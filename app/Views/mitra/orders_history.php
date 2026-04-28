<section class="space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-4xl font-semibold text-black">Detail/Riwayat</h1>
        <div class="flex gap-3">
            <a href="<?= route_path('/mitra/orders/history') ?>" class="rounded-lg bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700">Reset</a>
            <button class="rounded-lg bg-[#006b9b] px-4 py-2 text-sm font-semibold text-white" onclick="exportData()">Export CSV</button>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-2xl bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Total Pesanan</p><p class="mt-2 text-3xl font-bold text-slate-900"><?= (int)($stats['total_orders'] ?? 0) ?></p></article>
        <article class="rounded-2xl bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Selesai</p><p class="mt-2 text-3xl font-bold text-emerald-600"><?= (int)($stats['completed'] ?? 0) ?></p></article>
        <article class="rounded-2xl bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Pending</p><p class="mt-2 text-3xl font-bold text-amber-600"><?= (int)($stats['pending'] ?? 0) ?></p></article>
        <article class="rounded-2xl bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Total Pendapatan</p><p class="mt-2 text-2xl font-bold text-[#006b9b]"><?= formatRupiah((float)($stats['total_revenue'] ?? 0)) ?></p></article>
    </div>

    <form method="GET" class="grid gap-3 rounded-2xl bg-white p-4 shadow-sm md:grid-cols-4">
        <select name="status" class="rounded-lg border border-slate-300 px-3 py-2">
            <option value="all" <?= $statusFilter === 'all' ? 'selected' : '' ?>>Semua Status</option>
            <option value="pending" <?= $statusFilter === 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="confirmed" <?= $statusFilter === 'confirmed' ? 'selected' : '' ?>>Confirmed</option>
            <option value="in_progress" <?= $statusFilter === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
            <option value="completed" <?= $statusFilter === 'completed' ? 'selected' : '' ?>>Completed</option>
            <option value="cancelled" <?= $statusFilter === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
        </select>
        <input type="date" name="date_from" value="<?= htmlspecialchars($dateFrom) ?>" class="rounded-lg border border-slate-300 px-3 py-2">
        <input type="date" name="date_to" value="<?= htmlspecialchars($dateTo) ?>" class="rounded-lg border border-slate-300 px-3 py-2">
        <button type="submit" class="rounded-lg bg-[#006b9b] px-4 py-2 text-sm font-semibold text-white">Filter</button>
    </form>

    <div class="grid gap-6 lg:grid-cols-2">
        <?php if (count($orders) === 0): ?>
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-6 text-center text-slate-500">Tidak ada data pesanan untuk filter saat ini.</div>
        <?php else: ?>
            <?php
            $statusText = ['pending' => 'Pending', 'confirmed' => 'Dikonfirmasi', 'in_progress' => 'Dikerjakan', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];
            $statusColor = ['pending' => 'border-amber-300 text-amber-700', 'confirmed' => 'border-blue-300 text-blue-700', 'in_progress' => 'border-sky-300 text-sky-700', 'completed' => 'border-emerald-300 text-emerald-700', 'cancelled' => 'border-rose-300 text-rose-700'];
            ?>
            <?php foreach ($orders as $order): ?>
                <article class="rounded-[30px] bg-white p-5 shadow-[7px_12px_43px_0_rgba(0,0,0,0.14)]">
                    <h2 class="text-xl font-semibold text-black"><?= htmlspecialchars($order['customer_name']) ?></h2>
                    <p class="mt-2 text-slate-700"><?= htmlspecialchars($order['nama_layanan']) ?></p>
                    <p class="text-slate-700"><?= formatRupiah((float)$order['total_harga']) ?></p>
                    <p class="text-slate-700"><?= formatTanggal($order['tanggal_order']) ?></p>
                    <p class="text-slate-700">Kode: <?= htmlspecialchars($order['order_code']) ?></p>
                    <div class="mt-4 inline-flex items-center gap-2 rounded border-2 px-4 py-2 text-sm font-bold <?= $statusColor[$order['status']] ?? 'border-slate-300 text-slate-700' ?>">
                        <?= htmlspecialchars($statusText[$order['status']] ?? ucfirst($order['status'])) ?>
                    </div>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<script>
    function exportData() {
        window.location.href = '<?= route_path('/mitra/orders/history/export-csv') ?>&status=<?= urlencode($statusFilter) ?>&date_from=<?= urlencode($dateFrom) ?>&date_to=<?= urlencode($dateTo) ?>';
    }
</script>
