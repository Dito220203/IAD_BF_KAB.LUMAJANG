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



                            <form action="{{ route('monev.store') }}" method="POST">
                                @csrf

                                {{-- Hidden subprogram id --}}
                                <input type="hidden" name="id_subprogram" id="id_subprogram">

                                {{-- Rencana Kegiatan --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Rencana Kegiatan</label>
                                    <div class="col-sm-10">
                                        <select name="id_renja" class="form-select" id="id_renja" required>
                                            <option value="">Pilih</option>
                                            @foreach ($rencana as $data)
                                                <option value="{{ $data->id }}">{{ $data->judul }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Semua field selain Rencana Kegiatan dibungkus div --}}
                                <div id="form-lanjutan" style="display: none;">
                                    {{-- Nama Program --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Nama Program</label>
                                        <div class="col-sm-10">
                                            <input type="text" id="nama_program" class="form-control" readonly>
                                        </div>
                                    </div>

                                    {{-- Lokasi --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Lokasi</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="lokasi" id="lokasi" class="form-control">
                                        </div>
                                    </div>

                                    {{-- Tahun --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Tahun</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="tahun" id="tahun" class="form-control"
                                                readonly>
                                        </div>
                                    </div>

                                    {{-- Anggaran --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Anggaran</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="anggaran" id="anggaran" class="form-control"
                                                readonly>
                                        </div>
                                    </div>

                                    {{-- Perangkat Daerah --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Perangkat Daerah</label>
                                        <div class="col-sm-10">
                                            <select name="id_opd" id="id_opd" class="form-select">
                                                <option value="">Pilih</option>
                                                @foreach ($opd as $data)
                                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                @push('scripts')
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const idRenja = document.getElementById('id_renja');
                                            const formLanjutan = document.getElementById('form-lanjutan');
                                            const allInputs = document.querySelectorAll('#nama_program, #lokasi, #tahun, #anggaran, #id_opd');

                                            // Hide semua form selain Rencana Kerja awalnya
                                            formLanjutan.style.display = 'none';

                                            // Disable semua input dulu
                                            allInputs.forEach(input => input.disabled = true);

                                            idRenja.addEventListener('change', function() {
                                                if (this.value) {
                                                    formLanjutan.style.display = 'block';
                                                    allInputs.forEach(input => input.disabled = false);
                                                } else {

                                                    formLanjutan.style.display = 'none';
                                                    allInputs.forEach(input => input.disabled = true);
                                                }
                                            });
                                        });
                                    </script>
                                @endpush



                                {{-- RKA --}}
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
                                        <input type="text" name="realisasi" class="form-control" required>
                                    </div>
                                </div>

                                {{-- Keterangan --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Keterangan</label>
                                    <div class="col-sm-10">
                                        <textarea name="keterangan" class="form-control" rows="4" placeholder="Tulis keterangan tambahan..." required></textarea>
                                    </div>
                                </div>

                                <!-- Tombol -->
                                <div class="row mb-3">
                                    <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                        <button type="submit" class="btn btn-success">Simpan</button>
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
            const subprogramInput = document.getElementById('id_subprogram'); // hidden
            const namaProgramInput = document.getElementById('nama_program'); // readonly text

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

                        // ID untuk database
                        subprogramInput.value = data.subprogram_id || '';

                        // Nama hanya untuk ditampilkan
                        namaProgramInput.value = data.nama_program || '';
                    })
                    .catch(err => console.error(err));

            });
        });
    </script>
@endsection
