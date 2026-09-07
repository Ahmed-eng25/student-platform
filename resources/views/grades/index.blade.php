@extends('layouts.app')

@section('title', 'Grades Management')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">Academic Grades Record</h2>
        <p class="text-muted small mb-0">Review, update, and manage official exam grades and course evaluations.</p>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <form method="GET" action="{{ route('admin.grades.index') }}" class="row g-2 align-items-center">
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
                    <a href="{{ route('admin.grades.index') }}" class="btn btn-link text-muted text-decoration-none">Reset</a>
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
                        <th class="text-center">Score</th>
                        <th class="text-center">Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($grades as $grade)
                        <tr>
                            <td class="text-muted">{{ $grade->id }}</td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $grade->student->user->name ?? 'Student' }}</div>
                                <div class="text-muted small">Code: {{ $grade->student->student_code ?? '' }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $grade->course->name ?? 'Course' }}</div>
                                <span class="badge bg-secondary-subtle text-secondary">{{ $grade->course->code ?? '' }}</span>
                            </td>
                            <td>
                                @if ($grade->course && $grade->course->doctor && $grade->course->doctor->user)
                                    <span class="small fw-medium">Dr. {{ $grade->course->doctor->user->name }}</span>
                                @else
                                    <span class="text-muted small fst-italic">Unassigned</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="fw-bold fs-6 {{ $grade->grade >= 60 ? 'text-success' : 'text-danger' }}">
                                    {{ $grade->grade }}%
                                </span>
                            </td>
                            <td class="text-center">
                                @if ($grade->grade >= 85)
                                    <span class="badge bg-success-subtle text-success">Excellent</span>
                                @elseif ($grade->grade >= 75)
                                    <span class="badge bg-info-subtle text-info">Very Good</span>
                                @elseif ($grade->grade >= 60)
                                    <span class="badge bg-primary-subtle text-primary">Pass</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Fail</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.grades.edit', $grade) }}" class="btn btn-outline-primary" title="Edit Grade">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.grades.destroy', $grade) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this grade?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Delete Grade">
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
                                No grades found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if ($grades->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $grades->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection
