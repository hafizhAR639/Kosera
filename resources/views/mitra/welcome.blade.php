<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8" />
<meta content="width=device-width, initial-scale=1.0" name="viewport" />
<title>Mitra KOSERA - Selamat Datang</title>

@vite(['resources/css/app.css', 'resources/js/app.js'])

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
    body { font-family: 'Inter', sans-serif; }
    .grid-dots { background-image: radial-gradient(#CBD5E1 2px, transparent 2px); background-size: 20px 20px; }
</style>
</head>
<body class="bg-kosera-50 text-slate-800 antialiased">
  <nav class="sticky top-0 z-50 border-b border-kosera-100 bg-white px-6 py-4 shadow-sm md:px-12">
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-6">
      <div class="flex items-center gap-10">
        <a href="{{ route('welcome') }}" class="flex items-center gap-3">
          <img alt="KOSERA Logo" class="h-10 w-auto object-contain" src="{{ asset('img/logos/kosera-logo.png') }}" />
        </a>
        <div class="hidden items-center gap-8 text-sm font-medium md:flex">
          <a class="border-b-2 border-kosera-400 pb-1 text-kosera-800 hover:text-kosera-600" href="#">Tentang Kami</a>
          <a class="text-slate-600 hover:text-kosera-600" href="#">Kontak</a>
        </div>
      </div>
      <div class="flex items-center gap-3">
        <a href="{{ route('login') }}" class="rounded-full border border-kosera-200 bg-white px-6 py-2 font-medium text-kosera-600 transition-colors hover:bg-kosera-50">Masuk</a>
        <a href="{{ route('register') }}" class="rounded-full bg-kosera-400 px-6 py-2 font-medium text-white transition-colors hover:bg-kosera-600">Daftar</a>
      </div>
    </div>
  </nav>

  <main>
    <section class="container mx-auto px-6 py-12 md:flex-row md:py-24 flex flex-col items-center gap-12">
      <div class="flex-1 space-y-6">
        <h1 class="text-4xl font-extrabold leading-tight text-slate-900 md:text-5xl">
          Selamat Datang di<br />
          <span class="text-kosera-400">Mitra KOSERA</span>
        </h1>
        <p class="max-w-lg text-lg leading-relaxed text-slate-600">
          Masuk untuk mengelola pesanan dan mulai mendapatkan penghasilan dari layanan yang anda tawarkan.
        </p>
        <a href="{{ route('register') }}" class="inline-flex rounded-xl bg-kosera-400 px-8 py-3 text-lg font-bold text-white shadow-lg transition-transform hover:scale-105 hover:bg-kosera-600">Mulai Sekarang</a>
      </div>

      <div class="relative flex-1 w-full">
        <div class="absolute -left-10 -top-4 z-20 flex items-center gap-2 rounded-full border border-orange-100 bg-white px-4 py-2 shadow-md">
          <span class="text-xs font-bold text-orange-500">Daftarkan Dirimu Sekarang!</span>
        </div>
        <div class="relative mx-auto w-full max-w-md">
          <div class="absolute inset-0 -rotate-3 rounded-[3rem] bg-white z-0 shadow-sm"></div>
          <div class="relative z-10 p-4">
            <img alt="Mitra KOSERA" class="aspect-[4/5] w-full rounded-[2.5rem] object-cover object-top" src="{{ asset('img/illustrations/hero-mitra-welcome.png') }}" />
          </div>
          <div class="absolute bottom-10 right-0 z-20 flex items-center gap-3 rounded-2xl bg-white p-3 shadow-xl border border-slate-50">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 text-green-600">
              <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </div>
            <div>
              <p class="text-xs font-bold text-slate-900">1.000++</p>
              <p class="text-[10px] text-slate-500">Mitra Bergabung</p>
            </div>
          </div>
          <div class="grid-dots absolute -bottom-6 -left-6 z-0 h-32 w-32 opacity-20"></div>
        </div>
      </div>
    </section>

    <section class="container mx-auto px-6 py-16">
      <div class="mb-16 text-center">
        <h2 class="inline-block rounded-xl bg-kosera-400 px-8 py-3 text-xl font-bold text-white shadow-md">Persyaratan Umum Menjadi Mitra Kosera</h2>
      </div>
      <div class="flex flex-col items-center justify-center gap-12 lg:flex-row">
        <div class="relative">
          <img alt="Requirements Illustration" class="h-auto w-80 rounded-3xl object-cover object-center grayscale-[0.2]" src="{{ asset('img/illustrations/illustration-feature.png') }}" />
          <div class="absolute -bottom-4 -right-4 rounded-xl border border-slate-100 bg-white px-4 py-2 shadow-lg"><span class="text-xs font-bold text-slate-700">Ini Dia Syaratnya</span></div>
        </div>
        <div class="grid max-w-3xl grid-cols-1 gap-6 md:grid-cols-2">
          <div class="flex min-h-[160px] flex-col items-center justify-center rounded-2xl bg-white p-8 text-center shadow-sm border border-kosera-50"><p class="text-lg font-bold leading-snug text-kosera-400">Minimal 18 Tahun dan Maksimal 50 Tahun</p></div>
          <div class="flex min-h-[160px] flex-col items-center justify-center rounded-2xl bg-white p-8 text-center shadow-sm border border-kosera-50"><p class="text-lg font-bold leading-snug text-kosera-400">Memiliki KTP<br />(Identitas Diri)</p></div>
          <div class="flex min-h-[160px] flex-col items-center justify-center rounded-2xl bg-white p-8 text-center shadow-sm border border-kosera-50"><p class="text-lg font-bold leading-snug text-kosera-400">Memiliki Nomor HP Aktif</p></div>
          <div class="flex min-h-[160px] flex-col items-center justify-center rounded-2xl bg-white p-8 text-center shadow-sm border border-kosera-50"><p class="text-lg font-bold leading-snug text-kosera-400">Memiliki Keahlian Sesuai Layanan</p></div>
        </div>
      </div>
    </section>

    <section class="container mx-auto px-6 py-16">
      <div class="mb-20 text-center"><h2 class="inline-block rounded-xl bg-kosera-400 px-10 py-3 text-xl font-bold uppercase tracking-tight text-white shadow-md">Kenapa Harus Bergabung Dengan Kosera?</h2></div>
      <div class="mx-auto max-w-5xl space-y-24">
        <div class="flex flex-col items-center gap-12 md:flex-row">
          <div class="flex flex-1 justify-center"><img alt="Income Illustration" class="h-auto w-full max-w-xs" src="{{ asset('img/illustrations/illustration-growth-motivation.png') }}" /></div>
          <div class="flex-1 text-center md:text-left">
            <div class="mb-4 flex items-center justify-center gap-4 md:justify-start">
              <h3 class="text-2xl font-bold uppercase tracking-tight text-slate-900">Penghasilan Tambahan</h3>
              <span class="flex h-10 w-10 items-center justify-center rounded-full bg-kosera-400 text-lg font-bold text-white">1</span>
            </div>
            <p class="text-lg leading-relaxed text-slate-600">Dapatkan penghasilan dari setiap pekerjaan yang kamu selesaikan secara fleksibel.</p>
          </div>
        </div>
        <div class="flex flex-col items-center gap-12 md:flex-row-reverse">
          <div class="flex flex-1 justify-center"><img alt="Skills Illustration" class="h-auto w-full max-w-xs" src="{{ asset('img/illustrations/illustration-teamwork.png') }}" /></div>
          <div class="flex-1 text-center md:text-right">
            <div class="mb-4 flex items-center justify-center gap-4 md:justify-end">
              <span class="flex h-10 w-10 items-center justify-center rounded-full bg-kosera-400 text-lg font-bold text-white">2</span>
              <h3 class="text-2xl font-bold uppercase tracking-tight text-slate-900">Pilih Sesuai Keahlian</h3>
            </div>
            <p class="text-lg leading-relaxed text-slate-600">Dapat memilih pekerjaan berdasarkan kemampuan yang dimiliki.</p>
          </div>
        </div>
        <div class="flex flex-col items-center gap-12 md:flex-row">
          <div class="flex flex-1 justify-center"><img alt="Easy to Use Illustration" class="h-auto w-full max-w-xs" src="{{ asset('img/illustrations/illustration-authentication.png') }}" /></div>
          <div class="flex-1 text-center md:text-left">
            <div class="mb-4 flex items-center justify-center gap-4 md:justify-start">
              <h3 class="text-2xl font-bold uppercase tracking-tight text-slate-900">Mudah Digunakan</h3>
              <span class="flex h-10 w-10 items-center justify-center rounded-full bg-kosera-400 text-lg font-bold text-white">3</span>
            </div>
            <p class="text-lg leading-relaxed text-slate-600">Kelola seluruh pesanan dengan sistem yang praktis, dan mudah dipahami. Menyelesaikan pekerjaan dapat dilakukan dalam satu dashboard.</p>
          </div>
        </div>
        <div class="flex flex-col items-center gap-12 md:flex-row-reverse">
          <div class="flex flex-1 justify-center"><img alt="Trusted Illustration" class="h-auto w-full max-w-xs" src="{{ asset('img/illustrations/illustration-social-media.png') }}" /></div>
          <div class="flex-1 text-center md:text-right">
            <div class="mb-4 flex items-center justify-center gap-4 md:justify-end">
              <span class="flex h-10 w-10 items-center justify-center rounded-full bg-kosera-400 text-lg font-bold text-white">4</span>
              <h3 class="text-2xl font-bold uppercase tracking-tight text-slate-900">Aman dan Terpercaya</h3>
            </div>
            <p class="text-lg leading-relaxed text-slate-600">Sistem verifikasi membantu menjaga keamanan serta meningkatkan kepercayaan pengguna.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="container mx-auto px-6 py-16 bg-kosera-50">
      <div class="mb-16 text-center"><h2 class="inline-block rounded-xl bg-kosera-400 px-16 py-3 text-xl font-bold text-white shadow-md">Cerita Mitra Kosera</h2></div>
      <div class="mx-auto grid max-w-6xl grid-cols-1 gap-8 md:grid-cols-3">
        <div class="space-y-4 rounded-2xl bg-white p-8 shadow-sm">
          <div class="flex text-yellow-400">★★★★★</div>
          <p class="text-sm leading-relaxed text-slate-600">Sejak gabung di Kosera, aku jadi lebih mudah dapat pekerjaan tambahan. Sistemnya juga simpel, jadi gak ribet.</p>
          <div class="flex flex-col items-center gap-12 md:flex-row">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100"></div>
            <div><p class="text-xs font-bold text-slate-900">Andi</p><p class="text-[10px] text-slate-500">Perbaikan, Antar Jemput</p></div>
          </div>
        </div>
        <div class="space-y-4 rounded-2xl bg-white p-8 shadow-sm">
          <div class="flex text-yellow-400">★★★★★</div>
          <p class="text-sm leading-relaxed text-slate-600">Awalnya coba-coba, tapi ternyata banyak peluang kerja. Enak juga bisa pilih pekerjaan sendiri.</p>
          <div class="flex flex-col items-center gap-12 md:flex-row">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100"></div>
            <div><p class="text-xs font-bold text-slate-900">Rizky</p><p class="text-[10px] text-slate-500">Titip Beli</p></div>
          </div>
        </div>
        <div class="space-y-4 rounded-2xl bg-white p-8 shadow-sm">
          <div class="flex text-yellow-400">★★★★★</div>
          <p class="text-sm leading-relaxed text-slate-600">Aku jadi lebih produktif. Selain bantu orang lain, juga bisa dapat penghasilan tambahan.</p>
          <div class="flex flex-col items-center gap-12 md:flex-row">
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100"></div>
            <div><p class="text-xs font-bold text-slate-900">Sinta</p><p class="text-[10px] text-slate-500">Perbaikan, Titip Beli</p></div>
          </div>
        </div>
      </div>
    </section>

    <section class="container mx-auto px-6 py-20">
      <div class="mx-auto max-w-4xl rounded-[2.5rem] bg-kosera-400 p-12 text-center shadow-xl transition hover:scale-[1.02] md:p-20">
        <h2 class="text-3xl font-bold leading-tight text-white md:text-4xl">Gabung Sekarang dan Mulai Jadi Mitra Kosera!</h2>
      </div>
    </section>
  </main>

  <footer class="h-24"></footer>
</body>
</html>
