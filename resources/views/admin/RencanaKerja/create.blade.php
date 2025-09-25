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

                                        {{-- Dropdown ini tidak memiliki 'name' agar tidak terkirim --}}
                                        <select id="rencanaAksi_select" class="form-select" required>
                                            <option value="">Pilih Sub Program Dahulu</option>
                                        </select>

                                        {{-- Input manual untuk opsi "Lainnya", awalnya disembunyikan --}}
                                        <input type="text" id="rencanaAksi_manual" class="form-control mt-2"
                                            placeholder="Isi Rencana Aksi Lainnya" style="display:none;">

                                        {{-- Input hidden ini yang akan dikirim ke controller --}}
                                        <input type="hidden" name="rencanaAksi" id="rencanaAksi_hidden">
                                        <input type="hidden" name="id_rencana_aksi" id="id_rencana_aksi">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Kegiatan</label>
                                        <input type="text" id="sub_kegiatan_display" class="form-control bg-light"
                                            readonly>
                                        <input type="hidden" name="sub_kegiatan" id="sub_kegiatan_hidden">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kegiatan</label>
                                        <input type="text" id="kegiatan_display" class="form-control bg-light" readonly>
                                        <input type="hidden" name="kegiatan" id="kegiatan_hidden">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Program</label>
                                        <input type="text" id="nama_program_display" class="form-control bg-light"
                                            readonly>
                                        <input type="hidden" name="nama_program" id="nama_program_hidden">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tahun</label>
                                        <select name="tahun" id="tahun" class="form-select" required>
                                            <option value="">-- Pilih Tahun --</option>
                                            @for ($year = 2000; $year <= date('Y') + 5; $year++)
                                                <option value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
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
                                        <input type="text" id="sumberdana_lainnya"
                                            value="{{ !in_array(old('sumberdana'), ['APBN', 'DAK', 'APBD Kab', 'APBD Prov', 'BK Prov', 'DBHCHT']) ? old('sumberdana') : '' }}"
                                            class="form-control mt-2" placeholder="Masukkan sumber dana lainnya"
                                            style="display: none;">
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
                                            toggleInput();
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
                                            <input type="text" class="form-control"
                                                value="{{ $user->opd->nama ?? '-' }}" readonly>
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

                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="keterangan" class="form-control" rows="3" required>{{ old('keterangan') }}</textarea>
                                </div>

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
        $(document).ready(function() {
            // Definisikan elemen-elemen yang akan dimanipulasi
            const $rencanaAksiSelect = $('#rencanaAksi_select');
            const $rencanaAksiManual = $('#rencanaAksi_manual');
            const $rencanaAksiHidden = $('#rencanaAksi_hidden');
            const fieldsToToggle = ['sub_kegiatan', 'kegiatan', 'nama_program'];
            const $form = $('form');

            // Fungsi untuk mengembalikan field ke mode otomatis (readonly)
            function setFieldsToAuto() {
                $rencanaAksiManual.hide().val('').prop('required', false);
                fieldsToToggle.forEach(function(field) {
                    $('#' + field + '_display').prop('readonly', true).addClass('bg-light');
                });
            }

            // Fungsi untuk mengubah field ke mode manual (bisa diisi)
            function setFieldsToManual() {
                $rencanaAksiManual.show().prop('required', true);
                $('#id_rencana_aksi').val(''); // Kosongkan ID karena ini data baru

                fieldsToToggle.forEach(function(field) {
                    $('#' + field + '_display').val('').prop('readonly', false).removeClass('bg-light');
                    $('#' + field + '_hidden').val('');
                });
            }

            // Fungsi untuk mereset semua field terkait Rencana Aksi
            function resetRencanaAksiFields() {
                setFieldsToAuto();
                fieldsToToggle.forEach(function(field) {
                    $('#' + field + '_display').val('');
                    $('#' + field + '_hidden').val('');
                });
                 $('#id_rencana_aksi').val('');
            }

            // 1. Ambil Rencana Aksi saat Sub Program berubah
            $('#subprogram').on('change', function() {
                var id_subprogram = $(this).val();

                // Reset dropdown dan semua field terkait
                $rencanaAksiSelect.empty().append('<option value="">Pilih</option>');
                resetRencanaAksiFields();

                if (id_subprogram) {
                    $.ajax({
                        url: "{{ url('/get-rencana-aksi') }}/" + id_subprogram,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            $rencanaAksiSelect.empty().append('<option value="">-- Pilih Rencana Aksi --</option>');
                            $.each(data, function(key, value) {
                                // value diisi teks, data-id diisi ID (mengikuti pola kode lama)
                                $rencanaAksiSelect.append('<option value="' + value.rencana_aksi +
                                    '" data-id="' + value.id + '">' + value.rencana_aksi + '</option>');
                            });
                            // Tambahkan opsi "Lainnya" di akhir
                            $rencanaAksiSelect.append('<option value="lainnya">Lainnya...</option>');
                        }
                    });
                }
            });

            // 2. Logika saat dropdown Rencana Aksi berubah
            $rencanaAksiSelect.on('change', function() {
                var selectedValue = $(this).val();

                if (selectedValue === 'lainnya') {
                    // Jika memilih "Lainnya", aktifkan mode manual
                    setFieldsToManual();
                } else if (selectedValue) {
                    // Jika memilih Rencana Aksi yang ada, aktifkan mode otomatis
                    setFieldsToAuto();
                    var selectedId = $("#rencanaAksi_select option:selected").data("id");
                    $('#id_rencana_aksi').val(selectedId); // Simpan ID-nya

                    // Ambil detail dan isi field secara otomatis
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
                        }
                    });
                } else {
                    // Jika memilih "Pilih" (kosong), reset semua field
                    resetRencanaAksiFields();
                }
            });

            // 3. Sinkronkan input manual ke hidden field
            fieldsToToggle.forEach(function(field) {
                $('#' + field + '_display').on('input', function() {
                    // Hanya update hidden field jika input display tidak readonly
                    if (!$(this).prop('readonly')) {
                        $('#' + field + '_hidden').val($(this).val());
                    }
                });
            });

            // 4. Sebelum form disubmit, tentukan nilai akhir untuk 'rencanaAksi'
            $form.on('submit', function() {
                if ($rencanaAksiSelect.val() === 'lainnya') {
                    // Jika "Lainnya", ambil nilai dari input manual
                    $rencanaAksiHidden.val($rencanaAksiManual.val());
                } else {
                    // Jika bukan, ambil nilai dari dropdown yang dipilih
                    $rencanaAksiHidden.val($rencanaAksiSelect.val());
                }
            });
        });
    </script>
@endsection
