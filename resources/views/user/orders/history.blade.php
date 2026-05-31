@php
    $pageTitle = 'Riwayat Pesanan - KOSERA';
@endphp

<x-layout.user-sidebar :pageTitle="$pageTitle" :bgColor="'#f4faff'" mainClass="max-w-4xl mx-auto p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Riwayat Pesanan</h1>
        <p class="text-slate-500 mt-2">Kelola pesanan dan lacak status layanan Anda</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="rounded-lg bg-white p-4 shadow-sm border border-slate-100">
            <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-1">Total Pesanan</p>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['total'] }}</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow-sm border border-slate-100">
            <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-1">Selesai</p>
            <p class="text-2xl font-bold text-green-600">{{ $stats['completed'] }}</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow-sm border border-slate-100">
            <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-1">Tertunda</p>
            <p class="text-2xl font-bold text-yellow-600">{{ $stats['pending'] }}</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow-sm border border-slate-100">
            <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-1">Total Belanja</p>
            <p class="text-2xl font-bold text-[#0073a5]">
                Rp {{ number_format($stats['total_spent'], 0) }}
            </p>
        </div>
    </div>

    <!-- Filter -->
    <div class="mb-6">
        <form method="GET" action="{{ route('user.orders.history') }}" class="flex gap-3">
            <select name="status" class="px-4 py-2 rounded-lg border border-slate-200 bg-white text-sm focus:border-[#0073a5] focus:ring-2 focus:ring-[#0073a5]/20 outline-none transition">
                <option value="all" @if($filters['status'] === 'all') selected @endif>Semua Status</option>
                <option value="pending" @if($filters['status'] === 'pending') selected @endif>Tertunda</option>
                <option value="completed" @if($filters['status'] === 'completed') selected @endif>Selesai</option>
                <option value="cancelled" @if($filters['status'] === 'cancelled') selected @endif>Dibatalkan</option>
            </select>
            <button type="submit" class="px-4 py-2 rounded-lg bg-[#0073a5] text-white text-sm font-semibold hover:bg-[#005981] transition">
                Filter
            </button>
        </form>
    </div>

    <!-- Orders List -->
    @if($orders->count())
        <div class="space-y-4">
            @forelse($orders as $order)
                <div class="rounded-lg border border-slate-100 bg-white p-5 shadow-sm hover:shadow-md transition">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-start">
                        <!-- Service Info -->
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-1">Layanan</p>
                            <p class="font-bold text-slate-900">{{ $order->service->nama_layanan }}</p>
                            <p class="text-sm text-slate-500 mt-1">{{ $order->service->kategori }}</p>
                            <p class="text-xs text-slate-500 mt-2">Penyedia: <span class="font-semibold text-slate-900">{{ $order->service->user->nama }}</span></p>
                        </div>

                        <!-- Price -->
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-1">Harga</p>
                            <p class="text-xl font-bold text-[#0073a5]">Rp {{ number_format($order->total_harga, 0) }}</p>
                        </div>

                        <!-- Status -->
                        <div>
                            <p class="text-xs text-slate-500 uppercase font-bold tracking-wide mb-1">Status</p>
                            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
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

                        <!-- Actions -->
                        <div class="flex flex-col gap-2">
                            <a href="{{ route('user.orders.show', $order->id) }}" 
                                class="inline-block px-4 py-2 rounded-lg bg-[#0073a5] text-white text-center text-sm font-semibold hover:bg-[#005981] transition">
                                Lihat Detail
                            </a>
                            @if($order->status === 'pending')
                                <form method="POST" action="{{ route('user.orders.cancel', $order->id) }}" onsubmit="return confirm('Batalkan pesanan ini?')">
                                    @csrf
                                    <button type="submit" class="w-full px-4 py-2 rounded-lg border border-red-300 text-red-600 text-center text-sm font-semibold hover:bg-red-50 transition">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-lg border border-dashed border-slate-200 bg-slate-50 p-12 text-center">
                    <svg class="h-16 w-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                    </svg>
                    <p class="text-slate-600 font-semibold">Belum ada pesanan</p>
                    <p class="text-slate-500 text-sm mt-1">Mulai dengan menjelajahi layanan kami</p>
                    <a href="{{ route('user.services.index') }}" class="inline-block mt-4 px-6 py-2 rounded-lg bg-[#0073a5] text-white text-sm font-semibold hover:bg-[#005981] transition">
                        Cari Layanan
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="mt-8 flex justify-center gap-2">
                {{ $orders->links() }}
            </div>
        @endif
    @else
        <div class="rounded-lg border border-dashed border-slate-200 bg-slate-50 p-12 text-center">
            <svg class="h-16 w-16 mx-auto text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <p class="text-slate-600 font-semibold">Belum ada pesanan</p>
            <p class="text-slate-500 text-sm mt-1">Mulai dengan menjelajahi layanan kami</p>
            <a href="{{ route('user.services.index') }}" class="inline-block mt-4 px-6 py-2 rounded-lg bg-[#0073a5] text-white text-sm font-semibold hover:bg-[#005981] transition">
                Cari Layanan
            </a>
        </div>
    @endif
</x-layout.user-sidebar>
