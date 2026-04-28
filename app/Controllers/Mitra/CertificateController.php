<?php

namespace App\Controllers\Mitra;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Helpers;
use App\Models\Mitra\CertificateModel;

class CertificateController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $model = new CertificateModel();

        $category = Helpers::sanitize($_GET['category'] ?? 'all');
        $search = Helpers::sanitize($_GET['q'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 9;
        $offset = ($page - 1) * $perPage;

        $total = $model->countByUser($userId, $category, $search);
        $totalPages = max(1, (int)ceil($total / $perPage));
        if ($page > $totalPages) {
            $page = $totalPages;
            $offset = ($page - 1) * $perPage;
        }

        $certificates = $model->getListByUser($userId, $category, $search, $perPage, $offset);

        $this->render('mitra/certificates', [
            'title' => 'Sertifikat',
            'certificates' => $certificates,
            'filters' => [
                'category' => $category,
                'q' => $search,
                'page' => $page,
                'perPage' => $perPage,
                'total' => $total,
                'totalPages' => $totalPages,
            ],
            'message' => Helpers::getMessage(),
        ], 'mitra');
    }

    public function store(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $filePath = '';

        if (isset($_FILES['file_sertifikat']) && $_FILES['file_sertifikat']['error'] === 0) {
            $upload = Helpers::uploadFile($_FILES['file_sertifikat'], 'uploads/certificates/', ['jpg', 'jpeg', 'png', 'pdf']);
            if (!$upload['success']) {
                Helpers::setMessage('error', $upload['message']);
                $this->redirect(Helpers::routePath('/mitra/certificates'));
            }
            $filePath = $upload['file_path'];
        }

        $payload = [
            'nama_sertifikat' => Helpers::sanitize($_POST['nama_sertifikat'] ?? ''),
            'penerbit' => Helpers::sanitize($_POST['penerbit'] ?? ''),
            'tanggal_terbit' => Helpers::sanitize($_POST['tanggal_terbit'] ?? ''),
            'tanggal_kadaluarsa' => Helpers::sanitize($_POST['tanggal_kadaluarsa'] ?? ''),
            'nomor_sertifikat' => Helpers::sanitize($_POST['nomor_sertifikat'] ?? ''),
            'kategori' => Helpers::sanitize($_POST['kategori'] ?? ''),
            'file_path' => $filePath,
        ];

        $ok = (new CertificateModel())->create($userId, $payload);
        Helpers::setMessage($ok ? 'success' : 'error', $ok ? 'Sertifikat berhasil ditambahkan!' : 'Gagal menambahkan sertifikat');

        $this->redirect(Helpers::routePath('/mitra/certificates'));
    }

    public function update(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $id = (int)($_POST['id'] ?? 0);

        $payload = [
            'nama_sertifikat' => Helpers::sanitize($_POST['nama_sertifikat'] ?? ''),
            'penerbit' => Helpers::sanitize($_POST['penerbit'] ?? ''),
            'tanggal_terbit' => Helpers::sanitize($_POST['tanggal_terbit'] ?? ''),
            'tanggal_kadaluarsa' => Helpers::sanitize($_POST['tanggal_kadaluarsa'] ?? ''),
            'nomor_sertifikat' => Helpers::sanitize($_POST['nomor_sertifikat'] ?? ''),
            'kategori' => Helpers::sanitize($_POST['kategori'] ?? ''),
        ];

        $ok = (new CertificateModel())->update($userId, $id, $payload);
        Helpers::setMessage($ok ? 'success' : 'error', $ok ? 'Sertifikat berhasil diupdate!' : 'Gagal mengupdate sertifikat');

        $this->redirect(Helpers::routePath('/mitra/certificates'));
    }

    public function destroy(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $id = (int)($_POST['id'] ?? 0);

        $ok = (new CertificateModel())->delete($userId, $id);
        Helpers::setMessage($ok ? 'success' : 'error', $ok ? 'Sertifikat berhasil dihapus!' : 'Gagal menghapus sertifikat');

        $this->redirect(Helpers::routePath('/mitra/certificates'));
    }
}
