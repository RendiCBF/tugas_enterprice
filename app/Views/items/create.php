<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Form Tambah Barang</h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger">
                            <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('items/save') ?>" method="post">
                        <?= csrf_field(); ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" name="item_name" class="form-control" value="<?= old('item_name') ?>" placeholder="Contoh: Kopi Bubuk" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga (Rp)</label>
                            <input type="number" name="price" class="form-control" value="<?= old('price') ?>" placeholder="0" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok Awal</label>
                            <input type="number" name="stock_quantity" class="form-control" value="<?= old('stock_quantity') ?>" placeholder="0" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success">Simpan Data</button>
                            <a href="<?= base_url('items') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>