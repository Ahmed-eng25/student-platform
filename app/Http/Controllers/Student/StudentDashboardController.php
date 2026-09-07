<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $student = $request->user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $enrollments = Enrollment::where('student_id', $student->id)
            ->with(['course.department', 'course.doctor.user'])
            ->latest('enrollment_date')
            ->get();

        $enrolledCount = $enrollments->count();

        $grades = Grade::where('student_id', $student->id)
            ->with('course')
            ->latest()
            ->get();

        $averageGrade = $grades->avg('grade') ?? 0;

        $totalCredits = $enrollments->sum(function ($e) {
            return $e->course->credit_hours ?? 0;
        });

        return view('student.dashboard', compact(
            'student',
            'enrollments',
            'enrolledCount',
            'grades',
            'averageGrade',
            'totalCredits'
        ));
    }
}
