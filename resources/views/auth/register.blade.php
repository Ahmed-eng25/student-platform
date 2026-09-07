@extends('layouts.guest')

@section('content')
<div class="text-center mb-4">
    <span class="badge bg-primary-subtle text-primary mb-2 px-3 py-1 rounded-pill">Student Portal</span>
    <h3 class="fw-bold text-dark mb-1">Create Student Account</h3>
    <p class="text-muted small">Register as a student to access your academic dashboard</p>
</div>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Full Name -->
    <div class="mb-3">
        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bi bi-person"></i>
            </span>
            <input id="name" type="text" class="form-control border-start-0 ps-0 @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus placeholder="e.g. John Doe">
        </div>
        @error('name')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email Address -->
    <div class="mb-3">
        <label for="email" class="form-label">University Email <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bi bi-envelope"></i>
            </span>
            <input id="email" type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="student@university.edu">
        </div>
        @error('email')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Department & Level -->
    <div class="row g-2 mb-3">
        <div class="col-sm-7">
            <label for="department_id" class="form-label">Department <span class="text-danger">*</span></label>
            <select id="department_id" name="department_id" class="form-select @error('department_id') is-invalid @enderror" required>
                <option value="" disabled {{ old('department_id') ? '' : 'selected' }}>Select department...</option>
                @foreach ($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                        {{ $dept->name }}
                    </option>
                @endforeach
            </select>
            @error('department_id')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-sm-5">
            <label for="level" class="form-label">Academic Level <span class="text-danger">*</span></label>
            <select id="level" name="level" class="form-select @error('level') is-invalid @enderror" required>
                <option value="1" {{ old('level', 1) == 1 ? 'selected' : '' }}>Level 1 (Freshman)</option>
                <option value="2" {{ old('level') == 2 ? 'selected' : '' }}>Level 2 (Sophomore)</option>
                <option value="3" {{ old('level') == 3 ? 'selected' : '' }}>Level 3 (Junior)</option>
                <option value="4" {{ old('level') == 4 ? 'selected' : '' }}>Level 4 (Senior)</option>
            </select>
            @error('level')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <!-- Phone Number -->
    <div class="mb-3">
        <label for="phone" class="form-label">Phone Number (Optional)</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bi bi-telephone"></i>
            </span>
            <input id="phone" type="text" class="form-control border-start-0 ps-0 @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="+1 234 567 890">
        </div>
        @error('phone')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bi bi-lock"></i>
            </span>
            <input id="password" type="password" class="form-control border-start-0 ps-0 @error('password') is-invalid @enderror" name="password" required placeholder="Minimum 8 characters">
        </div>
        @error('password')
            <div class="text-danger small mt-1">{{ $message }}</div>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-4">
        <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted">
                <i class="bi bi-shield-check"></i>
            </span>
            <input id="password_confirmation" type="password" class="form-control border-start-0 ps-0" name="password_confirmation" required placeholder="Re-enter password">
        </div>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 mb-3 fw-semibold">
        <i class="bi bi-person-check me-1"></i> Register Student Account
    </button>

    <div class="text-center small text-muted">
        Already registered? 
        <a href="{{ route('login') }}" class="fw-semibold text-decoration-none">Sign in here</a>
    </div>
</form>
@endsection
