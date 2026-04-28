<?php

namespace App\Core;

class Helpers
{
    /**
     * Sanitize user input.
     */
    public static function sanitize(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    /**
     * Format a number as Indonesian Rupiah.
     */
    public static function formatRupiah(float $number): string
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }

    /**
     * Format a date string to Indonesian date format.
     */
    public static function formatTanggal(string $date): string
    {
        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        $pecah = explode('-', $date);
        return $pecah[2] . ' ' . $bulan[(int)$pecah[1]] . ' ' . $pecah[0];
    }

    /**
     * Upload a file to the given directory.
     *
     * @param array<string, mixed> $file        $_FILES element
     * @param string               $targetDir   destination directory
     * @param string[]             $allowedTypes allowed extensions
     * @return array{success: bool, file_path?: string, message?: string}
     */
    public static function uploadFile(array $file, string $targetDir = 'uploads/', array $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf']): array
    {
        $targetFile = $targetDir . basename($file['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($targetFile)) {
            $targetFile = $targetDir . time() . '_' . basename($file['name']);
        }

        // Check file size (5MB max)
        if ($file['size'] > 5000000) {
            return ['success' => false, 'message' => 'File terlalu besar. Maksimal 5MB'];
        }

        // Allow certain file formats
        if (!in_array($imageFileType, $allowedTypes)) {
            return ['success' => false, 'message' => 'Format file tidak diizinkan'];
        }

        // Try to upload file
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return ['success' => true, 'file_path' => $targetFile];
        }

        return ['success' => false, 'message' => 'Upload gagal'];
    }

    /**
     * Store a flash message in the session.
     */
    public static function setMessage(string $type, string $message): void
    {
        $_SESSION['message'] = ['type' => $type, 'text' => $message];
    }

    /**
     * Retrieve and clear the flash message from the session.
     *
     * @return array{type: string, text: string}|null
     */
    public static function getMessage(): ?array
    {
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']);
            return $message;
        }
        return null;
    }

    /**
     * Build a route path with the front controller query parameter.
     */
    public static function routePath(string $path): string
    {
        return 'index.php?r=' . $path;
    }
}
