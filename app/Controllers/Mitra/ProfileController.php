<?php

namespace App\Controllers\Mitra;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Helpers;
use App\Models\Mitra\ProfileModel;

class ProfileController extends Controller
{
    public function show(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $profile = (new ProfileModel())->getUserById($userId);

        if ($profile === null) {
            Helpers::setMessage('error', 'Profil tidak ditemukan.');
            $this->redirect(Helpers::routePath('/logout'));
        }

        $this->render('mitra/profile_show', [
            'title' => 'Profil Saya',
            'profile' => $profile,
            'avatarInitial' => strtoupper(substr($profile['nama'], 0, 1)),
            'message' => Helpers::getMessage(),
        ], 'mitra');
    }

    public function edit(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $profile = (new ProfileModel())->getUserById($userId);

        if ($profile === null) {
            Helpers::setMessage('error', 'Profil tidak ditemukan.');
            $this->redirect(Helpers::routePath('/logout'));
        }

        $this->render('mitra/profile_edit', [
            'title' => 'Edit Profil',
            'profile' => $profile,
            'message' => Helpers::getMessage(),
        ], 'mitra');
    }

    public function update(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $nama = Helpers::sanitize($_POST['nama'] ?? '');
        $phone = Helpers::sanitize($_POST['phone'] ?? '');
        $location = Helpers::sanitize($_POST['location'] ?? '');
        $bio = Helpers::sanitize($_POST['bio'] ?? '');

        if ($nama === '') {
            Helpers::setMessage('error', 'Nama wajib diisi.');
            $this->redirect(Helpers::routePath('/mitra/profile/edit'));
        }

        $avatarPath = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
            if (!is_dir('uploads/avatar')) {
                mkdir('uploads/avatar', 0755, true);
            }

            $upload = Helpers::uploadFile($_FILES['avatar'], 'uploads/avatar/', ['jpg', 'jpeg', 'png', 'webp']);
            if (!$upload['success']) {
                Helpers::setMessage('error', $upload['message']);
                $this->redirect(Helpers::routePath('/mitra/profile/edit'));
            }

            $avatarPath = $upload['file_path'];
        }

        $updated = (new ProfileModel())->updateProfile($userId, $nama, $phone, $location, $bio, $avatarPath);

        if ($updated) {
            Helpers::setMessage('success', 'Profil berhasil diperbarui.');
            $this->redirect(Helpers::routePath('/mitra/profile'));
        }

        Helpers::setMessage('error', 'Gagal memperbarui profil.');
        $this->redirect(Helpers::routePath('/mitra/profile/edit'));
    }
}
