<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table      = 'customers'; 
    protected $primaryKey = 'id_customer'; // Sesuai gambar: id_customer
    protected $allowedFields = ['name_customer', 'no_hp', 'alamat']; // Sesuai gambar
}