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

    <section class="section dashboard">
        <div class="row">

            <!-- Statistik Cepat -->
            <div class="col-lg-3 col-md-6">
                <div class="card info-card">
                    <div class="card-body">
                        <h5 class="card-title">Pengguna</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary text-white">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6>120</h6>
                                <span class="text-muted small">Total terdaftar</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progres Kerja -->
            <div class="col-lg-3 col-md-6">
                <div class="card info-card">
                    <div class="card-body">
                        <h5 class="card-title">Progres Kerja</h5>
                        <div class="progress mt-3" style="height: 20px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                 style="width: 75%;"
                                 aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                75%
                            </div>
                        </div>
                        <small class="text-muted">Dari semua target tahun ini</small>
                    </div>
                </div>
            </div>

            <!-- Informasi Terbaru -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-info text-white">Informasi Terbaru</div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item">
                                <strong>Rapat Koordinasi OPD</strong> <br>
                                <small class="text-muted">14 Agustus 2025</small>
                            </li>
                            <li class="list-group-item">
                                <strong>Update Sistem Aplikasi</strong> <br>
                                <small class="text-muted">12 Agustus 2025</small>
                            </li>
                            <li class="list-group-item">
                                <strong>Pengumuman Cuti Bersama</strong> <br>
                                <small class="text-muted">10 Agustus 2025</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

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
                                <tr>
                                    <td>Dito Febriansyah</td>
                                    <td>dito</td>
                                    <td>Admin</td>
                                    <td>Dinas Pendidikan</td>
                                    <td>14 Aug 2025</td>
                                </tr>
                                <tr>
                                    <td>Putri Ayu</td>
                                    <td>putri</td>
                                    <td>User</td>
                                    <td>Dinas Kesehatan</td>
                                    <td>13 Aug 2025</td>
                                </tr>
                                <tr>
                                    <td>Budi Santoso</td>
                                    <td>budi</td>
                                    <td>Operator</td>
                                    <td>Dinas PU</td>
                                    <td>12 Aug 2025</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Progres Per OPD</div>
                    <div class="card-body">
                        <canvas id="chartOpd" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </section>
</main>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    new Chart(document.getElementById('chartOpd'), {
        type: 'bar',
        data: {
            labels: ['Dinas Pendidikan', 'Dinas Kesehatan', 'Dinas PU', 'Dinas Sosial'],
            datasets: [{
                label: 'Progres (%)',
                data: [80, 60, 90, 50],
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true, max: 100 }
            }
        }
    });
});
</script>

@endsection
