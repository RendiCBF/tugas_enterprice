<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Report extends BaseController
{
    public function sales()
    {
        $orderModel = new OrderModel();
        
        // Mengambil filter tanggal, default ke bulan berjalan
        $start_date = $this->request->getGet('start_date') ?? date('Y-m-01');
        $end_date   = $this->request->getGet('end_date') ?? date('Y-m-d');

        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;

        // Query data transaksi penjualan
        $data['sales'] = $orderModel->select('orders.*, customers.name_customer')
            ->join('customers', 'customers.id_customer = orders.id_customer')
            ->where('order_date >=', $start_date . ' 00:00:00')
            ->where('order_date <=', $end_date . ' 23:59:59')
            ->findAll();

        // Menghitung total pendapatan
        $data['total_income'] = array_sum(array_column($data['sales'], 'total_amount'));

        // Query 5 produk terlaris berdasarkan data asli
        $db = \Config\Database::connect();
        $data['best_sellers'] = $db->table('order_items')
            ->select('items.item_name, SUM(order_items.quantity) as total_qty')
            ->join('items', 'items.item_id = order_items.item_id') 
            ->join('orders', 'orders.order_id = order_items.order_id')
            ->where('orders.order_date >=', $start_date . ' 00:00:00')
            ->where('orders.order_date <=', $end_date . ' 23:59:59')
            ->groupBy('order_items.item_id')
            ->orderBy('total_qty', 'DESC')
            ->limit(5)
            ->get()->getResultArray();

        // --- PERBAIKAN: Baris ini wajib ada agar halaman tampil ---
        return view('reports/sales_report', $data);
    }

    public function exportExcel()
    {
        $orderModel = new OrderModel();
        
        // 1. Ambil Filter Tanggal
        $start_date = $this->request->getGet('start_date') ?? date('Y-m-01');
        $end_date   = $this->request->getGet('end_date') ?? date('Y-m-d');

        // 2. Ambil Data Penjualan
        $sales = $orderModel->select('orders.*, customers.name_customer')
            ->join('customers', 'customers.id_customer = orders.id_customer')
            ->where('order_date >=', $start_date . ' 00:00:00')
            ->where('order_date <=', $end_date . ' 23:59:59')
            ->findAll();

        // 3. --- SIMPAN LOG DULU SEBELUM EXPORT ---
        // Kode ini harus di atas agar tereksekusi sebelum file didownload
        $db = \Config\Database::connect();
        $db->table('activity_logs')->insert([
            'user_id'     => session()->get('id_user') ?? 1, 
            'user_name'   => session()->get('username') ?? 'Admin Rendi',
            'action'      => 'EXPORT',
            'description' => 'Mengekspor Laporan Penjualan periode ' . $start_date . ' s/d ' . $end_date,
            'created_at'  => date('Y-m-d H:i:s')
        ]);

        // 4. Bersihkan Output Buffer
        if (ob_get_level()) ob_end_clean();

        // 5. Header untuk Excel
        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Penjualan_TokoRendi.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        // 6. Buat Tabel Excel
        echo '<table border="1">';
        echo '<tr><th colspan="4" style="font-size:16px; font-weight:bold;">LAPORAN PENJUALAN TOKO RENDI</th></tr>';
        echo '<tr><th colspan="4">Periode: ' . $start_date . ' s/d ' . $end_date . '</th></tr>';
        echo '<tr><th style="background:#eee;">No</th><th style="background:#eee;">Tanggal</th><th style="background:#eee;">Pelanggan</th><th style="background:#eee;">Total</th></tr>';
        
        foreach ($sales as $key => $s) {
            echo '<tr>';
            echo '<td>' . ($key + 1) . '</td>';
            echo '<td>' . date('d/m/Y', strtotime($s['order_date'])) . '</td>';
            echo '<td>' . $s['name_customer'] . '</td>';
            echo '<td>' . number_format($s['total_amount'], 0, '', '') . '</td>';
            echo '</tr>';
        }
        echo '</table>';

        // 7. Selesai
        exit;
    }
}