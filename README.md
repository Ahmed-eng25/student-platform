# Student Management Platform

A clean, modern, and responsive Student Management Platform built with **Laravel 12**, **Blade**, and **Bootstrap 5**. Designed specifically as a university academic project, this application emphasizes simple, understandable, and robust architecture without unnecessary enterprise overhead.

---

## 📌 Features

### 1. Role-Based Access Control (RBAC)
The system enforces strict multi-role authorization across three distinct roles:
- **Admin**: Full administrative authority to manage departments, faculty doctors, students, courses, enrollments, and university-wide grading.
- **Doctor / Professor**: Faculty access to manage assigned courses, view student rosters for their courses, and record/update student grades. Doctor-course isolation is enforced on both backend and UI.
- **Student**: Portal for students to view registered courses, course details, instructor contacts, and individual academic grades/transcripts.

### 2. Modern Dashboard Experiences
- **Admin Dashboard**: Real-time university metrics (Total Students, Faculty Doctors, Courses, Departments), recently enrolled students, and recent courses.
- **Doctor Dashboard**: Assigned courses summary, total students taught across all classes, and recent grade submissions.
- **Student Dashboard**: Registered courses overview, credit hours, calculated average grade/GPA, and recent evaluations.

### 3. Academic Management Modules (CRUD)
- **Departments**: Create, view, edit, search, and delete academic departments.
- **Students**: Register students with auto-generated student IDs, assign departments, and select academic levels (Freshman to Senior).
- **Doctors**: Register faculty members with unique employee codes, departments, and academic specializations.
- **Courses**: Create courses with unique course codes, assign credit hours, link to departments, and assign teaching doctors.
- **Enrollments**: Enroll students in courses with duplicate prevention constraints.
- **Grades**: Record student course grades (0–100%) with automated performance status (Excellent, Very Good, Pass, Fail) and duplicate grade protection.

### 4. Security & Validation
- CSRF protection enabled on all forms.
- Strong password hashing via Laravel's Bcrypt.
- Role-based route middleware (`role:admin`, `role:doctor`, `role:student`).
- Server-side validation on every create and update action with clear error messages.
- Database unique constraints (`['student_id', 'course_id']`) preventing duplicate enrollments and grades.
- Friendly error pages for `403 Forbidden`, `404 Not Found`, `419 Session Expired`, and `500 Server Error`.

---

## 🛠️ Technology Stack

- **Backend**: Laravel 12 (PHP 8.2+)
- **Database**: MySQL / MariaDB (via XAMPP)
- **ORM**: Eloquent ORM
- **Authentication**: Laravel Breeze (Blade scaffolding)
- **Frontend**: Blade templating, Bootstrap 5, Bootstrap Icons
- **Build Tool**: Vite

---


## 🔑 Demo Accounts

The database seeder automatically populates the system with realistic demo accounts:

| Role | Email | Password | Details |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@university.edu` | `password123` | Full university system administration |
| **Doctor** | `dr.sarah@university.edu` | `password123` | Computer Science Dept (DOC-2024-001) |
| **Doctor** | `dr.ahmed@university.edu` | `password123` | Information Systems Dept (DOC-2024-002) |
| **Doctor** | `dr.emily@university.edu` | `password123` | Software Engineering Dept (DOC-2024-003) |
| **Student** | `student1@university.edu` | `password123` | CS Dept &bull; Level 3 &bull; STU-2024-0101 |
| **Student** | `student2@university.edu` | `password123` | IS Dept &bull; Level 2 &bull; STU-2024-0102 |
| **Student** | `student3@university.edu` | `password123` | SE Dept &bull; Level 4 &bull; STU-2024-0103 |
| **Student** | `student4@university.edu` | `password123` | AI Dept &bull; Level 1 &bull; STU-2024-0104 |

> Public registration via the website automatically assigns the **Student** role and sets up a student profile.

---


All 35 tests verify:
- Admin access and dashboard protection
- Doctor course isolation and grading permissions
- Student dashboard restriction
- Duplicate enrollment and grade prevention
- Authentication and password workflows

---

## 📁 Project Directory Structure

```text
student-platform/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AdminDashboardController.php
│   │   │   │   ├── CourseController.php
│   │   │   │   ├── DepartmentController.php
│   │   │   │   ├── DoctorController.php
│   │   │   │   ├── EnrollmentController.php
│   │   │   │   ├── GradeController.php
│   │   │   │   └── StudentController.php
│   │   │   ├── Auth/
│   │   │   │   └── RegisteredUserController.php
│   │   │   ├── Doctor/
│   │   │   │   ├── DoctorCourseController.php
│   │   │   │   └── DoctorDashboardController.php
│   │   │   ├── Student/
│   │   │   │   ├── StudentCourseController.php
│   │   │   │   └── StudentDashboardController.php
│   │   │   └── ProfileController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── Course.php
│       ├── Department.php
│       ├── Doctor.php
│       ├── Enrollment.php
│       ├── Grade.php
│       ├── Student.php
│       └── User.php
│
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2026_09_08_000001_create_departments_table.php
│   │   ├── 2026_09_08_000002_create_students_table.php
│   │   ├── 2026_09_08_000003_create_doctors_table.php
│   │   ├── 2026_09_08_000004_create_courses_table.php
│   │   ├── 2026_09_08_000005_create_enrollments_table.php
│   │   └── 2026_09_08_000006_create_grades_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
│
├── resources/
│   ├── css/
│   │   └── app.css (Bootstrap 5 & custom styles)
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php (Responsive dashboard layout)
│       │   ├── guest.blade.php
│       │   └── sidebar.blade.php (Role-based menu)
│       ├── components/
│       │   ├── alert.blade.php
│       │   └── stat-card.blade.php
│       ├── admin/
│       │   └── dashboard.blade.php
│       ├── doctor/
│       │   ├── dashboard.blade.php
│       │   └── courses/
│       ├── student/
│       │   ├── dashboard.blade.php
│       │   ├── courses/
│       │   └── grades/
│       ├── departments/
│       ├── students/
│       ├── doctors/
│       ├── courses/
│       ├── enrollments/
│       ├── grades/
│       └── errors/
│           ├── 403.blade.php
│           ├── 404.blade.php
│           ├── 419.blade.php
│           └── 500.blade.php
│
├── routes/
│   ├── web.php
│   └── auth.php
└── tests/
    └── Feature/
        ├── AcademicConstraintsTest.php
        └── RoleAuthorizationTest.php
```

---


