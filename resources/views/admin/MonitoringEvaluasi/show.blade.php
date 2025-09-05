@extends('components.layout')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Detail Monitoring Evaluasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item">Monitoring Evaluasi</li>
                    <li class="breadcrumb-item active">Detail</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body mt-3">
                            <table class="table table-bordered">

                                <tr>
                                    <th>Rencana Kegiatan</th>
                                    <td>{{ $monev->rencanaKerja->judul ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Subprogram</th>
                                    <td>{{ $monev->subprogram->subprogram ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Lokasi</th>
                                    <td>{{ $monev->lokasi }}</td>
                                </tr>
                                <tr>
                                    <th>Tahun</th>
                                    <td>{{ $monev->tahun }}</td>
                                </tr>
                                <tr>
                                    <th>Anggaran</th>
                                    <td>Rp {{ number_format($monev->anggaran, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Perangkat Daerah</th>
                                    <td>{{ $monev->opd->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>RKA</th>
                                    <td>{{ $monev->rka }}</td>
                                </tr>
                                <tr>
                                    <th>Realisasi</th>
                                    <td>{{ $monev->realisasi }}</td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>{{ $monev->keterangan }}</td>
                                </tr>
                            </table>

                            <a href="{{ route('monev') }}" class="btn btn-secondary mt-3">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
