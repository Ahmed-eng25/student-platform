<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Student;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_students' => Student::count(),
            'total_doctors' => Doctor::count(),
            'total_courses' => Course::count(),
            'total_departments' => Department::count(),
        ];

        $recentStudents = Student::with(['user', 'department'])
            ->latest()
            ->take(5)
            ->get();

        $recentCourses = Course::with(['department', 'doctor.user'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentStudents', 'recentCourses'));
    }
}
