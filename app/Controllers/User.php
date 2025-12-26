<?php

namespace App\Controllers;

use App\Models\UserModel; // Pastikan kamu sudah membuat file Models/UserModel.php
use CodeIgniter\Controller;

class User extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        // Inisialisasi model agar bisa digunakan di semua function
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Join agar role_name muncul di tabel
        $this->userModel->select('users.*, roles.role_name');
        $this->userModel->join('roles', 'roles.role_id = users.role_id');

        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $this->userModel->like('username', $keyword)->orLike('email', $keyword);
        }

        $data = [
            'title' => 'Manajemen User',
            'users' => $this->userModel->paginate(10, 'user'),
            'pager' => $this->userModel->pager,
        ];

        return view('user/index', $data);
    }
    public function create()
    {
        return view('user/create', ['title' => 'Tambah User Baru']);
    }

    public function save()
    {
        // 1. Perbaikan: Sesuaikan validasi dengan nama input di form (role_id)
        if (!$this->validate([
            'username' => 'required|is_unique[users.username]|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[5]',
            'role_id'  => 'required' 
        ])) {
            return redirect()->to('/users/create')->withInput();
        }

        // 2. Perbaikan: Simpan ke kolom 'role_id' bukan 'role'
        $this->userModel->save([
            'username'  => $this->request->getVar('username'),
            'email'     => $this->request->getVar('email'),
            'password'  => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'role_id'   => $this->request->getVar('role_id'),
        ]);

        session()->setFlashdata('pesan', 'Data user berhasil ditambahkan.');
        return redirect()->to('/users'); // Redirect ke 'users' pakai S
    }

    public function delete($id)
    {
        $this->userModel->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil dihapus.');
        return redirect()->to('/users'); // Redirect ke 'users' pakai S
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Data User',
            'user'  => $this->userModel->find($id)
        ];
        return view('user/edit', $data);
    }

    public function update($id)
    {
        // 3. Perbaikan: Update kolom 'role_id'
        $this->userModel->update($id, [
            'username' => $this->request->getVar('username'),
            'email'    => $this->request->getVar('email'),
            'role_id'  => $this->request->getVar('role_id'),
        ]);

        session()->setFlashdata('pesan', 'Data berhasil diubah.');
        return redirect()->to('/users'); // Redirect ke 'users' pakai S
    }

}