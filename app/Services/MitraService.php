<?php

namespace App\Services;

use App\Repositories\MitraRepository;

class MitraService
{
    public function __construct(private MitraRepository $repo) {}

    public function getUserById(int $mitraId): ?array
    {
        return $this->repo->getUserById($mitraId);
    }

    public function getStats(int $mitraId): array
    {
        return $this->repo->getStats($mitraId);
    }

    public function getRecentOrders(int $mitraId, int $limit = 5): array
    {
        return $this->repo->getRecentOrders($mitraId, $limit);
    }

    public function getRecentCertificates(int $mitraId, int $limit = 4): array
    {
        return $this->repo->getRecentCertificates($mitraId, $limit);
    }

    public function getRecentPortfolio(int $mitraId, int $limit = 4): array
    {
        return $this->repo->getRecentPortfolio($mitraId, $limit);
    }

    public function getIncomingOrders(int $mitraId): array
    {
        return $this->repo->getIncomingOrders($mitraId);
    }

    public function updateIncomingOrderStatus(int $mitraId, int $orderId, string $status): bool
    {
        return $this->repo->updateIncomingOrderStatus($mitraId, $orderId, $status);
    }

    // Certificates
    public function getCertificates(int $mitraId, string $category = '', string $search = '', int $limit = 20, int $offset = 0): array
    {
        return $this->repo->getCertificates($mitraId, $category, $search, $limit, $offset);
    }

    public function countCertificates(int $mitraId, string $category = '', string $search = ''): int
    {
        return $this->repo->countCertificates($mitraId, $category, $search);
    }

    public function createCertificate(int $mitraId, array $payload): bool
    {
        return $this->repo->createCertificate($mitraId, $payload);
    }

    public function updateCertificate(int $mitraId, int $id, array $payload): bool
    {
        return $this->repo->updateCertificate($mitraId, $id, $payload);
    }

    public function deleteCertificate(int $mitraId, int $id): bool
    {
        return $this->repo->deleteCertificate($mitraId, $id);
    }

    // Portfolio
    public function getPortfolio(int $mitraId, string $category = '', string $search = '', int $limit = 20, int $offset = 0): array
    {
        return $this->repo->getPortfolio($mitraId, $category, $search, $limit, $offset);
    }

    public function countPortfolio(int $mitraId, string $category = '', string $search = ''): int
    {
        return $this->repo->countPortfolio($mitraId, $category, $search);
    }

    public function createPortfolio(int $mitraId, array $payload): bool
    {
        return $this->repo->createPortfolio($mitraId, $payload);
    }

    public function updatePortfolio(int $mitraId, int $id, array $payload): bool
    {
        return $this->repo->updatePortfolio($mitraId, $id, $payload);
    }

    public function deletePortfolio(int $mitraId, int $id): bool
    {
        return $this->repo->deletePortfolio($mitraId, $id);
    }

    // Profile
    public function getProfile(int $mitraId): ?array
    {
        return $this->repo->getProfile($mitraId);
    }

    public function updateProfile(int $mitraId, array $payload): bool
    {
        return $this->repo->updateProfile($mitraId, $payload);
    }

    // Order history
    public function getOrderHistory(int $mitraId, string $statusFilter = 'all', string $dateFrom = '', string $dateTo = ''): array
    {
        return $this->repo->getOrderHistory($mitraId, $statusFilter, $dateFrom, $dateTo);
    }

    public function getOrderHistoryStats(int $mitraId): array
    {
        return $this->repo->getOrderHistoryStats($mitraId);
    }

    public function getOrderHistoryForExport(int $mitraId, string $statusFilter = 'all', string $dateFrom = '', string $dateTo = ''): array
    {
        return $this->repo->getOrderHistoryForExport($mitraId, $statusFilter, $dateFrom, $dateTo);
    }
}
