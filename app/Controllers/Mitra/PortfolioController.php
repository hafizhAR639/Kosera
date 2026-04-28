<?php

namespace App\Controllers\Mitra;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Helpers;
use App\Models\Mitra\PortfolioModel;

class PortfolioController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $model = new PortfolioModel();

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

        $portfolios = $model->getListByUser($userId, $category, $search, $perPage, $offset);

        $this->render('mitra/portfolio', [
            'title' => 'Portfolio',
            'portfolios' => $portfolios,
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
        $payload = [
            'judul' => Helpers::sanitize($_POST['judul'] ?? ''),
            'deskripsi' => Helpers::sanitize($_POST['deskripsi'] ?? ''),
            'kategori' => Helpers::sanitize($_POST['kategori'] ?? ''),
            'tanggal_project' => Helpers::sanitize($_POST['tanggal_project'] ?? ''),
            'client_name' => Helpers::sanitize($_POST['client_name'] ?? ''),
            'lokasi' => Helpers::sanitize($_POST['lokasi'] ?? ''),
            'nilai_project' => (float)($_POST['nilai_project'] ?? 0),
            'durasi_hari' => (int)($_POST['durasi_hari'] ?? 0),
        ];

        $ok = (new PortfolioModel())->create($userId, $payload);
        Helpers::setMessage($ok ? 'success' : 'error', $ok ? 'Portfolio berhasil ditambahkan!' : 'Gagal menambahkan portfolio');

        $this->redirect(Helpers::routePath('/mitra/portfolio'));
    }

    public function update(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $id = (int)($_POST['id'] ?? 0);

        $payload = [
            'judul' => Helpers::sanitize($_POST['judul'] ?? ''),
            'deskripsi' => Helpers::sanitize($_POST['deskripsi'] ?? ''),
            'kategori' => Helpers::sanitize($_POST['kategori'] ?? ''),
            'tanggal_project' => Helpers::sanitize($_POST['tanggal_project'] ?? ''),
            'client_name' => Helpers::sanitize($_POST['client_name'] ?? ''),
            'lokasi' => Helpers::sanitize($_POST['lokasi'] ?? ''),
            'nilai_project' => (float)($_POST['nilai_project'] ?? 0),
            'durasi_hari' => (int)($_POST['durasi_hari'] ?? 0),
        ];

        $ok = (new PortfolioModel())->update($userId, $id, $payload);
        Helpers::setMessage($ok ? 'success' : 'error', $ok ? 'Portfolio berhasil diupdate!' : 'Gagal mengupdate portfolio');

        $this->redirect(Helpers::routePath('/mitra/portfolio'));
    }

    public function destroy(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $id = (int)($_POST['id'] ?? 0);

        $ok = (new PortfolioModel())->delete($userId, $id);
        Helpers::setMessage($ok ? 'success' : 'error', $ok ? 'Portfolio berhasil dihapus!' : 'Gagal menghapus portfolio');

        $this->redirect(Helpers::routePath('/mitra/portfolio'));
    }
}
