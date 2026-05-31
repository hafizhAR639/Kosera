<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>KOSERA - Profil Diri</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f4f7fe] font-['Plus_Jakarta_Sans',sans-serif] text-[#004a6d] antialiased">
  <div class="mx-auto flex min-h-screen max-w-6xl flex-col px-4 py-8 md:px-6 lg:px-8">
    <header class="mb-12 flex items-start justify-between gap-6">
      <div class="flex items-center gap-2">
        <img src="{{ asset('img/logos/kosera-logo.png') }}" alt="KOSERA" class="h-10 w-auto object-contain">
      </div>
      <div class="hidden w-40 lg:block"></div>
    </header>

    @php
      $role = request('role') ?? old('role') ?? 'user';
      $showPortfolio = $role === 'mitra';
    @endphp
    <nav class="relative mb-16 w-full">
      <div class="absolute top-6 left-0 right-0 h-1 bg-[#73b4ff]"></div>
      <div class="relative z-10 flex justify-between gap-3">
        <div class="flex flex-col items-center gap-2">
          <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#1e68a1] text-xl font-bold text-white shadow-lg shadow-blue-200 md:h-14 md:w-14">1</div>
          <span class="text-sm font-bold text-[#0070ba]">Profil Diri</span>
        </div>
        <div class="flex flex-col items-center gap-2">
          <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-[#73b4ff] bg-white text-xl font-bold text-[#73b4ff] md:h-14 md:w-14">2</div>
          <span class="text-sm font-semibold text-[#0070ba]">Verifikasi Data</span>
        </div>
        @if($showPortfolio)
        <div class="flex flex-col items-center gap-2">
          <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-[#73b4ff] bg-white text-xl font-bold text-[#73b4ff] md:h-14 md:w-14">3</div>
          <span class="text-sm font-semibold text-[#0070ba]">Album/Portofolio</span>
        </div>
        @endif
        <div class="flex flex-col items-center gap-2">
          <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-[#73b4ff] bg-white text-xl font-bold text-[#73b4ff] md:h-14 md:w-14">{{ $showPortfolio ? 4 : 3 }}</div>
          <span class="text-sm font-semibold text-[#0070ba]">Keuangan</span>
        </div>
      </div>
    </nav>

    <main class="mx-auto flex w-full max-w-5xl flex-1 flex-col items-center gap-10 md:grid md:grid-cols-12 md:items-start md:gap-8">
      <aside class="md:col-span-4 flex flex-col items-center pt-8">
        <div class="w-full rounded-3xl border border-blue-100 bg-white p-6 shadow-sm">
          <h3 class="mb-4 text-lg font-bold text-[#004a6d]">Lengkapi Data Dasar</h3>
          <ul class="space-y-3 text-sm text-slate-600">
            <li class="flex gap-2"><span class="text-[#73b4ff]">✔</span> Pakai nama asli sesuai identitas.</li>
            <li class="flex gap-2"><span class="text-[#73b4ff]">✔</span> Pastikan email dan nomor aktif.</li>
            <li class="flex gap-2"><span class="text-[#73b4ff]">✔</span> Lanjut ke verifikasi setelah ini.</li>
          </ul>
        </div>
      </aside>

      <section class="md:col-span-8 w-full">
        <form id="register-step1" action="{{ route('register') }}" method="POST" class="space-y-5">
        @php $reg = session('register.data', []); @endphp
          @csrf
          <input type="hidden" name="role" value="{{ $role }}" />
          <div class="space-y-1">
            <label class="ml-1 block text-sm font-medium text-[#717171]" for="nama">Nama Lengkap</label>
            <input id="nama" name="nama" type="text" value="{{ old('nama', $reg['nama'] ?? '') }}" required class="w-full rounded-xl border-none bg-[#d9dee6] px-4 py-3 transition-all focus:ring-2 focus:ring-[#0073a5] @error('nama') ring-2 ring-red-500 @enderror" placeholder="Isi nama lengkap">
            @error('nama') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
          </div>

          <div class="space-y-1">
            <label class="ml-1 block text-sm font-medium text-[#717171]" for="phone">Nomor Telepon</label>
            <input id="phone" name="phone" type="tel" value="{{ old('phone', $reg['phone'] ?? '') }}" class="w-full rounded-xl border-none bg-[#d9dee6] px-4 py-3 transition-all focus:ring-2 focus:ring-[#0073a5]" placeholder="Isi nomor telepon">
          </div>

          <div class="space-y-1">
            <label class="ml-1 block text-sm font-medium text-[#717171]" for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $reg['email'] ?? '') }}" required class="w-full rounded-xl border-none bg-[#d9dee6] px-4 py-3 transition-all focus:ring-2 focus:ring-[#0073a5] @error('email') ring-2 ring-red-500 @enderror" placeholder="Isi email aktif">
            @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
          </div>

          <div class="space-y-1">
            <label class="ml-1 block text-sm font-medium text-[#717171]" for="password">Kata Sandi</label>
            <input id="password" name="password" type="password" required class="w-full rounded-xl border-none bg-[#d9dee6] px-4 py-3 transition-all focus:ring-2 focus:ring-[#0073a5] @error('password') ring-2 ring-red-500 @enderror" placeholder="Buat kata sandi">
            @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
          </div>

          <div class="space-y-1">
            <label class="ml-1 block text-sm font-medium text-[#717171]" for="password_confirmation">Konfirmasi Kata Sandi</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full rounded-xl border-none bg-[#d9dee6] px-4 py-3 transition-all focus:ring-2 focus:ring-[#0073a5]" placeholder="Ulangi kata sandi">
          </div>

          <div class="space-y-1">
            <label class="ml-1 block text-sm font-medium text-[#717171]" for="alamat">Alamat Lengkap</label>
            <textarea id="alamat" name="alamat" rows="3" class="w-full rounded-xl border-none bg-[#d9dee6] px-4 py-3 transition-all focus:ring-2 focus:ring-[#0073a5]" placeholder="Isi alamat lengkap (jalan, kelurahan, kecamatan, kota)">{{ old('alamat', $reg['alamat'] ?? '') }}</textarea>
          </div>

          <div class="pt-4 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('login') }}" class="inline-flex justify-center rounded-lg border border-[#0073a5] px-6 py-3 text-sm font-semibold text-[#0073a5] transition-colors hover:bg-[#eaf4ff]">
              Masuk
            </a>
            <button type="submit" class="inline-flex justify-center rounded-lg bg-[#0073a5] px-6 py-3 text-lg font-bold text-white shadow-md transition-colors hover:bg-opacity-90">
              Selanjutnya
            </button>
          </div>
        </form>
      </section>
    </main>
  </div>

  <script>
    // save profile address to localStorage so later steps (keuangan) can reuse it
    document.getElementById('register-step1')?.addEventListener('submit', function () {
      var alamat = document.getElementById('alamat')?.value || '';
      try { localStorage.setItem('kosera_register_alamat', alamat); } catch (e) { /* ignore */ }
    });
  </script>
</body>
</html>
