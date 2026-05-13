<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Order;
use App\Models\Portfolio;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();

        $stats = [
            'total_orders' => Order::where('user_id', $userId)->count(),
            'completed_orders' => Order::where('user_id', $userId)->where('status', 'completed')->count(),
            'pending_orders' => Order::where('user_id', $userId)->where('status', 'pending')->count(),
            'in_progress_orders' => Order::where('user_id', $userId)->where('status', 'in_progress')->count(),
            'total_earnings' => Order::where('user_id', $userId)->where('status', 'completed')->sum('total_harga'),
            'total_portfolios' => Portfolio::where('user_id', $userId)->count(),
            'total_certificates' => Certificate::where('user_id', $userId)->count(),
            'total_services' => Service::where('user_id', $userId)->count(),
        ];

        $recentOrders = Order::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('mitra.dashboard', [
            'title' => 'Dashboard',
            'stats' => $stats,
            'recentOrders' => $recentOrders,
        ]);
    }
}
