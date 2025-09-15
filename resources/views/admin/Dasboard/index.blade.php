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

            // Data dummy untuk contoh - ganti dengan query database Anda
            $totalRencanaKerja = 15;
            $rencanaSelesai = 8;
            $rencanaProgress = 5;
            $rencanaBlmMulai = 2;

            $totalMonev = 13; // Total monev yang sudah dibuat dari rencana kerja
            $monevLengkap = 6;
            $monevBelumLengkap = 7;
        @endphp

        <section class="section dashboard">
            <!-- Welcome Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm overflow-hidden position-relative welcome-card">
                        <div class="card-body py-5 px-4 position-relative">
                            <div class="row align-items-center">
                                <div class="col-md-8">

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

            <!-- Statistics Cards Row -->
            <div class="row mb-4">
                <!-- Rencana Kerja Card -->
                <div class="col-md-6 col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm card-hover h-100">
                        <div class="card-header bg-gradient-primary text-white border-0 py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-1 fw-bold">
                                        <i class="fas fa-tasks me-2"></i>
                                        Rencana Kerja
                                    </h5>
                                    <small class="opacity-75">Manajemen rencana kerja</small>
                                </div>
                                <div class="text-end">
                                    <div class="fs-2 fw-bold">{{ $totalRencanaKerja }}</div>
                                    <small class="opacity-75">Total Rencana</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Progress Summary -->
                            <div class="row text-center mb-3">
                                <div class="col-6">
                                    <div class="p-3 rounded bg-success-subtle">
                                        <div class="fs-4 fw-bold text-success">{{ $rencanaSelesai }}</div>
                                        <small class="text-muted">Valid</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded bg-warning-subtle">
                                        <div class="fs-4 fw-bold text-warning">{{ $rencanaProgress }}</div>
                                        <small class="text-muted">Tidak Valid</small>
                                    </div>
                                </div>
                            
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-3">
                                @php
                                    $progressPercentage = ($rencanaSelesai / $totalRencanaKerja) * 100;
                                @endphp
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Progress Keseluruhan</small>
                                    <small class="fw-bold">{{ number_format($progressPercentage, 1) }}%</small>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success progress-bar-animated"
                                         style="width: {{ $progressPercentage }}%"></div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-primary btn-sm flex-fill hover-lift">
                                    <i class="fas fa-plus me-1"></i>
                                    Tambah Rencana
                                </a>
                                <a href="#" class="btn btn-outline-primary btn-sm flex-fill hover-lift">
                                    <i class="fas fa-list me-1"></i>
                                    Lihat Semua
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Monitoring Evaluasi Card -->
                <div class="col-md-6 col-lg-6 mb-4">
                    <div class="card border-0 shadow-sm card-hover h-100">
                        <div class="card-header bg-gradient-info text-white border-0 py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <h5 class="mb-1 fw-bold">
                                        <i class="fas fa-chart-line me-2"></i>
                                        Monitoring Evaluasi
                                    </h5>
                                    <small class="opacity-75">Status monitoring & evaluasi</small>
                                </div>
                                <div class="text-end">
                                    <div class="fs-2 fw-bold">{{ $totalMonev }}</div>
                                    <small class="opacity-75">Total Monev</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Monev Status -->
                            <div class="row text-center mb-3">
                                <div class="col-6">
                                    <div class="p-3 rounded bg-success-subtle">
                                        <div class="fs-4 fw-bold text-success">{{ $monevLengkap }}</div>
                                        <small class="text-muted">Data Lengkap</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded bg-danger-subtle position-relative">
                                        <div class="fs-4 fw-bold text-danger">{{ $monevBelumLengkap }}</div>
                                        <small class="text-muted">Belum Lengkap</small>
                                        <!-- Warning indicator -->
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-danger rounded-pill pulse-animation">!</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Alert untuk data belum lengkap -->
                            @if($monevBelumLengkap > 0)
                            <div class="alert alert-warning border-0 rounded-3 mb-3" role="alert">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    <div>
                                        <strong>Perhatian!</strong><br>
                                        <small>{{ $monevBelumLengkap }} data monev memiliki kolom yang belum terisi lengkap</small>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Completion Progress -->
                            <div class="mb-3">
                                @php
                                    $monevProgressPercentage = ($monevLengkap / $totalMonev) * 100;
                                @endphp
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Kelengkapan Data</small>
                                    <small class="fw-bold">{{ number_format($monevProgressPercentage, 1) }}%</small>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info progress-bar-animated"
                                         style="width: {{ $monevProgressPercentage }}%"></div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-info btn-sm flex-fill hover-lift text-white">
                                    <i class="fas fa-edit me-1"></i>
                                    Lengkapi Data
                                </a>
                                <a href="#" class="btn btn-outline-info btn-sm flex-fill hover-lift">
                                    <i class="fas fa-chart-bar me-1"></i>
                                    Lihat Laporan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light border-0 py-3">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="mb-0 fw-bold">
                                    <i class="fas fa-clock text-primary me-2"></i>
                                    Aktivitas Terbaru
                                </h5>
                                <a href="#" class="btn btn-outline-primary btn-sm hover-lift">
                                    <i class="fas fa-history me-1"></i>
                                    Lihat Semua
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <!-- Timeline Item 1 -->
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="mb-1">Rencana Kerja "Pengembangan Sistem" selesai</h6>
                                            <small class="text-muted">2 jam lalu</small>
                                        </div>
                                        <p class="text-muted mb-0 small">Data monev otomatis dibuat dan siap untuk dilengkapi</p>
                                    </div>
                                </div>

                                <!-- Timeline Item 2 -->
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-warning"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="mb-1">Data monev "Pelatihan SDM" belum lengkap</h6>
                                            <small class="text-muted">5 jam lalu</small>
                                        </div>
                                        <p class="text-muted mb-0 small">Mohon lengkapi kolom evaluasi dan dokumentasi</p>
                                    </div>
                                </div>

                                <!-- Timeline Item 3 -->
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="mb-1">Rencana Kerja baru ditambahkan</h6>
                                            <small class="text-muted">1 hari lalu</small>
                                        </div>
                                        <p class="text-muted mb-0 small">Rencana "Modernisasi Infrastruktur" telah dibuat</p>
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
        /* Enhanced Custom CSS */
        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--bs-primary), #0056b3);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, var(--bs-info), #0056b3);
        }

        .welcome-card {
            background: linear-gradient(135deg, #fff 0%, #f8f9ff 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
            border-radius: 15px !important;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
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

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Subtle Background Colors */
        .bg-primary-subtle {
            background-color: rgba(var(--bs-primary-rgb), 0.1) !important;
        }

        .bg-success-subtle {
            background-color: rgba(var(--bs-success-rgb), 0.1) !important;
        }

        .bg-info-subtle {
            background-color: rgba(var(--bs-info-rgb), 0.1) !important;
        }

        .bg-warning-subtle {
            background-color: rgba(var(--bs-warning-rgb), 0.1) !important;
        }

        .bg-danger-subtle {
            background-color: rgba(var(--bs-danger-rgb), 0.1) !important;
        }

        .bg-secondary-subtle {
            background-color: rgba(var(--bs-secondary-rgb), 0.1) !important;
        }

        /* Timeline Styles */
        .timeline {
            position: relative;
            padding: 0;
        }

        .timeline-item {
            position: relative;
            padding-left: 2rem;
            margin-bottom: 1.5rem;
        }

        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: 8px;
            top: 1.5rem;
            width: 2px;
            height: calc(100% + 1rem);
            background: #e9ecef;
        }

        .timeline-marker {
            position: absolute;
            left: 0;
            top: 0.25rem;
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #e9ecef;
        }

        .timeline-content {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
            border-left: 3px solid var(--bs-primary);
        }

        /* Progress Bar Animation */
        .progress-bar-animated {
            animation: progress-animation 1.5s ease-in-out;
        }

        @keyframes progress-animation {
            0% {
                width: 0%;
            }
            100% {
                width: var(--progress-width);
            }
        }

        /* Card Header Improvements */
        .card-header {
            border-radius: 15px 15px 0 0 !important;
        }

        /* Responsive Improvements */
        @media (max-width: 768px) {
            .card-hover:hover {
                transform: none;
            }

            .timeline-item {
                padding-left: 1.5rem;
            }

            .timeline-marker {
                width: 12px;
                height: 12px;
            }

            .fs-2 {
                font-size: 1.5rem !important;
            }
        }

        /* Custom Alert */
        .alert {
            border-left: 4px solid;
        }

        .alert-warning {
            border-left-color: var(--bs-warning);
            background: rgba(var(--bs-warning-rgb), 0.05);
        }
    </style>
@endsection
