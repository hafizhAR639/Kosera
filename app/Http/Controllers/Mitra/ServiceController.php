<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Services\MitraService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
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

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga_mulai' => 'nullable|numeric',
            'harga_max' => 'nullable|numeric',
            'satuan' => 'nullable|string|max:50',
            'durasi_estimasi' => 'nullable|string|max:100',
            'area_layanan' => 'nullable|string',
            'foto' => 'nullable|image|min:2048|max:4096',
            'foto_cover' => 'nullable|image|min:2048|max:4096',
            'status' => 'nullable|in:active,inactive',
        ], [
            'foto.min' => 'Ukuran foto minimal 2 MB',
            'foto.max' => 'Ukuran foto maksimal 4 MB',
            'foto_cover.min' => 'Ukuran foto cover minimal 2 MB',
            'foto_cover.max' => 'Ukuran foto cover maksimal 4 MB',
        ]);

        // handle foto upload
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('services', 'public');
            $validated['foto'] = '/storage/' . $path;
        }

        $portfolioImagePath = null;
        if ($request->hasFile('foto_cover')) {
            $path = $request->file('foto_cover')->store('portfolio', 'public');
            $portfolioImagePath = '/storage/' . $path;
        }

        $validated['status'] = $validated['status'] ?? 'active';

        $service = $this->mitraService->createService(Auth::id() ?? 1, $validated, $portfolioImagePath);

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

    public function update(Request $request, string $id)
    {
        $userId = Auth::id() ?? 1;
        $service = $this->mitraService->findServiceByUser($userId, (int) $id);

        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
            'harga_mulai' => 'nullable|numeric',
            'harga_max' => 'nullable|numeric',
            'satuan' => 'nullable|string|max:50',
            'durasi_estimasi' => 'nullable|string|max:100',
            'area_layanan' => 'nullable|string',
            'foto' => 'nullable|image|min:2048|max:4096',
            'status' => 'nullable|in:active,inactive',
        ], [
            'foto.min' => 'Ukuran foto minimal 2 MB',
            'foto.max' => 'Ukuran foto maksimal 4 MB',
        ]);

        // handle foto upload and delete previous if present
        if ($request->hasFile('foto')) {
            // delete previous file from storage if exists
            if (!empty($service->foto)) {
                $prev = ltrim(str_replace('/storage/', '', $service->foto), '/');
                Storage::disk('public')->delete($prev);
            }

            $path = $request->file('foto')->store('services', 'public');
            $validated['foto'] = '/storage/' . $path;
        }

        $this->mitraService->updateService($userId, (int) $id, $validated);

        return redirect()->route('mitra.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $service = $this->mitraService->findServiceByUser(Auth::id() ?? 1, (int) $id);

        // delete foto if exists
        if (!empty($service->foto)) {
            $path = ltrim(str_replace('/storage/', '', $service->foto), '/');
            Storage::disk('public')->delete($path);
        }

        $this->mitraService->deleteService(Auth::id() ?? 1, (int) $id);

        return redirect()->route('mitra.layanan.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}
