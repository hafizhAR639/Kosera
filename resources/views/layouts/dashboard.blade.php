@extends('layouts.mitra')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-[#006b9b]">Dashboard Mitra</h1>
            <p class="text-slate-600">Selamat datang kembali! Berikut ringkasan performa Anda.</p>
        </div>
        <div class="text-sm font-semibold text-slate-500 bg-white px-4 py-2 rounded-xl shadow-sm">
            {{ date('d F Y') }}
        </div>
    </div>

    <!-- Stats Cards (Dummy Data) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[24px] shadow-sm border border-blue-50">
            <p class="text-sm font-semibold text-slate-500 mb-1">Total Orderan</p>
            <h3 class="text-2xl font-bold text-[#006b9b]">124</h3>
            <p class="text-xs text-green-600 mt-2 font-medium">↑ 12% bulan ini</p>
        </div>
        <div class="bg-white p-6 rounded-[24px] shadow-sm border border-blue-50">
            <p class="text-sm font-semibold text-slate-500 mb-1">Pendapatan</p>
            <h3 class="text-2xl font-bold text-[#006b9b]">Rp 4.5Jt</h3>
            <p class="text-xs text-green-600 mt-2 font-medium">↑ 8% bulan ini</p>
        </div>
        <div class="bg-white p-6 rounded-[24px] shadow-sm border border-blue-50">
            <p class="text-sm font-semibold text-slate-500 mb-1">Rating</p>
            <h3 class="text-2xl font-bold text-[#006b9b]">4.9 <span class="text-sm text-slate-400">/ 5.0</span></h3>
            <p class="text-xs text-slate-400 mt-2">Dari 89 ulasan</p>
        </div>
        <div class="bg-white p-6 rounded-[24px] shadow-sm border border-blue-50">
            <p class="text-sm font-semibold text-slate-500 mb-1">Poin</p>
            <h3 class="text-2xl font-bold text-[#006b9b]">1,250</h3>
            <p class="text-xs text-blue-600 mt-2 font-medium">Status: Pro Mitra</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Revenue Chart -->
        <div class="lg:col-span-2 bg-white p-8 rounded-[32px] shadow-sm border border-blue-50">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-bold text-[#006b9b]">Statistik Pendapatan</h3>
                <span class="text-xs font-bold text-slate-400 uppercase">7 Hari Terakhir</span>
            </div>
            <div class="h-[300px]">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Recent Orders (Dummy) -->
        <div class="bg-white p-8 rounded-[32px] shadow-sm border border-blue-50">
            <h3 class="text-xl font-bold text-[#006b9b] mb-6">Order Terbaru</h3>
            <div class="space-y-6">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">A</div>
                    <div class="flex-grow">
                        <p class="text-sm font-bold text-slate-800">Ahmad Fauzi</p>
                        <p class="text-xs text-slate-500">Service AC Split</p>
                    </div>
                    <span class="text-xs font-bold text-green-600">Rp 150k</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold">S</div>
                    <div class="flex-grow">
                        <p class="text-sm font-bold text-slate-800">Siti Aminah</p>
                        <p class="text-xs text-slate-500">Deep Cleaning</p>
                    </div>
                    <span class="text-xs font-bold text-green-600">Rp 85k</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 font-bold">B</div>
                    <div class="flex-grow">
                        <p class="text-sm font-bold text-slate-800">Budi Santoso</p>
                        <p class="text-xs text-slate-500">Instalasi Listrik</p>
                    </div>
                    <span class="text-xs font-bold text-green-600">Rp 200k</span>
                </div>
            </div>
            <button class="w-full mt-8 py-3 text-sm font-bold text-[#006b9b] bg-slate-50 rounded-xl hover:bg-slate-100 transition-colors">
                Lihat Semua Riwayat
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
            datasets: [{
                label: 'Pendapatan (Rp)',
                data: [450000, 600000, 350000, 800000, 950000, 1200000, 1100000],
                borderColor: '#006b9b',
                backgroundColor: 'rgba(0, 107, 155, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3,
                pointRadius: 5,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#006b9b',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { 
                    beginAtZero: true,
                    ticks: { callback: (val) => 'Rp ' + (val / 1000) + 'k' }
                },
                x: { grid: { display: false } }
            }
        }
    });
});
</script>
@endsection