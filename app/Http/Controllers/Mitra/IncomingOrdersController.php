<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IncomingOrdersController extends Controller
{
    public function index()
    {
        $userId = Auth::id() ?? 1;

        // Fetch incoming orders (pending status) from database for logged-in mitra
        $orders = Order::whereHas('service', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->where('status', 'pending')
        ->with(['service:id,nama_layanan', 'user:id,nama,phone,email'])
        ->latest('created_at')
        ->get()
        ->map(function ($order) {
            return [
                'id' => $order->id,
                'order_code' => $order->order_code,
                'customer_name' => $order->customer_name,
                'service_type' => $order->service->kategori ?? 'Umum',
                'service_name' => $order->service->nama_layanan,
                'address' => $order->alamat_lengkap,
                'total_price' => $order->total_harga,
                'order_date' => $order->created_at->format('Y-m-d'),
                'status' => $order->status,
                'phone' => $order->customer_phone,
                'email' => $order->customer_email,
                'notes' => $order->catatan_customer,
            ];
        });

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
        $orderId = $request->input('order_id');
        $action = $request->input('action');

        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->route('mitra.orders.incoming')
                ->with('message', ['type' => 'error', 'text' => 'Pesanan tidak ditemukan.']);
        }

        // Verify ownership: order harus milik service dari mitra yang login
        $userId = Auth::id() ?? 1;
        if ($order->service->user_id !== $userId) {
            return redirect()->route('mitra.orders.incoming')
                ->with('message', ['type' => 'error', 'text' => 'Anda tidak memiliki akses ke pesanan ini.']);
        }

        if ($action === 'accept') {
            $order->update(['status' => 'confirmed']);
            return redirect()->route('mitra.orders.incoming')
                ->with('message', ['type' => 'success', 'text' => "Order #{$order->order_code} berhasil diterima dan status diubah menjadi Confirmed!"]);
        } elseif ($action === 'reject') {
            $rejectedOrderIds = session('mitra.rejected_order_ids', []);
            if (!in_array($orderId, $rejectedOrderIds)) {
                $rejectedOrderIds[] = $orderId;
            }
            session(['mitra.rejected_order_ids' => $rejectedOrderIds]);

            // Optionally: update order status to cancelled
            $order->update(['status' => 'cancelled']);
            return redirect()->route('mitra.orders.incoming')
                ->with('message', ['type' => 'warning', 'text' => "Order #{$order->order_code} telah ditolak dan dihapus dari daftar Pesanan Masuk."]);
        }

        return redirect()->route('mitra.orders.incoming');
    }
}