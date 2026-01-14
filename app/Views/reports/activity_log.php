<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-1">📜 Log Aktivitas Sistem</h3>
            <p class="text-muted small">Rekam jejak seluruh aktivitas pengguna untuk audit sistem.</p>
        </div>
        <a href="<?= base_url('dashboard') ?>" class="btn btn-outline-primary shadow-sm rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Dashboard
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4 p-3">
        <form action="" method="GET" class="row g-2 align-items-center">
            <div class="col-md-3">
                <select name="filter_aksi" class="form-select form-select-sm rounded-pill">
                    <option value="">-- Semua Aksi --</option>
                    <option value="INSERT" <?= (isset($filter_sekarang) && $filter_sekarang == 'INSERT') ? 'selected' : '' ?>>INSERT (Tambah)</option>
                    <option value="UPDATE" <?= (isset($filter_sekarang) && $filter_sekarang == 'UPDATE') ? 'selected' : '' ?>>UPDATE (Ubah)</option>
                    <option value="DELETE" <?= (isset($filter_sekarang) && $filter_sekarang == 'DELETE') ? 'selected' : '' ?>>DELETE (Hapus)</option>
                    <option value="LOGIN" <?= (isset($filter_sekarang) && $filter_sekarang == 'LOGIN') ? 'selected' : '' ?>>LOGIN</option>
                    <option value="LOGOUT" <?= (isset($filter_sekarang) && $filter_sekarang == 'LOGOUT') ? 'selected' : '' ?>>LOGOUT</option>
                    <option value="EXPORT" <?= (isset($filter_sekarang) && $filter_sekarang == 'EXPORT') ? 'selected' : '' ?>>EXPORT</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
                <a href="<?= site_url('activitylog') ?>" class="btn btn-light btn-sm rounded-pill px-3">Reset</a>
            </div>
        </form>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small fw-bold text-uppercase">Waktu</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Who</th> 
                        <th class="py-3 text-muted small fw-bold text-uppercase">Aksi</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($logs)): ?>
                        <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada aktivitas tercatat.</td></tr>
                    <?php else: ?>
                        <?php foreach($logs as $l): ?>
                        <tr>
                            <td class="ps-4 small text-muted"><?= date('d/m/Y H:i:s', strtotime($l['created_at'])) ?></td>
                            
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs me-2 bg-light rounded-circle text-center" style="width: 25px; height: 25px; line-height: 25px;">
                                        <i class="fas fa-user-circle text-secondary"></i>
                                    </div>
                                    <span class="small fw-bold text-primary"><?= esc($l['pelaku'] ?? 'System') ?></span>
                                </div>
                            </td>

                            <td>
                                <?php 
                                    $bg = 'bg-primary';
                                    if($l['action'] == 'DELETE') $bg = 'bg-danger';
                                    if($l['action'] == 'INSERT') $bg = 'bg-success';
                                    if($l['action'] == 'UPDATE') $bg = 'bg-info';
                                    if($l['action'] == 'LOGIN') $bg = 'bg-dark';
                                    if($l['action'] == 'LOGOUT') $bg = 'bg-secondary'; 
                                    if($l['action'] == 'EXPORT') $bg = 'bg-warning text-dark';
                                ?>
                                <span class="badge rounded-pill <?= $bg ?> px-3" style="min-width: 70px;">
                                    <?= $l['action'] ?>
                                </span>
                            </td>
                            <td class="small text-dark"><?= esc($l['description']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>