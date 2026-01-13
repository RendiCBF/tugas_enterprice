<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Mengambil total pendapatan bulan ini (Berdasarkan kolom total_amount di tabel orders)
        $monthly = $db->table('orders')
            ->selectSum('total_amount')
            ->where('MONTH(order_date)', date('m'))
            ->where('YEAR(order_date)', date('Y'))
            ->get()->getRow();

        // Mengambil total pendapatan tahun ini
        $annual = $db->table('orders')
            ->selectSum('total_amount')
            ->where('YEAR(order_date)', date('Y'))
            ->get()->getRow();

        // Menghitung jumlah order yang pending (Jika ada kolom order_status)
        $pending = $db->table('orders')
            ->where('order_status', 'Pending')
            ->countAllResults();

        // Menghitung persentase tugas (Misal target bulan ini 100jt)
        $target = 100000000;
        $currentEarnings = $monthly->total_amount ?? 0;
        $taskPercent = ($currentEarnings > 0) ? ($currentEarnings / $target) * 100 : 0;

        // Kirim semua variabel ke view melalui array $data
        $data = [
            'monthly_earnings' => $currentEarnings,
            'annual_earnings'  => $annual->total_amount ?? 0,
            'pending_requests' => $pending,
            'task_completion'  => $taskPercent
        ];

        return view('pages/dashboard', $data);
    }
}