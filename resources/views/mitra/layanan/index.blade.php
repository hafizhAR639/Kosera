@extends('layouts.mitra')

@section('content')
<style>
    .custom-radio {
        appearance: none;
        width: 24px;
        height: 24px;
        border: 1.5px solid #D1D5DB;
        border-radius: 9999px;
        background-color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        flex-shrink: 0;
    }

    .custom-radio:checked {
        border-color: #BE1E1E;
    }

    .custom-radio:checked::after {
        content: '';
        width: 14px;
        height: 14px;
        background-color: #BE1E1E;
        border-radius: 9999px;
        display: block;
    }
</style>

<section class="space-y-6 sm:space-y-8">
    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            {{ session('success') }}
        </div>
    @endif

    <header class="rounded-[28px] bg-white/85 p-6 shadow-[0_10px_30px_rgba(1,51,109,0.12)] backdrop-blur sm:p-8">
        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#006b9b]/70">Manajemen Layanan</p>
        <h1 class="mt-2 text-3xl font-semibold text-black sm:text-4xl">Layanan Mitra</h1>
        <p class="mt-2 max-w-2xl text-slate-600">Kelola semua layanan Anda dari satu halaman dengan tampilan sidebar yang konsisten seperti dashboard.</p>
    </header>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <a href="{{ route('mitra.layanan.create') }}" class="inline-flex items-center justify-center rounded-xl bg-[#006b9b] px-5 py-3 font-semibold text-white transition-colors hover:bg-[#00557b] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#006b9b]">
                Tambah Layanan
            </a>

            <form method="GET" action="{{ route('mitra.layanan.index') }}" class="w-full sm:w-auto">
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari Layanan"
                    class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-[#006b9b] focus:outline-none focus:ring-2 focus:ring-[#b3dff2] sm:w-64"
                >
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="border-b border-slate-100 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        <th class="py-3 pr-4">No</th>
                        <th class="py-3 pr-4">Nama Layanan</th>
                        <th class="py-3 pr-4">Kategori</th>
                        <th class="py-3 pr-4">Harga</th>
                        <th class="py-3 pr-4">Status</th>
                        <th class="py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr class="border-b border-slate-100 hover:bg-slate-50">
                            <td class="py-4 pr-4 text-slate-500">{{ ($services->currentPage() - 1) * $services->perPage() + $loop->iteration }}</td>
                            <td class="py-4 pr-4 font-semibold text-slate-800">{{ $service->nama_layanan }}</td>
                            <td class="py-4 pr-4">
                                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">{{ $service->kategori }}</span>
                            </td>
                            <td class="py-4 pr-4 font-medium text-slate-700">
                                @if($service->harga_mulai && $service->harga_max)
                                    Rp {{ number_format($service->harga_mulai, 0, ',', '.') }} - Rp {{ number_format($service->harga_max, 0, ',', '.') }}
                                @elseif($service->harga_mulai)
                                    Rp {{ number_format($service->harga_mulai, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td class="py-4 pr-4">
                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $service->status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                    {{ $service->status === 'active' ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('mitra.layanan.edit', $service->id) }}" class="rounded-lg bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700 transition-colors hover:bg-blue-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-blue-600">Edit</a>
                                    <button
                                        type="button"
                                        class="rounded-lg bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 transition-colors hover:bg-rose-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-rose-600"
                                        onclick="openDeleteModal({{ $service->id }}, @js($service->nama_layanan))"
                                    >
                                        Tolak
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-slate-500">
                                Belum ada layanan.
                                <a href="{{ route('mitra.layanan.create') }}" class="font-semibold text-[#006b9b] hover:underline">Tambah sekarang</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($services->hasPages())
            <div class="mt-6 border-t border-slate-100 pt-4">
                {{ $services->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</section>

<div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/45 p-4">
    <main class="w-full max-w-[488px] rounded-xl bg-white p-8 shadow-[0_20px_25px_-5px_rgba(0,0,0,0.1),0_10px_10px_-5px_rgba(0,0,0,0.04)]">
        <section class="mb-6">
            <h1 class="mb-4 text-2xl font-bold text-slate-900">Tolak Layanan?</h1>
            <p class="text-[15px] leading-relaxed text-slate-600">Silakan pilih alasan penolakan untuk membantu kami meningkatkan layanan.</p>
        </section>

        <form id="deleteForm" method="POST" class="space-y-3">
            @csrf
            @method('DELETE')
            <input type="hidden" name="reason" id="deleteReason" value="jadwal_tidak_sesuai">
            <input type="hidden" name="note" id="deleteNoteValue" value="">

            <label class="flex items-center gap-3 rounded-lg bg-[#EFF1F9] p-4 transition-all border-2 border-transparent cursor-pointer hover:border-[#BE1E1E]/15">
                <input class="custom-radio" name="reason_option" type="radio" value="jadwal_tidak_sesuai" checked>
                <span class="font-medium text-slate-900">Jadwal Tidak Sesuai</span>
            </label>

            <label class="flex items-center gap-3 rounded-lg bg-[#EFF1F9] p-4 transition-all border-2 border-transparent cursor-pointer hover:border-[#BE1E1E]/15">
                <input class="custom-radio" name="reason_option" type="radio" value="lainnya">
                <span class="font-medium text-slate-900">Lainnya</span>
            </label>

            <div class="mt-4">
                <textarea id="deleteNote" class="w-full resize-none rounded-lg border border-[#D1D5DB] bg-[#EFF1F9] p-4 text-slate-900 placeholder:text-[#9CA3AF] focus:border-[#BE1E1E] focus:outline-none focus:ring-1 focus:ring-[#BE1E1E] transition-all" placeholder="Tulis alasan penolakan (opsional)" rows="4"></textarea>
            </div>

            <section class="mt-10 flex flex-col items-center gap-6">
                <button class="w-full rounded-full bg-[#BE1E1E] py-4 font-bold text-white shadow-lg transition-colors hover:bg-red-800" type="submit">
                    Konfirmasi Penolakan
                </button>
                <button class="text-lg font-bold text-[#0055D3] hover:underline decoration-2 underline-offset-4" type="button" onclick="closeDeleteModal()">
                    Kembali
                </button>
            </section>
        </form>
    </main>
</div>

<script>
    const deleteModal = document.getElementById('deleteModal');
    const deleteForm = document.getElementById('deleteForm');
    const deleteReason = document.getElementById('deleteReason');
    const deleteNote = document.getElementById('deleteNote');
    const deleteNoteValue = document.getElementById('deleteNoteValue');
    const deleteBaseUrl = @json(url('/mitra/layanan'));

    function openDeleteModal(id, title) {
        deleteModal.classList.remove('hidden');
        deleteModal.classList.add('flex');
        deleteForm.action = `${deleteBaseUrl}/${id}`;
        deleteForm.dataset.title = title;
        deleteReason.value = 'jadwal_tidak_sesuai';
        deleteNote.value = '';
        deleteNoteValue.value = '';
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

    deleteForm.addEventListener('submit', () => {
        const selectedReason = deleteForm.querySelector('input[name="reason_option"]:checked');
        deleteReason.value = selectedReason ? selectedReason.value : 'lainnya';
        deleteNoteValue.value = deleteNote.value || '';
        closeDeleteModal();
    });
</script>
@endsection
