@php
    $pageTitle = $service->nama_layanan . ' - KOSERA';
@endphp

<x-layout.user-sidebar :pageTitle="$pageTitle" :bgColor="'#f4faff'" mainClass="max-w-4xl mx-auto space-y-6 p-6">
    <!-- Back Button -->
    <a href="{{ route('user.services.index') }}" class="inline-flex items-center gap-2 text-[#0073a5] hover:text-[#005981] transition font-semibold text-sm">
        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
        Kembali
    </a>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Service Info (Main) -->
        <div class="md:col-span-2 space-y-6">
            <!-- Header -->
            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <div class="flex items-start justify-between mb-4">
                    <span class="text-xs font-bold uppercase tracking-wide px-3 py-1 rounded-full bg-[#0073a5]/10 text-[#0073a5]">
                        {{ $service->kategori }}
                    </span>
                    <div class="flex items-center gap-1 text-sm font-bold text-amber-500">
                        <svg class="h-4 w-4 fill-current" viewBox="0 0 24 24"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        {{ number_format($service->views, 0) }} views
                    </div>
                </div>

                <h1 class="text-3xl font-bold text-slate-900 mb-2">{{ $service->nama_layanan }}</h1>
                <p class="text-slate-600 mb-6">{{ $service->deskripsi }}</p>

                <!-- Service Details Grid -->
                <div class="grid grid-cols-2 gap-4 py-4 border-t border-slate-100">
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold tracking-wide">Harga Mulai</p>
                        <p class="text-xl font-bold text-[#0073a5]">Rp {{ number_format($service->harga_mulai, 0) }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold tracking-wide">Estimasi Waktu</p>
                        <p class="text-xl font-bold text-slate-900">
                            @if($service->durasi_estimasi)
                                {{ $service->durasi_estimasi >= 1440 ? floor($service->durasi_estimasi / 1440) . 'd' : $service->durasi_estimasi . 'm' }}
                            @else
                                -
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold tracking-wide">Area Layanan</p>
                        <p class="text-xl font-bold text-slate-900">{{ $service->area_layanan ?? 'Area Luas' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 uppercase font-bold tracking-wide">Satuan</p>
                        <p class="text-xl font-bold text-slate-900">{{ $service->satuan ?? 'Per Project' }}</p>
                    </div>
                </div>
            </section>

            <!-- Description Section -->
            <section class="rounded-2xl bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-slate-900 mb-4">Tentang Layanan</h2>
                <p class="text-slate-600 leading-relaxed">
                    {{ $service->deskripsi ?? 'Layanan profesional dengan standar kualitas tinggi. Dikerjakan oleh tenaga profesional berpengalaman dan bersertifikat.' }}
                </p>
            </section>
        </div>

        <!-- Mitra Info (Sidebar) -->
        <aside class="space-y-6">
            <!-- Mitra Card -->
            <div class="rounded-2xl bg-white p-6 shadow-sm sticky top-20">
                <h3 class="text-sm font-bold uppercase tracking-wide text-slate-400 mb-4">Penyedia Layanan</h3>
                
                <div class="flex items-start gap-4 mb-6">
                    <div class="flex h-16 w-16 items-center justify-center rounded-xl bg-[#0073a5]/10 text-[#0073a5] text-2xl font-bold flex-shrink-0">
                        {{ substr($service->user?->nama ?? 'M', 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-slate-900 text-sm leading-tight">
                            {{ $service->user?->nama ?? 'Mitra' }}
                        </h4>
                        <p class="text-xs text-slate-500 mt-1">{{ $service->user?->location ?? 'Lokasi' }}</p>
                    </div>
                </div>

                <!-- Contact & CTA -->
                <div class="space-y-3 border-t border-slate-100 pt-4">
                    @if($service->user?->phone)
                        <a href="tel:{{ $service->user?->phone }}" 
                            class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-lg bg-slate-100 text-slate-900 hover:bg-slate-200 transition font-semibold text-sm">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 5a2 2 0 012-2h3.28a1 1 0 00.948.684l1.498 4.493a1 1 0 00.502.756l2.73 1.365a1 1 0 001.27-1.27L14.5 8.294" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            Hubungi Mitra
                        </a>
                    @endif

                    <a href="{{ route('user.orders.create', ['service_id' => $service->id]) }}" 
                        class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-lg bg-[#0073a5] text-white hover:bg-[#005981] transition font-semibold text-sm">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        Pesan Sekarang
                    </a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="rounded-2xl bg-[#0073a5]/5 border border-[#0073a5]/20 p-6">
                <h3 class="text-xs font-bold uppercase tracking-wide text-slate-600 mb-4">Info Cepat</h3>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center gap-2 text-slate-600">
                        <svg class="h-4 w-4 text-[#0073a5]" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                        Terverifikasi
                    </li>
                    <li class="flex items-center gap-2 text-slate-600">
                        <svg class="h-4 w-4 text-[#0073a5]" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                        Responsif
                    </li>
                    <li class="flex items-center gap-2 text-slate-600">
                        <svg class="h-4 w-4 text-[#0073a5]" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                        Garansi Kualitas
                    </li>
                </ul>
            </div>
        </aside>
    </div>
</x-layout.user-sidebar>
