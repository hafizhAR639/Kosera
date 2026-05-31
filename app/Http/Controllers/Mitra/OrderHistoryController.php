<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Services\MitraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderHistoryController extends Controller
{
    public function __construct(private MitraService $mitraService) {}

    public function index(Request $request)
    {
        $userId = Auth::id() ?? 1;
        $statusFilter = (string) $request->query('status', 'all');
        $dateFrom = (string) $request->query('date_from', '');
        $dateTo = (string) $request->query('date_to', '');

        $orders = $this->mitraService->getOrderHistory($userId, $statusFilter, $dateFrom, $dateTo);
        $stats = $this->mitraService->getOrderHistoryStats($userId);

        return view('mitra.orders_history', [
            'orders' => $orders,
            'stats' => $stats,
            'statusFilter' => $statusFilter,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ]);
    }

    public function export(Request $request)
    {
        $userId = Auth::id() ?? 1;
        $statusFilter = (string) $request->query('status', 'all');
        $dateFrom = (string) $request->query('date_from', '');
        $dateTo = (string) $request->query('date_to', '');

        $rows = $this->mitraService->getOrderHistoryForExport($userId, $statusFilter, $dateFrom, $dateTo);

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Order Code', 'Customer', 'Service', 'Total', 'Order Date', 'Status']);
            foreach ($rows as $r) {
                fputcsv($out, [
                    $r['order_code'] ?? '',
                    $r['customer_name'] ?? '',
                    $r['service_name'] ?? '',
                    $r['total_price'] ?? 0,
                    $r['order_date'] ?? '',
                    $r['status'] ?? '',
                ]);
            }
            fclose($out);
        };

        return response()->streamDownload($callback, 'orders_export.csv', ['Content-Type' => 'text/csv']);
    }
}
