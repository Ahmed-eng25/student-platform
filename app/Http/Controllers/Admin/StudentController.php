<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');

        $students = Student::with(['user', 'department'])
            ->when($search, function ($query, $search) {
                $query->where('student_code', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                          ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('department', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('students.index', compact('students', 'search'));
    }

    public function create(): View
    {
        $departments = Department::orderBy('name')->get();

        return view('students.create', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'department_id' => ['required', 'exists:departments,id'],
            'student_code' => ['required', 'string', 'max:50', 'unique:students,student_code'],
            'phone' => ['nullable', 'string', 'max:20'],
            'level' => ['required', 'integer', 'min:1', 'max:6'],
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'student',
            ]);

            Student::create([
                'user_id' => $user->id,
                'department_id' => $request->department_id,
                'student_code' => $request->student_code,
                'phone' => $request->phone,
                'level' => $request->level,
            ]);
        });

        return redirect()->route('admin.students.index')
            ->with('success', 'Student created successfully.');
    }

    public function show(Student $student): View
    {
        $student->load([
            'user',
            'department',
            'enrollments.course.doctor.user',
            'grades.course',
        ]);

        return view('students.show', compact('student'));
    }

    public function edit(Student $student): View
    {
        $student->load(['user', 'department']);
        $departments = Department::orderBy('name')->get();

        return view('students.edit', compact('student', 'departments'));
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($student->user_id)],
            'department_id' => ['required', 'exists:departments,id'],
            'student_code' => ['required', 'string', 'max:50', Rule::unique('students', 'student_code')->ignore($student->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'level' => ['required', 'integer', 'min:1', 'max:6'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        DB::transaction(function () use ($request, $student) {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $student->user->update($userData);

            $student->update([
                'department_id' => $request->department_id,
                'student_code' => $request->student_code,
                'phone' => $request->phone,
                'level' => $request->level,
            ]);
        });

        return redirect()->route('admin.students.index')
            ->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        // Deleting the associated user will cascade-delete the student record
        $student->user->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Student deleted successfully.');
    }
}
