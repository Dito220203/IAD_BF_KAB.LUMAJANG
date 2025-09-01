@extends('components.layout')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Dashboard</li>
                </ol>
            </nav>
        </div>

        @php
            $user = Auth::guard('pengguna')->user(); // pastikan guard sesuai
        @endphp

        <section class="section dashboard">
            <div class="row">

                {{-- Statistik Cepat: hanya untuk superadmin --}}
                @if ($user && $user->level === 'Super Admin')
                    <div class="col-lg-3 col-md-6">
                        <div class="card info-card">
                            <div class="card-body">
                                <h5 class="card-title">Pengguna</h5>
                                <div class="d-flex align-items-center">
                                    <div
                                        class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary text-white">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $totalPengguna }}</h6>
                                        <span class="text-muted small">Total terdaftar</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Progres Kerja Keseluruhan -->
                    <div class="col-lg-3 col-md-6">
                        <div class="card info-card">
                            <div class="card-body">
                                <h5 class="card-title">Progres Kerja</h5>
                                <div class="progress mt-3" style="height: 20px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 75%;"
                                        aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                        75%
                                    </div>
                                </div>
                                <small class="text-muted">Dari semua target tahun ini</small>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Informasi Terbaru -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-info text-white">Informasi Terbaru</div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach ($informasi as $data)
                                    <li class="list-group-item">
                                        <strong>{{ $data->judul }}</strong> <br>
                                        <small class="text-muted">{{ $data->tanggal }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            @if ($user && $user->level === 'Super Admin')
                <!-- Tabel Pengguna Terbaru -->
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-header">
                                <h5>Pengguna Terbaru</h5>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Level</th>
                                            <th>OPD</th>
                                            <th>Tanggal Daftar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($penggunaTerbaru as $userRow)
                                            <tr>
                                                <td>{{ $userRow->nama }}</td>
                                                <td>{{ $userRow->username }}</td>
                                                <td>{{ $userRow->level }}</td>
                                                <td>{{ $userRow->opd->nama ?? '-' }}</td>
                                                <td>{{ $userRow->created_at->format('d M Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Chart Monitoring & Evaluasi -->
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">Monitoring & Evaluasi Progres Per OPD</div>
                            <div class="card-body">
                                <canvas id="chartOpd" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </section>
    </main>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const ctx = document.getElementById('chartOpd').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json(collect($progresOpd)->pluck('nama')),
                    datasets: [{
                        label: 'Progres (%)',
                        data: @json(collect($progresOpd)->pluck('persentase')),
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });
        });
    </script>
@endsection
