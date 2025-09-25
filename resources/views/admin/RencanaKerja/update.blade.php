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

                            <!-- Subprogram & Rencana Aksi -->
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

                                        {{-- Tampilkan dulu opsi yang tersimpan (pakai relasi jika ada) --}}
                                        @if ($rencana->rencana_aksi)
                                            <option value="{{ $rencana->rencana_aksi }}" selected>
                                                {{ $rencana->rencanaAksi->rencana_aksi ?? 'ID: '.$rencana->rencana_aksi }}
                                            </option>
                                        @endif

                                    </select>
                                </div>
                            </div>

                            <!-- Kegiatan & Sub Kegiatan -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Sub Kegiatan</label>
                                    <input type="text" id="sub_kegiatan_display" class="form-control bg-light"
                                        value="{{ old('sub_kegiatan', $rencana->sub_kegiatan) }}" readonly>
                                    <input type="hidden" name="sub_kegiatan" id="sub_kegiatan_hidden"
                                        value="{{ old('sub_kegiatan', $rencana->sub_kegiatan) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kegiatan</label>
                                    <input type="text" id="kegiatan_display" class="form-control bg-light"
                                        value="{{ old('kegiatan', $rencana->kegiatan) }}" readonly>
                                    <input type="hidden" name="kegiatan" id="kegiatan_hidden"
                                        value="{{ old('kegiatan', $rencana->kegiatan) }}">
                                </div>
                            </div>

                            <!-- Nama Program & Tahun -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Program</label>
                                    <input type="text" id="nama_program_display" class="form-control bg-light"
                                        value="{{ old('nama_program', $rencana->nama_program) }}" readonly>
                                    <input type="hidden" name="nama_program" id="nama_program_hidden"
                                        value="{{ old('nama_program', $rencana->nama_program) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tahun</label>
                                    <select name="tahun" id="tahun" class="form-select" required>
                                        <option value="">-- Pilih Tahun --</option>
                                        @for ($year = 2000; $year <= date('Y') + 5; $year++)
                                            <option value="{{ $year }}"
                                                {{ old('tahun', $rencana->tahun) == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <!-- Volume & Satuan -->
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

                            <!-- Anggaran & Sumber Dana -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Anggaran</label>
                                    <input type="text" name="anggaran" id="anggaran" class="form-control"
                                        value="{{ old('anggaran', $rencana->anggaran) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Sumber Dana</label>
                                    <input type="text" name="sumberdana" class="form-control"
                                        value="{{ old('sumberdana', $rencana->sumberdana) }}" required>
                                </div>
                            </div>

                            <!-- Lokasi & OPD -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Lokasi</label>
                                    <input type="text" name="lokasi" class="form-control"
                                        value="{{ old('lokasi', $rencana->lokasi) }}">
                                </div>

                                @php $user = Auth::guard('pengguna')->user(); @endphp
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

                            <div class="d-flex justify-content-end gap-2 mt-4">
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

{{-- jquery --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // simpan id rencana aksi yang tersimpan supaya bisa dipilih saat AJAX load
    const selectedRencanaId = "{{ $rencana->rencana_aksi ?? '' }}";

    $(document).ready(function() {
    var currentSub = $('#subprogram').val();
    if (currentSub) {
        // Panggil AJAX untuk load daftar rencana aksi sesuai subprogram
        $.ajax({
            url: "{{ url('/get-rencana-aksi') }}/" + currentSub,
            type: "GET",
            dataType: "json",
            success: function(data) {
                $('#rencanaAksi').empty().append('<option value="">-- Pilih Rencana Aksi --</option>');
                $.each(data, function(key, value) {
                    var sel = (value.id == selectedRencanaId) ? ' selected' : '';
                    $('#rencanaAksi').append(
                        '<option value="' + value.id + '"' + sel + '>' + value.rencana_aksi + '</option>'
                    );
                });

                // ✅ Auto panggil detail langsung tanpa klik ulang
                if (selectedRencanaId) {
                    $.ajax({
                        url: "{{ url('/get-detail-rencana-aksi') }}/" + selectedRencanaId,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $('#sub_kegiatan_display').val(data.sub_kegiatan);
                            $('#sub_kegiatan_hidden').val(data.sub_kegiatan);

                            $('#kegiatan_display').val(data.kegiatan);
                            $('#kegiatan_hidden').val(data.kegiatan);

                            $('#nama_program_display').val(data.nama_program);
                            $('#nama_program_hidden').val(data.nama_program);
                        }
                    });
                }
            }
        });
    }
});


    // Jika ingin, Anda bisa otomatis load daftar rencana aksi sesuai subprogram tersimpan:
    $(document).ready(function() {
        var currentSub = $('#subprogram').val();
        if (currentSub) {
            $('#subprogram').trigger('change');
        }

        // Format anggaran (sederhana)
        const anggaranInput = document.getElementById('anggaran');
        if (anggaranInput) {
            if (anggaranInput.value) {
                let numeric = anggaranInput.value.toString().replace(/\D/g, '');
                if (numeric) {
                    numeric = parseInt(numeric).toLocaleString('id-ID');
                    anggaranInput.value = 'Rp. ' + numeric;
                }
            }
            anggaranInput.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, '');
                if (value) {
                    value = parseInt(value).toLocaleString('id-ID');
                    this.value = 'Rp. ' + value;
                } else {
                    this.value = '';
                }
            });
        }
    });
</script>
@endsection
