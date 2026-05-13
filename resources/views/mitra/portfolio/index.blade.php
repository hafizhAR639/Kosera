@extends('layouts.mitra')

@section('content')
<section class="space-y-6">
    @php
    $filters = $filters ?? ['category' => 'all', 'q' => '', 'page' => 1, 'total' => 0, 'totalPages' => 1];
    $selectedCategory = $filters['category'] ?? 'all';
    $searchQuery = $filters['q'] ?? '';
    $currentPage = (int)($filters['page'] ?? 1);
    $totalPages = (int)($filters['totalPages'] ?? 1);
    $totalItems = (int)($filters['total'] ?? 0);
    @endphp

    <header class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-3xl font-bold text-slate-900">Portfolio</h1>
        <button class="rounded-xl bg-sky-700 px-4 py-2 font-semibold text-white hover:bg-sky-800" onclick="openModal('add')">+ Tambah Portfolio</button>
    </header>

    @if (!empty($message))
        <p role="alert" class="rounded-xl border px-4 py-3 text-sm {{ $message['type'] === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' }}">
            {{ $message['text'] }}
        </p>
    @endif

    <form method="GET" action="{{ route('mitra.portfolio.index') }}" class="grid gap-3 rounded-2xl bg-white p-4 shadow-sm md:grid-cols-2">
        <select id="filterKategori" name="category" class="rounded-lg border border-slate-300 px-3 py-2">
            <option value="all" {{ $selectedCategory === 'all' ? 'selected' : '' }}>Semua Kategori</option>
            <option value="instalasi_ac" {{ $selectedCategory === 'instalasi_ac' ? 'selected' : '' }}>Instalasi AC</option>
            <option value="service_ac" {{ $selectedCategory === 'service_ac' ? 'selected' : '' }}>Service AC</option>
            <option value="instalasi_listrik" {{ $selectedCategory === 'instalasi_listrik' ? 'selected' : '' }}>Instalasi Listrik</option>
            <option value="perbaikan_elektronik" {{ $selectedCategory === 'perbaikan_elektronik' ? 'selected' : '' }}>Perbaikan Elektronik</option>
            <option value="lainnya" {{ $selectedCategory === 'lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>
        <div class="flex gap-2">
            <input id="searchInput" name="q" type="text" value="{{ $searchQuery }}" placeholder="Cari portfolio..." class="w-full rounded-lg border border-slate-300 px-3 py-2">
            <button type="submit" class="rounded-lg bg-sky-700 px-4 py-2 font-semibold text-white">Filter</button>
        </div>
    </form>

    <div id="portfolioGrid" class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($portfolios as $item)
            <article class="portfolio-card rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <figure class="mb-4 h-36 rounded-xl bg-gradient-to-br from-sky-100 to-cyan-100"></figure>
                <h3 class="text-lg font-bold text-slate-900">{{ $item['title'] }}</h3>
                <p class="mt-2 text-sm text-slate-600">{{ substr($item['description'], 0, 140) }}...</p>
                <div class="mt-3 space-y-1 text-sm text-slate-600">
                    <p>{{ $item['client_name'] }} · {{ $item['location'] }}</p>
                    <p>{{ \App\Helpers\FormatHelper::date($item['project_date']) }}</p>
                    <p>{{ \App\Helpers\FormatHelper::rupiah($item['project_value']) }}</p>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <button class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-semibold text-slate-700 hover:bg-slate-100" onclick="editPortfolio({{ $item['id'] }})">Edit</button>
                    <button class="rounded-lg border border-rose-200 px-3 py-1.5 text-sm font-semibold text-rose-700 hover:bg-rose-50" onclick="deletePortfolio({{ $item['id'] }})">Hapus</button>
                </div>
            </article>
        @empty
            <p class="rounded-2xl border border-slate-200 bg-white p-6 text-center text-slate-600">
                Data portfolio tidak ditemukan untuk filter saat ini.
            </p>
        @endforelse
    </div>

    <nav aria-label="Pagination" class="flex flex-wrap items-center justify-between gap-3 rounded-2xl bg-white p-4 text-sm shadow-sm">
        <p class="text-slate-600">Total: <span class="font-semibold text-slate-900">{{ $totalItems }}</span> data</p>
        <div class="flex items-center gap-2">
            @php
            $baseQuery = ['category' => $selectedCategory, 'q' => $searchQuery];
            $prevPage = max(1, $currentPage - 1);
            $nextPage = min($totalPages, $currentPage + 1);
            @endphp
            <a class="rounded-lg border border-slate-300 px-3 py-1.5 {{ $currentPage <= 1 ? 'pointer-events-none opacity-50' : '' }}" href="{{ route('mitra.portfolio.index', $baseQuery + ['page' => $prevPage]) }}">Sebelumnya</a>
            <span class="font-semibold text-slate-700">Halaman {{ $currentPage }} / {{ $totalPages }}</span>
            <a class="rounded-lg border border-slate-300 px-3 py-1.5 {{ $currentPage >= $totalPages ? 'pointer-events-none opacity-50' : '' }}" href="{{ route('mitra.portfolio.index', $baseQuery + ['page' => $nextPage]) }}">Berikutnya</a>
        </div>
    </nav>
</section>

<div id="portfolioModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="w-full max-w-3xl rounded-2xl bg-white shadow-2xl">
        <header class="flex items-center justify-between rounded-t-2xl bg-sky-700 px-5 py-4 text-white">
            <h2 id="modalTitle" class="text-xl font-bold">Tambah Portfolio</h2>
            <button class="text-2xl" onclick="closeModal()">&times;</button>
        </header>

        <form id="portfolioForm" method="POST" action="{{ route('mitra.portfolio.store') }}" class="space-y-4 p-5">
            @csrf
            <input type="hidden" name="id" id="portfolioId">

            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Judul Project</label>
                <input type="text" id="judul" name="title" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Deskripsi</label>
                <textarea id="deskripsi" name="description" rows="4" required class="w-full rounded-lg border border-slate-300 px-3 py-2"></textarea>
            </div>
            <div class="grid gap-3 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Kategori</label>
                    <select id="kategori" name="category" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                        <option value="">Pilih Kategori</option>
                        <option value="instalasi_ac">Instalasi AC</option>
                        <option value="service_ac">Service AC</option>
                        <option value="instalasi_listrik">Instalasi Listrik</option>
                        <option value="perbaikan_elektronik">Perbaikan Elektronik</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Tanggal Project</label>
                    <input type="date" id="tanggal_project" name="project_date" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
            </div>
            <div class="grid gap-3 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nama Klien</label>
                    <input type="text" id="client_name" name="client_name" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Lokasi</label>
                    <input type="text" id="lokasi" name="location" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
            </div>
            <div class="grid gap-3 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nilai Project</label>
                    <input type="number" id="nilai_project" name="project_value" min="0" step="1000" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Durasi (hari)</label>
                    <input type="number" id="durasi_hari" name="duration_days" min="1" class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
            </div>
            <footer class="flex justify-end gap-2 pt-2">
                <button type="button" class="rounded-lg bg-slate-100 px-4 py-2 font-semibold text-slate-700" onclick="closeModal()">Batal</button>
                <button type="submit" class="rounded-lg bg-sky-700 px-4 py-2 font-semibold text-white hover:bg-sky-800">Simpan</button>
            </footer>
        </form>
    </div>
</div>

<script>
    function openModal(mode) {
        document.getElementById('portfolioModal').classList.remove('hidden');
        document.getElementById('portfolioModal').classList.add('flex');
        if (mode === 'add') {
            document.getElementById('modalTitle').textContent = 'Tambah Portfolio';
            document.getElementById('portfolioForm').action = '{{ route("mitra.portfolio.store") }}';
            document.getElementById('portfolioForm').reset();
            document.getElementById('portfolioId').value = '';
        }
    }

    function closeModal() {
        document.getElementById('portfolioModal').classList.add('hidden');
        document.getElementById('portfolioModal').classList.remove('flex');
    }

    function editPortfolio(id) {
        openModal('edit');
        document.getElementById('modalTitle').textContent = 'Edit Portfolio';
        document.getElementById('portfolioForm').action = '{{ route("mitra.portfolio.update") }}';
        document.getElementById('portfolioId').value = id;
    }

    function deletePortfolio(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus portfolio ini?')) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("mitra.portfolio.delete") }}';
        form.innerHTML = `<input type="hidden" name="id" value="${id}"><input type="hidden" name="_token" value="{{ csrf_token() }}">`;
        document.body.appendChild(form);
        form.submit();
    }
</script>
@endsection
