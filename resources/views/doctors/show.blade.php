@extends('layouts.app')

@section('title', 'Doctor Profile')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">Dr. {{ $doctor->user->name }}</h2>
        <p class="text-muted small mb-0">{{ $doctor->employee_code }} &bull; {{ $doctor->department->name ?? 'Unassigned' }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-pencil me-1"></i> Edit Doctor
        </a>
        <a href="{{ route('admin.doctors.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Doctor Info Card -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 text-dark">Faculty Profile</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center shadow-sm" style="width: 72px; height: 72px; font-size: 1.75rem; font-weight: 700;">
                        {{ strtoupper(substr($doctor->user->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold text-dark mt-3 mb-1">Dr. {{ $doctor->user->name }}</h5>
                    <span class="badge bg-success-subtle text-success">{{ $doctor->specialization ?: 'Faculty Member' }}</span>
                </div>

                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex justify-content-between py-2 px-0">
                        <span class="text-muted">Employee Code:</span>
                        <span class="fw-semibold">{{ $doctor->employee_code }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between py-2 px-0">
                        <span class="text-muted">Email Address:</span>
                        <span class="fw-semibold">{{ $doctor->user->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between py-2 px-0">
                        <span class="text-muted">Department:</span>
                        <span class="fw-semibold">{{ $doctor->department->name ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between py-2 px-0">
                        <span class="text-muted">Specialization:</span>
                        <span class="fw-semibold">{{ $doctor->specialization ?: 'General' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between py-2 px-0">
                        <span class="text-muted">Phone Number:</span>
                        <span class="fw-semibold">{{ $doctor->phone ?: 'Not provided' }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Assigned Courses -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <h5 class="fw-bold mb-0 text-dark">Assigned Courses ({{ $doctor->courses->count() }})</h5>
                <a href="{{ route('admin.courses.create') }}" class="btn btn-sm btn-outline-primary">Assign New Course</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive border-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Course Title</th>
                                <th>Credits</th>
                                <th>Enrolled Students</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($doctor->courses as $course)
                                <tr>
                                    <td>
                                        <span class="badge bg-secondary-subtle text-secondary fw-bold">{{ $course->code }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.courses.show', $course) }}" class="fw-semibold text-dark text-decoration-none">
                                            {{ $course->name }}
                                        </a>
                                    </td>
                                    <td>{{ $course->credit_hours }} hrs</td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">{{ $course->enrollments->count() }} Students</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        No courses currently assigned to this doctor.
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
