@extends('layouts.app')

@section('title', 'My Assigned Courses')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">My Teaching Courses</h2>
        <p class="text-muted small mb-0">Manage course student rosters and record semester grades.</p>
    </div>
</div>

<div class="row g-4">
    @forelse ($courses as $course)
        <div class="col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0 card-hover">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge bg-secondary-subtle text-secondary fw-bold">{{ $course->code }}</span>
                        <span class="badge bg-light text-dark border">{{ $course->credit_hours }} Credit Hours</span>
                    </div>

                    <h5 class="fw-bold text-dark mb-2">{{ $course->name }}</h5>
                    <p class="text-muted small mb-4 flex-grow-1">
                        {{ \Illuminate\Support\Str::limit($course->description ?: 'No detailed syllabus provided.', 100) }}
                    </p>

                    <div class="border-top pt-3 mt-auto">
                        <div class="d-flex justify-content-between small text-muted mb-3">
                            <span><i class="bi bi-people me-1"></i> {{ $course->enrollments_count }} Enrolled</span>
                            <span><i class="bi bi-award me-1"></i> {{ $course->grades_count }} Graded</span>
                        </div>

                        <a href="{{ route('doctor.courses.show', $course) }}" class="btn btn-primary w-100">
                            <i class="bi bi-card-checklist me-1"></i> View Students & Grades
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card shadow-sm border-0 p-5 text-center text-muted">
                <i class="bi bi-journal-x fs-1 d-block mb-3 text-secondary"></i>
                <h5 class="fw-bold text-dark">No courses assigned to you</h5>
                <p class="small text-muted mb-0">The university administration has not assigned any courses to your account yet.</p>
            </div>
        </div>
    @endforelse
</div>
@endsection
