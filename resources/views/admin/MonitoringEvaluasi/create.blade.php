{{-- Lokasi: resources/views/admin/Monev/create.blade.php --}}

@extends('components.layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tambah Monitoring Evaluasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Monitoring Evaluasi</li>
                    <li class="breadcrumb-item active">Tambah Monitoring Evaluasi</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">

                            {{-- Tampilkan error validasi --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('monev.store') }}" method="POST">
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Program</label>
                                        <select name="id_subprogram" id="subprogram" class="form-select" required>
                                            <option value="">-- Pilih Subprogram --</option>
                                            @foreach ($subprogram as $data)
                                                <option value="{{ $data->id }}" {{ old('id_subprogram') == $data->id ? 'selected' : '' }}>{{ $data->subprogram }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Rencana Aksi</label>
                                        {{-- Nama field ini 'rencana_aksi' agar sesuai dengan kolom di database --}}
                                        <select name="rencana_aksi" id="rencanaAksi" class="form-select" required>
                                            <option value="">-- Pilih Sub Program Dahulu --</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Kegiatan</label>
                                        <input type="text" id="sub_kegiatan" name="sub_kegiatan" class="form-control bg-light"
                                            value="{{ old('sub_kegiatan') }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kegiatan</label>
                                        <input type="text" id="kegiatan" name="kegiatan" class="form-control bg-light"
                                            value="{{ old('kegiatan') }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Program</label>
                                        <input type="text" id="nama_program" name="nama_program" class="form-control bg-light"
                                            value="{{ old('nama_program') }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tahun</label>
                                        <input type="text" id="tahun" name="tahun" class="form-control bg-light"
                                            value="{{ old('tahun') }}" readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Volume</label>
                                        <input type="text" name="volume" value="{{ old('volume') }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Satuan</label>
                                        <input type="text" name="satuan" value="{{ old('satuan') }}" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Anggaran</label>
                                        <input type="text" name="anggaran" id="anggaran" value="{{ old('anggaran') }}"
                                            class="form-control" required>
                                    </div>
                                    <script>
                                        document.getElementById('anggaran').addEventListener('input', function(e) {
                                            let value = this.value.replace(/\D/g, '');
                                            if (value) {
                                                value = parseInt(value).toLocaleString('id-ID');
                                                this.value = 'Rp. ' + value;
                                            } else {
                                                this.value = '';
                                            }
                                        });
                                    </script>
                                    <div class="col-md-6">
                                        <label class="form-label">Sumber Dana</label>
                                        <input type="text" name="sumberdana" value="{{ old('sumberdana') }}"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Lokasi</label>
                                        <input type="text" id="lokasi" name="lokasi" class="form-control bg-light" value="{{ old('lokasi') }}" readonly>
                                    </div>

                                    @php
                                        $user = Auth::guard('pengguna')->user();
                                    @endphp
                                    <div class="col-md-6">
                                        <label class="form-label">Perangkat Daerah</label>
                                        @if ($user && $user->level == 'Admin')
                                            <input type="hidden" name="id_opd" value="{{ $user->id_opd }}">
                                            <input type="text" class="form-control" value="{{ $user->opd->nama ?? '-' }}"
                                                readonly>
                                        @else
                                            <select name="id_opd" class="form-select" required>
                                                <option value="">-- Pilih OPD --</option>
                                                @foreach ($opd as $data)
                                                    <option value="{{ $data->id }}" {{ old('id_opd') == $data->id ? 'selected' : '' }}>{{ $data->nama }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">RKA</label>
                                        <select name="rka" class="form-select" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="sudah" {{ old('rka') == 'sudah' ? 'selected' : '' }}>Sudah</option>
                                            <option value="belum" {{ old('rka') == 'belum' ? 'selected' : '' }}>Belum</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Realisasi</label>
                                        <input type="text" name="realisasi" value="{{ old('realisasi') }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Tanggal Monev</label>
                                        <input type="date" name="tanggal" value="{{ old('tanggal') }}" class="form-control" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" rows="3" required>{{ old('keterangan') }}</textarea>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('monev') }}" class="btn btn-warning">Batal</a>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- jQuery untuk AJAX --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Ambil daftar rencana kerja
            $('#subprogram').on('change', function() {
                var id_subprogram = $(this).val();
                if (id_subprogram) {
                    $.ajax({
                        url: "{{ url('/get-rencana-kerja') }}/" + id_subprogram,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#rencanaAksi').empty().append(
                                '<option value="">-- Pilih Rencana Aksi --</option>');
                            $.each(data, function(key, value) {
                                $('#rencanaAksi').append(
                                    '<option value="' + value.id + '">' + value
                                    .rencana_aksi + '</option>'
                                );
                            });
                        }
                    });
                } else {
                     $('#rencanaAksi').empty().append(
                        '<option value="">-- Pilih Sub Program Dahulu --</option>');
                }
            });

            // Ambil detail saat pilih rencana aksi
            $('#rencanaAksi').on('change', function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: "{{ url('/get-detail-rencana-kerja') }}/" + id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#sub_kegiatan').val(data.sub_kegiatan);
                            $('#kegiatan').val(data.kegiatan);
                            $('#nama_program').val(data.nama_program);
                            $('#tahun').val(data.tahun);
                            $('#lokasi').val(data.lokasi ?? '-');
                        }
                    });
                } else {
                    // Kosongkan field jika "-- Pilih Rencana Aksi --" dipilih
                    $('#sub_kegiatan').val('');
                    $('#kegiatan').val('');
                    $('#nama_program').val('');
                    $('#tahun').val('');
                    $('#lokasi').val('');
                }
            });
        });
    </script>
@endsection
