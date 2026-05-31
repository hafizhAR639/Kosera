@php
    $mode = $mode ?? 'mitra';
@endphp
<aside class="w-72 shrink-0 self-start sticky top-0 bg-white flex flex-col py-8 px-5 shadow-[4px_0_24px_rgba(0,0,0,0.05)] rounded-r-[40px] overflow-y-auto h-screen">
    <!-- Logo -->
    <div class="mb-8 px-4">
        <a href="{{ $mode === 'mitra' ? route('mitra.dashboard') : route('user.services.index') }}" class="block">
            <img alt="KOSERA Logo" class="h-12 w-auto object-contain" src="{{ asset('img/logos/kosera-logo.png') }}"/>
        </a>
    </div>

    <!-- Profile Section -->
    <div class="flex flex-col items-center mb-8">
        <a href="{{ $mode === 'mitra' ? route('mitra.profile.show') : route('user.profile.show') }}" class="w-20 h-20 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden mb-3 hover:ring-2 hover:ring-[#006b9b] transition-all">
            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path>
            </svg>
        </a>
        <h2 class="text-lg font-bold text-[#006b9b] leading-none">Profil</h2>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-grow space-y-2">
        @if($mode === 'mitra')
            <a href="{{ route('mitra.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold transition-colors {{ request()->routeIs('mitra.dashboard') ? 'bg-[#006b9b] text-white' : 'text-[#006b9b] hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('mitra.layanan.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold transition-colors {{ request()->routeIs('mitra.layanan.*') ? 'bg-[#006b9b] text-white' : 'text-[#006b9b] hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 1.343-3 3v6h6v-6c0-1.657-1.343-3-3-3z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M5 10h14M7 10V8a5 5 0 0110 0v2M4 20h16" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Layanan</span>
            </a>

            <a href="{{ route('mitra.orders.incoming') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold transition-colors {{ request()->routeIs('mitra.orders.incoming*') ? 'bg-[#006b9b] text-white' : 'text-[#006b9b] hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Orderan Masuk</span>
            </a>

            <a href="{{ route('mitra.orders.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold transition-colors {{ request()->routeIs('mitra.orders.history*') ? 'bg-[#006b9b] text-white' : 'text-[#006b9b] hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Detail/Riwayat</span>
            </a>
        @else
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold transition-colors {{ request()->routeIs('user.dashboard') ? 'bg-[#006b9b] text-white' : 'text-[#006b9b] hover:bg-gray-50' }}">
                <span class="material-symbols-outlined">search</span>
                <span>Cari Mitra</span>
            </a>
            <a href="{{ route('user.orders.history') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold transition-colors {{ request()->routeIs('user.orders.*') ? 'bg-[#006b9b] text-white' : 'text-[#006b9b] hover:bg-gray-50' }}">
                <span class="material-symbols-outlined">history</span>
                <span>Riwayat</span>
            </a>
            <a href="{{ route('user.profile.show') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold transition-colors {{ request()->routeIs('user.profile.*') ? 'bg-[#006b9b] text-white' : 'text-[#006b9b] hover:bg-gray-50' }}">
                <span class="material-symbols-outlined">person</span>
                <span>Profil</span>
            </a>
        @endif
    </nav>

    <!-- Bottom Actions -->
    <div class="mt-auto space-y-2 pt-8">
        @if($mode === 'mitra')
            <a href="{{ route('mitra.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg font-semibold transition-colors {{ request()->routeIs('mitra.profile.edit') ? 'bg-[#006b9b] text-white' : 'text-[#006b9b] hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                <span>Pengaturan</span>
            </a>

            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-[#006b9b] hover:bg-gray-50 font-semibold transition-colors text-left">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path></svg>
                    <span class="text-lg">Logout</span>
                </button>
            </form>
        @else
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-[#006b9b] hover:bg-gray-50 font-semibold transition-colors text-left">
                    <span class="material-symbols-outlined">logout</span>
                    <span>Keluar</span>
                </button>
            </form>
        @endif
    </div>
</aside>
