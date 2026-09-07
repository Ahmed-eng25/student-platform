@extends('layouts.app')

@section('title', $course->code . ' - ' . $course->name)

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <div class="d-flex align-items-center gap-2 mb-1">
            <span class="badge bg-secondary-subtle text-secondary fw-bold fs-6">{{ $course->code }}</span>
            <h2 class="h4 fw-bold text-dark mb-0">{{ $course->name }}</h2>
        </div>
        <p class="text-muted small mb-0">{{ $course->department->name ?? 'Department' }} &bull; {{ $course->credit_hours }} Credit Hours</p>
    </div>
    <a href="{{ route('doctor.courses.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to My Courses
    </a>
</div>

<div class="row g-4 mb-4">
    <div class="col-sm-6 col-lg-4">
        <x-stat-card 
            title="Total Enrolled" 
            value="{{ $course->enrollments->count() }}" 
            icon="people-fill" 
            color="primary"
        />
    </div>
    <div class="col-sm-6 col-lg-4">
        <x-stat-card 
            title="Graded Students" 
            value="{{ $course->grades->count() }}" 
            icon="check-circle-fill" 
            color="success"
        />
    </div>
    <div class="col-sm-6 col-lg-4">
        @php
            $classAvg = $course->grades->avg('grade') ?? 0;
        @endphp
        <x-stat-card 
            title="Class Average" 
            value="{{ number_format($classAvg, 1) }}%" 
            icon="graph-up" 
            color="{{ $classAvg >= 60 ? 'info' : 'warning' }}"
        />
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white d-flex align-items-center justify-content-between py-3">
        <div class="d-flex align-items-center gap-2">
            <i class="bi bi-people-fill text-primary fs-5"></i>
            <h5 class="fw-bold mb-0 text-dark">Course Roster & Student Grading</h5>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive border-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Code</th>
                        <th>Student Name</th>
                        <th>Department</th>
                        <th>Level</th>
                        <th class="text-center">Score</th>
                        <th class="text-center">Performance</th>
                        <th class="text-end">Grading Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($course->enrollments as $enrollment)
                        @php
                            $student = $enrollment->student;
                            $grade = $gradesByStudent->get($student->id);
                        @endphp
                        <tr>
                            <td>
                                <span class="badge bg-light text-dark border">{{ $student->student_code }}</span>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark">{{ $student->user->name ?? 'Student' }}</div>
                                <div class="text-muted small">{{ $student->user->email ?? '' }}</div>
                            </td>
                            <td>{{ $student->department->name ?? 'Unassigned' }}</td>
                            <td>
                                <span class="badge bg-primary-subtle text-primary">Level {{ $student->level }}</span>
                            </td>
                            <td class="text-center">
                                @if ($grade)
                                    <span class="fw-bold fs-6 {{ $grade->grade >= 60 ? 'text-success' : 'text-danger' }}">
                                        {{ $grade->grade }}%
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary">Pending</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($grade)
                                    @if ($grade->grade >= 85)
                                        <span class="badge bg-success-subtle text-success">Excellent</span>
                                    @elseif ($grade->grade >= 75)
                                        <span class="badge bg-info-subtle text-info">Very Good</span>
                                    @elseif ($grade->grade >= 60)
                                        <span class="badge bg-primary-subtle text-primary">Pass</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">Fail</span>
                                    @endif
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if ($grade)
                                    <!-- Edit Grade Button Triggering Modal -->
                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editGradeModal-{{ $grade->id }}">
                                        <i class="bi bi-pencil me-1"></i> Edit Grade
                                    </button>

                                    <!-- Edit Modal -->
                                    <div class="modal fade text-start" id="editGradeModal-{{ $grade->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $grade->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('doctor.courses.grades.update', [$course, $grade]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold" id="editModalLabel-{{ $grade->id }}">
                                                            Update Grade: {{ $student->user->name }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Grade Percentage (0 - 100)</label>
                                                            <input type="number" step="0.01" min="0" max="100" name="grade" class="form-control" value="{{ $grade->grade }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Add Grade Button Triggering Modal -->
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addGradeModal-{{ $student->id }}">
                                        <i class="bi bi-plus-lg me-1"></i> Add Grade
                                    </button>

                                    <!-- Add Modal -->
                                    <div class="modal fade text-start" id="addGradeModal-{{ $student->id }}" tabindex="-1" aria-labelledby="addModalLabel-{{ $student->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('doctor.courses.grades.store', $course) }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold" id="addModalLabel-{{ $student->id }}">
                                                            Enter Grade: {{ $student->user->name }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Grade Percentage (0 - 100)</label>
                                                            <input type="number" step="0.01" min="0" max="100" name="grade" class="form-control" placeholder="e.g. 85.50" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Save Grade</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                No students enrolled in this course yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
