@extends('layouts.app')

@section('title', 'Doctor Dashboard')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">Faculty Portal</h2>
        <p class="text-muted small mb-0">Welcome back, Dr. {{ auth()->user()->name }} ({{ $doctor->department->name ?? 'Department' }}).</p>
    </div>
    <div>
        <span class="badge bg-light text-dark border px-3 py-2">
            <i class="bi bi-person-badge me-1"></i> Employee Code: {{ $doctor->employee_code }}
        </span>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-4">
        <x-stat-card 
            title="My Courses" 
            value="{{ $courses->count() }}" 
            icon="journal-bookmark-fill" 
            color="primary"
            badge="Assigned"
        />
    </div>
    <div class="col-sm-6 col-lg-4">
        <x-stat-card 
            title="Enrolled Students" 
            value="{{ $totalStudents }}" 
            icon="people-fill" 
            color="success"
            badge="Across all courses"
        />
    </div>
    <div class="col-sm-6 col-lg-4">
        <x-stat-card 
            title="Recent Grades" 
            value="{{ $recentGrades->count() }}" 
            icon="award-fill" 
            color="info"
            badge="Submitted"
        />
    </div>
</div>

<!-- Main Section: My Courses & Recent Grades -->
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-journal-check text-primary fs-5"></i>
                    <h5 class="fw-bold mb-0 text-dark">My Assigned Courses</h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive border-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Course Title</th>
                                <th>Credit Hours</th>
                                <th>Students</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($courses as $course)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary fw-bold">{{ $course->code }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $course->name }}</div>
                                        <div class="text-muted small">{{ $course->department->name ?? '' }}</div>
                                    </td>
                                    <td>{{ $course->credit_hours }} hrs</td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">
                                            {{ $course->enrollments_count }} Enrolled
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('doctor.courses.show', $course) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-people me-1"></i> Roster & Grades
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="bi bi-journal-x fs-4 d-block mb-1"></i>
                                        No courses currently assigned to you.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Grades -->
    <div class="col-lg-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-clock-history text-success fs-5"></i>
                    <h5 class="fw-bold mb-0 text-dark">Recent Grades Entered</h5>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive border-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Course</th>
                                <th class="text-end">Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentGrades as $grade)
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $grade->student->user->name ?? 'Student' }}</div>
                                        <div class="text-muted small">{{ $grade->student->student_code ?? '' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $grade->course->code ?? '' }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge {{ $grade->grade >= 60 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fs-6">
                                            {{ $grade->grade }}%
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                        No grades recorded yet.
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
