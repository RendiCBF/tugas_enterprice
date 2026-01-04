<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
    <div class="container">
        <h2>Master Data Customer</h2>
        <hr>

        <?php if (session()->getFlashdata('success')) : ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success'); ?></div>
        <?php endif; ?>

        <div class="row mb-3">
            <div class="col-md-6">
                <form action="" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari nama atau HP..." name="keyword" value="<?= $keyword; ?>">
                        <button class="btn btn-primary" type="submit">Cari</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <a href="<?= base_url('customer/create'); ?>" class="btn btn-success">Tambah Customer</a>
            </div>
        </div>

        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Created At</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($customers)) : ?>
                    <tr><td colspan="6" class="text-center">Data tidak ditemukan.</td></tr>
                <?php else : ?>
                    <?php 
                    // Logika penomoran agar tetap urut saat pindah halaman
                    $no = 1 + (5 * ($pager->getCurrentPage('customer') - 1)); 
                    foreach ($customers as $c) : 
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $c['name_customer']; ?></td>
                        <td><?= $c['no_hp']; ?></td>
                        <td><?= $c['alamat']; ?></td>
                        <td><?= $c['created_at']; ?></td> <td>
                            <a href="<?= base_url('customer/edit/' . $c['id_customer']); ?>" class="btn btn-sm btn-warning">Edit</a>
    
                            <a href="<?= base_url('customer/delete/' . $c['id_customer']); ?>" 
                            class="btn btn-sm btn-danger" 
                            onclick="return confirm('Apakah Anda yakin ingin menghapus data <?= $c['name_customer']; ?>?')">
                            Hapus
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="mt-3">
            <?= $pager->links('customer', 'default_full'); ?>
        </div>
    </div>
</body>
</html>