<?php

namespace App\Controllers\Mitra;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Helpers;

class DashboardController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();

        // Use MitraService (wraps legacy DashboardModel) to fetch data
        $service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());

        $user = $service->getUserById($userId);
        if ($user === null) {
            Helpers::setMessage('error', 'Data pengguna tidak ditemukan.');
            $this->redirect(Helpers::routePath('/logout'));
        }

        $stats = $service->getStats($userId);
        $recentOrders = $service->getRecentOrders($userId, 5);
        $recentCertificates = $service->getRecentCertificates($userId, 4);
        $recentPortfolio = $service->getRecentPortfolio($userId, 4);

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
