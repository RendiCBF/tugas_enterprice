<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi | Toko Rendi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f4f7fa;
        }
        .page-title {
            font-weight: 700;
            color: #1e293b;
            letter-spacing: -0.5px;
        }
        .card-custom {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.03);
            transition: all 0.3s;
        }
        .stat-card {
            border-left: 5px solid #0d6efd;
        }
        .stat-card-income {
            border-left: 5px solid #198754;
        }
        .table-container {
            background: white;
            border-radius: 16px;
            overflow: hidden;
        }
        .table thead th {
            background-color: #f8fafc;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            padding: 20px;
            border: none;
        }
        .table tbody td {
            padding: 18px 20px;
            vertical-align: middle;
            border-color: #f1f5f9;
        }
        .badge-status {
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.75rem;
        }
        .btn-action {
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.2s;
        }
        .customer-icon {
            width: 38px;
            height: 38px;
            background-color: #f1f5f9;
            color: #64748b;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="page-title mb-1">🧾 Riwayat Transaksi</h2>
            <p class="text-muted mb-0">Laporan aktivitas penjualan dan nota pelanggan.</p>
        </div>
        <a href="<?= base_url('order/create') ?>" class="btn btn-primary btn-action shadow-sm px-4 py-2">
            <i class="fas fa-plus-circle me-2"></i> Buat Transaksi Baru
        </a>
    </div>

    <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <div class="card card-custom stat-card p-4 bg-white h-100">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <small class="text-muted fw-bold d-block mb-1">JUMLAH ORDER</small>
                        <h3 class="mb-0 fw-bold text-dark"><?= count($orders); ?> <small class="text-muted fs-6 fw-normal">Kali</small></h3>
                    </div>
                    <div class="icon-box p-3 bg-primary bg-opacity-10 rounded-pill text-primary">
                        <i class="fas fa-shopping-bag fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-custom stat-card-income p-4 bg-white h-100">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <small class="text-muted fw-bold d-block mb-1">TOTAL PENDAPATAN</small>
                        <?php 
                            $totalIncome = 0;
                            foreach($orders as $o) { $totalIncome += $o['total_amount']; }
                        ?>
                        <h3 class="mb-0 fw-bold text-success">Rp <?= number_format($totalIncome, 0, ',', '.'); ?></h3>
                    </div>
                    <div class="icon-box p-3 bg-success bg-opacity-10 rounded-pill text-success">
                        <i class="fas fa-wallet fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom table-container shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="text-center" width="80">No</th>
                        <th>Tanggal & Jam</th>
                        <th>Informasi Pelanggan</th>
                        <th>Total Pembayaran</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)): ?>
                        <?php $no = 1; foreach($orders as $o): ?>
                        <tr>
                            <td class="text-center text-muted fw-bold"><?= $no++; ?></td>
                            <td>
                                <div class="fw-bold text-dark"><?= date('d M Y', strtotime($o['order_date'])); ?></div>
                                <div class="text-muted small"><i class="far fa-clock me-1"></i><?= date('H:i', strtotime($o['order_date'])); ?> WIB</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="customer-icon me-3">
                                        <i class="fas fa-user small"></i>
                                    </div>
                                    <div class="fw-semibold text-dark"><?= strtoupper($o['name_customer']); ?></div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-bold text-primary fs-6">Rp <?= number_format($o['total_amount'], 0, ',', '.'); ?></div>
                            </td>
                            <td class="text-center">
                                <span class="badge badge-status bg-success-subtle text-success border border-success-subtle">
                                    <i class="fas fa-check-circle me-1"></i> <?= $o['order_status']; ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="<?= base_url('order/detail/' . $o['order_id']); ?>" class="btn btn-sm btn-white border btn-action px-3">
                                    <i class="fas fa-file-invoice text-info me-2"></i>Detail Nota
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" style="width: 100px; opacity: 0.2;" class="mb-4">
                                    <h5 class="text-muted fw-normal">Belum ada transaksi yang tercatat</h5>
                                    <a href="<?= base_url('order/create') ?>" class="btn btn-primary mt-3 btn-sm px-4">Buat Transaksi Sekarang</a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <a href="<?= base_url('dashboard') ?>" class="btn btn-link text-decoration-none text-muted p-0">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Menu Utama
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>