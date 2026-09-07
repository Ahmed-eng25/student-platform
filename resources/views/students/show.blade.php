@extends('layouts.app')

@section('title', 'Student Profile')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">{{ $student->user->name }}</h2>
        <p class="text-muted small mb-0">{{ $student->student_code }} &bull; {{ $student->department->name ?? 'Unassigned' }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-pencil me-1"></i> Edit Student
        </a>
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Student Info Card -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 text-dark">Profile Details</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 72px; height: 72px; font-size: 1.75rem; font-weight: 700;">
                        {{ strtoupper(substr($student->user->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold text-dark mt-3 mb-1">{{ $student->user->name }}</h5>
                    <span class="badge bg-primary-subtle text-primary">Level {{ $student->level }}</span>
                </div>

                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between py-2 px-0">
                        <span class="text-muted">Student Code:</span>
                        <span class="fw-semibold">{{ $student->student_code }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between py-2 px-0">
                        <span class="text-muted">Email Address:</span>
                        <span class="fw-semibold">{{ $student->user->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between py-2 px-0">
                        <span class="text-muted">Department:</span>
                        <span class="fw-semibold">{{ $student->department->name ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between py-2 px-0">
                        <span class="text-muted">Phone Number:</span>
                        <span class="fw-semibold">{{ $student->phone ?: 'Not provided' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between py-2 px-0">
                        <span class="text-muted">Registered On:</span>
                        <span class="fw-semibold">{{ $student->created_at->format('M d, Y') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Enrolled Courses & Grades -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark">Enrolled Courses ({{ $student->enrollments->count() }})</h5>
                    <a href="{{ route('admin.enrollments.create') }}" class="btn btn-sm btn-outline-primary">Enroll Course</a>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive border-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Course Title</th>
                                <th>Instructor</th>
                                <th>Credits</th>
                                <th>Enrollment Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($student->enrollments as $enrollment)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary fw-bold">{{ $enrollment->course->code ?? 'N/A' }}</span>
                                    </td>
                                    <td class="fw-semibold text-dark">{{ $enrollment->course->name ?? 'Course' }}</td>
                                    <td class="small">
                                        {{ $enrollment->course && $enrollment->course->doctor && $enrollment->course->doctor->user ? 'Dr. ' . $enrollment->course->doctor->user->name : 'Unassigned' }}
                                    </td>
                                    <td>{{ $enrollment->course->credit_hours ?? 3 }} hrs</td>
                                    <td class="text-muted small">{{ $enrollment->enrollment_date->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        This student is not enrolled in any courses yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Academic Grades -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 text-dark">Academic Grades ({{ $student->grades->count() }})</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive border-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Course</th>
                                <th>Course Code</th>
                                <th class="text-end">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($student->grades as $grade)
                                <tr>
                                    <td class="fw-semibold text-dark">{{ $grade->course->name ?? 'Course' }}</td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $grade->course->code ?? 'N/A' }}</span>
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
                                        No grades recorded for this student yet.
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
