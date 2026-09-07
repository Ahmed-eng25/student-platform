@extends('layouts.app')

@section('title', 'Doctors Management')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">Faculty Doctors</h2>
        <p class="text-muted small mb-0">Manage professors, academic doctors, and their assigned departments.</p>
    </div>
    <a href="{{ route('admin.doctors.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-1"></i> Add Doctor
    </a>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <form method="GET" action="{{ route('admin.doctors.index') }}" class="row g-2 align-items-center">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted border-end-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name, email, employee code, or specialization..." value="{{ $search }}">
                </div>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-secondary">Search</button>
                @if ($search)
                    <a href="{{ route('admin.doctors.index') }}" class="btn btn-link text-muted text-decoration-none">Reset</a>
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
                        <th>Doctor Name</th>
                        <th>Department</th>
                        <th>Specialization</th>
                        <th class="text-center">Courses</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($doctors as $doctor)
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $doctor->employee_code }}</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.doctors.show', $doctor) }}" class="fw-semibold text-dark text-decoration-none">
                                    Dr. {{ $doctor->user->name ?? 'N/A' }}
                                </a>
                                <div class="text-muted small">{{ $doctor->user->email ?? '' }}</div>
                            </td>
                            <td>{{ $doctor->department->name ?? 'Unassigned' }}</td>
                            <td>{{ $doctor->specialization ?: 'General' }}</td>
                            <td class="text-center">
                                <span class="badge bg-primary-subtle text-primary">{{ $doctor->courses_count }} Courses</span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.doctors.show', $doctor) }}" class="btn btn-outline-secondary" title="View Profile">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.doctors.edit', $doctor) }}" class="btn btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.doctors.destroy', $doctor) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this doctor? Their account will also be deleted.');">
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
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                No doctors found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($doctors->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $doctors->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
