@extends('layouts.guest')

@section('content')
<div class="text-center mb-4">
    <div class="stat-icon bg-primary-subtle text-primary mx-auto mb-3">
        <i class="bi bi-key-fill"></i>
    </div>
    <h3 class="fw-bold text-dark mb-1">Forgot Password</h3>
    <p class="text-muted small">Enter your email address and we'll send you a password reset link.</p>
</div>

@if (session('status'))
    <div class="alert alert-success small mb-3">
        {{ session('status') }}
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bi bi-envelope"></i>
            </span>
            <input id="email" type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus placeholder="name@university.edu">
        </div>
        @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 mb-3 fw-semibold">
        Email Password Reset Link
    </button>

    <div class="text-center small text-muted">
        Remembered your credentials?
        <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Back to Login</a>
    </div>
</form>
@endsection
