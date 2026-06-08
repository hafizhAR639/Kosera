<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard' }} - KOSERA Mitra</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-[#e1f5fe] text-slate-900">
    <div class="flex h-screen">
        @include('components.kosera-sidebar', ['mode' => 'mitra'])

        <!-- Main Content -->
        <main class="min-h-screen flex-1 overflow-y-auto p-1 sm:p-2 lg:p-6 bg-[#e1f5fe]">
            <!-- Page Content -->
            @yield('content')
        </main>
    </div>
</body>
</html>
