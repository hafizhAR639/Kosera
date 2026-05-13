<div class="flex min-h-screen items-center justify-center p-6">
    <div class="w-full max-w-lg rounded-3xl border border-slate-200 bg-white p-8 shadow-xl">
        <div class="mb-5 text-center">
            <h1 class="text-3xl font-bold text-slate-900">Daftar Mitra KOSERA</h1>
            <p class="mt-1 text-slate-500">Buat akun baru sebelum masuk ke dashboard.</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="mb-4 rounded-lg border px-4 py-3 text-sm <?= $message['type'] === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' ?>">
                <?= htmlspecialchars($message['text']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= route_path('/register') ?>" class="space-y-4">
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700" for="nama">Nama Lengkap</label>
                <input id="nama" name="nama" type="text" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-sky-500 focus:outline-none">
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700" for="email">Email</label>
                <input id="email" name="email" type="email" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-sky-500 focus:outline-none">
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700" for="password">Password</label>
                <input id="password" name="password" type="password" minlength="8" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-sky-500 focus:outline-none">
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700" for="password_confirm">Konfirmasi Password</label>
                <input id="password_confirm" name="password_confirm" type="password" minlength="8" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-sky-500 focus:outline-none">
            </div>
            <button type="submit" class="w-full rounded-xl bg-sky-700 px-4 py-3 font-semibold text-white hover:bg-sky-800">Daftar</button>
        </form>

        <p class="mt-4 text-center text-sm text-slate-500">Sudah punya akun? <a href="<?= route_path('/login') ?>" class="font-semibold text-sky-700">Masuk di sini</a>.</p>
    </div>
</div>
