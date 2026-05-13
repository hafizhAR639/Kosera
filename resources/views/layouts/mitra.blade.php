<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - KOSERA Mitra</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top,#d7f0fb_0%,#e1f5fe_40%,#ecf7ff_100%)] text-slate-900">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="hidden w-72 flex-shrink-0 bg-white shadow-lg lg:block">
            <div class="sticky top-0 flex h-screen flex-col overflow-y-auto">
                <!-- Logo -->
                <div class="border-b border-slate-200 px-6 py-8">
                    <a href="{{ route('mitra.dashboard') }}" class="inline-flex items-center gap-2 text-2xl font-bold text-[#006b9b]">
                        <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        <span>Kosera Mitra</span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 space-y-1 px-3 py-6">
                    <a href="{{ route('mitra.dashboard') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 {{ request()->routeIs('mitra.dashboard') ? 'bg-[#006b9b]/10 text-[#006b9b]' : 'text-slate-600 hover:bg-slate-100' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9m-9 16l4-4m0 0l4 4m-4-4V5"/>
                        </svg>
                        <span class="font-semibold">Dashboard</span>
                    </a>
                    <a href="{{ route('mitra.portfolio.index') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 {{ request()->routeIs('mitra.portfolio.*') ? 'bg-[#006b9b]/10 text-[#006b9b]' : 'text-slate-600 hover:bg-slate-100' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span class="font-semibold">Portfolio</span>
                    </a>
                    <a href="{{ route('mitra.orders.incoming') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 {{ request()->routeIs('mitra.orders.incoming*') ? 'bg-[#006b9b]/10 text-[#006b9b]' : 'text-slate-600 hover:bg-slate-100' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <span class="font-semibold">Orderan</span>
                    </a>
                    <a href="{{ route('mitra.orders.history') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 {{ request()->routeIs('mitra.orders.history*') ? 'bg-[#006b9b]/10 text-[#006b9b]' : 'text-slate-600 hover:bg-slate-100' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-semibold">Riwayat</span>
                    </a>
                    <a href="{{ route('mitra.certificates.index') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 {{ request()->routeIs('mitra.certificates.*') ? 'bg-[#006b9b]/10 text-[#006b9b]' : 'text-slate-600 hover:bg-slate-100' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-semibold">Sertifikat</span>
                    </a>
                    <a href="{{ route('mitra.profile.show') }}" class="flex items-center gap-3 rounded-lg px-4 py-3 {{ request()->routeIs('mitra.profile.*') ? 'bg-[#006b9b]/10 text-[#006b9b]' : 'text-slate-600 hover:bg-slate-100' }}">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span class="font-semibold">Profil</span>
                    </a>
                </nav>

                <!-- Logout -->
                <div class="border-t border-slate-200 px-3 py-6">
                    <form action="{{ route('logout') }}" method="POST" class="inline-block w-full">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-4 py-3 text-slate-600 hover:bg-rose-50 hover:text-rose-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            <span class="font-semibold">Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="min-h-screen flex-1 overflow-y-auto p-1 sm:p-2 lg:p-6">
            <!-- Mobile Navigation -->
            <nav class="mb-4 overflow-x-auto rounded-2xl bg-white/80 p-2 shadow-sm backdrop-blur lg:hidden">
                <div class="flex min-w-max gap-2 text-sm font-semibold">
                    <a href="{{ route('mitra.dashboard') }}" class="rounded-xl px-4 py-2 {{ request()->routeIs('mitra.dashboard') ? 'bg-[#006b9b] text-white' : 'bg-slate-100 text-[#006b9b]' }}">Dashboard</a>
                    <a href="{{ route('mitra.portfolio.index') }}" class="rounded-xl px-4 py-2 {{ request()->routeIs('mitra.portfolio.*') ? 'bg-[#006b9b] text-white' : 'bg-slate-100 text-[#006b9b]' }}">Layanan</a>
                    <a href="{{ route('mitra.orders.incoming') }}" class="rounded-xl px-4 py-2 {{ request()->routeIs('mitra.orders.incoming*') ? 'bg-[#006b9b] text-white' : 'bg-slate-100 text-[#006b9b]' }}">Orderan</a>
                    <a href="{{ route('mitra.orders.history') }}" class="rounded-xl px-4 py-2 {{ request()->routeIs('mitra.orders.history*') ? 'bg-[#006b9b] text-white' : 'bg-slate-100 text-[#006b9b]' }}">Riwayat</a>
                    <a href="{{ route('mitra.profile.show') }}" class="rounded-xl px-4 py-2 {{ request()->routeIs('mitra.profile.*') ? 'bg-[#006b9b] text-white' : 'bg-slate-100 text-[#006b9b]' }}">Profil</a>
                </div>
            </nav>

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>
</body>
</html>
