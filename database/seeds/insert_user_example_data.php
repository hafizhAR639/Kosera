<?php

/**
 * USER EXAMPLE DATA INSERT
 * 
 * Simple script to insert example customer users and orders
 * KISS principle: Direct, simple, no complexity
 * 
 * Usage:
 * php artisan tinker
 * include('database/seeds/insert_user_example_data.php')
 */

// STEP 1: Create customer users (role='user')
echo "\n=== Creating Customer Users ===\n";

$customers = [
    [
        'nama' => 'Budi Santoso',
        'email' => 'budi.santoso@email.com',
        'phone' => '081234567890',
        'location' => 'Jakarta, Indonesia',
        'role' => 'user',
        'status' => 'active',
    ],
    [
        'nama' => 'Siti Nurhaliza',
        'email' => 'siti.nurhaliza@email.com',
        'phone' => '081345678901',
        'location' => 'Surabaya, Indonesia',
        'role' => 'user',
        'status' => 'active',
    ],
    [
        'nama' => 'Ahmad Rahman',
        'email' => 'ahmad.rahman@email.com',
        'phone' => '081456789012',
        'location' => 'Bandung, Indonesia',
        'role' => 'user',
        'status' => 'active',
    ],
    [
        'nama' => 'Dewi Lestari',
        'email' => 'dewi.lestari@email.com',
        'phone' => '081567890123',
        'location' => 'Medan, Indonesia',
        'role' => 'user',
        'status' => 'active',
    ],
    [
        'nama' => 'Rudi Hermawan',
        'email' => 'rudi.hermawan@email.com',
        'phone' => '081678901234',
        'location' => 'Yogyakarta, Indonesia',
        'role' => 'user',
        'status' => 'active',
    ],
];

$customerIds = [];
foreach ($customers as $customer) {
    $user = \App\Models\User::firstOrCreate(
        ['email' => $customer['email']],
        array_merge($customer, [
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'join_date' => now(),
        ])
    );
    $customerIds[] = $user->id;
    echo "✓ Created/Found customer: {$user->nama} (ID: {$user->id})\n";
}

// STEP 2: Get existing services
echo "\n=== Fetching Available Services ===\n";

$services = \App\Models\Service::where('status', 'active')
    ->limit(5)
    ->get();

if ($services->isEmpty()) {
    echo "❌ No active services found! Seed mitra data first.\n";
    return;
}

echo "✓ Found " . $services->count() . " active services\n";

// STEP 3: Create orders linking customers to services
echo "\n=== Creating Example Orders ===\n";

$statuses = ['pending', 'confirmed', 'completed'];
$paymentStatuses = ['unpaid', 'paid'];
$orderCount = 0;

foreach ($customerIds as $customerId) {
    // Each customer places 2-3 orders
    $orderCount = rand(2, 3);
    
    for ($i = 0; $i < $orderCount; $i++) {
        $service = $services->random();
        $status = $statuses[array_rand($statuses)];
        $paymentStatus = $status === 'pending' ? 'unpaid' : 'paid';
        
        $orderCode = 'KSR-' . now()->format('YmdHis') . '-' . rand(100, 999);
        
        // Only create if doesn't exist
        $order = \App\Models\Order::firstOrCreate(
            ['order_code' => $orderCode],
            [
                'user_id' => $customerId,
                'service_id' => $service->id,
                'customer_name' => \App\Models\User::find($customerId)->nama,
                'customer_phone' => \App\Models\User::find($customerId)->phone,
                'customer_email' => \App\Models\User::find($customerId)->email,
                'alamat_lengkap' => \App\Models\User::find($customerId)->location . ', Jalan Contoh No. ' . rand(1, 99),
                'tanggal_order' => now()->subDays(rand(1, 30)),
                'total_harga' => $service->harga_mulai,
                'status' => $status,
                'payment_status' => $paymentStatus,
                'catatan_customer' => $i === 0 ? 'Silakan hubungi kami sebelum datang' : null,
            ]
        );
        
        echo "✓ Order created: {$order->order_code} | {$service->nama_layanan} | Status: {$order->status}\n";
    }
}

echo "\n=== Summary ===\n";
echo "✓ Created " . count($customerIds) . " customer users\n";
echo "✓ Created " . (\App\Models\Order::where('created_at', '>=', now()->subHour())->count()) . " example orders\n";
echo "✓ User features now have real data to display!\n\n";
