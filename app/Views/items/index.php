<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Barang | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; }
        .card { border: none; border-radius: 12px; }
        .table thead { background-color: #f1f4f9; }
        .btn-add { border-radius: 8px; font-weight: 600; }
        .search-box { border-radius: 8px 0 0 8px; border-right: none; }
        .search-btn { border-radius: 0 8px 8px 0; }
        .badge-stock { padding: 6px 12px; border-radius: 6px; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">
            <i class="fas fa-warehouse me-2 text-primary"></i> Inventaris App
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-secondary btn-sm text-white px-3 me-2" href="<?= base_url('/') ?>">
                        <i class="fas fa-home me-1"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('items') ?>">Master Barang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('users') ?>">Master User</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Daftar Stok Barang</h2>
            <p class="text-muted">Kelola inventaris gudang Anda secara real-time</p>
        </div>
        <a href="<?= base_url('items/create') ?>" class="btn btn-primary btn-add px-4 shadow-sm">
            <i class="fas fa-plus me-2"></i> Tambah Barang
        </a>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            
            <div class="row mb-4">
                <div class="col-md-5">
                    <form action="" method="get">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                            <input type="text" name="keyword" class="form-control search-box border-start-0" 
                                   placeholder="Cari nama barang..." value="<?= $keyword ?>">
                            <button class="btn btn-primary search-btn px-4" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr class="text-muted small text-uppercase">
                            <th class="py-3 px-4">Nama Barang</th>
                            <th class="py-3">Harga Satuan</th>
                            <th class="py-3 text-center">Stok</th>
                            <th class="py-3 text-center">Terakhir Update</th>
                            <th class="py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)) : ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Data tidak ditemukan.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($items as $row) : ?>
                            <tr>
                                <td class="px-4">
                                    <div class="fw-semibold text-dark"><?= $row['item_name'] ?></div>
                                    <div class="text-muted small">ID: #<?= str_pad($row['item_id'], 4, '0', STR_PAD_LEFT) ?></div>
                                </td>
                                <td class="fw-bold text-primary">
                                    Rp <?= number_format($row['price'], 0, ',', '.') ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['stock_quantity'] <= 5) : ?>
                                        <span class="badge bg-danger-subtle text-danger badge-stock">Kritis: <?= $row['stock_quantity'] ?></span>
                                    <?php elseif ($row['stock_quantity'] <= 15) : ?>
                                        <span class="badge bg-warning-subtle text-warning-emphasis badge-stock">Menipis: <?= $row['stock_quantity'] ?></span>
                                    <?php else : ?>
                                        <span class="badge bg-success-subtle text-success badge-stock">Tersedia: <?= $row['stock_quantity'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center text-muted small">
                                    <?= date('d/m/Y H:i', strtotime($row['created_at'])) ?>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group shadow-sm">
                                        <a href="<?= base_url('items/edit/'.$row['item_id']) ?>" class="btn btn-white btn-sm border" title="Edit">
                                            <i class="fas fa-edit text-warning"></i>
                                        </a>
                                        <a href="<?= base_url('items/delete/'.$row['item_id']) ?>" 
                                           class="btn btn-white btn-sm border text-danger" 
                                           onclick="return confirm('Hapus data ini?')" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <p class="text-muted small mb-0">Menampilkan data barang aktif</p>
                <nav>
                    <?= $pager->links('items', 'default_full') ?>
                </nav>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>