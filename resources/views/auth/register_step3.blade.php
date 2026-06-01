<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>KOSERA - Portofolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f4f7fe] font-['Plus_Jakarta_Sans',sans-serif] text-[#1f2937] antialiased">
    <div class="mx-auto flex min-h-screen max-w-6xl flex-col px-4 py-8 md:px-6 lg:px-8">
        <header class="mb-12 flex items-start justify-between gap-6">
            <div class="flex items-center gap-2" data-purpose="brand-logo">
                <img alt="Kosera Logo" class="h-10 w-auto object-contain" src="{{ asset('img/logos/kosera-logo.png') }}" />
            </div>
            <div class="hidden w-40 lg:block"></div>
        </header>

        @php $role = request('role') ?? old('role') ?? 'mitra'; $reg = session('register.data', []); @endphp
        <nav class="relative mb-16 w-full">
            <div class="absolute top-6 left-0 right-0 h-1 bg-[#73b4ff]"></div>
            <div class="relative z-10 flex justify-between gap-3">
                <div class="flex flex-col items-center gap-2">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-[#73b4ff] bg-white text-xl font-bold text-[#73b4ff] md:h-14 md:w-14">1</div>
                    <span class="text-sm font-semibold text-[#0070ba]">Profil Diri</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-[#73b4ff] bg-white text-xl font-bold text-[#73b4ff] md:h-14 md:w-14">2</div>
                    <span class="text-sm font-semibold text-[#0070ba]">Verifikasi Data</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-[#0070ba] text-xl font-bold text-white shadow-lg shadow-blue-200 md:h-14 md:w-14">3</div>
                    <span class="text-sm font-bold text-[#0070ba]">Portofolio</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full border-4 border-[#73b4ff] bg-white text-xl font-bold text-[#73b4ff] md:h-14 md:w-14">4</div>
                    <span class="text-sm font-semibold text-[#0070ba]">Keuangan</span>
                </div>
            </div>
        </nav>

        <main class="mx-auto flex w-full max-w-3xl flex-1 flex-col">
            <form class="space-y-10" action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @php $role = request('role') ?? old('role') ?? 'mitra'; $reg = session('register.data', []); @endphp
                <input type="hidden" name="role" value="{{ $role }}" />
                
                <div class="space-y-4">
                    <h2 class="text-lg font-medium text-gray-500">Deskripsi Portofolio</h2>
                    <label class="flex h-52 w-full cursor-text flex-col items-start justify-start rounded-3xl border-2 border-transparent bg-[#d9dee8] p-6 shadow-inner transition-colors hover:border-[#0070ba]">
                        <textarea name="deskripsi_portofolio" class="w-full h-full resize-none rounded-lg bg-transparent p-4 text-sm text-slate-800" placeholder="Tuliskan deskripsi portofolio Anda...">{{ old('deskripsi_portofolio', $reg['deskripsi_portofolio'] ?? $reg['deskripsi'] ?? '') }}</textarea>
                    </label>
                </div>

                <div class="space-y-4">
                    <h2 class="text-lg font-medium text-gray-500">Tambahkan Portofolio (Opsional)</h2>
                    <label class="flex h-52 w-full cursor-pointer flex-col items-center justify-center rounded-3xl border-2 border-transparent bg-[#d9dee8] p-6 shadow-inner transition-colors hover:border-[#0070ba]">
                        <svg class="mb-2 h-12 w-12 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"></path>
                        </svg>
                        <div class="mb-1 text-xs font-bold text-gray-600">PDF / IMAGE</div>
                        <span class="text-lg font-medium text-gray-600">Tambahkan File +</span>
                        <input name="portfolio_file" type="file" class="sr-only" accept="application/pdf,image/*" />
                        @if(!empty($reg['portfolio_filename']))
                            <p class="mt-3 text-sm text-slate-600">File yang diunggah sebelumnya: <span class="font-semibold">{{ $reg['portfolio_filename'] }}</span></p>
                        @endif
                    </label>
                </div>

                <nav class="flex justify-between gap-4 px-2 pt-8">
                    <a href="{{ route('register.step2', ['role' => $role]) }}" class="inline-flex justify-center rounded-xl bg-[#73b4ff] px-12 py-3 text-xl font-bold text-[#1f2937] shadow-md transition-colors hover:bg-blue-400">Kembali</a>
                    <button type="submit" class="inline-flex justify-center rounded-xl bg-[#73b4ff] px-12 py-3 text-xl font-bold text-[#1f2937] shadow-md transition-colors hover:bg-blue-400">SELANJUTNYA</button>
                </nav>
            </form>
        </main>
    </div>
</body>
</html>