<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customer extends BaseController
{
    protected $customerModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        // TAMBAHKAN INI agar fungsi validation_show_error() bisa terbaca di View
        helper(['form']); 
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

    // 1. TAMPILKAN FORM TAMBAH
    public function create()
    {
        $data = [
            'title' => 'Tambah Customer',
            'validation' => \Config\Services::validation()
        ];
        return view('customer/create', $data);
    }

    // 2. PROSES SIMPAN DATA (DENGAN VALIDASI)
    public function save()
    {
        if (!$this->validate([
            'name_customer' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Nama harus diisi!']
            ],
            'no_hp' => [
                'rules'  => 'required|numeric',
                'errors' => [
                    'required' => 'Nomor HP wajib diisi!',
                    'numeric'  => 'Gunakan angka untuk nomor HP!'
                ]
            ],
            'alamat' => [
                'rules'  => 'required',
                'errors' => ['required' => 'Alamat tidak boleh kosong!']
            ]
        ])) {
            // SINKRONISASI: Redirect kembali dengan membawa input dan errors
            return redirect()->to('/customer/create')->withInput();
        }

        $this->customerModel->save([
            'name_customer' => $this->request->getVar('name_customer'),
            'no_hp'         => $this->request->getVar('no_hp'),
            'alamat'        => $this->request->getVar('alamat'),
        ]);

        session()->setFlashdata('success', 'Customer berhasil ditambahkan.');
        return redirect()->to('/customer');
    }

    // 3. TAMPILKAN FORM EDIT
    public function edit($id)
    {
        $data = [
            'title'    => 'Edit Customer',
            'customer' => $this->customerModel->find($id),
            'validation' => \Config\Services::validation()
        ];
        return view('customer/edit', $data);
    }

    // 4. PROSES UPDATE DATA
    public function update($id)
    {
        $this->customerModel->update($id, [
            'name_customer' => $this->request->getVar('name_customer'),
            'no_hp'         => $this->request->getVar('no_hp'),
            'alamat'        => $this->request->getVar('alamat'),
        ]);

        session()->setFlashdata('success', 'Data berhasil diperbarui.');
        return redirect()->to('/customer');
    }

    // 5. PROSES HAPUS DATA
    public function delete($id)
    {
        $this->customerModel->delete($id);
        session()->setFlashdata('success', 'Data berhasil dihapus.');
        return redirect()->to('/customer');
    }
}