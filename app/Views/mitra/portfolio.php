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
        <h1 class="text-3xl font-bold text-slate-900">Portfolio</h1>
        <button class="rounded-xl bg-sky-700 px-4 py-2 font-semibold text-white hover:bg-sky-800" onclick="openModal('add')">+ Tambah Portfolio</button>
    </div>

    <?php if (!empty($message)): ?>
        <div class="rounded-xl border px-4 py-3 text-sm <?= $message['type'] === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' ?>">
            <?= htmlspecialchars($message['text']) ?>
        </div>
    <?php endif; ?>

    <form method="GET" action="<?= route_path('/mitra/portfolio') ?>" class="grid gap-3 rounded-2xl bg-white p-4 shadow-sm md:grid-cols-2">
        <select id="filterKategori" name="category" class="rounded-lg border border-slate-300 px-3 py-2">
            <option value="all" <?= $selectedCategory === 'all' ? 'selected' : '' ?>>Semua Kategori</option>
            <option value="Instalasi AC" <?= $selectedCategory === 'Instalasi AC' ? 'selected' : '' ?>>Instalasi AC</option>
            <option value="Service AC" <?= $selectedCategory === 'Service AC' ? 'selected' : '' ?>>Service AC</option>
            <option value="Instalasi Listrik" <?= $selectedCategory === 'Instalasi Listrik' ? 'selected' : '' ?>>Instalasi Listrik</option>
            <option value="Perbaikan Elektronik" <?= $selectedCategory === 'Perbaikan Elektronik' ? 'selected' : '' ?>>Perbaikan Elektronik</option>
            <option value="Lainnya" <?= $selectedCategory === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
        </select>
        <div class="flex gap-2">
            <input id="searchInput" name="q" type="text" value="<?= htmlspecialchars($searchQuery) ?>" placeholder="Cari portfolio..." class="w-full rounded-lg border border-slate-300 px-3 py-2">
            <button type="submit" class="rounded-lg bg-sky-700 px-4 py-2 font-semibold text-white">Filter</button>
        </div>
    </form>

    <div id="portfolioGrid" class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
        <?php foreach ($portfolios as $item): ?>
            <article class="portfolio-card rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 h-36 rounded-xl bg-gradient-to-br from-sky-100 to-cyan-100"></div>
                <h3 class="text-lg font-bold text-slate-900"><?= htmlspecialchars($item['judul']) ?></h3>
                <p class="mt-2 text-sm text-slate-600"><?= htmlspecialchars(substr($item['deskripsi'], 0, 140)) ?>...</p>
                <div class="mt-3 space-y-1 text-sm text-slate-600">
                    <p><?= htmlspecialchars($item['client_name']) ?> · <?= htmlspecialchars($item['lokasi']) ?></p>
                    <p><?= formatTanggal($item['tanggal_project']) ?></p>
                    <p><?= formatRupiah((float)$item['nilai_project']) ?></p>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <button class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm font-semibold text-slate-700 hover:bg-slate-100" onclick="editPortfolio(<?= (int)$item['id'] ?>)">Edit</button>
                    <button class="rounded-lg border border-rose-200 px-3 py-1.5 text-sm font-semibold text-rose-700 hover:bg-rose-50" onclick="deletePortfolio(<?= (int)$item['id'] ?>)">Hapus</button>
                </div>
            </article>
        <?php endforeach; ?>
    </div>

    <?php if (empty($portfolios)): ?>
        <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center text-slate-600">
            Data portfolio tidak ditemukan untuk filter saat ini.
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
            <a class="rounded-lg border border-slate-300 px-3 py-1.5 <?= $currentPage <= 1 ? 'pointer-events-none opacity-50' : '' ?>" href="<?= route_path('/mitra/portfolio') . '&' . http_build_query($baseQuery + ['page' => $prevPage]) ?>">Sebelumnya</a>
            <span class="font-semibold text-slate-700">Halaman <?= $currentPage ?> / <?= $totalPages ?></span>
            <a class="rounded-lg border border-slate-300 px-3 py-1.5 <?= $currentPage >= $totalPages ? 'pointer-events-none opacity-50' : '' ?>" href="<?= route_path('/mitra/portfolio') . '&' . http_build_query($baseQuery + ['page' => $nextPage]) ?>">Berikutnya</a>
        </div>
    </div>
</section>

<div id="portfolioModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
    <div class="w-full max-w-3xl rounded-2xl bg-white shadow-2xl">
        <div class="flex items-center justify-between rounded-t-2xl bg-sky-700 px-5 py-4 text-white">
            <h2 id="modalTitle" class="text-xl font-bold">Tambah Portfolio</h2>
            <button class="text-2xl" onclick="closeModal()">&times;</button>
        </div>

        <form id="portfolioForm" method="POST" action="<?= route_path('/mitra/portfolio/store') ?>" class="space-y-4 p-5">
            <input type="hidden" name="id" id="portfolioId">

            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Judul Project</label>
                <input type="text" id="judul" name="judul" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
            </div>
            <div>
                <label class="mb-1 block text-sm font-semibold text-slate-700">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" required class="w-full rounded-lg border border-slate-300 px-3 py-2"></textarea>
            </div>
            <div class="grid gap-3 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Kategori</label>
                    <select id="kategori" name="kategori" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                        <option value="">Pilih Kategori</option>
                        <option value="Instalasi AC">Instalasi AC</option>
                        <option value="Service AC">Service AC</option>
                        <option value="Instalasi Listrik">Instalasi Listrik</option>
                        <option value="Perbaikan Elektronik">Perbaikan Elektronik</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Tanggal Project</label>
                    <input type="date" id="tanggal_project" name="tanggal_project" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
            </div>
            <div class="grid gap-3 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nama Klien</label>
                    <input type="text" id="client_name" name="client_name" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Lokasi</label>
                    <input type="text" id="lokasi" name="lokasi" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
            </div>
            <div class="grid gap-3 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Nilai Project</label>
                    <input type="number" id="nilai_project" name="nilai_project" min="0" step="1000" required class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-slate-700">Durasi (hari)</label>
                    <input type="number" id="durasi_hari" name="durasi_hari" min="1" class="w-full rounded-lg border border-slate-300 px-3 py-2">
                </div>
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
        document.getElementById('portfolioModal').classList.remove('hidden');
        document.getElementById('portfolioModal').classList.add('flex');
        if (mode === 'add') {
            document.getElementById('modalTitle').textContent = 'Tambah Portfolio';
            document.getElementById('portfolioForm').action = '<?= route_path('/mitra/portfolio/store') ?>';
            document.getElementById('portfolioForm').reset();
            document.getElementById('portfolioId').value = '';
        }
    }

    function closeModal() {
        document.getElementById('portfolioModal').classList.add('hidden');
        document.getElementById('portfolioModal').classList.remove('flex');
    }

    function editPortfolio(id) {
        openModal('edit');
        document.getElementById('modalTitle').textContent = 'Edit Portfolio';
        document.getElementById('portfolioForm').action = '<?= route_path('/mitra/portfolio/update') ?>';
        document.getElementById('portfolioId').value = id;
    }

    function deletePortfolio(id) {
        if (!confirm('Apakah Anda yakin ingin menghapus portfolio ini?')) return;

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= route_path('/mitra/portfolio/delete') ?>';
        form.innerHTML = `<input type="hidden" name="id" value="${id}">`;
        document.body.appendChild(form);
        form.submit();
    }
</script>
