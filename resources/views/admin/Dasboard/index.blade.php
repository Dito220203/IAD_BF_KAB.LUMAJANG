@extends('components.layout')

@section('content')
    <main id="main" class="main">
        <!-- Page Title Section -->
        <div class="pagetitle">
            <h1 class="mb-3">
                <i class="fas fa-tachometer-alt text-primary me-2"></i>
                Dashboard
            </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#" class="text-decoration-none">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>

        @php
            $user = Auth::guard('pengguna')->user(); // ambil user login
        @endphp

        <section class="section dashboard">
            <!-- Welcome Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm overflow-hidden position-relative">
                        <!-- Background Pattern -->
                        {{-- <div class="position-absolute top-0 end-0 opacity-10">
                            <i class="fas fa-chart-line" style="font-size: 150px; color: var(--bs-primary);"></i>
                        </div> --}}

                        <div class="card-body py-5 px-4 position-relative">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <!-- Welcome Message -->
                                    <div class="mb-3">
                                        <h2 class="mb-2 text-dark fw-bold">
                                            Selamat Datang!
                                            <span class="text-primary">{{ $user->nama }}</span>
                                            <span class="fs-1">👋</span>
                                        </h2>
                                        <p class="text-muted mb-3 fs-5">
                                            Semoga hari Anda menyenangkan. Mari bersama kita kelola data dengan
                                            lebih efisien, akurat, dan transparan.
                                        </p>

                                    </div>

                                    <!-- User Info -->
                                    <div class="d-flex flex-wrap gap-3 mb-3">
                                        <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill">
                                            <i class="fas fa-user me-2"></i>
                                            Level: <strong>{{ $user->level ?? 'User' }}</strong>
                                        </div>
                                        <div class="badge bg-success-subtle text-success px-3 py-2 rounded-pill">
                                            <i class="fas fa-calendar me-2"></i>
                                            {{ date('d M Y') }}
                                        </div>
                                        <div class="badge bg-info-subtle text-info px-3 py-2 rounded-pill">
                                            <i class="fas fa-clock me-2"></i>
                                            {{ date('H:i') }} WIB
                                        </div>
                                    </div>

                                </div>

                                <!-- Welcome Illustration -->
                                <div class="col-md-4 text-center d-none d-md-block">
                                    <div class="position-relative">
                                        <div class="bg-primary-subtle rounded-circle d-inline-flex align-items-center justify-content-center"
                                            style="width: 200px; height: 200px;">
                                            <i class="fas fa-chart-bar text-primary" style="font-size: 80px;"></i>
                                        </div>
                                        <!-- Floating Elements -->
                                        <div class="position-absolute top-0 start-0">
                                            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center shadow-sm animate-float"
                                                style="width: 40px; height: 40px; animation-delay: 0s;">
                                                <i class="fas fa-star text-white"></i>
                                            </div>
                                        </div>
                                        <div class="position-absolute top-50 end-0">
                                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center shadow-sm animate-float"
                                                style="width: 35px; height: 35px; animation-delay: 1s;">
                                                <i class="fas fa-check text-white"></i>
                                            </div>
                                        </div>
                                        <div class="position-absolute bottom-0 start-50">
                                            <div class="bg-info rounded-circle d-flex align-items-center justify-content-center shadow-sm animate-float"
                                                style="width: 30px; height: 30px; animation-delay: 2s;">
                                                <i class="fas fa-bell text-white"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </section>
    </main>

    <style>
        /* Custom CSS for enhanced visual effects */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
        }

        .hover-lift {
            transition: transform 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-3px);
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .bg-primary-subtle {
            background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
        }

        .bg-success-subtle {
            background-color: rgba(var(--bs-success-rgb), 0.1) !important;
        }

        .bg-info-subtle {
            background-color: rgba(var(--bs-info-rgb), 0.1) !important;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .card-body .row .col-md-4:not(.d-none) {
                margin-top: 2rem;
            }

            .btn-lg {
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
            }
        }
    </style>
@endsection
