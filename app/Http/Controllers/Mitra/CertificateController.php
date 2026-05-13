<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $certificates = Certificate::where('user_id', Auth::id())
            ->orderBy('tanggal_terbit', 'desc')
            ->get();

        return view('mitra.certificate.index', [
            'title' => 'Sertifikat',
            'certificates' => $certificates,
        ]);
    }

    public function create()
    {
        return view('mitra.certificate.create', [
            'title' => 'Tambah Sertifikat',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sertifikat' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'tanggal_kadaluarsa' => 'nullable|date',
            'nomor_sertifikat' => 'nullable|string|max:100',
            'kategori' => 'required|in:teknis,keselamatan,manajemen,lainnya',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status_verifikasi'] = 'pending';

        Certificate::create($validated);

        return redirect()->route('mitra.certificate.index')
            ->with('success', 'Sertifikat berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        $certificate = Certificate::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('mitra.certificate.edit', [
            'title' => 'Edit Sertifikat',
            'certificate' => $certificate,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $certificate = Certificate::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'nama_sertifikat' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tanggal_terbit' => 'required|date',
            'tanggal_kadaluarsa' => 'nullable|date',
            'nomor_sertifikat' => 'nullable|string|max:100',
            'kategori' => 'required|in:teknis,keselamatan,manajemen,lainnya',
        ]);

        $certificate->update($validated);

        return redirect()->route('mitra.certificate.index')
            ->with('success', 'Sertifikat berhasil diupdate!');
    }

    public function show(string $id)
    {
        $certificate = Certificate::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('mitra.certificate.show', [
            'title' => 'Detail Sertifikat',
            'certificate' => $certificate,
        ]);
    }

    public function destroy(string $id)
    {
        $certificate = Certificate::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $certificate->delete();

        return redirect()->route('mitra.certificate.index')
            ->with('success', 'Sertifikat berhasil dihapus!');
    }
}
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
