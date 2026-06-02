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

<section class="space-y-8 pb-8">
    <header class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="relative">
                <i class="ti ti-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-lg"></i>
                <input type="text" placeholder="Cari Pesanan" class="pl-11 pr-4 py-2.5 w-72 rounded-xl bg-white shadow-sm border border-transparent focus:border-kosera-400 focus:ring-2 focus:ring-kosera-100 outline-none transition text-sm font-600 text-slate-700 placeholder:text-slate-400">
            </div>
            <button class="w-10 h-10 flex items-center justify-center bg-white rounded-xl shadow-sm text-slate-600 hover:text-kosera-700 transition" type="button">
                <i class="ti ti-filter text-xl"></i>
            </button>
        </div>
    </header>

    @if (!empty($message))
        <p role="alert" class="rounded-xl border px-4 py-3 text-sm {{ $message['type'] === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' }}">
            {{ $message['text'] }}
        </p>
    @endif

    <div>
        <h2 class="text-kosera-900 font-800 text-lg mb-6">Pesanan Baru</h2>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
            @forelse ($orders as $order)
                <article class="bg-white rounded-[24px] p-6 shadow-sm relative pt-8">
                    <div class="absolute -top-3 right-1/4 translate-x-1/2 bg-kosera-700 text-white text-[10px] font-800 px-4 py-1.5 rounded-lg tracking-wide">
                        {{ strtoupper($order['service_type'] ?? 'LAYANAN') }}
                    </div>

                    <div class="flex items-start gap-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($order['customer_name']) }}&background=random" alt="{{ $order['customer_name'] }}" class="w-14 h-14 rounded-full object-cover">

                        <div class="flex-1">
                            <h3 class="font-800 text-kosera-900 text-sm mb-2">{{ $order['customer_name'] }}</h3>

                            <div class="flex flex-col gap-1.5 text-xs font-600 text-slate-600">
                                <div class="flex items-start gap-2">
                                    <i class="ti ti-map-pin text-kosera-600 text-sm shrink-0"></i>
                                    <span>{{ $order['address'] ?? 'Alamat belum tersedia' }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ti ti-tool text-kosera-600 text-sm shrink-0"></i>
                                    <span>{{ $order['service_name'] }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ti ti-wallet text-kosera-600 text-sm shrink-0"></i>
                                    <span>{{ \App\Helpers\FormatHelper::rupiah($order['total_price']) }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="ti ti-calendar-time text-kosera-600 text-sm shrink-0"></i>
                                    <span>{{ \App\Helpers\FormatHelper::date($order['order_date']) }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-3 mt-5">
                                @if ($order['status'] === 'pending')
                                    <form method="POST" action="{{ route('mitra.orders.incoming.status') }}">
                                        @csrf
                                        <input type="hidden" name="action" value="accept">
                                        <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                                        <button class="px-5 py-1.5 rounded-lg border border-emerald-500 text-emerald-500 text-xs font-800 hover:bg-emerald-50 transition" type="submit">Terima</button>
                                    </form>
                                    <button type="button" class="px-5 py-1.5 rounded-lg border border-red-500 text-red-500 text-xs font-800 hover:bg-red-50 transition focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500" onclick="openRejectModal({{ $order['id'] }}, @js($order['customer_name']), @js($order['service_name']))">Tolak</button>
                                @else
                                    <a href="{{ route('mitra.orders.history') }}" class="px-5 py-1.5 rounded-lg border border-kosera-700 text-kosera-700 text-xs font-800 hover:bg-kosera-50 transition">Lihat Riwayat</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <p class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-slate-500 xl:col-span-2">Belum ada orderan masuk saat ini.</p>
            @endforelse
        </div>
    </div>
</section>

<div id="rejectModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4 backdrop-blur-[4px]">
    <main class="w-full max-w-[488px] rounded-xl bg-white p-8 shadow-[0_20px_25px_-5px_rgba(0,0,0,0.1),0_10px_10px_-5px_rgba(0,0,0,0.04)]">
        <section class="mb-6">
            <h1 class="mb-4 text-2xl font-bold text-[#111827]">Batalkan Pesanan?</h1>
            <p class="text-[15px] leading-relaxed text-[#6B7280]">Silakan pilih alasan penolakan untuk membantu kami meningkatkan layanan.</p>
        </section>

        <form id="rejectForm" method="POST" action="{{ route('mitra.orders.incoming.status') }}" class="space-y-3">
            @csrf
            <input type="hidden" name="action" value="reject">
            <input type="hidden" name="order_id" id="rejectOrderId" value="">
            <input type="hidden" name="reason" id="rejectReason" value="salah_input">
            <input type="hidden" name="note" id="rejectNoteValue" value="">

            <label class="flex items-center gap-3 rounded-lg border-2 border-transparent bg-[#EFF1F9] p-4 transition-all cursor-pointer">
                <input checked class="custom-radio" name="reason_option" type="radio" value="salah_input">
                <span class="font-medium text-[#111827]">Salah Input</span>
            </label>

            <label class="flex items-center gap-3 rounded-lg border-2 border-transparent bg-[#EFF1F9] p-4 transition-all cursor-pointer">
                <input class="custom-radio" name="reason_option" type="radio" value="jadwal_tidak_sesuai">
                <span class="font-medium text-[#111827]">Jadwal Tidak Sesuai</span>
            </label>

            <label class="flex items-center gap-3 rounded-lg border-2 border-transparent bg-[#EFF1F9] p-4 transition-all cursor-pointer">
                <input class="custom-radio" name="reason_option" type="radio" value="lainnya">
                <span class="font-medium text-[#111827]">Lainnya</span>
            </label>

            <div class="mt-4">
                <textarea id="rejectNote" class="w-full resize-none rounded-lg border border-[#D1D5DB] bg-[#EFF1F9] p-4 text-[#111827] placeholder:text-[#9CA3AF] focus:border-[#BE1E1E] focus:outline-none focus:ring-1 focus:ring-[#BE1E1E] transition-all" placeholder="Tulis alasan pembatalan (opsional)" rows="4"></textarea>
            </div>

            <section class="mt-10 flex flex-col items-center gap-6">
                <button class="w-full rounded-full bg-[#BE1E1E] py-4 font-bold text-white shadow-lg transition-colors hover:bg-red-800" type="submit">
                    Konfirmasi Pembatalan
                </button>
                <button class="text-lg font-bold text-[#0055D3] hover:underline decoration-2 underline-offset-4" type="button" onclick="closeRejectModal()">
                    Kembali
                </button>
            </section>
        </form>
    </main>
</div>

<script>
    const rejectModal = document.getElementById('rejectModal');
    const rejectForm = document.getElementById('rejectForm');
    const rejectOrderId = document.getElementById('rejectOrderId');
    const rejectReason = document.getElementById('rejectReason');
    const rejectNote = document.getElementById('rejectNote');
    const rejectNoteValue = document.getElementById('rejectNoteValue');

    function openRejectModal(orderId, customerName, serviceName) {
        rejectOrderId.value = orderId;
        rejectModal.classList.remove('hidden');
        rejectModal.classList.add('flex');
        rejectReason.value = 'salah_input';
        rejectNote.value = '';
        rejectNoteValue.value = '';
    }

    function closeRejectModal() {
        rejectModal.classList.add('hidden');
        rejectModal.classList.remove('flex');
    }

    rejectModal.addEventListener('click', (event) => {
        if (event.target === rejectModal) {
            closeRejectModal();
        }
    });

    rejectForm.addEventListener('submit', () => {
        const selectedReason = rejectForm.querySelector('input[name="reason_option"]:checked');
        rejectReason.value = selectedReason ? selectedReason.value : 'lainnya';
        rejectNoteValue.value = rejectNote.value || '';
        closeRejectModal();
    });
</script>
@endsection
