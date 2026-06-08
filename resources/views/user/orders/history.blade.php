@php
    $pageTitle = 'Riwayat Pesanan - KOSERA';
@endphp

<x-layout.user-sidebar :pageTitle="$pageTitle" :bgColor="'#f4faff'" mainClass="max-w-5xl mx-auto p-6 md:p-8 space-y-8">
    <!-- Header Section -->
    <div class="mt-10">
        <h1 class="text-4xl font-bold text-[#141d21]">Riwayat Pesanan</h1>
        <p class="mt-2 text-sm text-[#40484f]">Pantau status dan kelola semua pesanan layanan Anda di satu tempat.</p>
    </div>


    <!-- Tabs Filter -->
    <div class="border-b border-[#bfc7d0]/30">
        <div class="flex gap-8">
            <a href="{{ route('user.orders.history', ['status' => 'all']) }}" 
               class="pb-4 text-sm font-bold transition-all relative {{ ($filters['status'] ?? 'all') === 'all' ? 'text-[#006b9b]' : 'text-[#40484f] hover:text-[#006b9b]' }}">
                Semua
                @if(($filters['status'] ?? 'all') === 'all')
                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-[#006b9b]"></div>
                @endif
            </a>
            <a href="{{ route('user.orders.history', ['status' => 'berlangsung']) }}" 
               class="pb-4 text-sm font-bold transition-all relative {{ ($filters['status'] ?? '') === 'berlangsung' ? 'text-[#006b9b]' : 'text-[#40484f] hover:text-[#006b9b]' }}">
                Berlangsung
                @if(($filters['status'] ?? '') === 'berlangsung')
                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-[#006b9b]"></div>
                @endif
            </a>
            <a href="{{ route('user.orders.history', ['status' => 'completed']) }}" 
               class="pb-4 text-sm font-bold transition-all relative {{ ($filters['status'] ?? '') === 'completed' ? 'text-[#006b9b]' : 'text-[#40484f] hover:text-[#006b9b]' }}">
                Selesai
                @if(($filters['status'] ?? '') === 'completed')
                    <div class="absolute bottom-0 left-0 w-full h-0.5 bg-[#006b9b]"></div>
                @endif
            </a>
        </div>
    </div>

    <!-- Orders List -->
    <div class="space-y-4">
        @forelse($orders as $order)
            <article class="rounded-2xl border border-[#bfc7d0]/20 bg-white p-6 shadow-sm transition-all hover:border-[#006b9b]/30 hover:shadow-md">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <!-- Left: Service Info -->
                    <div class="flex gap-5 items-start">
                        <div class="w-16 h-16 rounded-xl bg-[#f4faff] flex items-center justify-center flex-shrink-0">
                            <svg class="w-8 h-8 text-[#006b9b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded bg-slate-100 text-slate-500">
                                    {{ $order->service->kategori }}
                                </span>
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded
                                    @if($order->status === 'completed') bg-emerald-50 text-emerald-600
                                    @elseif(in_array($order->status, ['pending', 'confirmed', 'in_progress'])) bg-amber-50 text-amber-600
                                    @elseif($order->status === 'cancelled') bg-red-50 text-red-600
                                    @else bg-slate-50 text-slate-600
                                    @endif
                                ">
                                    @if($order->status === 'pending') Menunggu Konfirmasi
                                    @elseif($order->status === 'confirmed') Diterima
                                    @elseif($order->status === 'in_progress') Sedang Dikerjakan
                                    @elseif($order->status === 'completed') Selesai
                                    @elseif($order->status === 'cancelled') Dibatalkan
                                    @else {{ ucfirst($order->status) }}
                                    @endif
                                </span>
                            </div>
                            <h3 class="text-xl font-bold text-[#141d21]">{{ $order->service->nama_layanan }}</h3>
                            <p class="text-sm text-[#40484f] mt-1">
                                Kode: <span class="font-semibold">{{ $order->order_code }}</span> • 
                                Mitra: <span class="font-semibold">{{ $order->service->user->nama }}</span>
                            </p>
                        </div>
                    </div>

                    <!-- Middle: Price & Date -->
                    <div class="flex lg:flex-col lg:items-end justify-between lg:justify-center border-t lg:border-t-0 pt-4 lg:pt-0 border-[#bfc7d0]/20">
                        <p class="text-xl font-black text-[#006b9b]">Rp {{ number_format($order->total_harga, 0) }}</p>
                        <p class="text-xs text-[#40484f] mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>

                    <!-- Right: Actions -->
                    <div class="flex gap-3">
                        <a href="{{ route('user.orders.show', $order->id) }}" 
                           class="flex-1 lg:flex-none px-6 py-2.5 rounded-xl border border-[#006b9b] text-[#006b9b] text-sm font-bold hover:bg-[#006b9b]/5 transition-colors text-center">
                            Detail
                        </a>
                        @if($order->status === 'pending')
                            <form method="POST" action="{{ route('user.orders.cancel', $order->id) }}" onsubmit="return confirm('Batalkan pesanan ini?')">
                                @csrf
                                <button type="submit" class="w-full px-6 py-2.5 rounded-xl bg-red-50 text-red-600 text-sm font-bold hover:bg-red-100 transition-colors">
                                    Batal
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-3xl border border-dashed border-[#bfc7d0]/40 bg-[#f4faff] p-16 text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-[#141d21]">Belum ada pesanan</h3>
                <p class="text-[#40484f] mt-2 max-w-xs mx-auto text-sm">Anda belum memiliki riwayat pesanan dengan status ini. Mulai cari layanan sekarang!</p>
                <a href="{{ route('user.dashboard') }}" class="inline-block mt-8 px-8 py-3 rounded-xl bg-[#006b9b] text-white font-bold hover:bg-[#00557b] transition-colors shadow-lg shadow-[#006b9b]/20">
                    Cari Layanan
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($orders->hasPages())
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</x-layout.user-sidebar>
