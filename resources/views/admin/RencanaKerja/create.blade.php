@extends('components.layout')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Tambah Rencana Kerja</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</a></li>
                    <li class="breadcrumb-item">Rencana Kerja</li>
                    <li class="breadcrumb-item active">Tambah Rencana Kerja</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section">
            <div class="row">
                <div class="col-lg-12"> {{-- Ubah jadi full width jika butuh --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3 mt-3">

                                <form action="{{ route('rencana.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- Subprogram --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Sub Program</label>
                                        <div class="col-sm-10">
                                            <select name="subprogram" class="form-select" required>
                                                <option value="">Pilih</option>
                                                @foreach ($subprogram as $data)
                                                    <option value="{{ $data->id }}">{{ $data->subprogram }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Judul --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Judul Rencana Kerja</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="judul" class="form-control" required>
                                        </div>
                                    </div>

                                    {{-- Lokasi --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Lokasi</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="lokasi" class="form-control" required>
                                        </div>
                                    </div>

                                    {{-- Tahun --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Tahun</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="tahun" class="form-control" required>
                                        </div>
                                    </div>

                                    {{-- Anggaran --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Anggaran</label>
                                        <div class="col-sm-10">
                                            <input type="number" name="anggaran" class="form-control" required>
                                        </div>
                                    </div>

                                    {{-- Pilih OPD --}}
                                    <div class="row mb-3">
                                        <label for="id_opd" class="col-sm-2 col-form-label">Pilih OPD</label>
                                        <div class="col-sm-10">
                                            <select name="id_opd" id="id_opd" class="form-control" required>
                                                <option value="">-- Pilih OPD --</option>
                                                @foreach ($opd as $item)
                                                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                   <div class="row mb-3">
    <label class="col-sm-2 col-form-label">Keterangan</label>
    <div class="col-sm-10">
        <textarea name="keterangan" class="form-control"
            style="height: 100px; font-size: 16px; resize: vertical;" required></textarea>
    </div>
</div>


                                    {{-- Tombol --}}
                                    <div class="row mb-3">
                                        <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                            <a href="{{ route('rencanakerja') }}" class="btn btn-warning">Kembali</a>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endsection
