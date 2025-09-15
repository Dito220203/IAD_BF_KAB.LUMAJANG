@extends('components.layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tambah Rencana Kerja</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Rencana Kerja</li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('rencana.store') }}" method="POST">
                                @csrf

                                <!-- Subprogram & Rencana Aksi -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Program IAD Perhutanan Sosial</label>
                                        <select name="id_subprogram" id="subprogram" class="form-select" required>
                                            <option value="">Pilih</option>
                                            @foreach ($subprogram as $data)
                                                <option value="{{ $data->id }}">{{ $data->subprogram }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Rencana Aksi</label>
                                        <select name="rencanaAksi" id="rencanaAksi" class="form-select" required>
                                            <option value="">Pilih</option>
                                        </select>
                                        <!-- kalau masih butuh id -->
                                        <input type="hidden" name="id_rencana_aksi" id="id_rencana_aksi">
                                    </div>
                                </div>

                                <!-- Kegiatan & Sub Kegiatan -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Kegiatan</label>
                                        <input type="text" id="sub_kegiatan_display" class="form-control bg-light" readonly>
                                        <input type="hidden" name="sub_kegiatan" id="sub_kegiatan_hidden">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kegiatan</label>
                                        <input type="text" id="kegiatan_display" class="form-control bg-light" readonly>
                                        <input type="hidden" name="kegiatan" id="kegiatan_hidden">
                                    </div>
                                </div>

                                <!-- Nama Program & Tahun -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Program</label>
                                        <input type="text" id="nama_program_display" class="form-control bg-light" readonly>
                                        <input type="hidden" name="nama_program" id="nama_program_hidden">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tahun</label>
                                        <input type="text" id="tahun_display" class="form-control bg-light" readonly>
                                        <input type="hidden" name="tahun" id="tahun_hidden">
                                    </div>
                                </div>

                                <!-- Volume & Satuan -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Volume</label>
                                        <input type="text" name="volume" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Satuan</label>
                                        <input type="text" name="satuan" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Anggaran & Sumber Dana -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Anggaran</label>
                                        <input type="text" name="anggaran" value="{{ old('anggaran') }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Sumber Dana</label>
                                        <input type="text" name="sumberdana" value="{{ old('sumberdana') }}" class="form-control" required>
                                    </div>
                                </div>

                                <!-- Lokasi & Perangkat Daerah -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Lokasi</label>
                                        <input type="text" name="lokasi" class="form-control">
                                    </div>

                                    @php
                                        $user = Auth::guard('pengguna')->user();
                                    @endphp
                                    <div class="col-md-6">
                                        <label class="form-label">Perangkat Daerah</label>
                                        @if ($user && $user->level == 'Admin')
                                            <input type="hidden" name="id_opd" value="{{ $user->id_opd }}">
                                            <input type="text" class="form-control" value="{{ $user->opd->nama ?? '-' }}" readonly>
                                        @else
                                            <select name="id_opd" class="form-select" required>
                                                <option value="">Pilih</option>
                                                @foreach ($opd as $data)
                                                    <option value="{{ $data->id }}">{{ $data->nama }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" rows="3" required>{{ old('keterangan') }}</textarea>
                                </div>

                                <!-- Tombol -->
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('rencanakerja') }}" class="btn btn-warning">Batal</a>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Step 1: Ambil daftar Rencana Aksi berdasarkan Subprogram
        $('#subprogram').on('change', function() {
            var id_subprogram = $(this).val();
            if (id_subprogram) {
                $.ajax({
                    url: "{{ url('/get-rencana-aksi') }}/" + id_subprogram,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#rencanaAksi').empty().append('<option value="">-- Pilih Rencana Aksi --</option>');
                        $.each(data, function(key, value) {
                            // simpan string rencana_aksi, bukan id
                            $('#rencanaAksi').append('<option value="' + value.rencana_aksi + '" data-id="' + value.id + '">' + value.rencana_aksi + '</option>');
                        });
                    }
                });
            }
        });

        // Step 2: Ambil detail Rencana Aksi untuk mengisi otomatis field lain
        $('#rencanaAksi').on('change', function() {
            var selectedText = $("#rencanaAksi option:selected").text();
            var selectedId   = $("#rencanaAksi option:selected").data("id");

            // isi hidden
            $('#id_rencana_aksi').val(selectedId);

            if (selectedId) {
                $.ajax({
                    url: "{{ url('/get-detail-rencana-aksi') }}/" + selectedId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#sub_kegiatan_display').val(data.sub_kegiatan);
                        $('#sub_kegiatan_hidden').val(data.sub_kegiatan);

                        $('#kegiatan_display').val(data.kegiatan);
                        $('#kegiatan_hidden').val(data.kegiatan);

                        $('#nama_program_display').val(data.nama_program);
                        $('#nama_program_hidden').val(data.nama_program);

                        $('#tahun_display').val(data.tahun);
                        $('#tahun_hidden').val(data.tahun);
                    }
                });
            }
        });
    </script>
@endsection
