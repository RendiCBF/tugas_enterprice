<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        // Jika sudah login, langsung lempar ke dashboard
        if (session()->get('isLoggedIn')) {
            return redirect()->to('/dashboard');
        }
        return view('auth/login');
    }

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
        
        $user = $model->select('users.*, roles.role_name')
                      ->join('roles', 'roles.role_id = users.role_id')
                      ->where('email', $email)
                      ->first();
        
        if ($user) {
            if (password_verify($password, $user['password'])) {
                
                $sessionData = [
                    'user_id'    => $user['user_id'],
                    'username'   => $user['username'],
                    'role'       => $user['role_name'],
                    'isLoggedIn' => true,
                ];

                $session->set($sessionData);

                // --- BAGIAN PENYEBAB MASALAH: TAMBAHKAN LOG DI SINI ---
                helper('log_helper'); // Pastikan helper dimuat
                \helper_log("LOGIN", "User {$user['username']} berhasil masuk ke sistem");
                // -----------------------------------------------------

                return redirect()->to('/dashboard')->with('success', 'Selamat Datang, ' . $user['username']);
                
            } else {
                return redirect()->back()->withInput()->with('msg', 'Password salah.');
            }
        } else {
            return redirect()->back()->withInput()->with('msg', 'Email tidak ditemukan.');
        }
    }

        public function logout()
        {
            // 1. Ambil username dari session SEBELUM dihancurkan
            $username = session()->get('username');

            // 2. Jika ada session, catat aktivitas logout
            if ($username) {
                helper('log_helper');
                \helper_log("LOGOUT", "User $username telah keluar dari sistem");
            }

            // 3. Baru kemudian hancurkan semua data session
            session()->destroy(); 

            // 4. Arahkan kembali ke halaman login
            return redirect()->to(base_url('/'))->with('message', 'Anda telah berhasil keluar.');
        }
}