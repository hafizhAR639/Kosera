@php
    $pageTitle = 'Cari Mitra Terpercaya - KOSERA';
    $services = $services ?? collect();
    $filters = $filters ?? ['search' => '', 'category' => 'all'];
    $selectedCategory = $filters['category'] ?? 'all';
    $searchQuery = $filters['search'] ?? '';
    $categoriesList = $categories ?? collect();
@endphp

<x-layout.user-sidebar :pageTitle="$pageTitle" :bgColor="'#f4faff'" mainClass="p-6 md:p-8 space-y-8">
    <!-- Header & Filter Card -->
    <section class="rounded-3xl border border-[#bfc7d0]/20 bg-white p-8 shadow-sm">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between mb-8">
            <div class="max-w-2xl">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-[#006b9b] mb-2">Dashboard User</p>
                <h1 class="text-3xl md:text-4xl font-black text-[#141d21]">Cari Mitra Terpercaya</h1>
                <p class="text-sm font-medium text-[#40484f] mt-2">Temukan partner profesional untuk kebersihan, servis elektronik, dan laundry yang telah terverifikasi oleh komunitas anak kos.</p>
            </div>
            <div class="flex gap-3 shrink-0">
                <a href="{{ route('user.orders.history') }}" class="rounded-xl border border-[#bfc7d0]/40 px-5 py-2.5 text-xs font-black text-[#006b9b] transition-all hover:bg-[#f4faff]">Riwayat Pesanan</a>
            </div>
        </div>

        <!-- Filter Form (Restored to original style but refined) -->
        <form class="flex flex-col gap-3 lg:flex-row" method="GET" action="{{ route('user.dashboard') }}">
            <div class="relative flex-1">
                <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-[#40484f]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"></path></svg>
                <input 
                    type="text" 
                    name="search" 
                    value="{{ $searchQuery }}" 
                    placeholder="Cari nama mitra atau jenis layanan..." 
                    class="w-full rounded-2xl border border-[#bfc7d0]/40 bg-[#f4faff] py-3.5 pl-12 pr-4 text-sm font-medium outline-none transition focus:border-[#006b9b] focus:ring-2 focus:ring-[#006b9b]/15" 
                />
            </div>
            <select name="category" class="rounded-2xl border border-[#bfc7d0]/40 bg-[#f4faff] px-6 py-3.5 text-sm font-bold text-slate-600 outline-none transition focus:border-[#006b9b] focus:ring-2 focus:ring-[#006b9b]/15 cursor-pointer min-w-[180px]">
                <option value="all" @selected($selectedCategory === 'all')>Semua Kategori</option>
                @foreach($categoriesList as $categoryItem)
                    <option value="{{ $categoryItem }}" @selected($selectedCategory === $categoryItem)>{{ ucfirst($categoryItem) }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-2xl bg-[#006b9b] px-8 py-3.5 text-sm font-black text-white shadow-lg shadow-[#006b9b]/20 transition-all hover:bg-[#00557b]">Cari Mitra</button>
        </form>
    </section>

    <!-- Services Grid (Original style) -->
    <section class="grid gap-6 lg:grid-cols-3">
        @forelse($services as $service)
            <article class="group flex flex-col rounded-[32px] border border-[#bfc7d0]/20 bg-white p-6 shadow-sm transition-all hover:shadow-lg hover:-translate-y-1">
                <div class="mb-4 flex items-center justify-between">
                    <span class="rounded-full bg-[#e0f2fe] px-3 py-1 text-[10px] font-black uppercase tracking-widest text-[#006b9b]">
                        {{ $service->kategori ?? 'Layanan' }}
                    </span>
                    <div class="flex items-center gap-1 text-amber-400">
                        <svg class="w-3 h-3 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                        <span class="text-[10px] font-black text-slate-900">4.9</span>
                    </div>
                </div>
                
                <div class="mb-4 flex items-center gap-3">
                    <div class="h-12 w-12 rounded-xl bg-slate-50 border border-slate-100 overflow-hidden shrink-0">
                        @if(!empty($service->user->avatar))
                            <img src="{{ asset($service->user->avatar) }}" class="h-full w-full object-cover" />
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($service->user->nama ?? 'M') }}&background=E1F5FE&color=006b9b" class="h-full w-full object-cover" />
                        @endif
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-lg font-black text-[#141d21] truncate">{{ $service->nama_layanan }}</h2>
                        <p class="text-xs font-bold text-slate-400 truncate">{{ $service->user?->nama ?? 'Mitra Kosera' }}</p>
                    </div>
                </div>

                <p class="text-xs font-medium text-[#40484f] line-clamp-2 mb-6 h-8">{{ $service->deskripsi ?? 'Deskripsi layanan belum tersedia.' }}</p>
                
                <div class="mt-auto flex items-center justify-between border-t border-slate-50 pt-4">
                    <div>
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-300">Mulai Dari</p>
                        <p class="text-lg font-black text-[#006b9b]">{{ \App\Helpers\FormatHelper::rupiah((float) ($service->harga_mulai ?? 0)) }}</p>
                    </div>
                    <a href="{{ route('user.services.show', $service->id) }}" class="rounded-xl bg-[#006b9b] px-5 py-2.5 text-xs font-black text-white shadow-md shadow-[#006b9b]/10 transition-all hover:bg-[#00557b]">Pesan</a>
                </div>
            </article>
        @empty
            <div class="rounded-[32px] border-2 border-dashed border-[#bfc7d0]/40 bg-white/50 p-12 text-center text-sm font-bold text-[#40484f] lg:col-span-3">
                Tidak ada layanan yang cocok dengan filter saat ini.
            </div>
        @endforelse
    </section>

    <!-- Why Kosera Section (Requested to add) -->
    <section class="rounded-[40px] bg-white p-10 md:p-16 shadow-sm border border-[#bfc7d0]/10">
        <div class="mb-16 text-center">
            <h2 class="text-3xl font-black text-[#141d21]">Kenapa Pesan Lewat Kosera?</h2>
            <p class="mt-4 text-[#40484f] font-medium max-w-xl mx-auto">Kualitas mitra kami adalah prioritas utama untuk kenyamanan kosmu.</p>
        </div>

        <div class="grid gap-10 md:grid-cols-3">
            <div class="flex flex-col items-center text-center group">
                <div class="mb-8 flex h-20 w-20 items-center justify-center rounded-3xl bg-blue-50 text-[#006b9b] transition-transform group-hover:scale-110">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </div>
                <h3 class="text-lg font-black text-[#141d21]">Mitra Terverifikasi</h3>
                <p class="mt-4 text-xs text-[#40484f] font-bold leading-relaxed px-4">Pengecekan latar belakang ketat untuk keamanan Anda.</p>
            </div>
            <div class="flex flex-col items-center text-center group">
                <div class="mb-8 flex h-20 w-20 items-center justify-center rounded-3xl bg-amber-50 text-amber-600 transition-transform group-hover:scale-110">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </div>
                <h3 class="text-lg font-black text-[#141d21]">Harga Transparan</h3>
                <p class="mt-4 text-xs text-[#40484f] font-bold leading-relaxed px-4">Tanpa biaya tersembunyi, pas di kantong mahasiswa.</p>
            </div>
            <div class="flex flex-col items-center text-center group">
                <div class="mb-8 flex h-20 w-20 items-center justify-center rounded-3xl bg-emerald-50 text-emerald-600 transition-transform group-hover:scale-110">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                </div>
                <h3 class="text-lg font-black text-[#141d21]">Jaminan Kualitas</h3>
                <p class="mt-4 text-xs text-[#40484f] font-bold leading-relaxed px-4">Garansi pengerjaan ulang jika hasil tidak memuaskan.</p>
            </div>
        </div>
    </section>

    <!-- Footer Section (Requested with white bg) -->
    <footer class="rounded-[40px] bg-white border border-[#bfc7d0]/10 p-12 md:p-16">
        <div class="flex flex-col md:flex-row justify-between gap-12 mb-12">
            <div class="max-w-xs space-y-6">
                <img src="{{ asset('img/logos/kosera-logo.png') }}" class="h-10 w-auto" />
                <p class="text-sm font-medium text-slate-400 leading-relaxed">Solusi terpercaya untuk kebutuhan jasa anak kos. Dari kebersihan hingga perbaikan elektronik, semua ada di Kosera.</p>
            </div>
            <div class="grid grid-cols-2 gap-12">
                <div>
                    <h4 class="font-black text-[#141d21] mb-6 uppercase tracking-widest text-[10px]">Layanan</h4>
                    <ul class="space-y-4 text-sm font-bold text-slate-400">
                        <li><a href="#" class="hover:text-[#006b9b] transition-colors">Kebersihan</a></li>
                        <li><a href="#" class="hover:text-[#006b9b] transition-colors">Elektronik</a></li>
                        <li><a href="#" class="hover:text-[#006b9b] transition-colors">Laundry</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-black text-[#141d21] mb-6 uppercase tracking-widest text-[10px]">Perusahaan</h4>
                    <ul class="space-y-4 text-sm font-bold text-slate-400">
                        <li><a href="#" class="hover:text-[#006b9b] transition-colors">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-[#006b9b] transition-colors">Kontak</a></li>
                        <li><a href="#" class="hover:text-[#006b9b] transition-colors">Karir</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="pt-10 border-t border-slate-50 text-center">
            <p class="text-[10px] font-black text-slate-200 uppercase tracking-widest">&copy; 2024 KOSERA. All rights reserved.</p>
        </div>
    </footer>
</x-layout.user-sidebar>
