<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\Models\Certificate;
use App\Models\Portfolio;
use App\Models\Point;
use Illuminate\Support\Carbon;

class MitraRepository
{
    public function getUserById(int $mitraId): ?array
    {
        $user = User::find($mitraId);
        return $user ? $user->toArray() : null;
    }

    public function getStats(int $mitraId): array
    {
        $now = Carbon::now();

        $totalServices = Service::where('user_id', $mitraId)->count();

        $monthlyOrders = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))
            ->whereMonth('tanggal_order', $now->month)
            ->whereYear('tanggal_order', $now->year)
            ->count();

        $totalOrders = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))->count();

        $completedOrders = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))->where('status', 'completed')->count();
        $pendingOrders = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))->where('status', 'pending')->count();
        $confirmedOrders = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))->where('status', 'confirmed')->count();
        $inProgressOrders = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))->where('status', 'in_progress')->count();

        $totalRevenue = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))
            ->where('status', 'completed')
            ->sum('total_harga');

        $totalCertificates = Certificate::where('user_id', $mitraId)->count();
        $verifiedCertificates = Certificate::where('user_id', $mitraId)->where('status_verifikasi', 'verified')->count();

        $totalPortfolio = Portfolio::where('user_id', $mitraId)->count();
        $publishedPortfolio = Portfolio::where('user_id', $mitraId)->where('status', 'published')->count();

        $totalPoints = Point::where('user_id', $mitraId)->sum('points');

        return [
            'total_services' => (int) $totalServices,
            'monthly_orders' => (int) $monthlyOrders,
            'total_orders' => (int) $totalOrders,
            'completed_orders' => (int) $completedOrders,
            'pending_orders' => (int) $pendingOrders,
            'confirmed_orders' => (int) $confirmedOrders,
            'in_progress_orders' => (int) $inProgressOrders,
            'total_revenue' => (float) $totalRevenue,
            'total_certificates' => (int) $totalCertificates,
            'verified_certificates' => (int) $verifiedCertificates,
            'total_portfolio' => (int) $totalPortfolio,
            'published_portfolio' => (int) $publishedPortfolio,
            'total_points' => (int) $totalPoints,
        ];
    }

    public function getRecentOrders(int $mitraId, int $limit = 5): array
    {
        $rows = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))
            ->with(['service:id,nama_layanan', 'user:id,nama'])
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->map(fn($o) => [
                'order_code' => $o->order_code,
                'tanggal_order' => $o->tanggal_order,
                'customer_name' => $o->customer_name,
                'status' => $o->status,
                'total_harga' => $o->total_harga,
                'nama_layanan' => $o->service?->nama_layanan ?? null,
            ])
            ->toArray();

        return $rows;
    }

    public function getRecentCertificates(int $mitraId, int $limit = 4): array
    {
        $rows = Certificate::where('user_id', $mitraId)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->nama_sertifikat,
                'issued_by' => $c->penerbit,
                'category' => $c->kategori,
                'status' => $c->status_verifikasi,
                'issued_date' => $c->tanggal_terbit,
            ])
            ->toArray();

        return $rows;
    }

    public function getRecentPortfolio(int $mitraId, int $limit = 4): array
    {
        $rows = Portfolio::where('user_id', $mitraId)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->map(fn($p) => [
                'id' => $p->id,
                'title' => $p->judul,
                'category' => $p->kategori,
                'rating' => $p->rating,
                'status' => $p->status,
                'project_date' => $p->tanggal_project,
            ])
            ->toArray();

        return $rows;
    }

    public function getIncomingOrders(int $mitraId): array
    {
        $rows = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))
            ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
            ->with(['service:id,nama_layanan', 'user:id,nama'])
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($o) => [
                'id' => $o->id,
                'order_code' => $o->order_code,
                'customer_name' => $o->customer_name,
                'alamat_lengkap' => $o->alamat_lengkap,
                'total_harga' => $o->total_harga,
                'tanggal_order' => $o->tanggal_order,
                'status' => $o->status,
                'nama_layanan' => $o->service?->nama_layanan ?? null,
            ])
            ->toArray();

        return $rows;
    }

    public function updateIncomingOrderStatus(int $mitraId, int $orderId, string $status): bool
    {
        $order = Order::find($orderId);
        if (! $order || $order->service?->user_id !== $mitraId) {
            return false;
        }

        $order->status = $status;
        return $order->save();
    }

    // Certificates CRUD
    public function getCertificates(int $mitraId, string $category = '', string $search = '', int $limit = 20, int $offset = 0): array
    {
        $query = Certificate::where('user_id', $mitraId);
        if ($category !== '' && $category !== 'all') {
            $query->where('kategori', $category);
        }
        if ($search !== '') {
            $query->where('nama_sertifikat', 'like', "%$search%");
        }

        return $query->orderByDesc('tanggal_terbit')->skip($offset)->take($limit)->get()->toArray();
    }

    public function countCertificates(int $mitraId, string $category = '', string $search = ''): int
    {
        $query = Certificate::where('user_id', $mitraId);
        if ($category !== '' && $category !== 'all') {
            $query->where('kategori', $category);
        }
        if ($search !== '') {
            $query->where('nama_sertifikat', 'like', "%$search%");
        }

        return $query->count();
    }

    public function createCertificate(int $mitraId, array $payload): bool
    {
        $payload['user_id'] = $mitraId;
        return (bool) Certificate::create($payload);
    }

    public function updateCertificate(int $mitraId, int $id, array $payload): bool
    {
        $cert = Certificate::where('id', $id)->where('user_id', $mitraId)->first();
        if (! $cert) return false;
        return $cert->update($payload);
    }

    public function deleteCertificate(int $mitraId, int $id): bool
    {
        return Certificate::where('id', $id)->where('user_id', $mitraId)->delete() > 0;
    }

    // Portfolio CRUD
    public function getPortfolio(int $mitraId, string $category = '', string $search = '', int $limit = 20, int $offset = 0): array
    {
        $query = Portfolio::where('user_id', $mitraId);
        if ($category !== '' && $category !== 'all') $query->where('kategori', $category);
        if ($search !== '') $query->where('judul', 'like', "%$search%");

        return $query->orderByDesc('tanggal_project')->skip($offset)->take($limit)->get()->toArray();
    }

    public function countPortfolio(int $mitraId, string $category = '', string $search = ''): int
    {
        $query = Portfolio::where('user_id', $mitraId);
        if ($category !== '' && $category !== 'all') $query->where('kategori', $category);
        if ($search !== '') $query->where('judul', 'like', "%$search%");
        return $query->count();
    }

    public function createPortfolio(int $mitraId, array $payload): bool
    {
        $payload['user_id'] = $mitraId;
        return (bool) Portfolio::create($payload);
    }

    public function updatePortfolio(int $mitraId, int $id, array $payload): bool
    {
        $p = Portfolio::where('id', $id)->where('user_id', $mitraId)->first();
        if (! $p) return false;
        return $p->update($payload);
    }

    public function deletePortfolio(int $mitraId, int $id): bool
    {
        return Portfolio::where('id', $id)->where('user_id', $mitraId)->delete() > 0;
    }

    // Profile
    public function getProfile(int $mitraId): ?array
    {
        $user = User::find($mitraId);
        return $user ? $user->toArray() : null;
    }

    public function updateProfile(int $mitraId, array $payload): bool
    {
        $user = User::find($mitraId);
        if (! $user) return false;
        return $user->update($payload);
    }

    // Order history
    public function getOrderHistory(int $mitraId, string $statusFilter = 'all', string $dateFrom = '', string $dateTo = ''): array
    {
        $query = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))->with(['service:id,nama_layanan']);

        if ($statusFilter !== 'all') $query->where('status', $statusFilter);
        if ($dateFrom !== '') $query->whereDate('tanggal_order', '>=', $dateFrom);
        if ($dateTo !== '') $query->whereDate('tanggal_order', '<=', $dateTo);

        return $query->orderByDesc('created_at')->get()->map(fn($o) => $o->toArray())->toArray();
    }

    public function getOrderHistoryStats(int $mitraId): array
    {
        $query = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId));

        return [
            'total_orders' => (int) $query->count(),
            'completed' => (int) $query->where('status', 'completed')->count(),
            'pending' => (int) $query->where('status', 'pending')->count(),
            'cancelled' => (int) $query->where('status', 'cancelled')->count(),
            'total_revenue' => (float) $query->where('status', 'completed')->sum('total_harga'),
        ];
    }

    public function getOrderHistoryForExport(int $mitraId, string $statusFilter = 'all', string $dateFrom = '', string $dateTo = ''): array
    {
        $query = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))->with(['service:id,nama_layanan']);
        if ($statusFilter !== 'all') $query->where('status', $statusFilter);
        if ($dateFrom !== '') $query->whereDate('tanggal_order', '>=', $dateFrom);
        if ($dateTo !== '') $query->whereDate('tanggal_order', '<=', $dateTo);

        return $query->orderByDesc('created_at')->get()->map(fn($o) => $o->toArray())->toArray();
    }
}
