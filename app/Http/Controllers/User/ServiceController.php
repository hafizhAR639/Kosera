<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Browse all services dari mitra
     * KISS: Simple pagination + filter by category
     */
    public function index(Request $request)
    {
        $search = $request->query('search', '');
        $category = $request->query('category', 'all');
        $page = $request->query('page', 1);
        $perPage = 12;

        $query = Service::where('status', 'active')
            ->with(['user:id,nama,phone,location']);

        // Filter by category
        if ($category !== 'all') {
            $query->where('kategori', $category);
        }

        // Search by name or description
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_layanan', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $services = $query->latest('views')->paginate($perPage);

        // Get unique categories
        $categories = Service::where('status', 'active')
            ->select('kategori')
            ->distinct()
            ->pluck('kategori');

        return view('user.services.index', [
            'services' => $services,
            'categories' => $categories,
            'filters' => [
                'search' => $search,
                'category' => $category,
            ],
        ]);
    }

    /**
     * Show mitra detail with all services
     * KISS: Single mitra + their services
     */
    public function showMitra(string $mitraId)
    {
        $mitra = User::findOrFail($mitraId);
        $services = Service::where('user_id', $mitraId)
            ->where('status', 'active')
            ->latest('views')
            ->get();

        return view('user.mitra.show', [
            'mitra' => $mitra,
            'services' => $services,
        ]);
    }

    /**
     * Show service detail
     * KISS: Service detail + mitra info + reviews
     */
    public function show(string $serviceId)
    {
        $service = Service::with(['user:id,nama,phone,location'])
            ->findOrFail($serviceId);

        // Increment views
        $service->increment('views');

        return view('user.services.show', [
            'service' => $service,
            'mitra' => $service->user,
        ]);
    }
}
