<?php

namespace App\Models\Mitra;

use App\Core\Database;

class ProfileModel
{
    private \mysqli $conn;

    public function __construct()
    {
        $this->conn = Database::connection();
    }

    public function getUserById(int $userId): ?array
    {
        $sql = 'SELECT * FROM users WHERE id = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $userId);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();

        return $row ?: null;
    }

    public function updateProfile(int $userId, string $nama, string $phone, string $location, string $bio, ?string $avatarPath = null): bool
    {
        if ($avatarPath !== null) {
            $sql = 'UPDATE users SET nama = ?, phone = ?, location = ?, bio = ?, avatar = ? WHERE id = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('sssssi', $nama, $phone, $location, $bio, $avatarPath, $userId);
            return $stmt->execute();
        }

        $sql = 'UPDATE users SET nama = ?, phone = ?, location = ?, bio = ? WHERE id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ssssi', $nama, $phone, $location, $bio, $userId);

        return $stmt->execute();
    }
}
