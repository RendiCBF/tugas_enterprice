<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
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
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
        .table thead th { 
            background-color: #f8fafc; 
            text-transform: uppercase; 
            font-size: 0.75rem; 
            letter-spacing: 0.05em;
            color: #64748b;
            border-top: none;
            padding: 15px;
        }
        .customer-avatar {
            width: 40px;
            height: 40px;
            background-color: #dcfce7;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #15803d;
            font-weight: bold;
        }
        .btn-add { 
            border-radius: 10px; 
            font-weight: 600; 
            padding: 10px 24px;
            transition: all 0.3s;
        }
        .search-box {
            border-radius: 10px 0 0 10px;
            border-right: none;
        }
        .search-btn {
            border-radius: 0 10px 10px 0;
        }
        .action-btn {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
        }
        .action-btn:hover { transform: translateY(-2px); }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">👥 Master Data Customer</h2>
            <p class="text-muted">Kelola informasi pelanggan setia Toko Rendi</p>
        </div>
        <a href="<?= base_url('customer/create'); ?>" class="btn btn-success btn-add shadow-sm">
            <i class="fas fa-plus me-2"></i> Tambah Customer
        </a>
    </div>

    <div class="card">
        <div class="card-body p-4">
            
            <div class="row mb-4">
                <div class="col-md-5">
                    <form action="" method="get">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" class="form-control search-box border-start-0" 
                                   placeholder="Cari nama atau nomor HP..." name="keyword" value="<?= $keyword; ?>">
                            <button class="btn btn-success search-btn px-4" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="text-center" width="60">No</th>
                            <th>Info Pelanggan</th>
                            <th>No. HP</th>
                            <th>Alamat</th>
                            <th class="text-center">Bergabung</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($customers)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="fas fa-users-slash fa-3x mb-3 opacity-25"></i><br>
                                    Data customer belum tersedia.
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php 
                            $no = 1 + (5 * ($pager->getCurrentPage('customer') - 1)); 
                            foreach ($customers as $c) : 
                            ?>
                            <tr>
                                <td class="text-center text-muted"><?= $no++; ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="customer-avatar me-3">
                                            <?= strtoupper(substr($c['name_customer'], 0, 1)); ?>
                                        </div>
                                        <div class="fw-bold text-dark"><?= $c['name_customer']; ?></div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border fw-normal py-2 px-3">
                                        <i class="fab fa-whatsapp text-success me-1"></i> <?= $c['no_hp']; ?>
                                    </span>
                                </td>
                                <td class="text-muted small"><?= $c['alamat']; ?></td>
                                <td class="text-center small text-muted">
                                    <?= date('d M Y', strtotime($c['created_at'])); ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('customer/edit/' . $c['id_customer']); ?>" 
                                       class="btn btn-outline-warning btn-sm action-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-outline-danger btn-sm action-btn btn-delete" 
                                            data-url="<?= base_url('customer/delete/' . $c['id_customer']); ?>"
                                            data-name="<?= $c['name_customer']; ?>"
                                            title="Hapus">
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
                    Halaman ke-<?= $pager->getCurrentPage('customer'); ?> dari <?= $pager->getPageCount('customer'); ?>
                </div>
                <nav>
                    <?= $pager->links('customer', 'default_full'); ?>
                </nav>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="<?= base_url('dashboard') ?>" class="btn btn-link text-decoration-none text-muted p-0">
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
            const name = this.getAttribute('data-name');
            
            Swal.fire({
                title: 'Hapus Customer?',
                text: "Anda akan menghapus data " + name + ". Aksi ini tidak bisa dibatalkan!",
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