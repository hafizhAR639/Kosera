@extends('layouts.mitra')

@section('content')
<section class="max-w-7xl mx-auto space-y-12 py-6">
    <!-- Header Section -->
    <header class="text-center space-y-4">
        <h1 class="text-4xl font-black text-slate-900 tracking-tight">Halo, Mitra Kosera!</h1>
        <p class="text-lg text-slate-500 font-medium max-w-2xl mx-auto">Selamat datang kembali. Pantau ringkasan performa layanan dan pendapatan Anda secara real-time di sini.</p>
        <div class="flex justify-center pt-2">
            <span class="inline-flex items-center gap-2 text-sm font-bold text-[#006b9b] bg-white px-6 py-2.5 rounded-2xl shadow-sm border border-slate-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                {{ now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </header>

    <!-- Stat Cards Grid -->
    <div class="grid gap-8 md:grid-cols-2">
        <!-- Monthly Orders Card -->
        <div class="group relative overflow-hidden rounded-[40px] bg-white p-10 shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:-translate-y-1">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <div class="h-16 w-16 rounded-[24px] bg-blue-50 flex items-center justify-center text-blue-600 transition-transform group-hover:scale-110">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path></svg>
                    </div>
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Statistik Utama</span>
                </div>
                <h3 class="text-lg font-bold text-slate-500 mb-1">Pesanan Baru</h3>
                <p class="text-6xl font-black text-slate-900 tracking-tighter">{{ $stats['monthly_orders'] ?? 0 }}</p>
                <div class="mt-6 flex items-center gap-2">
                    <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-bold text-blue-700">Terverifikasi</span>
                    <span class="text-xs font-bold text-slate-400">Total pesanan bulan ini</span>
                </div>
            </div>
            <!-- Background Decoration -->
            <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-blue-50/50 blur-3xl transition-opacity group-hover:opacity-100 opacity-0"></div>
        </div>

        <!-- Total Revenue Card -> Link to Earnings -->
        <a href="{{ route('mitra.earnings') }}" class="group relative overflow-hidden rounded-[40px] bg-[#006b9b] p-10 shadow-2xl shadow-[#006b9b]/30 transition-all hover:scale-[1.02] active:scale-95">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <div class="h-16 w-16 rounded-[24px] bg-white/20 flex items-center justify-center text-white transition-transform group-hover:scale-110">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 1.343-3 3v4m6 0v-4c0-1.657-1.343-3-3-3zM12 2a10 10 0 100 20 10 10 0 000-20z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path></svg>
                    </div>
                    <svg class="w-6 h-6 text-white/50 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 5l7 7m0 0l-7 7m7-7H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-white/80 mb-1">Total Pendapatan</h3>
                <p class="text-5xl font-black text-white tracking-tighter">{{ \App\Helpers\FormatHelper::rupiah($stats['total_income'] ?? 0) }}</p>
                <p class="mt-6 text-sm font-bold text-white/60">Klik untuk melihat detail grafik & statistik</p>
            </div>
            <!-- Background Decoration -->
            <div class="absolute -right-12 -bottom-12 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
        </a>

        <!-- Active Services Card -> Link to Services -->
        <a href="{{ route('mitra.layanan.index') }}" class="group relative overflow-hidden rounded-[40px] bg-white p-10 shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:-translate-y-1">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <div class="h-16 w-16 rounded-[24px] bg-emerald-50 flex items-center justify-center text-emerald-600 transition-transform group-hover:scale-110">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path></svg>
                    </div>
                    <span class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">Manajemen</span>
                </div>
                <h3 class="text-lg font-bold text-slate-500 mb-1">Layanan Aktif</h3>
                <p class="text-6xl font-black text-slate-900 tracking-tighter">{{ $stats['services_count'] ?? 0 }}</p>
                <p class="mt-6 text-sm font-bold text-emerald-600 group-hover:underline flex items-center gap-2">
                    Kelola Semua Layanan <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path></svg>
                </p>
            </div>
            <!-- Background Decoration -->
            <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-emerald-50/50 blur-3xl transition-opacity group-hover:opacity-100 opacity-0"></div>
        </a>

        <!-- Reputation Card -->
        <div class="group relative overflow-hidden rounded-[40px] bg-white p-10 shadow-sm border border-slate-100 transition-all hover:shadow-xl hover:-translate-y-1">
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-8">
                    <div class="h-16 w-16 rounded-[24px] bg-amber-50 flex items-center justify-center text-amber-600 transition-transform group-hover:scale-110">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"></path></svg>
                    </div>
                    <div class="flex text-amber-400 text-sm">★★★★★</div>
                </div>
                <h3 class="text-lg font-bold text-slate-500 mb-1">Poin Reputasi</h3>
                <p class="text-6xl font-black text-slate-900 tracking-tighter">{{ $stats['points'] ?? 0 }}</p>
                <div class="mt-6">
                    <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                        <div class="bg-amber-400 h-full rounded-full" style="width: 85%"></div>
                    </div>
                    <p class="mt-3 text-xs font-bold text-slate-400">Terus pertahankan kualitas layanan Anda!</p>
                </div>
            </div>
            <!-- Background Decoration -->
            <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full bg-amber-50/50 blur-3xl transition-opacity group-hover:opacity-100 opacity-0"></div>
        </div>
    </div>

    <!-- Quick Info Banner -->
    <!-- <div class="rounded-[40px] bg-gradient-to-br from-slate-800 to-slate-900 p-12 text-white relative overflow-hidden shadow-2xl">
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-4">
                <h2 class="text-3xl font-black">Butuh Bantuan?</h2>
                <p class="text-slate-400 font-medium text-lg">Hubungi tim support Kosera jika Anda menemui kendala dalam mengelola pesanan.</p>
                <div class="flex gap-4 pt-2">
                    <button class="rounded-2xl bg-[#006b9b] px-8 py-3 font-bold hover:bg-[#00557b] transition-colors shadow-lg shadow-[#006b9b]/20">Hubungi Support</button>
                    <button class="rounded-2xl bg-white/10 px-8 py-3 font-bold hover:bg-white/20 transition-colors backdrop-blur-sm">Pusat Bantuan</button>
                </div>
            </div>
            <div class="hidden lg:block">
                <div class="w-48 h-48 bg-white/5 rounded-full border border-white/10 flex items-center justify-center backdrop-blur-xl rotate-12">
                    <svg class="w-24 h-24 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path></svg>
                </div>
            </div>
        </div>
        <!-- Background Decorations -->
        <div class="absolute -right-24 -bottom-24 h-96 w-96 rounded-full bg-[#006b9b]/10 blur-3xl"></div>
        <div class="absolute -left-24 -top-24 h-96 w-96 rounded-full bg-white/5 blur-3xl"></div>
    </div> -->
</section>
@endsection
