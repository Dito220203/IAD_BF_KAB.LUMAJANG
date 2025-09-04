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

                            <form action="{{ route('monev.update', $monev->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- Hidden subprogram id --}}
                                <input type="hidden" name="program" id="id_subprogram" value="{{ $monev->program }}">

                                {{-- Rencana Kegiatan --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Rencana Kegiatan</label>
                                    <div class="col-sm-10">
                                        <select name="id_renja" id="id_renja" class="form-select">
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
                                        <input type="text" id="nama_program" name="program" class="form-control"
                                            value="{{ old('program', $monev->program) }}" readonly>
                                    </div>
                                </div>

                                {{-- Lokasi --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Lokasi</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="lokasi" id="lokasi" class="form-control"
                                            value="{{ old('lokasi', $monev->lokasi) }}">
                                    </div>
                                </div>

                                {{-- Tahun --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Tahun</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tahun" id="tahun" class="form-control"
                                            value="{{ old('tahun', $monev->tahun) }}" readonly>
                                    </div>
                                </div>

                                {{-- Anggaran --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Anggaran</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="anggaran" id="anggaran" class="form-control"
                                            value="{{ old('anggaran', $monev->anggaran) }}" readonly>
                                    </div>
                                </div>

                                {{-- Perangkat Daerah --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Perangkat Daerah</label>
                                    <div class="col-sm-10">
                                        <select name="id_opd" id="id_opd" class="form-select">
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

                                {{-- RKA --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">RKA</label>
                                    <div class="col-sm-10">
                                        <select name="rka" class="form-select" required>
                                            <option value="">Pilih</option>
                                            <option value="sudah" {{ $monev->rka == 'sudah' ? 'selected' : '' }}>Sudah
                                            </option>
                                            <option value="belum" {{ $monev->rka == 'belum' ? 'selected' : '' }}>Belum
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Realisasi --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Realisasi</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="realisasi" class="form-control"
                                            value="{{ old('realisasi', $monev->realisasi) }}">
                                    </div>
                                </div>

                                {{-- Keterangan --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Keterangan</label>
                                    <div class="col-sm-10">
                                        <textarea name="keterangan" class="form-control" rows="4">{{ old('keterangan', $monev->keterangan) }}</textarea>
                                    </div>
                                </div>

                                {{-- Tombol --}}
                                <div class="row mb-3">
                                    <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <a href="{{ route('monev') }}" class="btn btn-warning">Kembali</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const rencanaSelect = document.getElementById('id_renja');
            const lokasiInput = document.getElementById('lokasi');
            const tahunInput = document.getElementById('tahun');
            const anggaranInput = document.getElementById('anggaran');
            const opdSelect = document.getElementById('id_opd');
            const subprogramInput = document.getElementById('id_subprogram');
            const namaProgramInput = document.getElementById('nama_program');

            rencanaSelect.addEventListener('change', function() {
                const id = this.value;
                if (!id) {
                    lokasiInput.value = '';
                    tahunInput.value = '';
                    anggaranInput.value = '';
                    opdSelect.value = '';
                    subprogramInput.value = '';
                    namaProgramInput.value = '';
                    return;
                }

                fetch(`/rencana/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        lokasiInput.value = data.lokasi || '';
                        tahunInput.value = data.tanggal || '';
                        anggaranInput.value = data.anggaran || '';
                        opdSelect.value = data.opd_id || '';
                        subprogramInput.value = data.subprogram_id || '';
                        namaProgramInput.value = data.nama_program || '';
                    })
                    .catch(err => console.error(err));
            });
        });
    </script>
@endsection
