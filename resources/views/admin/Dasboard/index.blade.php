@extends('components.layout')

@section('content')
@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::guard('pengguna')->user(); // ambil user login

   
@endphp

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
                    <a>
                        <i class="fas fa-home me-1"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        {{-- Welcome Card --}}
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm overflow-hidden position-relative welcome-card">
                    <div class="card-body py-5 px-4 position-relative">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h2 class="mb-2 text-dark fw-bold">
                                    Selamat Datang!
                                    <span class="text-primary">{{ $user->nama }}</span> 👋
                                </h2>
                                <p class="text-muted mb-3 fs-5">
                                    Semoga hari Anda menyenangkan. Mari bersama kita kelola data dengan
                                    lebih efisien, akurat, dan transparan.
                                </p>

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

                            {{-- Icon Dashboard --}}
                            <div class="col-md-4 text-center d-none d-md-block">
                                <div class="position-relative">
                                    <div class="bg-primary-subtle rounded-circle d-inline-flex align-items-center justify-content-center"
                                         style="width: 200px; height: 200px;">
                                        <i class="fas fa-chart-bar text-primary" style="font-size: 80px;"></i>
                                    </div>
                                    {{-- Floating Elements --}}
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

        {{-- Statistik Card --}}
        <div class="row mb-4">
            {{-- Rencana Kerja --}}
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-header bg-gradient-primary text-white border-0 py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-1 fw-bold">
                                    <i class="fas fa-tasks me-2"></i> Rencana Kerja
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
                        {{-- Ringkasan --}}
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

                        {{-- Progress Bar --}}
                        @php
                            $progressPercentage = ($rencanaSelesai / max($totalRencanaKerja,1)) * 100;
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Progress Keseluruhan</small>
                                <small class="fw-bold">{{ number_format($progressPercentage, 1) }}%</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success progress-bar-animated"
                                     style="width: {{ $progressPercentage }}%"></div>
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex gap-2">
                       
                            <a href="{{route('rencanakerja')}}" class="btn btn-outline-primary btn-sm flex-fill hover-lift">
                                <i class="fas fa-list me-1"></i> Lihat Semua
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Monitoring Evaluasi --}}
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="card border-0 shadow-sm card-hover h-100">
                    <div class="card-header bg-gradient-info text-white border-0 py-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-1 fw-bold">
                                    <i class="fas fa-chart-line me-2"></i> Monitoring Evaluasi
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
                        {{-- Status --}}
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
                                    @if($monevBelumLengkap > 0)
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge bg-danger rounded-pill pulse-animation">!</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Alert --}}
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

                        {{-- Progress --}}
                        @php
                            $monevProgressPercentage = ($monevLengkap / max($totalMonev,1)) * 100;
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <small class="text-muted">Kelengkapan Data</small>
                                <small class="fw-bold">{{ number_format($monevProgressPercentage, 1) }}%</small>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info progress-bar-animated"
                                     style="width: {{ $monevProgressPercentage }}%"></div>
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <div class="d-flex gap-2">
                            <a href="{{route('monev')}}" class="btn btn-info btn-sm flex-fill hover-lift text-white">
                                <i class="fas fa-edit me-1"></i> Lengkapi Data
                            </a>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>

   
    </section>
</main>


@endsection
