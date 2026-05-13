<?php

namespace App\Models\Mitra;

use App\Core\Database;

class PortfolioModel
{
    private \mysqli $conn;

    public function __construct()
    {
        $this->conn = Database::connection();
    }

    public function getListByUser(int $userId, string $category, string $search, int $limit, int $offset): array
    {
        $category = trim($category);
        $search = trim($search);

        if ($category !== '' && $category !== 'all' && $search !== '') {
            $sql = 'SELECT id, judul, deskripsi, kategori, tanggal_project, client_name, lokasi, nilai_project
                    FROM portfolio
                    WHERE user_id = ? AND kategori = ? AND judul LIKE ?
                    ORDER BY tanggal_project DESC
                    LIMIT ? OFFSET ?';
            $like = '%' . $search . '%';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('issii', $userId, $category, $like, $limit, $offset);
        } elseif ($category !== '' && $category !== 'all') {
            $sql = 'SELECT id, judul, deskripsi, kategori, tanggal_project, client_name, lokasi, nilai_project
                    FROM portfolio
                    WHERE user_id = ? AND kategori = ?
                    ORDER BY tanggal_project DESC
                    LIMIT ? OFFSET ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('isii', $userId, $category, $limit, $offset);
        } elseif ($search !== '') {
            $sql = 'SELECT id, judul, deskripsi, kategori, tanggal_project, client_name, lokasi, nilai_project
                    FROM portfolio
                    WHERE user_id = ? AND judul LIKE ?
                    ORDER BY tanggal_project DESC
                    LIMIT ? OFFSET ?';
            $like = '%' . $search . '%';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('isii', $userId, $like, $limit, $offset);
        } else {
            $sql = 'SELECT id, judul, deskripsi, kategori, tanggal_project, client_name, lokasi, nilai_project
                    FROM portfolio
                    WHERE user_id = ?
                    ORDER BY tanggal_project DESC
                    LIMIT ? OFFSET ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('iii', $userId, $limit, $offset);
        }

        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function countByUser(int $userId, string $category, string $search): int
    {
        $category = trim($category);
        $search = trim($search);

        if ($category !== '' && $category !== 'all' && $search !== '') {
            $sql = 'SELECT COUNT(*) AS total FROM portfolio WHERE user_id = ? AND kategori = ? AND judul LIKE ?';
            $like = '%' . $search . '%';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('iss', $userId, $category, $like);
        } elseif ($category !== '' && $category !== 'all') {
            $sql = 'SELECT COUNT(*) AS total FROM portfolio WHERE user_id = ? AND kategori = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('is', $userId, $category);
        } elseif ($search !== '') {
            $sql = 'SELECT COUNT(*) AS total FROM portfolio WHERE user_id = ? AND judul LIKE ?';
            $like = '%' . $search . '%';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('is', $userId, $like);
        } else {
            $sql = 'SELECT COUNT(*) AS total FROM portfolio WHERE user_id = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('i', $userId);
        }

        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        return (int)($row['total'] ?? 0);
    }

    public function create(int $userId, array $payload): bool
    {
        $sql = "INSERT INTO portfolio (user_id, judul, deskripsi, kategori, tanggal_project, client_name, lokasi, nilai_project, durasi_hari, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'published')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            'issssssdi',
            $userId,
            $payload['judul'],
            $payload['deskripsi'],
            $payload['kategori'],
            $payload['tanggal_project'],
            $payload['client_name'],
            $payload['lokasi'],
            $payload['nilai_project'],
            $payload['durasi_hari']
        );

        return $stmt->execute();
    }

    public function update(int $userId, int $id, array $payload): bool
    {
        $sql = 'UPDATE portfolio SET judul = ?, deskripsi = ?, kategori = ?, tanggal_project = ?, client_name = ?, lokasi = ?, nilai_project = ?, durasi_hari = ?
                WHERE id = ? AND user_id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            'ssssssdiii',
            $payload['judul'],
            $payload['deskripsi'],
            $payload['kategori'],
            $payload['tanggal_project'],
            $payload['client_name'],
            $payload['lokasi'],
            $payload['nilai_project'],
            $payload['durasi_hari'],
            $id,
            $userId
        );

        return $stmt->execute();
    }

    public function delete(int $userId, int $id): bool
    {
        $sql = 'DELETE FROM portfolio WHERE id = ? AND user_id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $id, $userId);

        return $stmt->execute();
    }
}
