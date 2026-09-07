@extends('layouts.app')

@section('title', 'Student Dashboard')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">Welcome back, {{ auth()->user()->name }}</h2>
        <p class="text-muted small mb-0">{{ $student->department->name ?? 'Department' }} &bull; Level {{ $student->level }} &bull; ID: {{ $student->student_code }}</p>
    </div>
    <div>
        <span class="badge bg-primary-subtle text-primary border px-3 py-2 fs-6">
            <i class="bi bi-mortarboard me-1"></i> Level {{ $student->level }}
        </span>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-4">
        <x-stat-card 
            title="Enrolled Courses" 
            value="{{ $enrolledCount }}" 
            icon="journal-check" 
            color="primary"
            badge="Current Semester"
        />
    </div>
    <div class="col-sm-6 col-lg-4">
        <x-stat-card 
            title="Average Grade" 
            value="{{ number_format($averageGrade, 1) }}%" 
            icon="award-fill" 
            color="{{ $averageGrade >= 60 ? 'success' : 'warning' }}"
            badge="{{ $averageGrade >= 85 ? 'Excellent' : ($averageGrade >= 75 ? 'Very Good' : ($averageGrade >= 60 ? 'Pass' : 'Academic Standing')) }}"
        />
    </div>
    <div class="col-sm-6 col-lg-4">
        <x-stat-card 
            title="Total Credits" 
            value="{{ $totalCredits }} hrs" 
            icon="clock-history" 
            color="info"
            badge="Registered"
        />
    </div>
</div>

<!-- Main Section: My Courses & Recent Grades -->
<div class="row g-4">
    <div class="col-lg-7">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-journal-text text-primary fs-5"></i>
                    <h5 class="fw-bold mb-0 text-dark">Current Registered Courses</h5>
                </div>
                <a href="{{ route('student.courses.index') }}" class="small text-decoration-none fw-semibold">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive border-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Course Name</th>
                                <th>Instructor</th>
                                <th>Credits</th>
                                <th class="text-end">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($enrollments as $enrollment)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary fw-bold">
                                            {{ $enrollment->course->code ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $enrollment->course->name ?? 'Course' }}</div>
                                        <div class="text-muted small">Enrolled on {{ $enrollment->enrollment_date->format('M d, Y') }}</div>
                                    </td>
                                    <td>
                                        @if ($enrollment->course && $enrollment->course->doctor && $enrollment->course->doctor->user)
                                            <span class="small text-dark fw-medium">Dr. {{ $enrollment->course->doctor->user->name }}</span>
                                        @else
                                            <span class="text-muted small fst-italic">TBA</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $enrollment->course->credit_hours ?? 3 }} hrs</span>
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('student.courses.show', $enrollment->course) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-info-circle"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                        You are not enrolled in any courses yet.
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
                    <i class="bi bi-award text-success fs-5"></i>
                    <h5 class="fw-bold mb-0 text-dark">Course Grades</h5>
                </div>
                <a href="{{ route('student.grades.index') }}" class="small text-decoration-none fw-semibold">All Grades</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive border-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Course</th>
                                <th>Code</th>
                                <th class="text-end">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($grades as $grade)
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $grade->course->name ?? 'Course' }}</div>
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
