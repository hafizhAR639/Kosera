<header class="border-b border-slate-200 bg-white">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
        <a href="<?= route_path('/') ?>" class="inline-flex items-center">
            <img src="img/logos/kosera-logo.png" alt="Kosera" class="h-12 w-auto object-contain">
        </a>
        <nav class="flex items-center gap-3 text-sm">
            <a href="<?= route_path('/login') ?>" class="rounded-full bg-[#B6E8FF] px-5 py-2 font-semibold text-black hover:bg-[#9fdef8]">Masuk</a>
            <a href="<?= route_path('/register') ?>" class="rounded-full bg-[#B6E8FF] px-5 py-2 font-semibold text-black hover:bg-[#9fdef8]">Daftar</a>
        </nav>
    </div>
</header>

<main class="mx-auto w-full max-w-6xl px-4 py-8">
    <?php if (!empty($message)): ?>
        <div class="mb-6 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
            <?= htmlspecialchars($message['text']) ?>
        </div>
    <?php endif; ?>

    <div class="space-y-8">
        <section class="rounded-3xl border border-sky-100 bg-gradient-to-br from-sky-50 via-cyan-50 to-white p-8 md:p-12">
            <div class="grid items-center gap-10 lg:grid-cols-2">
                <div>
                    <span class="inline-flex rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-sky-700">Mitra Kosera</span>
                    <h1 class="mt-4 text-4xl font-black leading-tight text-slate-900 md:text-5xl">Selamat Datang di Mitra KOSERA</h1>
                    <p class="mt-4 max-w-xl text-lg text-slate-600">Masuk untuk mengelola pesanan dan mulai mendapatkan penghasilan dari layanan yang Anda tawarkan.</p>
                    <div class="mt-8 flex flex-wrap items-center gap-3">
                        <a href="<?= route_path('/register') ?>" class="rounded-full bg-sky-700 px-6 py-3 text-sm font-semibold text-white hover:bg-sky-800">Mulai Sekarang</a>
                        <a href="<?= route_path('/login') ?>" class="rounded-full border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-100">Masuk</a>
                    </div>
                </div>
                <div class="rounded-3xl bg-white p-4 shadow-xl ring-1 ring-slate-200">
                    <img src="img/illustrations/hero-mitra-welcome.png" alt="Ilustrasi Mitra" class="h-auto max-h-[520px] w-full rounded-2xl bg-sky-50 object-contain">
                </div>
            </div>
        </section>

        <section class="rounded-3xl border border-sky-200 bg-sky-700 p-8 text-center text-white md:p-12">
            <h2 class="text-3xl font-black md:text-4xl">Gabung Sekarang dan Mulai Jadi Mitra Kosera</h2>
            <p class="mx-auto mt-3 max-w-2xl text-sky-100">Bangun penghasilan tambahan Anda bersama ekosistem layanan Kosera.</p>
            <div class="mt-7">
                <a href="<?= route_path('/register') ?>" class="inline-flex rounded-full bg-white px-6 py-3 text-sm font-bold text-sky-700 hover:bg-slate-100">Daftar Sekarang</a>
            </div>
        </section>
    </div>
</main>
