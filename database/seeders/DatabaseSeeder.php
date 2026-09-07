<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Academic Departments
        $csDept = Department::create([
            'name' => 'Computer Science',
            'description' => 'Focuses on computation, algorithms, data structures, and computer architecture.',
        ]);

        $isDept = Department::create([
            'name' => 'Information Systems',
            'description' => 'Focuses on integrating information technology solutions and business processes.',
        ]);

        $seDept = Department::create([
            'name' => 'Software Engineering',
            'description' => 'Applies systematic engineering principles to software architecture and lifecycle.',
        ]);

        $aiDept = Department::create([
            'name' => 'Artificial Intelligence',
            'description' => 'Covers machine learning, neural networks, computer vision, and robotics.',
        ]);

        // 2. Create Administrator Account
        User::create([
            'name' => 'System Administrator',
            'email' => 'admin@university.edu',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 3. Create Faculty Doctors
        $doc1User = User::create([
            'name' => 'Sarah Connor',
            'email' => 'dr.sarah@university.edu',
            'password' => Hash::make('password123'),
            'role' => 'doctor',
        ]);
        $doc1 = Doctor::create([
            'user_id' => $doc1User->id,
            'department_id' => $csDept->id,
            'employee_code' => 'DOC-2024-001',
            'phone' => '+1 (555) 234-5671',
            'specialization' => 'Machine Learning & Algorithms',
        ]);

        $doc2User = User::create([
            'name' => 'Ahmed Mansour',
            'email' => 'dr.ahmed@university.edu',
            'password' => Hash::make('password123'),
            'role' => 'doctor',
        ]);
        $doc2 = Doctor::create([
            'user_id' => $doc2User->id,
            'department_id' => $isDept->id,
            'employee_code' => 'DOC-2024-002',
            'phone' => '+1 (555) 234-5672',
            'specialization' => 'Database Systems & Cloud Computing',
        ]);

        $doc3User = User::create([
            'name' => 'Emily Watson',
            'email' => 'dr.emily@university.edu',
            'password' => Hash::make('password123'),
            'role' => 'doctor',
        ]);
        $doc3 = Doctor::create([
            'user_id' => $doc3User->id,
            'department_id' => $seDept->id,
            'employee_code' => 'DOC-2024-003',
            'phone' => '+1 (555) 234-5673',
            'specialization' => 'Software Architecture & Quality Assurance',
        ]);

        // 4. Create Students
        $stu1User = User::create([
            'name' => 'John Smith',
            'email' => 'student1@university.edu',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);
        $stu1 = Student::create([
            'user_id' => $stu1User->id,
            'department_id' => $csDept->id,
            'student_code' => 'STU-2024-0101',
            'phone' => '+1 (555) 987-1001',
            'level' => 3,
        ]);

        $stu2User = User::create([
            'name' => 'Maria Garcia',
            'email' => 'student2@university.edu',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);
        $stu2 = Student::create([
            'user_id' => $stu2User->id,
            'department_id' => $isDept->id,
            'student_code' => 'STU-2024-0102',
            'phone' => '+1 (555) 987-1002',
            'level' => 2,
        ]);

        $stu3User = User::create([
            'name' => 'Alex Chen',
            'email' => 'student3@university.edu',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);
        $stu3 = Student::create([
            'user_id' => $stu3User->id,
            'department_id' => $seDept->id,
            'student_code' => 'STU-2024-0103',
            'phone' => '+1 (555) 987-1003',
            'level' => 4,
        ]);

        $stu4User = User::create([
            'name' => 'Fatma Al-Hassan',
            'email' => 'student4@university.edu',
            'password' => Hash::make('password123'),
            'role' => 'student',
        ]);
        $stu4 = Student::create([
            'user_id' => $stu4User->id,
            'department_id' => $aiDept->id,
            'student_code' => 'STU-2024-0104',
            'phone' => '+1 (555) 987-1004',
            'level' => 1,
        ]);

        // 5. Create Academic Courses
        $c1 = Course::create([
            'department_id' => $csDept->id,
            'doctor_id' => $doc1->id,
            'code' => 'CS101',
            'name' => 'Introduction to Computer Science',
            'description' => 'Fundamental concepts of programming, algorithmic thinking, and computer systems.',
            'credit_hours' => 3,
        ]);

        $c2 = Course::create([
            'department_id' => $csDept->id,
            'doctor_id' => $doc1->id,
            'code' => 'CS201',
            'name' => 'Data Structures & Algorithms',
            'description' => 'Trees, graphs, hashing, sorting algorithms, and complexity analysis (Big O notation).',
            'credit_hours' => 4,
        ]);

        $c3 = Course::create([
            'department_id' => $isDept->id,
            'doctor_id' => $doc2->id,
            'code' => 'IS102',
            'name' => 'Database Management Systems',
            'description' => 'Relational database design, normalization, SQL queries, transaction management, and indexing.',
            'credit_hours' => 3,
        ]);

        $c4 = Course::create([
            'department_id' => $isDept->id,
            'doctor_id' => $doc2->id,
            'code' => 'IS301',
            'name' => 'Enterprise Cloud Computing',
            'description' => 'Cloud architecture, distributed microservices, serverless compute, and virtualization.',
            'credit_hours' => 3,
        ]);

        $c5 = Course::create([
            'department_id' => $seDept->id,
            'doctor_id' => $doc3->id,
            'code' => 'SE202',
            'name' => 'Software Engineering Principles',
            'description' => 'Software lifecycle methodologies, design patterns, UML modeling, and code refactoring.',
            'credit_hours' => 3,
        ]);

        $c6 = Course::create([
            'department_id' => $seDept->id,
            'doctor_id' => $doc3->id,
            'code' => 'SE305',
            'name' => 'Agile DevOps & CI/CD',
            'description' => 'Continuous integration, delivery pipelines, automated test suites, and containerization.',
            'credit_hours' => 3,
        ]);

        $c7 = Course::create([
            'department_id' => $aiDept->id,
            'doctor_id' => $doc1->id,
            'code' => 'AI301',
            'name' => 'Machine Learning Foundations',
            'description' => 'Supervised and unsupervised learning, gradient descent, neural networks, and model evaluation.',
            'credit_hours' => 4,
        ]);

        $c8 = Course::create([
            'department_id' => $csDept->id,
            'doctor_id' => $doc2->id,
            'code' => 'CS304',
            'name' => 'Computer Networks & Protocols',
            'description' => 'OSI model, TCP/IP networking, routing algorithms, socket programming, and network security.',
            'credit_hours' => 3,
        ]);

        // 6. Create Enrollments
        $enrollmentDate = now()->subMonths(2)->format('Y-m-d');

        // Student 1 enrollments
        Enrollment::create(['student_id' => $stu1->id, 'course_id' => $c1->id, 'enrollment_date' => $enrollmentDate]);
        Enrollment::create(['student_id' => $stu1->id, 'course_id' => $c2->id, 'enrollment_date' => $enrollmentDate]);
        Enrollment::create(['student_id' => $stu1->id, 'course_id' => $c3->id, 'enrollment_date' => $enrollmentDate]);
        Enrollment::create(['student_id' => $stu1->id, 'course_id' => $c5->id, 'enrollment_date' => $enrollmentDate]);

        // Student 2 enrollments
        Enrollment::create(['student_id' => $stu2->id, 'course_id' => $c1->id, 'enrollment_date' => $enrollmentDate]);
        Enrollment::create(['student_id' => $stu2->id, 'course_id' => $c3->id, 'enrollment_date' => $enrollmentDate]);
        Enrollment::create(['student_id' => $stu2->id, 'course_id' => $c4->id, 'enrollment_date' => $enrollmentDate]);

        // Student 3 enrollments
        Enrollment::create(['student_id' => $stu3->id, 'course_id' => $c5->id, 'enrollment_date' => $enrollmentDate]);
        Enrollment::create(['student_id' => $stu3->id, 'course_id' => $c6->id, 'enrollment_date' => $enrollmentDate]);
        Enrollment::create(['student_id' => $stu3->id, 'course_id' => $c8->id, 'enrollment_date' => $enrollmentDate]);

        // Student 4 enrollments
        Enrollment::create(['student_id' => $stu4->id, 'course_id' => $c1->id, 'enrollment_date' => $enrollmentDate]);
        Enrollment::create(['student_id' => $stu4->id, 'course_id' => $c7->id, 'enrollment_date' => $enrollmentDate]);

        // 7. Record Grades
        Grade::create(['student_id' => $stu1->id, 'course_id' => $c1->id, 'grade' => 88.50]);
        Grade::create(['student_id' => $stu1->id, 'course_id' => $c2->id, 'grade' => 92.00]);
        Grade::create(['student_id' => $stu1->id, 'course_id' => $c3->id, 'grade' => 78.50]);

        Grade::create(['student_id' => $stu2->id, 'course_id' => $c3->id, 'grade' => 85.00]);
        Grade::create(['student_id' => $stu2->id, 'course_id' => $c1->id, 'grade' => 74.00]);

        Grade::create(['student_id' => $stu3->id, 'course_id' => $c5->id, 'grade' => 95.00]);
        Grade::create(['student_id' => $stu3->id, 'course_id' => $c6->id, 'grade' => 91.00]);

        Grade::create(['student_id' => $stu4->id, 'course_id' => $c1->id, 'grade' => 84.00]);
    }
}
