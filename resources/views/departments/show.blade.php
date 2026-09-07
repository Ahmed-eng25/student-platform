@extends('layouts.app')

@section('title', 'Department Details')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">{{ $department->name }}</h2>
        <p class="text-muted small mb-0">{{ $department->description ?: 'No description provided.' }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.departments.edit', $department) }}" class="btn btn-outline-primary btn-sm">
            <i class="bi bi-pencil me-1"></i> Edit Department
        </a>
        <a href="{{ route('admin.departments.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back to List
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Faculty / Doctors -->
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-person-workspace text-success fs-5"></i>
                    <h5 class="fw-bold mb-0 text-dark">Faculty Doctors ({{ $department->doctors->count() }})</h5>
                </div>
                <a href="{{ route('admin.doctors.create') }}" class="btn btn-sm btn-outline-success">Add Doctor</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive border-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Doctor</th>
                                <th>Code</th>
                                <th>Specialization</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($department->doctors as $doctor)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.doctors.show', $doctor) }}" class="fw-semibold text-dark text-decoration-none">
                                            Dr. {{ $doctor->user->name ?? 'N/A' }}
                                        </a>
                                        <div class="text-muted small">{{ $doctor->user->email ?? '' }}</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">{{ $doctor->employee_code }}</span>
                                    </td>
                                    <td class="small">{{ $doctor->specialization ?: 'General' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-4 text-muted">
                                        No doctors assigned to this department yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Courses -->
    <div class="col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-journal-bookmark text-primary fs-5"></i>
                    <h5 class="fw-bold mb-0 text-dark">Department Courses ({{ $department->courses->count() }})</h5>
                </div>
                <a href="{{ route('admin.courses.create') }}" class="btn btn-sm btn-outline-primary">Add Course</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive border-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Code</th>
                                <th>Course Title</th>
                                <th>Credits</th>
                                <th>Instructor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($department->courses as $course)
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
                                    <td class="small">
                                        {{ $course->doctor && $course->doctor->user ? 'Dr. ' . $course->doctor->user->name : 'Unassigned' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        No courses in this department yet.
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
