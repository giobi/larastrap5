<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', config('app.name'))</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Livewire Styles -->
    @livewireStyles
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --pastel-primary: #95B8D1;    /* Soft Blue */
            --pastel-secondary: #B8E0D2;  /* Mint Green */
            --pastel-success: #D8F3DC;    /* Light Sage */
            --pastel-danger: #FFB4B4;     /* Soft Coral */
            --pastel-warning: #FFE5B4;    /* Peach */
            --pastel-info: #BDE0FE;       /* Sky Blue */
            --pastel-background: #2B2D42; /* Dark Blue-Gray */
            --pastel-card: #3C4051;       /* Lighter Blue-Gray */
            --pastel-text: #EDF2F4;       /* Off-White */
        }

        body {
            background-color: var(--pastel-background);
            min-height: 100vh;
            color: var(--pastel-text);
        }

        .navbar {
            background-color: var(--pastel-card) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .navbar-brand, .nav-link {
            color: var(--pastel-text) !important;
        }

        .nav-link:hover {
            color: var(--pastel-primary) !important;
        }

        .nav-item {
            margin: 0 5px;
        }

        .nav-link {
            padding: 8px 16px !important;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-1px);
        }

        .nav-link.active {
            background-color: var(--pastel-primary);
            color: var(--pastel-background) !important;
        }

        .nav-link.active:hover {
            background-color: var(--pastel-primary);
            opacity: 0.9;
        }

        .nav-link i {
            transition: transform 0.3s ease;
        }

        .nav-link:hover i {
            transform: scale(1.2);
        }

        .navbar .btn-link {
            color: var(--pastel-text) !important;
        }

        .navbar .btn-link:hover {
            color: var(--pastel-primary) !important;
            text-decoration: none;
        }

        .card {
            background-color: var(--pastel-card);
            border: none;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
        }

        .card-header {
            background-color: rgba(0, 0, 0, 0.2);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-primary {
            background-color: var(--pastel-primary);
            border-color: var(--pastel-primary);
            color: var(--pastel-background);
        }

        .btn-primary:hover {
            background-color: #7FA8C1;
            border-color: #7FA8C1;
        }

        .btn-success {
            background-color: var(--pastel-success);
            border-color: var(--pastel-success);
            color: var(--pastel-background);
        }

        .btn-danger {
            background-color: var(--pastel-danger);
            border-color: var(--pastel-danger);
            color: var(--pastel-background);
        }

        .btn-warning {
            background-color: var(--pastel-warning);
            border-color: var(--pastel-warning);
            color: var(--pastel-background);
        }

        .btn-info {
            background-color: var(--pastel-info);
            border-color: var(--pastel-info);
            color: var(--pastel-background);
        }

        .alert-success {
            background-color: var(--pastel-success);
            border-color: #A8D5BD;
            color: var(--pastel-background);
        }

        .alert-danger {
            background-color: var(--pastel-danger);
            border-color: #E5A4A4;
            color: var(--pastel-background);
        }

        .badge {
            font-weight: 500;
        }

        .badge-primary {
            background-color: var(--pastel-primary);
            color: var(--pastel-background);
        }

        .badge-success {
            background-color: var(--pastel-success);
            color: var(--pastel-background);
        }

        .badge-danger {
            background-color: var(--pastel-danger);
            color: var(--pastel-background);
        }

        .badge-warning {
            background-color: var(--pastel-warning);
            color: var(--pastel-background);
        }

        .badge-info {
            background-color: var(--pastel-info);
            color: var(--pastel-background);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/dashboard">
                <i class="fas fa-building me-2"></i>
                {{ config('app.name') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" href="/dashboard">
                            <i class="fas fa-home me-1"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('user*') ? 'active' : '' }}" href="/user">
                            <i class="fas fa-user me-1"></i>
                            {{ __('users.users') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('clients*') ? 'active' : '' }}" href="{{ route('clients.index') }}">
                            <i class="fas fa-users me-1"></i>
                            Clienti
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('projects*') ? 'active' : '' }}" href="{{ route('projects.index') }}">
                            <i class="fas fa-project-diagram me-1"></i>
                            Progetti
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('system*') ? 'active' : '' }}" href="/system">
                            <i class="fas fa-server me-1"></i>
                            System
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">{{ __('auth.logout') }}</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>

    <!-- Livewire Scripts -->
    @livewireScripts
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 