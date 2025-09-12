@extends('components.layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Edit Rencana Kerja</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Rencana Kerja</li>
                    <li class="breadcrumb-item active">Edit</li>
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

                            <form action="{{ route('rencana.update', $rencana->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Sub Program & Rencana Aksi -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Program</label>
                                        <select name="id_subprogram" id="subprogram" class="form-select" required>
                                            <option value="">Pilih</option>
                                            @foreach ($subprogram as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ old('id_subprogram', $rencana->id_subprogram) == $data->id ? 'selected' : '' }}>
                                                    {{ $data->subprogram }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Rencana Aksi/Aktivitas</label>
                                        <select name="rencanaAksi" id="rencanaAksi" class="form-select" required>
                                            <option value="">-- Pilih Rencana Aksi --</option>
                                            @if ($rencana->rencana_aksi)
                                                <option value="{{ $rencana->rencana_aksi }}" selected>
                                                    {{ $rencana->rencanaAksi->rencana_aksi }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <!-- Kegiatan & Sub Kegiatan -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Kegiatan</label>
                                        <select name="sub_kegiatan" id="sub_kegiatan" class="form-select" required>
                                            <option value="">-- Pilih Sub Kegiatan --</option>
                                            @if ($rencana->sub_kegiatan)
                                                <option value="{{ $rencana->sub_kegiatan }}" selected>
                                                    {{ $rencana->sub_kegiatan }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kegiatan</label>
                                        <select name="kegiatan" id="kegiatan" class="form-select" required>
                                            <option value="">-- Pilih Kegiatan --</option>
                                            @if ($rencana->kegiatan)
                                                <option value="{{ $rencana->kegiatan }}" selected>
                                                    {{ $rencana->kegiatan }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Program</label>
                                        <select name="nama_program" id="nama_program" class="form-select" required>
                                            <option value="">-- Pilih Nama Program --</option>
                                            @if ($rencana->nama_program)
                                                <option value="{{ $rencana->nama_program }}" selected>
                                                    {{ $rencana->nama_program }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Lokasi</label>
                                        <input type="text" name="lokasi" value="{{ old('lokasi', $rencana->lokasi) }}"
                                            class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Volume</label>
                                        <input type="text" name="volume" class="form-control"
                                            value="{{ old('volume', $rencana->volume) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Satuan</label>
                                        <input type="text" name="satuan" class="form-control"
                                            value="{{ old('satuan', $rencana->satuan) }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Anggaran</label>
                                        <input type="text" name="anggaran"
                                            value="{{ old('anggaran', $rencana->anggaran) }}" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Sumber Dana</label>
                                        <input type="text" name="sumberdana" class="form-control"
                                            value="{{ old('sumberdana', $rencana->sumberdana) }}" required>
                                    </div>
                                </div>

                                <!-- Tahun, Lokasi, OPD -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Tahun</label>
                                        <select name="tahun" id="tahun" class="form-select" required>
                                            <option value="">-- Pilih Tahun --</option>
                                            @if ($rencana->tahun)
                                                <option value="{{ $rencana->tahun }}" selected>
                                                    {{ $rencana->tahun }}
                                                </option>
                                            @endif
                                        </select>
                                    </div>

                                    @php
                                        $user = Auth::guard('pengguna')->user();
                                    @endphp
                                    <div class="col-md-6">
                                        <label class="form-label">Perangkat Daerah</label>
                                        @if ($user && $user->level === 'Admin')
                                            <input type="hidden" name="id_opd" value="{{ $user->id_opd }}">
                                            <input type="text" class="form-control"
                                                value="{{ $user->opd->nama ?? '-' }}" readonly>
                                        @else
                                            <select name="id_opd" class="form-select" required>
                                                <option value="">Pilih</option>
                                                @foreach ($opd as $data)
                                                    <option value="{{ $data->id }}"
                                                        {{ old('id_opd', $rencana->id_opd) == $data->id ? 'selected' : '' }}>
                                                        {{ $data->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>



                                <!-- Keterangan -->
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" rows="3" required>{{ old('keterangan', $rencana->keterangan) }}</textarea>
                                </div>

                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('rencanakerja') }}" class="btn btn-warning">Batal</a>
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
                    url: "{{ url('/get-rencana-aksi') }}/" + id_subprogram,
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
