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
// $routes->get('reset-password', function() {
//     $model = new \App\Models\UserModel();
//     // Ganti 'admin' dengan username Anda, dan '12345' dengan password keinginan Anda
//     $model->where('username', 'admin')->set(['password' => md5('admin123')])->update();
//     return "Password berhasil diubah menjadi MD5: 12345";
// });