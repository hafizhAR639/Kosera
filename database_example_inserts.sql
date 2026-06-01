-- =============================================================
-- KOSERA DATABASE - CONTOH INSERTS DATA REAL
-- Untuk Integrasi Order & Earnings dari Database
-- =============================================================

-- 1. INSERT DATA USERS (Mitra = Service Provider)
-- Note: Password adalah hash dari 'password' menggunakan bcrypt
INSERT INTO `users` (
    `nama`, `email`, `password`, `phone`, `location`, `bio`, `avatar`, 
    `status`, `email_verified_at`, `created_at`, `updated_at`
) VALUES
-- Mitra 1: Laundry Solo
(
    'Laundry Clean & Fresh Solo',
    'laundry.cleanfresh@example.com',
    '$2y$12$K6mQs7s/s7QQQvQQvQQvQeQQvQQvQQvQQvQQvQQvQQvQQvQQvQQvQ',
    '081234567890',
    'Solo, Jawa Tengah',
    'Laundry kiloan premium dengan hasil maksimal',
    NULL,
    'active',
    NOW(),
    NOW(),
    NOW()
),
-- Mitra 2: Servis AC Profesional
(
    'AC Service Pro Indonesia',
    'acservice.pro@example.com',
    '$2y$12$K6mQs7s/s7QQQvQQvQQvQeQQvQQvQQvQQvQQvQQvQQvQQvQQvQQvQ',
    '081234567891',
    'Solo, Jawa Tengah',
    'Servis AC pemula hingga profesional dengan garansi',
    NULL,
    'active',
    NOW(),
    NOW(),
    NOW()
);

-- 2. INSERT DATA USERS (Regular User / Customer)
INSERT INTO `users` (
    `nama`, `email`, `password`, `phone`, `location`, `bio`, 
    `status`, `email_verified_at`, `created_at`, `updated_at`
) VALUES
-- Customer 1: Budi Santoso
(
    'Budi Santoso',
    'budi.santoso@example.com',
    '$2y$12$K6mQs7s/s7QQQvQQvQQvQeQQvQQvQQvQQvQQvQQvQQvQQvQQvQQvQ',
    '082987654321',
    'Solo, Jawa Tengah',
    'Customer tetap laundry kiloan',
    'active',
    NOW(),
    NOW(),
    NOW()
),
-- Customer 2: Siti Aminah
(
    'Siti Aminah',
    'siti.aminah@example.com',
    '$2y$12$K6mQs7s/s7QQQvQQvQQvQeQQvQQvQQvQQvQQvQQvQQvQQvQQvQQvQ',
    '082987654322',
    'Solo, Jawa Tengah',
    'Butuh servis AC berkala',
    'active',
    NOW(),
    NOW(),
    NOW()
),
-- Customer 3: Agus Pratama
(
    'Agus Pratama',
    'agus.pratama@example.com',
    '$2y$12$K6mQs7s/s7QQQvQQvQQvQeQQvQQvQQvQQvQQvQQvQQvQQvQQvQQvQ',
    '082987654323',
    'Solo, Jawa Tengah',
    'Direktur rumah sakit lokal',
    'active',
    NOW(),
    NOW(),
    NOW()
);

-- 3. INSERT DATA SERVICES (Layanan dari Mitra)
-- Mitra 1 (ID=1) Laundry:
INSERT INTO `services` (
    `user_id`, `nama_layanan`, `kategori`, `deskripsi`, 
    `harga_mulai`, `harga_max`, `satuan`, `durasi_estimasi`, 
    `area_layanan`, `foto`, `status`, `views`, `created_at`, `updated_at`
) VALUES
(
    1,
    'Laundry Kiloan Premium',
    'Laundry',
    'Paket laundry kiloan premium dengan hasil maksimal, bersih dan wangi tahan lama ',
    8000,
    12000,
    'per kg',
    1440,
    'Kota Solo',
    '/storage/services/laundry-kiloan.jpg',
    'active',
    325,
    NOW(),
    NOW()
),
(
    1,
    'Cuci Express 24 Jam',
    'Laundry',
    'Laundry express dengan pengiriman 24 jam, cocok untuk kebutuhan mendesak',
    15000,
    20000,
    'per kg',
    1440,
    'Kota Solo',
    '/storage/services/laundry-express.jpg',
    'active',
    156,
    NOW(),
    NOW()
),
(
    1,
    'Dry Cleaning Premium',
    'Laundry',
    'Dry cleaning untuk pakaian premium, jas, gaun, dengan perawatan khusus',
    30000,
    50000,
    'per piece',
    2880,
    'Kota Solo',
    '/storage/services/dry-cleaning.jpg',
    'active',
    89,
    NOW(),
    NOW()
);

-- Mitra 2 (ID=2) AC Service:
INSERT INTO `services` (
    `user_id`, `nama_layanan`, `kategori`, `deskripsi`, 
    `harga_mulai`, `harga_max`, `satuan`, `durasi_estimasi`, 
    `area_layanan`, `foto`, `status`, `views`, `created_at`, `updated_at`
) VALUES
(
    2,
    'Service AC Split',
    'Elektronik',
    'Service AC split type standard dengan penggantian freon dan pembersihan evaporator',
    150000,
    200000,
    'per unit',
    120,
    'Kota Solo',
    '/storage/services/ac-split-service.jpg',
    'active',
    412,
    NOW(),
    NOW()
),
(
    2,
    'Instalasi AC Baru',
    'Elektronik',
    'Instalasi AC split baru dengan konsultasi lokasi dan gratis maintenance 3 bulan',
    2500000,
    4000000,
    'per unit',
    180,
    'Kota Solo',
    '/storage/services/ac-instalasi.jpg',
    'active',
    234,
    NOW(),
    NOW()
),
(
    2,
    'Perbaikan AC Emergency',
    'Elektronik',
    'Service darurat AC dengan response time 2 jam untuk Area Solo',
    250000,
    350000,
    'per panggilan',
    120,
    'Kota Solo',
    '/storage/services/ac-emergency.jpg',
    'active',
    567,
    NOW(),
    NOW()
);

-- 4. INSERT DATA ORDERS (Pesanan dari Customer)
-- Pesanan dari Budi Santoso (user_id=3) ke Laundry Clean (service 1):
INSERT INTO `orders` (
    `order_code`, `user_id`, `service_id`, `customer_name`, `customer_phone`, 
    `customer_email`, `alamat_lengkap`, `tanggal_order`, `tanggal_mulai`, 
    `tanggal_selesai`, `total_harga`, `status`, `payment_status`, 
    `catatan_customer`, `catatan_mitra`, `created_at`, `updated_at`
) VALUES
-- 1. Pesanan Budi ke Laundry (pending - baru)
(
    'KSR-20260531-001',
    3,
    1,
    'Budi Santoso',
    '082987654321',
    'budi.santoso@example.com',
    'Jl. Merdeka No. 10, Solo',
    NOW(),
    NULL,
    NULL,
    80000,
    'pending',
    'unpaid',
    'Mohon gunakan pewangi yang soft',
    NULL,
    NOW(),
    NOW()
),
-- 2. Pesanan Siti ke AC Service (confirmed - sudah diterima)
(
    'KSR-20260530-002',
    4,
    4,
    'Siti Aminah',
    '082987654322',
    'siti.aminah@example.com',
    'Jl. Pahlawan No. 5, Solo',
    DATE_SUB(NOW(), INTERVAL 1 DAY),
    DATE_SUB(NOW(), INTERVAL 6 HOUR),
    NULL,
    175000,
    'confirmed',
    'paid',
    'AC dirasa kurang dingin',
    'Sudah confirm lokasi, akan datang besok pagi',
    DATE_SUB(NOW(), INTERVAL 1 DAY),
    DATE_SUB(NOW(), INTERVAL 6 HOUR)
),
-- 3. Pesanan Agus ke AC Service Instalasi (in_progress - sedang dikerjakan)
(
    'KSR-20260529-003',
    5,
    5,
    'Agus Pratama',
    '082987654323',
    'agus.pratama@example.com',
    'Jl. Diponegoro No. 22, Solo',
    DATE_SUB(NOW(), INTERVAL 2 DAY),
    DATE_SUB(NOW(), INTERVAL 2 DAY),
    NULL,
    3200000,
    'in_progress',
    'paid',
    'Mohon selesaikan sebelum hari Jumat',
    'Instalasi dimulai, diperkirakan selesai hari Jumat pukul 14.00 WIB',
    DATE_SUB(NOW(), INTERVAL 2 DAY),
    DATE_SUB(NOW(), INTERVAL 1 DAY)
),
-- 4. Pesanan Budi ke Laundry (completed - selesai)
(
    'KSR-20260528-004',
    3,
    1,
    'Budi Santoso',
    '082987654321',
    'budi.santoso@example.com',
    'Jl. Merdeka No. 10, Solo',
    DATE_SUB(NOW(), INTERVAL 5 DAY),
    DATE_SUB(NOW(), INTERVAL 5 DAY),
    DATE_SUB(NOW(), INTERVAL 4 DAY),
    76000,
    'completed',
    'paid',
    'Cuci pakaian kerja 10 kg',
    'Laundry selesai, pengiriman sukses',
    DATE_SUB(NOW(), INTERVAL 5 DAY),
    DATE_SUB(NOW(), INTERVAL 4 DAY)
),
-- 5. Pesanan Siti ke Laundry Express (completed - selesai)
(
    'KSR-20260527-005',
    4,
    2,
    'Siti Aminah',
    '082987654322',
    'siti.aminah@example.com',
    'Jl. Pahlawan No. 5, Solo',
    DATE_SUB(NOW(), INTERVAL 6 DAY),
    DATE_SUB(NOW(), INTERVAL 6 DAY),
    DATE_SUB(NOW(), INTERVAL 5 DAY),
    150000,
    'completed',
    'paid',
    'Kebutuhan mendesak, cuci 15 kg',
    'Express service berhasil, pelanggan puas',
    DATE_SUB(NOW(), INTERVAL 6 DAY),
    DATE_SUB(NOW(), INTERVAL 5 DAY)
),
-- 6. Pesanan Agus ke Laundry (completed - selesai)
(
    'KSR-20260526-006',
    5,
    1,
    'Agus Pratama',
    '082987654323',
    'agus.pratama@example.com',
    'Jl. Diponegoro No. 22, Solo',
    DATE_SUB(NOW(), INTERVAL 10 DAY),
    DATE_SUB(NOW(), INTERVAL 10 DAY),
    DATE_SUB(NOW(), INTERVAL 9 DAY),
    120000,
    'completed',
    'paid',
    'Laundry seragam pegawai 20 kg',
    'Batch besar, kualitas terjamin',
    DATE_SUB(NOW(), INTERVAL 10 DAY),
    DATE_SUB(NOW(), INTERVAL 9 DAY)
);

-- 5. INSERT DATA EARNINGS (Penghasilan Mitra dari Order)
-- Earning Mitra 1 (Laundry) dari order 1 (pending - belum bayar):
INSERT INTO `earnings` (
    `user_id`, `order_id`, `jumlah`, `tipe`, `status`, 
    `tanggal_bayar`, `metode_pembayaran`, `catatan`, `created_at`
) VALUES
-- Laundry order 1 (pending - belum ada earning karena unpaid)
-- Skipped karena payment_status masih unpaid

-- Laundry order 4 (completed - paid, earning approved & paid):
(
    1,
    4,
    68400,
    'order',
    'paid',
    NOW(),
    'bank_transfer',
    'Komisi 10% dari Rp 76.000',
    DATE_SUB(NOW(), INTERVAL 3 DAY)
),

-- AC Service order 2 (confirmed - paid, earning approved & pending):
(
    2,
    2,
    157500,
    'order',
    'approved',
    NULL,
    NULL,
    'Komisi 10% dari Rp 175.000, pending pembayaran',
    DATE_SUB(NOW(), INTERVAL 6 HOUR)
),

-- AC Service order 3 (in_progress - paid, earning pending):
(
    2,
    3,
    288000,
    'order',
    'pending',
    NULL,
    NULL,
    'Komisi 10% dari Rp 3.200.000, pending penyelesaian order',
    DATE_SUB(NOW(), INTERVAL 2 DAY)
),

-- Laundry order 5 (completed - paid, earning paid):
(
    1,
    5,
    135000,
    'order',
    'paid',
    NOW(),
    'bank_transfer',
    'Komisi 10% dari Rp 150.000 (express)',
    DATE_SUB(NOW(), INTERVAL 4 DAY)
),

-- Laundry order 6 (completed - paid, earning paid):
(
    1,
    6,
    108000,
    'order',
    'paid',
    NOW(),
    'bank_transfer',
    'Komisi 10% dari Rp 120.000',
    DATE_SUB(NOW(), INTERVAL 8 DAY)
);

-- 6. INSERT DATA BANK ACCOUNTS (Rekening Bank Mitra untuk Payout)
INSERT INTO `bank_accounts` (
    `user_id`, `nama_pemilik`, `nama_bank`, `nomor_rekening`, 
    `is_primary`, `created_at`, `updated_at`
) VALUES
(
    1,
    'Laundry Clean & Fresh Solo',
    'Bank BCA',
    '1234567890',
    1,
    NOW(),
    NOW()
),
(
    2,
    'AC Service Pro Indonesia',
    'Bank Mandiri',
    '9876543210',
    1,
    NOW(),
    NOW()
);

-- 7. INSERT DATA PORTFOLIOS (Portfolio/Galeri dari Mitra)
INSERT INTO `portfolios` (
    `user_id`, `judul`, `deskripsi`, `kategori`, `foto_cover`, 
    `status`, `rating`, `created_at`, `updated_at`
) VALUES
(
    1,
    'Laundry Kiloan Premium - Hasil Sempurna',
    'Paket laundry kiloan dengan hasil bersih maksimal dan wangi tahan lama hingga 7 hari',
    'Laundry',
    '/storage/portfolio/laundry-kiloan-01.jpg',
    'published',
    5,
    NOW(),
    NOW()
),
(
    1,
    'Dry Cleaning - Pakaian Formal Premium',
    'Dry cleaning untuk pakaian formal, jas, dan gaun dengan perawatan khusus',
    'Laundry',
    '/storage/portfolio/dry-cleaning-01.jpg',
    'published',
    5,
    NOW(),
    NOW()
),
(
    2,
    'Instalasi AC Split - Rumah Sakit Regional',
    'Instalasi AC split untuk 10 ruang pasien dengan kontrol temperatur presisi',
    'Elektronik',
    '/storage/portfolio/ac-instalasi-01.jpg',
    'published',
    5,
    NOW(),
    NOW()
),
(
    2,
    'Service AC Central - Gedung Perkantoran A',
    'Maintenance rutin AC Central untuk gedung 4 lantai dengan 50 unit indoor',
    'Elektronik',
    '/storage/portfolio/ac-central-01.jpg',
    'published',
    4.5,
    NOW(),
    NOW()
);

-- 8. INSERT DATA CERTIFICATES (Sertifikat Kualifikasi Mitra)
INSERT INTO `certificates` (
    `user_id`, `nama_sertifikat`, `penerbit`, `kategori`, 
    `nomor_sertifikat`, `tanggal_terbit`, `tanggal_kadaluarsa`, 
    `dokumen`, `status`, `created_at`, `updated_at`
) VALUES
(
    1,
    'Sertifikat Ahli Laundry Professional',
    'BNSP Indonesia',
    'Laundry',
    'BNSP-2024-001',
    '2024-01-15',
    '2027-01-15',
    '/storage/certificates/laundry-cert-001.pdf',
    'verified',
    NOW(),
    NOW()
),
(
    2,
    'Sertifikat Teknisi AC Profesional',
    'PT. Daikin Indonesia',
    'Elektronik',
    'DKN-2024-045',
    '2023-06-20',
    '2026-06-20',
    '/storage/certificates/ac-cert-001.pdf',
    'verified',
    NOW(),
    NOW()
),
(
    2,
    'Sertifikat AWI (Air Conditioning Workshop Indonesia)',
    'AWI',
    'Elektronik',
    'AWI-2024-089',
    '2024-03-10',
    '2027-03-10',
    '/storage/certificates/ac-cert-002.pdf',
    'verified',
    NOW(),
    NOW()
);

-- 9. INSERT DATA IDENTITY VERIFICATIONS (Verify KTP/Data Diri Mitra)
INSERT INTO `identity_verifications` (
    `user_id`, `tipe_identitas`, `nomor_identitas`, `nama_lengkap`, 
    `tanggal_lahir`, `alamat`, `dokumen_foto`, `status`, `created_at`, `updated_at`
) VALUES
(
    1,
    'ktp',
    '3372040512850001',
    'Siti Laundry Entrepreneur',
    '1985-12-05',
    'Jl. Pahlawan No. 10, Solo, Jawa Tengah',
    '/storage/identities/laundry-ktp.jpg',
    'verified',
    NOW(),
    NOW()
),
(
    2,
    'ktp',
    '3372041806900002',
    'Adi Teknisi Electrician',
    '1990-06-18',
    'Jl. Diponegoro No. 22, Solo, Jawa Tengah',
    '/storage/identities/ac-tech-ktp.jpg',
    'verified',
    NOW(),
    NOW()
);

-- 10. SUMMARY STATISTICS (Optional - untuk validasi data)
-- SELECT COUNT(*) as total_users FROM users;
-- SELECT COUNT(*) as total_services FROM services;
-- SELECT COUNT(*) as total_orders FROM orders;
-- SELECT SUM(jumlah) as total_earnings FROM earnings;
-- SELECT COUNT(*) as pending_earnings FROM earnings WHERE status = 'pending';

-- =============================================================
-- NOTE: Untuk menjalankan script ini:
-- 1. Pastikan database sudah di-create
-- 2. Jalankan migration terlebih dahulu: php artisan migrate
-- 3. Jalankan script ini di database MySQL
-- 4. Verifikasi data dengan queries di bagian SUMMARY STATISTICS
-- 
-- Password akun (semua):
-- Username: email @ users table
-- Password: password (plain) - di hash dengan bcrypt
-- 
-- Untuk login testing:
-- Mitra 1: laundry.cleanfresh@example.com / password
-- Mitra 2: acservice.pro@example.com / password
-- Customer 1: budi.santoso@example.com / password
-- Customer 2: siti.aminah@example.com / password
-- Customer 3: agus.pratama@example.com / password
-- =============================================================
