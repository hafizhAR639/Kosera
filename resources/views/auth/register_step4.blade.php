<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>KOSERA - Keuangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-[#f1f4f9] font-['Plus_Jakarta_Sans',sans-serif] text-slate-800 antialiased">
    <main class="mx-auto flex min-h-screen max-w-[1512px] flex-col p-8">
        <header class="mb-12 flex items-start justify-between gap-6">
            <div data-purpose="logo-container">
                <img alt="KOSERA Logo" class="h-12 w-auto object-contain" src="{{ asset('img/logos/kosera-logo.png') }}" />
            </div>

            <div class="flex-1 max-w-4xl mx-auto px-10">
                <div class="relative flex items-center justify-between">
                    <div class="absolute top-1/2 left-0 right-0 h-1 -translate-y-1/2 bg-[#73b4ff]"></div>

                    <div class="relative z-10 flex flex-col items-center">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full border-4 border-[#73b4ff] bg-white text-2xl font-bold text-[#d9dee8]">1</div>
                        <span class="mt-2 font-bold text-[#0077b6]">Profil Diri</span>
                    </div>

                    <div class="relative z-10 flex flex-col items-center">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full border-4 border-[#73b4ff] bg-white text-2xl font-bold text-[#d9dee8]">2</div>
                        <span class="mt-2 font-bold text-[#0077b6]">Verifikasi Data</span>
                    </div>

                    <div class="relative z-10 flex flex-col items-center">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full border-4 border-[#73b4ff] bg-white text-2xl font-bold text-[#d9dee8]">3</div>
                        <span class="mt-2 font-bold text-[#0077b6]">Portofolio</span>
                    </div>

                    <div class="relative z-10 flex flex-col items-center">
                        <div class="flex h-14 w-14 items-center justify-center rounded-full border-4 border-[#0077b6] bg-[#0077b6] text-2xl font-bold text-white">4</div>
                        <span class="mt-2 font-bold text-[#0077b6]">Keuangan</span>
                    </div>
                </div>
            </div>

            <div class="w-[150px]"></div>
        </header>

        <section class="flex flex-1 flex-col items-center justify-center pb-32">
            @php $role = request('role') ?? old('role') ?? 'user'; $showPortfolio = $role === 'mitra'; @endphp
            @php $reg = session('register.data', []); @endphp
            <form id="register-step4" class="w-full max-w-lg space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                <input type="hidden" name="role" value="{{ $role }}" />

                <div class="space-y-2">
                    <label class="block font-semibold text-gray-500" for="nama_bank">Nama Bank</label>
                    <div class="relative">
                        <select id="nama_bank" name="nama_bank" class="w-full appearance-none rounded-2xl border-none bg-[#d9dee8] bg-opacity-50 p-4 text-gray-400 focus:ring-2 focus:ring-[#73b4ff]">
                            <option disabled selected value="">Pilih Bank</option>
                            <option value="bca">BCA</option>
                            <option value="mandiri">Mandiri</option>
                            <option value="bni">BNI</option>
                            <option value="bri">BRI</option>
                        </select>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block font-semibold text-gray-500" for="nama_rekening">Nama Rekening</label>
                    <input id="nama_rekening" name="nama_rekening" type="text" placeholder="Isi Nama Rekening" value="{{ old('nama_rekening', $reg['nama_rekening'] ?? '') }}" class="w-full rounded-2xl border-none bg-[#d9dee8] bg-opacity-50 p-4 placeholder:text-gray-400 focus:ring-2 focus:ring-[#73b4ff]" />
                </div>

                <div class="space-y-2">
                    <label class="block font-semibold text-gray-500" for="nomor_rekening">Nomor Rekening</label>
                    <input id="nomor_rekening" name="nomor_rekening" type="text" placeholder="Isi Nomor Rekening" value="{{ old('nomor_rekening', $reg['nomor_rekening'] ?? '') }}" class="w-full rounded-2xl border-none bg-[#d9dee8] bg-opacity-50 p-4 placeholder:text-gray-400 focus:ring-2 focus:ring-[#73b4ff]" />
                </div>

                <div class="pt-8 flex justify-center">
                    <button type="submit" class="rounded-xl bg-[#73b4ff] px-16 py-3 text-lg font-bold text-slate-800 shadow-sm transition-colors hover:bg-blue-500">SIMPAN</button>
                </div>
            </form>
        </section>

                <footer class="mt-auto pb-4">
                            <a href="{{ $showPortfolio ? route('register.step3', ['role' => $role]) : route('register.step2', ['role' => $role]) }}" class="inline-flex rounded-xl bg-[#73b4ff] px-10 py-3 text-lg font-bold text-slate-800 shadow-sm transition-colors hover:bg-blue-500">Kembali</a>
                </footer>

    <script>
        // If user checked 'Alamat sama dengan profil', copy alamat from localStorage into a hidden field
        (function(){
            var form = document.getElementById('register-step4');
            if(!form) return;

            // create bank address field and checkbox
            var wrapper = document.createElement('div'); wrapper.className = 'space-y-2';
            wrapper.innerHTML = '\n        <label class="block font-semibold text-gray-500">Alamat Rekening</label>\n        <textarea id="alamat_bank" name="alamat_bank" rows="2" class="w-full rounded-2xl border-none bg-[#d9dee8] bg-opacity-50 p-4 placeholder:text-gray-400 focus:ring-2 focus:ring-[#73b4ff]" placeholder="Alamat terkait rekening (opsional)"></textarea>\n        <label class="inline-flex items-center mt-2">\n          <input id="same_as_profile" type="checkbox" class="mr-3 h-4 w-4" />\n          <span>Alamat sama dengan alamat profil</span>\n        </label>\n      ';

            // insert before submit button (which is last child)
            var submit = form.querySelector('button[type=submit]');
            submit.parentNode.insertBefore(wrapper, submit);

            var alamatBank = document.getElementById('alamat_bank');
            var chk = document.getElementById('same_as_profile');

            try {
                var saved = localStorage.getItem('kosera_register_alamat') || '';
                if(saved && chk) {
                    chk.addEventListener('change', function(){
                        if(this.checked) alamatBank.value = saved;
                        else alamatBank.value = '';
                    });
                }
            } catch(e) {}
        })();
    </script>
    </main>
</body>
</html>