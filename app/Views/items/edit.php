<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang | Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .card { border: none; border-radius: 12px; }
        .form-label { font-weight: 600; color: #495057; }
        .form-control { border-radius: 8px; padding: 10px 15px; }
        .btn-update { border-radius: 8px; font-weight: 600; padding: 10px 20px; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('items') ?>" class="text-decoration-none">Daftar Barang</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit Barang</li>
                </ol>
            </nav>

            <div class="card shadow-sm">
                <div class="card-header bg-white py-3 border-bottom">
                    <h4 class="fw-bold text-dark mb-0">
                        <i class="fas fa-edit text-warning me-2"></i> Edit Informasi Barang
                    </h4>
                </div>
                <div class="card-body p-4">

                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('items/update/' . $item['item_id']) ?>" method="post">
                        <?= csrf_field(); ?>

                        <div class="mb-3">
                            <label for="item_name" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="item_name" name="item_name" 
                                   value="<?= old('item_name', $item['item_name']) ?>" 
                                   placeholder="Masukkan nama barang" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Harga Satuan (Rp)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">Rp</span>
                                <input type="number" class="form-control" id="price" name="price" 
                                       value="<?= old('price', $item['price']) ?>" 
                                       placeholder="0" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="stock_quantity" class="form-label">Jumlah Stok</label>
                            <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" 
                                   value="<?= old('stock_quantity', $item['stock_quantity']) ?>" 
                                   placeholder="0" required>
                            <div class="form-text">Update jumlah stok fisik yang tersedia di gudang.</div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning text-white btn-update">
                                <i class="fas fa-save me-2"></i> Perbarui Data Barang
                            </button>
                            <a href="<?= base_url('items') ?>" class="btn btn-light border py-2">
                                Batal
                            </a>
                        </div>
                    </form>

                </div>
            </div>

            <div class="text-center mt-3">
                <small class="text-muted">Mengedit Kode Barang internal: <strong>#<?= str_pad($item['item_id'], 4, '0', STR_PAD_LEFT) ?></strong></small>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>