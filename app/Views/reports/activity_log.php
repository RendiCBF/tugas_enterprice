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

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small fw-bold text-uppercase">Waktu</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">User</th>
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
                            <td><span class="fw-bold"><?= $l['user_name'] ?></span></td>
                            <td>
                                <span class="badge rounded-pill <?= $l['action'] == 'EXPORT' ? 'bg-success' : 'bg-primary' ?>">
                                    <?= $l['action'] ?>
                                </span>
                            </td>
                            <td class="small text-dark"><?= $l['description'] ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>