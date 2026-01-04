<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f4f7f6;
    }

    /* Efek Kertas Nota di Layar */
    .nota-container {
        max-width: 800px;
        margin: auto;
        background: white;
        padding: 40px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        border-radius: 8px;
        position: relative;
    }

    /* Dekorasi Garis Putus-putus ala Struk */
    .border-dashed-bottom {
        border-bottom: 2px dashed #eee;
        padding-bottom: 20px;
        margin-bottom: 20px;
    }

    .table thead th {
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 1px;
        color: #888;
        border-top: none;
    }

    .total-section {
        background-color: #fdfdfd;
        border-radius: 8px;
        padding: 20px;
    }

    .grand-total-label {
        font-size: 1.1rem;
        color: #555;
    }

    .grand-total-amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3436;
    }

    /* Pengaturan Cetak */
    @media print {
        body { background: white; }
        .no-print { display: none !important; }
        .nota-container {
            box-shadow: none;
            padding: 0;
            max-width: 100%;
        }
        .btn, nav { display: none !important; }
    }
</style>

<div class="container py-5">
   

    <div class="nota-container">
        <div class="row border-dashed-bottom">
            <div class="col-md-6">
                <h3 class="fw-bold mb-1">TOKO RENDI</h3>
                <p class="text-muted small mb-0">
                    Sistem Manajemen Penjualan Retail<br>
                    Makassar, Sulawesi Selatan
                </p>
            </div>
            <div class="col-md-6 text-md-end mt-3 mt-md-0">
                <div class="badge bg-soft-success text-success p-2 px-3 mb-2" style="background-color: #e8f5e9;">
                    <i class="fas fa-check-circle me-1"></i> <?= strtoupper($order['order_status']); ?>
                </div>
                <h5 class="fw-bold mb-0">#TRX-<?= str_pad($order['order_id'], 5, '0', STR_PAD_LEFT); ?></h5>
                <small class="text-muted"><?= date('d F Y, H:i', strtotime($order['order_date'])); ?></small>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <small class="text-muted d-block text-uppercase small fw-bold mb-1">Dibayar Oleh:</small>
                <h6 class="fw-bold"><?= strtoupper($order['name_customer']); ?></h6>
            </div>
        </div>

        <div class="table-responsive mb-4">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th class="ps-0">Deskripsi Produk</th>
                        <th class="text-center">Harga</th>
                        <th class="text-center">Jumlah</th>
                        <th class="text-end pe-0">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($items as $item): ?>
                    <tr>
                        <td class="ps-0">
                            <span class="fw-semibold d-block"><?= $item['item_name']; ?></span>
                        </td>
                        <td class="text-center text-muted">Rp <?= number_format($item['unit_price'], 0, ',', '.'); ?></td>
                        <td class="text-center fw-bold"><?= $item['quantity']; ?></td>
                        <td class="text-end pe-0 fw-bold">Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="row justify-content-end">
            <div class="col-md-5">
                <div class="total-section border-top">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Metode Pembayaran</span>
                        <span class="fw-bold text-end">Tunai / Cash</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                        <span class="grand-total-label">Total Bayar</span>
                        <span class="grand-total-amount">Rp <?= number_format($order['total_amount'], 0, ',', '.'); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5 pt-4 border-top text-center">
            <p class="text-muted mb-1 small">Barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.</p>
            <h6 class="fw-bold small">TERIMA KASIH TELAH BERBELANJA</h6>
        </div>
    </div>
</div>
 <div class="mb-4 no-print d-flex justify-content-between align-items-center">
        <a href="<?= base_url('order') ?>" class="btn btn-link text-decoration-none text-muted">
            <i class="fas fa-chevron-left me-2"></i> Kembali ke Daftar
        </a>
        <button onclick="window.print()" class="btn btn-dark shadow-sm">
            <i class="fas fa-print me-2"></i> Cetak Transaksi
        </button>
    </div>