<x-layout.user-sidebar :pageTitle="'Pembayaran Berhasil - KOSERA'" :bgColor="'#e0f2fe'" mainClass="flex items-center justify-center p-6">
    <div class="w-full max-w-[600px]">
        <!-- Success Header -->
        <div class="mb-6 flex flex-col items-center rounded-3xl bg-white p-10 text-center shadow-sm">
            <div class="mb-6 rounded-2xl bg-[#006a94] p-6">
                <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                    <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </div>
            <h1 class="mb-4 text-3xl font-extrabold text-[#006a94]">Pembayaran Berhasil!</h1>
            <p class="max-w-sm text-lg leading-relaxed text-slate-500">Pesanan Anda telah diterima dan sedang diproses oleh mitra kami.</p>
        </div>

        <!-- Details Grid -->
        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-2">
            <!-- Transaction -->
            <div class="flex flex-col rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-center gap-2 text-[#006a94]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    <h2 class="text-lg font-bold text-black">Detail Transaksi</h2>
                </div>
                <div class="flex-grow space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-xs font-medium uppercase tracking-tight text-slate-400">ORDER ID</span>
                        <span class="font-bold text-slate-800">{{ data_get($order, 'order_code', '#KSR-82931102') }}</span>
                    </div>
                    <div class="border-b border-slate-100 pb-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-xs font-medium uppercase tracking-tight text-slate-400">METODE</span>
                            <span class="font-medium text-slate-800">{{ data_get($order, 'payment_method', 'Gopay') }}</span>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="flex justify-between">
                            <span class="text-xs font-medium uppercase tracking-tight text-slate-400">TOTAL</span>
                            <span class="text-2xl font-bold text-[#0073a5]">Rp {{ number_format((float) data_get($order, 'total_harga', 38000), 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service -->
            <div class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-center gap-2 text-[#006a94]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    <h2 class="text-lg font-bold text-black">Layanan</h2>
                </div>
                <div class="flex gap-3">
                    <img alt="{{ data_get($order, 'service.nama_layanan', 'Layanan') }}" class="h-16 w-16 rounded-lg bg-slate-100 object-cover" src="{{ data_get($order, 'service.image_url', 'https://lh3.googleusercontent.com/aida-public/AB6AXuDYPSc2MCfrRVzwHhh5uVI0C6GtFx-hEYzPYEbwdAXj70M9ErFglOTlK-7LU70jBsp1SCy-iN8a32wlqQLTp_qMV49NOSF8v7iOAf90Yy-4Uy0WE3j5gS5Z3wdEcMkvQTHZa7qK_BJE06OHTAVfMLvUvTFvkEFgXnBwP7BGSxnCUOLgGqxkdk-ergxHmAv1NjCHlFlhiXaaaK09uQRuYeWjI8hWFrurzwqt0Fjzv7SxQkktCSbuyY-7DRoz2LAFxbZQPIWwjL_o7YQ') }}" />
                    <div class="flex flex-col justify-center">
                        <h3 class="text-sm font-bold text-black">{{ data_get($order, 'service.nama_layanan', 'Laundry Kiloan Premium') }}</h3>
                        <p class="mb-1 text-xs text-slate-500">{{ data_get($order, 'service.user.nama', 'Clean &amp; Fresh Solo') }}</p>
                        <div class="flex items-center gap-1 text-[#0073a5]">
                            <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            <span class="text-[10px] font-semibold">{{ data_get($order, 'service.durasi_estimasi', '24 Jam') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('user.dashboard') }}" class="flex w-full items-center justify-center gap-2 rounded-xl border border-sky-300 bg-[#dcf2fb] py-4 font-bold text-[#0073a5] transition-colors hover:bg-sky-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#0073a5]">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>

        <!-- Info -->
        <div class="flex gap-4 rounded-xl border border-sky-200 bg-[#dcf2fb] p-6">
            <div class="mt-1">
                <div class="rounded-full border border-sky-300 bg-white p-1">
                    <svg class="h-5 w-5 text-[#0073a5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </div>
            </div>
            <div>
                <p class="text-sm font-medium leading-relaxed text-[#005a7d]">Estimasi penjemputan 30 menit ke depan.</p>
                    <a class="mt-1 text-sm font-bold text-[#0073a5] underline underline-offset-4 transition hover:text-[#005981] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#005981]" href="{{ $order ? route('user.orders.detail', $order->id) : route('user.dashboard') }}">Lihat Detail</a>
            </div>
        </div>
    </div>
</x-layout.user-sidebar>
