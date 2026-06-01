@extends('layouts.user')

@section('content')
<!-- Kebersihan Section -->
<div class="flex flex-col self-stretch gap-6">
    <div class="flex justify-between items-start self-stretch">
        <div class="flex flex-col shrink-0 items-center">
            <div class="flex flex-col items-start pr-[251px]">
                <span class="text-[#191C1E] text-[32px] font-bold">Kebersihan</span>
            </div>
            <div class="flex flex-col items-center">
                <span class="text-[#434656] text-base">Ahli kebersihan kamar dan perawatan pakaian pilihan.</span>
            </div>
        </div>
        <a href="{{ route('login') }}" class="mt-12 inline-flex shrink-0 items-center gap-1.5 rounded-lg px-2 py-1 text-[#006A9A] text-xs font-bold transition-colors hover:bg-[#EFF1F9] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006A9A]">
            <span>Lihat Semua</span>
            <img src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/bar9k6gb_expires_30_days.png" class="w-1 h-2 object-fill" />
        </a>
    </div>
    <div class="flex items-center self-stretch gap-6">
        <!-- Card 1 -->
        <div class="flex flex-1 flex-col bg-white p-[25px] gap-4 rounded-lg border border-solid border-[#C3C5D9]">
            <div class="flex items-start self-stretch gap-4">
                <img src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/tdrr4hca_expires_30_days.png" class="w-16 h-16 object-fill" />
                <div class="flex-1">
                    <div class="flex justify-between items-start self-stretch">
                        <span class="text-[#191C1E] text-xl font-bold">Clean & Fresh Solo</span>
                        <div class="flex shrink-0 items-center gap-[3px]">
                            <img src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/cc3l7hzw_expires_30_days.png" class="w-[13px] h-3 object-fill" />
                            <span class="text-[#006A9A] text-[11px] font-bold">4.9</span>
                        </div>
                    </div>
                    <span class="text-[#434656] text-xs text-left">Terverifikasi sejak 2021</span>
                </div>
            </div>
            <div class="flex flex-col self-stretch pb-2 gap-1 text-left">
                <span class="text-[#006A9A] text-[11px] font-bold uppercase tracking-wide">Layanan Tersedia</span>
                <div class="flex items-center self-stretch gap-2">
                    <span class="bg-[#ECEEF0] py-1 px-2 rounded-md text-[#434656] text-[11px] font-bold">Deep Cleaning</span>
                    <span class="bg-[#ECEEF0] py-1 px-2 rounded-md text-[#434656] text-[11px] font-bold">Cuci Kasur</span>
                    <span class="bg-[#ECEEF0] py-1 px-2 rounded-md text-[#434656] text-[11px] font-bold">Kamar Mandi</span>
                </div>
            </div>
            <div class="flex justify-between items-start self-stretch pt-[17px]">
                <div class="flex flex-col text-left">
                    <span class="text-[#434656] text-[11px] font-bold">Mulai dari</span>
                    <span class="text-[#006A9A] text-base font-bold">Rp 45.000</span>
                </div>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded bg-[#006A9A] px-4 py-2 text-xs font-bold text-white transition-colors hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006A9A]">Pesan Jasa</a>
            </div>
        </div>
        <!-- Card 2 -->
        <div class="flex flex-1 flex-col bg-white p-[25px] gap-4 rounded-lg border border-solid border-[#C3C5D9]">
            <div class="flex items-start self-stretch gap-[15px]">
                <img src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/c8c1pxfi_expires_30_days.png" class="w-16 h-16 object-fill" />
                <div class="flex-1">
                    <div class="flex justify-between items-start self-stretch">
                        <span class="text-[#191C1E] text-xl font-bold">Laundry Express 88</span>
                        <div class="flex shrink-0 items-center gap-[3px]">
                            <img src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/2lzzewod_expires_30_days.png" class="w-[13px] h-3 object-fill" />
                            <span class="text-[#006A9A] text-[11px] font-bold">4.8</span>
                        </div>
                    </div>
                    <p class="text-[#434656] text-xs text-left">Populer di area sekitar kampus</p>
                </div>
            </div>
            <div class="flex flex-col self-stretch pb-2 gap-1 text-left">
                <span class="text-[#006A9A] text-[11px] font-bold uppercase tracking-wide">Layanan Tersedia</span>
                <div class="flex items-center self-stretch gap-2">
                    <span class="bg-[#ECEEF0] py-1 px-2 rounded-md text-[#434656] text-[11px] font-bold">Kiloan Premium</span>
                    <span class="bg-[#ECEEF0] py-1 px-2 rounded-md text-[#434656] text-[11px] font-bold">Cuci Sepatu</span>
                    <span class="bg-[#ECEEF0] py-1 px-2 rounded-md text-[#434656] text-[11px] font-bold">Satuan</span>
                </div>
            </div>
            <div class="flex justify-between items-start self-stretch pt-[17px]">
                <div class="flex flex-col text-left">
                    <span class="text-[#434656] text-[11px] font-bold">Mulai dari</span>
                    <span class="text-[#006A9A] text-base font-bold">Rp 8.000/kg</span>
                </div>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded bg-[#006A9A] px-4 py-2 text-xs font-bold text-white transition-colors hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006A9A]">Pesan Jasa</a>
            </div>
        </div>
        <!-- Card 3 -->
        <div class="flex flex-1 flex-col bg-white p-[25px] gap-4 rounded-lg border border-solid border-[#C3C5D9]">
            <div class="flex items-start self-stretch gap-[15px]">
                <img src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/5dkcjc25_expires_30_days.png" class="w-16 h-16 object-fill" />
                <div class="flex-1">
                    <div class="flex justify-between items-start self-stretch">
                        <span class="text-[#191C1E] text-xl font-bold text-left">Pak Budi General Help</span>
                        <div class="flex shrink-0 items-center gap-1">
                            <img src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/8nznma75_expires_30_days.png" class="w-[13px] h-3 object-fill" />
                            <span class="text-[#006A9A] text-[11px] font-bold">5.0</span>
                        </div>
                    </div>
                    <span class="text-[#434656] text-xs block text-left">Spesialis Kos-kosan</span>
                </div>
            </div>
            <div class="flex flex-col self-stretch pb-2 gap-1 text-left">
                <span class="text-[#006A9A] text-[11px] font-bold uppercase tracking-wide">Layanan Tersedia</span>
                <div class="flex items-center self-stretch gap-2">
                    <span class="bg-[#ECEEF0] py-1 px-2 rounded-md text-[#434656] text-[11px] font-bold">Bereskan Kamar</span>
                    <span class="bg-[#ECEEF0] py-1 px-2 rounded-md text-[#434656] text-[11px] font-bold">Angkut Barang</span>
                    <span class="bg-[#ECEEF0] py-1 px-2 rounded-md text-[#434656] text-[11px] font-bold">Cat Ulang</span>
                </div>
            </div>
            <div class="flex justify-between items-start self-stretch pt-[17px]">
                <div class="flex flex-col text-left">
                    <span class="text-[#434656] text-[11px] font-bold">Mulai dari</span>
                    <span class="text-[#006A9A] text-base font-bold">Rp 60.000</span>
                </div>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded bg-[#006A9A] px-4 py-2 text-xs font-bold text-white transition-colors hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006A9A]">Pesan Jasa</a>
            </div>
        </div>
    </div>
</div>

<!-- Teknisi Section -->
<div class="flex flex-col self-stretch gap-6">
    <div class="flex justify-between items-start self-stretch">
        <div class="flex flex-col shrink-0 items-center">
            <div class="flex flex-col items-start pr-[140px]">
                <span class="text-[#191C1E] text-[32px] font-bold">Teknisi dan Perbaikan</span>
            </div>
            <div class="flex flex-col items-center">
                <span class="text-[#434656] text-base">Solusi untuk peralatan elektronik dan AC yang bermasalah.</span>
            </div>
        </div>
        <a href="{{ route('login') }}" class="mt-12 inline-flex shrink-0 items-center gap-1.5 rounded-lg px-2 py-1 text-[#006A9A] text-xs font-bold transition-colors hover:bg-[#EFF1F9] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006A9A]">
            <span>Lihat Semua</span>
            <img src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/0ouw7ikk_expires_30_days.png" class="w-1 h-2 object-fill" />
        </a>
    </div>
    <div class="flex items-center self-stretch gap-6">
        <!-- Card 1 Teknisi -->
        <div class="flex flex-1 flex-col bg-white p-[25px] gap-4 rounded-lg border border-solid border-[#C3C5D9]">
            <div class="flex items-start self-stretch gap-4">
                <img src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/f6dky247_expires_30_days.png" class="w-16 h-16 object-fill" />
                <div class="flex-1">
                    <div class="flex justify-between items-start self-stretch">
                        <span class="text-[#191C1E] text-xl font-bold">Sejuk Teknik AC</span>
                        <div class="flex shrink-0 items-center gap-[3px]">
                            <img src="https://storage.googleapis.com/tagjs-prod.appspot.com/v1/Kx2XDVWPKH/jsk6t72g_expires_30_days.png" class="w-[13px] h-3 object-fill" />
                            <span class="text-[#006A9A] text-[11px] font-bold">4.7</span>
                        </div>
                    </div>
                    <span class="text-[#434656] text-xs block text-left">Spesialis Cuci AC & Isi Freon</span>
                </div>
            </div>
            <div class="flex flex-col self-stretch pb-2 gap-1 text-left">
                <span class="text-[#006A9A] text-[11px] font-bold uppercase tracking-wide">Layanan Tersedia</span>
                <div class="flex items-center self-stretch gap-2">
                    <span class="bg-[#ECEEF0] py-1 px-2 rounded-md text-[#434656] text-[11px] font-bold">Cuci AC</span>
                    <span class="bg-[#ECEEF0] py-1 px-2 rounded-md text-[#434656] text-[11px] font-bold">Bongkar Pasang</span>
                </div>
            </div>
            <div class="flex justify-between items-start self-stretch pt-[17px]">
                <div class="flex flex-col text-left">
                    <span class="text-[#434656] text-[11px] font-bold">Mulai dari</span>
                    <span class="text-[#006A9A] text-base font-bold">Rp 75.000</span>
                </div>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded bg-[#006A9A] px-4 py-2 text-xs font-bold text-white transition-colors hover:opacity-90 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006A9A]">Pesan Jasa</a>
            </div>
        </div>
        <!-- Card 2 & 3 bisa ditambahkan di sini mengikuti pola yang sama -->
    </div>
</div>

<!-- Jadilah Mitra KOSERA Section -->
<div class="flex flex-col self-stretch mt-12">
    <div class="bg-[#1E8593] rounded-[40px] p-12 md:p-16 overflow-hidden relative shadow-xl">
        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-12 text-left">
            <div class="md:w-3/5">
                <h2 class="text-[48px] font-extrabold text-white mb-6 leading-tight">Jadilah Mitra KOSERA</h2>
                <p class="text-blue-50 text-[18px] font-medium leading-relaxed mb-10">
                    Dapatkan penghasilan tambahan dan kembangkan jasa profesional Anda bersama komunitas anak kos terbaik di Indonesia. Kami membantu Anda menjangkau ribuan pelanggan setiap harinya.
                </p>
                <div class="flex flex-col sm:flex-row items-center gap-8">
                    <a href="{{ route('register') }}" class="bg-white text-[#1E8593] hover:bg-gray-50 px-10 py-4 rounded-full font-bold text-[16px] transition-all transform hover:scale-[1.02] shadow-lg no-underline">
                        Daftar Sekarang
                    </a>
                    <a href="/admin" class="text-white font-bold hover:underline text-[16px] flex items-center gap-2 no-underline">
                        Pelajari lebih lanjut
                    </a>
                </div>
            </div>
            <div class="md:w-2/5 flex justify-center">
                <div class="w-64 h-64 bg-white/10 backdrop-blur-xl rounded-3xl flex items-center justify-center p-12 border border-white/20 transform rotate-6 hover:rotate-0 transition-transform duration-700">
                    <svg class="h-full w-full text-white/90" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"></path>
                    </svg>
                </div>
            </div>
        </div>
        <div class="absolute -top-16 -right-16 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
    </div>
</div>
@endsection