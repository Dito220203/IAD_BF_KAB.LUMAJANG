@extends('components.layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Edit Rencana Aksi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Rencana Aksi</li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body p-4">

                            <!-- Pesan error -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Form -->
                            <form action="{{ route('rencanaAksi.update', $rencanaAksi->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <!-- Sub Program & Nama Program -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Program</label>
                                        <select name="sub_program" class="form-select" required>
                                            <option value="">-- Pilih Sub Program --</option>
                                            @foreach ($subprogram as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ $data->id == $rencanaAksi->id_subprogram ? 'selected' : '' }}>
                                                    {{ $data->subprogram }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Rencana Aksi / Aktivitas</label>
                                        <input type="text" name="rencanaAksi" class="form-control"
                                            value="{{ old('rencanaAksi', $rencanaAksi->rencana_aksi) }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Kegiatan</label>
                                        <input type="text" name="sub_kegiatan" class="form-control"
                                            value="{{ old('sub_kegiatan', $rencanaAksi->sub_kegiatan) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kegiatan</label>
                                        <input type="text" name="kegiatan" class="form-control"
                                            value="{{ old('kegiatan', $rencanaAksi->kegiatan) }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Program</label>
                                        <input type="text" name="nama_program" class="form-control"
                                            value="{{ old('nama_program', $rencanaAksi->nama_program) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Lokasi</label>
                                        <input type="text" name="lokasi" class="form-control"
                                            value="{{ old('lokasi', $rencanaAksi->lokasi) }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Volume</label>
                                        <input type="text" name="volume" class="form-control"
                                            value="{{ old('volume', $rencanaAksi->volume) }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Satuan</label>
                                        <input type="text" name="satuan" class="form-control"
                                            value="{{ old('satuan', $rencanaAksi->satuan) }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Anggaran</label>
                                        <input type="text" name="anggaran" id="anggaran" class="form-control"
                                            value="{{ old('anggaran', $rencanaAksi->anggaran) }}" required>
                                    </div>

                                    <script>
                                        const anggaranInput = document.getElementById('anggaran');

                                        // Format value awal saat page load
                                        if (anggaranInput.value) {
                                            let numeric = anggaranInput.value.replace(/\D/g, '');
                                            if (numeric) {
                                                numeric = parseInt(numeric).toLocaleString('id-ID');
                                                anggaranInput.value = 'Rp. ' + numeric;
                                            }
                                        }

                                        // Format saat user mengetik
                                        anggaranInput.addEventListener('input', function() {
                                            let value = this.value.replace(/\D/g, ''); // hapus non-digit
                                            if (value) {
                                                value = parseInt(value).toLocaleString('id-ID'); // ribuan
                                                this.value = 'Rp. ' + value;
                                            } else {
                                                this.value = '';
                                            }
                                        });

                                       
                                    </script>
                                    <div class="col-md-6">
                                        <label class="form-label">Sumber Dana</label>
                                        <input type="text" name="sumberdana" class="form-control"
                                            value="{{ old('sumberdana', $rencanaAksi->sumberdana) }}" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Tahun</label>
                                        <input type="text" name="tahun" class="form-control" placeholder="YYYY"
                                            value="{{ old('tahun', $rencanaAksi->tahun) }}" required>
                                    </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Perangkat Daerah</label>
                                            <select name="id_opd" class="form-select" required>
                                                <option value="">-- Pilih OPD --</option>
                                                @foreach ($opds as $item)
                                                    <option value="{{ $item->id }}"
                                                        {{ $item->id == $rencanaAksi->id_opd ? 'selected' : '' }}>
                                                        {{ $item->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                </div>

                                <!-- Keterangan -->
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" rows="3" required>{{ old('keterangan', $rencanaAksi->keterangan) }}</textarea>
                                </div>

                                <!-- Tombol -->
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('rencana6tahun') }}" class="btn btn-warning">Batal</a>
                                    <button type="submit" class="btn btn-success">Update</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
