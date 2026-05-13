<?php

namespace App\Models\Auth;

use App\Core\Database;

class UserAuthModel
{
    private \mysqli $conn;

    public function __construct()
    {
        $this->conn = Database::connection();
    }

    public function findByEmail(string $email): ?array
    {
        $sql = 'SELECT id, nama, email, password FROM users WHERE email = ? LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $row = $stmt->get_result()->fetch_assoc();

        return $row ?: null;
    }

    public function createUser(string $nama, string $email, string $passwordHash): bool
    {
        $sql = 'INSERT INTO users (nama, email, password) VALUES (?, ?, ?)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('sss', $nama, $email, $passwordHash);

        return $stmt->execute();
    }
}
