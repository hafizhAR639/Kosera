<?php

namespace App\Controllers\Mitra;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Helpers;

class OrderHistoryController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $userId = (int) Auth::getCurrentUserId();
        $status = $_GET['status'] ?? 'all';
        $from = $_GET['from'] ?? '';
        $to = $_GET['to'] ?? '';

        $service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());

        $orders = $service->getOrderHistory($userId, $status, $from, $to);
        $stats = $service->getOrderHistoryStats($userId);

        $this->render('mitra/orders_history', [
            'title' => 'Riwayat Order',
            'message' => Helpers::getMessage(),
            'orders' => $orders,
            'stats' => $stats,
        ], 'mitra');
    }

    public function exportCsv(): void
    {
        Auth::requireLogin();

        $userId = (int) Auth::getCurrentUserId();
        $status = $_GET['status'] ?? 'all';
        $from = $_GET['from'] ?? '';
        $to = $_GET['to'] ?? '';

        $service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());
        $rows = $service->getOrderHistoryForExport($userId, $status, $from, $to);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="order_history.csv"');

        $out = fopen('php://output', 'w');
        fputcsv($out, ['order_code', 'order_date', 'service', 'customer_name', 'address', 'total_price', 'status', 'rating']);

        foreach ($rows as $r) {
            fputcsv($out, [
                $r['order_code'] ?? '',
                $r['tanggal_order'] ?? '',
                $r['nama_layanan'] ?? '',
                $r['customer_name'] ?? '',
                $r['alamat_lengkap'] ?? '',
                $r['total_harga'] ?? 0,
                $r['status'] ?? '',
                $r['rating'] ?? '',
            ]);
        }

        fclose($out);
        exit;
    }
}
