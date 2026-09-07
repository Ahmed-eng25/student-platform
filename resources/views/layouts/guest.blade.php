<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Student Platform') }}</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center py-5 px-3">
        <div class="text-center mb-4">
            <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none text-dark">
                <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 44px; height: 44px;">
                    <i class="bi bi-mortarboard-fill fs-4"></i>
                </div>
                <span class="fs-4 fw-bold text-brand-primary">StudentPlatform</span>
            </a>
        </div>

        <div class="card border shadow-sm rounded-4 w-100" style="max-width: 460px;">
            <div class="card-body p-4 p-sm-5">
                <x-alert />
                {{ $slot ?? '' }}
                @yield('content')
            </div>
        </div>

        <div class="text-center mt-4 text-muted small">
            <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                <i class="bi bi-arrow-left me-1"></i> Back to Homepage
            </a>
        </div>
    </div>
</body>
</html>
