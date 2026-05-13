@extends('layouts.mitra')

@section('content')
<section class="space-y-6">
    <h1 class="text-4xl font-semibold text-black">Orderan Masuk</h1>

    @if (!empty($message))
        <p role="alert" class="rounded-xl border px-4 py-3 text-sm {{ $message['type'] === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' }}">
            {{ $message['text'] }}
        </p>
    @endif

    <div class="grid gap-6 lg:grid-cols-2">
        @forelse ($orders as $order)
            <article class="rounded-[30px] bg-white p-5 shadow-[7px_12px_43px_0_rgba(0,0,0,0.14)]">
                <div class="mb-3 inline-flex rounded-lg bg-[#006b9b] px-4 py-2 text-sm font-bold text-white">{{ strtoupper($order['service_name']) }}</div>
                <h2 class="text-xl font-semibold text-black">{{ $order['customer_name'] }}</h2>
                <p class="mt-2 text-slate-700">{{ $order['address'] }}</p>
                <p class="text-slate-700">{{ $order['service_name'] }}</p>
                <p class="text-slate-700">{{ \App\Helpers\FormatHelper::rupiah($order['total_price']) }}</p>
                <p class="text-slate-700">{{ \App\Helpers\FormatHelper::date($order['order_date']) }}</p>
                <div class="mt-4 inline-flex rounded border-2 border-[#7fffcc] px-4 py-2 text-sm font-bold text-[#2cbf84]">
                    {{ ucfirst($order['status']) }}
                </div>
                <footer class="mt-4 flex gap-3">
                    @if ($order['status'] === 'pending')
                        <form method="POST" action="{{ route('mitra.orders.incoming.status') }}">
                            @csrf
                            <input type="hidden" name="action" value="accept">
                            <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                            <button class="rounded border-2 border-[#2cbf84] px-4 py-2 text-sm font-bold text-[#2cbf84]">Terima</button>
                        </form>
                        <form method="POST" action="{{ route('mitra.orders.incoming.status') }}" onsubmit="return confirm('Yakin menolak order ini?')">
                            @csrf
                            <input type="hidden" name="action" value="reject">
                            <input type="hidden" name="order_id" value="{{ $order['id'] }}">
                            <button class="rounded border-2 border-[#bf2c2c] px-4 py-2 text-sm font-bold text-[#bf2c2c]">Tolak</button>
                        </form>
                    @else
                        <a href="{{ route('mitra.orders.history') }}" class="rounded border-2 border-[#006b9b] px-4 py-2 text-sm font-bold text-[#006b9b]">Lihat Riwayat</a>
                    @endif
                </footer>
            </article>
        @empty
            <p class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-slate-500">Belum ada orderan masuk saat ini.</p>
        @endforelse
    </div>
</section>
@endsection
