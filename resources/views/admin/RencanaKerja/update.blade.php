{{-- Lokasi: resources/views/admin/RencanaKerja/update.blade.php --}}

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

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Program IAD Perhutanan Sosial</label>
                                        <select name="id_subprogram" id="subprogram" class="form-select" required>
                                            <option value="">Pilih</option>
                                            @foreach ($subprogram as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ old('id_subprogram', $rencana->id_subprogram) == $data->id ? 'selected' : '' }}>
                                                    {{ $data->subprogram }}</option>
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
                                        <input type="hidden" name="rencanaAksi" id="rencanaAksi_hidden"
                                            value="{{ old('rencanaAksi', $rencana->rencana_aksi) }}">
                                        <input type="hidden" name="id_rencana_aksi" id="id_rencana_aksi">
                                    </div>
                                </div>

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
                                                    {{ $year }}</option>
                                            @endfor
                                        </select>
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
                                        <input type="text" name="anggaran" id="anggaran"
                                            value="{{ old('anggaran', $rencana->anggaran) }}" class="form-control"
                                            required>
                                    </div>
                                    <script>
                                        // Fungsi format Anggaran
                                        function formatAnggaran(inputElement) {
                                            let value = inputElement.value.replace(/\D/g, '');
                                            if (value) {
                                                value = parseInt(value).toLocaleString('id-ID');
                                                inputElement.value = 'Rp. ' + value;
                                            } else {
                                                inputElement.value = '';
                                            }
                                        }

                                        const anggaranInput = document.getElementById('anggaran');
                                        // Panggil fungsi saat input berubah
                                        anggaranInput.addEventListener('input', function(e) {
                                            formatAnggaran(this);
                                        });
                                        // Panggil fungsi saat halaman pertama kali dimuat
                                        document.addEventListener("DOMContentLoaded", function() {
                                            formatAnggaran(anggaranInput);
                                        });
                                    </script>

                                    <div class="col-md-6">
                                        <label class="form-label">Sumber Dana</label>
                                        @php
                                            $sumberDanaOptions = ['APBN', 'DAK', 'APBD Kab', 'APBD Prov', 'BK Prov', 'DBHCHT'];
                                            $currentSumberDana = old('sumberdana', $rencana->sumberdana);
                                            $isLainnya = !in_array($currentSumberDana, $sumberDanaOptions);
                                        @endphp
                                        <select id="sumberdana_select" class="form-control" required>
                                            <option value="">-- Pilih Sumber Dana --</option>
                                            @foreach ($sumberDanaOptions as $option)
                                                <option value="{{ $option }}"
                                                    {{ $currentSumberDana == $option ? 'selected' : '' }}>
                                                    {{ $option }}</option>
                                            @endforeach
                                            <option value="Lainnya" {{ $isLainnya ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                        <input type="text" id="sumberdana_lainnya"
                                            value="{{ $isLainnya ? $currentSumberDana : '' }}"
                                            class="form-control mt-2" placeholder="Masukkan sumber dana lainnya"
                                            style="display: {{ $isLainnya ? 'block' : 'none' }};">
                                        <input type="hidden" name="sumberdana" id="sumberdana_hidden"
                                            value="{{ $currentSumberDana }}">
                                    </div>

                                    <script>
                                        // Script untuk Sumber Dana "Lainnya"
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
                                            // Panggil saat load untuk memastikan state awal benar
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
                                        <input type="text" name="lokasi" class="form-control"
                                            value="{{ old('lokasi', $rencana->lokasi) }}">
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
                                                        {{ old('id_opd', $rencana->id_opd) == $data->id ? 'selected' : '' }}>
                                                        {{ $data->nama }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Definisikan elemen-elemen
            const $subprogramSelect = $('#subprogram');
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
                $('#id_rencana_aksi').val('');

                fieldsToToggle.forEach(function(field) {
                    // Hanya kosongkan jika belum ada nilainya (penting untuk edit)
                    if (!$('#' + field + '_display').val()) {
                        $('#' + field + '_display').val('');
                    }
                    $('#' + field + '_display').prop('readonly', false).removeClass('bg-light');
                    $('#' + field + '_hidden').val($('#' + field + '_display').val());
                });
            }

            // Fungsi untuk mereset field Rencana Aksi
            function resetRencanaAksiFields() {
                setFieldsToAuto();
                fieldsToToggle.forEach(function(field) {
                    $('#' + field + '_display').val('');
                    $('#' + field + '_hidden').val('');
                });
                $('#id_rencana_aksi').val('');
            }

            // Fungsi untuk mengambil dan mengisi Rencana Aksi
            function fetchRencanaAksi(id_subprogram, selectedRencanaAksi) {
                if (!id_subprogram) return;

                $.ajax({
                    url: "{{ url('/get-rencana-aksi') }}/" + id_subprogram,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $rencanaAksiSelect.empty().append('<option value="">-- Pilih Rencana Aksi --</option>');
                        let optionFound = false;

                        $.each(data, function(key, value) {
                            let isSelected = value.rencana_aksi === selectedRencanaAksi;
                            if (isSelected) optionFound = true;

                            $rencanaAksiSelect.append('<option value="' + value.rencana_aksi +
                                '" data-id="' + value.id + '"' + (isSelected ? ' selected' : '') +
                                '>' + value.rencana_aksi + '</option>');
                        });

                        $rencanaAksiSelect.append('<option value="lainnya">Lainnya...</option>');

                        // Jika Rencana Aksi yang tersimpan tidak ada di list, pilih "Lainnya"
                        if (!optionFound && selectedRencanaAksi) {
                            $rencanaAksiSelect.val('lainnya');
                            $rencanaAksiManual.val(selectedRencanaAksi);
                        }

                        // Trigger change untuk mengisi field turunan (sub_kegiatan, dll)
                        $rencanaAksiSelect.trigger('change');
                    }
                });
            }


            // 1. Ambil Rencana Aksi saat Sub Program berubah
            $subprogramSelect.on('change', function() {
                var id_subprogram = $(this).val();
                $rencanaAksiSelect.empty().append('<option value="">Pilih</option>');
                resetRencanaAksiFields();
                fetchRencanaAksi(id_subprogram, null); // saat ganti manual, tidak ada yang dipilih
            });

            // 2. Logika saat dropdown Rencana Aksi berubah
            $rencanaAksiSelect.on('change', function() {
                var selectedValue = $(this).val();

                if (selectedValue === 'lainnya') {
                    setFieldsToManual();
                } else if (selectedValue) {
                    setFieldsToAuto();
                    var selectedId = $("#rencanaAksi_select option:selected").data("id");
                    $('#id_rencana_aksi').val(selectedId);

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
                    resetRencanaAksiFields();
                }
            });

            // 3. Sinkronkan input manual ke hidden field
            fieldsToToggle.forEach(function(field) {
                $('#' + field + '_display').on('input', function() {
                    if (!$(this).prop('readonly')) {
                        $('#' + field + '_hidden').val($(this).val());
                    }
                });
            });

            // 4. Sebelum form disubmit, tentukan nilai akhir
            $form.on('submit', function() {
                if ($rencanaAksiSelect.val() === 'lainnya') {
                    $rencanaAksiHidden.val($rencanaAksiManual.val());
                } else {
                    $rencanaAksiHidden.val($rencanaAksiSelect.val());
                }
            });

            // --- EKSEKUSI SAAT HALAMAN DIMUAT (UNTUK EDIT) ---
            const initialSubProgramId = $subprogramSelect.val();
            const initialRencanaAksi = "{{ old('rencanaAksi', $rencana->rencana_aksi) }}";
            if (initialSubProgramId) {
                fetchRencanaAksi(initialSubProgramId, initialRencanaAksi);
            }
        });
    </script>
@endsection
