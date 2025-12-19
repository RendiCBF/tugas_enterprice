<?php

namespace App\Controllers;

// Nama class "Manager" HARUS sama persis dengan nama file "Manager.php"
class Manager extends BaseController
{
    public function index()
    {
        return "<h1>Dashboard Manager</h1><p>Halaman ini khusus Manager dan Admin.</p>";
    }
}