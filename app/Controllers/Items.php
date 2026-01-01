<?php

namespace App\Controllers;

use App\Models\ItemModel;

class Items extends BaseController
{
    protected $itemModel;
    public function __construct() {
        $this->itemModel = new ItemModel();
    }

    public function index()
    {
        $keyword = $this->request->getVar('keyword');
        
        // Target Poin 3: Pencarian & Paginasi
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
        // Target Poin 2: Validasi Server-side
        if (!$this->validate([
            'item_name'      => 'required|is_unique[items.item_name]',
            'price'          => 'required|numeric',
            'stock_quantity' => 'required|integer'
        ])) {
            // Demo 1: Menampilkan pesan error jika input gagal
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->itemModel->save([
            'item_name'      => $this->request->getPost('item_name'),
            'price'          => $this->request->getPost('price'),
            'stock_quantity' => $this->request->getPost('stock_quantity'),
        ]);

        return redirect()->to('/items')->with('success', 'Data Berhasil Ditambahkan');
    }
    public function create()
    {
        // Pastikan Anda sudah membuat file 'create.php' di folder 'app/Views/items/'
        return view('items/create'); 
    }
    public function edit($id = null)
{
    // 1. Ambil data dari database berdasarkan ID
    $data['item'] = $this->itemModel->find($id);

    // 2. Jika data tidak ditemukan, tampilkan error 404
    if (empty($data['item'])) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException('Barang dengan ID ' . $id . ' tidak ditemukan');
    }

    // 3. Kirim data ke View edit
    return view('items/edit', $data);
    }
    public function update($id)
{
    // Validasi data (Poin 2 Target Anda)
    if (!$this->validate([
        'item_name' => "required|is_unique[items.item_name,item_id,$id]",
        'price'     => 'required|numeric',
        'stock_quantity' => 'required|integer'
    ])) {
        return redirect()->back()->withInput();
    }

    // Update ke database
    $this->itemModel->update($id, [
        'item_name'      => $this->request->getPost('item_name'),
        'price'          => $this->request->getPost('price'),
        'stock_quantity' => $this->request->getPost('stock_quantity'),
    ]);

    return redirect()->to('/items')->with('success', 'Data berhasil diubah');
}

   public function delete($id = null)
{
    // Cek apakah ID ada di URL
    if ($id === null) {
        return redirect()->to('/items');
    }

    // Menambahkan klausa WHERE secara eksplisit agar aman
    $this->itemModel->where('item_id', $id)->delete();

    // Kembali ke daftar stok dengan pesan sukses
    return redirect()->to('/items')->with('success', 'Data berhasil dihapus');
}
   
}