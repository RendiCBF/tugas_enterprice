<?php

namespace App\Controllers;

use App\Models\OrderModel;

class Report extends BaseController
{
    public function sales()
    {
        $orderModel = new OrderModel();
        
        // Ambil filter tanggal dari input (default: awal bulan ini s/d hari ini)
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate   = $this->request->getGet('end_date') ?? date('Y-m-d');

        // Ambil data transaksi dengan Join tabel customers
        // Kolom di gambar: name_customer
        $data['sales'] = $orderModel->select('orders.*, customers.name_customer')
            ->join('customers', 'customers.id_customer = orders.id_customer')
            ->where('order_date >=', $startDate . ' 00:00:00')
            ->where('order_date <=', $endDate . ' 23:59:59')
            ->orderBy('orders.order_date', 'DESC')
            ->findAll();

        $data['start_date'] = $startDate;
        $data['end_date']   = $endDate;

        // Hitung total pendapatan
        $data['total_income'] = array_sum(array_column($data['sales'], 'total_amount'));

        // Tambahkan di dalam fungsi sales() sebelum return view
        $orderItemModel = new \App\Models\OrderItemModel();
        $data['best_sellers'] = $orderItemModel->select('items.item_name, SUM(order_items.quantity) as total_qty')
            ->join('items', 'items.item_id = order_items.item_id')
            ->join('orders', 'orders.order_id = order_items.order_id')
            ->where('orders.order_date >=', $startDate . ' 00:00:00')
            ->where('orders.order_date <=', $endDate . ' 23:59:59')
            ->groupBy('order_items.item_id')
            ->orderBy('total_qty', 'DESC')
            ->limit(5)
            ->findAll();

        return view('reports/sales_report', $data);
    }
}