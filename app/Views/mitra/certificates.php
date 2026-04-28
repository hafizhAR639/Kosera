<section class="space-y-6">
    <?php
    $filters = $filters ?? ['category' => 'all', 'q' => '', 'page' => 1, 'total' => 0, 'totalPages' => 1];
    $selectedCategory = $filters['category'] ?? 'all';
    $searchQuery = $filters['q'] ?? '';
    $currentPage = (int)($filters['page'] ?? 1);
    $totalPages = (int)($filters['totalPages'] ?? 1);
    $totalItems = (int)($filters['total'] ?? 0);
    ?>

    <div class="flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-3xl font-bold text-slate-900">Sertifikat</h1>
        <button class="rounded-xl bg-sky-700 px-4 py-2 font-semibold text-white hover:bg-sky-800" onclick="openModal('add')">+ Tambah Sertifikat</button>
    </div>

    <?php if (!empty($message)): ?>
        <div class="rounded-xl border px-4 py-3 text-sm <?= $message['type'] === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' ?>">
            <?= htmlspecialchars($message['text']) ?>
        </div>
    <?php endif; ?>

    <form method="GET" action="<?= route_path('/mitra/certificates') ?>" class="grid gap-3 rounded-2xl bg-white p-4 shadow-sm md:grid-cols-2">
        <select id="filterKategori" name="category" class="rounded-lg border border-slate-300 px-3 py-2">
            <option value="all" <?= $selectedCategory === 'all' ? 'selected' : '' ?>>Semua Kategori</option>
            <option value="teknis" <?= $selectedCategory === 'teknis' ? 'selected' : '' ?>>Teknis</option>
            <option value="keselamatan" <?= $selectedCategory === 'keselamatan' ? 'selected' : '' ?>>Keselamatan</option>
            <option value="manajemen" <?= $selectedCategory === 'manajemen' ? 'selected' : '' ?>>Manajemen</option>
            <option value="lainnya" <?= $selectedCategory === 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
        </select>
        <div class="flex gap-2">
            <input id="searchInput" name="q" type="text" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Cari sertifikat..." class="w-full rounded-lg border border-slate-300 px-3 py-2">
            <button type="submit" class="rounded-lg bg-sky-700 px-4 py-2 font-semibold text-white">Filter</button>
        </div>
    </form>

    <div id="certificatesGrid" class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        <?php foreach ($certificates as $cert): ?>
            <?php
            $statusClass = [
                'verified' => 'bg-emerald-100 text-emerald-700',
                'pending' => 'bg-amber-100 text-amber-700',
                'rejected' => 'bg-rose-100 text-rose-700',
            ];
            $statusLabel = [
                'verified' => 'Terverifikasi',
                'pending' => 'Pending',
                'rejected' => 'Ditolak',
            ];
            ?>
            <article class="certificate-card rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-start justify-between gap-3">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-fuchsia-500 text-white">
                        <svg viewBox="0 0 24 24" class="h-6 w-6" fill="currentColor"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                    </div>
                    <span class="rounded-full px-3 py-1 text-xs font-semibold <?= $statusClass[$cert['status_verifikasi']] ?? 'bg-slate-100 text-slate-600' ?>">
                        <?= $statusLabel[$cert['status_verifikasi']] ?? ucfirst($cert['status_verifikasi']) ?>
                    </span>
                </div>

                <h3 class="text-lg font-bold text-slate-900"><?= htmlspecialchars($cert['nama_sertifikat']) ?></h3>
                <p class="mt-2 text-sm text-slate-600"><?= htmlspecialchars($cert['penerbit']) ?></p>
                <p class="mt-1 text-sm text-slate-600">Berlaku: <?= formatTanggal($cert['tanggal_terbit']) ?> - <?= formatTanggal($cert['tanggal_kadaluarsa']) ?></p>

                <div class="mt-4 flex items-center gap-2">
                    <button class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-semibold text-slate-700 hover:bg-slate-100" onclick="editCertificate(<?= (int)$cert['id'] ?>)">Edit</button>
                    <?php if (!empty($cert['file_path'])): ?>
                        <a href="<?= htmlspecialchars($cert['file_path']) ?>" target="_blank" class="rounded-lg border border-sky-200 px-3 py-1.5 text-sm font-semibold text-sky-700 hover:bg-sky-50">Lihat File</a>
                    <?php endif; ?>
                    <button class="rounded-lg border border-rose-200 px-3 py-1.5 text-sm font-semibold text-rose-700 hover:bg-rose-50" onclick="deleteCertificate(<?= (int)$cert['id'] ?>)">Hapus</button>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <?php if (empty($certificates)): ?>
        <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center text-slate-600">
            Data sertifikat tidak ditemukan untuk filter saat ini.
        </div>
    <?php endif; ?>

    <div class="flex flex-wrap items-center justify-between gap-3 rounded-2xl bg-white p-4 text-sm shadow-sm">
        <p class="text-slate-600">Total: <span class="font-semibold text-slate-900"><?= $totalItems ?></span> data</p>
        <div class="flex items-center gap-2">
            <?php
            $baseQuery = ['category' => $selectedCategory, 'q' => $searchQuery];
            $prevPage = max(1, $currentPage - 1);
            $nextPage = min($totalPages, $currentPage + 1);
            ?>
            <a class="rounded-lg border border-slate-300 px-3 py-1.5 <?= $currentPage <= 1 ? 'pointer-events-none opacity-50' : '' ?>" href="<?= route_path('/mitra/certificates') . '&' . http_build_query($baseQuery + ['page' => $prevPage]) ?>">Sebelumnya</a>
            <span class="font-semibold text-slate-700">Halaman <?= $currentPage ?> / <?= $totalPages ?></span>
            <a class="rounded-lg border border-slate-300 px-3 py-1.5 <?= $currentPage >= $totalPages ? 'pointer-events-none opacity-50' : '' ?>" href="<?= route_path('/mitra/certificates') . '&' . http_build_query($baseQuery + ['page' => $nextPage]) ?>">Berikutnya</a>
        </div>
    </div>
</section>

<div id="certModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between rounded-t-2xl bg-sky-700 px-5 py-4 text-white">
            <h2 id="modalTitle" class="text-xl font-bold">Tambah Sertifikat</h2>
            <button class="text-2xl" onclick="closeModal()">&times;</button>
        </div>

        <form id="certForm" method="POST" action="<?= route_path('/mitra/certificates/store') ?>" enctype="multipart/form-data" class="space-y-4 p-5">
            <input type="hidden" name="id" id="certId">

            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Nama Sertifikat</label>
                <input type="text" id="nama_sertifikat" name="nama_sertifikat" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Penerbit</label>
                <input type="text" id="penerbit" name="penerbit" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
            </div>
            <div class="grid gap-3 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Tanggal Terbit</label>
                    <input type="date" id="tanggal_terbit" name="tanggal_terbit" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Tanggal Kadaluarsa</label>
                    <input type="date" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Nomor Sertifikat</label>
                <input type="text" id="nomor_sertifikat" name="nomor_sertifikat" class="w-full rounded-lg border border-slate-300 px-3 py-2">
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Kategori</label>
                <select id="kategori" name="kategori" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                    <option value="">Pilih Kategori</option>
                    <option value="teknis">Teknis</option>
                    <option value="keselamatan">Keselamatan</option>
                    <option value="manajemen">Manajemen</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">File Sertifikat (opsional)</label>
                <input type="file" id="file_sertifikat" name="file_sertifikat" accept=".pdf,.jpg,.jpeg,.png" class="w-full rounded-lg border border-slate-300 px-3 py-2">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" class="rounded-lg bg-slate-100 px-4 py-2 font-semibold text-slate-700" onclick="closeModal()">Batal</button>
                <button type="submit" class="rounded-lg bg-sky-700 px-4 py-2 font-semibold text-white hover:bg-sky-800">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(mode) {
        document.getElementById('certModal').classList.remove('hidden');
        document.getElementById('certModal').classList.add('flex');
        if (mode === 'add') {
            document.getElementById('modalTitle').textContent = 'Tambah Sertifikat';
            document.getElementById('certForm').action = '<?= route_path('/mitra/certificates/store') ?>';
            document.getElementById('certForm').reset();
            document.getElementById('certId').value = '';
        }
    }

    function closeModal() {
        document.getElementById('certModal').classList.add('hidden');
        document.getElementById('certModal').classList.remove('flex');
    }

    function editCertificate(id) {
        openModal('edit');
        document.getElementById('modalTitle').textContent = 'Edit Sertifikat';
        document.getElementById('certForm').action = '<?= route_path('/mitra/certificates/update') ?>';
        document.getElementById('certId').value = id;
    }

    function deleteCertificate(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus sertifikat ini?')) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= route_path('/mitra/certificates/delete') ?>';
        form.innerHTML = `<input type="hidden" name="id" value="${id}">`;
        document.body.appendChild(form);
        form.submit();
    }
</script>
