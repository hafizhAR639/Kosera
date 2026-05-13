<?php

namespace App\Controllers\Mitra;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Helpers;
use App\Models\Mitra\DashboardModel;

class DashboardController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $model = new DashboardModel();

        $user = $model->getUserById($userId);
        if ($user === null) {
            Helpers::setMessage('error', 'Data pengguna tidak ditemukan.');
            $this->redirect(Helpers::routePath('/logout'));
        }

        $stats = $model->getStats($userId);
        $recentOrders = $model->getRecentOrders($userId);
        $recentCertificates = $model->getRecentCertificates($userId);
        $recentPortfolio = $model->getRecentPortfolio($userId);

        $this->render('mitra/dashboard', [
            'title' => 'Dashboard Mitra',
            'message' => Helpers::getMessage(),
            'user' => $user,
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'recentCertificates' => $recentCertificates,
            'recentPortfolio' => $recentPortfolio,
            'monthlyOrders' => (int)($stats['monthly_orders'] ?? 0),
            'totalIncome' => (float)($stats['total_revenue'] ?? 0),
            'servicesCount' => (int)($stats['total_services'] ?? 0),
            'point' => (int)($stats['total_points'] ?? 0),
        ], 'mitra');
    }
}
