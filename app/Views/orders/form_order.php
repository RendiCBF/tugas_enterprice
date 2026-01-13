<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<style>
    body { background-color: #f8f9fa; }
    .page-header { margin-bottom: 2rem; }
    .card { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
    .table thead th { 
        background-color: #f1f4f9; 
        text-transform: uppercase; 
        font-size: 0.75rem; 
        letter-spacing: 1px; 
        color: #5a6a85;
        border: none;
        padding: 15px;
    }
    .input-custom { 
        border: 1px solid #dfe5ef; 
        border-radius: 10px; 
        padding: 10px;
    }
    .item-row td { padding: 15px; border-color: #f1f4f9; vertical-align: middle; }
    .btn-remove { 
        color: #fa896b; 
        background: #fef2f0; 
        border: none; 
        width: 35px; 
        height: 35px; 
        border-radius: 8px; 
        transition: 0.3s;
    }
    .btn-remove:hover { background: #fa896b; color: white; }
    .summary-card { background: linear-gradient(135deg, #5d87ff 0%, #4667d6 100%); color: white; }
</style>

<div class="container py-4">
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold text-dark mb-1">🛒 Transaksi Baru</h3>
            <p class="text-muted mb-0 small">Pastikan stok mencukupi sebelum menyimpan.</p>
        </div>
        <a href="<?= base_url('order') ?>" class="btn btn-outline-secondary btn-sm px-3 rounded-pill">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="<?= base_url('order/store') ?>" method="post">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header bg-white py-3 border-0">
                        <h6 class="fw-bold mb-0">Keranjang Belanja</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0" id="orderTable">
                            <thead>
                                <tr>
                                    <th width="40%">Produk</th>
                                    <th>Harga</th>
                                    <th width="120">Qty</th>
                                    <th>Subtotal</th>
                                    <th width="50"></th>
                                </tr>
                            </thead>
                            <tbody id="item-list">
                                <tr class="item-row">
                                    <td>
                                        <select name="items[0][product_id]" class="form-select input-custom product-select" required>
                                            <option value="">-- Pilih Produk --</option>
                                            <?php foreach($products as $p): ?>
                                                <option value="<?= $p['item_id'] ?>" 
                                                        data-price="<?= $p['price'] ?>" 
                                                        data-stok="<?= $p['stock_quantity'] ?>">
                                                    <?= $p['item_name'] ?> (Stok: <?= $p['stock_quantity'] ?>) 
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0 small">Rp</span>
                                            <input type="number" class="form-control-plaintext ps-2 fw-semibold price" readonly value="0">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" name="items[0][qty]" class="form-control input-custom qty" min="1" required placeholder="0">
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0 small">Rp</span>
                                            <input type="number" name="items[0][subtotal]" class="form-control-plaintext ps-2 fw-bold text-primary subtotal" readonly value="0">
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn-remove remove-row">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-white border-0 py-3">
                        <button type="button" id="addRow" class="btn btn-outline-primary btn-sm px-4 rounded-pill fw-bold">
                            <i class="fas fa-plus me-2"></i> Tambah Baris Produk
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body p-4">
                        <label class="form-label fw-bold text-muted small">PELANGGAN</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-user text-muted"></i></span>
                            <select name="customer_id" class="form-select input-custom" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php foreach($customers as $c): ?>
                                    <option value="<?= $c['id_customer'] ?>" <?= old('customer_id') == $c['id_customer'] ? 'selected' : '' ?>>
                                        <?= $c['name_customer'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <!-- <input type="number" name="items[0][qty]" value="<?= old('items.0.qty') ?>" class="form-control qty" required> -->
                        </div>
                    </div>
                </div>

                <div class="card summary-card shadow-lg">
                    <div class="card-body p-4 text-center">
                        <p class="mb-1 opacity-75">Total Pembayaran</p>
                        <h2 class="fw-bold mb-4">Rp <span id="grandTotal">0</span></h2>
                        <input type="hidden" name="total_grand" id="inputGrandTotal">
                        
                        <button type="submit" class="btn btn-light w-100 py-3 fw-bold text-primary shadow" style="border-radius: 12px; border:none;">
                            SIMPAN TRANSAKSI <i class="fas fa-check-circle ms-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    let rowIdx = 1;

    // 1. Tambah Baris (Sempurna: Reset nilai & bersihkan data-atribut)
    document.getElementById('addRow').addEventListener('click', function() {
        const tbody = document.getElementById('item-list');
        const firstRow = document.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        
        newRow.querySelectorAll('select, input').forEach(el => {
            const name = el.getAttribute('name');
            if (name) el.setAttribute('name', name.replace(/\[\d+\]/, `[${rowIdx}]`));
            el.value = (el.classList.contains('qty')) ? '' : 0;
            if (el.tagName === 'SELECT') el.value = '';
        });
        
        tbody.appendChild(newRow);
        rowIdx++;
    });

    // 2. Hapus Baris
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-row')) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                e.target.closest('.item-row').remove();
                calculateAll();
            }
        }
    });

    // 3. Hitung Otomatis & Validasi Stok Real-time
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('product-select') || e.target.classList.contains('qty')) {
            calculateAll();
        }
    });

    function calculateAll() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const select = row.querySelector('.product-select');
            const selectedOption = select.options[select.selectedIndex];
            
            const price = parseFloat(selectedOption.getAttribute('data-price')) || 0;
            const stok = parseInt(selectedOption.getAttribute('data-stok')) || 0;
            const qtyInput = row.querySelector('.qty');
            let qty = parseInt(qtyInput.value) || 0;

            // Validasi Stok di Sisi Client
            if (qty > stok) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Kurang',
                    text: `Stok tersedia untuk ${selectedOption.text.split('(')[0]} hanya ${stok}`,
                });
                qty = stok;
                qtyInput.value = stok;
            }

            const subtotal = price * qty;
            row.querySelector('.price').value = price;
            row.querySelector('.subtotal').value = subtotal;
            total += subtotal;
        });

        document.getElementById('grandTotal').innerText = new Intl.NumberFormat('id-ID').format(total);
        document.getElementById('inputGrandTotal').value = total;
    }

    // 4. Alert Session Flashdata (Satu Tempat)
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (session()->getFlashdata('success')) : ?>
            Swal.fire({ icon: 'success', title: 'Berhasil!', text: '<?= session()->getFlashdata('success') ?>', timer: 2000, showConfirmButton: false });
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')) : ?>
            Swal.fire({
                icon: 'error',
                title: 'Transaksi Gagal',
                text: '<?= addslashes(session()->getFlashdata('error')) ?>',
                confirmButtonColor: '#d33'
            });
        <?php endif; ?>
    });
</script>
<?= $this->endSection() ?>