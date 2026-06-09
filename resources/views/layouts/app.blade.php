<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Barbershop Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #d4af37;
            --accent-color: #2d2d2d;
            --light-text: #f0f0f0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f0f0f 0%, #1a1a1a 100%);
            color: var(--light-text);
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: repeating-linear-gradient(90deg, transparent, transparent 2px, rgba(212, 175, 55, 0.03) 2px, rgba(212, 175, 55, 0.03) 4px);
            pointer-events: none;
            z-index: 1;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            box-shadow: 0 4px 20px rgba(212, 175, 55, 0.3);
            border-bottom: 2px solid var(--secondary-color);
            position: relative;
            z-index: 10;
            animation: slideDown 0.6s ease;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.8rem;
            letter-spacing: 2px;
            color: var(--secondary-color) !important;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
            animation: glow 2s ease-in-out infinite;
        }

        @keyframes glow {
            0%, 100% {
                text-shadow: 0 2px 4px rgba(0,0,0,0.5), 0 0 10px rgba(212, 175, 55, 0.3);
            }
            50% {
                text-shadow: 0 2px 4px rgba(0,0,0,0.5), 0 0 20px rgba(212, 175, 55, 0.6);
            }
        }

        .nav-link {
            color: var(--light-text) !important;
            transition: all 0.3s ease;
            margin-left: 10px;
            position: relative;
            padding-bottom: 5px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--secondary-color);
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .card {
            background: var(--accent-color);
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: var(--light-text);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
        }

        .card-header {
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.1) 0%, rgba(212, 175, 55, 0.05) 100%);
            border-bottom: 2px solid var(--secondary-color);
            color: var(--secondary-color);
            font-weight: 600;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--secondary-color) 0%, #ffd700 100%);
            border: none;
            color: var(--primary-color);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.4);
            color: var(--primary-color);
        }

        .btn-secondary, .btn-sm, .btn-success, .btn-info, .btn-warning, .btn-danger {
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-sm {
            border-radius: 6px;
        }

        .badge-pending {
            background-color: #ffc107;
            color: #333;
        }

        .badge-approved {
            background-color: #28a745;
            color: white;
        }

        .badge-rejected {
            background-color: #dc3545;
            color: white;
        }

        .badge-completed {
            background-color: #17a2b8;
            color: white;
        }

        .badge-cancelled {
            background-color: #6c757d;
            color: white;
        }

        .alert {
            border: none;
            border-radius: 10px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }

        .table {
            border-radius: 10px;
            overflow: hidden;
            color: var(--light-text);
        }

        .table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .table tbody tr {
            background: var(--accent-color);
            border-color: rgba(212, 175, 55, 0.2);
        }

        .table tbody tr:hover {
            background-color: rgba(212, 175, 55, 0.1);
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card h5 {
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .stat-card h2 {
            font-weight: bold;
            font-size: 2.5rem;
        }

        .form-control, .form-select {
            background: var(--accent-color);
            border: 1px solid rgba(212, 175, 55, 0.3);
            color: var(--light-text);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control::placeholder {
            color: #999;
        }

        .form-control:focus, .form-select:focus {
            background: var(--accent-color);
            border-color: var(--secondary-color);
            color: var(--light-text);
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }

        .form-label {
            color: var(--light-text);
            font-weight: 500;
        }

        .footer {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
            border-top: 2px solid var(--secondary-color);
        }

        .main-content {
            padding: 30px 0;
            position: relative;
            z-index: 2;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            color: var(--secondary-color);
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }

        .breadcrumb {
            background-color: transparent;
            padding: 0;
        }

        .breadcrumb-item a {
            color: var(--secondary-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .breadcrumb-item a:hover {
            text-decoration: underline;
            color: #ffd700;
        }

        .breadcrumb-item.active {
            color: var(--light-text);
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        .fade-in-down {
            animation: fadeInDown 0.6s ease;
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease;
        }

        .fade-in-left {
            animation: fadeInLeft 0.6s ease;
        }

        .float {
            animation: float 3s ease-in-out infinite;
        }

        .interactive-hover {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .interactive-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(212, 175, 55, 0.3);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .spin {
            animation: spin 2s linear infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .pulse {
            animation: pulse 2s ease-in-out infinite;
        }

        @media (max-width: 768px) {
            .sidebar {
                margin-bottom: 20px;
            }

            .stat-card h2 {
                font-size: 1.8rem;
            }

            .navbar-brand {
                font-size: 1.4rem;
            }
        }

        :root {
            --barber-red: #d63447;
            --barber-blue: #1f8ac0;
            --barber-cream: #f7efe1;
            --barber-ink: #111318;
            --barber-panel: rgba(27, 29, 35, 0.88);
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            min-height: 100vh;
            background:
                radial-gradient(circle at 18% 12%, rgba(214, 52, 71, 0.22), transparent 28%),
                radial-gradient(circle at 88% 18%, rgba(31, 138, 192, 0.22), transparent 30%),
                linear-gradient(135deg, #0b0d12 0%, #191b22 47%, #0f1117 100%);
            overflow-x: hidden;
        }

        body::before {
            background-image:
                repeating-linear-gradient(115deg, rgba(214, 52, 71, 0.07) 0 12px, rgba(247, 239, 225, 0.04) 12px 24px, rgba(31, 138, 192, 0.07) 24px 36px),
                linear-gradient(90deg, rgba(212, 175, 55, 0.04), transparent 34%, rgba(212, 175, 55, 0.03));
            background-size: 240px 240px, 100% 100%;
            animation: barberStripe 18s linear infinite;
            opacity: 0.9;
        }

        body::after {
            content: '';
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 1;
            background-image:
                radial-gradient(circle at 20% 75%, rgba(212, 175, 55, 0.10), transparent 24%),
                radial-gradient(circle at 76% 62%, rgba(31, 138, 192, 0.10), transparent 23%);
            animation: ambienceDrift 14s ease-in-out infinite alternate;
        }

        @keyframes barberStripe {
            from { background-position: 0 0, 0 0; }
            to { background-position: 240px 0, 0 0; }
        }

        @keyframes ambienceDrift {
            from { transform: translate3d(-1%, 0, 0) scale(1); }
            to { transform: translate3d(1%, -1%, 0) scale(1.04); }
        }

        .barber-ambient {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        .barber-ambient .pole {
            position: absolute;
            width: 78px;
            height: 230px;
            border: 2px solid rgba(247, 239, 225, 0.36);
            border-radius: 40px;
            background:
                repeating-linear-gradient(135deg, rgba(214, 52, 71, 0.74) 0 18px, rgba(247, 239, 225, 0.9) 18px 36px, rgba(31, 138, 192, 0.74) 36px 54px);
            background-size: 100% 180px;
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.35), inset 0 0 18px rgba(255, 255, 255, 0.25);
            opacity: 0.55;
            animation: poleRoll 4s linear infinite, slowFloat 8s ease-in-out infinite;
        }

        .barber-ambient .pole-left {
            left: 3vw;
            top: 18vh;
            transform: rotate(-8deg);
        }

        .barber-ambient .pole-right {
            right: 4vw;
            bottom: 13vh;
            transform: rotate(9deg);
            animation-delay: -1.2s;
        }

        .barber-ambient .tool {
            position: absolute;
            color: rgba(212, 175, 55, 0.22);
            font-size: clamp(42px, 6vw, 92px);
            filter: drop-shadow(0 20px 28px rgba(0, 0, 0, 0.24));
            animation: toolFloat 10s ease-in-out infinite;
        }

        .barber-ambient .tool-scissors {
            left: 12vw;
            bottom: 12vh;
        }

        .barber-ambient .tool-comb {
            right: 15vw;
            top: 18vh;
            animation-delay: -3s;
        }

        @keyframes poleRoll {
            from { background-position: 0 0; }
            to { background-position: 0 180px; }
        }

        @keyframes slowFloat {
            0%, 100% { translate: 0 0; }
            50% { translate: 0 -18px; }
        }

        @keyframes toolFloat {
            0%, 100% { transform: translateY(0) rotate(-8deg); }
            50% { transform: translateY(-24px) rotate(8deg); }
        }

        .navbar {
            backdrop-filter: blur(16px);
            background: linear-gradient(135deg, rgba(12, 14, 18, 0.94) 0%, rgba(36, 38, 46, 0.9) 100%);
        }

        .navbar-brand i {
            display: inline-block;
            animation: scissorSnip 2.8s ease-in-out infinite;
        }

        @keyframes scissorSnip {
            0%, 100% { transform: rotate(0deg) scale(1); }
            45% { transform: rotate(-13deg) scale(1.08); }
            62% { transform: rotate(10deg) scale(1.03); }
        }

        .main-content > .container-fluid {
            position: relative;
            z-index: 3;
        }

        .card,
        .stat-card,
        .alert,
        .table,
        .page-header {
            animation: riseIn 0.55s ease both;
        }

        .card {
            background: linear-gradient(145deg, rgba(43, 45, 53, 0.92), rgba(18, 20, 26, 0.92));
            border: 1px solid rgba(212, 175, 55, 0.28);
            border-radius: 8px;
            backdrop-filter: blur(14px);
        }

        .card:hover {
            border-color: rgba(212, 175, 55, 0.55);
        }

        .card-header {
            letter-spacing: 0.3px;
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            isolation: isolate;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(120deg, transparent 20%, rgba(255, 255, 255, 0.18) 45%, transparent 70%);
            transform: translateX(-120%);
            animation: shineSweep 4.5s ease-in-out infinite;
            z-index: -1;
        }

        .btn {
            border-radius: 8px;
        }

        .btn:hover,
        .nav-link:hover {
            filter: saturate(1.08);
        }

        .table thead {
            background: linear-gradient(135deg, var(--barber-red), var(--barber-blue));
        }

        .table tbody tr {
            transition: transform 0.2s ease, background-color 0.2s ease;
        }

        .table tbody tr:hover {
            transform: translateX(4px);
        }

        @keyframes riseIn {
            from { opacity: 0; transform: translateY(18px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes shineSweep {
            0%, 45% { transform: translateX(-120%); }
            75%, 100% { transform: translateX(120%); }
        }

        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                scroll-behavior: auto !important;
            }
        }

        @media (max-width: 768px) {
            .barber-ambient .pole {
                width: 50px;
                height: 160px;
                opacity: 0.32;
            }

            .barber-ambient .tool {
                opacity: 0.45;
            }
        }
    </style>
    @yield('extra-styles')
</head>
<body>
    <div class="barber-ambient" aria-hidden="true">
        <span class="pole pole-left"></span>
        <span class="pole pole-right"></span>
        <i class="bi bi-scissors tool tool-scissors"></i>
        <i class="bi bi-list tool tool-comb"></i>
    </div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-scissors"></i> BarberShop Elite
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        @if (Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.bookings.index') }}">
                                    <i class="bi bi-calendar2"></i> Booking
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.barbers.index') }}">
                                    <i class="bi bi-person"></i> Tukang Cukur
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.services.index') }}">
                                    <i class="bi bi-scissors"></i> Layanan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.payments.index') }}">
                                    <i class="bi bi-credit-card"></i> Pembayaran
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('customer.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('customer.bookings.create') }}">
                                    <i class="bi bi-plus-circle"></i> Booking Baru
                                </a>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" style="background: var(--accent-color); border-color: var(--secondary-color);">
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="dropdown-item" type="submit" style="color: var(--light-text);">
                                            <i class="bi bi-box-arrow-right"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: brightness(0) invert(1);"></button>
                </div>
            @endif

            @if ($message = Session::get('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" style="filter: brightness(0) invert(1);"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2026 Barbershop Elite. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('extra-scripts')
</body>
</html>
