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
        
        // 1. Ambil data dari form
        $items = $this->request->getPost('items');
        $totalAmount = $this->request->getPost('total_grand');
        $customerId = $this->request->getPost('customer_id');

        // Validasi Awal: Pastikan data tidak kosong
        if (empty($customerId) || empty($items)) {
            return redirect()->back()->withInput()->with('error', 'Lengkapi data pelanggan dan pilih minimal satu produk!');
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
                throw new \Exception('Gagal membuat data transaksi utama.');
            }

            $orderId = $orderModel->getInsertID();

            // B. Looping untuk detail item dan update stok
            foreach ($items as $item) {
                if (empty($item['product_id']) || empty($item['qty'])) continue;

                // 1. AMBIL DATA STOK TERBARU (Sesuai gambar DB Anda: item_id)
                $currentProduct = $db->table('items')
                    ->where('item_id', $item['product_id'])
                    ->get()
                    ->getRowArray();

                // 2. VALIDASI STOK (PENTING: Mencegah stok minus)
                if (!$currentProduct || (int)$currentProduct['stock_quantity'] < (int)$item['qty']) {
                    // PERBAIKAN: Gunakan 'item_name' sesuai gambar kolom database Anda
                    $namaProduk = $currentProduct['item_name'] ?? "Produk ID: " . $item['product_id'];
                    $sisaStok = $currentProduct['stock_quantity'] ?? 0;
                    
                    throw new \Exception("Stok tidak cukup! '$namaProduk' hanya tersisa $sisaStok.");
                }

                // 3. JIKA LOLOS VALIDASI, SIMPAN DETAIL ORDER
                $detailData = [
                    'order_id' => $orderId,
                    'item_id'  => $item['product_id'],
                    'quantity' => (int)$item['qty'],
                    'subtotal' => $item['subtotal']
                ];
                $orderItemModel->insert($detailData);

                // 4. POTONG STOK (Gunakan kolom stock_quantity sesuai gambar)
                $db->table('items')
                    ->where('item_id', $item['product_id'])
                    ->set('stock_quantity', "stock_quantity - " . (int)$item['qty'], false)
                    ->update();
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Terjadi kesalahan saat menyimpan ke database.');
            }

            return redirect()->to('/order/detail/' . $orderId)->with('success', 'Transaksi Berhasil Disimpan!');

        }catch (\Exception $e) {
            $db->transRollback();
            
            // PENTING: withInput() agar data di form TIDAK TERESET
            // with('error', ...) agar pesan muncul di SweetAlert
            return redirect()->back()
                            ->withInput()
                            ->with('error', $e->getMessage());
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