@php
    $pageTitle = 'Cari Mitra Terpercaya - KOSERA';
    $services = $services ?? collect();
    $filters = $filters ?? ['search' => '', 'category' => 'all'];
    $selectedCategory = $filters['category'] ?? 'all';
    $searchQuery = $filters['search'] ?? '';
    $categories = $categories ?? collect();
@endphp

<x-layout.user-sidebar :pageTitle="$pageTitle" :bgColor="'#f4faff'" mainClass="p-6 md:p-8 space-y-8">
    <section class="rounded-3xl border border-[#bfc7d0]/20 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-2xl space-y-2">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-[#006b9b]">Dashboard User</p>
                <h1 class="text-4xl font-bold text-[#141d21]">Cari Mitra Terpercaya</h1>
                <p class="text-sm text-[#40484f]">Temukan partner profesional untuk kebersihan, servis elektronik, dan laundry. Semua isi layanan ada di sini, jadi halaman ini jadi pusat utama user.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('user.orders.history') }}" class="rounded-xl border border-[#bfc7d0]/40 px-4 py-3 text-sm font-semibold text-[#006b9b] transition-colors hover:bg-[#f4faff]">Lihat Riwayat</a>
                <a href="{{ route('user.profile.show') }}" class="rounded-xl bg-[#006b9b] px-4 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#00557b]">Profil</a>
            </div>
        </div>

        <form class="mt-6 flex flex-col gap-3 lg:flex-row" method="GET" action="{{ route('user.dashboard') }}">
            <div class="relative flex-1">
                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-[#40484f]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path></svg>
                <input type="text" name="search" value="{{ $searchQuery }}" placeholder="Cari nama mitra atau jenis layanan..." class="w-full rounded-2xl border border-[#bfc7d0]/40 bg-[#f4faff] py-3 pl-12 pr-4 text-sm outline-none transition focus:border-[#006b9b] focus:ring-2 focus:ring-[#006b9b]/15" />
            </div>
            <select name="category" class="rounded-2xl border border-[#bfc7d0]/40 bg-[#f4faff] px-4 py-3 text-sm outline-none transition focus:border-[#006b9b] focus:ring-2 focus:ring-[#006b9b]/15">
                <option value="all" @selected($selectedCategory === 'all')>Semua Kategori</option>
                @foreach($categories as $categoryItem)
                    <option value="{{ $categoryItem }}" @selected($selectedCategory === $categoryItem)>{{ ucfirst($categoryItem) }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-2xl bg-[#006b9b] px-6 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#00557b]">Cari</button>
        </form>
    </section>

    <section class="grid gap-6 lg:grid-cols-3">
        @forelse($services as $service)
            <article class="rounded-3xl border border-[#bfc7d0]/20 bg-white p-6 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <span class="rounded-full bg-[#e0f2fe] px-3 py-1 text-xs font-bold uppercase tracking-wide text-[#006b9b]">
                        {{ $service->kategori ?? 'Layanan' }}
                    </span>
                    <span class="text-xs font-semibold text-amber-500">{{ number_format((float) ($service->views ?? 0), 0) }} views</span>
                </div>
                <h2 class="text-2xl font-bold text-[#141d21]">{{ $service->nama_layanan }}</h2>
                <p class="mt-2 text-sm text-[#40484f]">
                    {{ $service->user?->nama ?? 'Mitra' }}
                    @if(!empty($service->user?->location))
                        • {{ $service->user->location }}
                    @endif
                </p>
                <p class="mt-4 text-sm text-[#40484f]">{{ $service->deskripsi ?? 'Deskripsi layanan belum tersedia.' }}</p>
                <div class="mt-6 flex items-center justify-between border-t border-[#bfc7d0]/20 pt-4">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-[#40484f]">Mulai Dari</p>
                        <p class="text-lg font-bold text-[#006b9b]">{{ \App\Helpers\FormatHelper::rupiah((float) ($service->harga_mulai ?? 0)) }}</p>
                    </div>
                    <a href="{{ route('user.services.show', $service->id) }}" class="rounded-xl bg-[#006b9b] px-4 py-2 text-sm font-semibold text-white transition-colors hover:bg-[#00557b]">Pesan</a>
                </div>
            </article>
        @empty
            <div class="rounded-3xl border border-dashed border-[#bfc7d0]/40 bg-white p-8 text-center text-sm text-[#40484f] lg:col-span-3">
                Tidak ada layanan yang cocok dengan filter saat ini.
            </div>
        @endforelse
    </section>

    <section class="grid gap-6 lg:grid-cols-[1.4fr_0.6fr]">
        <div class="rounded-3xl border border-[#bfc7d0]/20 bg-white p-6 shadow-sm">
            <div class="mb-5 flex items-end justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-[#141d21]">Rekomendasi Mitra</h2>
                    <p class="text-sm text-[#40484f]">Beberapa layanan unggulan untuk langsung dipesan.</p>
                </div>
                <a href="{{ route('user.orders.history') }}" class="text-sm font-semibold text-[#006b9b] hover:underline">Riwayat</a>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <a href="#" class="rounded-2xl border border-[#bfc7d0]/20 p-4 transition-colors hover:border-[#006b9b]/40 hover:bg-[#f4faff]">
                    <p class="text-xs font-bold uppercase tracking-wide text-[#006b9b]">Pilihan Populer</p>
                    <h3 class="mt-2 text-lg font-bold text-[#141d21]">Bersih Cepat Mingguan</h3>
                    <p class="mt-1 text-sm text-[#40484f]">Cocok untuk kamar kos dan apartemen kecil.</p>
                </a>
                <a href="#" class="rounded-2xl border border-[#bfc7d0]/20 p-4 transition-colors hover:border-[#006b9b]/40 hover:bg-[#f4faff]">
                    <p class="text-xs font-bold uppercase tracking-wide text-[#006b9b]">Butuh Cepat</p>
                    <h3 class="mt-2 text-lg font-bold text-[#141d21]">Servis AC Darurat</h3>
                    <p class="mt-1 text-sm text-[#40484f]">Mitra siap datang ke lokasi hari ini.</p>
                </a>
            </div>
        </div>

        <aside class="rounded-3xl border border-[#bfc7d0]/20 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-[#141d21]">Aksi Cepat</h2>
            <p class="mt-2 text-sm text-[#40484f]">Semua navigasi utama user ada di sidebar, dashboard ini fokus ke isi layanan.</p>
            <div class="mt-6 space-y-3">
                <a href="{{ route('user.profile.show') }}" class="block rounded-2xl bg-[#f4faff] px-4 py-3 font-semibold text-[#006b9b] transition-colors hover:bg-[#e6eff5]">Buka Profil</a>
                <a href="{{ route('user.orders.history') }}" class="block rounded-2xl bg-[#f4faff] px-4 py-3 font-semibold text-[#006b9b] transition-colors hover:bg-[#e6eff5]">Lihat Riwayat</a>
                <a href="{{ route('user.dashboard') }}" class="block rounded-2xl bg-[#006b9b] px-4 py-3 font-semibold text-white transition-colors hover:bg-[#00557b]">Kembali ke Dashboard</a>
            </div>
        </aside>
    </section>
</x-layout.user-sidebar>
