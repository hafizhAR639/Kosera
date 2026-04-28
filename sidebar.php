<?php
use App\Core\Auth;
use App\Core\Database;
use App\Core\Helpers;

// Resolve current page from routed path first, fallback to current script name.
$route = $_GET['r'] ?? '';
$route_map = [
    '/mitra/dashboard' => 'dashboard',
    '/mitra/portfolio' => 'portfolio',
    '/mitra/orders/incoming' => 'orderan',
    '/mitra/orders/history' => 'riwayat',
    '/mitra/profile' => 'profile',
    '/mitra/profile/edit' => 'profile_edit',
    '/mitra/certificates' => 'sertifikat',
];

$current_page = $route_map[$route] ?? basename($_SERVER['PHP_SELF'], '.php');

// Get user data if needed
if (!isset($user)) {
    $user_id = Auth::getCurrentUserId();
    $conn_sidebar = Database::connection();
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn_sidebar->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
}

$avatar_path = $user['avatar'] ?? '';
$avatar_initial = strtoupper(substr($user['nama'] ?? 'U', 0, 1));

$nav = [
    ['key' => 'dashboard', 'label' => 'Dashboard', 'href' => Helpers::routePath('/mitra/dashboard')],
    ['key' => 'portfolio', 'label' => 'Layanan', 'href' => Helpers::routePath('/mitra/portfolio')],
    ['key' => 'orderan', 'label' => 'Orderan Masuk', 'href' => Helpers::routePath('/mitra/orders/incoming')],
    ['key' => 'riwayat', 'label' => 'Detail/Riwayat', 'href' => Helpers::routePath('/mitra/orders/history')],
    ['key' => 'profile', 'label' => 'Profil Saya', 'href' => Helpers::routePath('/mitra/profile')],
];
?>

<aside class="fixed left-0 top-0 z-30 hidden h-screen w-[270px] shrink-0 overflow-hidden rounded-r-[30px] bg-[#fbfbfb]/95 p-6 shadow-[7px_12px_43px_0_rgba(0,0,0,0.14)] backdrop-blur lg:block">
    <a href="<?= Helpers::routePath('/') ?>" class="mb-8 block">
        <img src="img/logos/kosera-logo.png" alt="Kosera" class="h-12 w-auto object-contain">
    </a>

    <div class="mb-8 text-center">
        <?php if (!empty($avatar_path)): ?>
            <img src="<?= htmlspecialchars($avatar_path) ?>" alt="Foto profil mitra" class="mx-auto h-[136px] w-[136px] rounded-full border-4 border-white object-cover shadow-md">
        <?php else: ?>
            <div class="mx-auto flex h-[136px] w-[136px] items-center justify-center rounded-full bg-slate-100 text-4xl font-bold text-slate-600">
                <?= htmlspecialchars($avatar_initial) ?>
            </div>
        <?php endif; ?>
        <p class="mt-3 text-2xl font-semibold text-[#006b9b]">Profil</p>
    </div>

    <nav class="space-y-3 text-sm font-semibold">
        <?php foreach ($nav as $item): ?>
            <?php
            $isProfileRoute = $item['key'] === 'profile' && ($current_page === 'profile' || $current_page === 'profile_edit');
            $isActive = $isProfileRoute || $current_page === $item['key'];
            ?>
            <a href="<?= $item['href'] ?>" class="flex items-center gap-3 rounded-lg px-4 py-2.5 <?= $isActive ? 'bg-[#006b9b] text-white' : 'bg-[#fbfbfb] text-[#006b9b]' ?>">
                <?= $item['label'] ?>
            </a>
        <?php endforeach; ?>
    </nav>

    <div class="mt-10 space-y-2">
        <p class="text-center text-[22px] font-medium text-[#006b9b]">Pengaturan</p>
        <form method="POST" action="<?= Helpers::routePath('/logout') ?>" onsubmit="return confirm('Apakah Anda yakin ingin logout?')">
            <button type="submit" class="w-full text-center text-[22px] font-medium text-[#006b9b]">Logout</button>
        </form>
    </div>
</aside>
