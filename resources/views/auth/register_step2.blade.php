<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>KOSERA - Verifikasi Data</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f4f7fe] font-['Plus_Jakarta_Sans',sans-serif] text-[#004a6d] antialiased">
    <div class="flex min-h-screen flex-col p-6 lg:p-12">
        <header class="mb-12 flex items-center justify-between gap-6">
            <div class="flex items-center gap-2">
                <img alt="KOSERA Logo" class="h-12 w-auto object-contain" src="{{ asset('img/logos/kosera-logo.png') }}" />
            </div>
            <div class="hidden w-[150px] lg:block"></div>
        </header>

            @php
                $role = request('role') ?? old('role') ?? 'user';
                $showPortfolio = $role === 'mitra';
            @endphp
            <nav class="relative mx-auto mb-16 w-full max-w-4xl">
                <div class="absolute top-6 left-0 right-0 h-1 rounded-full bg-[#73b4ff]"></div>
                <div class="relative z-10 flex items-start justify-between gap-3">
                    <div class="flex flex-col items-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-[#73b4ff] bg-white text-xl font-bold text-[#0070ba] md:h-14 md:w-14">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"></path>
                            </svg>
                        </div>
                        <span class="mt-2 text-sm font-semibold text-[#0070ba] md:text-base">Profil Diri</span>
                    </div>

                    <div class="flex flex-col items-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-[#1e68a1] bg-[#1e68a1] text-xl font-bold text-white shadow-lg shadow-blue-200 md:h-14 md:w-14">2</div>
                        <span class="mt-2 text-sm font-bold text-[#0070ba] md:text-base">Verifikasi Data</span>
                    </div>

                    @if($showPortfolio)
                    <div class="flex flex-col items-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-[#73b4ff] bg-white text-xl font-bold text-[#73b4ff] md:h-14 md:w-14">3</div>
                        <span class="mt-2 text-sm font-semibold text-[#0070ba] md:text-base">Album/Portofolio</span>
                    </div>
                    @endif

                    <div class="flex flex-col items-center">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-[#73b4ff] bg-white text-xl font-bold text-[#73b4ff] md:h-14 md:w-14">{{ $showPortfolio ? 4 : 3 }}</div>
                        <span class="mt-2 text-sm font-semibold text-[#0070ba] md:text-base">Keuangan</span>
                    </div>
                </div>
            </nav>

        <main class="mx-auto flex w-full max-w-5xl flex-1 flex-col items-center gap-10 md:grid md:grid-cols-12 md:items-start md:gap-8">
            <aside class="md:col-span-4 flex flex-col items-center pt-8">
                <div class="w-full rounded-3xl border border-blue-100 bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-bold text-[#004a6d]">Kenapa butuh Verifikasi?</h3>
                    <ul class="space-y-3 text-sm text-slate-600">
                        <li class="flex gap-2"><span class="text-[#73b4ff]">✔</span> Meningkatkan kepercayaan pelanggan.</li>
                        <li class="flex gap-2"><span class="text-[#73b4ff]">✔</span> Keamanan transaksi bagi mitra.</li>
                        <li class="flex gap-2"><span class="text-[#73b4ff]">✔</span> Memastikan data Anda valid di sistem.</li>
                    </ul>
                </div>
            </aside>

            <section class="md:col-span-8 w-full">
                @php $reg = session('register.data', []); @endphp
                <form class="space-y-8" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="role" value="{{ $role }}" />
                    <div class="flex flex-col">
                        <label class="mb-3 ml-1 font-medium text-gray-500" for="nik">Nomor Induk Kependudukan (NIK)</label>
                        <input id="nik" name="nik" type="text" maxlength="16" placeholder="Isi 16 digit NIK Anda" value="{{ old('nik', $reg['nik'] ?? '') }}" class="w-full rounded-3xl border-none bg-[#d9dee8] p-5 placeholder:text-gray-500 focus:ring-2 focus:ring-[#73b4ff]" />
                    </div>

                    <div class="flex flex-col">
                        <label class="mb-3 ml-1 font-medium text-gray-500">Foto KTP</label>
                        <label class="relative flex h-56 cursor-pointer flex-col items-center justify-center rounded-[2rem] bg-[#d9dee8] text-gray-600 shadow-inner transition-all hover:border-2 hover:border-[#73b4ff]">
                            <svg class="mb-2 h-12 w-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <span class="text-lg font-medium">Tambahkan Foto +</span>
                            <input name="foto_ktp" type="file" class="sr-only" accept="image/*" />
                        </label>
                    </div>

                    <div class="flex flex-col">
                        <label class="mb-3 ml-1 font-medium text-gray-500">Foto Selfie dengan KTP</label>
                        <label class="relative flex h-56 cursor-pointer flex-col items-center justify-center rounded-[2rem] bg-[#d9dee8] text-gray-600 shadow-inner transition-all hover:border-2 hover:border-[#73b4ff]">
                            <svg class="mb-2 h-12 w-12" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <span class="text-lg font-medium">Tambahkan Foto +</span>
                            <input name="selfie_ktp" type="file" class="sr-only" accept="image/*" />
                        </label>
                    </div>

                    <footer class="flex flex-col-reverse gap-4 pt-4 md:flex-row md:items-center md:justify-between">
                        <a href="{{ route('register', ['role' => $role]) }}" class="inline-flex justify-center rounded-xl bg-[#73b4ff] px-12 py-3 text-lg font-bold text-[#1f2937] shadow-md transition-colors hover:bg-blue-400">Kembali</a>
                        <button class="inline-flex justify-center rounded-xl bg-[#73b4ff] px-12 py-3 text-lg font-bold uppercase tracking-wider text-[#1f2937] shadow-md transition-colors hover:bg-blue-400" type="submit">Selanjutnya</button>
                    </footer>
                </form>
            </section>
        </main>
    </div>
</body>
</html>