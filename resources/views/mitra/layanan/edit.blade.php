@extends('layouts.mitra')

@section('content')
<section class="space-y-6 sm:space-y-8">
    <header>
        <div class="flex flex-wrap items-center gap-3 text-[#006b9b]">
            <a href="{{ route('mitra.layanan.index') }}" class="inline-flex items-center gap-2 rounded-xl bg-white px-4 py-2 text-sm font-semibold text-[#006b9b] shadow-sm ring-1 ring-slate-200 transition-colors hover:bg-slate-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006b9b]">
                <span>&larr;</span>
                Kembali ke Layanan
            </a>
            <div class="flex items-center gap-2">
                <span class="text-2xl font-bold">Layanan</span>
                <span class="text-xl">&gt;</span>
                <span class="text-2xl font-bold text-slate-900">Edit Layanan</span>
            </div>
        </div>
    </header>

    <form action="{{ route('mitra.layanan.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        @csrf
        @method('PUT')

        <section class="rounded-3xl bg-white p-6 shadow-sm lg:col-span-8">
            <div class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-600">Nama layanan <span class="text-rose-600">*</span></label>
                        <input type="text" name="nama_layanan" value="{{ old('nama_layanan', $service->nama_layanan) }}" placeholder="Contoh: Service AC" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('nama_layanan') border-rose-400 @enderror">
                        @error('nama_layanan') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-600">Kategori <span class="text-rose-600">*</span></label>
                        <select name="kategori" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('kategori') border-rose-400 @enderror">
                            <option value="">Pilih Kategori</option>
                            <option value="KEBERSIHAN" {{ old('kategori', $service->kategori) === 'KEBERSIHAN' ? 'selected' : '' }}>Kebersihan</option>
                            <option value="MAKANAN" {{ old('kategori', $service->kategori) === 'MAKANAN' ? 'selected' : '' }}>Makanan</option>
                            <option value="ELEKTRONIK" {{ old('kategori', $service->kategori) === 'ELEKTRONIK' ? 'selected' : '' }}>Elektronik</option>
                            <option value="TRANSPORTASI" {{ old('kategori', $service->kategori) === 'TRANSPORTASI' ? 'selected' : '' }}>Transportasi</option>
                            <option value="LAINNYA" {{ old('kategori', $service->kategori) === 'LAINNYA' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-600">Deskripsi Produk</label>
                    <textarea name="deskripsi" rows="6" placeholder="Berikan penjelasan detail mengenai layanan..." class="w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('deskripsi') border-rose-400 @enderror">{{ old('deskripsi', $service->deskripsi) }}</textarea>
                    @error('deskripsi') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-600">Harga Mulai</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-semibold text-[#006b9b]">Rp</span>
                            <input type="number" name="harga_mulai" value="{{ old('harga_mulai', $service->harga_mulai) }}" placeholder="0" step="1000" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-12 pr-4 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('harga_mulai') border-rose-400 @enderror">
                        </div>
                        @error('harga_mulai') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-600">Harga Maksimal</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-semibold text-[#006b9b]">Rp</span>
                            <input type="number" name="harga_max" value="{{ old('harga_max', $service->harga_max) }}" placeholder="0" step="1000" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-12 pr-4 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('harga_max') border-rose-400 @enderror">
                        </div>
                        @error('harga_max') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-600">Satuan</label>
                        <input type="text" name="satuan" value="{{ old('satuan', $service->satuan) }}" placeholder="Contoh: per unit" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('satuan') border-rose-400 @enderror">
                        @error('satuan') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-600">Durasi Estimasi</label>
                        <input type="text" name="durasi_estimasi" value="{{ old('durasi_estimasi', $service->durasi_estimasi) }}" placeholder="Contoh: 2 jam" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('durasi_estimasi') border-rose-400 @enderror">
                        @error('durasi_estimasi') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-600">Area Layanan</label>
                    <input type="text" name="area_layanan" value="{{ old('area_layanan', $service->area_layanan) }}" placeholder="Contoh: Kota Bandung" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('area_layanan') border-rose-400 @enderror">
                    @error('area_layanan') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-600">Status</label>
                    <select name="status" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2]">
                        <option value="active" {{ old('status', $service->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status', $service->status) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="flex justify-end gap-4 border-t border-slate-200 pt-4">
                    <a href="{{ route('mitra.layanan.index') }}" class="inline-flex items-center justify-center rounded-xl px-6 py-3 font-semibold text-slate-600 transition-colors hover:bg-slate-50 hover:text-[#006b9b] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006b9b]">Batal</a>
                    <button type="submit" class="rounded-xl bg-[#006b9b] px-8 py-3 font-bold text-white transition-colors hover:bg-[#00557b]">Simpan Perubahan</button>
                </div>
            </div>
        </section>

        <aside class="space-y-6 lg:col-span-4">
            <section class="overflow-hidden rounded-3xl bg-white shadow-sm">
                <div class="flex h-48 items-center justify-center bg-slate-100">
                    <div id="photo-placeholder" class="{{ !empty($service->foto) ? 'hidden ' : '' }}flex h-32 w-2/3 flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-200">
                        <span class="text-sm font-semibold text-slate-500">Foto Layanan</span>
                    </div>
                    <img id="photo-preview" src="{{ $service->foto ?? '' }}" alt="Preview foto layanan" class="{{ !empty($service->foto) ? '' : 'hidden ' }}h-48 w-full object-cover">
                </div>
                <label class="block cursor-pointer px-4 py-4 text-center font-bold text-[#006b9b] hover:bg-slate-50">
                    Unggah Foto Produk
                    <input type="file" name="foto" accept="image/*" class="hidden" onchange="previewServicePhoto(this)">
                </label>
                @error('foto') <p class="px-4 pb-4 text-xs text-rose-600">{{ $message }}</p> @enderror
            </section>

            <section class="rounded-3xl border border-[#006b9b]/15 bg-[#006b9b]/5 p-5">
                <h3 class="text-sm font-bold text-[#006b9b]">Portofolio terpisah dari layanan</h3>
                <p class="mt-2 text-sm text-slate-600">Portofolio dikelola di menu Portfolio supaya dokumentasi project tetap rapi dan tidak tercampur dengan data produk layanan.</p>
                <a href="{{ route('mitra.portfolio.index') }}" class="mt-4 inline-flex w-full items-center justify-center rounded-xl bg-white px-4 py-2.5 text-sm font-semibold text-[#006b9b] ring-1 ring-[#006b9b]/25 transition-colors hover:bg-[#eaf6fc]">
                    Buka Portfolio
                </a>
            </section>
        </aside>
    </form>
</section>

<script>
function previewServicePhoto(input) {
  const preview = document.getElementById('photo-preview');
  const placeholder = document.getElementById('photo-placeholder');

  if (input.files && input.files[0]) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
      preview.classList.remove('hidden');
      placeholder.classList.add('hidden');
    };
    reader.readAsDataURL(input.files[0]);
  }
}
</script>
@endsection
