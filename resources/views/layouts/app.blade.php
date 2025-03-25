<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HR') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .nav-link {
            transition: all 0.3s ease-in-out;
        }
        .nav-link:hover, .nav-link.active {
            background-color: #f8f9fa;
            color: #007bff;
        }
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        }
        .btn-clear {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn-clear:hover {
            background-color: #c82333;
        }
        .sidebar {
            height: 100vh; /* Full height */
            overflow-y: auto; /* Scrollable if content overflows */
        }
        @media (max-width: 767.98px) {
            .sidebar {
                height: auto; /* Auto height on mobile */
            }
        }
    </style>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    HR System
                </a>
                <!-- Toggle Button for Mobile -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" 
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto"></ul>
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        <!-- Combined Dropdown Menu -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" 
                               class="nav-link dropdown-toggle" 
                               href="#" 
                               role="button"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                               {{ Auth::user()->name }}
                            </a>
                        
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <!-- Sidebar Menu Items -->
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('users') }}">
                                    <i class="bi bi-people me-2"></i> Employees
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('attendances') }}">
                                    <i class="bi bi-card-list me-2"></i> Attendance
                                </a>
                                <a class="dropdown-item d-flex align-items-center" href="{{ route('settings') }}">
                                    <i class="bi bi-gear me-2"></i> Settings
                                </a>
                                <div class="dropdown-divider"></div>
                                <!-- Logout -->
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                        
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar (Visible on Desktop) -->
                <div class="col-md-3 col-lg-2 bg-white sidebar p-3 shadow-sm border-end d-none d-md-block">
                    <div class="d-flex flex-column align-items-center text-center py-3">
                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" 
                             class="rounded-circle mb-2" 
                             alt="User Avatar" 
                             style="width: 80px; height: 80px; object-fit: cover;">
                    </div>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded text-dark fw-medium d-flex align-items-center" href="{{ route('users') }}">
                                <i class="bi bi-people me-2"></i> Employees
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded text-dark fw-medium d-flex align-items-center" href="{{ route('attendances') }}">
                                <i class="bi bi-card-list me-2"></i> Attendance
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link py-2 px-3 rounded text-dark fw-medium d-flex align-items-center" href="{{ route('settings') }}">
                                <i class="bi bi-gear me-2"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Main Content -->
                <div class="col-md-9 col-lg-10 py-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</body>
</html>