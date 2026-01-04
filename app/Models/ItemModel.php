<?php

namespace App\Models;

use CodeIgniter\Model;

class ItemModel extends Model
{
    protected $table      = 'items';
    protected $primaryKey = 'item_id';

    // WAJIB: Masukkan stock_quantity agar bisa diupdate oleh Controller Order
    protected $allowedFields = ['item_name', 'price', 'stock_quantity']; 
}