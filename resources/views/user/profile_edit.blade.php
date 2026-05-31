@php
    $pageTitle = 'Edit Profile - KOSERA';
@endphp

<x-layout.user-sidebar :pageTitle="$pageTitle" :bgColor="'#f4faff'" mainClass="p-8">
        <h1 class="text-4xl font-bold mb-8 text-[#005981]">Edit Profile</h1>

        <div class="bg-white rounded-lg p-6 shadow-sm max-w-2xl">
            <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-[#40484f] mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ old('nama', $user->nama ?? '') }}" required
                        class="w-full px-4 py-2 border border-[#bfc7d0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#005981]">
                    @error('nama')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#40484f] mb-2">Email</label>
                    <input type="email" value="{{ $user->email ?? '' }}" disabled
                        class="w-full px-4 py-2 border border-[#bfc7d0] rounded-lg bg-gray-100 text-gray-600">
                    <p class="text-xs text-[#40484f] mt-1">Email tidak dapat diubah</p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#40484f] mb-2">Nomor Telepon</label>
                    <input type="tel" name="phone" value="{{ old('phone', $user->phone ?? '') }}"
                        class="w-full px-4 py-2 border border-[#bfc7d0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#005981]">
                    @error('phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#40484f] mb-2">Lokasi</label>
                    <input type="text" name="location" value="{{ old('location', $user->location ?? '') }}"
                        class="w-full px-4 py-2 border border-[#bfc7d0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#005981]">
                    @error('location')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#40484f] mb-2">Alamat Lengkap</label>
                    <textarea name="address" rows="4"
                        class="w-full px-4 py-2 border border-[#bfc7d0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#005981]">{{ old('address', $user->address ?? '') }}</textarea>
                    @error('address')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4 pt-6">
                    <button type="submit" class="bg-[#005981] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#003f5a] transition-colors">
                        Simpan
                    </button>
                    <a href="{{ route('user.profile.show') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-lg font-semibold hover:bg-gray-400 transition-colors">
                        Batal
                    </a>
                </div>
            </form>
        </div>
</x-layout.user-sidebar>
