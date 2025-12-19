<?php 

namespace App\Controllers;

use CodeIgniter\Controller;

class TestDB extends Controller
{
    public function index()
    {
        // Mencoba memuat instance koneksi database
        try {
            // Menggunakan fungsi bawaan CodeIgniter untuk koneksi database
            $db = \Config\Database::connect();
            
            // Mencoba melakukan query sederhana untuk memastikan koneksi aktif
            // Jika koneksi gagal, baris ini akan melempar Exception
            $db->query('SELECT NOW()'); 
            
            // Jika berhasil sampai di sini
            echo "<h1>✅ Koneksi Database Berhasil!</h1>";
            echo "<p>Driver: " . $db->getPlatform() . "</p>";
            echo "<p>Database Aktif: " . $db->getDatabase() . "</p>";
            
        } catch (\Exception $e) {
            
            // Menangkap kesalahan koneksi dan menampilkan pesan
            die("<h1>❌ Koneksi Database Gagal!</h1><p>Pastikan XAMPP/MySQL berjalan.</p><p>Detail Error: " . $e->getMessage() . "</p>");
            
        }
    }
}