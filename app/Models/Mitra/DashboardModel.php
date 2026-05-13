<?php

namespace App\Models\Mitra;

use App\Core\Database;

class DashboardModel
{
    private \mysqli $conn;

    public function __construct()
    {
        $this->conn = Database::connection();
    }

    public function getUserById(int $userId): ?array
    {
        $sql = 'SELECT * FROM users WHERE id = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result ?: null;
    }

    public function getStats(int $userId): array
    {
        $sql = "SELECT
            (SELECT COUNT(*) FROM services WHERE user_id = ?) AS total_services,
            (SELECT COUNT(*) FROM orders WHERE user_id = ? AND MONTH(tanggal_order) = MONTH(CURRENT_DATE) AND YEAR(tanggal_order) = YEAR(CURRENT_DATE)) AS monthly_orders,
            (SELECT COUNT(*) FROM orders WHERE user_id = ?) AS total_orders,
            (SELECT COUNT(*) FROM orders WHERE user_id = ? AND status = 'completed') AS completed_orders,
            (SELECT COUNT(*) FROM orders WHERE user_id = ? AND status = 'pending') AS pending_orders,
            (SELECT COUNT(*) FROM orders WHERE user_id = ? AND status = 'confirmed') AS confirmed_orders,
            (SELECT COUNT(*) FROM orders WHERE user_id = ? AND status = 'in_progress') AS in_progress_orders,
            (SELECT COALESCE(SUM(total_harga), 0) FROM orders WHERE user_id = ? AND status = 'completed') AS total_revenue,
            (SELECT COUNT(*) FROM certificates WHERE user_id = ?) AS total_certificates,
            (SELECT COUNT(*) FROM certificates WHERE user_id = ? AND status_verifikasi = 'verified') AS verified_certificates,
            (SELECT COUNT(*) FROM portfolio WHERE user_id = ?) AS total_portfolio,
            (SELECT COUNT(*) FROM portfolio WHERE user_id = ? AND status = 'published') AS published_portfolio,
            (SELECT COALESCE(SUM(points), 0) FROM points WHERE user_id = ?) AS total_points";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            'iiiiiiiiiiiii',
            $userId,
            $userId,
            $userId,
            $userId,
            $userId,
            $userId,
            $userId,
            $userId,
            $userId,
            $userId,
            $userId,
            $userId,
            $userId
        );
        $stmt->execute();

        return $stmt->get_result()->fetch_assoc() ?: [];
    }

    public function getRecentOrders(int $userId, int $limit = 5): array
    {
        $sql = "SELECT o.order_code, o.tanggal_order, o.customer_name, o.status, o.total_harga, s.nama_layanan
                FROM orders o
                JOIN services s ON o.service_id = s.id
                WHERE o.user_id = ?
                ORDER BY o.created_at DESC
                LIMIT ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $userId, $limit);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getRecentCertificates(int $userId, int $limit = 4): array
    {
        $sql = "SELECT id, nama_sertifikat, penerbit, kategori, status_verifikasi, tanggal_terbit
                FROM certificates
                WHERE user_id = ?
                ORDER BY created_at DESC
                LIMIT ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $userId, $limit);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getRecentPortfolio(int $userId, int $limit = 4): array
    {
        $sql = "SELECT id, judul, kategori, rating, status, tanggal_project
                FROM portfolio
                WHERE user_id = ?
                ORDER BY created_at DESC
                LIMIT ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $userId, $limit);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
