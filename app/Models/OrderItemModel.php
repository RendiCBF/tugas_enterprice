<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table      = 'order_items';
    protected $primaryKey = 'order_item_id'; // SUDAH DISESUAIKAN DENGAN FOTO
    
    protected $allowedFields = ['order_id', 'item_id', 'quantity', 'subtotal'];
}