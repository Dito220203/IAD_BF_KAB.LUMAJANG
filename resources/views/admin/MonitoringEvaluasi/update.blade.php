@extends('components.layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Edit Monitoring Evaluasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Monitoring Evaluasi</li>
                    <li class="breadcrumb-item active">Edit Monitoring Evaluasi</li>
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

                            <form action="{{ route('monev.update', $monev->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Subprogram & Rencana Aksi -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Program</label>
                                        <select name="id_subprogram" id="subprogram" class="form-select" required>
                                            <option value="">Pilih</option>
                                            @foreach ($subprogram as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ $monev->id_subprogram == $data->id ? 'selected' : '' }}>
                                                    {{ $data->subprogram }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Rencana Aksi</label>
                                        <select name="rencanaAksi" id="rencanaAksi" class="form-select" required>
                                            <option value="{{ $monev->rencana_aksi }}" selected>{{ $monev->rencana_aksi }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Kegiatan & Sub Kegiatan -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Kegiatan</label>
                                        <select name="sub_kegiatan" id="sub_kegiatan" class="form-select" required>
                                            <option value="{{ $monev->sub_kegiatan }}" selected>{{ $monev->sub_kegiatan }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kegiatan</label>
                                        <select name="kegiatan" id="kegiatan" class="form-select" required>
                                            <option value="{{ $monev->kegiatan }}" selected>{{ $monev->kegiatan }}</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Nama Program & Lokasi -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Program</label>
                                        <select name="nama_program" id="nama_program" class="form-select" required>
                                            <option value="{{ $monev->nama_program }}" selected>{{ $monev->nama_program }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Lokasi</label>
                                        <input type="text" name="lokasi" class="form-control"
                                            value="{{ old('lokasi', $monev->lokasi) }}" required>
                                    </div>
                                </div>

                                <!-- Volume & Satuan -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Volume</label>
                                        <input type="text" name="volume" class="form-control"
                                            value="{{ old('volume', $monev->volume) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Satuan</label>
                                        <input type="text" name="satuan" class="form-control"
                                            value="{{ old('satuan', $monev->satuan) }}" required>
                                    </div>
                                </div>

                                <!-- Anggaran & Sumber Dana -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Anggaran</label>
                                        <input type="text" name="anggaran" class="form-control"
                                            value="{{ old('anggaran', $monev->anggaran) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Sumber Dana</label>
                                        <input type="text" name="sumberdana" class="form-control"
                                            value="{{ old('sumberdana', $monev->sumberdana) }}" required>
                                    </div>
                                </div>

                                <!-- Tahun & OPD -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Tahun</label>
                                        <select name="tahun" id="tahun" class="form-select" required>
                                            <option value="{{ $monev->tahun }}" selected>{{ $monev->tahun }}</option>
                                        </select>
                                    </div>
                                    @php
                                        $user = Auth::guard('pengguna')->user();
                                    @endphp
                                    <div class="col-md-6">
                                        <label class="form-label">Perangkat Daerah</label>
                                        @if ($user && $user->level == 'Admin')
                                            <input type="hidden" name="id_opd" value="{{ $user->id_opd }}">
                                            <input type="text" class="form-control"
                                                value="{{ $user->opd->nama ?? '-' }}" readonly>
                                        @else
                                            <select name="id_opd" class="form-select" required>
                                                <option value="">Pilih</option>
                                                @foreach ($opd as $data)
                                                    <option value="{{ $data->id }}"
                                                        {{ $monev->id_opd == $data->id ? 'selected' : '' }}>
                                                        {{ $data->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>

                                </div>

                                <!-- RKA, Realisasi, Tanggal -->
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">RKA</label>
                                        <select name="rka" class="form-select" required>
                                            <option value="sudah" {{ $monev->rka == 'sudah' ? 'selected' : '' }}>Sudah
                                            </option>
                                            <option value="belum" {{ $monev->rka == 'belum' ? 'selected' : '' }}>Belum
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Realisasi</label>
                                        <input type="text" name="realisasi" class="form-control"
                                            value="{{ old('realisasi', $monev->realisasi) }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Tanggal Monev</label>
                                        <input type="date" name="tanggal" class="form-control"
                                            value="{{ old('tanggal', $monev->tanggal) }}" required>
                                    </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" rows="3" required>{{ old('keterangan', $monev->keterangan) }}</textarea>
                                </div>

                                <!-- Tombol -->
                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('monev') }}" class="btn btn-warning">Batal</a>
                                    <button type="submit" class="btn btn-success">Update</button>
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
                    url: "{{ url('/get-rencana-kerja') }}/" + id_subprogram,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#rencanaAksi').empty().append(
                            '<option value="">-- Pilih Rencana Aksi --</option>');
                        $('#kegiatan').empty().append('<option value="">-- Pilih Kegiatan --</option>');
                        $('#sub_kegiatan').empty().append(
                            '<option value="">-- Pilih Sub Kegiatan --</option>');
                        $('#nama_program').empty().append(
                            '<option value="">-- Pilih Nama Program --</option>');
                        $('#tahun').empty().append('<option value="">-- Pilih Tahun --</option>');

                        $.each(data, function(key, value) {
                            $('#rencanaAksi').append('<option value="' + value.rencana_aksi +
                                '">' + value.rencana_aksi + '</option>');
                            $('#kegiatan').append('<option value="' + value.kegiatan + '">' +
                                value.kegiatan + '</option>');
                            $('#sub_kegiatan').append('<option value="' + value.sub_kegiatan +
                                '">' + value.sub_kegiatan + '</option>');
                            $('#nama_program').append('<option value="' + value.nama_program +
                                '">' + value.nama_program + '</option>');
                            $('#tahun').append('<option value="' + value.tahun + '">' + value
                                .tahun + '</option>');
                        });
                    }
                });
            }
        });
    </script>
@endsection
