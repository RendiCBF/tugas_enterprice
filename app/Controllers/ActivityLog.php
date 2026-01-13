<?php

namespace App\Controllers;

class ActivityLog extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Mengambil data log dari yang terbaru
        $data['logs'] = $db->table('activity_logs')
                           ->orderBy('created_at', 'DESC')
                           ->get()
                           ->getResultArray();

        // Baris ini akan menampilkan file view reports/activity_log.php
        return view('reports/activity_log', $data);
    }
}