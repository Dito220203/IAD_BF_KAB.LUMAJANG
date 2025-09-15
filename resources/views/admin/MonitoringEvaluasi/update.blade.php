@extends('components.layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Edit Monitoring Evaluasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Monitoring Evaluasi</li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="card p-4">
                <form action="{{ route('monev.update', $monev->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Subprogram & Rencana Aksi -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Sub Program</label>
                            <select name="id_subprogram" id="subprogram" class="form-select" required>
                                <option value="">-- Pilih Subprogram --</option>
                                @foreach ($subprogram as $data)
                                    <option value="{{ $data->id }}"
                                        {{ $monev->id_subprogram == $data->id ? 'selected' : '' }}>
                                        {{ $data->subprogram }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_subprogram')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Rencana Aksi</label>
                            <select name="rencanaAksi" id="rencanaAksi" class="form-select" required>
                                <option value="{{ $monev->rencana_aksi }}" selected>
                                    {{ $monev->rencanaKerja->rencana_aksi ?? '-' }}
                                </option>
                            </select>
                            @error('rencanaAksi')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Sub Kegiatan & Kegiatan -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Sub Kegiatan</label>
                            <input type="text" id="sub_kegiatan" name="sub_kegiatan" class="form-control"
                                value="{{ old('sub_kegiatan', $monev->sub_kegiatan) }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Kegiatan</label>
                            <input type="text" id="kegiatan" name="kegiatan" class="form-control"
                                value="{{ old('kegiatan', $monev->kegiatan) }}" readonly>
                        </div>
                    </div>

                    <!-- Nama Program & Tahun -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Program</label>
                            <input type="text" id="nama_program" name="nama_program" class="form-control"
                                value="{{ old('nama_program', $monev->nama_program) }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tahun</label>
                            <input type="text" id="tahun" name="tahun" class="form-control"
                                value="{{ old('tahun', $monev->tahun) }}" readonly>
                        </div>
                    </div>

                    <!-- Lokasi, Volume, Satuan -->
                    <div class="row mb-3">

                        <div class="col-md-6">
                            <label class="form-label">Volume</label>
                            <input type="number" name="volume" class="form-control"
                                value="{{ old('volume', $monev->volume) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Satuan</label>
                            <input type="text" name="satuan" class="form-control"
                                value="{{ old('satuan', $monev->satuan) }}">
                        </div>
                    </div>

                    <!-- Anggaran, Sumber Dana, OPD -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Anggaran</label>
                            <input type="number" name="anggaran" class="form-control"
                                value="{{ old('anggaran', $monev->anggaran) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Sumber Dana</label>
                            <input type="text" name="sumberdana" class="form-control"
                                value="{{ old('sumberdana', $monev->sumberdana) }}">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Lokasi</label>
                            <input type="text" id="lokasi" name="lokasi" class="form-control"
                                value="{{ old('lokasi', $monev->lokasi) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">OPD</label>
                            <select name="id_opd" class="form-select" required>
                                <option value="">-- Pilih OPD --</option>
                                @foreach ($opd as $o)
                                    <option value="{{ $o->id }}" {{ $monev->id_opd == $o->id ? 'selected' : '' }}>
                                        {{ $o->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                   
            </div>

            <!-- RKA, Realisasi, Tanggal -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">RKA</label>
                    <select name="rka" class="form-select">
                        <option value="">-- Pilih --</option>
                        <option value="sudah" {{ old('rka', $monev->rka) == 'sudah' ? 'selected' : '' }}>Sudah
                        </option>
                        <option value="Belum" {{ old('rka', $monev->rka) == 'Belum' ? 'selected' : '' }}>Belum
                        </option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Realisasi</label>
                    <input type="text" name="realisasi" class="form-control"
                        value="{{ old('realisasi', $monev->realisasi) }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" class="form-control"
                        value="{{ old('tanggal', $monev->tanggal) }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="3" required>{{ old('keterangan', $monev->keterangan) }}</textarea>
            </div>

            <div class="d-flex justify-content-end">
                <a href="{{ route('monev') }}" class="btn btn-secondary me-2">Batal</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
            </form>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script>
        // Ambil daftar rencana kerja berdasarkan subprogram
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
                                '<option value="' + value.id + '">' + value.rencana_aksi +
                                '</option>'
                            );
                        });
                    }
                });
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
                        // $('#lokasi').val(data.lokasi ?? '-');
                    }
                });
            }
        });
    </script>
@endpush
