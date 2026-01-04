<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="container mt-4">
    <h2>Tambah Transaksi Baru</h2>
    <hr>
    
    <form action="<?= base_url('order/store') ?>" method="post">
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Customer</label>
                <select name="customer_id" class="form-select" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    <?php foreach($customers as $c): ?>
                        <option value="<?= $c['id_customer'] ?>"><?= $c['name_customer'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <table class="table table-bordered" id="orderTable">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th width="100">Qty</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="item-list">
                <tr class="item-row">
                    <td>
                        <select name="items[0][product_id]" class="form-select product-select" required>
                            <option value="">-- Pilih Produk --</option>
                            <?php foreach($products as $p): ?>
                                <option value="<?= $p['item_id'] ?>" data-price="<?= $p['price'] ?>">
                                    <?= $p['item_name'] ?> (Stok: <?= $p['stock_quantity'] ?? '0' ?>) 
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </td>
                    <td><input type="number" name="items[0][price]" class="form-control price" readonly></td>
                    <td><input type="number" name="items[0][qty]" class="form-control qty" min="1" required></td>
                    <td><input type="number" name="items[0][subtotal]" class="form-control subtotal" readonly></td>
                    <td><button type="button" class="btn btn-outline-danger remove-row">×</button></td>
                </tr>
            </tbody>
        </table>

        <button type="button" id="addRow" class="btn btn-primary mb-3">+ Tambah Baris</button>

        <div class="card bg-light">
            <div class="card-body text-end">
                <h4>Total Akhir: <span class="text-primary">Rp </span><span id="grandTotal" class="text-primary font-weight-bold">0</span></h4>
                <input type="hidden" name="total_grand" id="inputGrandTotal">
                <button type="submit" class="btn btn-success btn-lg px-5">Simpan Transaksi</button>
            </div>
        </div>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    let rowIdx = 1;

    // Tombol Tambah Baris (Sangat Penting: Harus mengubah atribut 'name')
    document.getElementById('addRow').addEventListener('click', function() {
        const tbody = document.getElementById('item-list');
        const firstRow = document.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        
        newRow.querySelectorAll('select, input').forEach(el => {
            const name = el.getAttribute('name');
            if (name) {
                // Mengubah items[0] menjadi items[1], items[2], dst
                el.setAttribute('name', name.replace(/\[\d+\]/, `[${rowIdx}]`));
            }
            el.value = ''; 
        });
        tbody.appendChild(newRow);
        rowIdx++;
    });

    // POP-UP BERHASIL
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= session()->getFlashdata('success') ?>',
            timer: 2500,
            showConfirmButton: false
        });
    <?php endif; ?>

    // POP-UP GAGAL
    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '<?= session()->getFlashdata('error') ?>'
        });
    <?php endif; ?>

    // Logika Hitung Otomatis
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('product-select') || e.target.classList.contains('qty')) {
            const row = e.target.closest('.item-row');
            const select = row.querySelector('.product-select');
            const price = select.options[select.selectedIndex].getAttribute('data-price') || 0;
            const qty = row.querySelector('.qty').value || 0;
            
            row.querySelector('.price').value = price;
            row.querySelector('.subtotal').value = price * qty;
            
            let total = 0;
            document.querySelectorAll('.subtotal').forEach(s => total += parseFloat(s.value || 0));
            document.getElementById('grandTotal').innerText = new Intl.NumberFormat('id-ID').format(total);
            document.getElementById('inputGrandTotal').value = total;
        }
    });
</script>
<?= $this->endSection() ?>