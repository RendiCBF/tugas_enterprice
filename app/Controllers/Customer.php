<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customer extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        
        // Memuat helper secara standar di constructor
        helper(['form', 'url', 'log_helper']); 
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        if ($keyword) {
            $this->customerModel->like('name_customer', $keyword);
        }

        $data = [
            'title'     => 'Daftar Customer',
            'customers' => $this->customerModel->paginate(5, 'customer'),
            'pager'     => $this->customerModel->pager,
            'keyword'   => $keyword
        ];

        return view('customer/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Customer',
            'validation' => \Config\Services::validation()
        ];
        return view('customer/create', $data);
    }

    public function save()
    {
        // Validasi input
        if (!$this->validate([
            'name_customer' => ['rules' => 'required', 'errors' => ['required' => 'Nama harus diisi!']],
            'no_hp'         => ['rules' => 'required|numeric', 'errors' => ['required' => 'No HP wajib diisi!', 'numeric' => 'Gunakan angka!']],
            'alamat'        => ['rules' => 'required', 'errors' => ['required' => 'Alamat tidak boleh kosong!']]
        ])) {
            return redirect()->to('/customer/create')->withInput();
        }

        $name = $this->request->getVar('name_customer');

        $this->customerModel->save([
            'name_customer' => $name,
            'no_hp'         => $this->request->getVar('no_hp'),
            'alamat'        => $this->request->getVar('alamat'),
        ]);

        // LOG: Mencatat penambahan customer baru
        // Kita gunakan \ untuk memastikan memanggil fungsi global
        \helper_log("INSERT", "Menambahkan customer baru bernama: $name");

        session()->setFlashdata('success', 'Customer berhasil ditambahkan.');
        return redirect()->to('/customer');
    }

    public function edit($id)
    {
        $data = [
            'title'      => 'Edit Customer',
            'customer'   => $this->customerModel->find($id),
            'validation' => \Config\Services::validation()
        ];
        return view('customer/edit', $data);
    }

    public function update($id)
    {
        $name = $this->request->getVar('name_customer');

        $this->customerModel->update($id, [
            'name_customer' => $name,
            'no_hp'         => $this->request->getVar('no_hp'),
            'alamat'        => $this->request->getVar('alamat'),
        ]);

        // LOG: Mencatat perubahan data
        \helper_log("UPDATE", "Mengubah data customer: $name (ID: $id)");

        session()->setFlashdata('success', 'Data berhasil diperbarui.');
        return redirect()->to('/customer');
    }

    public function delete($id = null)
    {
        if ($id == null) return redirect()->to('/customer');

        $customer = $this->customerModel->find($id);

        if ($customer) {
            $name = $customer['name_customer'];

            // LOG: Catat sebelum data benar-benar dihapus agar variabel $name tersedia
            \helper_log("DELETE", "Menghapus customer: $name (ID: $id)");

            $this->customerModel->delete($id);
            session()->setFlashdata('success', 'Data ' . $name . ' berhasil dihapus.');
        } else {
            session()->setFlashdata('error', 'Data tidak ditemukan.');
        }

        return redirect()->to('/customer');
    }
}