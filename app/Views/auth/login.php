<div class="flex min-h-screen items-center justify-center p-6">
    <div class="w-full max-w-md rounded-3xl border border-slate-200 bg-white p-8 shadow-xl">
        <div class="mb-5 text-center">
            <h1 class="text-3xl font-bold text-slate-900">KOSERA Mitra</h1>
            <p class="mt-1 text-slate-500">Masuk untuk membuka dashboard mitra.</p>
        </div>

        <?php if (!empty($message)): ?>
            <div class="mb-4 rounded-lg border px-4 py-3 text-sm <?= $message['type'] === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' ?>">
                <?= htmlspecialchars($message['text']) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= route_path('/login') ?>" class="space-y-4">
            <div>
                <label for="email" class="mb-1 block text-sm font-semibold text-slate-700">Email</label>
                <input id="email" name="email" type="email" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-sky-500 focus:outline-none">
            </div>
            <div>
                <label for="password" class="mb-1 block text-sm font-semibold text-slate-700">Password</label>
                <input id="password" name="password" type="password" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 focus:border-sky-500 focus:outline-none">
            </div>
            <button type="submit" class="w-full rounded-xl bg-sky-700 px-4 py-3 font-semibold text-white hover:bg-sky-800">Masuk</button>
        </form>

        <p class="mt-4 text-center text-sm text-slate-500">Belum punya akun? <a href="<?= route_path('/register') ?>" class="font-semibold text-sky-700">Daftar di sini</a>.</p>
    </div>
</div>
