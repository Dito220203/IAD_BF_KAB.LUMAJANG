@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tambah Monitoring Evaluasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item">Monitoring Evaluasi</li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Form Monitoring Evaluasi</h5>

                            <!-- Form Create -->
                            <form action="{{ route('monev.store') }}" method="POST">
                                @csrf

                                {{-- Nama Program --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Nama Program</label>
                                    <div class="col-sm-10">
                                        <select name="id_subprogram" class="form-select" required>
                                            <option value="">Pilih</option>
                                            @foreach ($subprogram as $data)
                                                <option value="{{ $data->id }}">{{ $data->subprogram }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Rencana Kegiatan --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Rencana Kegiatan</label>
                                    <div class="col-sm-10">
                                        <select name="id_renja" class="form-select">
                                            <option value="">Pilih</option>
                                            @foreach ($rencana as $data)
                                                <option value="{{ $data->id }}">{{ $data->judul }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Lokasi --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Lokasi</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="lokasi" class="form-control">
                                    </div>
                                </div>

                                {{-- Tahun --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Tahun</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tahun" class="form-control">
                                    </div>
                                </div>

                                {{-- Anggaran --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Anggaran</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="anggaran" class="form-control">
                                    </div>
                                </div>

                                {{-- Perangkat Daerah --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Perangkat Daerah</label>
                                    <div class="col-sm-10">
                                        <select name="id_opd" class="form-select">
                                            <option value="">Pilih</option>
                                            @foreach ($opd as $data)
                                                <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">RKA</label>
                                    <div class="col-sm-10">
                                        <select name="rka" class="form-select" required>
                                            <option value="">Pilih</option>
                                            <option value="sudah">Sudah</option>
                                            <option value="belum">Belum</option>
                                        </select>
                                    </div>
                                </div>


                                {{-- Realisasi --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Realisasi</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="realisasi" class="form-control">
                                    </div>
                                </div>

                                {{-- Keterangan --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Keterangan</label>
                                    <div class="col-sm-10">
                                        <textarea name="keterangan" class="form-control" rows="4" placeholder="Tulis keterangan tambahan..."></textarea>
                                    </div>
                                </div>

                                <!-- Tombol -->
                                <div class="row mb-3">
                                    <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                        <a href="{{ route('monev') }}" class="btn btn-warning">Kembali</a>
                                    </div>
                                </div>
                            </form><!-- End Form -->

                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>
@endsection
