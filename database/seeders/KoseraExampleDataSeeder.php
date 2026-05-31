<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\Order;
use App\Models\Earning;
use App\Models\BankAccount;
use App\Models\Portfolio;
use App\Models\Certificate;
use App\Models\IdentityVerification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class KoseraExampleDataSeeder extends Seeder
{
    public function run(): void
    {
        echo "\n🌱 Seeding example data for KOSERA...\n";

        // 1. Create Mitra Users
        echo "Creating mitra users...\n";
        $mitra1 = User::create([
            'nama' => 'Laundry Clean & Fresh Solo',
            'email' => 'laundry.cleanfresh@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'location' => 'Solo, Jawa Tengah',
            'bio' => 'Laundry kiloan premium dengan hasil maksimal',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        $mitra2 = User::create([
            'nama' => 'AC Service Pro Indonesia',
            'email' => 'acservice.pro@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'location' => 'Solo, Jawa Tengah',
            'bio' => 'Servis AC pemula hingga profesional dengan garansi',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // 2. Create Customer Users
        echo "Creating customer users...\n";
        $customer1 = User::create([
            'nama' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'password' => Hash::make('password'),
            'phone' => '082987654321',
            'location' => 'Solo, Jawa Tengah',
            'bio' => 'Customer tetap laundry kiloan',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        $customer2 = User::create([
            'nama' => 'Siti Aminah',
            'email' => 'siti.aminah@example.com',
            'password' => Hash::make('password'),
            'phone' => '082987654322',
            'location' => 'Solo, Jawa Tengah',
            'bio' => 'Butuh servis AC berkala',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        $customer3 = User::create([
            'nama' => 'Agus Pratama',
            'email' => 'agus.pratama@example.com',
            'password' => Hash::make('password'),
            'phone' => '082987654323',
            'location' => 'Solo, Jawa Tengah',
            'bio' => 'Direktur rumah sakit lokal',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // 3. Create Services
        echo "Creating services...\n";
        $service1 = Service::create([
            'user_id' => $mitra1->id,
            'nama_layanan' => 'Laundry Kiloan Premium',
            'kategori' => 'Laundry',
            'deskripsi' => 'Paket laundry kiloan premium dengan hasil maksimal, bersih dan wangi tahan lama',
            'harga_mulai' => 8000,
            'harga_max' => 12000,
            'satuan' => 'per kg',
            'durasi_estimasi' => 1440,
            'area_layanan' => 'Kota Solo',
            'foto' => '/storage/services/laundry-kiloan.jpg',
            'status' => 'active',
            'views' => 325,
        ]);

        $service2 = Service::create([
            'user_id' => $mitra1->id,
            'nama_layanan' => 'Cuci Express 24 Jam',
            'kategori' => 'Laundry',
            'deskripsi' => 'Laundry express dengan pengiriman 24 jam, cocok untuk kebutuhan mendesak',
            'harga_mulai' => 15000,
            'harga_max' => 20000,
            'satuan' => 'per kg',
            'durasi_estimasi' => 1440,
            'area_layanan' => 'Kota Solo',
            'foto' => '/storage/services/laundry-express.jpg',
            'status' => 'active',
            'views' => 156,
        ]);

        $service3 = Service::create([
            'user_id' => $mitra1->id,
            'nama_layanan' => 'Dry Cleaning Premium',
            'kategori' => 'Laundry',
            'deskripsi' => 'Dry cleaning untuk pakaian premium, jas, gaun, dengan perawatan khusus',
            'harga_mulai' => 30000,
            'harga_max' => 50000,
            'satuan' => 'per piece',
            'durasi_estimasi' => 2880,
            'area_layanan' => 'Kota Solo',
            'foto' => '/storage/services/dry-cleaning.jpg',
            'status' => 'active',
            'views' => 89,
        ]);

        $service4 = Service::create([
            'user_id' => $mitra2->id,
            'nama_layanan' => 'Service AC Split',
            'kategori' => 'Elektronik',
            'deskripsi' => 'Service AC split type standard dengan penggantian freon dan pembersihan evaporator',
            'harga_mulai' => 150000,
            'harga_max' => 200000,
            'satuan' => 'per unit',
            'durasi_estimasi' => 120,
            'area_layanan' => 'Kota Solo',
            'foto' => '/storage/services/ac-split-service.jpg',
            'status' => 'active',
            'views' => 412,
        ]);

        $service5 = Service::create([
            'user_id' => $mitra2->id,
            'nama_layanan' => 'Instalasi AC Baru',
            'kategori' => 'Elektronik',
            'deskripsi' => 'Instalasi AC split baru dengan konsultasi lokasi dan gratis maintenance 3 bulan',
            'harga_mulai' => 2500000,
            'harga_max' => 4000000,
            'satuan' => 'per unit',
            'durasi_estimasi' => 180,
            'area_layanan' => 'Kota Solo',
            'foto' => '/storage/services/ac-instalasi.jpg',
            'status' => 'active',
            'views' => 234,
        ]);

        $service6 = Service::create([
            'user_id' => $mitra2->id,
            'nama_layanan' => 'Perbaikan AC Emergency',
            'kategori' => 'Elektronik',
            'deskripsi' => 'Service darurat AC dengan response time 2 jam untuk Area Solo',
            'harga_mulai' => 250000,
            'harga_max' => 350000,
            'satuan' => 'per panggilan',
            'durasi_estimasi' => 120,
            'area_layanan' => 'Kota Solo',
            'foto' => '/storage/services/ac-emergency.jpg',
            'status' => 'active',
            'views' => 567,
        ]);

        // 4. Create Orders
        echo "Creating orders...\n";
        $order1 = Order::create([
            'order_code' => 'KSR-20260531-001',
            'user_id' => $customer1->id,
            'service_id' => $service1->id,
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '082987654321',
            'customer_email' => 'budi.santoso@example.com',
            'alamat_lengkap' => 'Jl. Merdeka No. 10, Solo',
            'tanggal_order' => now(),
            'total_harga' => 80000,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'catatan_customer' => 'Mohon gunakan pewangi yang soft',
        ]);

        $order2 = Order::create([
            'order_code' => 'KSR-20260530-002',
            'user_id' => $customer2->id,
            'service_id' => $service4->id,
            'customer_name' => 'Siti Aminah',
            'customer_phone' => '082987654322',
            'customer_email' => 'siti.aminah@example.com',
            'alamat_lengkap' => 'Jl. Pahlawan No. 5, Solo',
            'tanggal_order' => now()->subDay(),
            'tanggal_mulai' => now()->subHours(6),
            'total_harga' => 175000,
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'catatan_customer' => 'AC dirasa kurang dingin',
            'catatan_mitra' => 'Sudah confirm lokasi, akan datang besok pagi',
        ]);

        $order3 = Order::create([
            'order_code' => 'KSR-20260529-003',
            'user_id' => $customer3->id,
            'service_id' => $service5->id,
            'customer_name' => 'Agus Pratama',
            'customer_phone' => '082987654323',
            'customer_email' => 'agus.pratama@example.com',
            'alamat_lengkap' => 'Jl. Diponegoro No. 22, Solo',
            'tanggal_order' => now()->subDays(2),
            'tanggal_mulai' => now()->subDays(2),
            'total_harga' => 3200000,
            'status' => 'in_progress',
            'payment_status' => 'paid',
            'catatan_customer' => 'Mohon selesaikan sebelum hari Jumat',
            'catatan_mitra' => 'Instalasi dimulai, diperkirakan selesai hari Jumat pukul 14.00 WIB',
        ]);

        $order4 = Order::create([
            'order_code' => 'KSR-20260528-004',
            'user_id' => $customer1->id,
            'service_id' => $service1->id,
            'customer_name' => 'Budi Santoso',
            'customer_phone' => '082987654321',
            'customer_email' => 'budi.santoso@example.com',
            'alamat_lengkap' => 'Jl. Merdeka No. 10, Solo',
            'tanggal_order' => now()->subDays(5),
            'tanggal_mulai' => now()->subDays(5),
            'tanggal_selesai' => now()->subDays(4),
            'total_harga' => 76000,
            'status' => 'completed',
            'payment_status' => 'paid',
            'catatan_customer' => 'Cuci pakaian kerja 10 kg',
            'catatan_mitra' => 'Laundry selesai, pengiriman sukses',
            'rating' => 5,
        ]);

        $order5 = Order::create([
            'order_code' => 'KSR-20260527-005',
            'user_id' => $customer2->id,
            'service_id' => $service2->id,
            'customer_name' => 'Siti Aminah',
            'customer_phone' => '082987654322',
            'customer_email' => 'siti.aminah@example.com',
            'alamat_lengkap' => 'Jl. Pahlawan No. 5, Solo',
            'tanggal_order' => now()->subDays(6),
            'tanggal_mulai' => now()->subDays(6),
            'tanggal_selesai' => now()->subDays(5),
            'total_harga' => 150000,
            'status' => 'completed',
            'payment_status' => 'paid',
            'catatan_customer' => 'Kebutuhan mendesak, cuci 15 kg',
            'catatan_mitra' => 'Express service berhasil, pelanggan puas',
            'rating' => 5,
        ]);

        $order6 = Order::create([
            'order_code' => 'KSR-20260526-006',
            'user_id' => $customer3->id,
            'service_id' => $service1->id,
            'customer_name' => 'Agus Pratama',
            'customer_phone' => '082987654323',
            'customer_email' => 'agus.pratama@example.com',
            'alamat_lengkap' => 'Jl. Diponegoro No. 22, Solo',
            'tanggal_order' => now()->subDays(10),
            'tanggal_mulai' => now()->subDays(10),
            'tanggal_selesai' => now()->subDays(9),
            'total_harga' => 120000,
            'status' => 'completed',
            'payment_status' => 'paid',
            'catatan_customer' => 'Laundry seragam pegawai 20 kg',
            'catatan_mitra' => 'Batch besar, kualitas terjamin',
            'rating' => 4.5,
        ]);

        // 5. Create Earnings
        echo "Creating earnings...\n";
        Earning::create([
            'user_id' => $mitra1->id,
            'order_id' => $order4->id,
            'jumlah' => 68400,
            'tipe' => 'order',
            'status' => 'paid',
            'tanggal_bayar' => now(),
            'metode_pembayaran' => 'bank_transfer',
            'catatan' => 'Komisi 10% dari Rp 76.000',
        ]);

        Earning::create([
            'user_id' => $mitra2->id,
            'order_id' => $order2->id,
            'jumlah' => 157500,
            'tipe' => 'order',
            'status' => 'approved',
            'catatan' => 'Komisi 10% dari Rp 175.000, pending pembayaran',
        ]);

        Earning::create([
            'user_id' => $mitra2->id,
            'order_id' => $order3->id,
            'jumlah' => 288000,
            'tipe' => 'order',
            'status' => 'pending',
            'catatan' => 'Komisi 10% dari Rp 3.200.000, pending penyelesaian order',
        ]);

        Earning::create([
            'user_id' => $mitra1->id,
            'order_id' => $order5->id,
            'jumlah' => 135000,
            'tipe' => 'order',
            'status' => 'paid',
            'tanggal_bayar' => now(),
            'metode_pembayaran' => 'bank_transfer',
            'catatan' => 'Komisi 10% dari Rp 150.000 (express)',
        ]);

        Earning::create([
            'user_id' => $mitra1->id,
            'order_id' => $order6->id,
            'jumlah' => 108000,
            'tipe' => 'order',
            'status' => 'paid',
            'tanggal_bayar' => now(),
            'metode_pembayaran' => 'bank_transfer',
            'catatan' => 'Komisi 10% dari Rp 120.000',
        ]);

        // 6. Create Bank Accounts
        echo "Creating bank accounts...\n";
        BankAccount::create([
            'user_id' => $mitra1->id,
            'nama_pemilik' => 'Laundry Clean & Fresh Solo',
            'nama_bank' => 'Bank BCA',
            'nomor_rekening' => '1234567890',
            'is_primary' => 1,
        ]);

        BankAccount::create([
            'user_id' => $mitra2->id,
            'nama_pemilik' => 'AC Service Pro Indonesia',
            'nama_bank' => 'Bank Mandiri',
            'nomor_rekening' => '9876543210',
            'is_primary' => 1,
        ]);

        // 7. Create Portfolios
        echo "Creating portfolios...\n";
        Portfolio::create([
            'user_id' => $mitra1->id,
            'judul' => 'Laundry Kiloan Premium - Hasil Sempurna',
            'deskripsi' => 'Paket laundry kiloan dengan hasil bersih maksimal dan wangi tahan lama hingga 7 hari',
            'kategori' => 'Laundry',
            'foto_cover' => '/storage/portfolio/laundry-kiloan-01.jpg',
            'status' => 'published',
            'rating' => 5,
        ]);

        Portfolio::create([
            'user_id' => $mitra1->id,
            'judul' => 'Dry Cleaning - Pakaian Formal Premium',
            'deskripsi' => 'Dry cleaning untuk pakaian formal, jas, dan gaun dengan perawatan khusus',
            'kategori' => 'Laundry',
            'foto_cover' => '/storage/portfolio/dry-cleaning-01.jpg',
            'status' => 'published',
            'rating' => 5,
        ]);

        Portfolio::create([
            'user_id' => $mitra2->id,
            'judul' => 'Instalasi AC Split - Rumah Sakit Regional',
            'deskripsi' => 'Instalasi AC split untuk 10 ruang pasien dengan kontrol temperatur presisi',
            'kategori' => 'Elektronik',
            'foto_cover' => '/storage/portfolio/ac-instalasi-01.jpg',
            'status' => 'published',
            'rating' => 5,
        ]);

        Portfolio::create([
            'user_id' => $mitra2->id,
            'judul' => 'Service AC Central - Gedung Perkantoran A',
            'deskripsi' => 'Maintenance rutin AC Central untuk gedung 4 lantai dengan 50 unit indoor',
            'kategori' => 'Elektronik',
            'foto_cover' => '/storage/portfolio/ac-central-01.jpg',
            'status' => 'published',
            'rating' => 4.5,
        ]);

        // 8. Create Certificates
        echo "Creating certificates...\n";
        Certificate::create([
            'user_id' => $mitra1->id,
            'nama_sertifikat' => 'Sertifikat Ahli Laundry Professional',
            'penerbit' => 'BNSP Indonesia',
            'kategori' => 'Laundry',
            'nomor_sertifikat' => 'BNSP-2024-001',
            'tanggal_terbit' => '2024-01-15',
            'tanggal_kadaluarsa' => '2027-01-15',
            'dokumen' => '/storage/certificates/laundry-cert-001.pdf',
            'status' => 'verified',
        ]);

        Certificate::create([
            'user_id' => $mitra2->id,
            'nama_sertifikat' => 'Sertifikat Teknisi AC Profesional',
            'penerbit' => 'PT. Daikin Indonesia',
            'kategori' => 'Elektronik',
            'nomor_sertifikat' => 'DKN-2024-045',
            'tanggal_terbit' => '2023-06-20',
            'tanggal_kadaluarsa' => '2026-06-20',
            'dokumen' => '/storage/certificates/ac-cert-001.pdf',
            'status' => 'verified',
        ]);

        Certificate::create([
            'user_id' => $mitra2->id,
            'nama_sertifikat' => 'Sertifikat AWI (Air Conditioning Workshop Indonesia)',
            'penerbit' => 'AWI',
            'kategori' => 'Elektronik',
            'nomor_sertifikat' => 'AWI-2024-089',
            'tanggal_terbit' => '2024-03-10',
            'tanggal_kadaluarsa' => '2027-03-10',
            'dokumen' => '/storage/certificates/ac-cert-002.pdf',
            'status' => 'verified',
        ]);

        // 9. Create Identity Verifications
        echo "Creating identity verifications...\n";
        IdentityVerification::create([
            'user_id' => $mitra1->id,
            'tipe_identitas' => 'ktp',
            'nomor_identitas' => '3372040512850001',
            'nama_lengkap' => 'Siti Laundry Entrepreneur',
            'tanggal_lahir' => '1985-12-05',
            'alamat' => 'Jl. Pahlawan No. 10, Solo, Jawa Tengah',
            'dokumen_foto' => '/storage/identities/laundry-ktp.jpg',
            'status' => 'verified',
        ]);

        IdentityVerification::create([
            'user_id' => $mitra2->id,
            'tipe_identitas' => 'ktp',
            'nomor_identitas' => '3372041806900002',
            'nama_lengkap' => 'Adi Teknisi Electrician',
            'tanggal_lahir' => '1990-06-18',
            'alamat' => 'Jl. Diponegoro No. 22, Solo, Jawa Tengah',
            'dokumen_foto' => '/storage/identities/ac-tech-ktp.jpg',
            'status' => 'verified',
        ]);

        echo "\n✅ Example data seeded successfully!\n";
        echo "📊 Summary:\n";
        echo "  - Users: 5 (2 mitra, 3 customer)\n";
        echo "  - Services: 6\n";
        echo "  - Orders: 6 (various status)\n";
        echo "  - Earnings: 5\n";
        echo "  - Portfolios: 4\n";
        echo "  - Certificates: 3\n";
        echo "  - Bank Accounts: 2\n";
        echo "\n✨ Ready to test!\n\n";
    }
}
