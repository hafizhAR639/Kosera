# REFACT.md — Panduan Refactoring KOSERA

> **Tujuan dokumen ini**: Memandu AI (atau developer) dalam melakukan refactoring project KOSERA secara bertahap dan aman, tanpa mengubah desain view Blade yang sudah ada.

---

## Konteks Project

| Atribut | Detail |
|---|---|
| **Nama** | KOSERA — Marketplace Jasa |
| **Stack** | Laravel 11, PHP 8.2+, Blade, Tailwind CSS 3, Vite 6, MySQL |
| **Tujuan sistem** | Menghubungkan user dengan mitra profesional (order, pembayaran, rating) |
| **Fitur utama** | Dashboard user/mitra, alur pesanan, riwayat, profil, portofolio, sertifikat, registrasi bertahap |

---

## Batasan Keras (Jangan Dilanggar)

> Baca ini dulu sebelum menyentuh kode apapun.

1. **Jangan ubah desain view Blade** — file di `resources/views/` hanya boleh diubah logika PHP-nya (hapus `@php DB::...`, perbaiki variable passing), bukan struktur HTML/Tailwind-nya.
2. **Jangan ubah nama route** — `user.dashboard`, `user.orders.history`, `mitra.dashboard`, dll harus tetap sama persis.
3. **Jangan ubah nama Blade view** — path view yang dipanggil `view('...')` tidak boleh berubah.
4. **Jangan hapus folder legacy** — `app/Controllers/`, `app/Core/`, `app/Helpers/`, `app/Views/` dibiarkan saja, tidak perlu disentuh.
5. **Prinsip KISS** — solusi paling sederhana yang menyelesaikan masalah. Tidak perlu over-engineer.
6. **Satu perubahan, satu PR** — refactor per fitur/layer, bukan sekaligus semua.

---

## Arsitektur Target

```
routes/web.php
    → Controller (thin) — hanya validasi + panggil Service + return view
        → FormRequest    — validasi input
        → Service        — logika bisnis, orkestrasi
            → Repository — semua query Eloquent
                → Model  — relasi, scope, attribute
        → View (Blade)   — hanya presentasi, TIDAK BERUBAH desainnya
```

**Tidak perlu DTO/DataObject** untuk KOSERA — array atau Collection sudah cukup (KISS).

---

## Instruksi untuk AI

Kamu adalah senior Laravel developer. Saat saya memberikan kode dari project KOSERA, lakukan hal berikut:

### Langkah 1 — Audit dulu, jangan langsung ubah

Sebelum menulis kode apapun, identifikasi dan laporkan:

- **Fat Controller**: logika bisnis / query yang seharusnya tidak ada di sana
- **N+1 Problem**: relasi yang diakses di view tanpa `with()` di controller
- **Query di Blade**: `@php DB::...` atau `@php $x = Model::...` di dalam file view
- **If-else filter berlapis**: yang bisa diganti `when()`
- **Missing eager load**: relasi yang dipakai di view tapi tidak di-load

Format audit:
```
[FAT CONTROLLER] OrderController@store — ada 3 query langsung dan logika hitung total
[N+1] mitra.dashboard — $mitra->orders diakses tanpa eager load
[BLADE QUERY] user/orders/history.blade.php baris 12 — ada DB::select langsung
```

---

### Langkah 2 — Refactor Controller jadi tipis

**Sebelum (fat controller):**
```php
public function history(Request $request)
{
    $orders = DB::table('orders')
        ->join('mitras', 'orders.mitra_id', '=', 'mitras.id')
        ->where('orders.user_id', auth()->id())
        ->when($request->status, fn($q,$v) => $q->where('orders.status', $v))
        ->orderByDesc('orders.created_at')
        ->paginate(10);

    return view('user.orders.history', compact('orders'));
}
```

**Sesudah (thin controller):**
```php
public function history(Request $request)
{
    $orders = $this->orderService->getUserHistory(
        auth()->id(),
        $request->only(['status'])
    );
    return view('user.orders.history', compact('orders'));
    // view TIDAK berubah
}
```

---

### Langkah 3 — Buat Service per domain fitur

Buat file di `app/Services/`, satu file per domain:

```
app/Services/
  OrderService.php      ← logika order (user & mitra)
  MitraService.php      ← logika profil, portofolio, sertifikat mitra
  PaymentService.php    ← logika pembayaran
  RatingService.php     ← logika rating
```

**Aturan Service:**
- Tidak ada query Eloquent langsung di sini
- Panggil Repository atau Model scope
- Return data yang siap dipakai view (Collection, array, paginator)

```php
// app/Services/OrderService.php
class OrderService
{
    public function __construct(private OrderRepository $repo) {}

    public function getUserHistory(int $userId, array $filters)
    {
        return $this->repo->paginatedByUser($userId, $filters);
    }

    public function getMitraHistory(int $mitraId, array $filters)
    {
        return $this->repo->paginatedByMitra($mitraId, $filters);
    }
}
```

---

### Langkah 4 — Buat Repository per domain

Buat file di `app/Repositories/`:

```
app/Repositories/
  OrderRepository.php
  MitraRepository.php
  UserRepository.php
```

**Semua query Eloquent ada di sini:**

```php
// app/Repositories/OrderRepository.php
class OrderRepository
{
    public function paginatedByUser(int $userId, array $filters)
    {
        return Order::query()
            ->with(['mitra:id,nama,foto', 'service:id,nama'])
            ->where('user_id', $userId)
            ->when($filters['status'] ?? null, fn($q,$v) => $q->where('status', $v))
            ->latest()
            ->paginate(10);
    }

    public function paginatedByMitra(int $mitraId, array $filters)
    {
        return Order::query()
            ->with(['user:id,nama,foto'])
            ->where('mitra_id', $mitraId)
            ->when($filters['status'] ?? null, fn($q,$v) => $q->where('status', $v))
            ->latest()
            ->paginate(10);
    }
}
```

---

### Langkah 5 — Terapkan `when()` untuk semua filter

Ganti semua pola if-else filter menjadi `when()`:

```php
// SEBELUM
if ($request->filled('status')) {
    $query->where('status', $request->status);
}
if ($request->filled('tanggal_mulai')) {
    $query->whereDate('created_at', '>=', $request->tanggal_mulai);
}

// SESUDAH
->when($filters['status']      ?? null, fn($q,$v) => $q->where('status', $v))
->when($filters['tanggal_mulai'] ?? null, fn($q,$v) => $q->whereDate('created_at', '>=', $v))
```

Kalau filter di satu query > 5 kondisi (misalnya filter pencarian mitra), gunakan Pipeline:

```php
// app/Filters/Mitra/KategoriFilter.php
class KategoriFilter
{
    public function __invoke($query, Closure $next)
    {
        if ($k = request('kategori')) {
            $query->where('kategori_id', $k);
        }
        return $next($query);
    }
}

// Di MitraRepository
return app(Pipeline::class)
    ->send(Mitra::query()->with('kategori'))
    ->through([KategoriFilter::class, LokasiFilter::class, RatingFilter::class])
    ->thenReturn()
    ->paginate(12);
```

---

### Langkah 6 — Eloquent Scope untuk kondisi yang sering diulang

Tambahkan scope ke Model untuk kondisi yang muncul di banyak tempat:

```php
// app/Models/Order.php
class Order extends Model
{
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}

// Penggunaan di Repository
Order::byUser($userId)->selesai()->with('mitra')->latest()->paginate(10);
```

---

### Langkah 7 — Eager Loading, eliminasi N+1

Aktifkan detektor N+1 di `app/Providers/AppServiceProvider.php`:

```php
public function boot(): void
{
    Model::preventLazyLoading(! app()->isProduction());
}
```

Perbaiki semua relasi yang diakses di view tanpa eager load:

```php
// BURUK — N+1
$orders = Order::where('user_id', auth()->id())->paginate(10);
// di blade: $order->mitra->nama → query per baris!

// BENAR
$orders = Order::with(['mitra:id,nama,foto', 'service:id,nama'])
               ->where('user_id', auth()->id())
               ->paginate(10);
```

---

### Langkah 8 — Cache untuk query dashboard yang berat

Hanya untuk query yang memang berat (dashboard summary, statistik):

```php
// Di Service, bukan di Controller
public function getDashboardStats(int $mitraId): array
{
    return Cache::flexible(
        "mitra.dashboard.{$mitraId}",
        [300, 1800],  // fresh 5 menit, stale sampai 30 menit
        fn() => $this->repo->dashboardSummary($mitraId)
    );
}

// Invalidasi saat order baru masuk (di Observer)
Cache::forget("mitra.dashboard.{$order->mitra_id}");
```

Jangan cache sembarangan — hanya query yang > 100ms atau dipanggil sangat sering.

---

### Langkah 9 — Bersihkan Blade dari logika

Blade hanya untuk presentasi. Jika menemukan ini di view, pindahkan ke Controller/Service:

```blade
{{-- HAPUS ini dari Blade --}}
@php
    $orders = DB::table('orders')->where('user_id', auth()->id())->get();
    $total = $orders->sum('total');
@endphp

{{-- BENAR — variabel datang dari Controller --}}
{{-- $orders dan $total sudah disiapkan di controller, view tinggal pakai --}}
@forelse($orders as $order)
    ...
@empty
    <p>Belum ada pesanan.</p>
@endforelse
```

---

### Langkah 10 — Database Index

Tambahkan migration index untuk kolom yang sering dipakai di WHERE/ORDER BY:

```php
// database/migrations/xxxx_add_indexes_to_orders_table.php
Schema::table('orders', function (Blueprint $table) {
    $table->index('user_id');
    $table->index('mitra_id');
    $table->index('status');
    $table->index(['user_id', 'status']);
    $table->index(['mitra_id', 'status']);
    $table->index('created_at');
});

Schema::table('mitras', function (Blueprint $table) {
    $table->index('kategori_id');
    $table->index('status');
    $table->index(['kategori_id', 'status']);
});
```

---

## Format Output yang Diminta dari AI

Untuk setiap file yang direfactor:

1. **Isi file lengkap** — bukan snippet, tapi kode utuh yang langsung bisa disimpan
2. **Penjelasan 2-3 kalimat** — apa yang berubah dan kenapa
3. **Urutan eksekusi** — file mana dulu, lalu apa, perintah artisan yang diperlukan
4. **Breaking change** — kalau ada perubahan yang bisa merusak sesuatu, sebutkan eksplisit

---

## Urutan Prioritas Refactoring

Kerjakan dalam urutan ini agar aman dan bertahap:

```
Fase 1 — Fondasi (tidak merusak apapun)
  [ ] Aktifkan preventLazyLoading() di AppServiceProvider
  [ ] Buat folder app/Services/ dan app/Repositories/ (kosong dulu)

Fase 2 — Fitur Order (paling kritikal)
  [ ] Buat OrderRepository — pindahkan semua query order ke sini
  [ ] Buat OrderService — pindahkan logika bisnis order
  [ ] Refactor OrderController (user & mitra) jadi thin
  [ ] Perbaiki N+1 di view history & detail order

Fase 3 — Dashboard
  [ ] Buat logika dashboard ke Service masing-masing
  [ ] Pasang Cache::flexible() untuk summary stats
  [ ] Invalidasi cache di Order observer

Fase 4 — Fitur Pendukung
  [ ] MitraService + MitraRepository (profil, portofolio, sertifikat)
  [ ] PaymentService
  [ ] RatingService
  [ ] Pipeline filter untuk pencarian mitra

Fase 5 — Database
  [ ] Migration index orders
  [ ] Migration index mitras
  [ ] Verifikasi dengan EXPLAIN
```

---

## Cara Pakai Dokumen Ini

1. Buka percakapan baru dengan AI
2. Paste seluruh isi `REFACT.md` ini sebagai konteks awal
3. Lanjutkan dengan paste kode yang mau direfactor, misalnya:

```
Ini isi OrderController.php saya saat ini:
[paste kode]

Tolong audit dulu, lalu refactor sesuai panduan di atas.
```

4. AI akan audit → konfirmasi → baru mulai refactor
