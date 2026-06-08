<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>KOSERA - Jasa Anak Kos Terpercaya</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .grid-dots { background-image: radial-gradient(#CBD5E1 2px, transparent 2px); background-size: 20px 20px; }
    </style>
</head>
<body class="bg-[linear-gradient(180deg,#dff0f8_0%,#eef8fc_52%,#f8fcfe_100%)] text-kosera-900 antialiased">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 border-b border-kosera-100 bg-white/95 px-6 py-4 shadow-sm backdrop-blur-sm md:px-12">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-6">
            <div class="flex items-center gap-10">
                <a href="{{ route('welcome') }}" class="flex items-center gap-3">
                    <img alt="KOSERA Logo" class="h-10 w-auto object-contain" src="{{ asset('img/logos/kosera-logo.png') }}" />
                </a>
                <div class="hidden items-center gap-8 text-sm font-bold md:flex">
                    <a class="text-slate-600 hover:text-kosera-600 transition-colors" href="#">Tentang Kami</a>
                    <a class="text-slate-600 hover:text-kosera-600 transition-colors" href="#">Kontak</a>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('login') }}" class="rounded-full border border-kosera-200 bg-white px-8 py-2 font-bold text-kosera-600 transition-all hover:bg-kosera-50">Masuk</a>
                <a href="{{ route('register') }}" class="rounded-full bg-kosera-400 px-8 py-2 font-bold text-white transition-all hover:bg-kosera-600 shadow-md hover:shadow-lg">Daftar</a>
            </div>
        </div>
    </nav>

    <main>
        <!-- Hero Section -->
        <section class="mx-auto flex max-w-7xl flex-col items-center gap-12 px-6 py-16 md:flex-row md:py-24">
            <div class="flex-1 space-y-8">
                <div class="inline-flex items-center rounded-full border border-orange-100 bg-orange-50 px-4 py-2 shadow-sm">
                    <span class="text-xs font-bold text-orange-500">Daftarkan Dirimu Sekarang!</span>
                </div>
                <h1 class="text-4xl font-extrabold leading-tight text-slate-900 md:text-5xl lg:text-6xl">
                    Selamat Datang di<br />
                    <span class="text-kosera-400">Mitra KOSERA</span>
                </h1>
                <p class="max-w-lg text-lg leading-relaxed text-slate-600">
                    Masuk untuk mengelola pesanan dan mulai mendapatkan penghasilan dari layanan yang anda tawarkan.
                </p>
                <div class="flex flex-wrap gap-4 pt-2">
                    <a href="{{ route('register') }}" class="inline-flex rounded-xl bg-kosera-400 px-10 py-4 text-lg font-bold text-white shadow-xl transition-all hover:scale-[1.02] hover:bg-kosera-600">
                        Mulai Sekarang
                    </a>
                </div>
            </div>

            <div class="relative flex-1 w-full">
                <div class="relative mx-auto w-full max-w-md">
                    <div class="absolute inset-0 -rotate-3 rounded-[3rem] bg-slate-50 z-0 border border-slate-100 shadow-sm"></div>
                    <div class="relative z-10 p-4">
                        <img alt="Mitra KOSERA" class="aspect-[4/5] w-full rounded-[2.5rem] object-cover object-top shadow-2xl" src="{{ asset('img/illustrations/hero-mitra-welcome.png') }}" />
                    </div>
                    <div class="absolute bottom-10 right-0 z-20 flex items-center gap-3 rounded-2xl bg-white/95 p-4 shadow-2xl border border-slate-50 backdrop-blur-sm">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 text-green-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.1"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm font-extrabold text-slate-900">1.000++</p>
                            <p class="text-xs font-medium text-slate-500">Mitra Bergabung</p>
                        </div>
                    </div>
                    <div class="grid-dots absolute -bottom-6 -left-6 z-0 h-32 w-32 opacity-30"></div>
                </div>
            </div>
        </section>

        <!-- Persyaratan Section -->
        <section class="bg-slate-50/50 py-24">
            <div class="mx-auto max-w-7xl px-6">
                <div class="mb-20 text-center">
                    <h2 class="inline-block rounded-2xl bg-kosera-400 px-10 py-4 text-xl font-extrabold text-white shadow-xl">
                        Persyaratan Umum Menjadi Mitra Kosera
                    </h2>
                </div>
                <div class="flex flex-col items-center justify-center gap-16 lg:flex-row">
                    <div class="relative lg:w-1/3">
                        <img alt="Requirements Illustration" class="h-auto w-full rounded-[2.5rem] object-cover shadow-2xl grayscale-[0.1]" src="{{ asset('img/illustrations/illustration-feature.png') }}" />
                        <div class="absolute -bottom-6 -right-6 rounded-2xl border border-slate-100 bg-white px-6 py-3 shadow-xl">
                            <span class="text-sm font-extrabold text-slate-700 italic">Ini Dia Syaratnya!</span>
                        </div>
                    </div>
                    <div class="grid flex-1 grid-cols-1 gap-6 md:grid-cols-2 lg:w-2/3">
                        <div class="flex min-h-[160px] flex-col items-center justify-center rounded-[2rem] bg-white p-8 text-center shadow-md border border-slate-100 transition-all hover:shadow-lg hover:border-kosera-100 group">
                            <p class="text-lg font-bold leading-snug text-slate-700 group-hover:text-kosera-600">Minimal 18 Tahun dan Maksimal 50 Tahun</p>
                        </div>
                        <div class="flex min-h-[160px] flex-col items-center justify-center rounded-[2rem] bg-white p-8 text-center shadow-md border border-slate-100 transition-all hover:shadow-lg hover:border-kosera-100 group">
                            <p class="text-lg font-bold leading-snug text-slate-700 group-hover:text-kosera-600">Memiliki KTP<br />(Identitas Diri)</p>
                        </div>
                        <div class="flex min-h-[160px] flex-col items-center justify-center rounded-[2rem] bg-white p-8 text-center shadow-md border border-slate-100 transition-all hover:shadow-lg hover:border-kosera-100 group">
                            <p class="text-lg font-bold leading-snug text-slate-700 group-hover:text-kosera-600">Memiliki Nomor HP Aktif</p>
                        </div>
                        <div class="flex min-h-[160px] flex-col items-center justify-center rounded-[2rem] bg-white p-8 text-center shadow-md border border-slate-100 transition-all hover:shadow-lg hover:border-kosera-100 group">
                            <p class="text-lg font-bold leading-snug text-slate-700 group-hover:text-kosera-600">Memiliki Keahlian Sesuai Layanan</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kenapa Harus Bergabung Section -->
        <section class="py-24">
            <div class="mx-auto max-w-7xl px-6">
                <div class="mb-24 text-center">
                    <h2 class="inline-block rounded-2xl bg-kosera-400 px-12 py-4 text-xl font-extrabold uppercase tracking-tight text-white shadow-xl">
                        Kenapa Harus Bergabung Dengan Kosera?
                    </h2>
                </div>
                
                <div class="mx-auto max-w-5xl space-y-32">
                    <div class="flex flex-col items-center gap-16 md:flex-row">
                        <div class="flex flex-1 justify-center relative">
                            <div class="absolute inset-0 bg-kosera-50 rounded-full blur-3xl opacity-50"></div>
                            <img alt="Income Illustration" class="relative z-10 h-auto w-full max-w-sm drop-shadow-2xl" src="{{ asset('img/illustrations/illustration-growth-motivation.png') }}" />
                        </div>
                        <div class="flex-1 text-center md:text-left space-y-4">
                            <div class="flex items-center justify-center gap-6 md:justify-start">
                                <h3 class="text-2xl font-extrabold uppercase tracking-tight text-slate-900">Penghasilan Tambahan</h3>
                                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-kosera-400 text-xl font-black text-white shadow-lg">1</span>
                            </div>
                            <p class="text-lg leading-relaxed text-slate-600">Dapatkan penghasilan dari setiap pekerjaan yang kamu selesaikan secara fleksibel.</p>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-16 md:flex-row-reverse">
                        <div class="flex flex-1 justify-center relative">
                            <div class="absolute inset-0 bg-orange-50 rounded-full blur-3xl opacity-50"></div>
                            <img alt="Skills Illustration" class="relative z-10 h-auto w-full max-w-sm drop-shadow-2xl" src="{{ asset('img/illustrations/illustration-teamwork.png') }}" />
                        </div>
                        <div class="flex-1 text-center md:text-right space-y-4">
                            <div class="flex items-center justify-center gap-6 md:justify-end">
                                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-kosera-400 text-xl font-black text-white shadow-lg">2</span>
                                <h3 class="text-2xl font-extrabold uppercase tracking-tight text-slate-900">Pilih Sesuai Keahlian</h3>
                            </div>
                            <p class="text-lg leading-relaxed text-slate-600">Dapat memilih pekerjaan berdasarkan kemampuan yang dimiliki.</p>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-16 md:flex-row">
                        <div class="flex flex-1 justify-center relative">
                            <div class="absolute inset-0 bg-green-50 rounded-full blur-3xl opacity-50"></div>
                            <img alt="Easy to Use Illustration" class="relative z-10 h-auto w-full max-w-sm drop-shadow-2xl" src="{{ asset('img/illustrations/illustration-authentication.png') }}" />
                        </div>
                        <div class="flex-1 text-center md:text-left space-y-4">
                            <div class="flex items-center justify-center gap-6 md:justify-start">
                                <h3 class="text-2xl font-extrabold uppercase tracking-tight text-slate-900">Mudah Digunakan</h3>
                                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-kosera-400 text-xl font-black text-white shadow-lg">3</span>
                            </div>
                            <p class="text-lg leading-relaxed text-slate-600">Kelola seluruh pesanan dengan sistem yang praktis, dan mudah dipahami. Menyelesaikan pekerjaan dapat dilakukan dalam satu dashboard.</p>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-16 md:flex-row-reverse">
                        <div class="flex flex-1 justify-center relative">
                            <div class="absolute inset-0 bg-blue-50 rounded-full blur-3xl opacity-50"></div>
                            <img alt="Trusted Illustration" class="relative z-10 h-auto w-full max-w-sm drop-shadow-2xl" src="{{ asset('img/illustrations/illustration-social-media.png') }}" />
                        </div>
                        <div class="flex-1 text-center md:text-right space-y-4">
                            <div class="flex items-center justify-center gap-6 md:justify-end">
                                <span class="flex h-12 w-12 items-center justify-center rounded-full bg-kosera-400 text-xl font-black text-white shadow-lg">4</span>
                                <h3 class="text-2xl font-extrabold uppercase tracking-tight text-slate-900">Aman dan Terpercaya</h3>
                            </div>
                            <p class="text-lg leading-relaxed text-slate-600">Sistem verifikasi membantu menjaga keamanan serta meningkatkan kepercayaan pengguna.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cerita Mitra Section -->
        <section class="bg-kosera-50 py-24">
            <div class="mx-auto max-w-7xl px-6">
                <div class="mb-20 text-center">
                    <h2 class="inline-block rounded-2xl bg-kosera-400 px-16 py-4 text-xl font-extrabold text-white shadow-xl">
                        Cerita Mitra Kosera
                    </h2>
                </div>
                <div class="mx-auto grid max-w-6xl grid-cols-1 gap-8 md:grid-cols-3">
                    <!-- Testimonial 1 -->
                    <div class="group flex flex-col space-y-6 rounded-[2.5rem] bg-white p-10 shadow-lg border border-transparent transition-all hover:shadow-2xl hover:border-kosera-100">
                        <div class="flex text-yellow-400 text-xl">★★★★★</div>
                        <p class="text-base leading-relaxed text-slate-600 italic">"Sejak gabung di Kosera, aku jadi lebih mudah dapat pekerjaan tambahan. Sistemnya juga simpel, jadi gak ribet."</p>
                        <div class="flex items-center gap-4 pt-4 border-t border-slate-50">
                            <div class="h-14 w-14 rounded-2xl bg-kosera-50 flex items-center justify-center text-kosera-400 text-2xl font-black">A</div>
                            <div>
                                <p class="text-sm font-black text-slate-900">Andi</p>
                                <p class="text-xs font-bold text-slate-400">Perbaikan, Antar Jemput</p>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 2 -->
                    <div class="group flex flex-col space-y-6 rounded-[2.5rem] bg-white p-10 shadow-lg border border-transparent transition-all hover:shadow-2xl hover:border-kosera-100">
                        <div class="flex text-yellow-400 text-xl">★★★★★</div>
                        <p class="text-base leading-relaxed text-slate-600 italic">"Awalnya coba-coba, tapi ternyata banyak peluang kerja. Enak juga bisa pilih pekerjaan sendiri."</p>
                        <div class="flex items-center gap-4 pt-4 border-t border-slate-50">
                            <div class="h-14 w-14 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-400 text-2xl font-black">R</div>
                            <div>
                                <p class="text-sm font-black text-slate-900">Rizky</p>
                                <p class="text-xs font-bold text-slate-400">Titip Beli</p>
                            </div>
                        </div>
                    </div>
                    <!-- Testimonial 3 -->
                    <div class="group flex flex-col space-y-6 rounded-[2.5rem] bg-white p-10 shadow-lg border border-transparent transition-all hover:shadow-2xl hover:border-kosera-100">
                        <div class="flex text-yellow-400 text-xl">★★★★★</div>
                        <p class="text-base leading-relaxed text-slate-600 italic">"Aku jadi lebih produktif. Selain bantu orang lain, juga bisa dapat penghasilan tambahan."</p>
                        <div class="flex items-center gap-4 pt-4 border-t border-slate-50">
                            <div class="h-14 w-14 rounded-2xl bg-green-50 flex items-center justify-center text-green-400 text-2xl font-black">S</div>
                            <div>
                                <p class="text-sm font-black text-slate-900">Sinta</p>
                                <p class="text-xs font-bold text-slate-400">Perbaikan, Titip Beli</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Final CTA Section -->
        <section class="mx-auto max-w-7xl px-6 py-24">
            <div class="relative overflow-hidden rounded-[3.5rem] bg-gradient-to-br from-kosera-400 to-kosera-600 p-16 text-center shadow-2xl transition-all hover:scale-[1.01] md:p-24">
                <div class="relative z-10 space-y-8">
                    <h2 class="text-4xl font-extrabold leading-tight text-white md:text-5xl lg:text-6xl">
                        Gabung Sekarang dan Mulai<br />Jadi Mitra Kosera!
                    </h2>
                    <div class="flex justify-center pt-4">
                        <a href="{{ route('register') }}" class="rounded-full bg-white px-12 py-5 text-xl font-black text-kosera-600 shadow-xl transition-all hover:bg-slate-50 hover:scale-105 active:scale-95">
                            Daftar Mitra Sekarang
                        </a>
                    </div>
                </div>
                <!-- Decorations -->
                <div class="absolute -right-24 -top-24 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-black/10 blur-3xl"></div>
            </div>
        </section>
    </main>

    <footer class="border-t border-slate-100 py-12 text-center text-slate-400">
        <p class="text-sm font-medium">&copy; 2024 KOSERA. All rights reserved.</p>
    </footer>
</body>
</html>
