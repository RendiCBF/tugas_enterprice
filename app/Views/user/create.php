<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Tambah User Baru</h3>
                    </div>
                    <div class="card-body">
                        <?php if (session()->getFlashdata('error')) : ?>
                            <div class="alert alert-danger">
                                <?= session()->getFlashdata('error'); ?>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('users/save'); ?>" method="post">
                            <?= csrf_field(); ?>
                            <?php if (session()->getFlashdata('errors')) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <?= validation_list_errors() ?>
                                </div>
                                 <?php endif; ?>

                                 <form action="<?= base_url('users/save'); ?>" method="post">
...
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= old('username'); ?>" placeholder="Masukkan username" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= old('email'); ?>" placeholder="contoh@email.com" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 5 karakter" required>
                            </div>

                            <div class="mb-3">
                                <label for="role_id" class="form-label">Role / Hak Akses</label>
                                <select class="form-select" name="role_id" required>
                                    <option value="" selected disabled>-- Pilih Role --</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Manager</option>
                                    <option value="3">Staff</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="<?= base_url('users'); ?>" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>