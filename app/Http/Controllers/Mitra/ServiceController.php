<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Services\MitraService;
use App\Http\Requests\ServiceRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function __construct(private MitraService $mitraService) {}

    public function index()
    {
        $userId = Auth::id() ?? 1;
        $category = request()->get('category', 'all');
        $search = request()->get('q', '');
        $page = request()->get('page', 1);
        $perPage = 9;

        $services = $this->mitraService->paginateServices($userId, [
            'category' => $category,
            'q' => $search,
        ], $perPage);

        return view('mitra.layanan.index', [
            'title' => 'Layanan',
            'services' => $services,
            'filters' => [
                'category' => $category,
                'q' => $search,
                'page' => $page,
                'perPage' => $perPage,
                'total' => $services->total(),
                'totalPages' => $services->lastPage(),
            ],
        ]);
    }

    public function create()
    {
        return view('mitra.layanan.create', [
            'title' => 'Tambah Layanan',
        ]);
    }

    public function store(ServiceRequest $request)
    {
        $validated = $request->validated();

        $validated['status'] = $validated['status'] ?? 'active';

        $service = $this->mitraService->createServiceWithFiles(
            Auth::id() ?? 1,
            $validated,
            $request->file('foto') ?? null,
            $request->file('foto_cover') ?? null
        );

        return redirect()->route('mitra.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $service = $this->mitraService->findServiceByUser(Auth::id() ?? 1, (int) $id);

        return view('mitra.layanan.edit', [
            'title' => 'Edit Layanan',
            'service' => $service,
        ]);
    }

    public function update(ServiceRequest $request, string $id)
    {
        $userId = Auth::id() ?? 1;
        $service = $this->mitraService->findServiceByUser($userId, (int) $id);
        $validated = $request->validated();

        $this->mitraService->updateServiceWithFiles($userId, (int) $id, $validated, $request->file('foto') ?? null);

        return redirect()->route('mitra.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $service = $this->mitraService->findServiceByUser(Auth::id() ?? 1, (int) $id);

        $this->mitraService->deleteServiceWithFiles(Auth::id() ?? 1, (int) $id);

        return redirect()->route('mitra.layanan.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}
