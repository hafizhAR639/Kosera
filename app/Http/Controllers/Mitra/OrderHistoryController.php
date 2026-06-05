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
    // ... fungsi-fungsi lain di atasnya ...

    public function updateProgress(\Illuminate\Http\Request $request, $orderId)
    {
        // 1. Validasi status yang dikirim (hanya boleh in_progress atau completed)
        $request->validate([
            'status' => 'required|in:in_progress,completed'
        ]);

        // 2. Cari pesanan berdasarkan Kode Pesanan
        $order = \App\Models\Order::where('order_code', $orderId)->firstOrFail();

        // 3. Ubah status pesanan
        $order->status = $request->status;
        $order->save();

        // 4. Jika statusnya "completed", tambahkan pendapatan ke Mitra
        if ($request->status === 'completed') {
            $mitraId = auth()->id() ?? session('user_id', 1);
            \App\Models\Earning::create([
                'user_id' => $mitraId, 
                'order_id' => $order->id, 
                'jumlah' => $order->total_harga, // <- Menggunakan 'jumlah' bukan 'amount'
                'status' => 'pending', // <- Menggunakan 'pending' sesuai ENUM database
                'tipe' => 'order'
            ]);
            
            return redirect()->back()->with('success', 'Pesanan selesai! Pendapatan telah ditambahkan ke Dashboard Anda.');
        }

        // 5. Jika statusnya "in_progress", berikan notifikasi biasa
        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui menjadi Sedang Dikerjakan.');
    }
} // <-- Ini kurung kurawal penutup akhir file

