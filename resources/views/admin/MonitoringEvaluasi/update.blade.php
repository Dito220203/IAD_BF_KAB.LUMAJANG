@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Edit Monitoring Evaluasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item">Monitoring Evaluasi</li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Form Edit Monitoring Evaluasi</h5>

                            <!-- Form Edit -->
                            <form action="{{ route('monev.update', $monev->id) }}" method="POST">
                                @csrf
                                @method('PUT')



                                {{-- Rencana Kegiatan --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Rencana Kegiatan</label>
                                    <div class="col-sm-10">
                                        <select name="id_renja" class="form-select">
                                            <option value="">Pilih</option>
                                            @foreach ($rencana as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ $monev->id_renja == $data->id ? 'selected' : '' }}>
                                                    {{ $data->judul }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Nama Program --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Nama Program</label>
                                    <div class="col-sm-10">

                                        <input type="text" id="nama_program" name="e_program" class="form-control"
                                            value="{{ old('e_program', $monev->program) }}">

                                    </div>
                                </div>

                                {{-- Lokasi --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Lokasi</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="e_lokasi" class="form-control"
                                            value="{{ $monev->lokasi }}">
                                    </div>
                                </div>

                                {{-- Tahun --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Tahun</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="e_tahun" class="form-control"
                                            value="{{ $monev->tahun }}">
                                    </div>
                                </div>

                                {{-- Anggaran --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Anggaran</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="e_anggaran" class="form-control"
                                            value="{{ $monev->anggaran }}">
                                    </div>
                                </div>

                                @auth('pengguna')
                                    @if (Auth::guard('pengguna')->user()->level === 'Super Admin')
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label">Perangkat Daerah</label>
                                            <div class="col-sm-10">
                                                <select name="id_opd" class="form-select">
                                                    <option value="">Pilih</option>
                                                    @foreach ($opd as $data)
                                                        <option value="{{ $data->id }}"
                                                            {{ $monev->id_opd == $data->id ? 'selected' : '' }}>
                                                            {{ $data->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                @endauth

                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">RKA</label>
                                    <div class="col-sm-10">
                                        <select name="e_rka" class="form-select" required>
                                            <option value="">Pilih</option>
                                            <option value="sudah" {{ $monev->rka == 'sudah' ? 'selected' : '' }}>
                                                Sudah</option>
                                            <option value="belum" {{ $monev->rka == 'belum' ? 'selected' : '' }}>
                                                Belum</option>
                                        </select>
                                    </div>
                                </div>


                                {{-- Realisasi --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Realisasi</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="e_realisasi" class="form-control"
                                            value="{{ $monev->realisasi }}">
                                    </div>
                                </div>

                                {{-- Keterangan --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Keterangan</label>
                                    <div class="col-sm-10">
                                        <textarea name="e_keterangan" class="form-control" rows="4">{{ $monev->keterangan }}</textarea>
                                    </div>
                                </div>

                                <!-- Tombol -->
                                <div class="row mb-3">
                                    <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                        <button type="submit" class="btn btn-success">Update</button>
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
