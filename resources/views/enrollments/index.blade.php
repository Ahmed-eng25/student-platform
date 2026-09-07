@extends('layouts.app')

@section('title', 'Enrollments Management')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">Course Enrollments</h2>
        <p class="text-muted small mb-0">Manage student course registrations and track semester enrollments.</p>
    </div>
    <a href="{{ route('admin.enrollments.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> New Enrollment
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <form method="GET" action="{{ route('admin.enrollments.index') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search by student name, code, or course..." value="{{ $search }}">
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
                @if ($search)
                    <a href="{{ route('admin.enrollments.index') }}" class="btn btn-link text-muted text-decoration-none">Reset</a>
                @endif
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive border-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Course</th>
                        <th>Instructor</th>
                        <th>Enrollment Date</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($enrollments as $enrollment)
                        <tr>
                            <td class="text-muted">{{ $enrollment->id }}</td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $enrollment->student->user->name ?? 'Student' }}</div>
                                <div class="text-muted small">Code: {{ $enrollment->student->student_code ?? '' }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $enrollment->course->name ?? 'Course' }}</div>
                                <span class="badge bg-secondary-subtle text-secondary">{{ $enrollment->course->code ?? '' }}</span>
                            </td>
                            <td>
                                @if ($enrollment->course && $enrollment->course->doctor && $enrollment->course->doctor->user)
                                    <span class="small fw-medium">Dr. {{ $enrollment->course->doctor->user->name }}</span>
                                @else
                                    <span class="text-muted small fst-italic">Unassigned</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $enrollment->enrollment_date->format('M d, Y') }}</td>
                            <td class="text-end">
                                <form action="{{ route('admin.enrollments.destroy', $enrollment) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to drop this enrollment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Drop Enrollment">
                                        <i class="bi bi-trash"></i> Drop
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                No enrollments recorded.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($enrollments->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $enrollments->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
