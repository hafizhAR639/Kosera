@php
    $pageTitle = 'Detail Pesanan #' . $order->order_code . ' - KOSERA';
@endphp

<x-layout.user-sidebar :pageTitle="$pageTitle" :bgColor="'#f4faff'" mainClass="max-w-3xl mx-auto p-6">
    <!-- Back Button -->
    <a href="{{ route('user.orders.history') }}" class="inline-flex items-center gap-2 text-[#0073a5] hover:text-[#005981] transition font-semibold text-sm mb-6">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        Kembali ke Riwayat
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Order Header -->
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-4 mb-4">
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-1">Nomor Pesanan</p>
                        <h1 class="text-2xl font-bold text-slate-900">{{ $order->order_code }}</h1>
                    </div>
                    <span class="inline-block px-4 py-2 rounded-lg text-sm font-bold uppercase tracking-wide
                        @if($order->status === 'completed') bg-green-100 text-green-700
                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-700
                        @elseif($order->status === 'cancelled') bg-red-100 text-red-700
                        @else bg-slate-100 text-slate-700
                        @endif
                    ">
                        @if($order->status === 'completed') Selesai
                        @elseif($order->status === 'pending') Tertunda
                        @elseif($order->status === 'cancelled') Dibatalkan
                        @else {{ ucfirst($order->status) }}
                        @endif
                    </span>
                </div>
                <p class="text-sm text-slate-500">Tanggal Pesanan: {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}</p>
            </div>

            <!-- Service Info -->
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Informasi Layanan</h2>
                
                <div class="space-y-4">
                    <!-- Service Name -->
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-2">Layanan</p>
                        <p class="text-lg font-bold text-slate-900">{{ $order->service->nama_layanan }}</p>
                        <p class="text-sm text-slate-500 mt-1">{{ $order->service->kategori }}</p>
                    </div>

                    <!-- Service Details -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-2">Harga Layanan</p>
                            <p class="text-xl font-bold text-[#0073a5]">Rp {{ number_format($order->total_harga, 0) }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-2">Durasi Estimasi</p>
                            <p class="text-lg font-semibold text-slate-900">{{ $order->service->durasi_estimasi }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="rounded-2xl bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Informasi Pelanggan</h2>
                
                <div class="space-y-4">
                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-2">Nama</p>
                        <p class="text-base font-semibold text-slate-900">{{ $order->customer_name }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-2">Telepon</p>
                            <p class="text-base font-semibold text-slate-900">{{ $order->customer_phone }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-2">Email</p>
                            <p class="text-base font-semibold text-slate-900">{{ $order->customer_email }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-2">Alamat Pengiriman</p>
                        <p class="text-base font-semibold text-slate-900">{{ $order->alamat_lengkap }}</p>
                    </div>

                    @if($order->catatan_customer)
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-2">Catatan</p>
                            <p class="text-base text-slate-700">{{ $order->catatan_customer }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
            @if($order->status === 'pending')
                <div class="flex gap-3">
                    <form method="POST" action="{{ route('user.orders.cancel', $order->id) }}" class="flex-1" onsubmit="return confirm('Batalkan pesanan ini?')">
                        @csrf
                        <button type="submit" class="w-full px-4 py-3 rounded-lg border border-red-300 text-red-600 font-semibold hover:bg-red-50 transition">
                            Batalkan Pesanan
                        </button>
                    </form>
                </div>
            @endif
        </div>

        <!-- Sidebar - Provider Info -->
        <aside>
            <div class="rounded-2xl bg-white p-6 shadow-sm sticky top-20">
                <h3 class="text-xs font-bold uppercase tracking-wide text-slate-400 mb-4">Penyedia Layanan</h3>
                
                <!-- Provider Card -->
                <div class="text-center pb-6 border-b border-slate-100">
                    @if($order->service->user->avatar)
                        <img src="{{ $order->service->user->avatar }}" alt="{{ $order->service->user->nama }}" class="w-16 h-16 rounded-full mx-auto object-cover mb-3">
                    @else
                        <div class="w-16 h-16 rounded-full mx-auto mb-3 bg-[#0073a5]/10 flex items-center justify-center">
                            <span class="text-2xl font-bold text-[#0073a5]">{{ substr($order->service->user->nama, 0, 1) }}</span>
                        </div>
                    @endif
                    <h4 class="font-bold text-slate-900">{{ $order->service->user->nama }}</h4>
                    <p class="text-xs text-slate-500 mt-1">📍 {{ $order->service->user->location }}</p>
                </div>

                <!-- Contact Info -->
                <div class="py-6 space-y-3 border-b border-slate-100">
                    <a href="tel:{{ $order->service->user->phone }}" class="flex items-center gap-2 text-sm text-slate-600 hover:text-[#0073a5] transition">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        <span>{{ $order->service->user->phone }}</span>
                    </a>
                </div>

                <!-- Quick Info -->
                <div class="pt-6 space-y-3 text-xs text-slate-600">
                    <p class="flex items-start gap-2">
                        <svg class="h-4 w-4 text-[#0073a5] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                        <span>Terverifikasi</span>
                    </p>
                    <p class="flex items-start gap-2">
                        <svg class="h-4 w-4 text-[#0073a5] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                        <span>Responsif</span>
                    </p>
                    <p class="flex items-start gap-2">
                        <svg class="h-4 w-4 text-[#0073a5] flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                        <span>Garansi Kualitas</span>
                    </p>
                </div>
            </div>
        </aside>
    </div>
</x-layout.user-sidebar>
