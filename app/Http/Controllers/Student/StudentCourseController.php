<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentCourseController extends Controller
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
            ->paginate(10);

        return view('student.courses.index', compact('enrollments'));
    }

    public function show(Request $request, Course $course): View
    {
        $student = $request->user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $course->load(['department', 'doctor.user']);

        // Check enrollment and grade for this student
        $enrollment = Enrollment::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->first();

        $grade = Grade::where('student_id', $student->id)
            ->where('course_id', $course->id)
            ->first();

        return view('student.courses.show', compact('course', 'enrollment', 'grade'));
    }

    public function grades(Request $request): View
    {
        $student = $request->user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $grades = Grade::where('student_id', $student->id)
            ->with(['course.department', 'course.doctor.user'])
            ->latest()
            ->paginate(15);

        $averageGrade = Grade::where('student_id', $student->id)->avg('grade') ?? 0;

        return view('student.grades.index', compact('grades', 'averageGrade'));
    }
}
