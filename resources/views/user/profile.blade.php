@php
    $pageTitle = 'Profile - KOSERA';
@endphp

<x-layout.user-sidebar :pageTitle="$pageTitle" :bgColor="'#f4faff'" mainClass="p-8">
        <h1 class="text-4xl font-bold mb-8 text-[#005981]">Profile</h1>

        <!-- Profile Header -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Avatar Card -->
            <div class="bg-white rounded-lg p-6 shadow-sm text-center">
                <div class="w-32 h-32 mx-auto bg-[#e0e9ef] rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-16 h-16 text-[#005981]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12a4 4 0 100-8 4 4 0 000 8zm0 2c-3.33 0-6 2.015-6 4.5V20h12v-1.5c0-2.485-2.67-4.5-6-4.5z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-[#005981]">{{ auth()->user()->name ?? 'User' }}</h2>
                <p class="text-sm text-[#40484f] mt-1">Kosera Member</p>
            </div>

            <!-- Personal Info -->
            <div class="lg:col-span-2 bg-white rounded-lg p-6 shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-[#005981]">Informasi Pribadi</h3>
                    <a href="{{ route('user.profile.edit') }}" class="text-blue-600 text-sm font-semibold hover:underline">Edit</a>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs uppercase text-[#40484f] font-semibold mb-1">Nama</p>
                        <p class="text-base font-semibold text-[#005981]">{{ auth()->user()->name ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-[#40484f] font-semibold mb-1">Email</p>
                        <p class="text-base font-semibold text-[#005981]">{{ auth()->user()->email ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-[#40484f] font-semibold mb-1">Telepon</p>
                        <p class="text-base font-semibold text-[#005981]">{{ auth()->user()->phone ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase text-[#40484f] font-semibold mb-1">Lokasi</p>
                        <p class="text-base font-semibold text-[#005981]">{{ auth()->user()->location ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Address Card -->
        <div class="bg-white rounded-lg p-6 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-[#005981]">Alamat</h3>
                <a href="{{ route('user.profile.edit') }}" class="bg-[#005981] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#003f5a] transition-colors">
                    Tambah Alamat
                </a>
            </div>
            <div class="border-2 border-[#9bcefe]/20 rounded-lg p-6">
                <p class="text-[#005981] font-semibold mb-2">Alamat Utama</p>
                <p class="text-[#40484f] text-sm leading-relaxed">{{ auth()->user()->address ?? 'Belum ada alamat' }}</p>
            </div>
        </div>
</x-layout.user-sidebar>
