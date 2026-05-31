<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Services\MitraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function __construct(private MitraService $mitraService) {}

    public function index(Request $request)
    {
        $userId = Auth::id() ?? 1;
        $category = (string) $request->query('category', 'all');
        $search = (string) $request->query('q', '');
        $page = max(1, (int) $request->query('page', 1));
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $certificates = $this->mitraService->getCertificates($userId, $category, $search, $limit, $offset);
        $count = $this->mitraService->countCertificates($userId, $category, $search);
        $totalPages = max(1, (int) ceil($count / $limit));

        return view('mitra.certificates', [
            'title' => 'Sertifikat',
            'certificates' => $certificates,
            'filters' => [
                'category' => $category,
                'q' => $search,
                'page' => $page,
                'total' => $count,
                'totalPages' => $totalPages,
            ],
            'message' => session('message'),
        ]);
    }

    public function create()
    {
        return view('mitra.certificates', [
            'title' => 'Tambah Sertifikat',
            'certificates' => [],
            'filters' => ['category' => 'all', 'q' => '', 'page' => 1, 'total' => 0, 'totalPages' => 1],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issued_by' => 'required|string|max:255',
            'issued_date' => 'required|date',
            'expiry_date' => 'nullable|date',
            'certificate_number' => 'nullable|string|max:100',
            'category' => 'required|in:teknis,keselamatan,manajemen,lainnya',
        ]);

        $userId = Auth::id() ?? 1;
        $validated['status_verifikasi'] = 'pending';

        $ok = $this->mitraService->createCertificate($userId, $validated);

        return redirect()->route('mitra.certificates.index')
            ->with('message', [
                'type' => $ok ? 'success' : 'error',
                'text' => $ok ? 'Sertifikat berhasil ditambahkan!' : 'Gagal menambahkan sertifikat.',
            ]);
    }

    public function edit(string $id)
    {
        return redirect()->route('mitra.certificates.index');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issued_by' => 'required|string|max:255',
            'issued_date' => 'required|date',
            'expiry_date' => 'nullable|date',
            'certificate_number' => 'nullable|string|max:100',
            'category' => 'required|in:teknis,keselamatan,manajemen,lainnya',
        ]);

        $userId = Auth::id() ?? 1;
        $targetId = (int) ($request->input('id') ?: $id);
        $ok = $this->mitraService->updateCertificate($userId, $targetId, $validated);

        return redirect()->route('mitra.certificates.index')
            ->with('message', [
                'type' => $ok ? 'success' : 'error',
                'text' => $ok ? 'Sertifikat berhasil diupdate!' : 'Gagal memperbarui sertifikat.',
            ]);
    }

    public function show(string $id)
    {
        return redirect()->route('mitra.certificates.index');
    }

    public function destroy(string $id)
    {
        $userId = Auth::id() ?? 1;
        $targetId = (int) (request('id') ?: $id);
        $ok = $this->mitraService->deleteCertificate($userId, $targetId);

        return redirect()->route('mitra.certificates.index')
            ->with('message', [
                'type' => $ok ? 'success' : 'error',
                'text' => $ok ? 'Sertifikat berhasil dihapus!' : 'Gagal menghapus sertifikat.',
            ]);
    }
}
