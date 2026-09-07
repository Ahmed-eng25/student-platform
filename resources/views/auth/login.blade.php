@extends('layouts.guest')

@section('content')
<div class="text-center mb-4">
    <h3 class="fw-bold text-dark mb-1">Welcome Back</h3>
    <p class="text-muted small">Enter your academic credentials to sign in</p>
</div>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bi bi-envelope"></i>
            </span>
            <input id="email" type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="name@university.edu" autocomplete="username">
        </div>
        @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <label for="password" class="form-label mb-0">Password</label>
            @if (Route::has('password.request'))
                <a class="small text-decoration-none" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bi bi-lock"></i>
            </span>
            <input id="password" type="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" name="password" required placeholder="••••••••" autocomplete="current-password">
        </div>
        @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Remember Me -->
    <div class="mb-3 form-check">
        <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
        <label for="remember_me" class="form-check-label small text-muted">Remember me on this computer</label>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 mb-3 fw-semibold">
        <i class="bi bi-box-arrow-in-right me-1"></i> Sign In
    </button>

    <div class="text-center small text-muted">
        Don't have an account yet? 
        <a href="{{ route('register') }}" class="fw-semibold text-decoration-none">Register as Student</a>
    </div>
</form>
@endsection
