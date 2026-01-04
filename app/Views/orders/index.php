<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8f9fa;
    }
    .page-title {
        font-weight: 700;
        color: #2d3436;
        letter-spacing: -0.5px;
    }
    .card-table {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .table thead {
        background-color: #f1f3f5;
    }
    .table thead th {
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        color: #495057;
        padding: 15px;
        border: none;
    }
    .table tbody td {
        padding: 15px;
        vertical-align: middle;
        color: #2d3436;
        border-color: #f1f3f5;
    }
    .badge-status {
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.8rem;
    }
    .btn-action {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s;
    }
    .btn-action:hover {
        transform: translateY(-2px);
    }
    .search-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.02);
        margin-bottom: 25px;
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="page-title mb-1">Riwayat Transaksi</h2>
            <p class="text-muted small mb-0">Kelola dan pantau semua data penjualan toko Anda.</p>
        </div>
        <a href="<?= base_url('order/create') ?>" class="btn btn-primary btn-action shadow-sm px-4 py-2">
            <i class="fas fa-plus-circle me-2"></i> Transaksi Baru
        </a>
    </div>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card card-table p-3 border-start border-primary border-4">
                <small class="text-muted fw-bold">TOTAL TRANSAKSI</small>
                <h4 class="mb-0 fw-bold"><?= count($orders); ?></h4>
            </div>
        </div>
    </div>

    <div class="card card-table">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Waktu Transaksi</th>
                        <th>Nama Pelanggan</th>
                        <th>Nominal Pembayaran</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php $no = 1; foreach($orders as $o): ?>
                        <tr>
                            <td class="text-center text-muted"><?= $no++; ?></td>
                            <td>
                                <div class="fw-bold"><?= date('d M Y', strtotime($o['order_date'])); ?></div>
                                <small class="text-muted"><?= date('H:i', strtotime($o['order_date'])); ?> WIB</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px;">
                                        <i class="fas fa-user text-secondary small"></i>
                                    </div>
                                    <span class="fw-semibold"><?= strtoupper($o['name_customer']); ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">Rp <?= number_format($o['total_amount'], 0, ',', '.'); ?></span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-soft-success text-success badge-status" style="background-color: #e8f5e9;">
                                    <i class="fas fa-check-circle me-1 small"></i> <?= $o['order_status']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('order/detail/' . $o['order_id']); ?>" class="btn btn-sm btn-outline-info btn-action px-3">
                                    <i class="fas fa-file-invoice me-1"></i> Lihat Nota
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" style="width: 80px; opacity: 0.5;" class="mb-3">
                                <p class="text-muted">Belum ada aktivitas transaksi hari ini.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>