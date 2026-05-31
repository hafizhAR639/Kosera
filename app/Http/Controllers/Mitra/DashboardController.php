<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Service;
use App\Models\Earning;
use App\Models\Certificate;
use App\Models\Portfolio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id() ?? 1;
        
        // Query pesanan bulan ini
        $monthlyOrdersCount = Order::whereHas('service', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->whereMonth('created_at', now()->month)
        ->whereYear('created_at', now()->year)
        ->count();

        // Total pendapatan dari earnings completed
        $totalIncome = Earning::where('user_id', $userId)
            ->where('status', 'paid')
            ->sum('jumlah');

        // Jumlah layanan aktif
        $servicesCount = Service::where('user_id', $userId)
            ->where('status', 'active')
            ->count();

        // Total semua orders
        $totalOrders = Order::whereHas('service', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->count();

        // Orders completed
        $completedOrders = Order::whereHas('service', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->where('status', 'completed')
        ->count();

        // Orders pending
        $pendingOrders = Order::whereHas('service', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->where('status', 'pending')
        ->count();

        // Recent orders (6 bulan terakhir) dengan relasi user dan service
        $recentOrders = Order::whereHas('service', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->with(['service:id,nama_layanan', 'user:id,nama'])
        ->latest('created_at')
        ->limit(5)
        ->get()
        ->map(function ($order) {
            return [
                'order_code' => $order->order_code,
                'customer_name' => $order->customer_name,
                'service_name' => $order->service->nama_layanan,
                'total_price' => $order->total_harga,
                'status' => $order->status,
            ];
        });

        // Chart data: earnings per bulan (6 bulan terakhir)
        $chartData = [];
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $labels[] = $date->format('M');

            $monthlyEarnings = Earning::where('user_id', $userId)
                ->where('status', 'paid')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('jumlah');
            
            $chartData[] = (float)$monthlyEarnings;
        }

        $chartData = [
            'labels' => $labels,
            'data' => $chartData,
        ];

        // Recent certificates
        $recentCertificates = Certificate::where('user_id', $userId)
            ->latest('created_at')
            ->limit(2)
            ->get()
            ->map(function ($cert) {
                return [
                    'name' => $cert->nama_sertifikat,
                    'status' => $cert->status,
                    'issued_by' => $cert->penerbit ?? 'N/A',
                    'category' => $cert->kategori ?? 'Umum',
                ];
            })->toArray();

        // Recent portfolio
        $recentPortfolio = Portfolio::where('user_id', $userId)
            ->latest('created_at')
            ->limit(2)
            ->get()
            ->map(function ($port) {
                return [
                    'title' => $port->judul,
                    'status' => $port->status,
                    'category' => $port->kategori ?? 'Umum',
                    'rating' => $port->rating ?? 0,
                ];
            })->toArray();

        $stats = [
            'monthly_orders' => $monthlyOrdersCount,
            'total_income' => $totalIncome,
            'services_count' => $servicesCount,
            'total_orders' => $totalOrders,
            'completed' => $completedOrders,
            'pending' => $pendingOrders,
            'total_revenue' => $totalIncome,
        ];

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
