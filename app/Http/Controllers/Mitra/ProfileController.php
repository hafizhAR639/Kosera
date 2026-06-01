<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Services\MitraService;
use App\Http\Requests\MitraProfileRequest;
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

    public function update(MitraProfileRequest $request)
    {
        $userId = Auth::id() ?? 1;

        $validated = $request->validated();

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
