@extends('components.layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tambah Monitoring Evaluasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Monitoring Evaluasi</li>
                    <li class="breadcrumb-item active">Tambah Monitoring Evaluasi</li>
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

                            <form action="{{ route('monev.store') }}" method="POST">
                                @csrf

                                {{-- Bagian form atas --}}
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Program</label>
                                        <select name="id_subprogram" id="subprogram" class="form-select" required>
                                            <option value="">-- Pilih Subprogram --</option>
                                            @foreach ($subprogram as $data)
                                                <option value="{{ $data->id }}" {{ old('id_subprogram') == $data->id ? 'selected' : '' }}>
                                                    {{ $data->subprogram }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Rencana Aksi</label>
                                        <select name="rencanaAksi" id="rencanaAksi" class="form-select" required>
                                            <option value="">-- Pilih Sub Program Dahulu --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Kegiatan</label>
                                        <input type="text" id="sub_kegiatan" name="sub_kegiatan" class="form-control bg-light" value="{{ old('sub_kegiatan') }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kegiatan</label>
                                        <input type="text" id="kegiatan" name="kegiatan" class="form-control bg-light" value="{{ old('kegiatan') }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Program</label>
                                        <input type="text" id="nama_program" name="nama_program" class="form-control bg-light" value="{{ old('nama_program') }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tahun</label>
                                        <input type="text" id="tahun" name="tahun" class="form-control bg-light" value="{{ old('tahun') }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Volume Target</label>
                                        <input type="text" name="volume" value="{{ old('volume') }}" class="form-control " required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Satuan</label>
                                        <input type="text" name="satuan" value="{{ old('satuan') }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Lokasi</label>
                                        <input type="text" name="lokasi" class="form-control " value="{{ old('lokasi') }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Perangkat Daerah</label>
                                        @php $user = Auth::guard('pengguna')->user(); @endphp
                                        @if ($user && $user->level == 'Admin')
                                            <input type="hidden" name="id_opd" value="{{ $user->id_opd }}">
                                            <input type="text" class="form-control bg-light" value="{{ $user->opd->nama ?? '-' }}" required>
                                        @else
                                            <select name="id_opd" class="form-select" required>
                                                <option value="">-- Pilih OPD --</option>
                                                @foreach ($opd as $data)
                                                    <option value="{{ $data->id }}" {{ old('id_opd') == $data->id ? 'selected' : '' }}>
                                                        {{ $data->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>

                                <fieldset class="border p-3 rounded-3 mb-3">
                                    <legend class="float-none w-auto px-2 h6">Detail Pendanaan</legend>
                                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#anggaranModal">
                                        <i class="bi bi-plus-circle"></i> Tambah Anggaran & Sumber Dana
                                    </button>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" scope="col">Anggaran</th>
                                                    <th class="text-center" scope="col">Sumber Dana</th>
                                                    <th class="text-center" scope="col" style="width: 10%;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="anggaran-table-body">
                                                {{-- Data akan muncul di sini via JavaScript --}}
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="hidden-inputs-container" style="display: none;"></div>
                                </fieldset>

                                <fieldset class="border rounded-3 p-3 mb-3">
                                    <legend class="float-none w-auto px-3 h6">Data Per Triwulan</legend>
                                    <div class="row mb-3">
                                        @php
                                            $twLabels = ['RKA', 'RKA', 'PRKA', 'PRKA'];
                                            $twRomans = ['I', 'II', 'III', 'IV'];
                                        @endphp

                                        {{-- Kolom Dokumen Anggaran --}}
                                        <div class="col-md-4" id="dokumen-anggaran-container">
                                            <label class="form-label">Dokumen Anggaran</label>
                                            @for ($i = 1; $i <= 4; $i++)
                                                <div id="tw{{ $i }}-block" class="mt-2" style="{{ $i > 1 ? 'display: none;' : '' }}">
                                                    <div class="border p-2 rounded">
                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="d-flex">
                                                                    <div class="form-check me-3">
                                                                        <input class="form-check-input" type="radio" name="tw[{{ $i }}]" id="tw{{ $i }}_ada" value="TW {{ $twRomans[$i-1] }} | {{ $twLabels[$i-1] }} | ADA" data-tw="{{ $i }}" {{ $i == 1 ? 'required' : ''}}>
                                                                        <label class="form-check-label" for="tw{{ $i }}_ada">ADA</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="tw[{{ $i }}]" id="tw{{ $i }}_tidak" value="TW {{ $twRomans[$i-1] }} | {{ $twLabels[$i-1] }} | TIDAK" data-tw="{{ $i }}">
                                                                        <label class="form-check-label" for="tw{{ $i }}_tidak">TIDAK</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="d-flex justify-content-start justify-content-md-end">
                                                                    <div class="ps-2 border-start"><span class="fw-bold text-muted">{{ $twLabels[$i-1] }}</span></div>
                                                                    <div class="ps-2 border-start ms-3"><span class="fw-bold text-muted">TW {{ $twRomans[$i-1] }}</span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>

                                        {{-- Kolom Realisasi --}}
                                        <div class="col-md-4" id="realisasi-container">
                                            <label class="form-label">Realisasi</label>
                                            @for ($i = 1; $i <= 4; $i++)
                                                <div id="realisasi-tw{{ $i }}-block" class="mt-2" style="{{ $i > 1 ? 'display: none;' : '' }}">
                                                    <input type="text" name="realisasi[{{ $i }}]" placeholder="Realisasi TW {{ $twRomans[$i-1] }}" class="form-control p-2">
                                                </div>
                                            @endfor
                                        </div>

                                        {{-- Kolom Volume Target --}}
                                        <div class="col-md-4" id="volume-target-container">
                                            <label class="form-label">Volume Realisasi</label>
                                            @for ($i = 1; $i <= 4; $i++)
                                                <div id="volume-target-tw{{ $i }}-block" class="mt-2" style="{{ $i > 1 ? 'display: none;' : '' }}">
                                                    <input type="text" name="volumeTarget[{{ $i }}]" placeholder="Volume Target TW {{ $twRomans[$i-1] }}" class="form-control p-2">
                                                </div>
                                            @endfor
                                        </div>
                                    </div>

                                    {{-- Tombol di dalam fieldset --}}
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <button type="button" id="tombol-hapus-tw" class="btn btn-danger">
                                                    <i class="bi bi-trash"></i> Hapus Baris Terakhir
                                                </button>
                                                <button type="button" id="tombol-tambah-tw" class="btn btn-primary">
                                                    <i class="bi bi-plus-circle"></i> Tambah Baris Triwulan
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <textarea name="uraian" class="form-control" rows="3" required>{{ old('uraian') }}</textarea>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('monev') }}" class="btn btn-warning">Batal</a>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- Modal Anggaran (tidak berubah) --}}
    <div class="modal fade" id="anggaranModal" tabindex="-1" aria-labelledby="anggaranModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="anggaranModalLabel">Tambah Anggaran Dan Sumber Dana</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="modal-anggaran-form">
                        <div class="mb-3">
                            <label for="modal-anggaran" class="form-label">Anggaran</label>
                            <input type="text" id="modal-anggaran" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="modal-sumberdana" class="form-label">Sumber Dana</label>
                            <select id="modal-sumberdana" class="form-select" required>
                                <option value="">-- Pilih Sumber Dana --</option>
                                <option value="APBN">APBN</option>
                                <option value="DAK">DAK</option>
                                <option value="APBD Kab">APBD Kab</option>
                                <option value="APBD Prov">APBD Prov</option>
                                <option value="BK Prov">BK Prov</option>
                                <option value="DBHCHT">DBHCHT</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="mb-3" id="modal-sumberdana-lainnya-container" style="display: none;">
                            <label for="modal-sumberdana-lainnya" class="form-label">Sumber Dana Lainnya</label>
                            <input type="text" id="modal-sumberdana-lainnya" class="form-control" placeholder="Masukkan sumber dana lainnya">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="tambah-ke-tabel">Tambah ke Tabel</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // SCRIPT UNTUK MODAL DAN PENDANAAN (Vanilla JS)
    document.addEventListener("DOMContentLoaded", function() {
        const modalElement = document.getElementById('anggaranModal');
        if (!modalElement) return;

        const modal = new bootstrap.Modal(modalElement);
        const modalForm = document.getElementById('modal-anggaran-form');
        const anggaranInput = document.getElementById('modal-anggaran');
        const sumberDanaSelect = document.getElementById('modal-sumberdana');
        const lainnyaContainer = document.getElementById('modal-sumberdana-lainnya-container');
        const lainnyaInput = document.getElementById('modal-sumberdana-lainnya');
        const addButton = document.getElementById('tambah-ke-tabel');
        const tableBody = document.getElementById('anggaran-table-body');
        const hiddenContainer = document.getElementById('hidden-inputs-container');

        const formatRupiah = (input) => {
            let value = String(input.value).replace(/\D/g, '');
            return value ? 'Rp. ' + parseInt(value).toLocaleString('id-ID') : '';
        };

        anggaranInput.addEventListener('input', () => {
            anggaranInput.value = formatRupiah({ value: anggaranInput.value });
        });

        sumberDanaSelect.addEventListener('change', () => {
            if (sumberDanaSelect.value === 'Lainnya') {
                lainnyaContainer.style.display = 'block';
                lainnyaInput.required = true;
            } else {
                lainnyaContainer.style.display = 'none';
                lainnyaInput.required = false;
            }
        });

        addButton.addEventListener('click', () => {
            if (!modalForm.checkValidity()) {
                modalForm.reportValidity();
                return;
            }

            const anggaranValue = anggaranInput.value; // Ambil nilai terformat
            let sumberDanaValue = sumberDanaSelect.value;
            const sumberDanaText = sumberDanaValue === 'Lainnya' ? lainnyaInput.value : sumberDanaSelect.options[sumberDanaSelect.selectedIndex].text;

            if (sumberDanaValue === 'Lainnya') {
                sumberDanaValue = lainnyaInput.value;
            }

            if (!anggaranValue || !sumberDanaValue) {
                alert('Anggaran dan Sumber Dana harus diisi.');
                return;
            }

            const uniqueId = 'row-' + Date.now();
            const newRow = `
                <tr id="${uniqueId}">
                    <td class="text-center">${anggaranValue}</td>
                    <td class="text-center">${sumberDanaText}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm hapus-anggaran-row" data-target="${uniqueId}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
            tableBody.insertAdjacentHTML('beforeend', newRow);

            const newHiddenInputs = `
                <div id="hidden-${uniqueId}">
                    <input type="hidden" name="anggaran[]" value="${anggaranValue}">
                    <input type="hidden" name="sumberdana[]" value="${sumberDanaValue}">
                </div>
            `;
            hiddenContainer.insertAdjacentHTML('beforeend', newHiddenInputs);

            modalForm.reset();
            lainnyaContainer.style.display = 'none';
            lainnyaInput.required = false;
            modal.hide();
        });

        tableBody.addEventListener('click', (e) => {
            const deleteButton = e.target.closest('.hapus-anggaran-row');
            if (deleteButton) {
                const targetId = deleteButton.dataset.target;
                document.getElementById(targetId)?.remove();
                document.getElementById('hidden-' + targetId)?.remove();
            }
        });
    });

    // SCRIPT UNTUK DROPDOWN & TRIWULAN (jQuery)
    $(document).ready(function() {
        // AJAX untuk Rencana Aksi berdasarkan Subprogram
        $('#subprogram').on('change', function() {
            var id_subprogram = $(this).val();
            if (id_subprogram) {
                $.ajax({
                    url: "{{ url('/get-rencana-kerja') }}/" + id_subprogram,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#rencanaAksi').empty().append('<option value="">-- Pilih Rencana Aksi --</option>');
                        $.each(data, function(key, value) {
                            $('#rencanaAksi').append('<option value="' + value.id + '">' + value.rencana_aksi + '</option>');
                        });
                    },
                    error: function() {
                        // Handle error jika AJAX gagal
                        $('#rencanaAksi').empty().append('<option value="">Gagal memuat data</option>');
                    }
                });
            } else {
                $('#rencanaAksi').empty().append('<option value="">-- Pilih Sub Program Dahulu --</option>');
            }
        });

        // AJAX untuk mengisi detail form berdasarkan Rencana Aksi
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
                        $('#volume').val(data.volume);
                        $('#satuan').val(data.satuan);
                        $('#lokasi').val(data.lokasi);
                    }
                });
            } else {
                $('#sub_kegiatan, #kegiatan, #nama_program, #tahun, #volume, #satuan, #lokasi').val('');
            }
        });

        // LOGIKA BARU UNTUK TOMBOL TRIWULAN
        let triwulanCounter = 1;
        const maxTriwulan = 4;

        function updateButtonVisibility() {
            $('#tombol-hapus-tw').toggle(triwulanCounter > 1);
            $('#tombol-tambah-tw').toggle(triwulanCounter < maxTriwulan);
        }

        updateButtonVisibility(); // Panggil saat halaman dimuat

        $('#tombol-tambah-tw').on('click', function() {
            if (triwulanCounter < maxTriwulan) {
                triwulanCounter++;
                $('#tw' + triwulanCounter + '-block').slideDown();
                $('#realisasi-tw' + triwulanCounter + '-block').slideDown();
                $('#volume-target-tw' + triwulanCounter + '-block').slideDown();

                // Jadikan input di baris baru 'required'
                $(`input[name="tw[${triwulanCounter}]"]`).prop('required', true);

                updateButtonVisibility();
            }
        });

        $('#tombol-hapus-tw').on('click', function() {
            if (triwulanCounter > 1) {
                // Hapus 'required' dari input yang akan disembunyikan
                $(`input[name="tw[${triwulanCounter}]"]`).prop('required', false);

                // Kosongkan nilai sebelum disembunyikan
                $('#tw' + triwulanCounter + '-block').find('input:radio').prop('checked', false);
                $('#realisasi-tw' + triwulanCounter + '-block').find('input').val('');
                $('#volume-target-tw' + triwulanCounter + '-block').find('input').val('');

                // Sembunyikan blok
                $('#tw' + triwulanCounter + '-block').slideUp();
                $('#realisasi-tw' + triwulanCounter + '-block').slideUp();
                $('#volume-target-tw' + triwulanCounter + '-block').slideUp();

                triwulanCounter--;
                updateButtonVisibility();
            }
        });
    });
</script>
@endpush
