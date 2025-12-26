<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table      = 'items';
    protected $primaryKey = 'item_id'; // Sesuai gambar Anda

    protected $allowedFields = ['item_name', 'price', 'stock_quantity'];

    // Target Poin 4: Timestamp Otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}