@extends('components.layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tambah Rencana Aksi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Rencana Aksi</li>
                    <li class="breadcrumb-item active">Tambah</li>
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
                            <form action="{{ route('rencanaAksi.store') }}" method="POST">
                                @csrf

                                <!-- Sub Program & Nama Program -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Program</label>
                                        <select name="sub_program" class="form-select" required>
                                            <option value="">-- Pilih Sub Program --</option>
                                            @foreach ($subprogram as $data)
                                                <option value="{{ $data->id }}">{{ $data->subprogram }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Rencana Aksi / Aktivitas</label>
                                        <input type="text" name="rencanaAksi" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Kegiatan</label>
                                        <input type="text" name="sub_kegiatan" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kegiatan</label>
                                        <input type="text" name="kegiatan" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Program</label>
                                        <input type="text" name="nama_program" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Lokasi</label>
                                        <input type="text" name="lokasi" class="form-control" required>
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
                                        <input type="text" name="anggaran" id="anggaran" value="{{ old('anggaran') }}"
                                            class="form-control" required>
                                    </div>
                                    <script>
                                        document.getElementById('anggaran').addEventListener('input', function(e) {
                                            let value = this.value.replace(/\D/g, ''); // hapus semua non-digit
                                            if (value) {
                                                value = parseInt(value).toLocaleString('id-ID'); // format ribuan
                                                this.value = 'Rp. ' + value; // tetap tampil Rp. xx.xxx.xxx
                                            } else {
                                                this.value = '';
                                            }
                                        });
                                    </script>

                                    <div class="col-md-6">
                                        <label class="form-label">Sumber Dana</label>

                                        <!-- Dropdown (tanpa name) -->
                                        <select id="sumberdana_select" class="form-control" required>
                                            <option value="">-- Pilih Sumber Dana --</option>
                                            <option value="APBN" {{ old('sumberdana') == 'APBN' ? 'selected' : '' }}>APBN
                                            </option>
                                            <option value="DAK" {{ old('sumberdana') == 'DAK' ? 'selected' : '' }}>DAK
                                            </option>
                                            <option value="APBD Kab"
                                                {{ old('sumberdana') == 'APBD Kab' ? 'selected' : '' }}>APBD Kab</option>
                                            <option value="APBD Prov"
                                                {{ old('sumberdana') == 'APBD Prov' ? 'selected' : '' }}>APBD Prov</option>
                                            <option value="BK Prov" {{ old('sumberdana') == 'BK Prov' ? 'selected' : '' }}>
                                                BK Prov</option>
                                            <option value="DBHCHT" {{ old('sumberdana') == 'DBHCHT' ? 'selected' : '' }}>
                                                DBHCHT</option>
                                            <option value="Lainnya"
                                                {{ !in_array(old('sumberdana'), ['APBN', 'DAK', 'APBD Kab', 'APBD Prov', 'BK Prov', 'DBHCHT']) && old('sumberdana') ? 'selected' : '' }}>
                                                Lainnya</option>
                                        </select>

                                        <!-- Input manual -->
                                        <input type="text" id="sumberdana_lainnya"
                                            value="{{ !in_array(old('sumberdana'), ['APBN', 'DAK', 'APBD Kab', 'APBD Prov', 'BK Prov', 'DBHCHT']) ? old('sumberdana') : '' }}"
                                            class="form-control mt-2" placeholder="Masukkan sumber dana lainnya"
                                            style="display: none;">

                                        <!-- Hidden input (final yang dikirim ke DB) -->
                                        <input type="hidden" name="sumberdana" id="sumberdana_hidden"
                                            value="{{ old('sumberdana') }}">
                                    </div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            const dropdown = document.getElementById("sumberdana_select");
                                            const inputLainnya = document.getElementById("sumberdana_lainnya");
                                            const hidden = document.getElementById("sumberdana_hidden");
                                            const form = dropdown.closest("form");

                                            function toggleInput() {
                                                if (dropdown.value === "Lainnya") {
                                                    inputLainnya.style.display = "block";
                                                    inputLainnya.required = true;
                                                } else {
                                                    inputLainnya.style.display = "none";
                                                    inputLainnya.required = false;
                                                    inputLainnya.value = "";
                                                }
                                            }

                                            dropdown.addEventListener("change", toggleInput);

                                            // cek pas reload halaman
                                            toggleInput();

                                            // sebelum submit: tentukan value final
                                            form.addEventListener("submit", function() {
                                                if (dropdown.value === "Lainnya" && inputLainnya.value.trim() !== "") {
                                                    hidden.value = inputLainnya.value.trim();
                                                } else {
                                                    hidden.value = dropdown.value;
                                                }
                                            });
                                        });
                                    </script>



                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Tahun</label>
                                        <input type="text" name="tahun" class="form-control" placeholder="YYYY"
                                            required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Perangkat Daerah</label>
                                        <select name="id_opd" class="form-select" required>
                                            <option value="">-- Pilih OPD --</option>
                                            @foreach ($opds as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <!-- Keterangan -->
                                    <div class="mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <textarea name="keterangan" class="form-control" rows="3" required>{{ old('keterangan') }}</textarea>
                                    </div>


                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                        <a href="{{ route('rencana6tahun') }}" class="btn btn-warning">Batal</a>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
