-- Database: kosera_mitra
-- ETS Pemrograman Web - Sistem Manajemen Mitra KOSERA

DROP DATABASE IF EXISTS kosera_mitra;
CREATE DATABASE IF NOT EXISTS kosera_mitra;
USE kosera_mitra;

-- Tabel Users (Mitra)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    location VARCHAR(100),
    bio TEXT,
    avatar VARCHAR(255),
    join_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabel Sertifikat
CREATE TABLE IF NOT EXISTS certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nama_sertifikat VARCHAR(200) NOT NULL,
    penerbit VARCHAR(200) NOT NULL,
    tanggal_terbit DATE NOT NULL,
    tanggal_kadaluarsa DATE,
    nomor_sertifikat VARCHAR(100),
    file_path VARCHAR(255),
    kategori ENUM('teknis', 'keselamatan', 'manajemen', 'lainnya') DEFAULT 'teknis',
    status_verifikasi ENUM('pending', 'verified', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel Portfolio
CREATE TABLE IF NOT EXISTS portfolio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    judul VARCHAR(200) NOT NULL,
    deskripsi TEXT,
    kategori VARCHAR(100),
    tanggal_project DATE,
    client_name VARCHAR(100),
    lokasi VARCHAR(100),
    nilai_project DECIMAL(15,2),
    durasi_hari INT,
    foto_cover VARCHAR(255),
    rating DECIMAL(2,1) DEFAULT 0,
    status ENUM('draft', 'published') DEFAULT 'published',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel Portfolio Images
CREATE TABLE IF NOT EXISTS portfolio_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    portfolio_id INT NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    caption TEXT,
    urutan INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (portfolio_id) REFERENCES portfolio(id) ON DELETE CASCADE
);

-- Tabel Layanan (Services)
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nama_layanan VARCHAR(200) NOT NULL,
    kategori VARCHAR(100),
    deskripsi TEXT,
    harga_mulai DECIMAL(15,2),
    harga_max DECIMAL(15,2),
    satuan VARCHAR(50) DEFAULT 'per project',
    durasi_estimasi INT COMMENT 'dalam menit',
    area_layanan VARCHAR(200),
    foto VARCHAR(255),
    status ENUM('active', 'inactive') DEFAULT 'active',
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Tabel Orders (Pesanan)
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(50) UNIQUE NOT NULL,
    user_id INT NOT NULL,
    service_id INT NOT NULL,
    customer_name VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20),
    customer_email VARCHAR(100),
    alamat_lengkap TEXT,
    tanggal_order DATE,
    tanggal_mulai DATETIME,
    tanggal_selesai DATETIME,
    total_harga DECIMAL(15,2),
    status ENUM('pending', 'confirmed', 'in_progress', 'completed', 'cancelled') DEFAULT 'pending',
    payment_status ENUM('unpaid', 'paid', 'refunded') DEFAULT 'unpaid',
    catatan_customer TEXT,
    catatan_mitra TEXT,
    rating DECIMAL(2,1),
    review TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (service_id) REFERENCES services(id)
);

-- Tabel Earnings
CREATE TABLE IF NOT EXISTS earnings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    order_id INT,
    jumlah DECIMAL(15,2) NOT NULL,
    tipe ENUM('order', 'bonus', 'refund') DEFAULT 'order',
    status ENUM('pending', 'approved', 'paid') DEFAULT 'pending',
    tanggal_bayar DATE,
    metode_pembayaran VARCHAR(50),
    catatan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (order_id) REFERENCES orders(id)
);

-- Tabel Points
CREATE TABLE IF NOT EXISTS points (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    points INT DEFAULT 0,
    tipe ENUM('earned', 'redeemed') DEFAULT 'earned',
    sumber VARCHAR(100),
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Sample Data
INSERT INTO users (nama, email, password, phone, location, bio) VALUES
('Sera Gu', 'sera@kosera.com', MD5('password123'), '+62812345678', 'Surabaya, Jawa Timur',
'Profesional dalam bidang perbaikan elektronik dan instalasi listrik dengan pengalaman lebih dari 5 tahun.');

SET @user_id = LAST_INSERT_ID();

INSERT INTO certificates (user_id, nama_sertifikat, penerbit, tanggal_terbit, tanggal_kadaluarsa, nomor_sertifikat, kategori, status_verifikasi) VALUES
(@user_id, 'Sertifikat Teknisi AC Profesional', 'Asosiasi HVAC Indonesia', '2024-06-15', '2027-06-15', 'HVAC-2024-001', 'teknis', 'verified'),
(@user_id, 'Lisensi Instalasi Listrik', 'Kementerian ESDM', '2023-03-20', '2028-03-20', 'ESDM-2023-456', 'teknis', 'verified'),
(@user_id, 'Pelatihan K3 (Keselamatan Kerja)', 'BNSP', '2024-01-10', '2026-01-10', 'K3-2024-789', 'keselamatan', 'verified');

INSERT INTO portfolio (user_id, judul, deskripsi, kategori, tanggal_project, client_name, lokasi, nilai_project, rating, status) VALUES
(@user_id, 'Instalasi AC Split 5 Unit - Rumah Mewah',
'Instalasi lengkap sistem AC untuk rumah 2 lantai dengan 5 unit AC split, termasuk pipa tembaga, kabel listrik, dan bracket outdoor.',
'Instalasi AC', '2026-03-15', 'Budi Santoso', 'Surabaya', 7500000, 5.0, 'published'),
(@user_id, 'Perbaikan Panel Listrik Kompleks Perumahan',
'Maintenance dan upgrade panel listrik untuk 20 rumah di kompleks perumahan, termasuk penggantian MCB dan instalasi grounding.',
'Instalasi Listrik', '2026-02-20', 'PT. Griya Indah', 'Sidoarjo', 15000000, 4.9, 'published'),
(@user_id, 'Service AC Central Mall',
'Pemeliharaan rutin sistem AC central untuk gedung mall 3 lantai, termasuk cleaning coil dan pengecekan refrigerant.',
'Service AC', '2026-01-10', 'Mall Surabaya Plaza', 'Surabaya', 12000000, 5.0, 'published');

INSERT INTO services (user_id, nama_layanan, kategori, deskripsi, harga_mulai, harga_max, area_layanan, status) VALUES
(@user_id, 'Instalasi AC Split', 'AC & Pendingin', 'Instalasi AC split complete termasuk pipa, kabel, dan bracket. Gratis konsultasi!', 500000, 2000000, 'Surabaya, Sidoarjo', 'active'),
(@user_id, 'Service AC Rutin', 'AC & Pendingin', 'Service AC lengkap: cuci AC, isi freon, cek kompressor. Bergaransi 1 bulan!', 150000, 350000, 'Surabaya', 'active'),
(@user_id, 'Instalasi Listrik Rumah', 'Listrik', 'Instalasi listrik rumah baru atau renovasi. Termasuk pemasangan MCB, stop kontak, saklar.', 1000000, 5000000, 'Surabaya, Sidoarjo, Gresik', 'active'),
(@user_id, 'Perbaikan Elektronik', 'Elektronik', 'Service TV, kulkas, mesin cuci, dan elektronik lainnya. Dikerjakan oleh teknisi bersertifikat.', 100000, 500000, 'Surabaya', 'active'),
(@user_id, 'Pasang CCTV', 'Keamanan', 'Instalasi CCTV lengkap dengan DVR dan setting remote viewing via smartphone.', 2000000, 8000000, 'Surabaya, Sidoarjo', 'active');

INSERT INTO orders (order_code, user_id, service_id, customer_name, customer_phone, alamat_lengkap, tanggal_order, tanggal_selesai, total_harga, status, payment_status, rating) VALUES
('ORD-2026-001', @user_id, 1, 'Ahmad Riyadi', '+62813456789', 'Jl. Raya Darmo No. 123, Surabaya', '2026-04-05', '2026-04-05 16:00:00', 650000, 'completed', 'paid', 5.0),
('ORD-2026-002', @user_id, 2, 'Siti Aminah', '+62814567890', 'Jl. Diponegoro No. 45, Sidoarjo', '2026-04-04', '2026-04-04 14:30:00', 200000, 'completed', 'paid', 4.8),
('ORD-2026-003', @user_id, 3, 'Dewi Lestari', '+62815678901', 'Jl. Ahmad Yani No. 78, Surabaya', '2026-04-03', NULL, 2500000, 'in_progress', 'paid', NULL),
('ORD-2026-004', @user_id, 1, 'Eko Prasetyo', '+62816789012', 'Jl. Pahlawan No. 56, Surabaya', '2026-04-02', '2026-04-02 17:00:00', 750000, 'completed', 'paid', 4.9);

INSERT INTO earnings (user_id, order_id, jumlah, tipe, status, tanggal_bayar, metode_pembayaran) VALUES
(@user_id, 1, 585000, 'order', 'paid', '2026-04-06', 'Transfer Bank'),
(@user_id, 2, 180000, 'order', 'paid', '2026-04-05', 'Transfer Bank'),
(@user_id, 3, 2250000, 'order', 'approved', NULL, NULL),
(@user_id, 4, 675000, 'order', 'paid', '2026-04-03', 'Transfer Bank');

INSERT INTO points (user_id, points, tipe, sumber, keterangan) VALUES
(@user_id, 10, 'earned', 'Order Completed', 'Pesanan ORD-2026-001 selesai'),
(@user_id, 10, 'earned', 'Order Completed', 'Pesanan ORD-2026-002 selesai'),
(@user_id, 15, 'earned', 'Perfect Rating', 'Rating 5.0 dari pelanggan'),
(@user_id, -10, 'redeemed', 'Voucher Claimed', 'Tukar voucher diskon 10%');

CREATE OR REPLACE VIEW v_mitra_stats AS
SELECT
    u.id AS user_id,
    u.nama,
    COUNT(DISTINCT o.id) AS total_orders,
    SUM(CASE WHEN o.status = 'completed'
        AND MONTH(o.tanggal_selesai) = MONTH(CURRENT_DATE)
        AND YEAR(o.tanggal_selesai) = YEAR(CURRENT_DATE) THEN 1 ELSE 0 END) AS orders_this_month,
    COUNT(DISTINCT s.id) AS active_services,
    COALESCE(SUM(e.jumlah), 0) AS total_earnings,
    COALESCE(AVG(o.rating), 0) AS avg_rating,
    COALESCE((SELECT SUM(points) FROM points WHERE user_id = u.id), 0) AS total_points
FROM users u
LEFT JOIN orders o ON u.id = o.user_id
LEFT JOIN services s ON u.id = s.user_id AND s.status = 'active'
LEFT JOIN earnings e ON u.id = e.user_id AND e.status = 'paid'
GROUP BY u.id, u.nama;

-- Indexes for performance
CREATE INDEX idx_user_email ON users(email);
CREATE INDEX idx_cert_user ON certificates(user_id);
CREATE INDEX idx_cert_user_kategori_terbit ON certificates(user_id, kategori, tanggal_terbit);
CREATE INDEX idx_portfolio_user ON portfolio(user_id);
CREATE INDEX idx_portfolio_user_kategori_tanggal ON portfolio(user_id, kategori, tanggal_project);
CREATE INDEX idx_service_user ON services(user_id);
CREATE INDEX idx_order_user ON orders(user_id);
CREATE INDEX idx_order_status ON orders(status);
CREATE INDEX idx_earning_user ON earnings(user_id);
