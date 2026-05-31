<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\User;
use App\Models\Portfolio;
use App\Models\BankAccount;
use App\Models\IdentityVerification;
use App\Models\Service;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Mitra\DashboardController;
use App\Http\Controllers\Mitra\PortfolioController;
use App\Http\Controllers\Mitra\CertificateController;
use App\Http\Controllers\Mitra\IncomingOrdersController;
use App\Http\Controllers\Mitra\ServiceController;
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
    return view('user.dashboard');
})->name('user.dashboard');

Route::get('/user/konfirmasi-pesanan', function () {
    return view('user.konfirmasi-pesanan');
})->name('user.order.confirm');

Route::get('/user/pembayaran-berhasil', function () {
    $userId = Auth::id() ?? session('user_id', 1);

    $order = Order::where('user_id', $userId)
        ->latest('created_at')
        ->first();

    return view('user.payment-success', [
        'order' => $order,
    ]);
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
Route::post('/register', function (Request $request) {
    // Simple session-backed progressive registration storage (KISS) with DB persistence
    $data = $request->except('_token');

    // merge into session (preserve previous steps)
    $stored = session('register.data', []);
    $stored = array_merge($stored, $data);
    session(['register.data' => $stored]);

    // If bank details are present, treat as final step: create all records to DB
    if (!empty($data['nama_bank']) || !empty($data['nomor_rekening'])) {
        $reg = session('register.data', []);
        $email = $reg['email'] ?? null;

        if ($email && User::where('email', $email)->exists()) {
            session()->flash('message', ['type' => 'warning', 'text' => 'Email sudah terdaftar. Silakan masuk.']);
            session()->forget('register.data');
            return redirect()->route('login');
        }

        // create user with role
        $password = $reg['password'] ?? bin2hex(random_bytes(8));
        $user = User::create([
            'nama' => $reg['nama'] ?? 'Pengguna Baru',
            'email' => $email,
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'phone' => $reg['phone'] ?? null,
            'location' => $reg['alamat'] ?? null,
            'role' => $reg['role'] ?? 'user',
            'status' => 'active',
        ]);

        // create bank account record
        if (!empty($reg['nama_bank'])) {
            BankAccount::create([
                'user_id' => $user->id,
                'nama_bank' => $reg['nama_bank'],
                'nama_rekening' => $reg['nama_rekening'] ?? null,
                'nomor_rekening' => $reg['nomor_rekening'] ?? null,
                'alamat_bank' => $reg['alamat_bank'] ?? null,
            ]);
        }

        // create identity verification record (if mitra)
        if ($reg['role'] === 'mitra' && !empty($reg['nik'])) {
            IdentityVerification::create([
                'user_id' => $user->id,
                'nik' => $reg['nik'],
                'foto_ktp' => $reg['foto_ktp'] ?? null,
                'selfie_ktp' => $reg['selfie_ktp'] ?? null,
                'status' => 'pending',
            ]);
        }

        // create initial portfolio record if deskripsi is present and mitra
        if ($reg['role'] === 'mitra' && !empty($reg['deskripsi_portofolio'])) {
            Portfolio::create([
                'user_id' => $user->id,
                'judul' => 'Portfolio Awal',
                'deskripsi' => $reg['deskripsi_portofolio'],
                'kategori' => 'Lainnya',
                'status' => 'draft',
            ]);
        }

        session()->flash('message', ['type' => 'success', 'text' => 'Akun dibuat. Silakan masuk.']);
        session()->forget('register.data');
        return redirect()->route('login');
    }

    // Determine which step to route to based on data presence
    $role = $data['role'] ?? session('register.data.role', 'user');
    
    // If portfolio description or portfolio file is present, next is step4 (keuangan)
    if (!empty($data['deskripsi_portofolio']) || !empty($data['portfolio_file'])) {
        return redirect()->route('register.step4', ['role' => $role]);
    }

    // If NIK is present, route based on role
    if (!empty($data['nik'])) {
        // If mitra and has NIK, go to step3 (portfolio)
        if ($role === 'mitra') {
            return redirect()->route('register.step3', ['role' => 'mitra']);
        }
        // If user and has NIK, go to step4 (keuangan)
        return redirect()->route('register.step4', ['role' => 'user']);
    }

    // If only basic profile (nama, email, etc), go to step2 (verifikasi)
    if (!empty($data['nama']) && !empty($data['email'])) {
        if ($role === 'mitra') {
            return redirect()->route('register.step2', ['role' => 'mitra']);
        }
        return redirect()->route('register.step2', ['role' => 'user']);
    }

    // Default fallback
    return redirect()->route('register');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Mitra Routes
Route::prefix('mitra')->name('mitra.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Orders - incoming, status update, history and export
    Route::get('orders/incoming', [IncomingOrdersController::class, 'index'])->name('orders.incoming');
    Route::post('orders/incoming/status', [IncomingOrdersController::class, 'updateStatus'])->name('orders.incoming.status');

    Route::get('orders/history', function (Request $request) {
        $userId = Auth::id() ?? 1;
        $statusFilter = $request->query('status', 'all');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $q = Order::where('user_id', $userId);
        if ($statusFilter !== 'all') {
            $q->where('status', $statusFilter);
        }
        if ($dateFrom) {
            $q->whereDate('tanggal_order', '>=', $dateFrom);
        }
        if ($dateTo) {
            $q->whereDate('tanggal_order', '<=', $dateTo);
        }

        $orders = $q->orderBy('created_at', 'desc')->get()->map(function ($o) {
            return [
                'order_code' => $o->order_code,
                'customer_name' => $o->customer_name,
                'address' => $o->alamat ?? $o->address ?? '-',
                'service_name' => $o->service_name,
                'service_type' => $o->service_type ?? 'Lainnya',
                'total_price' => $o->total_harga ?? $o->total_price ?? 0,
                'order_date' => $o->tanggal_order ?? $o->created_at,
                'order_code' => $o->order_code,
                'order' => $o,
                'status' => $o->status,
            ];
        })->toArray();

        $stats = [
            'total_orders' => Order::where('user_id', $userId)->count(),
            'completed' => Order::where('user_id', $userId)->where('status', 'completed')->count(),
            'pending' => Order::where('user_id', $userId)->where('status', 'pending')->count(),
            'total_revenue' => Order::where('user_id', $userId)->where('status', 'completed')->sum('total_harga'),
        ];

        return view('user.riwayat', [
            'orders' => $orders,
            'statusFilter' => $statusFilter,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'stats' => $stats,
        ]);
    })->name('orders.history');

    Route::get('orders/history/export', function (Request $request) {
        $userId = Auth::id() ?? 1;
        $status = $request->query('status', 'all');
        $dateFrom = $request->query('date_from');
        $dateTo = $request->query('date_to');

        $q = Order::where('user_id', $userId);
        if ($status !== 'all') $q->where('status', $status);
        if ($dateFrom) $q->whereDate('tanggal_order', '>=', $dateFrom);
        if ($dateTo) $q->whereDate('tanggal_order', '<=', $dateTo);

        $rows = $q->orderBy('created_at', 'desc')->get()->map(function ($o) {
            return [
                'order_code' => $o->order_code,
                'customer_name' => $o->customer_name,
                'service_name' => $o->service_name,
                'total_price' => $o->total_harga ?? $o->total_price ?? 0,
                'order_date' => $o->tanggal_order ?? $o->created_at,
                'status' => $o->status,
            ];
        })->toArray();

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Order Code', 'Customer', 'Service', 'Total', 'Order Date', 'Status']);
            foreach ($rows as $r) {
                fputcsv($out, [$r['order_code'], $r['customer_name'], $r['service_name'], $r['total_price'], $r['order_date'], $r['status']]);
            }
            fclose($out);
        };

        return response()->streamDownload($callback, 'orders_export.csv', ['Content-Type' => 'text/csv']);
    })->name('orders.history.export');

    // Profile: show, edit, update
    Route::get('profile', function () {
        $user = Auth::user() ?? User::find(1);
        $profile = $user ? $user->toArray() : [];

        return view('mitra.profile', [
            'profile' => $profile,
        ]);
    })->name('profile.show');

    Route::get('profile/edit', function () {
        $user = Auth::user() ?? User::find(1);
        $profile = $user ? $user->toArray() : [];
        $bankAccount = $user ? BankAccount::where('user_id', $user->id)->first() : null;

        return view('mitra.profile_edit', [
            'profile' => $profile,
            'bankAccount' => $bankAccount ? $bankAccount->toArray() : [],
        ]);
    })->name('profile.edit');

    Route::post('profile/edit', function (Request $request) {
        $user = Auth::user() ?? User::find(1);
        if (! $user) {
            return redirect()->route('mitra.dashboard');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'location' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'avatar' => 'nullable|image|max:4096',
            'nama_bank' => 'nullable|string|max:100',
            'nama_rekening' => 'nullable|string|max:100|required_with:nama_bank,nomor_rekening',
            'nomor_rekening' => 'nullable|string|max:50|required_with:nama_bank,nama_rekening',
            'alamat_bank' => 'nullable|string|max:255',
        ]);

        $data = [
            'nama' => $validated['nama'],
            'phone' => $validated['phone'] ?? null,
            'location' => $validated['location'] ?? null,
            'bio' => $validated['bio'] ?? null,
        ];

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = '/storage/' . $path;
        }

        $user->fill($data);
        $user->save();

        $hasBankInput = !empty($validated['nama_bank'] ?? null)
            || !empty($validated['nama_rekening'] ?? null)
            || !empty($validated['nomor_rekening'] ?? null)
            || !empty($validated['alamat_bank'] ?? null);

        if ($hasBankInput) {
            BankAccount::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama_bank' => $validated['nama_bank'] ?? '',
                    'nama_rekening' => $validated['nama_rekening'] ?? '',
                    'nomor_rekening' => $validated['nomor_rekening'] ?? '',
                    'alamat_bank' => $validated['alamat_bank'] ?? null,
                ]
            );
        }

        return redirect()->route('mitra.profile.show')->with('message', ['type' => 'success', 'text' => 'Profil berhasil diperbarui.']);
    })->name('profile.update');

    Route::resource('portfolio', PortfolioController::class);
        Route::resource('layanan', ServiceController::class);
    Route::resource('certificates', CertificateController::class);
});

// User Routes - Services & Orders
Route::prefix('user')->name('user.')->group(function () {
    // Profile - show and edit
    Route::get('/profile', function () {
        $user = Auth::user() ?? User::find(1);
        return view('user.profile', ['user' => $user]);
    })->name('profile.show');

    Route::get('/profile/edit', function () {
        $user = Auth::user() ?? User::find(1);
        return view('user.profile_edit', ['user' => $user]);
    })->name('profile.edit');

    Route::post('/profile/edit', function (Request $request) {
        $user = Auth::user() ?? User::find(1);
        if (!$user) {
            return redirect()->route('user.dashboard');
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
            'location' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
        ]);

        $user->fill([
            'nama' => $validated['nama'],
            'phone' => $validated['phone'],
            'location' => $validated['location'],
            'address' => $validated['address'],
        ])->save();

        return redirect()->route('user.profile.show')->with('message', ['type' => 'success', 'text' => 'Profil berhasil diperbarui.']);
    })->name('profile.update');

    // Services - browse and view
    Route::get('/services', function () {
        return redirect()->route('user.dashboard');
    })->name('services.index');
    Route::get('/services/{service}', [UserServiceController::class, 'show'])->name('services.show');
    Route::get('/mitra/{mitra}', [UserServiceController::class, 'showMitra'])->name('services.showMitra');

    // Orders - history, detail, create, store, cancel
    Route::get('/riwayat', [UserOrderController::class, 'history'])->name('orders.history');
    Route::get('/detail-pesanan/{order?}', [UserOrderController::class, 'detail'])->name('orders.detail');
    Route::get('/orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/create', [UserOrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [UserOrderController::class, 'store'])->name('orders.store');
    Route::post('/orders/{order}/cancel', [UserOrderController::class, 'cancel'])->name('orders.cancel');
    
    // Rating route
    Route::post('/orders/rating/store', function (Request $request) {
        $validated = $request->validate([
            'order_id' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Dummy: store rating in session or database
        // In production, create Rating model and store properly
        session()->push('ratings', $validated);

        return response()->json(['success' => true, 'message' => 'Rating berhasil disimpan']);
    })->name('orders.rating.store');
});
