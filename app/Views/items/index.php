<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Barang | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f4f7fa; 
            color: #2d3436;
        }
        .card { 
            border: none; 
            border-radius: 16px; 
            transition: transform 0.2s;
        }
        .table thead th { 
            background-color: #f8fafc; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 0.05em;
            color: #64748b;
            border-top: none;
        }
        .btn-add { 
            border-radius: 10px; 
            font-weight: 600; 
            padding: 10px 24px;
            transition: all 0.3s;
        }
        .btn-add:hover { transform: translateY(-2px); box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3); }
        
        .search-box { border-radius: 10px 0 0 10px; border-right: none; padding: 12px; }
        .search-btn { border-radius: 0 10px 10px 0; padding: 0 20px; }
        
        .badge-stock { 
            padding: 8px 14px; 
            border-radius: 8px; 
            font-weight: 600;
        }
        .item-name { font-size: 1rem; color: #1e293b; }
        .action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            margin: 0 2px;
            transition: all 0.2s;
        }
        .action-btn:hover { transform: scale(1.1); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row align-items-center mb-5">
        <div class="col-md-8">
            <h2 class="fw-bold mb-1">📦 Inventaris Barang</h2>
            <p class="text-muted">Pantau dan kelola aset gudang Anda dalam satu panel kontrol.</p>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="<?= base_url('items/create') ?>" class="btn btn-primary btn-add shadow-sm">
                <i class="fas fa-plus me-2"></i> Tambah Barang Baru
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <form action="" method="get">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="keyword" class="form-control search-box border-start-0" 
                                   placeholder="Cari berdasarkan nama barang..." value="<?= $keyword ?? '' ?>">
                            <button class="btn btn-primary search-btn" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="ps-4">Detail Produk</th>
                            <th>Harga Satuan</th>
                            <th class="text-center">Status Stok</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($items)) : ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="mb-3 opacity-50"><br>
                                    Data barang tidak ditemukan.
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($items as $row) : ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold item-name"><?= $row['item_name'] ?></div>
                                    <small class="text-muted">SKU: #<?= str_pad($row['item_id'], 5, '0', STR_PAD_LEFT) ?></small>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">Rp <?= number_format($row['price'], 0, ',', '.') ?></span>
                                </td>
                                <td class="text-center">
                                    <?php if ($row['stock_quantity'] <= 5) : ?>
                                        <span class="badge bg-danger-subtle text-danger badge-stock border border-danger-subtle">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Kritis: <?= $row['stock_quantity'] ?>
                                        </span>
                                    <?php elseif ($row['stock_quantity'] <= 15) : ?>
                                        <span class="badge bg-warning-subtle text-warning-emphasis badge-stock border border-warning-subtle">
                                            <i class="fas fa-info-circle me-1"></i> Menipis: <?= $row['stock_quantity'] ?>
                                        </span>
                                    <?php else : ?>
                                        <span class="badge bg-success-subtle text-success badge-stock border border-success-subtle">
                                            <i class="fas fa-check me-1"></i> Aman: <?= $row['stock_quantity'] ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('items/edit/'.$row['item_id']) ?>" class="btn btn-outline-warning btn-sm action-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-outline-danger btn-sm action-btn btn-delete" 
                                            data-url="<?= base_url('items/delete/'.$row['item_id']) ?>" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted small">
                    Total: <strong><?= count($items) ?></strong> produk tersedia
                </div>
                <nav>
                    <?= $pager->links('items', 'default_full') ?>
                </nav>
            </div>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="<?= base_url('dashboard') ?>" class="btn btn-link text-decoration-none text-muted">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Konfirmasi Hapus SweetAlert
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data barang akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });

    // Notifikasi Sukses
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('success') ?>',
            timer: 2500,
            showConfirmButton: false
        });
    <?php endif; ?>
</script>
</body>
</html>