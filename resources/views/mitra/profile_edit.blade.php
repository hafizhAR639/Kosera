@extends('layouts.mitra')

@section('content')
<section class="mx-auto max-w-6xl space-y-6 sm:space-y-8">
    @if (!empty($message))
        <p role="alert" class="rounded-xl border px-4 py-3 text-sm {{ $message['type'] === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' }}">
            {{ $message['text'] }}
        </p>
    @endif

    <header class="rounded-[28px] bg-white/85 p-6 shadow-[0_10px_30px_rgba(1,51,109,0.12)] backdrop-blur sm:p-8">
        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#006b9b]/70">Profil Saya</p>
        <h1 class="mt-2 text-3xl font-semibold text-black sm:text-4xl">Edit Profil</h1>
        <p class="mt-2 text-slate-600">Perbarui informasi umum, keuangan, dan kelengkapan profil mitra Anda.</p>
    </header>

    <form method="POST" action="{{ route('mitra.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="space-y-6 xl:col-span-2">
                <section class="rounded-3xl bg-white p-6 shadow-sm">
                    <h2 class="mb-6 text-xl font-bold text-slate-900">Informasi Umum</h2>

                    <div class="space-y-5">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-600">Nama Panjang</label>
                            <input type="text" name="nama" value="{{ old('nama', $profile['nama'] ?? '') }}" placeholder="Isi nama panjang" class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2]" required>
                            @error('nama') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-600">Nomor HP</label>
                            <input type="text" name="phone" value="{{ old('phone', $profile['phone'] ?? '') }}" placeholder="Isi nomor HP" class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2]">
                            @error('phone') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-600">Deskripsi Diri</label>
                            <textarea name="bio" rows="3" placeholder="Isi deskripsi diri" class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2]">{{ old('bio', $profile['bio'] ?? '') }}</textarea>
                            @error('bio') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-600">Jangkauan Kota</label>
                            <input type="text" name="location" value="{{ old('location', $profile['location'] ?? '') }}" placeholder="Contoh: Bandung, Cimahi" class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2]">
                            @error('location') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </section>

                <section class="rounded-3xl bg-white p-6 shadow-sm">
                    <h2 class="mb-6 text-xl font-bold text-slate-900">Keuangan</h2>

                    <div class="space-y-5">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-600">Nama Bank</label>
                            <input type="text" name="nama_bank" value="{{ old('nama_bank', $bankAccount['nama_bank'] ?? '') }}" placeholder="Contoh: BCA" class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2]">
                            @error('nama_bank') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-600">Nama Rekening</label>
                            <input type="text" name="nama_rekening" value="{{ old('nama_rekening', $bankAccount['nama_rekening'] ?? '') }}" placeholder="Isi Nama Rekening" class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2]">
                            @error('nama_rekening') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-600">Nomor Rekening</label>
                            <input type="text" name="nomor_rekening" value="{{ old('nomor_rekening', $bankAccount['nomor_rekening'] ?? '') }}" placeholder="Isi Nomor Rekening" class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2]">
                            @error('nomor_rekening') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-600">Alamat Bank (Opsional)</label>
                            <input type="text" name="alamat_bank" value="{{ old('alamat_bank', $bankAccount['alamat_bank'] ?? '') }}" placeholder="Isi alamat bank" class="w-full rounded-xl border border-slate-200 bg-slate-100 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2]">
                            @error('alamat_bank') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </section>
            </div>

            <div class="space-y-6">
                <section class="rounded-3xl bg-white p-6 shadow-sm">
                    <h2 class="mb-4 text-lg font-bold text-slate-900">Foto Profil</h2>
                    <div class="mb-4 flex justify-center">
                        <div class="h-36 w-36 overflow-hidden rounded-2xl border border-slate-200 bg-slate-100">
                            @if (!empty($profile['avatar']))
                                <img src="{{ $profile['avatar'] }}" alt="Foto profil" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center text-4xl font-bold text-slate-400">{{ strtoupper(substr($profile['nama'] ?? 'U', 0, 1)) }}</div>
                            @endif
                        </div>
                    </div>
                    <label class="block cursor-pointer rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-6 text-center text-sm font-semibold text-slate-600 hover:border-[#006b9b] hover:text-[#006b9b]">
                        Upload Foto
                        <input type="file" name="avatar" accept="image/*" class="hidden">
                    </label>
                    @error('avatar') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </section>

                <section class="rounded-3xl bg-white p-6 shadow-sm">
                    <h2 class="mb-3 text-lg font-bold text-slate-900">Portofolio</h2>
                    <p class="text-sm text-slate-600">Portofolio sebaiknya dikelola pada menu Layanan/Portfolio agar tidak duplikat data dengan profil.</p>
                    <a href="{{ route('mitra.portfolio.index') }}" class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-[#006b9b] px-4 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#00557b]">
                        Kelola Portofolio
                    </a>
                </section>
            </div>
        </div>

        <div class="flex flex-wrap justify-center gap-3 pt-2 sm:justify-end">
            <button type="submit" class="inline-flex min-w-[140px] items-center justify-center rounded-xl bg-[#006b9b] px-6 py-3 text-base font-bold text-white transition-colors hover:bg-[#00557b] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006b9b]">Simpan</button>
            <a href="{{ route('mitra.profile.show') }}" class="inline-flex min-w-[140px] items-center justify-center rounded-xl bg-[#49bef3] px-6 py-3 text-center text-base font-bold text-white transition-colors hover:bg-[#37a7da] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#49bef3]">Kembali</a>
        </div>
    </form>
</section>
@endsection
