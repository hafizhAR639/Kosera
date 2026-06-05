<?php

namespace App\Services;

use App\Repositories\OrderRepository;

class OrderService
{
    public function __construct(private OrderRepository $repository) {}

    /**
     * Get user's order history with statistics
     */
    public function getUserHistory(int $userId, array $filters = [])
    {
        return $this->repository->getUserOrdersWithStats($userId, $filters);
    }

    /**
     * Get single order detail
     */
    public function getOrderDetail(int $userId, string $orderId)
    {
        return $this->repository->getUserOrderDetail($userId, $orderId);
    }

    public function getLatestOrderForUser(int $userId)
    {
        return $this->repository->getLatestOrderForUser($userId);
    }

    public function ensureServiceExists(int $serviceId)
    {
        return \App\Models\Service::findOrFail($serviceId);
    }

    /**
     * Cancel a pending order
     */
    public function cancelOrder(int $userId, string $orderId): bool
    {
        $order = $this->repository->getUserOrderDetail($userId, $orderId);

        if ($order->status !== 'pending') {
            throw new \Exception('Hanya pesanan tertunda yang bisa dibatalkan.');
        }

        return $order->update(['status' => 'cancelled']);
    }

    /**
     * Create new order
     */
    public function createOrder(int $userId, array $validated)
    {
        $service = \App\Models\Service::findOrFail($validated['service_id']);

        $orderCode = 'KSR-' . now()->format('YmdHis') . '-' . rand(100, 999);

        return \App\Models\Order::create([
            'order_code' => $orderCode,
            'user_id' => $userId,
            'service_id' => $validated['service_id'],
            'customer_name' => $validated['customer_name'],
            'customer_phone' => $validated['customer_phone'],
            'customer_email' => $validated['customer_email'],
            'alamat_lengkap' => $validated['alamat_lengkap'],
            'catatan_customer' => $validated['catatan_customer'] ?? null,
            'tanggal_order' => now(),
            'total_harga' => $validated['total_harga'],
            'status' => 'pending',
            'payment_status' => 'unpaid',
        ]);
    }
}
