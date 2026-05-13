# KOSERA Mitra - Platform Mitra Profesional

Platform manajemen untuk mitra profesional yang menyediakan layanan, mengelola pesanan, portofolio, dan sertifikat. Aplikasi ini adalah **migrasi dari custom PHP ke Laravel 11** dengan UI modern menggunakan **Tailwind CSS**.

## 📋 Fitur Utama

- **Dashboard** - Ringkasan pesanan, pendapatan, dan statistik mitra
- **Portfolio** - Kelola proyek dan layanan yang ditawarkan
- **Orderan** - Terima, tolak, dan kelola pesanan masuk serta riwayat
- **Sertifikat** - Upload dan kelola sertifikat profesional
- **Profil** - Edit data pribadi dan deskripsi diri
- **Responsive Design** - Mobile-first dengan Tailwind CSS

## 🏗️ Stack Teknologi

- **Framework**: Laravel 11
- **Database**: MySQL/MariaDB
- **Frontend**: Tailwind CSS + Blade Templates
- **Build Tool**: Vite
- **CSS Framework**: Tailwind CSS

## 📁 Struktur Project

```
kosera-mitra-new/
├── app/
│   ├── Http/Controllers/Mitra/     # Mitra Controllers
│   ├── Models/                     # Database Models
│   ├── Helpers/                    # Helper Functions
│   └── Providers/                  # Service Providers
├── resources/
│   ├── views/
│   │   ├── layouts/mitra.blade.php # Main Layout
│   │   ├── mitra/                  # Mitra Views
│   │   └── auth/                   # Auth Views
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php                     # Web Routes
│   └── console.php                 # Console Routes
├── database/
│   ├── migrations/                 # Database Migrations
│   ├── seeders/                    # Database Seeders
│   └── factories/                  # Model Factories
├── public/                         # Public Assets
└── storage/                        # Files Storage
```

## 🚀 Instalasi & Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL/MariaDB

### Langkah Instalasi

1. **Clone Repository**
```bash
git clone <repository-url>
cd kosera-mitra-new
```

2. **Install Dependencies**
```bash
composer install
npm install
```

3. **Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Configuration**
Edit `.env` untuk konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kosera_mitra
DB_USERNAME=root
DB_PASSWORD=
```

5. **Migrations**
```bash
php artisan migrate
```

6. **Build Assets**
```bash
npm run build
# atau untuk development dengan hot reload
npm run dev
```

7. **Jalankan Application**
```bash
php artisan serve
```

Akses aplikasi di `http://localhost:8000`

## 📚 API Routes

### Mitra Protected Routes
```
GET/POST  /mitra/dashboard              - Dashboard utama
GET/POST  /mitra/portfolio             - Kelola portfolio
GET/POST  /mitra/orders/incoming       - Orderan masuk
GET/POST  /mitra/orders/history        - Riwayat pesanan
GET/POST  /mitra/certificates          - Kelola sertifikat
GET       /mitra/profile               - Lihat profil
GET/POST  /mitra/profile/edit          - Edit profil
```

## 🗄️ Database Models

- **User** - Data user/mitra
- **Portfolio** - Project dan layanan
- **Certificate** - Sertifikat profesional
- **Order** - Pesanan dari klien
- **Earning** - Riwayat pendapatan
- **Point** - Poin dan reputasi service

## 🎨 UI Design

Menggunakan **Tailwind CSS** v3 dengan komponen:
- Grid layout responsive (mobile-first)
- Modal dialogs untuk form
- Form validation client & server
- Status badges dengan warna semantik
- Pagination dengan navigation
- Data tables responsif
- Card-based layouts

## 🔐 Security Features

- CSRF Protection (enabled by default)
- Input validation (Form Requests)
- SQL Injection protection (Eloquent ORM)
- XSS protection (Blade auto-escaping)
- Authorization policies (Laravel Gates)
- Secure password hashing

## 🧪 Testing

```bash
php artisan test
```

## 📖 Dokumentasi

Lebih lengkap di [Laravel Documentation](https://laravel.com/docs)

## 🔄 Migration dari kosera-mitra (PHP Native)

Project ini adalah hasil migrasi dari custom PHP router ke **Laravel Framework**.

**Perubahan Utama:**
| Aspect | Sebelum (PHP) | Sesudah (Laravel) |
|--------|---------------|------------------|
| Router | Custom router | Laravel routing system |
| Helpers | Manual PHP functions | Laravel helpers + Classes |
| Views | Plain PHP | Blade templates |
| Validation | Manual checks | Form Requests |
| ORM | Manual SQL | Eloquent ORM |
| Styling | Bootstrap | Tailwind CSS |

**Kompatibilitas:**
✅ Database schema tetap sama
✅ Business logic dipertahankan
✅ UI upgrade ke Tailwind CSS modern
✅ Performance improvement dengan caching

## 🤝 Kontribusi

Silakan buat pull request atau report issues di repository.

## 📄 License

Licensed under the MIT License - lihat [LICENSE](LICENSE) file untuk detail.

---

**Last Updated**: May 2026
**Version**: 1.0.0 (Laravel Migration)
