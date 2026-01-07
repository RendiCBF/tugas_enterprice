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
        .user-avatar {
            width: 40px;
            height: 40px;
            background-color: #e2e8f0;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-weight: bold;
        }
        .btn-add { 
            border-radius: 10px; 
            font-weight: 600; 
            padding: 10px 24px;
            transition: all 0.3s;
        }
        .badge-role { 
            padding: 6px 12px; 
            border-radius: 8px; 
            font-weight: 600;
            font-size: 0.8rem;
        }
        .action-btn {
            width: 32px;
            height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">👥 Manajemen User</h2>
            <p class="text-muted">Kelola hak akses dan informasi pengguna aplikasi</p>
        </div>
        <a href="<?= base_url('users/create') ?>" class="btn btn-primary btn-add shadow-sm">
            <i class="fas fa-user-plus me-2"></i> Tambah User
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <div class="row mb-4">
                <div class="col-md-4">
                    <form action="" method="get">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text" name="keyword" class="form-control border-start-0" 
                                   placeholder="Cari username atau email..." value="<?= isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                            <button class="btn btn-primary px-4" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Info User</th>
                            <th>Role</th>
                            <th class="text-center">Dibuat Pada</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1 + (10 * (($pager->getCurrentPage('user') ?? 1) - 1)); // Diubah ke 10 sesuai Controller
                            foreach($users as $u) : 
                        ?>
                        <tr>
                            <td class="text-center text-muted"><?= $no++; ?></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="user-avatar me-3">
                                        <?= strtoupper(substr($u['username'], 0, 1)); ?>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark"><?= $u['username']; ?></div>
                                        <div class="text-muted small"><?= $u['email']; ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php 
                                    $roleClass = 'bg-secondary-subtle text-secondary';
                                    if(strtolower($u['role_name']) == 'admin') $roleClass = 'bg-danger-subtle text-danger';
                                    elseif(strtolower($u['role_name']) == 'manager') $roleClass = 'bg-primary-subtle text-primary';
                                    elseif(strtolower($u['role_name']) == 'staff') $roleClass = 'bg-success-subtle text-success';
                                ?>
                                <span class="badge badge-role <?= $roleClass; ?> border">
                                    <?= $u['role_name']; ?>
                                </span>
                            </td>
                            <td class="text-center small text-muted">
                                <?= date('d M Y', strtotime($u['created_at'])); ?>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('users/edit/' . $u['user_id']); ?>" class="btn btn-outline-warning btn-sm action-btn" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-outline-danger btn-sm action-btn btn-delete" 
                                        data-url="<?= base_url('users/delete/' . $u['user_id']); ?>" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($users)) : ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-user-slash fa-3x mb-3 opacity-25"></i><br>
                                    Data user tidak ditemukan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <?= $pager->links('user', 'default_full') ?>
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
    // SweetAlert untuk Konfirmasi Hapus
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            Swal.fire({
                title: 'Hapus User?',
                text: "Aksi ini tidak dapat dibatalkan!",
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

    // Notifikasi Flashdata (Pesan Sukses)
    <?php if (session()->getFlashdata('pesan')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('pesan') ?>',
            timer: 3000,
            showConfirmButton: false
        });
    <?php endif; ?>
</script>
</body>
</html>