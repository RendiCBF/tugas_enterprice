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
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Tambah Data Customer</h4>
            </div>
            <div class="card-body">
                <form action="<?= base_url('customer/save'); ?>" method="post">
                    <?= csrf_field(); ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Customer</label>
                        <input type="text" class="form-control" name="name_customer" value="<?= old('name_customer'); ?>">
                        <div class="text-danger mt-1 small"><?= validation_show_error('name_customer'); ?></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">No HP</label>
                        <input type="text" class="form-control" name="no_hp" value="<?= old('no_hp'); ?>">
                        <div class="text-danger mt-1 small"><?= validation_show_error('no_hp'); ?></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat</label>
                        <textarea class="form-control" name="alamat"><?= old('alamat'); ?></textarea>
                        <div class="text-danger mt-1 small"><?= validation_show_error('alamat'); ?></div>
                    </div>

                    <button type="submit" class="btn btn-success">Simpan Customer</button>
                    <a href="<?= base_url('customer'); ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>