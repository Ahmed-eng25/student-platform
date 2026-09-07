<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AcademicConstraintsTest extends TestCase
{
    use RefreshDatabase;

    public function test_prevent_duplicate_enrollment(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $dept = Department::create(['name' => 'Computer Science']);
        $studentUser = User::factory()->create(['role' => 'student']);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'department_id' => $dept->id,
            'student_code' => 'STU-01',
            'level' => 1,
        ]);
        $course = Course::create([
            'department_id' => $dept->id,
            'code' => 'CS101',
            'name' => 'Data Structures',
            'credit_hours' => 3,
        ]);

        // First enrollment succeeds
        Enrollment::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'enrollment_date' => now(),
        ]);

        // Second enrollment via Admin controller should fail validation with custom error
        $response = $this->actingAs($admin)->post(route('admin.enrollments.store'), [
            'student_id' => $student->id,
            'course_id' => $course->id,
            'enrollment_date' => now()->format('Y-m-d'),
        ]);

        $response->assertSessionHasErrors('course_id');
        $this->assertEquals(1, Enrollment::count());
    }

    public function test_prevent_duplicate_grades(): void
    {
        $dept = Department::create(['name' => 'Computer Science']);
        $doctorUser = User::factory()->create(['role' => 'doctor']);
        $doctor = Doctor::create([
            'user_id' => $doctorUser->id,
            'department_id' => $dept->id,
            'employee_code' => 'DOC-01',
        ]);
        $course = Course::create([
            'department_id' => $dept->id,
            'doctor_id' => $doctor->id,
            'code' => 'CS101',
            'name' => 'Data Structures',
            'credit_hours' => 3,
        ]);
        $studentUser = User::factory()->create(['role' => 'student']);
        $student = Student::create([
            'user_id' => $studentUser->id,
            'department_id' => $dept->id,
            'student_code' => 'STU-01',
            'level' => 1,
        ]);

        Enrollment::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'enrollment_date' => now(),
        ]);

        // First grade
        Grade::create([
            'student_id' => $student->id,
            'course_id' => $course->id,
            'grade' => 85.00,
        ]);

        // Attempting to post a second grade for the same student and course
        $response = $this->actingAs($doctorUser)->post(route('doctor.courses.grades.store', $course), [
            'student_id' => $student->id,
            'grade' => 90.00,
        ]);

        $response->assertSessionHasErrors('student_id');
        $this->assertEquals(1, Grade::count());
    }

    public function test_admin_can_create_department(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->post(route('admin.departments.store'), [
            'name' => 'Artificial Intelligence',
            'description' => 'Department of AI and Robotics',
        ]);

        $response->assertRedirect(route('admin.departments.index'));
        $this->assertDatabaseHas('departments', [
            'name' => 'Artificial Intelligence',
        ]);
    }

    public function test_central_dashboard_redirects_according_to_role(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $responseAdmin = $this->actingAs($admin)->get(route('dashboard'));
        $responseAdmin->assertRedirect(route('admin.dashboard'));

        $doctor = User::factory()->create(['role' => 'doctor']);
        $responseDoc = $this->actingAs($doctor)->get(route('dashboard'));
        $responseDoc->assertRedirect(route('doctor.dashboard'));

        $student = User::factory()->create(['role' => 'student']);
        $responseStu = $this->actingAs($student)->get(route('dashboard'));
        $responseStu->assertRedirect(route('student.dashboard'));
    }
}
