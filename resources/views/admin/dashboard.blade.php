@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Page Header -->
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">Academic Overview</h2>
        <p class="text-muted small mb-0">Welcome back, {{ auth()->user()->name }}. Here is a summary of the university system.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-person-plus me-1"></i> Add Student
        </a>
        <a href="{{ route('admin.courses.create') }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-journal-plus me-1"></i> Add Course
        </a>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <x-stat-card 
            title="Total Students" 
            value="{{ $stats['total_students'] }}" 
            icon="people-fill" 
            color="primary"
            badge="Enrolled"
        />
    </div>
    <div class="col-sm-6 col-xl-3">
        <x-stat-card 
            title="Total Doctors" 
            value="{{ $stats['total_doctors'] }}" 
            icon="person-workspace" 
            color="success"
            badge="Faculty"
        />
    </div>
    <div class="col-sm-6 col-xl-3">
        <x-stat-card 
            title="Total Courses" 
            value="{{ $stats['total_courses'] }}" 
            icon="journal-bookmark-fill" 
            color="warning"
            badge="Active"
        />
    </div>
    <div class="col-sm-6 col-xl-3">
        <x-stat-card 
            title="Departments" 
            value="{{ $stats['total_departments'] }}" 
            icon="building" 
            color="info"
            badge="Academic Units"
        />
    </div>
</div>

<!-- Main Tables Section -->
<div class="row g-4">
    <!-- Recent Students -->
    <div class="col-lg-6">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-people text-primary fs-5"></i>
                    <h5 class="fw-bold mb-0 text-dark">Recently Added Students</h5>
                </div>
                <a href="{{ route('admin.students.index') }}" class="small text-decoration-none fw-semibold">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive border-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Code</th>
                                <th>Department</th>
                                <th>Level</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentStudents as $student)
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $student->user->name ?? 'N/A' }}</div>
                                        <div class="text-muted small">{{ $student->user->email ?? '' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $student->student_code }}</span>
                                    </td>
                                    <td>{{ $student->department->name ?? 'Unassigned' }}</td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">Level {{ $student->level }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                        No students registered yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Courses -->
    <div class="col-lg-6">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-journal-bookmark text-success fs-5"></i>
                    <h5 class="fw-bold mb-0 text-dark">Recent Courses</h5>
                </div>
                <a href="{{ route('admin.courses.index') }}" class="small text-decoration-none fw-semibold">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive border-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Course Name</th>
                                <th>Department</th>
                                <th>Instructor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentCourses as $course)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary fw-bold">{{ $course->code }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $course->name }}</div>
                                        <div class="text-muted small">{{ $course->credit_hours }} Credit Hours</div>
                                    </td>
                                    <td>{{ $course->department->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($course->doctor && $course->doctor->user)
                                            <span class="text-dark small fw-medium">Dr. {{ $course->doctor->user->name }}</span>
                                        @else
                                            <span class="text-muted small fst-italic">Not assigned</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                        No courses created yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
