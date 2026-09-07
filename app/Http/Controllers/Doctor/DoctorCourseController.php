<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class DoctorCourseController extends Controller
{
    /**
     * Helper to verify course belongs to logged-in doctor
     */
    protected function authorizeCourseDoctor(Request $request, Course $course)
    {
        $doctor = $request->user()->doctor;

        if (! $doctor || $course->doctor_id !== $doctor->id) {
            abort(403, 'Unauthorized. You are not assigned to teach this course.');
        }

        return $doctor;
    }

    public function index(Request $request): View
    {
        $doctor = $request->user()->doctor;

        if (! $doctor) {
            abort(403, 'Doctor profile not found.');
        }

        $courses = Course::where('doctor_id', $doctor->id)
            ->with(['department'])
            ->withCount(['enrollments', 'grades'])
            ->get();

        return view('doctor.courses.index', compact('courses'));
    }

    public function show(Request $request, Course $course): View
    {
        $this->authorizeCourseDoctor($request, $course);

        $course->load([
            'department',
            'enrollments.student.user',
            'enrollments.student.department',
            'grades.student.user',
        ]);

        // Map grades keyed by student_id for quick display in student roster
        $gradesByStudent = $course->grades->keyBy('student_id');

        return view('doctor.courses.show', compact('course', 'gradesByStudent'));
    }

    public function storeGrade(Request $request, Course $course): RedirectResponse
    {
        $this->authorizeCourseDoctor($request, $course);

        $request->validate([
            'student_id' => [
                'required',
                'exists:students,id',
                Rule::unique('grades')->where(function ($query) use ($course) {
                    return $query->where('course_id', $course->id);
                }),
            ],
            'grade' => ['required', 'numeric', 'min:0', 'max:100'],
        ], [
            'student_id.unique' => 'A grade has already been recorded for this student in this course.',
        ]);

        // Verify student is actually enrolled in this course
        $isEnrolled = $course->enrollments()->where('student_id', $request->student_id)->exists();
        if (! $isEnrolled) {
            return back()->withErrors(['student_id' => 'The selected student is not enrolled in this course.']);
        }

        Grade::create([
            'student_id' => $request->student_id,
            'course_id' => $course->id,
            'grade' => $request->grade,
        ]);

        return redirect()->route('doctor.courses.show', $course)
            ->with('success', 'Grade recorded successfully.');
    }

    public function updateGrade(Request $request, Course $course, Grade $grade): RedirectResponse
    {
        $this->authorizeCourseDoctor($request, $course);

        if ($grade->course_id !== $course->id) {
            abort(403, 'Unauthorized grade update.');
        }

        $validated = $request->validate([
            'grade' => ['required', 'numeric', 'min:0', 'max:100'],
        ]);

        $grade->update($validated);

        return redirect()->route('doctor.courses.show', $course)
            ->with('success', 'Grade updated successfully.');
    }
}
