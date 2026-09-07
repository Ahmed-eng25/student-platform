@extends('layouts.app')

@section('title', 'My Academic Grades')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
    <div>
        <h2 class="h4 fw-bold text-dark mb-1">Academic Transcript & Grades</h2>
        <p class="text-muted small mb-0">Official grade sheet and performance evaluation across all completed courses.</p>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-lg-4">
        <x-stat-card 
            title="Overall Average" 
            value="{{ number_format($averageGrade, 1) }}%" 
            icon="award-fill" 
            color="{{ $averageGrade >= 60 ? 'success' : 'warning' }}"
        />
    </div>
    <div class="col-sm-6 col-lg-4">
        <x-stat-card 
            title="Graded Courses" 
            value="{{ $grades->total() }}" 
            icon="journal-check" 
            color="primary"
        />
    </div>
    <div class="col-sm-6 col-lg-4">
        @php
            $passedCount = $grades->filter(fn($g) => $g->grade >= 60)->count();
            $passRate = $grades->count() > 0 ? round(($passedCount / $grades->count()) * 100) : 0;
        @endphp
        <x-stat-card 
            title="Passing Ratio" 
            value="{{ $passRate }}%" 
            icon="percent" 
            color="info"
        />
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h5 class="fw-bold mb-0 text-dark">Course Grades Breakdown</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive border-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Code</th>
                        <th>Course Title</th>
                        <th>Department</th>
                        <th>Credits</th>
                        <th>Instructor</th>
                        <th class="text-center">Score</th>
                        <th class="text-end">Evaluation</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($grades as $grade)
                        <tr>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary fw-bold">{{ $grade->course->code ?? 'N/A' }}</span>
                            </td>
                            <td class="fw-semibold text-dark">{{ $grade->course->name ?? 'Course' }}</td>
                            <td>{{ $grade->course->department->name ?? 'General' }}</td>
                            <td>{{ $grade->course->credit_hours ?? 3 }} hrs</td>
                            <td>
                                @if ($grade->course && $grade->course->doctor && $grade->course->doctor->user)
                                    <span class="small text-dark">Dr. {{ $grade->course->doctor->user->name }}</span>
                                @else
                                    <span class="text-muted small fst-italic">Unassigned</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="fw-bold fs-6 {{ $grade->grade >= 60 ? 'text-success' : 'text-danger' }}">
                                    {{ $grade->grade }}%
                                </span>
                            </td>
                            <td class="text-end">
                                @if ($grade->grade >= 85)
                                    <span class="badge bg-success-subtle text-success">Grade A (Excellent)</span>
                                @elseif ($grade->grade >= 75)
                                    <span class="badge bg-info-subtle text-info">Grade B (Very Good)</span>
                                @elseif ($grade->grade >= 60)
                                    <span class="badge bg-primary-subtle text-primary">Grade C (Pass)</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">Grade F (Fail)</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bi bi-inbox fs-4 d-block mb-1"></i>
                                No grades have been recorded yet.
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
