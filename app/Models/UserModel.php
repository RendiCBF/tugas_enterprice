<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'user_id'; // Sesuai dengan gambar database Anda: 'user_id'

    // Izinkan kolom-kolom ini untuk diakses
    protected $allowedFields = ['role_id', 'username', 'email', 'password'];
}