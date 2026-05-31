<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Services\OrderService;
use Illuminate\Http\Request;
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
            : \App\Models\Order::byUser($userId)
                ->withDetails()
                ->latest('created_at')
                ->firstOrFail();

        return view('user.detail-pesanan', ['order' => $order]);
    }

    /**
     * Create new order (redirect to confirmation)
     * Validate service exists, then redirect
     */
    public function create(Request $request)
    {
        $serviceId = $request->query('service_id');
        Service::findOrFail($serviceId);

        return redirect()->route('user.order.confirm', ['service_id' => $serviceId]);
    }

    /**
     * Store order
     * Validation → Service → Redirect
     */
    public function store(Request $request)
    {
        $userId = Auth::id() ?? session('user_id', 1);

        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'required|email',
            'alamat_lengkap' => 'required|string',
            'catatan_customer' => 'nullable|string|max:1000',
        ]);

        $order = $this->orderService->createOrder($userId, $validated);

        return redirect()->route('user.order.confirm', ['order_id' => $order->id])
            ->with('success', 'Pesanan berhasil dibuat! Lanjutkan ke pembayaran.');
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
