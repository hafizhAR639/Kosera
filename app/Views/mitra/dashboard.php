<?php
$statusClass = [
    'pending' => 'bg-amber-100 text-amber-700',
    'confirmed' => 'bg-blue-100 text-blue-700',
    'in_progress' => 'bg-sky-100 text-sky-700',
    'completed' => 'bg-emerald-100 text-emerald-700',
    'cancelled' => 'bg-rose-100 text-rose-700',
];
$statusText = [
    'pending' => 'Pending',
    'confirmed' => 'Confirmed',
    'in_progress' => 'Dikerjakan',
    'completed' => 'Selesai',
    'cancelled' => 'Dibatalkan',
];
?>

<section class="space-y-6 sm:space-y-8">
    <?php if (!empty($message)): ?>
        <div class="rounded-xl border px-4 py-3 text-sm <?= $message['type'] === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' ?>">
            <?= htmlspecialchars($message['text']) ?>
        </div>
    <?php endif; ?>

    <header class="rounded-[28px] bg-white/85 p-6 shadow-[0_10px_30px_rgba(1,51,109,0.12)] backdrop-blur sm:p-8">
        <p class="text-sm font-semibold uppercase tracking-[0.18em] text-[#006b9b]/70">Dashboard Mitra</p>
        <h1 class="mt-2 text-3xl font-semibold text-black sm:text-4xl">Selamat Datang <?= htmlspecialchars($user['nama']) ?>!</h1>
        <p class="mt-2 max-w-2xl text-slate-600">Semua ringkasan utama ada di sini. Tampilan dibuat lebih lapang agar mirip mood Figma dan tetap nyaman di mobile.</p>
    </header>

    <div class="grid gap-5 md:grid-cols-2">
        <article class="min-h-[210px] rounded-[30px] bg-white p-6 shadow-[0_12px_34px_rgba(0,0,0,0.12)] sm:p-8">
            <p class="text-base font-semibold uppercase tracking-wide text-[#006b9b]">Pesanan Bulan Ini</p>
            <p class="mt-8 text-5xl font-bold text-slate-900"><?= $monthlyOrders ?></p>
            <a href="<?= route_path('/mitra/orders/incoming') ?>" class="mt-6 inline-block text-sm font-semibold text-[#006b9b]">Lihat Orderan Masuk</a>
        </article>

        <article class="min-h-[210px] rounded-[30px] bg-gradient-to-br from-[#006b9b] via-[#0d7cae] to-[#31a6d8] p-6 text-white shadow-[0_16px_40px_rgba(0,65,110,0.35)] sm:p-8">
            <p class="text-base font-semibold uppercase tracking-wide text-white/90">Total Pendapatan</p>
            <p class="mt-8 text-4xl font-bold sm:text-5xl"><?= formatRupiah($totalIncome) ?></p>
            <p class="mt-4 text-sm text-white/80">Akumulasi pendapatan layanan aktif.</p>
        </article>

        <article class="min-h-[210px] rounded-[30px] bg-white p-6 shadow-[0_12px_34px_rgba(0,0,0,0.12)] sm:p-8">
            <p class="text-base font-semibold uppercase tracking-wide text-[#006b9b]">Layanan Aktif</p>
            <p class="mt-8 text-5xl font-bold text-slate-900"><?= $servicesCount ?></p>
            <a href="<?= route_path('/mitra/portfolio') ?>" class="mt-6 inline-block text-sm font-semibold text-[#006b9b]">Kelola Layanan</a>
        </article>

        <article class="min-h-[210px] rounded-[30px] bg-white p-6 shadow-[0_12px_34px_rgba(0,0,0,0.12)] sm:p-8">
            <p class="text-base font-semibold uppercase tracking-wide text-[#006b9b]">Reputasi &amp; Poin</p>
            <p class="mt-8 text-5xl font-bold text-slate-900"><?= $point ?></p>
            <div class="mt-4 inline-flex items-center gap-1 text-[#f0bf2f]"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
            <p class="mt-2 text-sm text-slate-500">Performa layanan Anda konsisten baik.</p>
        </article>
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <section class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Pesanan Terbaru</h2>
                    <p class="text-sm text-slate-500">5 transaksi terakhir yang masuk ke akun Anda.</p>
                </div>
                <a href="<?= route_path('/mitra/orders/history') ?>" class="text-sm font-semibold text-[#006b9b]">Semua Pesanan</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="border-b text-left text-xs uppercase tracking-wide text-slate-500">
                            <th class="py-2 pr-3">Kode</th><th class="py-2 pr-3">Pelanggan</th><th class="py-2 pr-3">Layanan</th><th class="py-2 pr-3">Total</th><th class="py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($recentOrders) === 0): ?>
                            <tr><td colspan="5" class="py-4 text-center text-slate-400">Belum ada pesanan</td></tr>
                        <?php else: ?>
                            <?php foreach ($recentOrders as $order): ?>
                                <tr class="border-b last:border-0">
                                    <td class="py-3 pr-3 font-mono text-xs font-semibold text-[#006b9b]"><?= htmlspecialchars($order['order_code']) ?></td>
                                    <td class="py-3 pr-3"><?= htmlspecialchars($order['customer_name']) ?></td>
                                    <td class="py-3 pr-3"><?= htmlspecialchars($order['nama_layanan']) ?></td>
                                    <td class="py-3 pr-3 font-semibold"><?= formatRupiah((float)$order['total_harga']) ?></td>
                                    <td class="py-3"><span class="rounded-full px-2.5 py-1 text-xs font-semibold <?= $statusClass[$order['status']] ?? 'bg-slate-100 text-slate-600' ?>"><?= $statusText[$order['status']] ?? ucfirst($order['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Sertifikat Terbaru</h2>
                    <p class="text-sm text-slate-500">Empat sertifikat terakhir yang tersimpan.</p>
                </div>
                <a href="<?= route_path('/mitra/certificates') ?>" class="text-sm font-semibold text-[#006b9b]">Semua Sertifikat</a>
            </div>
            <div class="space-y-3">
                <?php if (count($recentCertificates) === 0): ?>
                    <p class="text-center text-slate-400">Belum ada sertifikat</p>
                <?php else: ?>
                    <?php foreach ($recentCertificates as $cert): ?>
                        <article class="rounded-xl border border-slate-200 p-3">
                            <div class="flex items-start justify-between gap-2">
                                <strong class="text-slate-900"><?= htmlspecialchars($cert['nama_sertifikat']) ?></strong>
                                <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700"><?= htmlspecialchars($cert['status_verifikasi']) ?></span>
                            </div>
                            <p class="mt-1 text-sm text-slate-600"><?= htmlspecialchars($cert['penerbit']) ?> · <?= htmlspecialchars($cert['kategori']) ?></p>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </section>
    </div>

    <section class="rounded-3xl bg-white p-6 shadow-sm">
        <div class="mb-4 flex items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Portfolio Terbaru</h2>
                <p class="text-sm text-slate-500">Project yang baru Anda unggah.</p>
            </div>
            <a href="<?= route_path('/mitra/portfolio') ?>" class="text-sm font-semibold text-[#006b9b]">Semua Portfolio</a>
        </div>
        <div class="grid gap-3 md:grid-cols-2">
            <?php if (count($recentPortfolio) === 0): ?>
                <p class="col-span-full text-center text-slate-400">Belum ada portfolio</p>
            <?php else: ?>
                <?php foreach ($recentPortfolio as $item): ?>
                    <article class="rounded-xl border border-slate-200 p-3">
                        <div class="flex items-start justify-between gap-2">
                            <strong class="text-slate-900"><?= htmlspecialchars($item['judul']) ?></strong>
                            <span class="rounded-full bg-slate-100 px-2 py-0.5 text-xs font-semibold text-slate-700"><?= htmlspecialchars($item['status']) ?></span>
                        </div>
                        <p class="mt-1 text-sm text-slate-600">
                            <?= htmlspecialchars($item['kategori'] ?: 'Tanpa kategori') ?>
                            <?php if (!empty($item['rating'])): ?> · Rating <?= htmlspecialchars((string)$item['rating']) ?>/5<?php endif; ?>
                        </p>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </section>
</section>
