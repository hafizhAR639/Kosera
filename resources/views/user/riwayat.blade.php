@php
    $pageTitle = 'Riwayat Pesanan - KOSERA';
@endphp

<x-layout.user-sidebar :pageTitle="$pageTitle" :bgColor="'#f4faff'" mainClass="p-6 md:p-8 space-y-8">
    <section class="rounded-3xl border border-[#bfc7d0]/20 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#006b9b]">Riwayat</p>
                <h1 class="text-4xl font-bold text-[#141d21]">Riwayat Pesanan</h1>
                <p class="mt-2 text-sm text-[#40484f]">Pantau status layanan per pesanan tanpa sidebar ganda atau blok layout lama.</p>
            </div>
            <a href="{{ route('user.dashboard') }}" class="rounded-xl bg-[#006b9b] px-4 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#00557b]">Kembali ke Dashboard</a>
        </div>
    </section>

    <section class="rounded-3xl border border-[#bfc7d0]/20 bg-white p-6 shadow-sm">
        <div class="grid gap-4 md:grid-cols-4">
            <div class="rounded-2xl bg-[#f4faff] p-4">
                <p class="text-xs font-bold uppercase tracking-wide text-[#40484f]">Total Pesanan</p>
                <p class="mt-2 text-3xl font-bold text-[#141d21]">{{ $stats['total'] ?? 0 }}</p>
            </div>
            <div class="rounded-2xl bg-[#f4faff] p-4">
                <p class="text-xs font-bold uppercase tracking-wide text-[#40484f]">Selesai</p>
                <p class="mt-2 text-3xl font-bold text-emerald-600">{{ $stats['completed'] ?? 0 }}</p>
            </div>
            <div class="rounded-2xl bg-[#f4faff] p-4">
                <p class="text-xs font-bold uppercase tracking-wide text-[#40484f]">Tertunda</p>
                <p class="mt-2 text-3xl font-bold text-amber-600">{{ $stats['pending'] ?? 0 }}</p>
            </div>
            <div class="rounded-2xl bg-[#f4faff] p-4">
                <p class="text-xs font-bold uppercase tracking-wide text-[#40484f]">Total Belanja</p>
                <p class="mt-2 text-3xl font-bold text-[#006b9b]">Rp {{ number_format($stats['total_spent'] ?? 0, 0) }}</p>
            </div>
        </div>
    </section>

    <section class="rounded-3xl border border-[#bfc7d0]/20 bg-white p-6 shadow-sm">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-[#141d21]">Daftar Pesanan</h2>
                <p class="text-sm text-[#40484f]">Semua item tampil sebagai kartu per blok.</p>
            </div>
            <form method="GET" action="{{ route('user.orders.history') }}" class="flex gap-3">
                <select name="status" class="rounded-xl border border-[#bfc7d0]/40 bg-[#f4faff] px-4 py-3 text-sm outline-none transition focus:border-[#006b9b] focus:ring-2 focus:ring-[#006b9b]/15">
                    <option value="all" @selected(($statusFilter ?? 'all') === 'all')>Semua Status</option>
                    <option value="pending" @selected(($statusFilter ?? 'all') === 'pending')>Tertunda</option>
                    <option value="completed" @selected(($statusFilter ?? 'all') === 'completed')>Selesai</option>
                    <option value="cancelled" @selected(($statusFilter ?? 'all') === 'cancelled')>Dibatalkan</option>
                </select>
                <button type="submit" class="rounded-xl bg-[#006b9b] px-4 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#00557b]">Filter</button>
            </form>
        </div>

        <div class="space-y-4">
            @forelse(($orders ?? []) as $order)
                <article class="rounded-2xl border border-[#bfc7d0]/20 p-5 transition-colors hover:border-[#006b9b]/30 hover:bg-[#f4faff]">
                    <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wide text-[#40484f]">{{ $order['service_type'] ?? 'Layanan' }}</p>
                                <h3 class="mt-1 text-xl font-bold text-[#141d21]">{{ $order['service_name'] ?? 'Layanan' }}</h3>
                            </div>
                            <p class="text-sm text-[#40484f]">Kode Pesanan: {{ $order['order_code'] ?? '-' }}</p>
                            <div class="grid gap-2 text-sm text-[#40484f] sm:grid-cols-2">
                                <p>Alamat: <span class="font-semibold text-[#141d21]">{{ $order['address'] ?? '-' }}</span></p>
                                <p>Tanggal: <span class="font-semibold text-[#141d21]">{{ !empty($order['order_date']) ? \App\Helpers\FormatHelper::date($order['order_date']) : '-' }}</span></p>
                                <p>Status: <span class="font-semibold text-[#141d21]">{{ strtoupper(str_replace('_', ' ', $order['status'] ?? 'pending')) }}</span></p>
                                <p>Harga: <span class="font-semibold text-[#141d21]">{{ \App\Helpers\FormatHelper::rupiah((float) ($order['total_price'] ?? 0)) }}</span></p>
                            </div>
                        </div>

                        <div class="flex gap-3 lg:min-w-[180px] lg:flex-col">
                            @if(!empty($order['order']))
                                <a href="{{ route('user.orders.show', $order['order']) }}" class="w-full rounded-xl border border-[#006b9b] px-4 py-3 text-center text-sm font-semibold text-[#006b9b] transition-colors hover:bg-[#006b9b]/5">
                                    Lihat Detail
                                </a>
                            @endif
                            @if(($order['status'] ?? null) === 'completed' && empty($order['rated']))
                                <button type="button" class="js-open-rating w-full rounded-xl bg-[#006b9b] px-4 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#00557b]" data-order-code="{{ $order['order_code'] ?? '' }}" data-service-name="{{ $order['service_name'] ?? 'Layanan' }}" data-provider-name="Mitra KOSERA">
                                    Beri Rating
                                </button>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-[#bfc7d0]/40 bg-[#f4faff] p-10 text-center">
                    <p class="font-semibold text-[#141d21]">Belum ada riwayat pesanan.</p>
                    <p class="mt-1 text-sm text-[#40484f]">Mulai dari dashboard untuk mencari layanan.</p>
                </div>
            @endforelse
        </div>
    </section>

    @include('components.rating-modal')

    <script>
        document.querySelectorAll('.js-open-rating').forEach((button) => {
            button.addEventListener('click', () => {
                openRatingModal(
                    button.dataset.orderCode || '',
                    button.dataset.serviceName || 'Layanan',
                    button.dataset.providerName || 'Mitra KOSERA'
                );
            });
        });
    </script>
</x-layout.user-sidebar>
