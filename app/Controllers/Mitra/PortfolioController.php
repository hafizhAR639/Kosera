<?php

namespace App\Controllers\Mitra;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Helpers;

class PortfolioController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $userId = (int) Auth::getCurrentUserId();
        $category = $_GET['category'] ?? '';
        $search = $_GET['search'] ?? '';

        $service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());

        $items = $service->getPortfolio($userId, $category, $search);
        $count = $service->countPortfolio($userId, $category, $search);

        $this->render('mitra/portfolio/index', [
            'title' => 'Portfolio',
            'message' => Helpers::getMessage(),
            'items' => $items,
            'count' => $count,
        ], 'mitra');
    }

    public function store(): void
    {
        Auth::requireLogin();

        $userId = (int) Auth::getCurrentUserId();

        $payload = [
            'judul' => $_POST['judul'] ?? '',
            'deskripsi' => $_POST['deskripsi'] ?? '',
            'kategori' => $_POST['kategori'] ?? '',
            'tanggal_project' => $_POST['tanggal_project'] ?? '',
            'client_name' => $_POST['client_name'] ?? '',
            'lokasi' => $_POST['lokasi'] ?? '',
            'nilai_project' => $_POST['nilai_project'] ?? 0,
            'durasi_hari' => $_POST['durasi_hari'] ?? 0,
        ];

        $service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());
        $ok = $service->createPortfolio($userId, $payload);

        if ($ok) {
            Helpers::setMessage('success', 'Portfolio berhasil ditambahkan.');
        } else {
            Helpers::setMessage('error', 'Gagal menambahkan portfolio.');
        }

        $this->redirect(Helpers::routePath('/mitra/portfolio'));
    }

    public function update(): void
    {
        Auth::requireLogin();

        $userId = (int) Auth::getCurrentUserId();
        $id = (int) ($_POST['id'] ?? 0);

        $payload = [
            'judul' => $_POST['judul'] ?? '',
            'deskripsi' => $_POST['deskripsi'] ?? '',
            'kategori' => $_POST['kategori'] ?? '',
            'tanggal_project' => $_POST['tanggal_project'] ?? '',
            'client_name' => $_POST['client_name'] ?? '',
            'lokasi' => $_POST['lokasi'] ?? '',
            'nilai_project' => $_POST['nilai_project'] ?? 0,
            'durasi_hari' => $_POST['durasi_hari'] ?? 0,
        ];

        $service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());
        $ok = $service->updatePortfolio($userId, $id, $payload);

        if ($ok) {
            Helpers::setMessage('success', 'Portfolio berhasil diperbarui.');
        } else {
            Helpers::setMessage('error', 'Gagal memperbarui portfolio.');
        }

        $this->redirect(Helpers::routePath('/mitra/portfolio'));
    }

    public function destroy(): void
    {
        Auth::requireLogin();

        $userId = (int) Auth::getCurrentUserId();
        $id = (int) ($_POST['id'] ?? 0);

        $service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());
        $ok = $service->deletePortfolio($userId, $id);

        if ($ok) {
            Helpers::setMessage('success', 'Portfolio berhasil dihapus.');
        } else {
            Helpers::setMessage('error', 'Gagal menghapus portfolio.');
        }

        $this->redirect(Helpers::routePath('/mitra/portfolio'));
    }
}
