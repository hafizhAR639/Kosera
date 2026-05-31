<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Services\MitraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomingOrdersController extends Controller
{
    public function __construct(private MitraService $mitraService) {}

    public function index()
    {
        $userId = Auth::id() ?? 1;
        $orders = collect($this->mitraService->getIncomingOrders($userId));

        // Filter out rejected orders from session
        $rejectedOrderIds = session('mitra.rejected_order_ids', []);
        $orders = $orders->filter(function ($order) use ($rejectedOrderIds) {
            return !in_array($order['id'], $rejectedOrderIds);
        })->values();

        $message = session('message');

        return view('mitra.orders_incoming', compact('orders', 'message'));
    }

    public function updateStatus(Request $request)
    {
        $orderId = (int) $request->input('order_id');
        $action = $request->input('action');
        $userId = Auth::id() ?? 1;

        if ($action === 'accept') {
            $ok = $this->mitraService->updateIncomingOrderStatus($userId, $orderId, 'confirmed');
            if (! $ok) {
                return redirect()->route('mitra.orders.incoming')
                    ->with('message', ['type' => 'error', 'text' => 'Pesanan tidak ditemukan atau akses ditolak.']);
            }
            return redirect()->route('mitra.orders.incoming')
                ->with('message', ['type' => 'success', 'text' => 'Pesanan berhasil diterima dan status diubah menjadi Confirmed!']);
        } elseif ($action === 'reject') {
            $rejectedOrderIds = session('mitra.rejected_order_ids', []);
            if (!in_array($orderId, $rejectedOrderIds)) {
                $rejectedOrderIds[] = $orderId;
            }
            session(['mitra.rejected_order_ids' => $rejectedOrderIds]);

            $this->mitraService->updateIncomingOrderStatus($userId, $orderId, 'cancelled');
            return redirect()->route('mitra.orders.incoming')
                ->with('message', ['type' => 'warning', 'text' => 'Pesanan telah ditolak dan dihapus dari daftar Pesanan Masuk.']);
        }

        return redirect()->route('mitra.orders.incoming');
    }
}