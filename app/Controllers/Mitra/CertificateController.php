<?php

namespace App\Controllers\Mitra;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Helpers;

class CertificateController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $userId = (int) Auth::getCurrentUserId();
        $category = $_GET['category'] ?? '';
        $search = $_GET['search'] ?? '';

        $service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());

        $certs = $service->getCertificates($userId, $category, $search);
        $count = $service->countCertificates($userId, $category, $search);

        $this->render('mitra/certificates', [
            'title' => 'Sertifikat',
            'message' => Helpers::getMessage(),
            'certificates' => $certs,
            'count' => $count,
        ], 'mitra');
    }

    public function store(): void
    {
        Auth::requireLogin();

        $userId = (int) Auth::getCurrentUserId();

        $payload = [
            'nama_sertifikat' => $_POST['nama_sertifikat'] ?? '',
            'penerbit' => $_POST['penerbit'] ?? '',
            'tanggal_terbit' => $_POST['tanggal_terbit'] ?? '',
            'tanggal_kadaluarsa' => $_POST['tanggal_kadaluarsa'] ?? '',
            'nomor_sertifikat' => $_POST['nomor_sertifikat'] ?? '',
            'kategori' => $_POST['kategori'] ?? '',
            'file_path' => $_POST['file_path'] ?? '',
        ];

        $service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());
        $ok = $service->createCertificate($userId, $payload);

        if ($ok) {
            Helpers::setMessage('success', 'Sertifikat berhasil ditambahkan.');
        } else {
            Helpers::setMessage('error', 'Gagal menambahkan sertifikat.');
        }

        $this->redirect(Helpers::routePath('/mitra/certificates'));
    }

    public function update(): void
    {
        Auth::requireLogin();

        $userId = (int) Auth::getCurrentUserId();
        $id = (int) ($_POST['id'] ?? 0);

        $payload = [
            'nama_sertifikat' => $_POST['nama_sertifikat'] ?? '',
            'penerbit' => $_POST['penerbit'] ?? '',
            'tanggal_terbit' => $_POST['tanggal_terbit'] ?? '',
            'tanggal_kadaluarsa' => $_POST['tanggal_kadaluarsa'] ?? '',
            'nomor_sertifikat' => $_POST['nomor_sertifikat'] ?? '',
            'kategori' => $_POST['kategori'] ?? '',
        ];

        $service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());
        $ok = $service->updateCertificate($userId, $id, $payload);

        if ($ok) {
            Helpers::setMessage('success', 'Sertifikat berhasil diperbarui.');
        } else {
            Helpers::setMessage('error', 'Gagal memperbarui sertifikat.');
        }

        $this->redirect(Helpers::routePath('/mitra/certificates'));
    }

    public function destroy(): void
    {
        Auth::requireLogin();

        $userId = (int) Auth::getCurrentUserId();
        $id = (int) ($_POST['id'] ?? 0);

        $service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());
        $ok = $service->deleteCertificate($userId, $id);

        if ($ok) {
            Helpers::setMessage('success', 'Sertifikat berhasil dihapus.');
        } else {
            Helpers::setMessage('error', 'Gagal menghapus sertifikat.');
        }

        $this->redirect(Helpers::routePath('/mitra/certificates'));
    }
}
