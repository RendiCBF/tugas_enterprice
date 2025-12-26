<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <h1>Daftar Manajemen User</h1>

    <?php if (session()->getFlashdata('pesan')) : ?>
        <div class="alert alert-success" role="alert">
            <?= session()->getFlashdata('pesan'); ?>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <form action="" method="get">
            <div class="input-group" style="max-width: 300px;">
                <input type="text" name="keyword" class="form-control" placeholder="Cari username atau email..." value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                <button class="btn btn-outline-secondary" type="submit">Cari</button>
            </div>
        </form>

        <a href="<?= base_url('users/create') ?>" class="btn btn-primary">Tambah User Baru</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>Dibuat Pada</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $no = 1 + (5 * (($pager->getCurrentPage('user') ?? 1) - 1)); 
                foreach($users as $u) : 
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $u['username']; ?></td>
                <td><?= $u['email']; ?></td>
                <td>
                    <span class="badge bg-info text-dark"><?= $u['role_name']; ?></span>
                </td>
                <td><?= $u['created_at']; ?></td>
                <td>
                    <a href="<?= base_url('users/edit/' . $u['user_id']); ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?= base_url('users/delete/' . $u['user_id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
            
            <?php if (empty($users)) : ?>
                <tr>
                    <td colspan="6" class="text-center">Data tidak ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        <?= $pager->links('user', 'default_full') ?>
    </div>

    <hr>
    <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">Kembali ke Dashboard</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>