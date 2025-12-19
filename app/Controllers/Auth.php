<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    /**
     * Menampilkan Halaman Login
     * URL: localhost/rendi/public/ atau localhost/rendi/public/auth
     */
    public function index()
{
    return view('auth/login'); // Sesuaikan dengan nama file view login Anda
}

    /**
     * Memproses Data Login
     */
   public function login()
{
    $session = session();
    $model = new UserModel();

    $rules = [
        'email'    => 'required|valid_email',
        'password' => 'required|min_length[5]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }

    $email = trim($this->request->getVar('email'));
    $password = trim($this->request->getVar('password'));
    
    $user = $model->where('email', $email)->first();

if ($user) {
    // MENGGUNAKAN HASH MODERN: password_verify
    // Fungsi ini membandingkan teks biasa ($password) dengan hash di database
    if (password_verify($password, $user['password'])) {
        
        $sessionData = [
            'user_id'    => $user['user_id'],
            'username'   => $user['username'],
            'isLoggedIn' => true,
        ];

        session()->set($sessionData);
        return redirect()->to('/dashboard'); 
        } else {
            return redirect()->back()->withInput()->with('msg', 'Password salah.');
        }
    } else {
        return redirect()->back()->withInput()->with('msg', 'Email tidak ditemukan.');
    }
}

    /**
     * Menampilkan Halaman Dashboard
     */
    public function dashboard()
    {
        // Proteksi: Jika belum login, tendang balik ke halaman login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/auth')->with('msg', 'Silakan login terlebih dahulu.');
        }

        return view('pages/dashboard'); 
    }

    /**
     * Proses Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
    
}