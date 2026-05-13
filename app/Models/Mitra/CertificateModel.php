<?php

namespace App\Models\Mitra;

use App\Core\Database;

class CertificateModel
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
            $sql = 'SELECT id, nama_sertifikat, penerbit, tanggal_terbit, tanggal_kadaluarsa, nomor_sertifikat, kategori, file_path, status_verifikasi
                    FROM certificates
                    WHERE user_id = ? AND kategori = ? AND nama_sertifikat LIKE ?
                    ORDER BY tanggal_terbit DESC
                    LIMIT ? OFFSET ?';
            $like = '%' . $search . '%';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('issii', $userId, $category, $like, $limit, $offset);
        } elseif ($category !== '' && $category !== 'all') {
            $sql = 'SELECT id, nama_sertifikat, penerbit, tanggal_terbit, tanggal_kadaluarsa, nomor_sertifikat, kategori, file_path, status_verifikasi
                    FROM certificates
                    WHERE user_id = ? AND kategori = ?
                    ORDER BY tanggal_terbit DESC
                    LIMIT ? OFFSET ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('isii', $userId, $category, $limit, $offset);
        } elseif ($search !== '') {
            $sql = 'SELECT id, nama_sertifikat, penerbit, tanggal_terbit, tanggal_kadaluarsa, nomor_sertifikat, kategori, file_path, status_verifikasi
                    FROM certificates
                    WHERE user_id = ? AND nama_sertifikat LIKE ?
                    ORDER BY tanggal_terbit DESC
                    LIMIT ? OFFSET ?';
            $like = '%' . $search . '%';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('isii', $userId, $like, $limit, $offset);
        } else {
            $sql = 'SELECT id, nama_sertifikat, penerbit, tanggal_terbit, tanggal_kadaluarsa, nomor_sertifikat, kategori, file_path, status_verifikasi
                    FROM certificates
                    WHERE user_id = ?
                    ORDER BY tanggal_terbit DESC
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
            $sql = 'SELECT COUNT(*) AS total FROM certificates WHERE user_id = ? AND kategori = ? AND nama_sertifikat LIKE ?';
            $like = '%' . $search . '%';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('iss', $userId, $category, $like);
        } elseif ($category !== '' && $category !== 'all') {
            $sql = 'SELECT COUNT(*) AS total FROM certificates WHERE user_id = ? AND kategori = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('is', $userId, $category);
        } elseif ($search !== '') {
            $sql = 'SELECT COUNT(*) AS total FROM certificates WHERE user_id = ? AND nama_sertifikat LIKE ?';
            $like = '%' . $search . '%';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('is', $userId, $like);
        } else {
            $sql = 'SELECT COUNT(*) AS total FROM certificates WHERE user_id = ?';
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param('i', $userId);
        }

        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();

        return (int)($row['total'] ?? 0);
    }

    public function create(int $userId, array $payload): bool
    {
        $sql = 'INSERT INTO certificates (user_id, nama_sertifikat, penerbit, tanggal_terbit, tanggal_kadaluarsa, nomor_sertifikat, kategori, file_path)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            'isssssss',
            $userId,
            $payload['nama_sertifikat'],
            $payload['penerbit'],
            $payload['tanggal_terbit'],
            $payload['tanggal_kadaluarsa'],
            $payload['nomor_sertifikat'],
            $payload['kategori'],
            $payload['file_path']
        );

        return $stmt->execute();
    }

    public function update(int $userId, int $id, array $payload): bool
    {
        $sql = 'UPDATE certificates SET nama_sertifikat = ?, penerbit = ?, tanggal_terbit = ?, tanggal_kadaluarsa = ?, nomor_sertifikat = ?, kategori = ?
                WHERE id = ? AND user_id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param(
            'ssssssii',
            $payload['nama_sertifikat'],
            $payload['penerbit'],
            $payload['tanggal_terbit'],
            $payload['tanggal_kadaluarsa'],
            $payload['nomor_sertifikat'],
            $payload['kategori'],
            $id,
            $userId
        );

        return $stmt->execute();
    }

    public function delete(int $userId, int $id): bool
    {
        $sql = 'DELETE FROM certificates WHERE id = ? AND user_id = ?';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('ii', $id, $userId);

        return $stmt->execute();
    }
}
