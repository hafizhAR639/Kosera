<?php

namespace App\Controllers\Mitra;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Helpers;
use App\Models\Mitra\OrderModel;

class OrderHistoryController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $statusFilter = $_GET['status'] ?? 'all';
        $dateFrom = $_GET['date_from'] ?? '';
        $dateTo = $_GET['date_to'] ?? '';

        $model = new OrderModel();

        $this->render('mitra/orders_history', [
            'title' => 'Riwayat Pesanan',
            'orders' => $model->getHistory($userId, $statusFilter, $dateFrom, $dateTo),
            'stats' => $model->getHistoryStats($userId),
            'statusFilter' => $statusFilter,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ], 'mitra');
    }

    public function exportCsv(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $statusFilter = $_GET['status'] ?? 'all';
        $dateFrom = $_GET['date_from'] ?? '';
        $dateTo = $_GET['date_to'] ?? '';

        $rows = (new OrderModel())->getHistoryForExport($userId, $statusFilter, $dateFrom, $dateTo);

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=riwayat-pesanan.csv');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Kode Order', 'Tanggal', 'Layanan', 'Pelanggan', 'Alamat', 'Total', 'Status', 'Rating']);

        foreach ($rows as $row) {
            fputcsv($output, [
                $row['order_code'],
                $row['tanggal_order'],
                $row['nama_layanan'],
                $row['customer_name'],
                $row['alamat_lengkap'],
                $row['total_harga'],
                $row['status'],
                $row['rating'],
            ]);
        }

        fclose($output);
        exit();
    }
}
