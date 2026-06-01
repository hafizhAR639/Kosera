<?php

namespace App\Repositories;

use App\Models\BankAccount;
use App\Models\IdentityVerification;
use App\Models\Order;
use App\Models\Portfolio;
use App\Models\User;

class UserRepository
{
    public function findById(int $id): ?User
    {
        return User::find($id);
    }

    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function createUser(array $payload): User
    {
        return User::create($payload);
    }

    public function latestOrderByUser(int $userId): ?Order
    {
        return Order::where('user_id', $userId)->latest('created_at')->first();
    }

    public function updateUser(User $user, array $payload): bool
    {
        return $user->fill($payload)->save();
    }

    public function getBankAccountByUserId(int $userId): ?BankAccount
    {
        return BankAccount::where('user_id', $userId)->first();
    }

    public function upsertBankAccount(int $userId, array $payload): BankAccount
    {
        return BankAccount::updateOrCreate(
            ['user_id' => $userId],
            [
                'nama_bank' => $payload['nama_bank'] ?? '',
                'nama_rekening' => $payload['nama_rekening'] ?? '',
                'nomor_rekening' => $payload['nomor_rekening'] ?? '',
                'alamat_bank' => $payload['alamat_bank'] ?? null,
            ]
        );
    }

    public function createIdentityVerification(int $userId, array $payload): IdentityVerification
    {
        return IdentityVerification::create([
            'user_id' => $userId,
            'nik' => $payload['nik'] ?? null,
            'foto_ktp' => $payload['foto_ktp'] ?? null,
            'selfie_ktp' => $payload['selfie_ktp'] ?? null,
            'status' => $payload['status'] ?? 'pending',
        ]);
    }

    public function createInitialPortfolio(int $userId, string $description): Portfolio
    {
        return Portfolio::create([
            'user_id' => $userId,
            'judul' => 'Portfolio Awal',
            'deskripsi' => $description,
            'kategori' => 'Lainnya',
            'status' => 'draft',
        ]);
    }
}
