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
