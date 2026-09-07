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

class RoleAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
    }

    public function test_student_cannot_access_admin_dashboard(): void
    {
        $studentUser = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($studentUser)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    public function test_doctor_cannot_access_admin_dashboard(): void
    {
        $doctorUser = User::factory()->create(['role' => 'doctor']);

        $response = $this->actingAs($doctorUser)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    public function test_doctor_can_access_doctor_dashboard(): void
    {
        $dept = Department::create(['name' => 'Computer Science']);
        $doctorUser = User::factory()->create(['role' => 'doctor']);
        Doctor::create([
            'user_id' => $doctorUser->id,
            'department_id' => $dept->id,
            'employee_code' => 'DOC-TEST-1',
        ]);

        $response = $this->actingAs($doctorUser)->get(route('doctor.dashboard'));

        $response->assertOk();
    }

    public function test_student_cannot_access_doctor_dashboard(): void
    {
        $studentUser = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($studentUser)->get(route('doctor.dashboard'));

        $response->assertForbidden();
    }

    public function test_doctor_cannot_grade_courses_assigned_to_another_doctor(): void
    {
        $dept = Department::create(['name' => 'Computer Science']);

        $doc1User = User::factory()->create(['role' => 'doctor']);
        $doc1 = Doctor::create([
            'user_id' => $doc1User->id,
            'department_id' => $dept->id,
            'employee_code' => 'DOC-01',
        ]);

        $doc2User = User::factory()->create(['role' => 'doctor']);
        $doc2 = Doctor::create([
            'user_id' => $doc2User->id,
            'department_id' => $dept->id,
            'employee_code' => 'DOC-02',
        ]);

        $course1 = Course::create([
            'department_id' => $dept->id,
            'doctor_id' => $doc1->id,
            'code' => 'CS101',
            'name' => 'Course 1',
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
            'course_id' => $course1->id,
            'enrollment_date' => now(),
        ]);

        // Doctor 2 attempts to post grade to Course 1 (taught by Doctor 1)
        $response = $this->actingAs($doc2User)->post(route('doctor.courses.grades.store', $course1), [
            'student_id' => $student->id,
            'grade' => 85,
        ]);

        $response->assertForbidden();
    }
}
