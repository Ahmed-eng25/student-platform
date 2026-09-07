<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Student Platform') }} - @yield('title', 'Dashboard')</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts and Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body>
    <div id="dashboard-wrapper">
        <!-- Desktop Sidebar -->
        <aside id="sidebar">
            @include('layouts.sidebar')
        </aside>

        <!-- Mobile Offcanvas Sidebar -->
        <div class="offcanvas offcanvas-start bg-dark text-white p-0" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel" style="width: 260px;">
            <div class="offcanvas-header p-3 border-bottom border-secondary border-opacity-25">
                <h5 class="offcanvas-title d-flex align-items-center gap-2 text-white" id="mobileSidebarLabel">
                    <i class="bi bi-mortarboard-fill text-primary"></i>
                    <span>StudentPlatform</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body p-0">
                @include('layouts.sidebar')
            </div>
        </div>

        <!-- Main Content Area -->
        <div id="main-content">
            <!-- Top Navbar -->
            <header class="top-navbar d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <button class="btn btn-outline-secondary d-lg-none py-1 px-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-label="Toggle navigation">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <div>
                        <h1 class="h5 fw-bold mb-0 text-dark">@yield('title', 'Dashboard')</h1>
                        @if (isset($breadcrumb))
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0 small text-muted">
                                    {{ $breadcrumb }}
                                </ol>
                            </nav>
                        @endif
                    </div>
                </div>

                <div class="d-flex align-items-center gap-3">
                    @php
                        $roleColors = [
                            'admin' => 'danger',
                            'doctor' => 'success',
                            'student' => 'primary',
                        ];
                        $roleColor = $roleColors[auth()->user()->role] ?? 'secondary';
                    @endphp

                    <span class="badge bg-{{ $roleColor }}-subtle text-{{ $roleColor }} px-2 py-1 text-uppercase fw-bold" style="letter-spacing: 0.05em; font-size: 0.75rem;">
                        {{ auth()->user()->role }}
                    </span>

                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 py-1 px-2 rounded-3 border" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 28px; height: 28px; font-size: 0.8rem; font-weight: 600;">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </span>
                            <span class="d-none d-md-inline fw-medium text-dark small">{{ auth()->user()->name }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-1">
                            <li><h6 class="dropdown-header small text-muted">{{ auth()->user()->email }}</h6></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person"></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                        <i class="bi bi-box-arrow-right"></i>
                                        <span>Log Out</span>
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            <!-- Page Body -->
            <main class="flex-grow-1 p-3 p-md-4">
                <div class="container-fluid max-w-7xl">
                    <x-alert />
                    {{ $slot ?? '' }}
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-white border-top py-3 px-4 text-center text-muted small">
                &copy; {{ date('Y') }} Student Management Platform. Clean, modern academic management.
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
