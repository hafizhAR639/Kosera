<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ $title ?? 'KOSERA - Jasa Anak Kos' }}</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<style>
		body {
			font-family: 'Plus Jakarta Sans', sans-serif;
		}
	</style>
</head>
<body class="bg-white">
    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-[#E1F5FE]/95 backdrop-blur-sm">
        <div class="mx-auto flex max-w-[1440px] items-center justify-between px-6 py-4 md:px-[52px]">
            <a href="/">
                <img src="{{ asset('img/logos/kosera-logo.png') }}" class="h-[45px] w-auto object-contain" alt="Kosera Logo" />
            </a>
            
            <div class="hidden items-center gap-8 lg:flex">
                <a href="{{ route('user.dashboard') }}" class="text-base font-bold text-black hover:text-[#1E8593] transition-colors {{ request()->routeIs('user.dashboard') ? 'underline' : '' }}">Cari Mitra</a>
                <a href="{{ route('user.orders.history') }}" class="text-base font-bold text-black hover:text-[#1E8593] transition-colors {{ request()->routeIs('user.orders.history') ? 'underline' : '' }}">Riwayat</a>
                <a href="#" class="text-base font-bold text-black hover:text-[#1E8593] transition-colors">Profil</a>
                <a href="#" class="text-base font-bold text-black hover:text-[#1E8593] transition-colors">Tentang kami</a>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <div class="flex items-center gap-4">
                        <a href="{{ route('user.profile.show') }}" class="flex items-center gap-2 text-base font-bold text-black hover:text-[#1E8593]">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center overflow-hidden border border-slate-200">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset(auth()->user()->avatar) }}" class="w-full h-full object-cover" />
                                @else
                                    <i class="ti ti-user text-xl text-slate-400"></i>
                                @endif
                            </div>
                            <span class="hidden sm:inline">{{ auth()->user()->nama }}</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="rounded-full bg-white px-6 py-2 text-sm font-bold text-rose-600 shadow-sm transition-all hover:bg-rose-50 border border-rose-100">
                                Keluar
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="rounded-full bg-white px-8 py-2 text-base font-bold text-black shadow-sm transition-all hover:bg-gray-50">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="rounded-2xl bg-[#B6E8FE] px-8 py-2 text-base font-bold text-black transition-all hover:bg-[#a5d8f0]">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <!-- Footer could be added here -->
</body>
</html>



Edit Screen
