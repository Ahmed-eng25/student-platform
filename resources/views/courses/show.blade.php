@extends('layouts.app')

@section('title', 'Course Details')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">
            <span class="badge bg-secondary-subtle text-secondary me-2">{{ $course->code }}</span>
            {{ $course->name }}
        </h2>
        <p class="text-muted small mb-0">{{ $course->department->name ?? 'Department' }} &bull; {{ $course->credit_hours }} Credit Hours</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-pencil me-1"></i> Edit Course
        </a>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to Catalog
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Course Info Card -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 text-dark">Course Information</h5>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">
                    {{ $course->description ?: 'No detailed course description provided.' }}
                </p>

                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between py-2 px-0">
                        <span class="text-muted">Department:</span>
                        <span class="fw-semibold">{{ $course->department->name ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between py-2 px-0">
                        <span class="text-muted">Instructor:</span>
                        <span class="fw-semibold">
                            {{ $course->doctor && $course->doctor->user ? 'Dr. ' . $course->doctor->user->name : 'Unassigned' }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between py-2 px-0">
                        <span class="text-muted">Credit Hours:</span>
                        <span class="fw-semibold">{{ $course->credit_hours }} Hours</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between py-2 px-0">
                        <span class="text-muted">Enrolled Students:</span>
                        <span class="badge bg-primary-subtle text-primary">{{ $course->enrollments->count() }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Enrolled Students & Grades -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <h5 class="fw-bold mb-0 text-dark">Enrolled Students ({{ $course->enrollments->count() }})</h5>
                <a href="{{ route('admin.enrollments.create') }}" class="btn btn-sm btn-outline-primary">
                    <i class="bi bi-plus-lg me-1"></i> Enroll Student
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive border-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Student</th>
                                <th>Code</th>
                                <th>Enrolled Date</th>
                                <th class="text-end">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $gradesMap = $course->grades->keyBy('student_id');
                            @endphp

                            @forelse ($course->enrollments as $enrollment)
                                @php
                                    $studentGrade = $gradesMap->get($enrollment->student_id);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $enrollment->student->user->name ?? 'Student' }}</div>
                                        <div class="text-muted small">{{ $enrollment->student->user->email ?? '' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $enrollment->student->student_code ?? '' }}</span>
                                    </td>
                                    <td class="text-muted small">{{ $enrollment->enrollment_date->format('M d, Y') }}</td>
                                    <td class="text-end">
                                        @if ($studentGrade)
                                            <span class="badge {{ $studentGrade->grade >= 60 ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} fs-6">
                                                {{ $studentGrade->grade }}%
                                            </span>
                                        @else
                                            <span class="text-muted small fst-italic">Not Graded</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        No students enrolled in this course yet.
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
