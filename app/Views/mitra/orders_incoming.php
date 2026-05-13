<section class="space-y-6">
    <h1 class="text-4xl font-semibold text-black">Orderan Masuk</h1>

    <?php if (!empty($message)): ?>
        <div class="rounded-xl border px-4 py-3 text-sm <?= $message['type'] === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' ?>">
            <?= htmlspecialchars($message['text']) ?>
        </div>
    <?php endif; ?>

    <div class="grid gap-6 lg:grid-cols-2">
        <?php if (count($orders) === 0): ?>
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-slate-500">Belum ada orderan masuk saat ini.</div>
        <?php else: ?>
            <?php foreach ($orders as $order): ?>
                <article class="rounded-[30px] bg-white p-5 shadow-[7px_12px_43px_0_rgba(0,0,0,0.14)]">
                    <div class="mb-3 inline-flex rounded-lg bg-[#006b9b] px-4 py-2 text-sm font-bold text-white"><?= htmlspecialchars(strtoupper($order['nama_layanan'])) ?></div>
                    <h2 class="text-xl font-semibold text-black"><?= htmlspecialchars($order['customer_name']) ?></h2>
                    <p class="mt-2 text-slate-700"><?= htmlspecialchars($order['alamat_lengkap']) ?></p>
                    <p class="text-slate-700"><?= htmlspecialchars($order['nama_layanan']) ?></p>
                    <p class="text-slate-700"><?= formatRupiah((float)$order['total_harga']) ?></p>
                    <p class="text-slate-700"><?= formatTanggal($order['tanggal_order']) ?></p>
                    <div class="mt-4 inline-flex rounded border-2 border-[#7fffcc] px-4 py-2 text-sm font-bold text-[#2cbf84]">
                        <?= htmlspecialchars($statusLabel[$order['status']] ?? ucfirst($order['status'])) ?>
                    </div>
                    <div class="mt-4 flex gap-3">
                        <?php if ($order['status'] === 'pending'): ?>
                            <form method="POST" action="<?= route_path('/mitra/orders/incoming/status') ?>">
                                <input type="hidden" name="action" value="accept">
                                <input type="hidden" name="order_id" value="<?= (int)$order['id'] ?>">
                                <button class="rounded border-2 border-[#2cbf84] px-4 py-2 text-sm font-bold text-[#2cbf84]">Terima</button>
                            </form>
                            <form method="POST" action="<?= route_path('/mitra/orders/incoming/status') ?>" onsubmit="return confirm('Yakin menolak order ini?')">
                                <input type="hidden" name="action" value="reject">
                                <input type="hidden" name="order_id" value="<?= (int)$order['id'] ?>">
                                <button class="rounded border-2 border-[#bf2c2c] px-4 py-2 text-sm font-bold text-[#bf2c2c]">Tolak</button>
                            </form>
                        <?php else: ?>
                            <a href="<?= route_path('/mitra/orders/history') ?>" class="rounded border-2 border-[#006b9b] px-4 py-2 text-sm font-bold text-[#006b9b]">Lihat Riwayat</a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>
