<h3>Laporan Penjualan</h3>

<form method="GET" action="/report/sales" class="mb-4">
    <div class="row">
        <div class="col-md-3">
            <input type="date" name="start_date" class="form-control" value="<?= $start_date ?>">
        </div>
        <div class="col-md-3">
            <input type="date" name="end_date" class="form-control" value="<?= $end_date ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal</th>
            <th>Pelanggan</th>
            <th>Total Transaksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($sales as $index => $s): ?>
        <tr>
            <td><?= $index + 1 ?></td>
            <td><?= date('d/m/Y', strtotime($s['order_date'])) ?></td>
            <td><?= $s['name_customer']; ?></td>
            <td>Rp <?= number_format($s['total_amount'], 0, ',', '.') ?></td>
        </tr>
        <?php endforeach; ?>
        
    </tbody>
    <tfoot>
        <h4 class="mt-5">5 Produk Terlaris</h4>
<table class="table table-sm table-striped" style="width: 50%;">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Total Terjual</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($best_sellers as $bs): ?>
        <tr>
            <td><?= $bs['item_name'] ?></td>
            <td><?= $bs['total_qty'] ?> unit</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
        <tr>
            <th colspan="3" class="text-end">GRAND TOTAL PENDAPATAN:</th>
            <th>Rp <?= number_format($total_income, 0, ',', '.') ?></th>
        </tr>
    </tfoot>
</table>