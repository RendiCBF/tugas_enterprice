<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderModel extends Model
{
    protected $table            = 'orders';
    protected $primaryKey       = 'order_id';
    protected $useAutoIncrement = true;
    
    // Pastikan kolom id_customer dan total_amount ada di tabel orders Anda
    protected $allowedFields    = ['user_id', 'id_customer', 'order_date', 'total_amount', 'order_status'];
}