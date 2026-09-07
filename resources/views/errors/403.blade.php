<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 - Access Forbidden</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center text-center p-4">
        <div class="card border-0 shadow-sm rounded-4 p-5" style="max-width: 500px;">
            <div class="stat-icon bg-danger-subtle text-danger mx-auto mb-4" style="width: 64px; height: 64px; font-size: 2rem;">
                <i class="bi bi-shield-x"></i>
            </div>
            <h1 class="display-5 fw-bold text-dark mb-2">403</h1>
            <h4 class="fw-semibold text-danger mb-3">Access Denied</h4>
            <p class="text-muted mb-4">
                {{ $exception->getMessage() ?: 'You do not have permission to access this page or resource with your current role.' }}
            </p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ url('/') }}" class="btn btn-primary px-4">
                    <i class="bi bi-house-door me-1"></i> Return Home
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary px-3">
                        My Dashboard
                    </a>
                @endauth
            </div>
        </div>
    </div>
</body>
</html>
