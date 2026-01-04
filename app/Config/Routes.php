<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- 1. RUTE AUTH (Bisa diakses siapa saja/Public) ---
$routes->get('/', 'Auth::index');
$routes->get('/auth', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');

// ini untuk logout
$routes->get('logout', 'Auth::logout');

// rute digunakan untuk menampilkan halaman error 403
$routes->get('/error403', function() {
    return view('errors/html/error_403');
});

// --- 2. RUTE DASHBOARD (Semua yang sudah Login) ---
$routes->get('/dashboard', 'Auth::dashboard', ['filter' => 'auth']);

// --- 3. RUTE KHUSUS ADMIN (Hanya Admin) ---
// Menggunakan Group agar lebih aman dan rapi
$routes->group('users', ['filter' => 'role:Admin'], function($routes) {
    $routes->get('/', 'User::index');
    $routes->get('create', 'User::create');
    $routes->post('save', 'User::save');
    $routes->get('edit/(:num)', 'User::edit/$1');
    $routes->post('update/(:num)', 'User::update/$1');
    $routes->get('delete/(:num)', 'User::delete/$1');
});

// Rute Admin Area lainnya
$routes->get('/admin-area', 'Admin::index', ['filter' => 'role:Admin']);

// --- 4. RUTE MANAGER & ADMIN (Laporan/Charts) ---
$routes->get('/manager-area', 'Manager::index', ['filter' => 'role:Admin,Manager']);
$routes->get('/charts', 'Manager::index', ['filter' => 'role:Admin,Manager']);
$routes->get('/laporan', 'Manager::index', ['filter' => 'role:Admin,Manager']);

// --- 5. RUTE OPERASIONAL (Barang/Items) ---
// Biasanya Staff & Manager boleh lihat, tapi hanya Admin/Staff yang boleh edit
$routes->group('items', ['filter' => 'role:Admin,Manager,Staff'], function($routes) {
    $routes->get('/', 'Items::index');
    // Jika ingin batasi edit barang hanya untuk Admin, pindahkan baris bawah ke group Admin
    $routes->get('create', 'Items::create');
    $routes->post('save', 'Items::save');
    $routes->get('edit/(:num)', 'Items::edit/$1');
    $routes->post('update/(:num)', 'Items::update/$1');
    $routes->get('delete/(:num)', 'Items::delete/$1');
});

// akses untuk Order
// Tambahkan ini agar URL /order dikenali
// Hapus semua deklarasi order sebelumnya dan sisakan ini saja
$routes->group('order', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Order::index');              // List transaksi
    $routes->get('create', 'Order::create');         // Form input
    $routes->post('store', 'Order::store');          // Proses simpan
    $routes->get('detail/(:num)', 'Order::detail/$1'); // Detail nota
});