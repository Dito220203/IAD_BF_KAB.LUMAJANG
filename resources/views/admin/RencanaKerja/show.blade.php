@extends('components.layout')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Detail Rencana Kerja</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item">Rencana Kerja</li>
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
                                    <th>Subprogram</th>
                                    <td>{{ $rencana->subprogram->subprogram ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Judul</th>
                                    <td>{{ $rencana->judul }}</td>
                                </tr>
                                <tr>
                                    <th>Lokasi</th>
                                    <td>{{ $rencana->lokasi }}</td>
                                </tr>
                                <tr>
                                    <th>Tahun</th>
                                    <td>{{ $rencana->tahun }}</td>
                                </tr>
                                <tr>
                                    <th>Anggaran</th>
                                    <td>Rp {{ number_format($rencana->anggaran, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>OPD</th>
                                    <td>{{ $rencana->opd->nama ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge bg-{{ $rencana->status == 'Valid' ? 'success' : 'warning' }}">
                                            {{ $rencana->status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td>{{ $rencana->keterangan }}</td>
                                </tr>

                            </table>

                            <a href="{{ route('rencanakerja') }}" class="btn btn-secondary mt-3">Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
