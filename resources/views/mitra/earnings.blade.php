@extends('layouts.mitra')

@section('content')
<section class="space-y-6">
    <header class="rounded-[28px] bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Statistik Pendapatan</h1>
                <p class="text-sm text-slate-500">Analisis detail penghasilan Anda selama 12 bulan terakhir.</p>
            </div>
            <a href="{{ route('mitra.dashboard') }}" class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Kembali</a>
        </div>
    </header>

    <div class="grid gap-6 md:grid-cols-3">
        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-100">
            <p class="text-sm font-semibold text-slate-500 uppercase">Total Pendapatan</p>
            <p class="mt-2 text-3xl font-bold text-[#006b9b]">{{ \App\Helpers\FormatHelper::rupiah($stats['total_income'] ?? 0) }}</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-100">
            <p class="text-sm font-semibold text-slate-500 uppercase">Rata-rata Bulanan</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ \App\Helpers\FormatHelper::rupiah(($stats['total_income'] ?? 0) / 12) }}</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm border border-slate-100">
            <p class="text-sm font-semibold text-slate-500 uppercase">Pesanan Selesai</p>
            <p class="mt-2 text-3xl font-bold text-slate-900">{{ $stats['completed_orders'] ?? ($stats['monthly_orders'] ?? 0) }}</p>
        </div>
    </div>

    <div class="rounded-[32px] bg-white p-8 shadow-sm border border-slate-100">
        <h2 class="text-xl font-bold text-slate-900 mb-6">Grafik Perkembangan</h2>
        <div class="relative w-full h-[400px]">
            <canvas id="earningsChart"></canvas>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('earningsChart').getContext('2d');
        const chartData = @json($chartData ?? ['labels' => [], 'data' => []]);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: chartData.labels,
                datasets: [{
                    label: 'Pendapatan',
                    data: chartData.data,
                    backgroundColor: '#006b9b',
                    borderRadius: 8,
                    barThickness: 30,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });
    });
</script>
@endsection
