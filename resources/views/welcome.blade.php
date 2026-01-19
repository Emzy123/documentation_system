@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="container py-5">
        <div class="row align-items-center py-5">
            <div class="col-lg-6">
                <!-- Badge -->
                <div class="d-inline-flex align-items-center bg-light border rounded-pill px-3 py-1 mb-4 text-primary fw-bold" style="font-size: 0.85rem;">
                    <span class="badge bg-primary rounded-pill me-2">NEW</span> Student ID Cards & Attendance
                </div>
                
                <h1 class="display-3 fw-bold text-dark mb-3 lh-sm">
                    Your Complete <span class="text-primary">Academic</span><br>
                    <span class="text-primary">Management</span> Hub.
                </h1>
                <p class="lead text-muted mb-5 pe-lg-5">
                    Streamline your university experience. Download official documents, track attendance, check grades, and manage fees—all in one secure portal.
                </p>
                <div class="d-flex gap-3">
                    @auth
                        @php
                            $dashboardRoute = match(auth()->user()->role->slug) {
                                'admin' => route('admin.dashboard'),
                                'staff' => route('staff.dashboard'),
                                default => route('student.dashboard'),
                            };
                        @endphp
                        <a href="{{ $dashboardRoute }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow-sm fw-bold">
                            Go to Dashboard <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 rounded-pill shadow fw-bold">
                            Get Started
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-dark btn-lg px-5 rounded-pill fw-bold">
                            Login
                        </a>
                    @endauth
                </div>
                
                <div class="mt-5 text-muted small">
                    <i class="bi bi-shield-check text-success me-1"></i> Secure • 
                    <i class="bi bi-lightning-charge text-warning me-1"></i> Instant Access • 
                    <i class="bi bi-phone text-primary me-1"></i> Mobile Ready
                </div>
            </div>
            <div class="col-lg-6 text-center mt-5 mt-lg-0 position-relative">
                <div class="position-absolute top-0 start-50 translate-middle w-75 h-75 bg-primary opacity-10 rounded-circle blur-3xl z-n1" style="filter: blur(60px);"></div>
                <img src="{{ asset('images/hero_dashboard.png') }}" class="img-fluid rounded-4 shadow-lg border border-light position-relative" alt="Student Dashboard Preview" style="transform: perspective(1000px) rotateY(-5deg) rotateX(2deg);">
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section class="bg-light py-5 position-relative overflow-hidden">
        <div class="container py-5">
            <div class="text-center mb-5 mw-md mx-auto" style="max-width: 700px;">
                <h6 class="text-primary fw-bold text-uppercase ls-md mb-2">Features</h6>
                <h2 class="fw-bold text-dark display-5 mb-3">Everything you need, organized.</h2>
                <p class="text-muted fs-5">Designed to make academic administration effortless for students, staff, and administrators.</p>
            </div>
            
            <div class="row g-4">
                <!-- Academic Records -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm p-4 hover-lift transition-all">
                        <div class="mb-4 d-inline-block bg-primary bg-opacity-10 p-3 rounded-circle text-primary">
                            <i class="bi bi-mortarboard fs-2"></i>
                        </div>
                        <h4 class="fw-bold h5">Academic Records</h4>
                        <p class="text-muted small">View your current courses, credits, and up-to-date grades instantly. Download detailed transcripts anytime.</p>
                    </div>
                </div>
                
                <!-- Document Automation -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm p-4 hover-lift transition-all">
                        <div class="mb-4 d-inline-block bg-success bg-opacity-10 p-3 rounded-circle text-success">
                            <i class="bi bi-file-earmark-pdf fs-2"></i>
                        </div>
                        <h4 class="fw-bold h5">Instant Documents</h4>
                        <p class="text-muted small">Generate and download official PDF Admission Letters, ID Cards, and Certificates with a single click.</p>
                    </div>
                </div>
                
                <!-- Attendance -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm p-4 hover-lift transition-all">
                        <div class="mb-4 d-inline-block bg-warning bg-opacity-10 p-3 rounded-circle text-warning">
                            <i class="bi bi-calendar-check fs-2"></i>
                        </div>
                        <h4 class="fw-bold h5">Attendance Tracking</h4>
                        <p class="text-muted small">Keep track of your daily attendance. Teachers can mark presence in seconds, ensuring accurate records.</p>
                    </div>
                </div>

                <!-- Fee Management -->
                <div class="col-md-6 col-lg-3">
                    <div class="card h-100 border-0 shadow-sm p-4 hover-lift transition-all">
                        <div class="mb-4 d-inline-block bg-info bg-opacity-10 p-3 rounded-circle text-info">
                            <i class="bi bi-wallet2 fs-2"></i>
                        </div>
                        <h4 class="fw-bold h5">Fee Management</h4>
                        <p class="text-muted small">Monitor your tuition fee status, check outstanding balances, and view your complete payment history.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA -->
    <section class="py-5 bg-primary bg-gradient text-white text-center">
        <div class="container py-4">
            <h2 class="fw-bold mb-3">Ready to get started?</h2>
            <p class="lead opacity-75 mb-4">Join thousands of students managing their academic life smarter.</p>
            @guest
                <a href="{{ route('register') }}" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary shadow-sm hover-scale">Create Account</a>
            @else
                <a href="{{ url('/student/dashboard') }}" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary shadow-sm hover-scale">Go to Dashboard</a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-5 border-top border-secondary">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center mb-3">
                         <div class="bg-primary text-white rounded-3 d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px;">
                            <i class="bi bi-mortarboard-fill fs-6"></i>
                        </div>
                        <span class="fw-bold fs-5">StudentDocs</span>
                    </div>
                    <p class="text-secondary small">The trusted platform for academic document management and student administration.</p>
                </div>
                <div class="col-lg-2 offset-lg-6">
                    <h6 class="fw-bold mb-3 text-white">Quick Links</h6>
                    <ul class="list-unstyled small">
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-white">About Us</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-white">Contact</a></li>
                        <li class="mb-2"><a href="#" class="text-secondary text-decoration-none hover-white">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-top border-secondary mt-4 pt-4 text-center text-secondary small">
                &copy; {{ date('Y') }} Student Documentation System. All rights reserved.
            </div>
        </div>
    </footer>
</div>

<style>
.hover-lift:hover {
    transform: translateY(-5px);
    transition: transform 0.3s ease;
}
.hover-scale:hover {
    transform: scale(1.05);
    transition: transform 0.2s ease;
}
.blur-3xl {
    filter: blur(3rem);
}
</style>
@endsection
