@php
    $role = auth()->user()->role;
@endphp

<div class="d-flex flex-column h-100">
    <div class="sidebar-brand">
        <i class="bi bi-mortarboard-fill fs-4 text-primary"></i>
        <span>StudentPlatform</span>
    </div>

    <div class="flex-grow-1 overflow-auto py-2">
        {{-- Dashboard Link --}}
        <div class="nav-section-title">Dashboard</div>
        @if ($role === 'admin')
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Admin Dashboard</span>
            </a>
        @elseif ($role === 'doctor')
            <a href="{{ route('doctor.dashboard') }}" class="nav-link {{ request()->routeIs('doctor.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Doctor Dashboard</span>
            </a>
        @elseif ($role === 'student')
            <a href="{{ route('student.dashboard') }}" class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Student Dashboard</span>
            </a>
        @endif

        {{-- Academic Section --}}
        <div class="nav-section-title">Academic</div>
        @if ($role === 'admin')
            <a href="{{ route('admin.courses.index') }}" class="nav-link {{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark-fill"></i>
                <span>Courses</span>
            </a>
            <a href="{{ route('admin.enrollments.index') }}" class="nav-link {{ request()->routeIs('admin.enrollments.*') ? 'active' : '' }}">
                <i class="bi bi-card-checklist"></i>
                <span>Enrollments</span>
            </a>
            <a href="{{ route('admin.grades.index') }}" class="nav-link {{ request()->routeIs('admin.grades.*') ? 'active' : '' }}">
                <i class="bi bi-award-fill"></i>
                <span>Grades</span>
            </a>
        @elseif ($role === 'doctor')
            <a href="{{ route('doctor.courses.index') }}" class="nav-link {{ request()->routeIs('doctor.courses.*') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark-fill"></i>
                <span>My Courses</span>
            </a>
        @elseif ($role === 'student')
            <a href="{{ route('student.courses.index') }}" class="nav-link {{ request()->routeIs('student.courses.*') ? 'active' : '' }}">
                <i class="bi bi-journal-bookmark-fill"></i>
                <span>My Courses</span>
            </a>
            <a href="{{ route('student.grades.index') }}" class="nav-link {{ request()->routeIs('student.grades.*') ? 'active' : '' }}">
                <i class="bi bi-award-fill"></i>
                <span>My Grades</span>
            </a>
        @endif

        {{-- Management Section (Admin Only) --}}
        @if ($role === 'admin')
            <div class="nav-section-title">Management</div>
            <a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Students</span>
            </a>
            <a href="{{ route('admin.doctors.index') }}" class="nav-link {{ request()->routeIs('admin.doctors.*') ? 'active' : '' }}">
                <i class="bi bi-person-workspace"></i>
                <span>Doctors</span>
            </a>
            <a href="{{ route('admin.departments.index') }}" class="nav-link {{ request()->routeIs('admin.departments.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Departments</span>
            </a>
        @endif

        {{-- Account Section --}}
        <div class="nav-section-title">Account</div>
        <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i>
            <span>Profile</span>
        </a>
    </div>

    {{-- User Info at Sidebar Bottom --}}
    <div class="p-3 border-top border-secondary border-opacity-25 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center overflow-hidden me-2">
            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2 flex-shrink-0" style="width: 36px; height: 36px; font-weight: 600;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="text-truncate">
                <div class="text-white text-truncate fw-semibold small">{{ auth()->user()->name }}</div>
                <div class="text-muted small text-capitalize">{{ $role }}</div>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" class="m-0">
            @csrf
            <button type="submit" class="btn btn-sm btn-outline-light border-0" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
            </button>
        </form>
    </div>
</div>
