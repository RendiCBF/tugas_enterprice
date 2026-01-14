<?php

namespace App\Controllers;

use App\Models\ItemModel;

class Items extends BaseController
{
    protected $itemModel;
    public function __construct() {
        $this->itemModel = new ItemModel();
        // Me-load helper secara global di constructor agar selalu siap digunakan
        helper(['log_helper', 'url']);
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        
        if ($keyword) {
            $this->itemModel->like('item_name', $keyword);
        }

        $data = [
            'items' => $this->itemModel->paginate(5, 'items'),
            'pager' => $this->itemModel->pager,
            'keyword' => $keyword
        ];
        return view('items/index', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'item_name'      => 'required|is_unique[items.item_name]',
            'price'          => 'required|numeric',
            'stock_quantity' => 'required|integer'
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $itemName = $this->request->getPost('item_name');

        $this->itemModel->save([
            'item_name'      => $itemName,
            'price'          => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
        ]);

        // LOG: Mencatat penambahan barang baru
        \helper_log("INSERT", "Menambahkan barang baru: $itemName");

        return redirect()->to('/items')->with('success', 'Data Berhasil Ditambahkan');
    }

    public function create()
    {
        return view('items/create'); 
    }

    public function edit($id = null)
    {
        $data['item'] = $this->itemModel->find($id);

        if (empty($data['item'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Barang dengan ID ' . $id . ' tidak ditemukan');
        }

        return view('items/edit', $data);
    }

    public function update($id)
    {
        if (!$this->validate([
            'item_name' => "required|is_unique[items.item_name,item_id,$id]",
            'price'     => 'required|numeric',
            'stock_quantity' => 'required|integer'
        ])) {
            return redirect()->back()->withInput();
        }

        $itemName = $this->request->getPost('item_name');

        $this->itemModel->update($id, [
            'item_name'      => $itemName,
            'price'          => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
        ]);

        // LOG: Mencatat perubahan data barang
        \helper_log("UPDATE", "Mengubah data barang: $itemName (ID: $id)");

        return redirect()->to('/items')->with('success', 'Data berhasil diubah');
    }

    public function delete($id = null)
    {
        if ($id === null) {
            return redirect()->to('/items');
        }

        // Ambil data barang sebelum dihapus untuk kebutuhan penulisan log
        $item = $this->itemModel->find($id);

        if ($item) {
            $this->itemModel->where('item_id', $id)->delete();

            // LOG: Mencatat penghapusan barang secara detail (Skema Nilai 6)
            \helper_log("DELETE", "Menghapus barang: " . $item['item_name'] . " (ID: $id)");
            
            return redirect()->to('/items')->with('success', 'Data berhasil dihapus');
        }

        return redirect()->to('/items');
    }
}