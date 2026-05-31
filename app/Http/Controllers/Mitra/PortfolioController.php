<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
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

        $query = Portfolio::where('user_id', $userId);

        if ($category !== 'all') {
            $query->where('kategori', $category);
        }

        if ($search) {
            $query->where('judul', 'like', "%{$search}%");
        }

        $portfolios = $query->paginate($perPage);

        return view('mitra.portfolio.index', [
            'title' => 'Portfolio',
            'portfolios' => $portfolios,
            'filters' => [
                'category' => $category,
                'q' => $search,
                'page' => $page,
                'perPage' => $perPage,
                'total' => $portfolios->total(),
                'totalPages' => $portfolios->lastPage(),
            ],
        ]);
    }

    public function create()
    {
        return view('mitra.portfolio.create', [
            'title' => 'Tambah Portfolio',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:100',
            'tanggal_project' => 'nullable|date',
            'client_name' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:100',
            'nilai_project' => 'nullable|numeric',
            'durasi_hari' => 'nullable|integer',
            'foto_cover' => 'nullable|image|max:4096',
        ]);

        // handle foto_cover upload
        if ($request->hasFile('foto_cover')) {
            $path = $request->file('foto_cover')->store('portfolio', 'public');
            $validated['foto_cover'] = '/storage/' . $path;
        }

        $validated['user_id'] = Auth::id();

        Portfolio::create($validated);

        return redirect()->route('mitra.portfolio.index')
            ->with('success', 'Portfolio berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $portfolio = Portfolio::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('mitra.portfolio.edit', [
            'title' => 'Edit Portfolio',
            'portfolio' => $portfolio,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $portfolio = Portfolio::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'required|string|max:100',
            'tanggal_project' => 'nullable|date',
            'client_name' => 'nullable|string|max:100',
            'lokasi' => 'nullable|string|max:100',
            'nilai_project' => 'nullable|numeric',
            'durasi_hari' => 'nullable|integer',
            'foto_cover' => 'nullable|image|max:4096',
        ]);

        // handle foto_cover upload and delete previous if present
        if ($request->hasFile('foto_cover')) {
            // delete previous file from storage if exists
            if (!empty($portfolio->foto_cover)) {
                $prev = ltrim(str_replace('/storage/', '', $portfolio->foto_cover), '/');
                try { Storage::disk('public')->delete($prev); } catch (\Throwable $e) {}
            }

            $path = $request->file('foto_cover')->store('portfolio', 'public');
            $validated['foto_cover'] = '/storage/' . $path;
        }

        $portfolio->update($validated);

        return redirect()->route('mitra.portfolio.index')
            ->with('success', 'Portfolio berhasil diupdate!');
    }

    public function show(string $id)
    {
        $portfolio = Portfolio::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('mitra.portfolio.show', [
            'title' => 'Detail Portfolio',
            'portfolio' => $portfolio,
        ]);
    }

    public function destroy(string $id)
    {
        $portfolio = Portfolio::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $portfolio->delete();

        return redirect()->route('mitra.portfolio.index')
            ->with('success', 'Portfolio berhasil dihapus!');
    }
}
