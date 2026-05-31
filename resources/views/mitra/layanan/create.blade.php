@extends('layouts.mitra')

@section('content')
<section class="space-y-6 sm:space-y-8">
    <header>
        <div class="flex items-center gap-2 text-[#006b9b]">
            <span class="text-2xl font-bold">Layanan</span>
            <span class="text-xl">&gt;</span>
            <span class="text-2xl font-bold text-slate-900">Tambah Layanan Baru</span>
        </div>
    </header>

    <form action="{{ route('mitra.layanan.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 gap-6 lg:grid-cols-12">
        @csrf

        <section class="rounded-3xl bg-white p-6 shadow-sm lg:col-span-8">
            <div class="space-y-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-600">Nama layanan <span class="text-rose-600">*</span></label>
                        <input type="text" name="nama_layanan" value="{{ old('nama_layanan') }}" placeholder="Contoh: Service AC" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('nama_layanan') border-rose-400 @enderror">
                        @error('nama_layanan') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-600">Kategori <span class="text-rose-600">*</span></label>
                        <select name="kategori" required class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('kategori') border-rose-400 @enderror">
                            <option value="">Pilih Kategori</option>
                            <option value="KEBERSIHAN" {{ old('kategori') === 'KEBERSIHAN' ? 'selected' : '' }}>Kebersihan</option>
                            <option value="MAKANAN" {{ old('kategori') === 'MAKANAN' ? 'selected' : '' }}>Makanan</option>
                            <option value="ELEKTRONIK" {{ old('kategori') === 'ELEKTRONIK' ? 'selected' : '' }}>Elektronik</option>
                            <option value="TRANSPORTASI" {{ old('kategori') === 'TRANSPORTASI' ? 'selected' : '' }}>Transportasi</option>
                            <option value="LAINNYA" {{ old('kategori') === 'LAINNYA' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('kategori') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-600">Deskripsi Produk</label>
                    <textarea name="deskripsi" rows="6" placeholder="Berikan penjelasan detail mengenai layanan..." class="w-full resize-none rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('deskripsi') border-rose-400 @enderror">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-600">Harga Mulai</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-semibold text-[#006b9b]">Rp</span>
                            <input type="number" name="harga_mulai" value="{{ old('harga_mulai') }}" placeholder="0" step="1000" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-12 pr-4 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('harga_mulai') border-rose-400 @enderror">
                        </div>
                        @error('harga_mulai') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-600">Harga Maksimal</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 font-semibold text-[#006b9b]">Rp</span>
                            <input type="number" name="harga_max" value="{{ old('harga_max') }}" placeholder="0" step="1000" class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-12 pr-4 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('harga_max') border-rose-400 @enderror">
                        </div>
                        @error('harga_max') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-600">Satuan</label>
                        <input type="text" name="satuan" value="{{ old('satuan') }}" placeholder="Contoh: per unit" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('satuan') border-rose-400 @enderror">
                        @error('satuan') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-600">Durasi Estimasi</label>
                        <input type="text" name="durasi_estimasi" value="{{ old('durasi_estimasi') }}" placeholder="Contoh: 2 jam" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('durasi_estimasi') border-rose-400 @enderror">
                        @error('durasi_estimasi') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-600">Area Layanan</label>
                    <input type="text" name="area_layanan" value="{{ old('area_layanan') }}" placeholder="Contoh: Kota Bandung" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] @error('area_layanan') border-rose-400 @enderror">
                    @error('area_layanan') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-600">Status</label>
                    <select name="status" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2]">
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                    </select>
                </div>

                <div class="flex justify-end gap-4 border-t border-slate-200 pt-4">
                    <a href="{{ route('mitra.layanan.index') }}" class="px-6 py-3 font-semibold text-slate-600 transition-colors hover:text-[#006b9b]">Batal</a>
                    <button type="submit" class="rounded-xl bg-[#006b9b] px-8 py-3 font-bold text-white transition-colors hover:bg-[#00557b]">Simpan Data</button>
                </div>
            </div>
        </section>

        <aside class="space-y-6 lg:col-span-4">
            <section class="overflow-hidden rounded-3xl bg-white shadow-sm">
                <div class="flex h-48 items-center justify-center bg-slate-100">
                    <div id="photo-placeholder" class="flex h-32 w-2/3 flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-200">
                        <span class="text-sm font-semibold text-slate-500">Foto Layanan</span>
                    </div>
                    <img id="photo-preview" alt="Preview foto layanan" class="hidden h-48 w-full object-cover">
                </div>
                <label class="block cursor-pointer px-4 py-4 text-center font-bold text-[#006b9b] hover:bg-slate-50">
                    Unggah Foto Produk
                    <input type="file" name="foto" accept="image/*" class="hidden" onchange="previewServicePhoto(this)">
                </label>
                @error('foto') <p class="px-4 pb-4 text-xs text-rose-600">{{ $message }}</p> @enderror
            </section>

            <section class="overflow-hidden rounded-3xl bg-white shadow-sm">
                <div class="flex h-48 items-center justify-center bg-slate-100">
                    <div id="portfolio-placeholder" class="flex h-32 w-2/3 flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-200">
                        <span class="text-sm font-semibold text-slate-500">Portofolio</span>
                    </div>
                    <img id="portfolio-preview" alt="Preview foto portofolio" class="hidden h-48 w-full object-cover">
                </div>
                <label class="block cursor-pointer px-4 py-4 text-center font-bold text-[#006b9b] hover:bg-slate-50">
                    Unggah Portofolio
                    <input type="file" name="foto_cover" accept="image/*" class="hidden" onchange="previewPortfolioPhoto(this)">
                </label>
                @error('foto_cover') <p class="px-4 pb-4 text-xs text-rose-600">{{ $message }}</p> @enderror
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

function previewPortfolioPhoto(input) {
    const preview = document.getElementById('portfolio-preview');
    const placeholder = document.getElementById('portfolio-placeholder');

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
