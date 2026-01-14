<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
  public function index()
{
    $db = \Config\Database::connect();

    // 1. Mengambil total pendapatan bulan ini
    // Menggunakan 'order_date' karena 'created_at' tidak ada di tabel orders
    $monthly = $db->table('orders')
        ->selectSum('total_amount')
        ->where('MONTH(order_date)', date('m'))
        ->where('YEAR(order_date)', date('Y'))
        ->get()->getRow();

    // 2. Menghitung total pelanggan dari tabel 'customers' (Sesuai Gambar PMA Anda)
    $totalPelanggan = $db->table('customers')->countAllResults();

    // 3. Menghitung jumlah order yang pending
    $pending = $db->table('orders')
        ->where('order_status', 'Pending')
        ->countAllResults();

    // 4. Perhitungan persentase tugas
    $target = 100000000;
    $currentEarnings = $monthly->total_amount ?? 0;
    $taskPercent = ($currentEarnings > 0) ? ($currentEarnings / $target) * 100 : 0;

    // Kirim data ke view dengan nama variabel yang konsisten
    $data = [
        'pendapatan_bulan_ini' => $currentEarnings,
        'total_pelanggan'      => $totalPelanggan,
        'pending_requests'     => $pending,
        'task_completion'      => $taskPercent
    ];

    return view('pages/dashboard', $data);
}
}