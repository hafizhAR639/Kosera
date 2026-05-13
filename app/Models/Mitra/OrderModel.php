<?php

namespace App\Models\Mitra;

use App\Core\Database;

class OrderModel
{
    private \mysqli $conn;

    public function __construct()
    {
        $this->conn = Database::connection();
    }

    public function getIncomingOrders(int $userId): array
    {
        $sql = "SELECT o.id, o.order_code, o.customer_name, o.alamat_lengkap, o.total_harga, o.tanggal_order, o.status, s.nama_layanan
                FROM orders o
                JOIN services s ON o.service_id = s.id
                WHERE o.user_id = ? AND o.status IN ('pending', 'confirmed', 'in_progress')
                ORDER BY o.created_at DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function updateIncomingOrderStatus(int $userId, int $orderId, string $status): bool
    {
        $sql = 'UPDATE orders SET status = ? WHERE id = ? AND user_id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sii', $status, $orderId, $userId);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

    public function getHistory(int $userId, string $statusFilter, string $dateFrom, string $dateTo): array
    {
        $sql = "SELECT o.*, s.nama_layanan
                FROM orders o
                JOIN services s ON o.service_id = s.id
                WHERE o.user_id = ?";

        $params = [$userId];
        $types = 'i';

        if ($statusFilter !== 'all') {
            $sql .= ' AND o.status = ?';
            $params[] = $statusFilter;
            $types .= 's';
        }

        if ($dateFrom !== '') {
            $sql .= ' AND o.tanggal_order >= ?';
            $params[] = $dateFrom;
            $types .= 's';
        }

        if ($dateTo !== '') {
            $sql .= ' AND o.tanggal_order <= ?';
            $params[] = $dateTo;
            $types .= 's';
        }

        $sql .= ' ORDER BY o.created_at DESC';

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getHistoryStats(int $userId): array
    {
        $sql = "SELECT
            COUNT(*) as total_orders,
            SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed,
            SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = 'cancelled' THEN 1 ELSE 0 END) as cancelled,
            SUM(CASE WHEN status = 'completed' THEN total_harga ELSE 0 END) as total_revenue
            FROM orders WHERE user_id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc() ?: [];
    }

    public function getHistoryForExport(int $userId, string $statusFilter, string $dateFrom, string $dateTo): array
    {
        $sql = "SELECT o.order_code, o.tanggal_order, s.nama_layanan, o.customer_name, o.alamat_lengkap, o.total_harga, o.status, o.rating
                FROM orders o
                JOIN services s ON o.service_id = s.id
                WHERE o.user_id = ?";

        $params = [$userId];
        $types = 'i';

        if ($statusFilter !== 'all') {
            $sql .= ' AND o.status = ?';
            $params[] = $statusFilter;
            $types .= 's';
        }

        if ($dateFrom !== '') {
            $sql .= ' AND o.tanggal_order >= ?';
            $params[] = $dateFrom;
            $types .= 's';
        }

        if ($dateTo !== '') {
            $sql .= ' AND o.tanggal_order <= ?';
            $params[] = $dateTo;
            $types .= 's';
        }

        $sql .= ' ORDER BY o.created_at DESC';

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
