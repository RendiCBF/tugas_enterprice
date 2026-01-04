<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-warning">
                <h4 class="mb-0">Edit Data Customer</h4>
            </div>
            <div class="card-body">
                <form action="<?= base_url('customer/update/' . $customer['id_customer']); ?>" method="post">
                    <?= csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Customer</label>
                        <input type="text" class="form-control" name="name_customer" value="<?= $customer['name_customer']; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" class="form-control" name="no_hp" value="<?= $customer['no_hp']; ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat"><?= $customer['alamat']; ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary">Update Data</button>
                    <a href="<?= base_url('customer'); ?>" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>