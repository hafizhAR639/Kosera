<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $pageTitle ?? 'KOSERA' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: {{ $bgColor ?? '#f4faff' }};
            color: #1e293b;
        }
    </style>
</head>
<body class="min-h-screen overflow-x-hidden bg-[#f4faff] text-[#141d21]">
    <div class="flex h-screen">
        @include('components.kosera-sidebar', ['mode' => 'user'])

        <!-- Main Content -->
        <main class="min-h-screen flex-1 overflow-y-auto p-1 sm:p-2 lg:p-6 {{ $mainClass ?? '' }}">
            {{ $slot }}
        </main>
    </div>
</body>
</html>
