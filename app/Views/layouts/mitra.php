<?php
/** @var string $content */

use App\Core\Helpers;

$route = $_GET['r'] ?? '';

$mobile_nav = [
    ['path' => '/mitra/dashboard', 'label' => 'Dashboard'],
    ['path' => '/mitra/portfolio', 'label' => 'Layanan'],
    ['path' => '/mitra/orders/incoming', 'label' => 'Orderan'],
    ['path' => '/mitra/orders/history', 'label' => 'Riwayat'],
    ['path' => '/mitra/profile', 'label' => 'Profil'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(($title ?? 'Halaman') . ' - KOSERA Mitra') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[radial-gradient(circle_at_top,#d7f0fb_0%,#e1f5fe_40%,#ecf7ff_100%)] text-slate-900">
    <?php include __DIR__ . '/../../../sidebar.php'; ?>

    <main class="min-h-screen p-1 sm:p-2 lg:ml-[286px] lg:p-6">
        <div class="mb-4 overflow-x-auto rounded-2xl bg-white/80 p-2 shadow-sm backdrop-blur lg:hidden">
            <div class="flex min-w-max gap-2 text-sm font-semibold">
                <?php foreach ($mobile_nav as $item): ?>
                    <?php $active = $route === $item['path']; ?>
                    <a href="<?= Helpers::routePath($item['path']) ?>" class="rounded-xl px-4 py-2 <?= $active ? 'bg-[#006b9b] text-white' : 'bg-slate-100 text-[#006b9b]' ?>"><?= $item['label'] ?></a>
                <?php endforeach; ?>
            </div>
        </div>

        <?= $content ?>
    </main>
</body>
</html>
