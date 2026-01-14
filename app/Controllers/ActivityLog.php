<?php

namespace App\Controllers;

class ActivityLog extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('activity_logs');

        // Pastikan kita mengambil username dari tabel users
        // Gunakan alias 'pelaku' agar sesuai dengan yang dipanggil di View
        $builder->select('activity_logs.*, users.username as pelaku'); 
        
        // Join menggunakan LEFT JOIN agar log tetap muncul meskipun user sudah dihapus
        $builder->join('users', 'users.user_id = activity_logs.user_id', 'left'); 

        $filterAksi = $this->request->getGet('filter_aksi');
        if (!empty($filterAksi)) {
            $builder->where('activity_logs.action', $filterAksi);
        }
        
        // Urutkan berdasarkan waktu terbaru
        $query = $builder->orderBy('activity_logs.created_at', 'DESC')->get();
        
        $data = [
            'title'           => "Log Aktivitas Sistem",
            'logs'            => $query->getResultArray(),
            'filter_sekarang' => $filterAksi
        ];

        return view('reports/activity_log', $data);
    }
}