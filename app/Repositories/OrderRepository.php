<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Pagination\Paginator;

class OrderRepository
{
    /**
     * Get user's orders with stats
     * Returns: ['orders' => paginator, 'stats' => array]
     */
    public function getUserOrdersWithStats(int $userId, array $filters = []): array
    {
        $status = $filters['status'] ?? 'all';

        // Build base query
        $baseQuery = Order::byUser($userId);

        // Get orders (return Eloquent models for existing Blade views)
        $orders = Order::byUser($userId)
            ->withDetails()
            ->when($status !== 'all', fn($q) => $q->byStatus($status))
            ->latest('created_at')
            ->paginate(10);

        // Get stats (single query with aggregation)
        $stats = Order::byUser($userId)
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = ? THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = ? THEN total_harga ELSE 0 END) as total_spent
            ', ['completed', 'pending', 'completed'])
            ->first();

        return [
            'orders' => $orders,
            'stats' => [
                'total' => (int) ($stats->total ?? 0),
                'completed' => (int) ($stats->completed ?? 0),
                'pending' => (int) ($stats->pending ?? 0),
                'total_spent' => (float) ($stats->total_spent ?? 0),
            ],
        ];
    }

    /**
     * Get single order detail for user
     */
    public function getUserOrderDetail(int $userId, string $orderId): Order
    {
        return Order::byUser($userId)
            ->withDetails()
            ->findOrFail($orderId);
    }

    /**
     * Get latest order for user
     */
    public function getLatestOrderForUser(int $userId): Order
    {
        return Order::byUser($userId)
            ->withDetails()
            ->latest('created_at')
            ->firstOrFail();
    }

    /**
     * Transform Eloquent model to array for blade view
     * Maps model attributes to view's expected keys
     */
    private function mapOrderForView(Order $order): array
    {
        return [
            'order' => $order->id,
            'order_code' => $order->order_code,
            'service_type' => $order->service?->kategori ?? 'Layanan',
            'service_name' => $order->service?->nama_layanan ?? 'Layanan',
            'address' => $order->alamat_lengkap,
            'order_date' => $order->tanggal_order,
            'status' => $order->status,
            'total_price' => $order->total_harga,
            'rated' => $order->isRated(),
        ];
    }
}
