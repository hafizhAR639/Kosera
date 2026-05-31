<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Services\MitraService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortfolioController extends Controller
{
    public function __construct(private MitraService $mitraService) {}

    public function index()
    {
        $userId = Auth::id() ?? 1;
        $category = request()->get('category', 'all');
        $search = request()->get('q', '');
        $page = request()->get('page', 1);
        $perPage = 9;

        $portfolios = $this->mitraService->paginatePortfolio($userId, [
            'category' => $category,
            'q' => $search,
        ], $perPage);

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

        $userId = Auth::id() ?? 1;
        $this->mitraService->createPortfolioWithFile($userId, $validated, $request->file('foto_cover'));

        return redirect()->route('mitra.portfolio.index')
            ->with('success', 'Portfolio berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $portfolio = $this->mitraService->findPortfolioByUser(Auth::id() ?? 1, (int) $id);

        return view('mitra.portfolio.edit', [
            'title' => 'Edit Portfolio',
            'portfolio' => $portfolio,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $userId = Auth::id() ?? 1;
        $portfolio = $this->mitraService->findPortfolioByUser($userId, (int) $id);

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

        $this->mitraService->updatePortfolioWithFile($userId, (int) $id, $validated, $request->file('foto_cover'));

        return redirect()->route('mitra.portfolio.index')
            ->with('success', 'Portfolio berhasil diupdate!');
    }

    public function show(string $id)
    {
        $portfolio = $this->mitraService->findPortfolioByUser(Auth::id() ?? 1, (int) $id);

        return view('mitra.portfolio.show', [
            'title' => 'Detail Portfolio',
            'portfolio' => $portfolio,
        ]);
    }

    public function destroy(string $id)
    {
        $this->mitraService->deletePortfolio(Auth::id() ?? 1, (int) $id);

        return redirect()->route('mitra.portfolio.index')
            ->with('success', 'Portfolio berhasil dihapus!');
    }
}
