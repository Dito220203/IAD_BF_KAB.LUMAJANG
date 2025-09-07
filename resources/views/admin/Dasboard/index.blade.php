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
                    <div class="position-absolute top-0 end-0 opacity-10">
                        <i class="fas fa-chart-line" style="font-size: 150px; color: var(--bs-primary);"></i>
                    </div>

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
                                        Semoga hari Anda menyenangkan. Mari kelola monitoring evaluasi dengan efisien!
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

                                <!-- Quick Action -->
                                <div class="mt-4">
                                    <a href="{{ route('monev.create') }}" class="btn btn-primary btn-lg me-3 shadow-sm">
                                        <i class="fas fa-plus me-2"></i>
                                        Tambah Monitoring
                                    </a>
                                    <a href="{{ route('monev') }}" class="btn btn-outline-primary btn-lg shadow-sm">
                                        <i class="fas fa-list me-2"></i>
                                        Lihat Semua Data
                                    </a>
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

        <!-- Stats Cards Row -->
        <div class="row g-4 mb-4">
            <!-- Card 1 - Total Monitoring -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-primary bg-gradient rounded-3 p-3">
                                    <i class="fas fa-clipboard-list text-white fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Total Monitoring</h6>
                                <h4 class="mb-0 fw-bold text-dark">{{ $totalMonev ?? 0 }}</h4>
                                <small class="text-success">
                                    <i class="fas fa-arrow-up me-1"></i>Data terbaru
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2 - Status Valid -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-success bg-gradient rounded-3 p-3">
                                    <i class="fas fa-check-circle text-white fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Data Valid</h6>
                                <h4 class="mb-0 fw-bold text-dark">{{ $validMonev ?? 0 }}</h4>
                                <small class="text-success">
                                    <i class="fas fa-shield-check me-1"></i>Tervalidasi
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3 - Pending -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-warning bg-gradient rounded-3 p-3">
                                    <i class="fas fa-clock text-white fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Menunggu Validasi</h6>
                                <h4 class="mb-0 fw-bold text-dark">{{ $pendingMonev ?? 0 }}</h4>
                                <small class="text-warning">
                                    <i class="fas fa-hourglass-half me-1"></i>Review diperlukan
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 4 - This Month -->
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 card-hover">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="bg-info bg-gradient rounded-3 p-3">
                                    <i class="fas fa-calendar-alt text-white fs-4"></i>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="text-muted mb-1">Bulan Ini</h6>
                                <h4 class="mb-0 fw-bold text-dark">{{ $thisMonthMonev ?? 0 }}</h4>
                                <small class="text-info">
                                    <i class="fas fa-calendar-day me-1"></i>{{ date('M Y') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-0 py-3">
                        <h5 class="mb-0 fw-bold">
                            <i class="fas fa-bolt text-warning me-2"></i>
                            Aksi Cepat
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <a href="{{ route('monev.create') }}" class="text-decoration-none">
                                    <div class="d-flex align-items-center p-3 bg-primary bg-opacity-10 rounded-3 hover-lift">
                                        <i class="fas fa-plus-circle text-primary fs-3 me-3"></i>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark">Tambah Data Baru</h6>
                                            <small class="text-muted">Buat monitoring evaluasi</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('monev') }}" class="text-decoration-none">
                                    <div class="d-flex align-items-center p-3 bg-success bg-opacity-10 rounded-3 hover-lift">
                                        <i class="fas fa-table text-success fs-3 me-3"></i>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark">Lihat Semua Data</h6>
                                            <small class="text-muted">Kelola monitoring evaluasi</small>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="#" class="text-decoration-none">
                                    <div class="d-flex align-items-center p-3 bg-info bg-opacity-10 rounded-3 hover-lift">
                                        <i class="fas fa-chart-pie text-info fs-3 me-3"></i>
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark">Laporan</h6>
                                            <small class="text-muted">Analisis dan statistik</small>
                                        </div>
                                    </div>
                                </a>
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
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
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
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
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
