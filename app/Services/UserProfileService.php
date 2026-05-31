<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;

class UserProfileService
{
    public function __construct(private UserRepository $users) {}

    public function getUserWithFallback(?int $authId, int $fallbackId = 1): ?User
    {
        return $this->users->findById($authId ?? $fallbackId);
    }

    public function getBankAccountArray(int $userId): array
    {
        $bank = $this->users->getBankAccountByUserId($userId);
        return $bank ? $bank->toArray() : [];
    }

    public function updateProfile(User $user, array $payload): bool
    {
        return $this->users->updateUser($user, $payload);
    }

    public function upsertBankAccount(int $userId, array $payload): void
    {
        $this->users->upsertBankAccount($userId, $payload);
    }
}
