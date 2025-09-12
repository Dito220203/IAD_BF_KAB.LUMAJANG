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
                                    </div>
                                </div>

                                <!-- Kegiatan & Sub Kegiatan -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Kegiatan</label>
                                        <select name="sub_kegiatan" id="sub_kegiatan" class="form-select" required>
                                            <option value="">-- Pilih Sub Kegiatan --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kegiatan</label>
                                        <select name="kegiatan" id="kegiatan" class="form-select" required>
                                            <option value="">-- Pilih Kegiatan --</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Nama Program & Lokasi -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Program</label>
                                        <select name="nama_program" id="nama_program" class="form-select" required>
                                            <option value="">-- Pilih Nama Program --</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Lokasi</label>
                                        <input type="text" name="lokasi" class="form-control">
                                    </div>

                                </div>
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
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Anggaran</label>
                                        <input type="text" name="anggaran" value="{{ old('anggaran') }}"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Sumber Dana</label>
                                        <input type="text" name="sumberdana" value="{{ old('sumberdana') }}"
                                            class="form-control" required>
                                    </div>
                                </div>

                                <!-- Tahun & Perangkat Daerah -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Tahun</label>
                                        <select name="tahun" id="tahun" class="form-select" required>
                                            <option value="">-- Pilih Tahun --</option>
                                        </select>
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
        $('#subprogram').on('change', function() {
            var id_subprogram = $(this).val();
            if (id_subprogram) {
                $.ajax({
                    url: "{{ url('/get-rencana-aksi') }}/" + id_subprogram,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#nama_program').empty().append(
                            '<option value="">-- Pilih Nama Program --</option>');
                        $('#rencanaAksi').empty().append(
                            '<option value="">-- Pilih Rencana Aksi --</option>');
                        $('#kegiatan').empty().append('<option value="">-- Pilih Kegiatan --</option>');
                        $('#sub_kegiatan').empty().append(
                            '<option value="">-- Pilih Sub Kegiatan --</option>');
                        $('#tahun').empty().append('<option value="">-- Pilih Tahun --</option>');

                        $.each(data, function(key, value) {
                            $('#nama_program').append('<option value="' + value.nama_program +
                                '">' + value.nama_program + '</option>');
                            $('#rencanaAksi').append('<option value="' + value.id + '">' + value
                                .rencana_aksi + '</option>');
                            $('#kegiatan').append('<option value="' + value.kegiatan + '">' +
                                value.kegiatan + '</option>');
                            $('#sub_kegiatan').append('<option value="' + value.sub_kegiatan +
                                '">' + value.sub_kegiatan + '</option>');
                            $('#tahun').append('<option value="' + value.tahun + '">' + value
                                .tahun + '</option>');
                        });
                    }
                });
            }
        });
    </script>
@endsection
