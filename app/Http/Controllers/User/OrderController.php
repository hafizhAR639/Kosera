<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\OrderService;
use Illuminate\Http\Request;
use App\Http\Requests\StoreOrderRequest;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService) {}

    /**
     * Show order history
     * Thin controller: Validate → Service → View
     */
    public function history(Request $request)
    {
        $userId = Auth::id() ?? session('user_id', 1);
        $filters = $request->only(['status']);

        $data = $this->orderService->getUserHistory($userId, $filters);

        return view('user.orders.history', [
            'orders' => $data['orders'],
            'stats' => $data['stats'],
            'filters' => ['status' => $filters['status'] ?? 'all'],
        ]);
    }

    /**
     * Show order detail
     * Thin controller: just fetch and return
     */
    public function show(string $orderId)
    {
        $userId = Auth::id() ?? session('user_id', 1);
        $order = $this->orderService->getOrderDetail($userId, $orderId);

        return view('user.orders.show', ['order' => $order]);
    }

    /**
     * Show detail pesanan setelah pembayaran berhasil
     * Thin controller: fetch latest if no ID provided
     */
    public function detail(?string $orderId = null)
    {
        $userId = Auth::id() ?? session('user_id', 1);

        $order = $orderId
            ? $this->orderService->getOrderDetail($userId, $orderId)
            : $this->orderService->getLatestOrderForUser($userId);

        return view('user.detail-pesanan', ['order' => $order]);
    }

    /**
     * Create new order (redirect to confirmation)
     * Validate service exists, then redirect
     */
    // KODE BARU (Langsung mengirim data ke halaman Blade)
    public function create(Request $request)
    {
        $serviceId = $request->query('service_id');
        
        // 1. Ambil data layanan asli dari database berdasarkan ID yang diklik
        $service = \App\Models\Service::findOrFail($serviceId);
        // Ambil data user yang sedang login (dengan fallback ke User ID 1 agar aman)
        $user = \App\Models\User::find(auth()->id()) ?? \App\Models\User::find(1);
        // 2. Langsung tampilkan halamannya dan kirimkan datanya (tanpa redirect)
        return view('user.konfirmasi-pesanan', compact('service', 'user'));
    }

    /**
     * Store order
     * Validation → Service → Redirect
     */
    public function store(StoreOrderRequest $request)
    {
        $userId = Auth::id() ?? session('user_id', 1);

        $validated = $request->validated();

        $order = $this->orderService->createOrder($userId, $validated);

        return redirect()->route('user.payment.success')
            ->with('success', 'Pesanan berhasil dibuat!');
    }

    /**
     * Cancel order
     * Business logic delegated to Service
     */
    public function cancel(string $orderId)
    {
        $userId = Auth::id() ?? session('user_id', 1);

        try {
            $this->orderService->cancelOrder($userId, $orderId);

            return redirect()->route('user.orders.history')
                ->with('success', 'Pesanan berhasil dibatalkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
