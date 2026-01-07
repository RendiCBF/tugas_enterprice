<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8fafc;
    }

    /* Container Nota */
    .nota-container {
        max-width: 850px;
        margin: auto;
        background: white;
        padding: 50px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.03);
        border-radius: 16px;
        position: relative;
        border: 1px solid #f1f5f9;
    }

    /* Header Toko */
    .shop-logo {
        letter-spacing: -1px;
        color: #1e293b;
        font-weight: 800;
    }

    /* Status Badge */
    .status-badge {
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Tabel Detail Produk */
    .table thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 1px;
        color: #64748b;
        border: none;
        padding: 15px;
    }

    .table tbody td {
        padding: 20px 15px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
    }

    /* Bagian Total */
    .total-box {
        background-color: #f8fafc;
        border-radius: 12px;
        padding: 24px;
    }

    .grand-total-amount {
        font-size: 1.75rem;
        font-weight: 800;
        color: #0f172a;
    }

    /* Dekorasi Garis Ala Struk Modern */
    .divider {
        height: 1px;
        background-image: linear-gradient(to right, #e2e8f0 50%, rgba(255, 255, 255, 0) 0%);
        background-position: bottom;
        background-size: 8px 1px;
        background-repeat: repeat-x;
        margin: 30px 0;
    }

    /* Pengaturan Tombol */
    .btn-print {
        background-color: #0f172a;
        color: white;
        padding: 12px 25px;
        border-radius: 10px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn-print:hover {
        background-color: #334155;
        color: white;
        transform: translateY(-2px);
    }

    /* Pengaturan Cetak */
    @media print {
        body { background: white !important; }
        .no-print { display: none !important; }
        .nota-container {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            max-width: 100% !important;
        }
        nav, .footer { display: none !important; }
    }
</style>

<div class="container py-5">
    <div class="mb-4 no-print d-flex justify-content-between align-items-center">
        <a href="<?= base_url('order') ?>" class="btn btn-light text-muted fw-semibold rounded-pill px-4">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-print shadow-sm">
            <i class="fas fa-print me-2"></i> Cetak Invoice
        </button>
    </div>

    <div class="nota-container">
        <div class="row align-items-start">
            <div class="col-sm-6">
                <h2 class="shop-logo mb-1">TOKO RENDI</h2>
                <p class="text-muted small lh-base">
                    Retail & Management System<br>
                    Jl. Jenderal Sudirman No. 123, Makassar<br>
                    Sulawesi Selatan, Indonesia
                </p>
            </div>
            <div class="col-sm-6 text-sm-end mt-4 mt-sm-0">
                <span class="status-badge bg-success text-white mb-3 d-inline-block">
                    <i class="fas fa-check me-1"></i> <?= $order['order_status']; ?>
                </span>
                <h4 class="fw-bold text-dark mb-0">INVOICE #<?= str_pad($order['order_id'], 5, '0', STR_PAD_LEFT); ?></h4>
                <p class="text-muted small"><?= date('D, d M Y | H:i', strtotime($order['order_date'])); ?></p>
            </div>
        </div>

        <div class="divider"></div>

        <div class="row mb-5">
            <div class="col-6">
                <p class="text-muted small text-uppercase fw-bold mb-2 ls-1">Ditagihkan Kepada:</p>
                <h5 class="fw-bold text-dark mb-1"><?= strtoupper($order['name_customer']); ?></h5>
                <p class="text-muted small">ID Pelanggan: CUST-<?= $order['id_customer'] ?? '000'; ?></p>
            </div>
            <div class="col-6 text-end">
                <p class="text-muted small text-uppercase fw-bold mb-2 ls-1">Metode Pembayaran:</p>
                <h6 class="fw-bold text-dark">Tunai / Cash</h6>
                <p class="text-muted small">Kasir: Administrator</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th class="ps-0" width="45%">Item Description</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end pe-0">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items as $item): ?>
                    <tr>
                        <td class="ps-0">
                            <span class="fw-bold d-block text-dark"><?= $item['item_name']; ?></span>
                            <span class="text-muted small">ID Product: #<?= $item['item_id']; ?></span>
                        </td>
                        <td class="text-center">Rp <?= number_format($item['unit_price'], 0, ',', '.'); ?></td>
                        <td class="text-center fw-semibold"><?= $item['quantity']; ?></td>
                        <td class="text-end pe-0 fw-bold text-dark">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="row justify-content-end mt-4">
            <div class="col-lg-5 col-md-7">
                <div class="total-box">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal Produk</span>
                        <span class="fw-semibold">Rp <?= number_format($order['total_amount'], 0, ',', '.'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Pajak (0%)</span>
                        <span class="fw-semibold">Rp 0</span>
                    </div>
                    <div class="border-top pt-3 d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark">GRAND TOTAL</span>
                        <span class="grand-total-amount text-primary">Rp <?= number_format($order['total_amount'], 0, ',', '.'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 pt-5 text-center">
            <div class="divider"></div>
            <p class="text-muted small mb-1 italic">"Kepuasan pelanggan adalah prioritas kami."</p>
            <p class="text-dark fw-bold small text-uppercase">Terima kasih telah berbelanja di Toko Rendi</p>
            
            <div class="mt-3 opacity-25">
                <i class="fas fa-qrcode fa-3x text-dark"></i>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>