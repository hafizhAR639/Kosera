<?php

namespace App\Services;

use App\Repositories\MitraRepository;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Storage;

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

    public function getRevenueChart(int $mitraId, int $months = 6): array
    {
        return $this->repo->getRevenueChart($mitraId, $months);
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

    public function paginatePortfolio(int $mitraId, array $filters = [], int $perPage = 9)
    {
        return $this->repo->paginatePortfolio($mitraId, $filters, $perPage);
    }

    public function findPortfolioByUser(int $mitraId, int $portfolioId)
    {
        return $this->repo->findPortfolioByUser($mitraId, $portfolioId);
    }

    public function countPortfolio(int $mitraId, string $category = '', string $search = ''): int
    {
        return $this->repo->countPortfolio($mitraId, $category, $search);
    }

    public function createPortfolio(int $mitraId, array $payload): bool
    {
            return $this->repo->createPortfolio($mitraId, $payload);
    }

        public function createPortfolioWithFile(int $mitraId, array $payload, ?\Illuminate\Http\UploadedFile $cover = null): bool
        {
            if ($cover) {
                $path = $cover->store('portfolio', 'public');
                $payload['foto_cover'] = '/storage/' . $path;
            }

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

    public function updatePortfolioWithFile(int $mitraId, int $id, array $payload, ?\Illuminate\Http\UploadedFile $cover = null): bool
    {
        $p = Portfolio::where('id', $id)->where('user_id', $mitraId)->first();
        if (! $p) return false;

        if ($cover) {
            // delete previous
            if (! empty($p->foto_cover)) {
                $prev = ltrim(str_replace('/storage/', '', $p->foto_cover), '/');
                try { \Illuminate\Support\Facades\Storage::disk('public')->delete($prev); } catch (\Throwable $e) {}
            }
            $path = $cover->store('portfolio', 'public');
            $payload['foto_cover'] = '/storage/' . $path;
        }

        return $p->update($payload);
    }

    // Profile
    public function getProfile(int $mitraId): ?array
    {
        return $this->repo->getProfile($mitraId);
    }

    public function getBankAccount(int $mitraId): ?array
    {
        return $this->repo->getBankAccount($mitraId);
    }

    public function upsertBankAccount(int $mitraId, array $payload): array
    {
        return $this->repo->upsertBankAccount($mitraId, $payload);
    }

    public function updateProfile(int $mitraId, array $payload): bool
    {
        return $this->repo->updateProfile($mitraId, $payload);
    }

    public function updateProfileWithBank(int $mitraId, array $profilePayload, ?\Illuminate\Http\UploadedFile $avatar = null, ?array $bankPayload = null): bool
    {
        if ($avatar) {
            $path = $avatar->store('avatars', 'public');
            $profilePayload['avatar'] = '/storage/' . $path;
        }

        $updated = $this->repo->updateProfile($mitraId, $profilePayload);

        if ($bankPayload && (
            (!empty($bankPayload['nama_bank'] ?? '')) || (!empty($bankPayload['nama_rekening'] ?? '')) || (!empty($bankPayload['nomor_rekening'] ?? ''))
        )) {
            $this->repo->upsertBankAccount($mitraId, $bankPayload);
        }

        return $updated;
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

    public function paginateServices(int $mitraId, array $filters = [], int $perPage = 9)
    {
        return $this->repo->paginateServices($mitraId, $filters, $perPage);
    }

    public function createService(int $mitraId, array $payload, ?string $portfolioImagePath = null)
    {
        $service = $this->repo->createService($mitraId, $payload);

        if ($portfolioImagePath) {
            $portfolioPayload = [
                'judul' => $payload['nama_layanan'] ?? ($payload['name'] ?? null),
                'deskripsi' => $payload['deskripsi'] ?? null,
                'kategori' => $payload['kategori'] ?? null,
                'foto_cover' => $portfolioImagePath,
                'status' => 'published',
            ];

            $this->repo->createPortfolio($mitraId, $portfolioPayload);
        }

        return $service;
    }

    public function findServiceByUser(int $mitraId, int $serviceId)
    {
        return $this->repo->findServiceByUser($mitraId, $serviceId);
    }

    public function updateService(int $mitraId, int $serviceId, array $payload): bool
    {
        return $this->repo->updateService($mitraId, $serviceId, $payload);
    }

    public function deleteService(int $mitraId, int $serviceId): bool
    {
        return $this->repo->deleteService($mitraId, $serviceId);
    }
}
