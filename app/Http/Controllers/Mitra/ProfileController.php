<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Services\MitraService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(private MitraService $mitraService) {}

    public function show()
    {
        $userId = Auth::id() ?? 1;
        $profile = $this->mitraService->getProfile($userId) ?? [];

        return view('mitra.profile', [
            'profile' => $profile,
        ]);
    }

    public function edit()
    {
        $userId = Auth::id() ?? 1;
        $profile = $this->mitraService->getProfile($userId) ?? [];
        $bankAccount = $this->mitraService->getBankAccount($userId) ?? [];

        return view('mitra.profile_edit', [
            'profile' => $profile,
            'bankAccount' => $bankAccount,
        ]);
    }

    public function update(Request $request)
    {
        $userId = Auth::id() ?? 1;

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|max:4096',
            'nama_bank' => 'nullable|string|max:100',
            'nama_rekening' => 'nullable|string|max:100|required_with:nama_bank,nomor_rekening',
            'nomor_rekening' => 'nullable|string|max:50|required_with:nama_bank,nama_rekening',
            'alamat_bank' => 'nullable|string|max:255',
        ]);

        $profilePayload = [
            'nama' => $validated['nama'],
            'phone' => $validated['phone'] ?? null,
            'location' => $validated['location'] ?? null,
            'bio' => $validated['bio'] ?? null,
        ];

        $bankPayload = [
            'nama_bank' => $validated['nama_bank'] ?? '',
            'nama_rekening' => $validated['nama_rekening'] ?? '',
            'nomor_rekening' => $validated['nomor_rekening'] ?? '',
            'alamat_bank' => $validated['alamat_bank'] ?? null,
        ];

        $this->mitraService->updateProfileWithBank($userId, $profilePayload, $request->file('avatar'), $bankPayload);

        return redirect()->route('mitra.profile.show')->with('message', ['type' => 'success', 'text' => 'Profil berhasil diperbarui.']);
    }
}
