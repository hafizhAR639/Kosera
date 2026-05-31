<?php

namespace App\Controllers\Mitra;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Helpers;

class ProfileController extends Controller
{
    public function show(): void
    {
        Auth::requireLogin();

        $userId = (int) Auth::getCurrentUserId();
        $service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());

        $user = $service->getProfile($userId);

        $this->render('mitra/profile_show', [
            'title' => 'Profil Mitra',
            'message' => Helpers::getMessage(),
            'user' => $user,
        ], 'mitra');
    }

    public function edit(): void
    {
        Auth::requireLogin();

        $userId = (int) Auth::getCurrentUserId();
        $service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());

        $user = $service->getProfile($userId);

        $this->render('mitra/profile_edit', [
            'title' => 'Edit Profil',
            'message' => Helpers::getMessage(),
            'user' => $user,
        ], 'mitra');
    }

    public function update(): void
    {
        Auth::requireLogin();

        $userId = (int) Auth::getCurrentUserId();

        $payload = [
            'nama' => $_POST['nama'] ?? '',
            'phone' => $_POST['phone'] ?? '',
            'location' => $_POST['location'] ?? '',
            'bio' => $_POST['bio'] ?? '',
            'avatar' => $_POST['avatar'] ?? null,
        ];

        $service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());
        $ok = $service->updateProfile($userId, $payload);

        if ($ok) {
            Helpers::setMessage('success', 'Profil berhasil diperbarui.');
        } else {
            Helpers::setMessage('error', 'Gagal memperbarui profil.');
        }

        $this->redirect(Helpers::routePath('/mitra/profile'));
    }
}
