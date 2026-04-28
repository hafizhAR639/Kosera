# KOSERA MITRA - Sistem Manajemen Mitra
## ETS Pemrograman Web

> Aplikasi web management system untuk mitra KOSERA dengan fitur CRUD lengkap, filter kategori, dan validasi client-side & server-side.

---

## 📋 Deskripsi Project

Sistem Manajemen Mitra KOSERA adalah aplikasi web yang memungkinkan mitra untuk:
- Mengelola profil dan informasi personal
- Menambah, mengedit, dan menghapus sertifikat
- Mengelola portfolio pekerjaan
- Melihat riwayat pesanan dan pendapatan
- Filter data berdasarkan kategori dan tanggal
- Export laporan ke CSV

**Teknologi yang Digunakan:**
- PHP 7.4+ (Backend & Server-side Processing)
- MySQL/MariaDB (Database)
- HTML5 (Markup)
- Tailwind CSS (utility-first styling)
- JavaScript Vanilla (Client-side Validation & Interactivity)

---

## 🚀 Instalasi

### Prerequisites
- XAMPP/WAMP/MAMP atau web server dengan PHP 7.4+
- MySQL/MariaDB
- Browser modern (Chrome, Firefox, Edge)

### Setup di Linux (Ubuntu/Debian)

Jika menjalankan project ini di Linux, install paket yang dibutuhkan terlebih dahulu:

```bash
sudo apt update
sudo apt install php php-cli php-mysql php-mbstring php-xml php-curl mysql-server unzip
```

Jika ingin memakai Apache, install juga:

```bash
sudo apt install apache2 libapache2-mod-php
```

Pastikan service database aktif:

```bash
sudo systemctl enable --now mysql
```

### Langkah-langkah Instalasi

#### 1. Setup Database
```bash
# Masuk ke MySQL
mysql -u root -p

# Import database
mysql -u root -p < database_fix.sql

# Atau via phpMyAdmin:
# - Buka phpMyAdmin
# - Create database: kosera_mitra
# - Import file: database_fix.sql
```

#### 2. Konfigurasi Database
Edit file `config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');          // Sesuaikan username
define('DB_PASS', '');               // Sesuaikan password
define('DB_NAME', 'kosera_mitra');
```

#### 3. Setup Project
```bash
# Copy semua file ke folder web root
# Contoh Linux Apache: /var/www/html/
sudo cp -r kosera-mitra /var/www/html/

# Masuk ke folder project
cd /var/www/html/kosera-mitra

# Buat folder uploads
mkdir -p uploads/certificates uploads/portfolio

# Set permissions (Linux/Mac)
chmod 755 uploads
chmod 755 uploads/certificates
chmod 755 uploads/portfolio

# Jika server menulis file upload, beri ownership ke user web server
sudo chown -R www-data:www-data uploads
```

#### 4. Akses Aplikasi
Buka browser dan akses:
```
http://localhost/kosera-mitra/index.php
```

Kalau ingin menjalankan tanpa Apache, gunakan built-in PHP server dari folder project:

```bash
php -S 127.0.0.1:8000
```

Lalu buka:

```text
http://127.0.0.1:8000/index.php?r=/
```

**Login Default:**
- Email: sera@kosera.com
- Password: password123

### Cara Menjalankan di Linux

1. Pastikan MySQL sudah berjalan dan database `kosera_mitra` sudah di-import.
2. Sesuaikan kredensial database di `config.php` jika username atau password MySQL berbeda.
3. Jalankan Apache atau PHP built-in server dari folder project.
4. Buka browser dan akses halaman utama melalui `index.php?r=/`.

---

## 📁 Struktur File

```
kosera-mitra/
│
├── config.php              # Konfigurasi database & helper functions
├── index.php               # Front controller untuk routing native MVC
├── bootstrap/
│   └── app.php             # Bootstrap autoload + registrasi route
├── config/
│   └── routes.php          # Peta route aplikasi
├── app/
│   ├── Core/               # Router, Controller base, View renderer
│   ├── Controllers/
│   │   ├── Auth/           # Controller auth (welcome/login/register/logout)
│   │   └── Mitra/          # Controller area mitra
│   ├── Models/
│   │   ├── Auth/           # Model auth
│   │   └── Mitra/          # Model area mitra
│   └── Views/
│       ├── layouts/        # Layout shared
│       ├── auth/           # View auth/public
│       └── mitra/          # View area mitra
├── database_fix.sql        # SQL schema & sample data
│
├── sidebar.php            # Component sidebar (reusable)
│
├── uploads/               # Folder upload files
│   ├── certificates/      # Upload sertifikat
│   └── portfolio/         # Upload portfolio images
│
└── README.md              # Dokumentasi
```

### Catatan Arsitektur (Native MVC)

- Seluruh alur utama sudah melalui front controller `index.php` dan route di `config/routes.php`.
- Modul auth/public tersedia pada route:
   - `/` (welcome)
   - `/login` (GET/POST)
   - `/register` (GET/POST)
   - `/logout` (GET/POST)
- Modul mitra tersedia pada route `/mitra/*`.

---

## 🎯 Fitur Utama

### 1. Dashboard Overview
- Statistik real-time (pesanan, pendapatan, layanan, poin)
- Profile card dengan informasi mitra
- Quick access ke semua menu

### 2. Sertifikat (CRUD)
✅ **CREATE**: Tambah sertifikat baru
- Form input: nama, penerbit, tanggal terbit/kadaluarsa, kategori
- Upload file (PDF/JPG/PNG, max 5MB)
- Validasi client-side & server-side

✅ **READ**: Tampilan grid sertifikat
- Card layout dengan icon & badge status
- Informasi lengkap per sertifikat

✅ **UPDATE**: Edit sertifikat
- Pre-filled form dengan data existing
- Update informasi tanpa menghapus file

✅ **DELETE**: Hapus sertifikat
- Konfirmasi sebelum delete (JavaScript alert)
- Cascade delete dari database

🔍 **FILTER**: 
- Filter by kategori (Teknis, Keselamatan, Manajemen, Lainnya)
- Search by nama sertifikat

### 3. Portfolio (CRUD)
✅ **CREATE**: Tambah portfolio project
- Form lengkap: judul, deskripsi, kategori, klien, lokasi, nilai, durasi
- Upload multiple images (future enhancement)

✅ **READ**: Gallery portfolio
- Card dengan image placeholder
- Meta information (client, lokasi, tanggal, nilai)
- Rating display

✅ **UPDATE**: Edit portfolio
- Update detail project
- Maintain images

✅ **DELETE**: Remove portfolio
- Konfirmasi JavaScript
- Cascade delete images

🔍 **FILTER**:
- Filter by kategori
- Search by judul

### 4. Riwayat Pesanan
📊 **Statistik**:
- Total pesanan
- Pesanan selesai, pending, cancelled
- Total pendapatan

📋 **Tabel Transaksi**:
- Data lengkap per order
- Status dengan badge berwarna
- Rating dari customer

🔍 **FILTER**:
- Filter by status (all, pending, confirmed, in progress, completed, cancelled)
- Filter by date range (dari - sampai)
- Reset filter

💾 **EXPORT**:
- Export data ke CSV
- Include filtered data only

---

## ✅ Validasi Form

### Client-side (JavaScript)
- ✅ Required field validation
- ✅ Minimum length validation
- ✅ Email format validation
- ✅ Phone number format (Indonesia)
- ✅ Date validation (tidak boleh masa depan)
- ✅ Date range validation (kadaluarsa > terbit)
- ✅ File upload validation (type & size)
- ✅ Number validation (tidak negatif)
- ✅ Real-time error display
- ✅ Auto-dismiss alerts

### Server-side (PHP)
- ✅ Input sanitization (htmlspecialchars, trim, stripslashes)
- ✅ Prepared statements (SQL injection prevention)
- ✅ File upload validation
- ✅ Data type validation
- ✅ Business logic validation

---

## 🎨 Design System

### Color Palette
```css
Primary: #0891b2 (Cyan)
Secondary: #06b6d4 (Light Cyan)
Success: #10b981 (Green)
Danger: #ef4444 (Red)
Warning: #f59e0b (Amber)
```

### Typography
- Font Family: System UI Stack (Apple, Segoe UI, Roboto)
- Headings: 700-800 weight
- Body: 400-600 weight

### Components
- **Cards**: Rounded-xl (1.5rem), Shadow-lg
- **Buttons**: Gradient backgrounds, Hover effects
- **Modals**: Backdrop blur, Slide-up animation
- **Forms**: Focus states with ring shadow

### Responsive Breakpoints
- Desktop: > 1024px
- Tablet: 768px - 1024px
- Mobile: < 768px

---

## 🔐 Security Features

1. **SQL Injection Prevention**
   - Prepared statements di semua query
   - Parameter binding

2. **XSS Prevention**
   - `htmlspecialchars()` untuk output
   - Input sanitization

3. **CSRF Protection**
   - Session management
   - Form tokens (recommended untuk production)

4. **File Upload Security**
   - File type validation
   - File size limit (5MB)
   - Rename uploaded files
   - Separate upload directory

5. **Authentication**
   - Session-based login
   - Password hashing (MD5 - upgrade to bcrypt recommended)
   - Login required untuk semua halaman

---

## 📊 Database Schema

### Tables
1. **users** - Data mitra
2. **certificates** - Sertifikat mitra
3. **portfolio** - Portfolio pekerjaan
4. **portfolio_images** - Multiple images per portfolio
5. **services** - Layanan yang ditawarkan
6. **orders** - Pesanan/transaksi
7. **earnings** - Pendapatan
8. **points** - Poin/rewards

### Key Relationships
- `certificates.user_id` → `users.id`
- `portfolio.user_id` → `users.id`
- `orders.user_id` → `users.id`
- `orders.service_id` → `services.id`

---

## 🧪 Testing

### Manual Testing Checklist

**Sertifikat:**
- [ ] Tambah sertifikat dengan semua field valid
- [ ] Tambah sertifikat dengan field kosong (validasi)
- [ ] Upload file dengan format salah (validasi)
- [ ] Upload file > 5MB (validasi)
- [ ] Edit sertifikat existing
- [ ] Delete sertifikat dengan konfirmasi
- [ ] Filter by kategori
- [ ] Search by nama

**Portfolio:**
- [ ] Tambah portfolio dengan data lengkap
- [ ] Validasi form kosong
- [ ] Edit portfolio existing
- [ ] Delete portfolio
- [ ] Filter & search

**Riwayat:**
- [ ] View all orders
- [ ] Filter by status
- [ ] Filter by date range
- [ ] Export CSV
- [ ] View order detail

---

## 🚧 Future Enhancements

### Priority 1
- [ ] Login & Register page
- [ ] Password reset functionality
- [ ] Profile edit page
- [ ] Dashboard dengan grafik (Chart.js)

### Priority 2
- [ ] Multiple image upload untuk portfolio
- [ ] Image preview before upload
- [ ] Pagination untuk table
- [ ] Advanced search & filter
- [ ] Notification system

### Priority 3
- [ ] Email notifications
- [ ] PDF export untuk laporan
- [ ] Dark mode
- [ ] PWA support
- [ ] API untuk mobile app

---

## 🐛 Known Issues

1. **Edit Form**: Form edit belum auto-fill data (need AJAX implementation)
2. **File Preview**: No preview before upload
3. **Pagination**: Not implemented yet (show all data)
4. **Image Upload**: Single file only (need multiple upload)

---

## 📝 Changelog

### v1.0.0 (2026-04-08)
- ✅ Initial release
- ✅ Dashboard overview
- ✅ Sertifikat CRUD
- ✅ Portfolio CRUD
- ✅ Riwayat pesanan
- ✅ Filter & search
- ✅ Responsive design
- ✅ Client & server validation

---

## 👨‍💻 Developer

**Hafizh Septian**
- Project: ETS Pemrograman Web
- Institution: [Your University]
- Program: Information Systems

---

## 📄 License

This project is created for educational purposes (ETS Pemrograman Web).

---

## 📞 Support

Jika ada pertanyaan atau issues:
1. Check this README
2. Review kode dengan comment
3. Test di localhost dengan data sample
4. Contact developer

---

**Happy Coding! 🚀**
