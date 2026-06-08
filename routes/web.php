<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\User;
use App\Models\Portfolio;
use App\Models\IdentityVerification;
use App\Models\Service;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Mitra\DashboardController;
use App\Http\Controllers\Mitra\PortfolioController;
use App\Http\Controllers\Mitra\CertificateController;
use App\Http\Controllers\Mitra\IncomingOrdersController;
use App\Http\Controllers\Mitra\OrderHistoryController;
use App\Http\Controllers\Mitra\ProfileController as MitraProfileController;
use App\Http\Controllers\Mitra\ServiceController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ProfileController as UserProfileController;
use App\Http\Controllers\User\RatingController;
use App\Http\Controllers\User\ServiceController as UserServiceController;
use App\Http\Controllers\User\OrderController as UserOrderController;

Route::get('/', function () {
    return view('user.welome');
})->name('welcome');

Route::get('/admin', function () {
    return view('mitra.welcome');
})->name('admin.welcome');

Route::get('/user/layanan', function () {
    return redirect()->route('mitra.portfolio.index');
})->name('user.layanan');

Route::get('/admin/layanan', function () {
    return redirect()->route('mitra.portfolio.index');
})->name('admin.layanan');

Route::get('/user', function () {
    return redirect()->route('user.dashboard');
})->name('user.home');

Route::get('/user/dashboard', function () {
    $search = request()->query('search', '');
    $category = request()->query('category', 'all');

    $servicesQuery = Service::query()
        ->where('status', 'active')
        ->with(['user:id,nama,phone,location']);

    if ($category !== 'all') {
        $servicesQuery->where('kategori', $category);
    }

    if ($search !== '') {
        $servicesQuery->where(function ($query) use ($search) {
            $query->where('nama_layanan', 'like', "%{$search}%")
                ->orWhere('deskripsi', 'like', "%{$search}%")
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('nama', 'like', "%{$search}%");
                });
        });
    }

    $services = $servicesQuery
        ->latest('views')
        ->limit(9)
        ->get();

    $categories = Service::where('status', 'active')
        ->select('kategori')
        ->distinct()
        ->pluck('kategori');

    return view('user.dashboard', [
        'services' => $services,
        'categories' => $categories,
        'filters' => [
            'search' => $search,
            'category' => $category,
        ],
    ]);
})->name('user.dashboard');

//Route::get('/user/konfirmasi-pesanan', function () {
   // return view('user.konfirmasi-pesanan');
//})->name('user.order.confirm');

Route::get('/user/pembayaran-berhasil', function () {
    return app(PaymentController::class)->success();
})->name('user.payment.success');

Route::get('/preview/mitra-layout', function () {
    return view('layouts.mitra', [
        'title' => 'Preview',
    ]);
})->name('preview.mitra-layout');

// Authentication Routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', function (Request $request) {
    // TODO: Auth logic disabled for route preview
    return redirect()->route('user.dashboard');
});
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::get('/register/step-2', function () {
    return view('auth.register_step2');
})->name('register.step2');
Route::get('/register/step-3', function () {
    return view('auth.register_step3');
})->name('register.step3');
Route::get('/register/step-4', function () {
    return view('auth.register_step4');
})->name('register.step4');
Route::post('/register', [AuthController::class, 'processStepRegistration']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Mitra Routes
Route::prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Orders - incoming, status update, history and export
    Route::get('orders/incoming', [IncomingOrdersController::class, 'index'])->name('orders.incoming');
    Route::post('orders/incoming/status', [IncomingOrdersController::class, 'updateStatus'])->name('orders.incoming.status');

    Route::get('orders/history', [OrderHistoryController::class, 'index'])->name('orders.history');
    Route::get('orders/history/export', [OrderHistoryController::class, 'export'])->name('orders.history.export');

    Route::patch('orders/{id}/update-progress', [OrderHistoryController::class, 'updateProgress'])->name('orders.update_progress');

    // Profile: show, edit, update
    Route::get('profile', [MitraProfileController::class, 'show'])->name('profile.show');
    Route::get('profile/edit', [MitraProfileController::class, 'edit'])->name('profile.edit');
    Route::post('profile/edit', [MitraProfileController::class, 'update'])->name('profile.update');

    Route::resource('portfolio', PortfolioController::class);
    Route::resource('layanan', ServiceController::class);
    Route::resource('certificates', CertificateController::class);

    Route::get('earnings', function () {
        $userId = Auth::id() ?? 1;
        $stats = app(\App\Services\MitraService::class)->getStats($userId);
        $chartData = app(\App\Services\MitraService::class)->getRevenueChart($userId, 12);
        return view('mitra.earnings', [
            'title' => 'Grafik Pendapatan',
            'stats' => $stats,
            'chartData' => $chartData
        ]);
    })->name('earnings');
});

// User Routes - Services & Orders
Route::prefix('user')->name('user.')->group(function () {
    // Profile - show and edit
    Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/edit', [UserProfileController::class, 'update'])->name('profile.update');

    // Services - browse and view
    Route::get('/services', function () {
        return redirect()->route('user.dashboard');
    })->name('services.index');
    Route::get('/services/{service}', [UserServiceController::class, 'show'])->name('services.show');
    Route::get('/mitra/{mitra}', [UserServiceController::class, 'showMitra'])->name('services.showMitra');

    // Orders - history, detail, create, store, cancel
    Route::get('/riwayat', [UserOrderController::class, 'history'])->name('orders.history');
    Route::get('/detail-pesanan/{order?}', [UserOrderController::class, 'detail'])->name('orders.detail');
    Route::get('/orders/create', [UserOrderController::class, 'create'])->name('orders.create');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [UserOrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{order}/cancel', [UserOrderController::class, 'cancel'])->name('orders.cancel');
    
    // Rating route
    Route::post('/orders/rating/store', [RatingController::class, 'store'])->name('orders.rating.store');
});
