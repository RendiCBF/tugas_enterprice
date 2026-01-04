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
        if (session()->get('role') !== 'Admin') {
            return view('auth/login');
        }
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
    
    // PERBAIKAN FINAL: Nama tabel disamakan menjadi 'roles'
    $user = $model->select('users.*, roles.role_name')
                  ->join('roles', 'roles.role_id = users.role_id') // Pastikan pakai 'roles'
                  ->where('email', $email)
                  ->first();
    
    if ($user) {
        if (password_verify($password, $user['password'])) {
            
            $sessionData = [
                'user_id'    => $user['user_id'], // Pastikan kolom di tabel users adalah 'user_id'
                'username'   => $user['username'],
                'role'       => $user['role_name'], // Mengambil nama: Admin/Staff
                'isLoggedIn' => true,
            ];

            $session->set($sessionData);
            return redirect()->to('/dashboard')->with('success', 'berhasil login!');
            
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
            // 1. Menghapus semua data session yang tersimpan di server
            session()->destroy(); 

            // 2. Mengarahkan ke halaman login dengan pesan sukses
            return redirect()->to(base_url('/'))->with('message', 'Anda telah berhasil keluar.');
        }
    
   
}