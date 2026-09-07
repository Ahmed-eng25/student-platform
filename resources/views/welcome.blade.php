<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Platform - Manage Your Academic Journey</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-3 sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2 fw-bold text-brand-primary fs-4" href="{{ route('home') }}">
                <div class="bg-primary text-white rounded-3 p-2 d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
                    <i class="bi bi-mortarboard-fill fs-5"></i>
                </div>
                <span>StudentPlatform</span>
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link fw-medium active" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="#roles">Roles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="#demo">Demo Accounts</a>
                    </li>
                </ul>

                <div class="d-flex align-items-center gap-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-primary px-4">
                            <i class="bi bi-speedometer2 me-1"></i> Go to Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary px-3">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                        <a href="{{ route('register') }}" class="btn btn-primary px-3">
                            <i class="bi bi-person-plus me-1"></i> Register as Student
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-5 py-lg-6 bg-light border-bottom">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge bg-primary-subtle text-primary mb-3 px-3 py-2 rounded-pill fw-semibold">
                        <i class="bi bi-stars me-1"></i> University Academic Portal
                    </span>
                    <h1 class="display-4 fw-extrabold text-dark tracking-tight mb-3">
                        Manage Your Academic Journey
                    </h1>
                    <p class="lead text-muted mb-4">
                        A simple and modern platform for students, doctors, and administrators. Seamlessly organize courses, track enrollments, and manage grading in one place.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg px-4 shadow-sm">
                                Enter Dashboard <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg px-4 shadow-sm">
                                Sign In <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-lg px-4">
                                Student Registration
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="col-lg-6">
                    <!-- Educational Visual Mockup Card -->
                    <div class="card border shadow-lg rounded-4 p-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between pb-3 border-bottom mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge rounded-circle bg-danger p-1"></span>
                                <span class="badge rounded-circle bg-warning p-1"></span>
                                <span class="badge rounded-circle bg-success p-1"></span>
                                <span class="small text-muted ms-2 fw-semibold">Academic Overview</span>
                            </div>
                            <span class="badge bg-success-subtle text-success">Active Semester</span>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <div class="text-muted small fw-medium">Student Performance</div>
                                    <div class="h3 fw-bold text-primary mb-0 mt-1">94.8%</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="p-3 bg-light rounded-3 text-center">
                                    <div class="text-muted small fw-medium">Registered Courses</div>
                                    <div class="h3 fw-bold text-dark mb-0 mt-1">100%</div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group list-group-flush rounded-3 border">
                            <div class="list-group-item d-flex align-items-center justify-content-between py-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-journal-check text-primary"></i>
                                    <span class="small fw-semibold">CS101: Data Structures</span>
                                </div>
                                <span class="badge bg-primary-subtle text-primary">3 Credits</span>
                            </div>
                            <div class="list-group-item d-flex align-items-center justify-content-between py-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-journal-check text-primary"></i>
                                    <span class="small fw-semibold">SE202: Software Architecture</span>
                                </div>
                                <span class="badge bg-primary-subtle text-primary">3 Credits</span>
                            </div>
                            <div class="list-group-item d-flex align-items-center justify-content-between py-2">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-journal-check text-primary"></i>
                                    <span class="small fw-semibold">AI301: Machine Learning Basics</span>
                                </div>
                                <span class="badge bg-primary-subtle text-primary">4 Credits</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Roles Section -->
    <section id="roles" class="py-5">
        <div class="container py-4">
            <div class="text-center max-w-xl mx-auto mb-5">
                <h2 class="fw-bold text-dark">Tailored for Every Academic Role</h2>
                <p class="text-muted">Distinct access levels and specialized dashboards designed for clear separation of concerns.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 border rounded-4 p-4 shadow-sm hover-shadow">
                        <div class="stat-icon bg-danger-subtle text-danger mb-3">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Administrator</h4>
                        <p class="text-muted small mb-3">Complete control over departments, courses, doctors, students, enrollments, and academic grades.</p>
                        <ul class="list-unstyled small text-muted mb-0">
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i> Manage departments & courses</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i> Register doctors & students</li>
                            <li><i class="bi bi-check2 text-success me-2"></i> Monitor university analytics</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border rounded-4 p-4 shadow-sm hover-shadow">
                        <div class="stat-icon bg-success-subtle text-success mb-3">
                            <i class="bi bi-person-workspace"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Doctor / Professor</h4>
                        <p class="text-muted small mb-3">Focused on assigned courses. View enrolled students, input exam results, and monitor course progress.</p>
                        <ul class="list-unstyled small text-muted mb-0">
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i> View assigned course rosters</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i> Record and update student grades</li>
                            <li><i class="bi bi-check2 text-success me-2"></i> Strict doctor-course ownership</li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 border rounded-4 p-4 shadow-sm hover-shadow">
                        <div class="stat-icon bg-primary-subtle text-primary mb-3">
                            <i class="bi bi-backpack-fill"></i>
                        </div>
                        <h4 class="fw-bold mb-2">Student</h4>
                        <p class="text-muted small mb-3">Student self-service portal to track registered courses, credit hours, doctor assignments, and final grades.</p>
                        <ul class="list-unstyled small text-muted mb-0">
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i> View enrolled courses</li>
                            <li class="mb-2"><i class="bi bi-check2 text-success me-2"></i> Track grades and GPA</li>
                            <li><i class="bi bi-check2 text-success me-2"></i> Quick profile management</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Demo Credentials Section -->
    <section id="demo" class="py-5 bg-light border-top">
        <div class="container py-4">
            <div class="text-center max-w-xl mx-auto mb-4">
                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill fw-semibold mb-2">Demo Access</span>
                <h3 class="fw-bold text-dark">Ready-to-Use Demo Accounts</h3>
                <p class="text-muted small">You can log in immediately using any of these seeded credentials:</p>
            </div>

            <div class="row g-3 justify-content-center">
                <div class="col-md-4">
                    <div class="card border rounded-3 p-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge bg-danger">Admin Account</span>
                            <i class="bi bi-shield-lock text-danger"></i>
                        </div>
                        <div class="small text-muted mb-1">Email: <strong class="text-dark">admin@university.edu</strong></div>
                        <div class="small text-muted mb-2">Password: <code class="text-danger">password123</code></div>
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-danger w-100 mt-2">Log in as Admin</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border rounded-3 p-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge bg-success">Doctor Account</span>
                            <i class="bi bi-person-workspace text-success"></i>
                        </div>
                        <div class="small text-muted mb-1">Email: <strong class="text-dark">dr.sarah@university.edu</strong></div>
                        <div class="small text-muted mb-2">Password: <code class="text-success">password123</code></div>
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-success w-100 mt-2">Log in as Doctor</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border rounded-3 p-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge bg-primary">Student Account</span>
                            <i class="bi bi-backpack text-primary"></i>
                        </div>
                        <div class="small text-muted mb-1">Email: <strong class="text-dark">student1@university.edu</strong></div>
                        <div class="small text-muted mb-2">Password: <code class="text-primary">password123</code></div>
                        <a href="{{ route('login') }}" class="btn btn-sm btn-outline-primary w-100 mt-2">Log in as Student</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-top py-4 text-center text-muted small">
        <div class="container">
            <p class="mb-1">&copy; {{ date('Y') }} Student Management Platform. Built with Laravel & Bootstrap 5.</p>
            <p class="mb-0 text-muted">A modern educational project designed for university demonstration.</p>
        </div>
    </footer>
</body>
</html>
