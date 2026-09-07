<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\GradeController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Doctor\DoctorCourseController;
use App\Http\Controllers\Doctor\DoctorDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\StudentCourseController;
use App\Http\Controllers\Student\StudentDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Authenticated Central Dashboard Router
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function (Request $request) {
    return match ($request->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'doctor' => redirect()->route('doctor.dashboard'),
        'student' => redirect()->route('student.dashboard'),
        default => abort(403, 'Unknown user role.'),
    };
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Management (All Authenticated Roles)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Role: admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('departments', DepartmentController::class);
    Route::resource('students', StudentController::class);
    Route::resource('doctors', DoctorController::class);
    Route::resource('courses', CourseController::class);

    Route::resource('enrollments', EnrollmentController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::resource('grades', GradeController::class)->only(['index', 'edit', 'update', 'destroy']);
});

/*
|--------------------------------------------------------------------------
| Doctor Routes (Role: doctor)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorDashboardController::class, 'index'])->name('dashboard');

    Route::get('/courses', [DoctorCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [DoctorCourseController::class, 'show'])->name('courses.show');
    Route::post('/courses/{course}/grades', [DoctorCourseController::class, 'storeGrade'])->name('courses.grades.store');
    Route::put('/courses/{course}/grades/{grade}', [DoctorCourseController::class, 'updateGrade'])->name('courses.grades.update');
});

/*
|--------------------------------------------------------------------------
| Student Routes (Role: student)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    Route::get('/courses', [StudentCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [StudentCourseController::class, 'show'])->name('courses.show');
    Route::get('/grades', [StudentCourseController::class, 'grades'])->name('grades.index');
});

require __DIR__.'/auth.php';
