@extends('layouts.mitra')

@section('content')
<section class="space-y-6 sm:space-y-8">
    <header class="rounded-[28px] bg-white/85 p-6 shadow-[0_10px_30px_rgba(1,51,109,0.12)] backdrop-blur sm:p-8">
        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#006b9b]/70">Manajemen Layanan</p>
        <h1 class="mt-2 text-3xl font-semibold text-black sm:text-4xl">Edit Layanan</h1>
        <p class="mt-2 max-w-2xl text-slate-600">Perbarui detail layanan tanpa mengubah sidebar mitra yang sudah konsisten.</p>
    </header>

    <div class="grid gap-6 xl:grid-cols-[1.7fr_1fr]">
        <section class="rounded-[28px] bg-white p-6 shadow-sm sm:p-8">
            <form action="{{ route('mitra.portfolio.update', $portfolio->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="space-y-2">
                        <label for="judul" class="block text-sm font-semibold text-slate-700">Nama layanan <span class="text-rose-600">*</span></label>
                        <input id="judul" name="judul" type="text" value="{{ old('judul', $portfolio->judul) }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#006b9b] focus:ring-[#006b9b]" placeholder="Contoh: Instalasi AC Split">
                        @error('judul') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label for="kategori" class="block text-sm font-semibold text-slate-700">Kategori <span class="text-rose-600">*</span></label>
                        <select id="kategori" name="kategori" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#006b9b] focus:ring-[#006b9b]">
                            <option value="">Pilih kategori</option>
                            <option value="Instalasi AC" @selected(old('kategori', $portfolio->kategori) === 'Instalasi AC')>Instalasi AC</option>
                            <option value="Instalasi Listrik" @selected(old('kategori', $portfolio->kategori) === 'Instalasi Listrik')>Instalasi Listrik</option>
                            <option value="Service AC" @selected(old('kategori', $portfolio->kategori) === 'Service AC')>Service AC</option>
                            <option value="Elektronik" @selected(old('kategori', $portfolio->kategori) === 'Elektronik')>Elektronik</option>
                            <option value="Keamanan" @selected(old('kategori', $portfolio->kategori) === 'Keamanan')>Keamanan</option>
                            <option value="Lainnya" @selected(old('kategori', $portfolio->kategori) === 'Lainnya')>Lainnya</option>
                        </select>
                        @error('kategori') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="deskripsi" class="block text-sm font-semibold text-slate-700">Deskripsi</label>
                    <textarea id="deskripsi" name="deskripsi" rows="5" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#006b9b] focus:ring-[#006b9b]" placeholder="Jelaskan layanan secara singkat dan jelas">{{ old('deskripsi', $portfolio->deskripsi) }}</textarea>
                    @error('deskripsi') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="space-y-2">
                        <label for="client_name" class="block text-sm font-semibold text-slate-700">Nama Klien</label>
                        <input id="client_name" name="client_name" type="text" value="{{ old('client_name', $portfolio->client_name) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#006b9b] focus:ring-[#006b9b]" placeholder="Opsional">
                    </div>
                    <div class="space-y-2">
                        <label for="lokasi" class="block text-sm font-semibold text-slate-700">Lokasi</label>
                        <input id="lokasi" name="lokasi" type="text" value="{{ old('lokasi', $portfolio->lokasi) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#006b9b] focus:ring-[#006b9b]" placeholder="Opsional">
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="space-y-2">
                        <label for="tanggal_project" class="block text-sm font-semibold text-slate-700">Tanggal Project</label>
                        <input id="tanggal_project" name="tanggal_project" type="date" value="{{ old('tanggal_project', optional($portfolio->tanggal_project)->format('Y-m-d')) }}" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#006b9b] focus:ring-[#006b9b]">
                    </div>
                    <div class="space-y-2">
                        <label for="nilai_project" class="block text-sm font-semibold text-slate-700">Nilai Project</label>
                        <input id="nilai_project" name="nilai_project" type="number" value="{{ old('nilai_project', $portfolio->nilai_project) }}" min="0" step="1000" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#006b9b] focus:ring-[#006b9b]" placeholder="0">
                    </div>
                </div>

                <div class="grid gap-5 md:grid-cols-2">
                    <div class="space-y-2">
                        <label for="durasi_hari" class="block text-sm font-semibold text-slate-700">Durasi (Hari)</label>
                        <input id="durasi_hari" name="durasi_hari" type="number" value="{{ old('durasi_hari', $portfolio->durasi_hari) }}" min="0" class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-[#006b9b] focus:ring-[#006b9b]" placeholder="0">
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="foto_cover" class="block text-sm font-semibold text-slate-700">Foto Cover (opsional)</label>
                    @if($portfolio->foto_cover)
                        <img src="{{ $portfolio->foto_cover }}" alt="cover" class="mb-2 max-h-40 w-full object-cover rounded-xl" />
                    @endif
                    <input id="foto_cover" name="foto_cover" type="file" accept="image/*" class="w-full rounded-xl border border-slate-300 px-2 py-2 focus:border-[#006b9b] focus:ring-[#006b9b]">
                    @error('foto_cover') <p class="text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>
                <div class="flex flex-col-reverse gap-3 pt-3 sm:flex-row sm:justify-end">
                    <a href="{{ route('mitra.portfolio.index') }}" class="inline-flex justify-center rounded-xl border border-slate-300 px-5 py-3 font-semibold text-slate-700 transition-colors hover:bg-slate-100">Batal</a>
                    <button type="submit" class="inline-flex justify-center rounded-xl bg-[#006b9b] px-5 py-3 font-semibold text-white transition-colors hover:bg-[#00557b]">Simpan Perubahan</button>
                </div>
            </form>
        </section>

        <aside class="space-y-6">
            <div class="rounded-[28px] bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900">Perhatian</h2>
                <p class="mt-3 text-sm leading-6 text-slate-600">Pastikan kategori dan judul tetap konsisten dengan data layanan yang sedang dijual.</p>
            </div>
        </aside>
    </div>
</section>
@endsection