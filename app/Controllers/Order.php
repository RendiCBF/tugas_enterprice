<?php

namespace App\Controllers;

use App\Models\OrderModel;
use App\Models\OrderItemModel;
use App\Models\ItemModel;
use App\Models\CustomerModel;
use CodeIgniter\Controller;

class Order extends BaseController
{
    public function create()
    {
        $customerModel = new CustomerModel();
        $data['customers'] = $customerModel->findAll();

        $itemModel = new ItemModel();
        $data['products'] = $itemModel->findAll();

        return view('orders/form_order', $data);
    }

    public function store()
    {
        $db = \Config\Database::connect();
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();
        $itemModel = new ItemModel();

        // 1. Ambil data dari form
        $items = $this->request->getPost('items');
        $totalAmount = $this->request->getPost('total_grand');
        $customerId = $this->request->getPost('customer_id');

        // Validasi Awal
        if (empty($customerId) || empty($items)) {
            return redirect()->back()->with('error', 'Lengkapi data pelanggan dan pilih minimal satu produk!');
        }

        // Mulai Transaksi Database
        $db->transStart();

        try {
            // A. Simpan ke tabel 'orders'
            $orderData = [
                'user_id'      => session()->get('user_id') ?? 1,
                'id_customer'  => $customerId,
                'order_date'   => date('Y-m-d H:i:s'),
                'total_amount' => $totalAmount,
                'order_status' => 'Completed'
            ];

            if (!$orderModel->insert($orderData)) {
                throw new \Exception('Gagal membuat data order utama.');
            }

            $orderId = $orderModel->getInsertID();

            // B. Looping untuk detail item dan update stok
            foreach ($items as $item) {
                if (empty($item['product_id']) || empty($item['qty'])) continue;

                // 1. Simpan detail item
                $detailData = [
                    'order_id' => $orderId,
                    'item_id'  => $item['product_id'],
                    'quantity' => (int)$item['qty'],
                    'subtotal' => $item['subtotal']
                ];

                if (!$orderItemModel->insert($detailData)) {
                    throw new \Exception('Gagal menyimpan detail item: ' . $item['product_id']);
                }

                // 2. POTONG STOK (Gunakan Query Builder agar lebih aman)
                // Pastikan nama kolom di database adalah 'stock_quantity'
                $db->table('items')
                   ->where('item_id', $item['product_id'])
                   ->set('stock_quantity', "stock_quantity - " . (int)$item['qty'], false)
                   ->update();
                   
                if ($db->affectedRows() == 0) {
                    throw new \Exception('Gagal memperbarui stok untuk produk ID: ' . $item['product_id']);
                }
            }

            $db->transComplete(); // Selesaikan transaksi

            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', 'Transaksi gagal disimpan karena kesalahan database.');
            }

            return redirect()->to('/order')->with('success', 'Transaksi berhasil disimpan!');

        } catch (\Exception $e) {
            $db->transRollback(); // Batalkan semua jika ada satu saja yang gagal
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $orderModel = new OrderModel();
        // Menggunakan join agar bisa menampilkan nama customer
        $data['orders'] = $orderModel->select('orders.*, customers.name_customer')
            ->join('customers', 'customers.id_customer = orders.id_customer')
            ->orderBy('orders.order_date', 'DESC')
            ->findAll();

        return view('orders/index', $data);
    }

    public function detail($id)
    {
        $orderModel = new OrderModel();
        $orderItemModel = new OrderItemModel();

        $data['order'] = $orderModel->select('orders.*, customers.name_customer')
            ->join('customers', 'customers.id_customer = orders.id_customer')
            ->find($id);

        if (!$data['order']) {
            return redirect()->to('/order')->with('error', 'Data transaksi tidak ditemukan!');
        }

        $data['items'] = $orderItemModel->select('order_items.*, items.item_name, items.price as unit_price')
            ->join('items', 'items.item_id = order_items.item_id')
            ->where('order_id', $id)
            ->findAll();

        return view('orders/detail', $data);
    }
}