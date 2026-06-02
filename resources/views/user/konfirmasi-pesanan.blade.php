<x-layout.user-sidebar :pageTitle="'Konfirmasi Pesanan - KOSERA'" :bgColor="'#f4faff'" mainClass="flex items-start justify-start p-6">
    <div class="w-full max-w-[1000px]">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('user.dashboard') }}" class="group inline-flex items-center gap-2 text-[#0073a5] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#005981]">
                <svg class="h-6 w-6 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M10 19l-7-7m0 0l7-7m-7 7h18" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                </svg>
                <span class="text-xl font-bold">Konfirmasi Pesanan</span>
            </a>
        </div>

        <form method="POST" action="{{ route('user.orders.store') }}">
            @csrf
            <input type="hidden" name="service_id" value="{{ request('service_id', 3) }}">
            <input type="hidden" name="customer_name" value="{{ auth()->user()->nama ?? 'Customer Kosera' }}">
            <input type="hidden" name="customer_phone" value="{{ auth()->user()->phone ?? '-' }}">
            <input type="hidden" name="customer_email" value="{{ auth()->user()->email ?? 'test@kosera.com' }}">
            <input type="hidden" name="alamat_lengkap" value="{{ auth()->user()->location ?? 'Alamat Default' }}">

        <div class="grid grid-cols-12 gap-8">
            <!-- Left Column -->
            <div class="col-span-12 space-y-6 lg:col-span-8">
                <!-- Service Info -->
                <section class="flex items-start gap-5 rounded-lg border border-slate-100 bg-white p-6 shadow-sm">
                    <img alt="Laundry" class="h-24 w-24 flex-shrink-0 rounded-lg object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA55lmZx1rOqvCJnCVRWHxO9PlULNLxat34QuynfD7yEA2C_us0PfYgOyOGsxQjYk6gB69TcHCJUKIC8UrUwuZn6ixP7UgFizkqMvUugSOBmQ3_hnG1RqiZTZk8qrmo54T0pb2bEWUfmeD1kRtKG4ti0aTn5CEEHunLPEFFakbXiUku-sNp1HDSQkbzlelB1MxtVsA-ZCm6BobmnLdl2E0PktTshjuua-YkQss6cKGweEjIxnog-s95M4_nfBz9EerLGOqXXyBdJ0w" />
                    <div class="flex-1">
                        <div class="mb-2 flex items-start justify-between gap-2">
                            <div>
                                <h3 class="text-xl font-bold text-slate-800">{{ $service->nama_layanan }}</h3>
                                <p class="font-semibold text-[#0073a5]">{{ $service->user->nama ?? 'Mitra KOSERA' }}</p>
                            </div>
                            <span class="rounded-full bg-[#e0f2fe] px-3 py-1 text-xs font-bold uppercase text-[#0073a5]">Premium</span>
                        </div>
                        <div class="flex flex-wrap items-center gap-6 text-sm font-medium text-slate-500">
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                                <span>24 - 48 Jam</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                                <span>Rp {{ number_format($service->harga_mulai, 0) }} / {{ $service->satuan }}</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Address -->
                <section class="rounded-lg border border-slate-100 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2 font-bold text-slate-800">
                            <svg class="h-5 w-5 text-[#0073a5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                            <span>Alamat Pengiriman/Pickup</span>
                        </div>
                        <button type="button" class="text-sm font-semibold text-[#0073a5] hover:underline focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#005981]">Ubah Alamat</button>
                    </div>
                    <div class="rounded-lg border border-slate-100 bg-slate-50 p-4">
                        <p class="mb-1 font-bold text-slate-700">Kos Mahasiswa Sejahtera (Kamar 204)</p>
                        <p class="text-sm leading-relaxed text-slate-500">Jl. Ir. Sutami No. 36, Jebres, Kota Surakarta, Jawa Tengah 57126</p>
                    </div>
                </section>

                <!-- Notes -->
                <section class="rounded-lg border border-slate-100 bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center gap-2 font-bold text-slate-800">
                        <svg class="h-5 w-5 text-[#0073a5]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h7" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        <span>Catatan Tambahan</span>
                    </div>
                    <textarea class="h-32 w-full resize-none rounded-lg border border-slate-200 bg-slate-50 p-4 text-sm text-slate-700 transition-all placeholder:text-slate-400 focus:border-[#0073a5] focus:ring-[#0073a5]" placeholder="Contoh: Tolong jangan pakai pewangi mawar, atau jemput di gerbang samping."></textarea>
                </section>
            </div>

            <!-- Right Column -->
            <div class="col-span-12 lg:col-span-4">
                <div class="sticky top-8 space-y-6">
                    <!-- Payment Summary -->
                    <section class="rounded-lg border border-slate-100 bg-white p-8 shadow-sm">
                        <h3 class="mb-6 text-xl font-bold text-slate-800">Rincian Pembayaran</h3>

                        <div class="mb-8 space-y-4">
                            <div class="flex justify-between text-slate-600">
                                <span>Harga Layanan (Min. 3kg)</span>
                                <span class="font-medium text-slate-800">Rp {{ number_format($service->harga_mulai, 0) }}</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Biaya Layanan Aplikasi</span>
                                <span class="font-medium text-slate-800">Rp 2.000</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Biaya Antar Jemput</span>
                                <span class="text-sm font-bold uppercase text-green-600">Gratis</span>
                            </div>
                        </div>

                        <div class="mb-8 border-t border-dashed border-slate-200 pt-6">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-800">Total</span>
                                <span class="text-2xl font-extrabold text-[#0073a5]">Rp 38.000</span>
                            </div>
                        </div>

                        <button type="submit" class="mb-6 block w-full rounded-lg bg-[#0073a5] py-4 text-center font-bold text-white shadow-lg shadow-[#0073a5]/20 transition-colors hover:bg-[#005b85]">
                            Pesan Sekarang
                        </button>

                        <div class="flex items-center justify-center gap-2 text-center text-xs font-medium text-slate-400">
                            <svg class="h-4 w-4 text-[#0073a5]" fill="currentColor" viewBox="0 0 20 20"><path clip-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0110 1.944 11.954 11.954 0 0117.834 5c.11.65.166 1.32.166 2.001 0 4.946-2.597 9.281-6.505 11.751a.75.75 0 01-.83 0C6.763 16.282 4.166 11.947 4.166 7.001c0-.68.056-1.35.166-2.002zm10.58 4.47a.75.75 0 00-1.06-1.06L9 11.19 7.314 9.504a.75.75 0 00-1.06 1.06l2.217 2.217a.75.75 0 001.06 0l3.215-3.215z" fill-rule="evenodd"></path></svg>
                            <span>Pembayaran Aman</span>
                        </div>
                    </section>
                </div>
            </div>
        </div> 
    </form></div>
</x-layout.user-sidebar>
