@extends('layouts.mitra')

@section('content')
@php
    $selectedCategory = request('category', 'all');
    $searchQuery = request('q', '');
    $paginator = $portfolios->appends(request()->query());
@endphp

<section class="space-y-6 sm:space-y-8">
    <header class="flex flex-col gap-4 rounded-[28px] bg-white/85 p-6 shadow-[0_10px_30px_rgba(1,51,109,0.12)] backdrop-blur sm:flex-row sm:items-center sm:justify-between sm:p-8">
        <div>
            <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#006b9b]/70">Manajemen Layanan</p>
            <h1 class="mt-2 text-3xl font-semibold text-black sm:text-4xl">Daftar Layanan</h1>
            <p class="mt-2 max-w-2xl text-slate-600">Kelola layanan mitra dengan sidebar yang tetap konsisten, edit dari halaman terpisah, dan hapus lewat popup konfirmasi.</p>
        </div>
        <a href="{{ route('mitra.portfolio.create') }}" class="inline-flex items-center justify-center rounded-xl bg-[#006b9b] px-5 py-3 font-semibold text-white transition-colors hover:bg-[#00557b]">
            + Tambah Layanan
        </a>
    </header>

    <form method="GET" action="{{ route('mitra.portfolio.index') }}" class="grid gap-3 rounded-[24px] bg-white p-4 shadow-sm md:grid-cols-[220px_1fr_auto]">
        <select name="category" class="rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-700 focus:border-[#006b9b] focus:ring-[#006b9b]">
            <option value="all" {{ $selectedCategory === 'all' ? 'selected' : '' }}>Semua Kategori</option>
            <option value="Instalasi AC" {{ $selectedCategory === 'Instalasi AC' ? 'selected' : '' }}>Instalasi AC</option>
            <option value="Instalasi Listrik" {{ $selectedCategory === 'Instalasi Listrik' ? 'selected' : '' }}>Instalasi Listrik</option>
            <option value="Service AC" {{ $selectedCategory === 'Service AC' ? 'selected' : '' }}>Service AC</option>
            <option value="Elektronik" {{ $selectedCategory === 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
            <option value="Keamanan" {{ $selectedCategory === 'Keamanan' ? 'selected' : '' }}>Keamanan</option>
            <option value="Lainnya" {{ $selectedCategory === 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
        </select>
        <input name="q" value="{{ $searchQuery }}" type="text" placeholder="Cari layanan..." class="rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-[#006b9b] focus:ring-[#006b9b]">
        <button type="submit" class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-[#006b9b]">Filter</button>
    </form>

    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        @forelse ($portfolios as $item)
            <article class="overflow-hidden rounded-[28px] bg-white shadow-[0_12px_34px_rgba(0,0,0,0.08)] transition-transform hover:-translate-y-0.5">
                @if($item->foto_cover)
                    <img src="{{ asset('storage/' . $item->foto_cover) }}" alt="cover" class="h-40 w-full object-cover" />
                @else
                    <div class="h-40 bg-gradient-to-br from-[#e1f0ff] via-[#d7ebfb] to-[#cde5ff]"></div>
                @endif
                <div class="space-y-3 p-5">
                    <div class="flex items-start justify-between gap-3">
                        <h3 class="text-lg font-semibold text-slate-900">{{ $item->judul }}</h3>
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">{{ ucfirst($item->status ?? 'published') }}</span>
                    </div>
                    <p class="line-clamp-3 text-sm text-slate-600">{{ $item->deskripsi ?: 'Belum ada deskripsi layanan.' }}</p>
                    <div class="space-y-1 text-sm text-slate-600">
                        <p>{{ $item->kategori ?: '-' }} · {{ $item->client_name ?: '-' }}</p>
                        <p>{{ $item->lokasi ?: '-' }}</p>
                        <p>{{ \App\Helpers\FormatHelper::date($item->tanggal_project) }}</p>
                        <p class="font-semibold text-slate-900">{{ \App\Helpers\FormatHelper::rupiah($item->nilai_project ?? 0) }}</p>
                    </div>
                    <div class="flex items-center gap-2 pt-2">
                        <a href="{{ route('mitra.portfolio.edit', $item->id) }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-100">Edit</a>
                        <button type="button" class="rounded-xl border border-rose-200 px-4 py-2 text-sm font-semibold text-rose-700 transition-colors hover:bg-rose-50" onclick="openDeleteModal({{ $item->id }}, @js($item->judul))">Hapus</button>
                    </div>
                </div>
            </article>
        @empty
            <p class="rounded-[24px] border border-dashed border-slate-300 bg-white p-8 text-center text-slate-500 md:col-span-2 xl:col-span-3">Belum ada layanan yang ditambahkan.</p>
        @endforelse
    </div>

    <nav aria-label="Pagination" class="flex flex-col gap-3 rounded-[24px] bg-white p-4 text-sm shadow-sm sm:flex-row sm:items-center sm:justify-between">
        <p class="text-slate-600">Total: <span class="font-semibold text-slate-900">{{ $paginator->total() }}</span> data</p>
        <div class="flex items-center gap-2">
            <a class="rounded-lg border border-slate-300 px-3 py-1.5 {{ $paginator->onFirstPage() ? 'pointer-events-none opacity-50' : '' }}" href="{{ $paginator->previousPageUrl() ?: '#' }}">Sebelumnya</a>
            <span class="font-semibold text-slate-700">Halaman {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}</span>
            <a class="rounded-lg border border-slate-300 px-3 py-1.5 {{ $paginator->hasMorePages() ? '' : 'pointer-events-none opacity-50' }}" href="{{ $paginator->nextPageUrl() ?: '#' }}">Berikutnya</a>
        </div>
    </nav>
</section>

<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/45 p-4">
    <div class="w-full max-w-md rounded-[28px] bg-white p-6 shadow-2xl">
        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-rose-100 text-rose-700">
            <span class="text-3xl font-bold">!</span>
        </div>
        <h2 class="text-center text-2xl font-semibold text-slate-900">Hapus Layanan?</h2>
        <p class="mt-3 text-center text-sm leading-6 text-slate-600">Layanan <span id="deleteModalTitle" class="font-semibold text-slate-900"></span> akan dihapus permanen. Tindakan ini tidak bisa dibatalkan.</p>

        <form id="deleteForm" method="POST" class="mt-6 flex flex-col gap-3 sm:flex-row">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()" class="flex-1 rounded-xl border border-slate-300 px-4 py-3 font-semibold text-slate-700 transition-colors hover:bg-slate-100">Batal</button>
            <button type="submit" class="flex-1 rounded-xl bg-rose-600 px-4 py-3 font-semibold text-white transition-colors hover:bg-rose-700">Hapus Sekarang</button>
        </form>
    </div>
</div>

<script>
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const deleteModalTitle = document.getElementById('deleteModalTitle');
    const deleteBaseUrl = @json(url('/mitra/portfolio'));

    function openDeleteModal(id, title) {
        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');
        deleteModalTitle.textContent = title;
        deleteForm.action = `${deleteBaseUrl}/${id}`;
    }

    function closeDeleteModal() {
        deleteModal.classList.add('hidden');
        deleteModal.classList.remove('flex');
    }

    deleteModal.addEventListener('click', (event) => {
        if (event.target === deleteModal) {
            closeDeleteModal();
        }
    });
</script>
@endsection
