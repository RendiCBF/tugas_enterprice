<?php

namespace App\Controllers;

// Nama class "Admin" harus sama dengan nama file "Admin.php"
class Admin extends BaseController
{
    public function index()
    {
        // Mencari file di app/Views/admin/user_list.php
        return view('admin/user_list');
    }
}