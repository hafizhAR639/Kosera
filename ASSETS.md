# 📁 Image Assets Documentation - Kosera Mitra

## Struktur Folder Images

Project sekarang menggunakan struktur folder yang terorganisir untuk semua image assets:

```
img/
├── logos/
│   └── kosera-logo.png               # Logo brand Kosera (digunakan di header & sidebar)
│
├── illustrations/
│   ├── hero-mitra-welcome.png        # Hero illustration untuk welcome/landing page
│   ├── illustration-feature.png      # Feature/promotional illustration
│   ├── illustration-brand.png        # Brand-related illustration
│   ├── illustration-authentication.png   # Authentication/security illustration
│   ├── illustration-teamwork.png     # Teamwork/collaboration illustration
│   ├── illustration-growth-motivation.png # Growth/motivation illustration
│   └── illustration-social-media.png # Social media marketing illustration
│
└── ui/
    └── (untuk UI elements, icons, atau components)
```

---

## 📋 Image Inventory & Usage

| Filename | Kategori | Deskripsi | Lokasi Penggunaan |
|----------|----------|-----------|------------------|
| `kosera-logo.png` | Logo | Logo brand Kosera 1:1 | Header welcome page, Sidebar |
| `hero-mitra-welcome.png` | Illustration | Hero illustration untuk mitra di welcome page | `/auth/welcome.php` |
| `illustration-feature.png` | Illustration | Feature/promotional illustration | (Siap untuk digunakan) |
| `illustration-brand.png` | Illustration | Brand-related illustration | (Siap untuk digunakan) |
| `illustration-authentication.png` | Illustration | Authentication/security related | (Siap untuk digunakan) |
| `illustration-teamwork.png` | Illustration | Teamwork & collaboration | (Siap untuk digunakan) |
| `illustration-growth-motivation.png` | Illustration | Growth, motivation, earnings | (Siap untuk digunakan) |
| `illustration-social-media.png` | Illustration | Social media marketing | (Siap untuk digunakan) |

---

## 🎯 Naming Convention

Semua images mengikuti naming convention yang jelas:

### 1. **Logos** (`img/logos/`)
   - Format: `kosera-logo.png`
   - Deskriptif dan singkat
   - Untuk brand/logo identitas

### 2. **Illustrations** (`img/illustrations/`)
   - Format: `illustration-{purpose}.png`
   - Prefix `illustration-` untuk konsistensi
   - Suffix menjelaskan tujuan/konten
   - Contoh: `illustration-teamwork.png`, `illustration-growth-motivation.png`

### 3. **UI Elements** (`img/ui/`)
   - Format: `icon-{name}.png` atau `ui-{component}.png`
   - Untuk icons, buttons, atau reusable components

---

## 🔄 References Update

### File yang telah diupdate:

1. **`app/Views/auth/welcome.php`**
   - ❌ `img/image-4-(2)-2.png` → ✅ `img/logos/kosera-logo.png`
   - ❌ `img/desain-tanpa-judul-(65)-1.png` → ✅ `img/illustrations/hero-mitra-welcome.png`

2. **`sidebar.php`**
   - ❌ `img/image-4-(2)-2.png` → ✅ `img/logos/kosera-logo.png`

---

## 🚀 Cara Menggunakan Images

### Dalam Blade/PHP Views:

```php
<!-- Logo -->
<img src="img/logos/kosera-logo.png" alt="Kosera" class="h-12 w-auto">

<!-- Illustration Hero -->
<img src="img/illustrations/hero-mitra-welcome.png" alt="Welcome Mitra" class="w-full">

<!-- Future: Other Illustrations -->
<img src="img/illustrations/illustration-teamwork.png" alt="Team" class="w-full">
```

### Path relatif:
- Dari **root project**: `img/logos/kosera-logo.png`
- Dari **views folder**: `../img/logos/kosera-logo.png` (jika diperlukan)

---

## 📏 Image Specifications & Best Practices

### Rekomendasi Ukuran:

| Kategori | Ukuran Rekomendasi | Format | Quality |
|----------|-------------------|--------|---------|
| Logo | 200×200px - 400×400px | PNG (transparent) | 100% |
| Hero Illustration | 600×600px - 1200×1200px | PNG / WebP | 90-95% |
| Feature Illustration | 400×400px - 800×800px | PNG / WebP | 90% |
| Icons/UI | 24px - 128px | PNG (transparent) / SVG | 100% |

### Optimasi:

- 🗜️ Gunakan image compression tools (TinyPNG, FileOptimizer)
- 📦 Pertimbangkan dengan WebP untuk produksi
- ♻️ Reuse illustrations sebanyak mungkin untuk consistency
- 🎨 Maintain brand color palette di semua illustrations

---

## 🎨 Color & Style Guide

Kosera Mitra menggunakan warna-warna berikut (dari Tailwind CSS):

### Primary Colors:
- **Sky Blue**: `#0ea5e9` (sky-500) atau `#0c63e4` (sky-600)
- **Dark Sky**: `#0369a1` (sky-700)
- **Light Sky**: `#e0f2fe` (sky-100)

### Accents:
- **Cyan**: `#06b6d4` (cyan-500)
- **White**: `#ffffff`
- **Slate**: `#1e293b` (slate-900)

Pastikan semua illustrations mengikuti color palette ini untuk konsistensi brand.

---

## 👥 Contoh Penggunaan di Views

### Welcome Page (`app/Views/auth/welcome.php`):

```html
<header>
    <img src="img/logos/kosera-logo.png" alt="Kosera" class="h-12">
</header>

<div class="grid lg:grid-cols-2">
    <div>
        <!-- Text content -->
    </div>
    <div>
        <img src="img/illustrations/hero-mitra-welcome.png" alt="Ilustrasi Mitra">
    </div>
</div>
```

### Sidebar (`sidebar.php`):

```html
<aside>
    <img src="img/logos/kosera-logo.png" alt="Kosera" class="h-12">
    <!-- Navigation items -->
</aside>
```

---

## 📝 Maintenance Checklist

- [x] Organize images dalam folder berdasarkan kategori
- [x] Rename images dengan naming convention yang jelas
- [x] Update semua references di PHP/Blade files
- [ ] Compress all images untuk production
- [ ] Convert suitable images ke WebP format
- [ ] Add alt text yang deskriptif untuk accessibility
- [ ] Document setiap image yang ditambahkan baru
- [ ] Maintain brand consistency di semua assets

---

## 🔗 Related Files

- **Styling**: `style.css`, Tailwind CDN
- **Logo Assets**: `img/logos/`
- **Illustrations**: `img/illustrations/`
- **Views**: `app/Views/`, `sidebar.php`

---

## 📌 Catatan

- Jika menambah image baru, ikuti struktur folder dan naming convention ini
- Semua paths bersifat **relative to project root**
- Untuk development, bisa langsung mengakses dari browser: `http://localhost/kosera-mitra/img/logos/kosera-logo.png`
- Untuk production, pastikan folder `img/` readable oleh web server
