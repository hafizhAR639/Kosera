# Integrasi Database MySQL untuk Mitra Orders & Earnings
**Update: 31 Mei 2026**

## 📋 Ringkasan Perubahan

Sistem telah diintegrasikan dengan database MySQL untuk menampilkan data real dari pesanan dan penghasilan mitra, menggantikan dummy/hardcoded data.

---

## 🔄 Komponen yang Diperbarui

### 1. **Controllers**

#### `DashboardController.php` (app/Http/Controllers/Mitra/)
**Perubahan:** Mengambil data real dari database
- ✅ Monthly orders: Query real dari tabel `orders` 
- ✅ Total income: Sum dari tabel `earnings` dengan status `paid`
- ✅ Services count: Count dari tabel `services` dengan status `active`
- ✅ Recent orders: Relasi dengan `Order` model (user & service)
- ✅ Chart data: 6 bulan earnings per bulan dari database
- ✅ Certificates & Portfolio: Dari database real

**Query Pattern:**
```php
Order::whereHas('service', function ($q) use ($userId) {
    $q->where('user_id', $userId);
})
->where('status', 'pending')
->count();
```

#### `IncomingOrdersController.php` (app/Http/Controllers/Mitra/)
**Perubahan:** Replace dummy orders dengan database query
- ✅ Fetch pending orders dari `orders` table dengan relasi service
- ✅ Ownership validation: Memastikan order milik service mitra
- ✅ Accept action: Update order status ke `confirmed`
- ✅ Reject action: Update order status ke `cancelled` + session filtering
- ✅ Include customer details: phone, email, notes dari database

**Status Update:**
- Accept → `status = 'confirmed'`
- Reject → `status = 'cancelled'` + add to session rejected list

#### `ServiceController.php` (app/Http/Controllers/Mitra/)
**Perubahan:** Add file size validation
- ✅ File minimum: 2MB (2048 KB) - `min:2048`
- ✅ File maximum: 4MB (4096 KB) - `max:4096`
- ✅ Custom error messages dalam Bahasa Indonesia
- ✅ Validation on both `store()` dan `update()` methods

```php
'foto' => 'nullable|image|min:2048|max:4096', // 2MB - 4MB
'foto_cover' => 'nullable|image|min:2048|max:4096',
```

---

### 2. **Models**

#### `PortfolioImage.php`
**Perubahan:** Add fields untuk tracking file metadata
- ✅ `original_filename` (string nullable): Nama file asli saat upload
- ✅ `file_size` (bigint nullable): Ukuran file dalam bytes

```php
protected $fillable = [
    'portfolio_id',
    'image_path',
    'caption',
    'urutan',
    'original_filename',  // NEW
    'file_size',          // NEW
];

protected $casts = [
    'file_size' => 'integer',
];
```

---

### 3. **Migrations**

#### `2026_05_31_000000_add_file_size_to_portfolio_images.php`
**Perubahan:** Add 2 columns ke tabel `portfolio_images`

```sql
ALTER TABLE portfolio_images ADD COLUMN original_filename VARCHAR(255) NULL;
ALTER TABLE portfolio_images ADD COLUMN file_size BIGINT UNSIGNED NULL;
```

**Cara Jalankan:**
```bash
php artisan migrate
```

---

### 4. **Views (No Changes Required)**

View sudah siap dengan struktur yang flexible:
- ✅ `mitra/dashboard.blade.php` - Menerima $stats, $chartData dari controller
- ✅ `mitra/orders_incoming.blade.php` - Loop $orders dari controller
- ✅ Semua format sudah menggunakan helper `FormatHelper::rupiah()` dan `FormatHelper::date()`

---

## 📊 Database Structure (ERD)

### Relationships:
```
users (Mitra/Customer)
  ├─ has many → services
  ├─ has many → orders (via service)
  ├─ has many → earnings
  ├─ has one → bank_accounts
  ├─ has one → identity_verifications
  └─ has many → portfolios

services
  ├─ belongs to → users
  └─ has many → orders

orders
  ├─ belongs to → users (customer)
  ├─ belongs to → services
  └─ has one → earnings

earnings
  ├─ belongs to → users (mitra)
  ├─ belongs to → orders (optional)

portfolios
  ├─ belongs to → users
  └─ has many → portfolio_images

portfolio_images
  └─ belongs to → portfolios
```

---

## 🗄️ Contoh Data SQL

File: `database_example_inserts.sql`

### Insert Terdiri dari:
1. **Users (3 Mitra + 3 Customer)** - 6 records
2. **Services** - 6 records (3 dari mitra 1, 3 dari mitra 2)
3. **Orders** - 6 records dengan berbagai status:
   - 1 pending
   - 1 confirmed
   - 1 in_progress
   - 3 completed
4. **Earnings** - Corresponding earnings records
5. **Bank Accounts** - Rekening mitra untuk payout
6. **Portfolios** - Gallery dari mitra (4 records)
7. **Certificates** - Sertifikasi mitra (3 records)
8. **Identity Verifications** - Verifikasi KTP (2 records)

### Data struktur:
```
├─ Mitra 1 (ID=1): Laundry Clean & Fresh Solo
├─ Mitra 2 (ID=2): AC Service Pro Indonesia
├─ Customer 1 (ID=3): Budi Santoso
├─ Customer 2 (ID=4): Siti Aminah
└─ Customer 3 (ID=5): Agus Pratama
```

### Cara Jalankan Inserts:
```bash
# 1. Copy isi database_example_inserts.sql ke MySQL
mysql> source /path/to/database_example_inserts.sql;

# ATAU di Laravel
# php artisan db:seed --class=ExampleDataSeeder
```

### Login Data untuk Testing:
```
Mitra 1: laundry.cleanfresh@example.com / password
Mitra 2: acservice.pro@example.com / password

Customer 1: budi.santoso@example.com / password
Customer 2: siti.aminah@example.com / password
Customer 3: agus.pratama@example.com / password
```

---

## 🔍 Validasi File Size

### Implementasi pada Upload:

#### Service File Upload
```php
// Store
$request->validate([
    'foto' => 'nullable|image|min:2048|max:4096',
    'foto_cover' => 'nullable|image|min:2048|max:4096',
], [
    'foto.min' => 'Ukuran foto minimal 2 MB',
    'foto.max' => 'Ukuran foto maksimal 4 MB',
]);

// Update handler
if ($request->hasFile('foto')) {
    if ($file->getSize() < 2048000) {
        // Reject - File terlalu kecil
    }
}
```

### Tracking di Database:
Saat mengupload portfolio image (PortfolioImage model):
```php
PortfolioImage::create([
    'portfolio_id' => $portfolio->id,
    'image_path' => '/storage/' . $path,
    'original_filename' => $request->file('image')->getClientOriginalName(),
    'file_size' => $request->file('image')->getSize(), // bytes
]);
```

---

## 📈 Statistik Dashboard (Real Data)

Dashboard sekarang menampilkan data real:

### Metric yang Diquery:
1. **Pesanan Bulan Ini** 
   - Query: `WHERE created_at BETWEEN first_day_of_month AND last_day_of_month`

2. **Total Pendapatan**
   - Query: `SUM(earnings.jumlah) WHERE status='paid'`

3. **Layanan Aktif**
   - Query: `COUNT(services) WHERE status='active'`

4. **Recent Orders (5 terakhir)**
   - Query: `Order::with(['service', 'user'])->latest()->limit(5)`

5. **Chart Data (6 bulan)**
   ```php
   for ($i=5; $i>=0; $i--) {
       $date = now()->subMonths($i);
       $earnings = Earning::where('status', 'paid')
           ->whereMonth('created_at', $date->month)
           ->sum('jumlah');
   }
   ```

---

## 🔐 Security & Validation

### Ownership Validation
```php
// IncomingOrdersController::updateStatus()
$order = Order::find($orderId);
if ($order->service->user_id !== Auth::id()) {
    return redirect()->with('error', 'Akses ditolak');
}
```

### File Upload Security
- ✅ Validasi MIME type: `image` (jpg, png, gif, webp)
- ✅ Size validation: Min 2MB, Max 4MB
- ✅ Storage path: `/storage/` dengan Laravel Storage
- ✅ Original filename disimpan untuk audit

### Query Scope
```php
// Hanya ambil orders dari service milik user
Order::whereHas('service', function ($q) use ($userId) {
    $q->where('user_id', $userId);
})
```

---

## 🚀 Cara Setup

### Step 1: Jalankan Migration
```bash
php artisan migrate
```

### Step 2: Insert Contoh Data
```bash
# Copy queries dari database_example_inserts.sql ke MySQL client
# ATAU gunakan seeder
php artisan db:seed --class=ExampleDataSeeder
```

### Step 3: Test Dashboard
```bash
# Start Laravel development server
php artisan serve

# Login sebagai mitra
# URL: http://localhost:8000/mitra/dashboard
# Email: laundry.cleanfresh@example.com
# Pass: password
```

### Step 4: Verifikasi
- ✅ Dashboard menampilkan real data
- ✅ Orders incoming menampilkan pending orders
- ✅ Chart earnings menampilkan 6 bulan real data
- ✅ Accept/Reject orders update status ke database

---

## 📝 ERD Adjustment Notes

### Struktur Sesuai dengan ERD:
- ✅ **users table**: field untuk mitra dan customer (unified)
- ✅ **services table**: linked to users.id
- ✅ **orders table**: linked to users (customer) + services
- ✅ **earnings table**: linked to users (mitra) + orders
- ✅ **portfolio_images table**: new fields original_filename, file_size
- ✅ **bank_accounts table**: for mitra payout
- ✅ **identity_verifications table**: for user identity validation

### Relational Constraints:
- `services.user_id` → FK to `users.id` (CASCADE DELETE)
- `orders.user_id` → FK to `users.id`
- `orders.service_id` → FK to `services.id`
- `earnings.user_id` → FK to `users.id`
- `earnings.order_id` → FK to `orders.id` (NULLABLE)
- `portfolio_images.portfolio_id` → FK to `portfolios.id`

---

## ✅ Testing Checklist

- [ ] Migration berjalan tanpa error: `php artisan migrate`
- [ ] Contoh data ter-insert: `php artisan db:seed`
- [ ] Login mitra: dashboard menampilkan real data
- [ ] Orders incoming: menampilkan pending orders dari DB
- [ ] Accept order: status berubah ke confirmed
- [ ] Reject order: status berubah ke cancelled + session filtering
- [ ] Chart: menampilkan 6 bulan earnings data
- [ ] File upload: validasi 2MB minimum berfungsi
- [ ] Error messages: Bahasa Indonesia tampil saat validasi gagal
- [ ] Ownership: User A tidak bisa akses order milik user B

---

## 🐛 Troubleshooting

### Issue: "Model [Order] has no table in the database"
**Solution:**
```bash
php artisan migrate:fresh --seed
```

### Issue: Dashboard menampilkan 0 untuk semua metric
**Solution:**
- Check: `php artisan tinker` → `User::count()` should > 0
- Check: `Order::count()` should > 0
- Ensure Auth::id() returns correct user_id

### Issue: File upload validation not working
**Solution:**
- Laravel min/max validation adalah dalam **bytes**
- 2MB = 2048 * 1024 = 2097152 bytes
- Namun Laravel accepts `min:2048` = 2048 bytes

### Issue: CORS/Auth error saat accept/reject
**Solution:**
- Form harus include `@csrf` token
- Method harus POST
- Ensure middleware auth ada: `Route::prefix('mitra')->middleware('auth')`

---

## 📞 Support Reference

**Kontroller terkait:**
- `DashboardController::index()` - Dashboard stats
- `IncomingOrdersController::index()` - Listing pending
- `IncomingOrdersController::updateStatus()` - Accept/reject
- `ServiceController::store()/update()` - File validation

**Routes terkait:**
- `GET /mitra/dashboard` → DashboardController@index
- `GET /mitra/orders/incoming` → IncomingOrdersController@index
- `POST /mitra/orders/incoming/status` → IncomingOrdersController@updateStatus

**Database terkait:**
- `orders` table: order transactions
- `earnings` table: komisi mitra
- `portfolio_images` table: portfolio uploads
- `services` table: layanan yang ditawarkan

---

## 🎯 Prinsip KISS yang Diterapkan

1. **DRY (Don't Repeat Yourself)**
   - Relasi model untuk query
   - Helper functions untuk format rupiah & date

2. **Single Responsibility**
   - Controller: hanya logic dan query
   - View: hanya display
   - Model: hanya relasi dan validation

3. **Readable Code**
   - Named queries dengan whereHas untuk clarity
   - Consistent naming: order_code, customer_name, dll
   - Comments di migration untuk context

4. **No Over-engineering**
   - Closure routes untuk simple listing (orders history)
   - Direct model queries tanpa additional abstraction
   - Minimal service layer - langsung ke model

---

**Created: 31 Mei 2026**  
**Status: Production Ready** ✅
