<?php

/**
 * Global helper function aliases for use in view templates.
 *
 * These thin wrappers delegate to the proper namespaced classes,
 * keeping templates concise while all logic lives in App\Core\*.
 *
 * This file is loaded by Composer via the "files" autoload directive.
 */

use App\Core\Auth;
use App\Core\Helpers;

if (!function_exists('route_path')) {
    function route_path(string $path): string
    {
        return Helpers::routePath($path);
    }
}

if (!function_exists('formatRupiah')) {
    function formatRupiah(float $number): string
    {
        return Helpers::formatRupiah($number);
    }
}

if (!function_exists('formatTanggal')) {
    function formatTanggal(string $date): string
    {
        return Helpers::formatTanggal($date);
    }
}

if (!function_exists('sanitize')) {
    function sanitize(string $data): string
    {
        return Helpers::sanitize($data);
    }
}

if (!function_exists('isLoggedIn')) {
    function isLoggedIn(): bool
    {
        return Auth::isLoggedIn();
    }
}

if (!function_exists('getCurrentUserId')) {
    function getCurrentUserId(): ?int
    {
        return Auth::getCurrentUserId();
    }
}

if (!function_exists('requireLogin')) {
    function requireLogin(): void
    {
        Auth::requireLogin();
    }
}

if (!function_exists('setMessage')) {
    function setMessage(string $type, string $message): void
    {
        Helpers::setMessage($type, $message);
    }
}

if (!function_exists('getMessage')) {
    function getMessage(): ?array
    {
        return Helpers::getMessage();
    }
}

if (!function_exists('uploadFile')) {
    function uploadFile(array $file, string $targetDir = 'uploads/', array $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf']): array
    {
        return Helpers::uploadFile($file, $targetDir, $allowedTypes);
    }
}
