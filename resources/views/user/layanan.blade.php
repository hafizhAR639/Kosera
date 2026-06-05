@php
    $pageTitle = 'Cari Mitra - KOSERA';
@endphp

<x-layout.user-sidebar :pageTitle="$pageTitle" :bgColor="'#f4faff'" mainClass="p-6 md:p-8 space-y-8">
    <section class="rounded-3xl border border-[#bfc7d0]/20 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#006b9b]">Cari Mitra</p>
                <h1 class="text-4xl font-bold text-[#141d21]">Temukan layanan terbaik</h1>
                <p class="mt-2 text-sm text-[#40484f]">Halaman ini sekarang mengikuti layout shared user, jadi sidebar dan spacing seragam dengan dashboard dan riwayat.</p>
            </div>
            <a href="{{ route('user.dashboard') }}" class="rounded-xl bg-[#006b9b] px-4 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#00557b]">Ke Dashboard</a>
        </div>

        <form class="mt-6 flex flex-col gap-3 lg:flex-row" method="GET" action="{{ route('user.services.index') }}">
            <div class="relative flex-1">
                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-[#40484f]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path></svg>
                <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari mitra atau layanan..." class="w-full rounded-2xl border border-[#bfc7d0]/40 bg-[#f4faff] py-3 pl-12 pr-4 text-sm outline-none transition focus:border-[#006b9b] focus:ring-2 focus:ring-[#006b9b]/15" />
            </div>
            <select name="category" class="rounded-2xl border border-[#bfc7d0]/40 bg-[#f4faff] px-4 py-3 text-sm outline-none transition focus:border-[#006b9b] focus:ring-2 focus:ring-[#006b9b]/15">
                <option value="all">Semua Kategori</option>
                <option value="kebersihan">Kebersihan</option>
                <option value="teknisi">Teknisi</option>
                <option value="laundry">Laundry</option>
            </select>
            <button type="submit" class="rounded-2xl bg-[#006b9b] px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#00557b]">Cari</button>
        </form>
    </section>

    <section class="grid gap-6 lg:grid-cols-3">
        @foreach ($services as $service)
            <a href="{{ route('user.orders.create', ['service_id' => $service->id]) }}" class="block rounded-3xl border border-[#bfc7d0]/20 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006b9b]">
                <div class="mb-4">
                    <span class="rounded-full bg-[#e0f2fe] px-3 py-1 text-xs font-bold uppercase tracking-wide text-[#006b9b]">{{ $service->kategori }}</span>
                </div>
                <h2 class="text-2xl font-bold text-[#141d21]">{{ $service->nama_layanan }}</h2>
                <p class="mt-4 text-sm text-[#40484f]">{{ $service->deskripsi }}</p>
                <p class="mt-4 text-base font-semibold text-[#006b9b]">Mulai dari Rp {{ number_format($service->harga_mulai, 0, ',', '.') }}</p>
            </a>
        @endforeach
    </section>
</x-layout.user-sidebar>
