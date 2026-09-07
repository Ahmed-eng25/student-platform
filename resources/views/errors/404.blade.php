<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
    <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center text-center p-4">
        <div class="card border-0 shadow-sm rounded-4 p-5" style="max-width: 500px;">
            <div class="stat-icon bg-warning-subtle text-warning mx-auto mb-4" style="width: 64px; height: 64px; font-size: 2rem;">
                <i class="bi bi-compass"></i>
            </div>
            <h1 class="display-5 fw-bold text-dark mb-2">404</h1>
            <h4 class="fw-semibold text-dark mb-3">Page Not Found</h4>
            <p class="text-muted mb-4">
                The page you are looking for does not exist or has been moved.
            </p>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ url('/') }}" class="btn btn-primary px-4">
                    <i class="bi bi-house-door me-1"></i> Return Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
