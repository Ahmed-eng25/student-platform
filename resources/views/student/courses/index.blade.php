@extends('layouts.app')

@section('title', 'My Enrolled Courses')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">My Registered Courses</h2>
        <p class="text-muted small mb-0">View all academic courses you are registered for this semester.</p>
    </div>
</div>

<div class="row g-4">
    @forelse ($enrollments as $enrollment)
        @php
            $course = $enrollment->course;
        @endphp
        <div class="col-md-6 col-xl-4">
            <div class="card h-100 shadow-sm border-0 card-hover">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge bg-secondary-subtle text-secondary fw-bold">{{ $course->code }}</span>
                        <span class="badge bg-light text-dark border">{{ $course->credit_hours }} Credit Hours</span>
                    </div>

                    <h5 class="fw-bold text-dark mb-1">{{ $course->name }}</h5>
                    <div class="text-muted small mb-3">
                        <i class="bi bi-building me-1"></i> {{ $course->department->name ?? 'Department' }}
                    </div>

                    <p class="text-muted small mb-4 flex-grow-1">
                        {{ \Illuminate\Support\Str::limit($course->description ?: 'No detailed syllabus available.', 100) }}
                    </p>

                    <div class="border-top pt-3 mt-auto">
                        <div class="d-flex align-items-center justify-content-between small text-muted mb-3">
                            <span>
                                <i class="bi bi-person-workspace me-1"></i>
                                {{ $course->doctor && $course->doctor->user ? 'Dr. ' . $course->doctor->user->name : 'Unassigned' }}
                            </span>
                            <span>Enrolled: {{ $enrollment->enrollment_date->format('M d') }}</span>
                        </div>

                        <a href="{{ route('student.courses.show', $course) }}" class="btn btn-outline-primary w-100">
                            <i class="bi bi-info-circle me-1"></i> Course Details & Grade
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="card shadow-sm border-0 p-5 text-center text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-3 text-secondary"></i>
                <h5 class="fw-bold text-dark">No courses registered yet</h5>
                <p class="small text-muted mb-0">Please contact the academic administration to enroll you into your semester courses.</p>
            </div>
        </div>
    @endforelse
</div>

@if ($enrollments->hasPages())
    <div class="mt-4">
        {{ $enrollments->links('pagination::bootstrap-5') }}
    </div>
@endif
@endsection
