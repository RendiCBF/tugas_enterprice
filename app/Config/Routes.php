<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
// app/Config/Routes.php

// Rute untuk menampilkan dashboard
$routes->get('/', 'Auth::index'); // Pastikan baris ini ada agar halaman awal adalah LOGIN
$routes->get('/auth', 'Auth::index');
$routes->post('/auth/login', 'Auth::login');
$routes->get('/dashboard', 'Auth::dashboard'); // Arahkan ke method dashboard di Auth Controller
$routes->get('/logout', 'Auth::logout');
$routes->get('auth/logout', 'Auth::logout');


// Rute untuk halaman 403
$routes->get('/dashboard', 'Auth::dashboard');
$routes->get('/admin-area', 'Admin::index', ['filter' => 'role[Admin]']); // Hanya Admin
$routes->get('/manager-area', 'Manager::index', ['filter' => 'role[Admin,Manager]']); // Admin & Manager
$routes->get('/error403', function() { return view('errors/html/error_403'); });

// Route Dashboard Utama
$routes->get('/dashboard', 'Auth::dashboard');

// Route khusus Admin (Poin 4: Proteksi Route)
$routes->get('users', 'Admin::index', ['filter' => 'role:Admin']);

// Route untuk Admin & Manager
$routes->get('/charts', 'Manager::index', ['filter' => 'role[Admin,Manager]']);

// Route untuk Operasional (Semua Role)
$routes->get('/items', 'Items::index');

// Route Halaman Error 403 (Poin 3)
$routes->get('/error403', function() {
    return view('errors/html/error_403');
});

// Route ini hanya bisa dibuka oleh role 'Manager' dan 'Admin'
$routes->get('laporan', 'Manager::index', ['filter' => 'role:Manager,Admin']);

