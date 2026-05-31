<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $userId = Auth::id();
        $category = request()->get('category', 'all');
        $search = request()->get('q', '');
        $page = request()->get('page', 1);
        $perPage = 9;

        $query = Service::where('user_id', $userId);

        if ($category !== 'all') {
            $query->where('kategori', $category);
        }

        if ($search) {
            $query->where('nama_layanan', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
        }

        $services = $query->paginate($perPage);

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

        $validated['user_id'] = Auth::id();
        $validated['status'] = $validated['status'] ?? 'active';

        $service = Service::create($validated);

        if ($portfolioImagePath) {
            Portfolio::create([
                'user_id' => Auth::id(),
                'judul' => $validated['nama_layanan'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'kategori' => $validated['kategori'] ?? null,
                'foto_cover' => $portfolioImagePath,
                'status' => 'published',
            ]);
        }

        return redirect()->route('mitra.layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $service = Service::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('mitra.layanan.edit', [
            'title' => 'Edit Layanan',
            'service' => $service,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $service = Service::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

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

        $service->fill($validated);
        $service->save();

        return redirect()->route('mitra.layanan.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $service = Service::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // delete foto if exists
        if (!empty($service->foto)) {
            $path = ltrim(str_replace('/storage/', '', $service->foto), '/');
            Storage::disk('public')->delete($path);
        }

        $service->delete();

        return redirect()->route('mitra.layanan.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}
