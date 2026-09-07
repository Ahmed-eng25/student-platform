@extends('layouts.app')

@section('title', 'Edit Grade')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="fw-bold mb-0 text-dark">Edit Grade</h5>
                    <a href="{{ route('admin.grades.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="bg-light p-3 rounded-3 mb-4">
                    <div class="small text-muted mb-1">Student:</div>
                    <div class="fw-bold text-dark">{{ $grade->student->user->name ?? 'Student' }} ({{ $grade->student->student_code ?? '' }})</div>
                    <div class="small text-muted mt-2 mb-1">Course:</div>
                    <div class="fw-bold text-dark">{{ $grade->course->name ?? 'Course' }} [{{ $grade->course->code ?? '' }}]</div>
                </div>

                <form action="{{ route('admin.grades.update', $grade) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="grade" class="form-label">Grade Percentage (0 - 100) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" max="100" id="grade" name="grade" class="form-control @error('grade') is-invalid @enderror" value="{{ old('grade', $grade->grade) }}" required>
                        @error('grade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-lg me-1"></i> Update Grade
                        </button>
                        <a href="{{ route('admin.grades.index') }}" class="btn btn-light border px-4">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
