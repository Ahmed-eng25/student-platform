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
    <a href="{{ route('student.courses.index') }}" class="btn btn-outline-secondary btn-sm">
        <i class="bi bi-arrow-left me-1"></i> Back to Courses
    </a>
</div>

<div class="row g-4">
    <!-- Course Details -->
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 text-dark">Course Syllabus & Description</h5>
            </div>
            <div class="card-body p-4">
                <p class="text-dark mb-4 lead fs-6">
                    {{ $course->description ?: 'No detailed description has been published for this course yet.' }}
                </p>

                <div class="row g-3 border-top pt-3">
                    <div class="col-sm-4">
                        <div class="text-muted small">Course Code</div>
                        <div class="fw-bold text-dark">{{ $course->code }}</div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-muted small">Credit Hours</div>
                        <div class="fw-bold text-dark">{{ $course->credit_hours }} Hours</div>
                    </div>
                    <div class="col-sm-4">
                        <div class="text-muted small">Department</div>
                        <div class="fw-bold text-dark">{{ $course->department->name ?? 'General' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instructor Information -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 text-dark">Course Instructor</h5>
            </div>
            <div class="card-body p-4">
                @if ($course->doctor && $course->doctor->user)
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold fs-4" style="width: 56px; height: 56px;">
                            {{ strtoupper(substr($course->doctor->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-1">Dr. {{ $course->doctor->user->name }}</h5>
                            <div class="text-muted small mb-1">{{ $course->doctor->specialization ?: 'Faculty Member' }}</div>
                            <div class="text-muted small">
                                <i class="bi bi-envelope me-1"></i> {{ $course->doctor->user->email }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-muted text-center py-3">
                        <i class="bi bi-person-x fs-3 d-block mb-1"></i>
                        No instructor currently assigned to this course.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Student Status & Grade Card -->
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0 text-dark">My Course Status</h5>
            </div>
            <div class="card-body p-4">
                @if ($enrollment)
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="badge bg-success-subtle text-success px-3 py-2 fs-6">
                            <i class="bi bi-check-circle me-1"></i> Enrolled
                        </span>
                    </div>
                    <div class="text-muted small mb-3">
                        Registered on: <strong>{{ $enrollment->enrollment_date->format('F d, Y') }}</strong>
                    </div>
                @else
                    <div class="badge bg-secondary-subtle text-secondary px-3 py-2 mb-3">Not Enrolled</div>
                @endif

                <hr>

                <div class="text-center py-3">
                    <div class="text-muted small mb-1">Course Final Grade</div>
                    @if ($grade)
                        <div class="display-5 fw-bold {{ $grade->grade >= 60 ? 'text-success' : 'text-danger' }}">
                            {{ $grade->grade }}%
                        </div>
                        <div class="mt-2">
                            @if ($grade->grade >= 85)
                                <span class="badge bg-success">Grade: A (Excellent)</span>
                            @elseif ($grade->grade >= 75)
                                <span class="badge bg-info">Grade: B (Very Good)</span>
                            @elseif ($grade->grade >= 60)
                                <span class="badge bg-primary">Grade: C (Pass)</span>
                            @else
                                <span class="badge bg-danger">Grade: F (Fail)</span>
                            @endif
                        </div>
                    @else
                        <div class="h4 text-muted fst-italic">Pending Evaluation</div>
                        <p class="text-muted small mb-0 mt-2">Grade has not been entered by your professor yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
