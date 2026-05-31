@php
    $pageTitle = 'Cari Mitra - KOSERA';
@endphp

<x-layout.user-sidebar :pageTitle="$pageTitle" :bgColor="'#f4faff'" mainClass="space-y-6 p-6 md:p-8">
    <!-- Search & Filter -->
    <header class="space-y-4">
        <div class="flex items-end gap-3">
            <form class="flex-1 relative" method="GET" action="{{ route('user.services.index') }}">
                <svg class="absolute left-4 top-1/2 -translate-y-1/2 h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <input type="text" name="search" value="{{ $filters['search'] }}" placeholder="Cari mitra atau layanan..." 
                    class="w-full pl-11 pr-4 py-3 rounded-lg border border-slate-200 bg-white focus:border-[#0073a5] focus:ring-2 focus:ring-[#0073a5]/20 outline-none transition text-sm">
                <select name="category" onchange="this.form.submit()"
                    class="ml-2 px-4 py-3 rounded-lg border border-slate-200 bg-white focus:border-[#0073a5] focus:ring-2 focus:ring-[#0073a5]/20 outline-none transition text-sm">
                    <option value="all">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ $filters['category'] === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </form>
        </div>
    </header>

    <!-- Services Grid -->
    @if($services->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
                <a href="{{ route('user.services.show', $service->id) }}" 
                    class="group rounded-2xl border border-slate-100 bg-white p-6 shadow-sm hover:shadow-md transition-all hover:border-[#0073a5]/30">
                    
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-4">
                        <span class="text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-full bg-[#0073a5]/10 text-[#0073a5]">
                            {{ $service->kategori ?? 'Layanan' }}
                        </span>
                        <div class="flex items-center gap-1 text-xs font-bold text-amber-500">
                            <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            {{ number_format($service->views, 0) }}
                        </div>
                    </div>

                    <!-- Service Name & Mitra -->
                    <h3 class="font-bold text-slate-900 mb-2 group-hover:text-[#0073a5] transition line-clamp-2">
                        {{ $service->nama_layanan }}
                    </h3>
                    <p class="text-xs text-slate-500 mb-4">
                        {{ $service->user?->nama ?? 'Mitra' }}
                    </p>

                    <!-- Description -->
                    <p class="text-sm text-slate-600 mb-4 line-clamp-2">
                        {{ $service->deskripsi ?? 'Layanan profesional berkualitas' }}
                    </p>

                    <!-- Price & CTA -->
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        <div class="text-sm">
                            <p class="text-xs text-slate-400">Mulai dari</p>
                            <p class="font-bold text-[#0073a5] text-lg">
                                Rp {{ number_format($service->harga_mulai, 0) }}
                            </p>
                        </div>
                        <svg class="h-5 w-5 text-[#0073a5] group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="flex gap-2 justify-center py-8">
            @if($services->onFirstPage())
                <button disabled class="px-4 py-2 rounded-lg text-slate-300 bg-slate-100 text-sm font-semibold">← Sebelumnya</button>
            @else
                <a href="{{ $services->previousPageUrl() }}" class="px-4 py-2 rounded-lg bg-[#0073a5] text-white text-sm font-semibold hover:bg-[#005981] transition">← Sebelumnya</a>
            @endif

            <span class="px-4 py-2 text-sm font-semibold">{{ $services->currentPage() }} / {{ $services->lastPage() }}</span>

            @if($services->hasMorePages())
                <a href="{{ $services->nextPageUrl() }}" class="px-4 py-2 rounded-lg bg-[#0073a5] text-white text-sm font-semibold hover:bg-[#005981] transition">Berikutnya →</a>
            @else
                <button disabled class="px-4 py-2 rounded-lg text-slate-300 bg-slate-100 text-sm font-semibold">Berikutnya →</button>
            @endif
        </div>
    @else
        <div class="rounded-2xl border-2 border-dashed border-slate-300 bg-slate-50 p-12 text-center">
            <svg class="h-12 w-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
            </svg>
            <p class="text-slate-600 font-semibold">Layanan tidak ditemukan</p>
            <p class="text-sm text-slate-500 mt-1">Coba ubah pencarian atau kategori Anda</p>
        </div>
    @endif
</x-layout.user-sidebar>
