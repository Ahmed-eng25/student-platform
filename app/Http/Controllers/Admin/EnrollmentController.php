<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EnrollmentController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $enrollments = Enrollment::with(['student.user', 'course.doctor.user'])
            ->when($search, function ($query, $search) {
                $query->whereHas('student.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhereHas('student', function ($q) use ($search) {
                    $q->where('student_code', 'like', "%{$search}%");
                })->orWhereHas('course', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->latest('enrollment_date')
            ->paginate(15)
            ->withQueryString();

        return view('enrollments.index', compact('enrollments', 'search'));
    }

    public function create(): View
    {
        $students = Student::with('user')->get();
        $courses = Course::with('doctor.user')->get();

        return view('enrollments.create', compact('students', 'courses'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'student_id' => ['required', 'exists:students,id'],
            'course_id' => [
                'required',
                'exists:courses,id',
                Rule::unique('enrollments')->where(function ($query) use ($request) {
                    return $query->where('student_id', $request->student_id)
                                 ->where('course_id', $request->course_id);
                }),
            ],
            'enrollment_date' => ['required', 'date'],
        ], [
            'course_id.unique' => 'This student is already enrolled in the selected course.',
        ]);

        Enrollment::create([
            'student_id' => $request->student_id,
            'course_id' => $request->course_id,
            'enrollment_date' => $request->enrollment_date,
        ]);

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment created successfully.');
    }

    public function destroy(Enrollment $enrollment): RedirectResponse
    {
        $enrollment->delete();

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment removed successfully.');
    }
}
