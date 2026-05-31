<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Services\MitraService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(private MitraService $mitraService) {}

    public function index()
    {
        $userId = Auth::id() ?? 1;
        $stats = $this->mitraService->getStats($userId);
        $recentOrders = $this->mitraService->getRecentOrders($userId, 5);
        $recentCertificates = $this->mitraService->getRecentCertificates($userId, 4);
        $recentPortfolio = $this->mitraService->getRecentPortfolio($userId, 4);
        $chartData = $this->mitraService->getRevenueChart($userId, 6);

        return view('mitra.dashboard', [
            'title' => 'Dashboard',
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'chartData' => $chartData,
            'recentCertificates' => $recentCertificates,
            'recentPortfolio' => $recentPortfolio,
        ]);
    }
}
