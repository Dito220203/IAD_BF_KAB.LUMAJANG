@extends('components.layout')

@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Edit / Lengkapi Monitoring Evaluasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Monitoring Evaluasi</li>
                    <li class="breadcrumb-item active">Edit / Lengkapi Monitoring Evaluasi</li>
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

                                {{-- Bagian form atas --}}
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Program</label>
                                        {{-- Input tersembunyi untuk mengirim ID --}}
                                        <input type="hidden" name="id_subprogram" value="{{ $monev->id_subprogram }}">
                                        {{-- Input teks untuk menampilkan nama, tidak bisa diubah --}}
                                        <input type="text" class="form-control bg-light"
                                            value="{{ $monev->subprogram->subprogram ?? 'Data tidak ditemukan' }}" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Rencana Aksi</label>
                                        {{-- Input tersembunyi untuk mengirim ID --}}
                                        <input type="hidden" name="rencanaAksi" value="{{ $monev->rencana_aksi }}">
                                        {{-- Input teks untuk menampilkan nama, tidak bisa diubah --}}
                                        <input type="text" class="form-control bg-light"
                                            value="{{ $monev->rencanakerja->rencana_aksi ?? 'Data tidak ditemukan' }}"
                                            readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Sub Kegiatan</label>
                                        <input type="text" id="sub_kegiatan" name="sub_kegiatan"
                                            value="{{ old('sub_kegiatan', $monev->sub_kegiatan) }}"
                                            class="form-control bg-light" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Kegiatan</label>
                                        <input type="text" id="kegiatan" name="kegiatan"
                                            value="{{ old('kegiatan', $monev->kegiatan) }}" class="form-control bg-light"
                                            readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Nama Program</label>
                                        <input type="text" id="nama_program" name="nama_program"
                                            value="{{ old('nama_program', $monev->nama_program) }}"
                                            class="form-control bg-light" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tahun</label>
                                        <input type="text" id="tahun" name="tahun"
                                            value="{{ old('tahun', $monev->tahun) }}" class="form-control bg-light"
                                            readonly>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Volume</label>
                                        <input type="text" name="volume" value="{{ old('volume', $monev->volume) }}"
                                            class="form-control bg-light" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Satuan</label>
                                        <input type="text" name="satuan" value="{{ old('satuan', $monev->satuan) }}"
                                            class="form-control bg-light" readonly>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-md-6">
                                        <label class="form-label">Lokasi</label>
                                        <input type="text" name="lokasi" value="{{ old('lokasi', $monev->lokasi) }}"
                                            class="form-control bg-light" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Perangkat Daerah</label>
                                        @php $user = Auth::guard('pengguna')->user(); @endphp
                                        @if ($user && $user->level == 'Admin')
                                            <input type="hidden" name="id_opd" value="{{ $user->id_opd }}">
                                            <input type="text" class="form-control bg-light"
                                                value="{{ $user->opd->nama ?? '-' }}" readonly>
                                        @else
                                            <select name="id_opd" class="form-select" required>
                                                <option value="">-- Pilih OPD --</option>
                                                @foreach ($opd as $data)
                                                    <option value="{{ $data->id }}"
                                                        {{ old('id_opd', $monev->id_opd) == $data->id ? 'selected' : '' }}>
                                                        {{ $data->nama }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @endif
                                    </div>
                                </div>

                                {{-- Fieldset untuk Detail Pendanaan --}}
                                <fieldset class="border p-3 rounded-3 mb-3">
                                    <legend class="float-none w-auto px-2 h6">Detail Pendanaan</legend>

                                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                        data-bs-target="#anggaranModal">
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
                                                {{-- MEMUAT DATA LAMA DARI DATABASE --}}
                                                @if (is_array($monev->anggaran) && is_array($monev->sumberdana))
                                                    @foreach ($monev->anggaran as $index => $anggaranValue)
                                                        @php
                                                            $uniqueId = 'row-initial-' . $index;
                                                            $sumberDanaValue = $monev->sumberdana[$index] ?? '';
                                                        @endphp
                                                        <tr id="{{ $uniqueId }}">
                                                            <td class="text-center">
                                                                {{ $anggaranValue}}</td>
                                                            <td class="text-center">{{ $sumberDanaValue }}</td>
                                                            <td class="text-center">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm hapus-anggaran-row"
                                                                    data-target="{{ $uniqueId }}">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <div id="hidden-inputs-container" style="display: none;">
                                        {{-- MEMUAT DATA LAMA SEBAGAI HIDDEN INPUT --}}
                                        @if (is_array($monev->anggaran) && is_array($monev->sumberdana))
                                            @foreach ($monev->anggaran as $index => $anggaranValue)
                                                @php
                                                    $uniqueId = 'row-initial-' . $index;
                                                    $sumberDanaValue = $monev->sumberdana[$index] ?? '';
                                                @endphp
                                                <div id="hidden-{{ $uniqueId }}">
                                                    <input type="hidden" name="anggaran[]"
                                                        value="{{ $anggaranValue }}">
                                                    <input type="hidden" name="sumberdana[]"
                                                        value="{{ $sumberDanaValue }}">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>


                                </fieldset>
                                @push('scripts')
                                    {{-- Memanggil file JavaScript eksternal --}}
                                    <script src="{{ asset('js/anggaranDansumberDana.js') }}"></script>
                                @endpush


                                <fieldset class="border rounded-3 p-3 mb-3">
                                    <legend class="float-none w-auto px-3 h6">Data Per Triwulan</legend>

                                    @php
                                        $dokumenAnggaran = $monev->dokumen_anggaran ?? [];
                                        $realisasiData = $monev->realisasi ?? [];
                                        $volumeTargetData = $monev->volumeTarget ?? [];

                                        // Hitung triwulan yang datanya ada (bukan null atau string kosong)
                                        $existingData = array_filter(
                                            $dokumenAnggaran,
                                            fn($value) => !is_null($value) && $value !== '',
                                        );
                                        $existingTriwulanCount = count($existingData);

                                        // Selalu tampilkan minimal satu baris, bahkan jika tidak ada data sama sekali
                                        if ($existingTriwulanCount == 0) {
                                            $existingTriwulanCount = 1;
                                        }
                                    @endphp

                                    <div class="row mb-3">
                                        {{-- Kolom Dokumen Anggaran --}}
                                        <div class="col-md-4" id="dokumen-anggaran-container">
                                            <label class="form-label">Dokumen Anggaran</label>
                                            @for ($i = 1; $i <= 4; $i++)
                                                @php
                                                    $twValue = $dokumenAnggaran[$i] ?? null;
                                                    $twLabel = $i <= 2 ? 'RKA' : 'PRKA';
                                                    $twRoman = ['I', 'II', 'III', 'IV'][$i - 1];
                                                @endphp
                                                <div id="tw{{ $i }}-block" class="mt-2"
                                                    style="{{ $i > $existingTriwulanCount ? 'display: none;' : '' }}">
                                                    <div class="border p-2 rounded">
                                                        <div class="row align-items-center g-2">
                                                            <div class="col-auto">
                                                                <div class="d-flex">
                                                                    <div class="form-check me-3">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="tw[{{ $i }}]"
                                                                            id="tw{{ $i }}_ada"
                                                                            value="TW {{ $twRoman }} | {{ $twLabel }} | ADA"
                                                                            data-tw="{{ $i }}"
                                                                            {{ ($twValue ?? '') == "TW $twRoman | $twLabel | ADA" ? 'checked' : '' }}>
                                                                        <label class="form-check-label"
                                                                            for="tw{{ $i }}_ada">ADA</label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="tw[{{ $i }}]"
                                                                            id="tw{{ $i }}_tidak"
                                                                            value="TW {{ $twRoman }} | {{ $twLabel }} | TIDAK"
                                                                            data-tw="{{ $i }}"
                                                                            {{ ($twValue ?? '') == "TW $twRoman | $twLabel | TIDAK" ? 'checked' : '' }}>
                                                                        <label class="form-check-label"
                                                                            for="tw{{ $i }}_tidak">TIDAK</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div
                                                                    class="d-flex justify-content-start justify-content-md-end">
                                                                    <div class="ps-2 border-start"><span
                                                                            class="fw-bold text-muted">{{ $twLabel }}</span>
                                                                    </div>
                                                                    <div class="ps-2 border-start ms-3"><span
                                                                            class="fw-bold text-muted">TW
                                                                            {{ $twRoman }}</span></div>
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
                                                <div id="realisasi-tw{{ $i }}-block" class="mt-2"
                                                    style="{{ $i > $existingTriwulanCount ? 'display: none;' : '' }}">
                                                    <input type="text" name="realisasi[{{ $i }}]"
                                                        value="{{ old('realisasi.' . $i, $realisasiData[$i] ?? '') }}"
                                                        placeholder="Realisasi TW {{ ['I', 'II', 'III', 'IV'][$i - 1] }}"
                                                        class="form-control p-2">
                                                </div>
                                            @endfor
                                        </div>

                                        {{-- Kolom Volume Target --}}
                                        <div class="col-md-4" id="volume-target-container">
                                            <label class="form-label">Volume Target</label>
                                            @for ($i = 1; $i <= 4; $i++)
                                                <div id="volume-target-tw{{ $i }}-block" class="mt-2"
                                                    style="{{ $i > $existingTriwulanCount ? 'display: none;' : '' }}">
                                                    <input type="text" name="volumeTarget[{{ $i }}]"
                                                        value="{{ old('volumeTarget.' . $i, $volumeTargetData[$i] ?? '') }}"
                                                        placeholder="Volume Target TW {{ ['I', 'II', 'III', 'IV'][$i - 1] }}"
                                                        class="form-control p-2">
                                                </div>
                                            @endfor
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                                <button type="button" id="tombol-hapus-tw" class="btn btn-danger"> <i
                                                        class="bi bi-trash"></i> Hapus Baris Terakhir </button>
                                                <button type="button" id="tombol-tambah-tw" class="btn btn-primary"> <i
                                                        class="bi bi-plus-circle"></i> Tambah Baris Triwulan </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 mt-3">
                                        <label class="form-label">Keterangan</label>
                                        <textarea name="uraian" class="form-control" rows="3" required>{{ old('uraian', $monev->uraian) }}</textarea>
                                    </div>
                                </fieldset>

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
    {{-- modal anggaran dan sumberdana --}}
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
                            <input type="text" id="modal-sumberdana-lainnya" class="form-control"
                                placeholder="Masukkan sumber dana lainnya">
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

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script>
        $(document).ready(function() {
            // **PERBAIKAN ERROR JAVASCRIPT**
            // Mengubah selector dari #anggaran menjadi #modal-anggaran
            // monev/edit.blade.php

            $('#modal-anggaran').on('input', function(e) {
                let value = this.value.replace(/\D/g, '');
                if (value) {
                    // TAMBAHKAN 'Rp. ' + DI SINI
                    this.value = 'Rp. ' + parseInt(value).toLocaleString('id-ID');
                } else {
                    this.value = '';
                }
            });

            // --- MANAJEMEN BARIS TRIWULAN ---
            const maxTriwulan = 4;
            let triwulanCounter = {{ $existingTriwulanCount }}; // Mengambil nilai dari PHP

            function updateButtonVisibility() {
                $('#tombol-hapus-tw').toggle(triwulanCounter > 1);
                $('#tombol-tambah-tw').toggle(triwulanCounter < maxTriwulan);
            }

            // Atur visibilitas tombol saat halaman pertama kali dimuat
            updateButtonVisibility();

            $('#tombol-tambah-tw').on('click', function() {
                if (triwulanCounter < maxTriwulan) {
                    triwulanCounter++;
                    $('#tw' + triwulanCounter + '-block').slideDown();
                    $('#realisasi-tw' + triwulanCounter + '-block').slideDown();
                    $('#volume-target-tw' + triwulanCounter + '-block').slideDown();
                    updateButtonVisibility();
                }
            });

            $('#tombol-hapus-tw').on('click', function() {
                if (triwulanCounter > 1) {
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
@endsection
