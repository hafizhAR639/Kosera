<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - KOSERA Mitra</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-[#e1f5fe] text-slate-900">
    <div class="flex h-screen">
        @include('components.kosera-sidebar', ['mode' => 'mitra'])

        <!-- Main Content -->
        <main class="min-h-screen flex-1 overflow-y-auto p-1 sm:p-2 lg:p-6 bg-[#e1f5fe]">
            <header class="mb-6 rounded-[28px] bg-white px-6 py-4 shadow-[0_10px_30px_rgba(0,0,0,0.06)] ring-1 ring-white/70">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#006b9b]">KOSERA Mitra</p>
                        <h1 class="text-2xl font-bold text-slate-900">{{ $title ?? 'Dashboard' }}</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <button class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#e1f5fe] text-[#006b9b] transition-colors hover:bg-[#ccecf9]" type="button">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </button>
                        <button class="flex h-11 w-11 items-center justify-center rounded-2xl bg-[#e1f5fe] text-[#006b9b] transition-colors hover:bg-[#ccecf9]" type="button">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4.75 4.75A.75.75 0 015.5 4h12a.75.75 0 01.75.75v14.5a.75.75 0 01-.75.75h-12a.75.75 0 01-.75-.75V4.75z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M8 8h8M8 12h8M8 16h5" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>
</body>
</html>
