<section class="space-y-6">
    <h1 class="text-4xl font-semibold text-black">Edit Profil Saya</h1>

    <?php if (!empty($message)): ?>
        <div class="rounded-xl border px-4 py-3 text-sm <?= $message['type'] === 'success' ? 'border-emerald-200 bg-emerald-50 text-emerald-700' : 'border-rose-200 bg-rose-50 text-rose-700' ?>">
            <?= htmlspecialchars($message['text']) ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?= route_path('/mitra/profile/edit') ?>" enctype="multipart/form-data" class="rounded-[30px] bg-white p-8 shadow-[7px_12px_43px_0_rgba(0,0,0,0.14)]">
        <div class="mb-8 text-center">
            <div class="mx-auto h-48 w-48 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow">
                <?php if (!empty($profile['avatar'])): ?>
                    <img src="<?= htmlspecialchars($profile['avatar']) ?>" alt="Foto profil" class="h-full w-full object-cover">
                <?php else: ?>
                    <div class="flex h-full items-center justify-center text-4xl text-slate-400"><?= htmlspecialchars(strtoupper(substr($profile['nama'], 0, 1))) ?></div>
                <?php endif; ?>
            </div>
            <label class="mt-4 inline-block cursor-pointer rounded-[10px] border border-[#006b9b] px-8 py-3 text-xl font-medium text-[#006b9b]">
                Upload Foto
                <input type="file" name="avatar" accept="image/*" class="hidden">
            </label>
        </div>

        <div class="grid gap-5">
            <div>
                <label class="mb-2 block text-xl font-medium text-[#7c838a]">Nama Lengkap</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($profile['nama']) ?>" class="w-full rounded-[20px] bg-[#b0bac3]/40 px-5 py-4 text-xl" required>
            </div>
            <div>
                <label class="mb-2 block text-xl font-medium text-[#7c838a]">Nomor HP</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($profile['phone'] ?: '') ?>" class="w-full rounded-[20px] bg-[#b0bac3]/40 px-5 py-4 text-xl">
            </div>
            <div>
                <label class="mb-2 block text-xl font-medium text-[#7c838a]">Kota</label>
                <input type="text" name="location" value="<?= htmlspecialchars($profile['location'] ?: '') ?>" class="w-full rounded-[20px] bg-[#b0bac3]/40 px-5 py-4 text-xl">
            </div>
            <div>
                <label class="mb-2 block text-xl font-medium text-[#7c838a]">Deskripsi Diri</label>
                <textarea name="bio" rows="4" class="w-full rounded-[20px] bg-[#b0bac3]/40 px-5 py-4 text-xl"><?= htmlspecialchars($profile['bio'] ?: '') ?></textarea>
            </div>
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-4">
            <button type="submit" class="rounded-[10px] bg-[#006b9b] px-12 py-3 text-[22px] font-bold text-white">Simpan</button>
            <a href="<?= route_path('/mitra/profile') ?>" class="rounded-[10px] bg-[#49bef3] px-12 py-3 text-[22px] font-bold text-white">Kembali</a>
        </div>
    </form>
</section>
