@extends('layouts.app')

@section('title', 'Departments Management')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">Academic Departments</h2>
        <p class="text-muted small mb-0">Manage college departments, faculty members, and course offerings.</p>
    </div>
    <a href="{{ route('admin.departments.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Department
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <form method="GET" action="{{ route('admin.departments.index') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name or description..." value="{{ $search }}">
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
                @if ($search)
                    <a href="{{ route('admin.departments.index') }}" class="btn btn-link text-muted text-decoration-none">Reset</a>
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
                        <th>Department Name</th>
                        <th>Description</th>
                        <th class="text-center">Students</th>
                        <th class="text-center">Doctors</th>
                        <th class="text-center">Courses</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $dept)
                        <tr>
                            <td class="text-muted">{{ $dept->id }}</td>
                            <td>
                                <a href="{{ route('admin.departments.show', $dept) }}" class="fw-semibold text-decoration-none text-dark">
                                    {{ $dept->name }}
                                </a>
                            </td>
                            <td class="text-muted small text-truncate" style="max-width: 250px;">
                                {{ $dept->description ?: 'No description provided.' }}
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary-subtle text-primary">{{ $dept->students_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success-subtle text-success">{{ $dept->doctors_count }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-warning-subtle text-warning">{{ $dept->courses_count }}</span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.departments.show', $dept) }}" class="btn btn-outline-secondary" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.departments.edit', $dept) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.departments.destroy', $dept) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this department? All associated courses, students, and doctors may be affected.');">
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
                                No departments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($departments->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $departments->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
