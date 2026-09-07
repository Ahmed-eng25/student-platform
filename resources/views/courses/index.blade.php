@extends('layouts.app')

@section('title', 'Courses Management')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">Course Catalog</h2>
        <p class="text-muted small mb-0">Manage university courses, credit hours, and instructor assignments.</p>
    </div>
    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
        <i class="bi bi-journal-plus me-1"></i> Add Course
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <form method="GET" action="{{ route('admin.courses.index') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search by course code, name, department, or doctor..." value="{{ $search }}">
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
                @if ($search)
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-link text-muted text-decoration-none">Reset</a>
                @endif
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive border-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Code</th>
                        <th>Course Title</th>
                        <th>Department</th>
                        <th>Instructor</th>
                        <th class="text-center">Credits</th>
                        <th class="text-center">Enrolled</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($courses as $course)
                        <tr>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary fw-bold">{{ $course->code }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.courses.show', $course) }}" class="fw-semibold text-dark text-decoration-none">
                                    {{ $course->name }}
                                </a>
                            </td>
                            <td>{{ $course->department->name ?? 'Unassigned' }}</td>
                            <td>
                                @if ($course->doctor && $course->doctor->user)
                                    <span class="small fw-medium text-dark">Dr. {{ $course->doctor->user->name }}</span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning">Unassigned</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border">{{ $course->credit_hours }} hrs</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary-subtle text-primary">{{ $course->enrollments_count }}</span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.courses.show', $course) }}" class="btn btn-outline-secondary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this course? All student enrollments and grades for this course will be permanently removed.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                No courses found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($courses->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $courses->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
