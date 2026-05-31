<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\Order;

class UserExampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * KISS: Simple seeder to add customer users and orders
     */
    public function run(): void
    {
        echo "\n=== Seeding Customer Users and Orders ===\n";

        // Create customer users
        $customers = [
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'phone' => '081234567890',
                'location' => 'Jakarta, Indonesia',
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@email.com',
                'phone' => '081345678901',
                'location' => 'Surabaya, Indonesia',
            ],
            [
                'nama' => 'Ahmad Rahman',
                'email' => 'ahmad.rahman@email.com',
                'phone' => '081456789012',
                'location' => 'Bandung, Indonesia',
            ],
            [
                'nama' => 'Dewi Lestari',
                'email' => 'dewi.lestari@email.com',
                'phone' => '081567890123',
                'location' => 'Medan, Indonesia',
            ],
            [
                'nama' => 'Rudi Hermawan',
                'email' => 'rudi.hermawan@email.com',
                'phone' => '081678901234',
                'location' => 'Yogyakarta, Indonesia',
            ],
        ];

        $customerIds = [];
        foreach ($customers as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                    'role' => 'user',
                    'status' => 'active',
                    'join_date' => now(),
                ])
            );
            $customerIds[] = $user->id;
            $this->command->info("✓ Customer: {$user->nama} (ID: {$user->id})");
        }

        // Get active services
        $services = Service::where('status', 'active')->limit(5)->get();
        
        if ($services->isEmpty()) {
            $this->command->error('❌ No active services found! Run mitra seeder first.');
            return;
        }

        // Create orders for each customer
        $statuses = ['pending', 'confirmed', 'completed'];
        foreach ($customerIds as $customerId) {
            $customer = User::find($customerId);
            $orderCount = rand(2, 3);
            
            for ($i = 0; $i < $orderCount; $i++) {
                $service = $services->random();
                $status = $statuses[array_rand($statuses)];
                $paymentStatus = $status === 'pending' ? 'unpaid' : 'paid';
                $orderCode = 'KSR-' . now()->format('YmdHis') . '-' . rand(100, 999);
                
                Order::firstOrCreate(
                    ['order_code' => $orderCode],
                    [
                        'user_id' => $customerId,
                        'service_id' => $service->id,
                        'customer_name' => $customer->nama,
                        'customer_phone' => $customer->phone,
                        'customer_email' => $customer->email,
                        'alamat_lengkap' => $customer->location . ', Jalan Contoh No. ' . rand(1, 99),
                        'tanggal_order' => now()->subDays(rand(1, 30)),
                        'total_harga' => $service->harga_mulai,
                        'status' => $status,
                        'payment_status' => $paymentStatus,
                        'catatan_customer' => $i === 0 ? 'Hubungi kami sebelum datang' : null,
                    ]
                );
            }
            
            $this->command->info("✓ Created {$orderCount} orders for {$customer->nama}");
        }

        $this->command->info("\n✅ User example data seeded successfully!");
    }
}
