@php
    $pageTitle = 'Detail Pesanan #' . $order->order_code . ' - KOSERA';

    $status = $order->status ?? 'pending';
    $isPaid = data_get($order, 'payment_status') === 'paid' || in_array($status, ['processing', 'completed'], true);
    $isProcessing = in_array($status, ['processing', 'completed'], true);
    $isCompleted = $status === 'completed';

    $steps = [
        ['label' => 'Pesanan dibuat', 'done' => true],
        ['label' => 'Pembayaran diterima', 'done' => $isPaid],
        ['label' => 'Pesanan diproses', 'done' => $isProcessing],
        ['label' => 'Pesanan selesai', 'done' => $isCompleted],
    ];

    $statusLabel = match ($status) {
        'completed' => 'Selesai',
        'processing' => 'Diproses',
        'cancelled' => 'Dibatalkan',
        default => 'Menunggu',
    };

    $statusClass = match ($status) {
        'completed' => 'bg-emerald-100 text-emerald-700 ring-1 ring-emerald-200',
        'processing' => 'bg-sky-100 text-sky-700 ring-1 ring-sky-200',
        'cancelled' => 'bg-rose-100 text-rose-700 ring-1 ring-rose-200',
        default => 'bg-amber-100 text-amber-700 ring-1 ring-amber-200',
    };
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pageTitle }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top,_#e0f2fe_0,_#f8fbff_38%,_#eef6fb_100%)] text-slate-900">
    <div class="mx-auto flex min-h-screen max-w-6xl flex-col px-4 py-5 sm:px-6 lg:px-8">
        <header class="mb-6 flex items-center justify-between rounded-3xl border border-white/70 bg-white/85 px-5 py-4 shadow-sm backdrop-blur">
            <div class="flex items-center gap-4">
                <a href="{{ route('user.payment.success') }}" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-sky-100 bg-sky-50 text-[#0073a5] transition hover:bg-sky-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#005981]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                </a>
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-sky-600">Kosera</p>
                    <h1 class="text-lg font-extrabold text-slate-900 sm:text-xl">Detail Pesanan</h1>
                </div>
            </div>
            <a href="{{ route('user.orders.history') }}" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:border-sky-200 hover:text-[#0073a5]">
                Riwayat
            </a>
        </header>

        <main class="grid flex-1 gap-6 lg:grid-cols-[1.6fr_0.9fr]">
            <section class="space-y-6">
                <div class="overflow-hidden rounded-[2rem] border border-white/70 bg-white shadow-sm">
                    <div class="border-b border-slate-100 bg-gradient-to-r from-sky-50 to-white px-6 py-6 sm:px-8">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Nomor Pesanan</p>
                                <h2 class="mt-2 text-2xl font-black tracking-tight text-slate-900">#{{ $order->order_code }}</h2>
                                <p class="mt-2 text-sm text-slate-500">Dibuat pada {{ optional($order->created_at)->format('d M Y, H:i') }}</p>
                            </div>
                            <span class="inline-flex items-center rounded-full px-4 py-2 text-sm font-bold {{ $statusClass }}">
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>

                    <div class="grid gap-4 px-6 py-6 sm:px-8 md:grid-cols-2">
                        <div class="rounded-2xl border border-slate-100 bg-slate-50/70 p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Layanan</p>
                            <h3 class="mt-2 text-lg font-bold text-slate-900">{{ $order->service->nama_layanan ?? '-' }}</h3>
                            <p class="mt-1 text-sm text-slate-500">{{ $order->service->kategori ?? 'Kategori tidak tersedia' }}</p>
                            <div class="mt-4 flex items-center justify-between gap-3">
                                <span class="text-sm text-slate-500">Estimasi</span>
                                <span class="font-semibold text-slate-800">{{ $order->service->durasi_estimasi ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-100 bg-slate-50/70 p-5">
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Total Pembayaran</p>
                            <h3 class="mt-2 text-3xl font-black tracking-tight text-[#0073a5]">Rp {{ number_format((float) ($order->total_harga ?? 0), 0, ',', '.') }}</h3>
                            <p class="mt-2 text-sm text-slate-500">Metode: {{ data_get($order, 'payment_method', 'Belum tersedia') }}</p>
                            <div class="mt-4 flex items-center justify-between gap-3">
                                <span class="text-sm text-slate-500">Status bayar</span>
                                <span class="font-semibold {{ $isPaid ? 'text-emerald-600' : 'text-amber-600' }}">{{ $isPaid ? 'Diterima' : 'Menunggu' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-white/70 bg-white p-6 shadow-sm sm:p-8">
                    <div class="mb-6 flex items-center justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Progress</p>
                            <h3 class="mt-2 text-xl font-extrabold text-slate-900">Status Pesanan</h3>
                        </div>
                        <span class="text-sm font-semibold text-slate-500">Sederhana, jelas, langsung ke inti</span>
                    </div>

                    <div class="space-y-4">
                        @foreach ($steps as $index => $step)
                            <div class="flex items-start gap-4">
                                <div class="mt-0.5 flex h-10 w-10 shrink-0 items-center justify-center rounded-full {{ $step['done'] ? 'bg-[#0073a5] text-white' : 'bg-slate-100 text-slate-400' }}">
                                    @if ($step['done'])
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                                        </svg>
                                    @else
                                        <span class="text-sm font-bold">{{ $index + 1 }}</span>
                                    @endif
                                </div>
                                <div class="flex-1 pb-4 {{ !$loop->last ? 'border-b border-slate-100' : '' }}">
                                    <p class="font-semibold text-slate-900">{{ $step['label'] }}</p>
                                    <p class="mt-1 text-sm text-slate-500">
                                        @if ($step['done'])
                                            Sudah tercatat.
                                        @else
                                            Masih menunggu tahap sebelumnya.
                                        @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <aside class="space-y-6">
                <div class="rounded-[2rem] border border-white/70 bg-white p-6 shadow-sm">
                    <h3 class="text-lg font-extrabold text-slate-900">Rincian Pesanan</h3>
                    <div class="mt-5 space-y-4 text-sm">
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-slate-500">Nama pelanggan</span>
                            <span class="font-semibold text-slate-900 text-right">{{ $order->customer_name ?? '-' }}</span>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-slate-500">Telepon</span>
                            <span class="font-semibold text-slate-900 text-right">{{ $order->customer_phone ?? '-' }}</span>
                        </div>
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-slate-500">Email</span>
                            <span class="font-semibold text-slate-900 text-right">{{ $order->customer_email ?? '-' }}</span>
                        </div>
                        <div class="pt-2">
                            <p class="text-slate-500">Alamat</p>
                            <p class="mt-1 font-semibold leading-relaxed text-slate-900">{{ $order->alamat_lengkap ?? '-' }}</p>
                        </div>
                        @if (!empty($order->catatan_customer))
                            <div class="pt-2">
                                <p class="text-slate-500">Catatan</p>
                                <p class="mt-1 leading-relaxed text-slate-700">{{ $order->catatan_customer }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="rounded-[2rem] border border-white/70 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-sky-50 text-2xl font-black text-[#0073a5]">
                            {{ strtoupper(substr(data_get($order, 'service.user.nama', 'K'), 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-[0.18em] text-slate-400">Mitra</p>
                            <h3 class="mt-1 text-lg font-bold text-slate-900">{{ data_get($order, 'service.user.nama', 'Mitra Kosera') }}</h3>
                            <p class="text-sm text-slate-500">{{ data_get($order, 'service.user.location', 'Lokasi belum tersedia') }}</p>
                        </div>
                    </div>

                    <div class="mt-5 space-y-3 text-sm">
                        <div class="flex items-center justify-between gap-3 rounded-2xl bg-slate-50 px-4 py-3">
                            <span class="text-slate-500">Telepon</span>
                            <a href="tel:{{ data_get($order, 'service.user.phone') }}" class="font-semibold text-[#0073a5]">{{ data_get($order, 'service.user.phone', '-') }}</a>
                        </div>
                        <div class="rounded-2xl border border-sky-100 bg-sky-50 px-4 py-4 text-sm leading-relaxed text-sky-900">
                            Tim mitra akan memproses pesanan sesuai status terakhir di atas.
                        </div>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-200 bg-slate-900 p-6 text-white shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-400">Aksi cepat</p>
                    <h3 class="mt-2 text-xl font-extrabold">Selesai lihat detail?</h3>
                    <p class="mt-2 text-sm leading-relaxed text-slate-300">Kembali ke riwayat untuk cek pesanan lain, atau lanjut ke dashboard.</p>
                    <div class="mt-5 flex flex-col gap-3">
                        <a href="{{ route('user.orders.history') }}" class="inline-flex items-center justify-center rounded-2xl bg-white px-4 py-3 font-bold text-slate-900 transition hover:bg-slate-100">
                            Ke Riwayat
                        </a>
                        <a href="{{ route('user.dashboard') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/20 px-4 py-3 font-bold text-white transition hover:bg-white/10">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </div>
            </aside>
        </main>
    </div>
</body>
</html>
