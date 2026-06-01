<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthRegistrationService
{
    public function __construct(private UserRepository $users) {}

    /**
     * Process step-based registration flow.
     * Returns array with keys: stored, redirect_route, redirect_params, flash, clear_session
     */
    public function processStep(array $currentInput, array $stored): array
    {
        // === BARIS PERBAIKAN DI SINI ===
        // 1. Cek dan amankan file 'foto_ktp' jika ada di inputan saat ini
        if (isset($currentInput['foto_ktp']) && $currentInput['foto_ktp'] instanceof \Illuminate\Http\UploadedFile) {
            // Simpan ke storage dan ubah objek menjadi string path
            $currentInput['foto_ktp'] = $currentInput['foto_ktp']->store('public/ktp');
        }

        // 2. Cek dan amankan file 'selfie_ktp' jika ada di inputan saat ini
        if (isset($currentInput['selfie_ktp']) && $currentInput['selfie_ktp'] instanceof \Illuminate\Http\UploadedFile) {
            // Simpan ke storage dan ubah objek menjadi string path
            $currentInput['selfie_ktp'] = $currentInput['selfie_ktp']->store('public/selfie');
        }
        // ===============================

        // Sekarang array_merge hanya akan menggabungkan teks string aman, bukan objek file biner lagi
        $stored = array_merge($stored, $currentInput);

        if (!empty($currentInput['nama_bank']) || !empty($currentInput['nomor_rekening'])) {
            $email = $stored['email'] ?? null;

            if ($email && $this->users->findByEmail($email)) {
                return [
                    'stored' => $stored,
                    'redirect_route' => 'login',
                    'redirect_params' => [],
                    'flash' => ['type' => 'warning', 'text' => 'Email sudah terdaftar. Silakan masuk.'],
                    'clear_session' => true,
                ];
            }

            $password = $stored['password'] ?? bin2hex(random_bytes(8));
            $user = $this->users->createUser([
                'nama' => $stored['nama'] ?? 'Pengguna Baru',
                'email' => $email,
                'password' => Hash::make($password),
                'phone' => $stored['phone'] ?? null,
                'location' => $stored['alamat'] ?? null,
                'role' => $stored['role'] ?? 'user',
                'status' => 'active',
            ]);

            if (!empty($stored['nama_bank'])) {
                $this->users->upsertBankAccount($user->id, [
                    'nama_bank' => $stored['nama_bank'] ?? '',
                    'nama_rekening' => $stored['nama_rekening'] ?? '',
                    'nomor_rekening' => $stored['nomor_rekening'] ?? '',
                    'alamat_bank' => $stored['alamat_bank'] ?? null,
                ]);
            }

            if (($stored['role'] ?? null) === 'mitra' && !empty($stored['nik'])) {
                $this->users->createIdentityVerification($user->id, [
                    'nik' => $stored['nik'] ?? null,
                    'foto_ktp' => $stored['foto_ktp'] ?? null,
                    'selfie_ktp' => $stored['selfie_ktp'] ?? null,
                    'status' => 'pending',
                ]);
            }

            if (($stored['role'] ?? null) === 'mitra' && !empty($stored['deskripsi_portofolio'])) {
                $this->users->createInitialPortfolio($user->id, (string) $stored['deskripsi_portofolio']);
            }

            return [
                'stored' => $stored,
                'redirect_route' => 'login',
                'redirect_params' => [],
                'flash' => ['type' => 'success', 'text' => 'Akun dibuat. Silakan masuk.'],
                'clear_session' => true,
            ];
        }

        $role = $currentInput['role'] ?? ($stored['role'] ?? 'user');

        if (!empty($currentInput['deskripsi_portofolio']) || !empty($currentInput['portfolio_file'])) {
            return [
                'stored' => $stored,
                'redirect_route' => 'register.step4',
                'redirect_params' => ['role' => $role],
                'flash' => null,
                'clear_session' => false,
            ];
        }

        if (!empty($currentInput['nik'])) {
            return [
                'stored' => $stored,
                'redirect_route' => $role === 'mitra' ? 'register.step3' : 'register.step4',
                'redirect_params' => ['role' => $role],
                'flash' => null,
                'clear_session' => false,
            ];
        }

        if (!empty($currentInput['nama']) && !empty($currentInput['email'])) {
            return [
                'stored' => $stored,
                'redirect_route' => 'register.step2',
                'redirect_params' => ['role' => $role],
                'flash' => null,
                'clear_session' => false,
            ];
        }

        return [
            'stored' => $stored,
            'redirect_route' => 'register',
            'redirect_params' => [],
            'flash' => null,
            'clear_session' => false,
        ];
    }
}
