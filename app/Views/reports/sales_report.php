<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4 pb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-sm btn-light text-muted mb-2 rounded-pill px-3 no-print">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
            <h3 class="fw-bold text-dark mb-1">📊 Laporan Strategis</h3>
            <p class="text-muted small mb-0">Pantau performa penjualan dan produk terlaris Anda.</p>
        </div>
        <div class="no-print d-flex gap-2">
            <a href="<?= base_url('report/exportExcel?start_date=' . $start_date . '&end_date=' . $end_date) ?>" class="btn btn-soft-success shadow-sm px-3">
                <i class="fas fa-file-excel me-2"></i> Ekspor Excel
            </a>
            <button onclick="window.print()" class="btn btn-soft-danger shadow-sm px-3">
                <i class="fas fa-print me-2"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <div class="card border-0 shadow-sm mb-4 bg-white rounded-4">
        <div class="card-body p-4">
            <form method="GET" action="<?= base_url('report/sales') ?>" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-uppercase text-muted tracking-wider">Rentang Tanggal Awal</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="far fa-calendar-alt text-muted"></i></span>
                        <input type="date" name="start_date" class="form-control border-0 bg-light rounded-end" value="<?= $start_date ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-uppercase text-muted tracking-wider">Rentang Tanggal Akhir</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="far fa-calendar-check text-muted"></i></span>
                        <input type="date" name="end_date" class="form-control border-0 bg-light rounded-end" value="<?= $end_date ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 rounded-3 shadow-sm hover-up">
                        <i class="fas fa-filter me-2"></i> Terapkan Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="row mb-4 g-4">
        <div class="col-md-6">
            <div class="card card-kpi gradient-blue text-white border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="position-relative z-index-1">
                        <h6 class="text-uppercase opacity-75 small fw-bold mb-3">Total Pendapatan</h6>
                        <h2 class="fw-bold mb-0 display-6">Rp <?= number_format($total_income, 0, ',', '.') ?></h2>
                    </div>
                    <i class="fas fa-wallet icon-bg text-white opacity-10"></i>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-kpi gradient-dark text-white border-0 shadow-sm h-100 rounded-4 overflow-hidden">
                <div class="card-body p-4 position-relative">
                    <div class="position-relative z-index-1">
                        <h6 class="text-uppercase opacity-75 small fw-bold mb-3">Total Transaksi</h6>
                        <h2 class="fw-bold mb-0 display-6"><?= count($sales) ?> <span class="fs-4 fw-normal">Kali</span></h2>
                    </div>
                    <i class="fas fa-shopping-cart icon-bg text-white opacity-10"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-header bg-white py-3 border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-bold text-dark"><i class="fas fa-list-ul me-2 text-primary"></i>Riwayat Transaksi</h6>
                        <span class="badge bg-light text-dark rounded-pill px-3 py-2 fw-normal"><?= count($sales) ?> Data Terdeteksi</span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 border-0 text-muted small fw-bold text-uppercase">No</th>
                                <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Tanggal</th>
                                <th class="py-3 border-0 text-muted small fw-bold text-uppercase">Pelanggan</th>
                                <th class="py-3 border-0 text-muted small fw-bold text-uppercase text-end pe-4">Total Ammount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($sales)): ?>
                                <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada transaksi di periode ini.</td></tr>
                            <?php else: ?>
                                <?php foreach($sales as $index => $s): ?>
                                <tr>
                                    <td class="ps-4 text-muted small"><?= $index + 1 ?></td>
                                    <td class="fw-medium"><?= date('d M Y', strtotime($s['order_date'])) ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2 bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold">
                                                <?= strtoupper(substr($s['name_customer'], 0, 1)) ?>
                                            </div>
                                            <span class="fw-semibold"><?= $s['name_customer']; ?></span>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <span class="fw-bold text-primary">Rp <?= number_format($s['total_amount'], 0, ',', '.') ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100 rounded-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="mb-0 fw-bold text-success"><i class="fas fa-fire me-2"></i>Produk Terlaris</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php if(empty($best_sellers)): ?>
                            <div class="p-4 text-center text-muted small">Tidak ada data.</div>
                        <?php else: ?>
                            <?php foreach($best_sellers as $index => $bs): ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center p-4 border-0 border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0 me-3 fw-bold text-light"><?= $index + 1 ?></h5>
                                    <div>
                                        <span class="d-block fw-bold text-dark small mb-0"><?= $bs['item_name'] ?></span>
                                        <small class="text-muted small">ID Item: #<?= rand(100, 999) ?></small>
                                    </div>
                                </div>
                                <span class="badge bg-soft-success text-success px-3 py-2 rounded-pill fw-bold"><?= $bs['total_qty'] ?> Unit</span>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Gradient backgrounds */
    .gradient-blue { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
    .gradient-dark { background: linear-gradient(135deg, #1a1c23 0%, #2c3e50 100%); }
    
    /* Soft Buttons */
    .btn-soft-success { background-color: #e8f5e9; color: #2e7d32; border: none; }
    .btn-soft-success:hover { background-color: #c8e6c9; color: #1b5e20; }
    .btn-soft-danger { background-color: #ffebee; color: #c62828; border: none; }
    .btn-soft-danger:hover { background-color: #ffcdd2; color: #b71c1c; }
    
    /* Utility */
    .avatar-sm { width: 32px; height: 32px; font-size: 0.8rem; }
    .bg-soft-primary { background-color: #e3f2fd; }
    .bg-soft-success { background-color: #e8f5e9; }
    .tracking-wider { letter-spacing: 0.05em; }
    .icon-bg { position: absolute; right: -10px; bottom: -10px; font-size: 5rem; transform: rotate(-15deg); }
    .rounded-4 { border-radius: 1rem !important; }
    .hover-up { transition: all 0.2s ease; }
    .hover-up:hover { transform: translateY(-3px); box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important; }
    
    /* Printing */
    @media print {
        .no-print, .btn, form, nav, .footer { display: none !important; }
        .card { border: 1px solid #eee !important; box-shadow: none !important; }
        body { background-color: white !important; }
        .card-kpi { color: black !important; background: white !important; border: 1px solid #eee !important; }
        .icon-bg { display: none; }
    }
</style>
<?= $this->endSection() ?>