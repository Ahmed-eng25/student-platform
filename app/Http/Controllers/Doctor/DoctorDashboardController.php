<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorDashboardController extends Controller
{
    public function index(Request $request): View
    {
        $doctor = $request->user()->doctor;

        if (! $doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $courses = Course::where('doctor_id', $doctor->id)
            ->withCount('enrollments')
            ->with('department')
            ->get();

        $courseIds = $courses->pluck('id');

        $totalStudents = \App\Models\Enrollment::whereIn('course_id', $courseIds)
            ->distinct('student_id')
            ->count('student_id');

        $recentGrades = Grade::whereIn('course_id', $courseIds)
            ->with(['student.user', 'course'])
            ->latest()
            ->take(5)
            ->get();

        return view('doctor.dashboard', compact('doctor', 'courses', 'totalStudents', 'recentGrades'));
    }
}
