<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Kosera Mitra' }} - Platform Mitra Profesional</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #4F46E5;
            --secondary-color: #7C3AED;
            --danger-color: #EF4444;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #E1F5FE;
        }
        
        .navbar {
            background-color: white;
            border-bottom: 1px solid #E5E7EB;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            font-size: 1.5rem;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .sidebar {
            background-color: white;
            border-right: 1px solid #E5E7EB;
            min-height: 100vh;
            padding-top: 2rem;
        }
        
        .sidebar .nav-link {
            color: #6B7280;
            padding: 0.75rem 1.5rem;
            border-left: 3px solid transparent;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #F3F4F6;
            color: var(--primary-color);
            border-left-color: var(--primary-color);
        }
        
        .main-content {
            padding: 2rem;
        }
        
        .card {
            border: 1px solid #E5E7EB;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        
        .page-header {
            margin-bottom: 2rem;
            border-bottom: 1px solid #E5E7EB;
            padding-bottom: 1rem;
        }
        
        .alert-box {
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 1000;
            min-width: 300px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <i class="fas fa-handshake"></i> Kosera Mitra
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle"  href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> {{ auth()->user()->nama }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('mitra.dashboard') }}">Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Alert Messages -->
    <div class="alert-box">
        @if ($message = session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if ($message = session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle"></i> {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    @auth
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-2 sidebar">
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('mitra.dashboard') ? 'active' : '' }}" 
                            href="{{ route('mitra.dashboard') }}">
                            <i class="fas fa-chart-line"></i> Dashboard
                        </a>
                        <a class="nav-link {{ request()->routeIs('mitra.portfolio*') ? 'active' : '' }}" 
                            href="{{ route('mitra.portfolio.index') }}">
                            <i class="fas fa-briefcase"></i> Portfolio
                        </a>
                        <a class="nav-link {{ request()->routeIs('mitra.certificate*') ? 'active' : '' }}" 
                            href="{{ route('mitra.certificate.index') }}">
                            <i class="fas fa-certificate"></i> Sertifikat
                        </a>
                    </nav>
                </div>

                <!-- Main Content -->
                <div class="col-md-10 main-content">
                    @yield('content')
                </div>
            </div>
        </div>
    @else
        <div class="container">
            @yield('content')
        </div>
    @endauth

    <!-- Auto-dismiss alerts after 5 seconds -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });
    </script>
</body>
</html>
