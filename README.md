# KOSERA

KOSERA adalah aplikasi marketplace jasa berbasis Laravel untuk mempertemukan user dengan mitra profesional. Aplikasi ini menangani layanan, pesanan, pembayaran, riwayat, rating, profil mitra, portofolio, sertifikat, dan registrasi bertahap.

## Ringkasan

- Framework: Laravel 11
- Bahasa: PHP 8.2+
- Frontend: Blade, Tailwind CSS 3, Vite
- Database: MySQL / MariaDB
- Tooling: Composer, Node.js, npm

## Refaktor Terkini

- Status: mayoritas refaktor controller untuk area `Mitra` dan `User` telah selesai.
- Apa yang sudah dilakukan: pemindahan validasi ke `FormRequest` (mis. `CertificateRequest`, `UserProfileRequest`, `ServiceRequest`, `LoginRequest`, dsb.), pemisahan logika bisnis ke service layer, dan view diperbaiki untuk generasi URL resource.
- Pengujian: suite unit/feature dieksekusi secara lokal — `php artisan test` dilaporkan OK untuk tes yang ada setelah perubahan.
- Catatan logout: perilaku logout kini mengarahkan `mitra` ke halaman welcome mitra (`/admin`) dan user ke halaman welcome user (`/`).
- Branch/Commit: perubahan ini dicommit pada branch `refactor/migrate-mitra-to-eloquent` (contoh commit: "Fix: import Request and role-aware logout redirect in AuthController").
- Lingkungan lokal: untuk pengecekan lokal pastikan `SESSION_DRIVER=file` jika tidak ingin tergantung koneksi DB untuk sesi saat pengujian.


## Fitur Utama

- Dashboard user dan mitra
- Pencarian layanan dan mitra
- Alur pesanan dari buat pesanan sampai detail dan riwayat
- Status order, pembayaran, dan rating
- Profil user dan mitra
- Portofolio mitra dan sertifikat
- Registrasi bertahap untuk mitra

## Struktur Proyek

Jika repository dibuka dari folder luar, masuk dulu ke folder proyek inti yang berisi file Laravel seperti `artisan`, `composer.json`, `routes/`, `app/`, dan `resources/`.

Folder penting yang dipakai aplikasi:

```text
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
tests/
```

Folder legacy yang tidak dipakai sebagai jalur utama aplikasi Laravel sudah dihapus atau dibiarkan kosong bila masih tersisa.

## Kekurangan yang Masih Ada

- Cakupan pengujian fungsional/integrasi masih terbatas — rekomendasi: tambahkan tes end-to-end untuk upload file (avatar/portofolio/sertifikat), alur pembayaran, dan registrasi multi‑step mitra.
- Dokumentasi lingkungan pengembangan perlu penambahan catatan praktis (mis. `SESSION_DRIVER=file` untuk pengujian lokal tanpa DB sessions, instruksi .env), serta pengayaan README jika diperlukan.

## Instalasi

### 1. Prasyarat

- PHP 8.2 atau lebih baru
- Composer
- Node.js 18 atau lebih baru
- npm
- MySQL atau MariaDB

### 2. Install dependency

```bash
composer install
npm install
```

### 3. Siapkan file environment

```bash
cp .env.example .env
php artisan key:generate
```

Atur koneksi database di `.env`:

```env
APP_NAME=KOSERA
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kosera
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Buat database

Jalankan migrasi untuk membangun schema:

```bash
php artisan migrate:fresh
```

Jika ingin isi data awal, jalankan seeder yang tersedia di project.

### 5. Build frontend

```bash
npm run build
```

Untuk mode development:

```bash
npm run dev
```

### 6. Jalankan aplikasi

```bash
php artisan serve
```

Lalu buka:

```text
http://127.0.0.1:8000
```

## Perintah Berguna

```bash
php artisan migrate:status
php artisan route:list
php artisan test
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## Alur Fitur Inti

- User memilih layanan
- User membuat pesanan
- Sistem menyimpan order ke database
- Mitra menerima pesanan masuk
- Mitra melihat riwayat dan pendapatan
- User melihat status, detail, dan hasil pembayaran

## ERD Sederhana

Relasi utama di database:

```text
users
  ├─ hasMany -> orders
  ├─ hasMany -> bank_accounts
  ├─ hasMany -> identity_verifications
  ├─ hasMany -> certificates
  └─ hasMany -> portfolios

services
  ├─ belongsTo -> users
  └─ hasMany -> orders

orders
  ├─ belongsTo -> users
  ├─ belongsTo -> services
  └─ hasOne -> earnings

earnings
  └─ belongsTo -> orders

portfolio_images
  └─ belongsTo -> portfolios
```

## Catatan Implementasi

- Controller dibuat tipis dan fokus ke validasi, pemanggilan service, dan pengembalian view.
- Query utama dipindah ke service dan repository.
- Blade dipertahankan strukturnya agar desain tidak berubah.
- Grafik dashboard mitra memakai data dari server sehingga lebih dinamis.

## Pengujian

```bash
php artisan test
```

## Lisensi

MIT License.
