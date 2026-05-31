# KOSERA

KOSERA adalah aplikasi marketplace jasa berbasis Laravel untuk menghubungkan user dengan mitra profesional. Repositori ini berisi alur user dan mitra, riwayat pesanan, detail pesanan, profil, portofolio, sertifikat, dan flow registrasi bertahap.

## Stack

- PHP 8.2+
- Laravel 11
- Blade templates
- Tailwind CSS 3
- Vite 6
- MySQL / MariaDB
- Composer
- Node.js + npm

## Fitur Utama

- Dashboard user dan mitra
- Pencarian layanan / mitra
- Alur pesanan, konfirmasi, pembayaran berhasil, detail pesanan, dan riwayat
- Rating dan status order
- Profil user dan mitra
- Portofolio mitra dan sertifikat
- Demo data untuk akun user dan mitra
- Layout shared sidebar untuk konsistensi UI

## Struktur Folder

### Yang dipakai Laravel runtime

```text
app/
  Http/Controllers/
  Models/
  Providers/
bootstrap/
config/
database/
public/
resources/
  css/
  js/
  views/
routes/
storage/
tests/
```

### Yang masih legacy / sisa migrasi

```text
app/Controllers/
app/Core/
app/Helpers/
app/Views/
config.php
sidebar.php
```

Catatan: folder legacy di atas tidak dipakai sebagai jalur utama aplikasi Laravel. Untuk pengembangan baru, fokus ke `routes/web.php`, `app/Http/Controllers`, `app/Models`, dan `resources/views`.

## Cara Install

### 1. Prasyarat

- PHP 8.2 atau lebih baru
- Composer
- Node.js 18+ dan npm
- MySQL atau MariaDB

### 2. Install dependency

```bash
composer install
npm install
```

### 3. Siapkan environment

```bash
cp .env.example .env
php artisan key:generate
```

Lalu sesuaikan database di `.env`:

```env
APP_NAME=KOSERA
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kosera
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Jalankan migrasi dan seed

```bash
php artisan migrate
php artisan db:seed
```

Database migration ada di `database/migrations`. Itu sumber utama skema database Laravel, jadi jika ada file SQL lama seperti `database_fix.sql` atau `database_example_inserts.sql`, anggap itu referensi tambahan saja.

Jika ingin seed demo akun yang dipakai untuk pengujian UI:

```bash
php artisan db:seed --class=Database\\Seeders\\DemoAccountsSeeder
```

### 5. Build frontend

```bash
npm run build
```

Untuk development:

```bash
npm run dev
```

### 6. Jalankan aplikasi

```bash
php artisan serve
```

Akses aplikasi di:

```text
http://127.0.0.1:8000
```

## Perintah Berguna

```bash
php artisan route:list
php artisan test
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## Alur Halaman Utama

- `user.dashboard` - dashboard utama user
- `user.orders.history` - riwayat pesanan user
- `user.orders.detail` - detail pesanan setelah pembayaran berhasil
- `user.payment.success` - halaman pembayaran berhasil
- `mitra.dashboard` - dashboard mitra
- `mitra.orders.history` - riwayat pesanan mitra

## Catatan Implementasi

- Layout user dan mitra memakai pola shared component agar tampilan konsisten.
- Styling utama menggunakan Tailwind dan font Plus Jakarta Sans.
- Route dan Blade view yang aktif ada di `routes/web.php` dan `resources/views`.
- Folder legacy masih ada di repo supaya tidak memutus file lama, tapi tidak perlu dipakai untuk fitur baru.
- File `gemini.md` tidak dipakai untuk runtime aplikasi dan sudah dihapus.

## Testing

```bash
php artisan test
```

## License

MIT License.
