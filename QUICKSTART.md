# 🚀 KOSERA - Database Integration Quickstart
**Setup dalam 3 menit**

---

## 📋 Yang Dibutuhkan
- ✅ PHP 8.3+
- ✅ MySQL 8.0+
- ✅ Laravel 11.51.0 (sudah ada)
- ✅ Composer dependencies installed

---

## ⚡ 3 Step Setup

### 1️⃣ Migration (1 menit)
```bash
php artisan migrate
```
**Output**: ✓ Semua tabel di-create, termasuk column untuk file_size

### 2️⃣ Seeding (1 menit)
```bash
# Pilih salah satu:

# Opsi A: Recommended (Seeder)
php artisan db:seed --class=KoseraExampleDataSeeder

# Opsi B: SQL manual
mysql < database_example_inserts.sql

# Opsi C: Auto script
./setup-database.sh    # macOS/Linux
setup-database.bat     # Windows
```
**Output**: ✓ 5 users + 6 services + 6 orders + earnings + certificates

### 3️⃣ Jalankan (1 menit)
```bash
php artisan serve
```
**Buka**: http://localhost:8000/mitra/dashboard

---

## 🔑 Login Sekarang Juga

### Mitra 1 (Laundry)
```
📧 laundry.cleanfresh@example.com
🔐 password
```
Lihat: 3 services, 6 orders, Rp 2.5jt revenue

### Mitra 2 (AC Service)
```
📧 acservice.pro@example.com
🔐 password
```
Lihat: 3 services, 3 orders, Rp 3.2jt revenue

---

## ✅ Testing Checklist (5 menit)

- [ ] Dashboard stats menampilkan real numbers
- [ ] Orders Masuk menampilkan pending orders
- [ ] Klik "Terima" → status berubah ke Confirmed
- [ ] Klik "Tolak" → order hilang dari list
- [ ] Chart 6 bulan menampilkan earnings
- [ ] Portfolio menampilkan data seeded

---

## 📊 Data yang Di-seed

```
✓ 5 Users        (2 mitra, 3 customer)
✓ 6 Services     (Laundry, AC Service)
✓ 6 Orders       (Various status)
✓ 5 Earnings     (Pending, Approved, Paid)
✓ 2 Bank Account (Mitra payout)
✓ 4 Portfolios   (Gallery mitra)
✓ 3 Certificates (Kualifikasi mitra)
✓ 2 Identities   (KTP verification)
```

---

## 🔍 Apa yang Berubah

| Aspek | Sebelum | Sesudah |
|-------|---------|---------|
| Dashboard Data | Hardcoded | Real dari DB |
| Orders List | Dummy array | Query dari DB |
| File Min Size | Tidak ada | 2MB validation |
| Earnings | Hardcoded | Real tracking |
| Chart Data | Static | 6 bulan real data |

---

## 🆘 Error Common

### "SQLSTATE[42S02]: Table doesn't exist"
❌ Lupa migrate
✅ Run: `php artisan migrate`

### "No query results found"
❌ Lupa seed data  
✅ Run: `php artisan db:seed --class=KoseraExampleDataSeeder`

### Dashboard menampilkan 0
❌ Cache not cleared
✅ Run: `php artisan cache:clear`

### Auth error saat accept order
❌ CSRF token invalid
✅ Check form include `@csrf`

---

## 📁 Files Ditambah

```
✓ app/Http/Controllers/Mitra/DashboardController.php (Updated)
✓ app/Http/Controllers/Mitra/IncomingOrdersController.php (Updated)
✓ app/Http/Controllers/Mitra/ServiceController.php (Updated)
✓ app/Models/PortfolioImage.php (Updated)
✓ database/migrations/2026_05_31_000000_add_file_size_to_portfolio_images.php (New)
✓ database/seeders/KoseraExampleDataSeeder.php (New)
✓ database_example_inserts.sql (New)
✓ setup-database.sh (New)
✓ setup-database.bat (New)
✓ INTEGRATION_DATABASE_MYSQL.md (New)
✓ DATABASE_INTEGRATION_SUMMARY.md (New)
```

---

## 🔐 Features Terintegrasi

✅ Real order data dari database  
✅ Real earnings calculation  
✅ File size validation 2MB  
✅ Ownership security (user A ≠ user B data)  
✅ Status transition (pending → confirmed → completed)  
✅ Chart dengan 6 bulan real data  
✅ Portfolio tracking dengan file metadata

---

## 📞 For Details

- **Setup Guide**: `INTEGRATION_DATABASE_MYSQL.md`
- **Summary**: `DATABASE_INTEGRATION_SUMMARY.md`
- **SQL Inserts**: `database_example_inserts.sql`
- **Seeder Code**: `database/seeders/KoseraExampleDataSeeder.php`

---

## ✨ Prinsip KISS Diterapkan

- 🎯 Minimal code, maximum functionality
- 🎯 Single responsibility per file
- 🎯 DRY - no code duplication
- 🎯 Readable variable names
- 🎯 Direct Eloquent queries (no over-abstraction)
- 🎯 Helper functions untuk formatting (rupiah, date)

---

**Selamat mencoba! 🚀**

Jika ada error, check `INTEGRATION_DATABASE_MYSQL.md` bagian Troubleshooting
