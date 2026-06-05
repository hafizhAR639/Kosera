<?php

namespace App\Repositories;

use App\Models\BankAccount;
use App\Models\Earning;
use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\Models\Certificate;
use App\Models\Portfolio;
use App\Models\Point;
use Illuminate\Support\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

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
            'services_count' => (int) $totalServices,
            'monthly_orders' => (int) $monthlyOrders,
            'total_orders' => (int) $totalOrders,
            'completed_orders' => (int) $completedOrders,
            'pending_orders' => (int) $pendingOrders,
            'confirmed_orders' => (int) $confirmedOrders,
            'in_progress_orders' => (int) $inProgressOrders,
            'total_revenue' => (float) $totalRevenue,
            'total_income' => (float) $totalRevenue,
            'total_certificates' => (int) $totalCertificates,
            'verified_certificates' => (int) $verifiedCertificates,
            'total_portfolio' => (int) $totalPortfolio,
            'published_portfolio' => (int) $publishedPortfolio,
            'total_points' => (int) $totalPoints,
            'points' => (int) $totalPoints,
        ];
    }

    public function getRevenueChart(int $mitraId, int $months = 6): array
    {
        $labels = [];
        $data = [];

        for ($i = $months - 1; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->format('M');

            $sum = Earning::where('user_id', $mitraId)
                ->where('status', ['pending','paid'])
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('jumlah');

            $data[] = (float) $sum;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    public function getRecentOrders(int $mitraId, int $limit = 5): array
    {
        return Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))
            ->with(['service:id,nama_layanan', 'user:id,nama'])
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get()
            ->map(fn($o) => [
                'order_code' => $o->order_code,
                'order_date' => $o->tanggal_order,
                'customer_name' => $o->customer_name,
                'status' => $o->status,
                'total_price' => (float) $o->total_harga,
                'service_name' => $o->service?->nama_layanan ?? null,
            ])
            ->toArray();
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
        return Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))
            ->whereIn('status', ['pending', 'confirmed', 'in_progress'])
            ->with(['service:id,nama_layanan', 'user:id,nama'])
            ->orderByDesc('created_at')
            ->get()
            ->map(fn($o) => [
                'id' => $o->id,
                'order_code' => $o->order_code,
                'customer_name' => $o->customer_name,
                'service_type' => $o->service?->kategori ?? 'Umum',
                'service_name' => $o->service?->nama_layanan ?? null,
                'address' => $o->alamat_lengkap,
                'total_price' => (float) $o->total_harga,
                'order_date' => $o->created_at?->format('Y-m-d'),
                'status' => $o->status,
                'phone' => $o->customer_phone,
                'email' => $o->customer_email,
                'notes' => $o->catatan_customer,
            ])
            ->toArray();
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

        return $query->orderByDesc('tanggal_terbit')
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(fn($c) => [
                'id' => $c->id,
                'name' => $c->nama_sertifikat,
                'issued_by' => $c->penerbit,
                'issued_date' => $c->tanggal_terbit,
                'expiry_date' => $c->tanggal_kadaluarsa,
                'certificate_number' => $c->nomor_sertifikat,
                'category' => $c->kategori,
                'status' => $c->status_verifikasi,
                'file_path' => $c->file_path,
            ])
            ->toArray();
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
        $payload = [
            'nama_sertifikat' => $payload['name'] ?? $payload['nama_sertifikat'] ?? '',
            'penerbit' => $payload['issued_by'] ?? $payload['penerbit'] ?? '',
            'tanggal_terbit' => $payload['issued_date'] ?? $payload['tanggal_terbit'] ?? null,
            'tanggal_kadaluarsa' => $payload['expiry_date'] ?? $payload['tanggal_kadaluarsa'] ?? null,
            'nomor_sertifikat' => $payload['certificate_number'] ?? $payload['nomor_sertifikat'] ?? null,
            'kategori' => $payload['category'] ?? $payload['kategori'] ?? 'lainnya',
            'file_path' => $payload['file_path'] ?? null,
            'status_verifikasi' => $payload['status_verifikasi'] ?? 'pending',
        ];
        $payload['user_id'] = $mitraId;
        return (bool) Certificate::create($payload);
    }

    public function updateCertificate(int $mitraId, int $id, array $payload): bool
    {
        $payload = [
            'nama_sertifikat' => $payload['name'] ?? $payload['nama_sertifikat'] ?? '',
            'penerbit' => $payload['issued_by'] ?? $payload['penerbit'] ?? '',
            'tanggal_terbit' => $payload['issued_date'] ?? $payload['tanggal_terbit'] ?? null,
            'tanggal_kadaluarsa' => $payload['expiry_date'] ?? $payload['tanggal_kadaluarsa'] ?? null,
            'nomor_sertifikat' => $payload['certificate_number'] ?? $payload['nomor_sertifikat'] ?? null,
            'kategori' => $payload['category'] ?? $payload['kategori'] ?? 'lainnya',
            'file_path' => $payload['file_path'] ?? null,
        ];
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

    public function paginatePortfolio(int $mitraId, array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        $category = $filters['category'] ?? 'all';
        $search = $filters['q'] ?? '';

        return Portfolio::query()
            ->where('user_id', $mitraId)
            ->when($category !== 'all', fn($q) => $q->where('kategori', $category))
            ->when($search !== '', fn($q) => $q->where('judul', 'like', "%{$search}%"))
            ->orderByDesc('tanggal_project')
            ->paginate($perPage);
    }

    public function findPortfolioByUser(int $mitraId, int $portfolioId): Portfolio
    {
        return Portfolio::where('id', $portfolioId)
            ->where('user_id', $mitraId)
            ->firstOrFail();
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

    public function getBankAccount(int $mitraId): ?array
    {
        $bank = BankAccount::where('user_id', $mitraId)->first();
        return $bank ? $bank->toArray() : null;
    }

    public function upsertBankAccount(int $mitraId, array $payload): array
    {
        $bank = BankAccount::updateOrCreate(
            ['user_id' => $mitraId],
            [
                'nama_bank' => $payload['nama_bank'] ?? '',
                'nama_rekening' => $payload['nama_rekening'] ?? '',
                'nomor_rekening' => $payload['nomor_rekening'] ?? '',
                'alamat_bank' => $payload['alamat_bank'] ?? null,
            ]
        );

        return $bank->toArray();
    }

    public function updateProfile(int $mitraId, array $payload): bool
    {
        $user = User::find($mitraId);
        if (! $user) return false;
        $payload = array_intersect_key($payload, array_flip([
            'nama', 'phone', 'location', 'bio', 'avatar'
        ]));
        return $user->update($payload);
    }

    // Order history
    public function getOrderHistory(int $mitraId, string $statusFilter = 'all', string $dateFrom = '', string $dateTo = ''): array
    {
        $query = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))
            ->with(['service:id,nama_layanan']);

        if ($statusFilter !== 'all') $query->where('status', $statusFilter);
        if ($dateFrom !== '') $query->whereDate('tanggal_order', '>=', $dateFrom);
        if ($dateTo !== '') $query->whereDate('tanggal_order', '<=', $dateTo);

        return $query->orderByDesc('created_at')
            ->get()
            ->map(fn($o) => [
                'order_code' => $o->order_code,
                'customer_name' => $o->customer_name,
                'service_name' => $o->service?->nama_layanan ?? '-',
                'total_price' => (float) ($o->total_harga ?? 0),
                'order_date' => $o->tanggal_order ?? $o->created_at,
                'status' => $o->status,
            ])
            ->toArray();
    }

    public function getOrderHistoryStats(int $mitraId): array
    {
        $baseQuery = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId));

        return [
            'total_orders' => (int) (clone $baseQuery)->count(),
            'completed' => (int) (clone $baseQuery)->where('status', 'completed')->count(),
            'pending' => (int) (clone $baseQuery)->where('status', 'pending')->count(),
            'cancelled' => (int) (clone $baseQuery)->where('status', 'cancelled')->count(),
            'total_revenue' => (float) (clone $baseQuery)->where('status', 'completed')->sum('total_harga'),
        ];
    }

    public function getOrderHistoryForExport(int $mitraId, string $statusFilter = 'all', string $dateFrom = '', string $dateTo = ''): array
    {
        $query = Order::whereHas('service', fn($q) => $q->where('user_id', $mitraId))
            ->with(['service:id,nama_layanan']);
        if ($statusFilter !== 'all') $query->where('status', $statusFilter);
        if ($dateFrom !== '') $query->whereDate('tanggal_order', '>=', $dateFrom);
        if ($dateTo !== '') $query->whereDate('tanggal_order', '<=', $dateTo);

        return $query->orderByDesc('created_at')
            ->get()
            ->map(fn($o) => [
                'order_code' => $o->order_code,
                'customer_name' => $o->customer_name,
                'service_name' => $o->service?->nama_layanan ?? '-',
                'total_price' => (float) ($o->total_harga ?? 0),
                'order_date' => $o->tanggal_order ?? $o->created_at,
                'status' => $o->status,
            ])
            ->toArray();
    }

    // Layanan CRUD for Laravel Mitra controller
    public function paginateServices(int $mitraId, array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        $category = $filters['category'] ?? 'all';
        $search = $filters['q'] ?? '';

        return Service::query()
            ->where('user_id', $mitraId)
            ->when($category !== 'all', fn($q) => $q->where('kategori', $category))
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('nama_layanan', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('created_at')
            ->paginate($perPage);
    }

    public function createService(int $mitraId, array $payload): Service
    {
        $payload['user_id'] = $mitraId;
        return Service::create($payload);
    }

    public function findServiceByUser(int $mitraId, int $serviceId): Service
    {
        return Service::where('id', $serviceId)
            ->where('user_id', $mitraId)
            ->firstOrFail();
    }

    public function updateService(int $mitraId, int $serviceId, array $payload): bool
    {
        $service = $this->findServiceByUser($mitraId, $serviceId);
        return $service->update($payload);
    }

    public function deleteService(int $mitraId, int $serviceId): bool
    {
        $service = $this->findServiceByUser($mitraId, $serviceId);
        return (bool) $service->delete();
    }
}
