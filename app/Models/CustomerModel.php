<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table      = 'customers'; // Pastikan ini sesuai nama tabel di phpMyAdmin
    protected $primaryKey = 'id_customer';

    // SESUAIKAN DENGAN GAMBAR DATABASE ANDA
    protected $allowedFields = ['name_customer', 'no_hp', 'alamat']; 

    // FITUR TIMESTAMP (SKOR 2)
    protected $useTimestamps = true; 
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}