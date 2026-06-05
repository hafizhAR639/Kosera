@php
    $pageTitle = 'Pembayaran Berhasil - KOSERA';
@endphp

<x-layout.user-sidebar :pageTitle="$pageTitle" :bgColor="'#f4faff'" mainClass="p-6 md:p-10">
    <div class="mx-auto w-full max-w-[700px] space-y-6">

        <!-- Success Header -->
        <div class="flex flex-col items-center gap-4 rounded-[32px] bg-white px-6 py-10 text-center shadow-sm">
            <div class="flex h-20 w-20 flex-shrink-0 items-center justify-center rounded-full bg-[#0073a5] text-white shadow-lg shadow-sky-200">
                <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>
            <h1 class="mt-2 text-3xl font-bold text-[#0073a5] sm:text-4xl">Pembayaran Berhasil!</h1>
            <p class="max-w-[460px] text-base text-slate-600">Terima kasih. Pesanan Anda sudah diterima dan segera diproses oleh mitra KOSERA.</p>
        </div>

        <!-- Details Grid -->
        <div class="grid gap-6 md:grid-cols-2">
            <!-- Transaction -->
            <div class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                <div class="mb-5 flex items-center gap-3 text-[#0073a5]">
                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-sky-50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">Detail Transaksi</h2>
                </div>
                <div class="space-y-4 text-slate-700">
                    <div class="flex justify-between text-sm">
                        <span class="font-bold uppercase tracking-wider text-slate-400">Order ID</span>
                        <span class="font-bold text-slate-900">{{ data_get($order, 'order_code', '#KSR-82931102') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="font-bold uppercase tracking-wider text-slate-400">Metode</span>
                        <span class="font-medium text-slate-900">{{ data_get($order, 'payment_method', 'Gopay') }}</span>
                    </div>
                    <hr class="border-slate-100" />
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold uppercase tracking-wider text-slate-400">Total</span>
                        <span class="text-2xl font-bold text-[#0073a5]">Rp {{ number_format((float) data_get($order, 'total_harga', 38000), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Service -->
            <div class="rounded-[32px] border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md">
                <div class="mb-5 flex items-center gap-3 text-[#0073a5]">
                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-sky-50">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    </div>
                    <h2 class="text-lg font-bold text-slate-900">Layanan</h2>
                </div>
            <!-- Bagian ini yang kita perbaiki agar tidak berantakan -->
                <div class="flex items-center gap-4">
                    <img alt="Layanan" class="h-20 w-20 flex-shrink-0 rounded-2xl object-cover" src="{{ data_get($order, 'service.image_url', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDYPSc2MCfrRVzwHhh5uVI0C6GtFx-hEYzPYEbwdAXj70M9ErFglOTlK-7LU70jBsp1SCy-iN8a32wlqQLTp_qMV49NOSF8v7iOAf90Yy-4Uy0WE3j5gS5Z3wdEcMkvQTHZa7qK_BJE06OHTAVfMLvUvTFvkEFgXnBwP7BGSxnCUOLgGqxkdk-ergxHmAv1NjCHlFlhiXaaaK09uQRuYeWjI8hWFrurzwqt0Fjzv7SxQkktCSbuyY-7DRoz2LAFxbZQPIWwjL_o7YQ') }}" />
                    
                    <div class="min-w-0 flex-1">
                        <h3 class="text-base font-bold text-slate-900 truncate">{{ data_get($order, 'service.nama_layanan', 'Service Ac') }}</h3>
                        <p class="text-sm text-slate-500 truncate">{{ data_get($order, 'service.user.nama', 'Mitra Kosera') }}</p>
                        <div class="mt-3 inline-flex items-center gap-1.5 rounded-full bg-sky-50 px-3 py-1 text-xs font-bold text-[#0073a5]">
                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            <span>{{ data_get($order, 'service.durasi_estimasi', '120') }} Menit</span>
                        </div>
                    </div>
                </div>
            </div>

        <!-- Back Button -->
        <div class="grid gap-4 sm:grid-cols-2">
            <a href="{{ route('user.orders.history') }}" class="flex items-center justify-center gap-2 rounded-[24px] bg-[#0073a5] px-6 py-4 text-sm font-bold text-white transition hover:-translate-y-1 hover:bg-[#005a82] hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#0073a5] focus:ring-offset-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <span>Lihat Riwayat Pesanan</span>
            </a>

            <a href="{{ route('user.dashboard') }}" class="flex items-center justify-center gap-2 rounded-[24px] border border-sky-200 bg-white px-6 py-4 text-sm font-bold text-[#0073a5] transition hover:-translate-y-1 hover:bg-sky-50 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#0073a5] focus:ring-offset-2">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                <span>Ke Profil Pengguna</span>
            </a>
        </div>

        <!-- Info -->
        <div class="flex items-start gap-4 rounded-[32px] border border-sky-100 bg-sky-50 p-6 sm:items-center">
            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-white text-[#0073a5] shadow-sm">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
            </div>
            <div>
                <p class="text-sm font-medium leading-relaxed text-slate-700">Estimasi penjemputan atau pengerjaan layanan dalam 30 menit ke depan.</p>
                <a class="mt-1 inline-block text-sm font-bold text-[#0073a5] underline-offset-4 hover:underline" href="{{ $order ? route('user.orders.detail', $order->id) : route('user.dashboard') }}">Lihat Detail</a>
            </div>
        </div>

    </div>
</x-layout.user-sidebar>