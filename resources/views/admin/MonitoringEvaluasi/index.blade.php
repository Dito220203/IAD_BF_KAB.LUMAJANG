@extends('components.layout')
@section('content')
    <style>
        .multi-item {
            padding: 0 !important;
            margin: 0 !important;
            vertical-align: top;

        }

        .multi-item>div {
            padding: 8px 12px;
            white-space: normal;

        }

        .multi-item>div:not(:last-child) {
            /* GANTI WARNA DI SINI */
            border-bottom: 1px solid #cccccc;
        }
    </style>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Monitoring Evaluasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item active">Monitoring Evaluasi</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card ">
                        <div class="card-body">
                            <!-- Header control: Tambah, Search, Tampilkan Data -->
                            <div class="row g-3 align-items-center mb-3 mt-3">
                                <div class="col-12 col-md-auto">
                                    <a href="{{ route('monev.create') }}" class="btn btn-primary w-100">
                                        <i class="fas fa-plus me-2"></i>Tambah Data
                                    </a>
                                </div>

                                <div class="col-12 col-md-auto">
                                    <a href="{{ route('monev.export', ['tahun' => request('tahun'), 'search' => request('search')]) }}"
                                        class="btn btn-danger w-100">
                                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                                    </a>
                                </div>

                                <div class="col-12 col-md-auto ms-md-auto">
                                    <form id="filter-form" method="GET" class="d-flex flex-column flex-md-row gap-2">

                                        {{-- Filter Tahun --}}
                                        <div class="input-group  w-auto">
                                            <label class="input-group-text" for="tahun-filter">
                                                <i class="fas fa-calendar-alt"></i>
                                            </label>
                                            <select name="tahun" id="tahun-filter" class="form-select">
                                                <option value="">Semua Tahun</option>
                                                @foreach ($tahuns as $tahun)
                                                    <option value="{{ $tahun }}"
                                                        {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                                        {{ $tahun }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Search --}}
                                        <div class="input-group  w-auto">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari data..." value="{{ request('search') }}">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search"></i>
                                            </button>

                                            {{-- Tombol Reset Filter --}}
                                            @if (request('search') || request('tahun'))
                                                <a href="{{ route('monev') }}" class="btn btn-secondary"
                                                    title="Reset Filter">
                                                    <i class="fas fa-sync-alt"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </form>
                                </div>

                                @push('scripts')
                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                    <script>
                                        $(document).ready(function() {
                                            // Auto submit kalau tahun berubah
                                            $('#tahun-filter').on('change', function() {
                                                $('#filter-form').submit();
                                            });
                                        });
                                    </script>
                                @endpush

                            </div>
                            <div class="table-container">
                                <div class="top-scrollbar-container">
                                    <div class="top-scrollbar-content"></div>
                                </div>
                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="detail-table" id="TableMonev" style="min-width: 3000px;">
                                        @php
                                            $adaPesan = $monev->contains(function ($item) {
                                                return !empty($item->pesan);
                                            });
                                        @endphp
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th class="text-center">Sub Program</th>
                                                <th class="text-center" style="width: 300px;">Rencana Aksi / Aktivitas</th>
                                                <th class="text-center" style="width: 200px;">Sub Kegiatan</th>
                                                <th class="text-center" style="width: 200px;">Kegiatan</th>
                                                <th class="text-center" style="width: 200px;">Nama Program</th>
                                                <th class="text-center">Lokasi</th>
                                                <th class="text-center">Volume</th>
                                                <th class="text-center">Satuan</th>
                                                <th class="text-center">Tahun</th>
                                                <th class="text-center">Perangkat Daerah</th>
                                                <th class="text-center" style="width: 150px;">Anggaran</th>
                                                <th class="text-center" style="width: 200px;">Sumber Dana</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Dokumen Anggaran</th>
                                                <th class="text-center">Realisasi</th>
                                                <th class="text-center">Volume Target</th>
                                                <th class="text-center">Keterangan</th>
                                                @if ($adaPesan)
                                                    <th class="text-center">Catatan</th>
                                                @endif
                                                <th class="text-center" style="width: 190px;">Dokumentasi</th>
                                                <th class="text-center" style="width: 400px;">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($monev as $data)
                                                <tr id="row-{{ $data->id }}">
                                                    <td class="text-center">{{ $monev->firstItem() + $loop->index }}</td>
                                                    <td class="text-center">{{ $data->subprogram->subprogram ?? '-' }}</td>
                                                    <td>{{ $data->rencanakerja->rencana_aksi ?? '-' }}</td>
                                                    <td>{{ $data->sub_kegiatan }}</td>
                                                    <td>{{ $data->kegiatan }}</td>
                                                    <td>{{ $data->nama_program }}</td>
                                                    <td class="text-center">{{ $data->lokasi }}</td>
                                                    <td class="text-center">{{ $data->volume }}</td>
                                                    <td class="text-center">{{ $data->satuan }}</td>
                                                    <td class="text-center">{{ $data->tahun }}</td>
                                                    <td class="text-center" class="text-center">
                                                        {{ $data->opd->nama ?? '-' }}
                                                    </td>
                                                    @php
                                                        $anggarans = explode('; ', $data->anggaran);
                                                        $sumberdanas = explode('; ', $data->sumberdana);
                                                    @endphp

                                                    {{-- Cek untuk Kolom Anggaran --}}
                                                    @if (count($anggarans) > 1)
                                                        {{-- Jika data lebih dari satu, gunakan tampilan multi-baris --}}
                                                        <td class="multi-item text-center align-middle">
                                                            @foreach ($anggarans as $anggaran)
                                                                <div>{{ $anggaran ?: '-' }}</div>
                                                            @endforeach
                                                        </td>
                                                    @else
                                                        {{-- Jika data hanya satu, tampilkan seperti biasa --}}
                                                        <td class="text-center">{{ $data->anggaran ?: '-' }}</td>
                                                    @endif

                                                    {{-- Cek untuk Kolom Sumber Dana --}}
                                                    @if (count($sumberdanas) > 1)
                                                        {{-- Jika data lebih dari satu, gunakan tampilan multi-baris --}}
                                                        <td class="multi-item text-center align-middle">
                                                            @foreach ($sumberdanas as $sumber)
                                                                <div>{{ $sumber ?: '-' }}</div>
                                                            @endforeach
                                                        </td>
                                                    @else
                                                        {{-- Jika data hanya satu, tampilkan seperti biasa --}}
                                                        <td class="text-center">{{ $data->sumberdana ?: '-' }}</td>
                                                    @endif



                                                    <td class="text-center">
                                                        @if ($data->status === 'Valid')
                                                            <span class="badge bg-success">{{ $data->status }}</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ $data->status }}</span>
                                                        @endif
                                                    </td>

                                                    @php
                                                        // Definisikan array pemetaan angka ke Romawi di sini
                                                        // Indeks 0 sengaja dikosongkan agar $romanMap[1] menjadi 'I'
                                                        $romanMap = ['', 'I', 'II', 'III', 'IV'];
                                                    @endphp

                                                    {{-- Kolom Dokumen Anggaran (Tidak perlu diubah, sudah benar) --}}
                                                    <td class="text-center">
                                                        @forelse (($data->dokumen_anggaran ?? []) as $status)
                                                            @if ($status && str_contains($status, 'ADA'))
                                                                <span
                                                                    class="badge bg-success d-block mb-1">{{ $status }}</span>
                                                            @elseif ($status)
                                                                <span
                                                                    class="badge bg-danger d-block mb-1">{{ $status }}</span>
                                                            @endif
                                                        @empty
                                                            <span>-</span>
                                                        @endforelse
                                                    </td>

                                                    {{-- Kolom Realisasi (Diperbaiki dengan Flexbox) --}}
                                                    <td>
                                                        @if (is_array($data->realisasi))
                                                            @foreach ($data->realisasi as $triwulan => $nilai)
                                                                @if ($nilai)
                                                                    {{-- Bungkus setiap baris dengan div dan gunakan flex --}}
                                                                    <div style="display: flex; align-items: baseline;">
                                                                        {{-- Atur lebar tetap untuk label --}}
                                                                        <span style="width: 55px; display: inline-block;">
                                                                            TW {{ $romanMap[$triwulan] ?? $triwulan }}
                                                                        </span>
                                                                        <span>:</span>
                                                                        {{-- Beri sedikit jarak kiri --}}
                                                                        <strong
                                                                            style="margin-left: 5px;">{{ $nilai }}</strong>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            {{ $data->realisasi }}
                                                        @endif
                                                    </td>

                                                    {{-- Kolom Volume Target (Diperbaiki dengan Flexbox) --}}
                                                    <td>
                                                        @if (is_array($data->volumeTarget))
                                                            @foreach ($data->volumeTarget as $triwulan => $nilai)
                                                                @if ($nilai)
                                                                    <div style="display: flex; align-items: baseline;">
                                                                        <span style="width: 55px; display: inline-block;">
                                                                            TW {{ $romanMap[$triwulan] ?? $triwulan }}
                                                                        </span>
                                                                        <span>:</span>
                                                                        <strong
                                                                            style="margin-left: 5px;">{{ $nilai }}</strong>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            {{ $data->volumeTarget }}
                                                        @endif
                                                    </td>

                                                    <td>{{ $data->uraian }}</td>
                                                    @if ($adaPesan)
                                                        <td>{{ $data->pesan }}</td>
                                                    @endif

                                                    {{-- Tombol Lihat Dokumentasi --}}
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#ModalDetailProduk{{ $data->id }}">
                                                            Lihat Dokumentasi
                                                        </button>
                                                    </td>
                                                    <!-- Modal Detail Dokumentasi -->
                                                    <div class="modal fade" id="ModalDetailProduk{{ $data->id }}"
                                                        tabindex="-1" aria-labelledby="DetailLabel{{ $data->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header bg-info text-white">
                                                                    <h5 class="modal-title"
                                                                        id="DetailLabel{{ $data->id }}">
                                                                        Dokumentasi Foto Progres
                                                                    </h5>
                                                                    <button type="button"
                                                                        class="btn-close btn-close-white"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    @if ($data->fotoProgres->isNotEmpty())
                                                                        {{-- Tampilkan Keterangan Umum di Atas --}}
                                                                        <div class="mb-4">
                                                                            <strong>Keterangan:</strong>
                                                                            <p class="mt-1" style="font-size: 1.1em;">
                                                                                {{-- Ambil deskripsi dari foto pertama, karena semuanya sama --}}
                                                                                {{ $data->fotoProgres->first()->deskripsi ?: 'Tidak ada keterangan.' }}
                                                                            </p>
                                                                        </div>

                                                                        <hr>

                                                                        {{-- Galeri Foto-foto --}}
                                                                        <div class="row">
                                                                            @foreach ($data->fotoProgres as $foto)
                                                                                <div class="col-lg-4 col-md-6 mb-4">
                                                                                    <div class="card h-100 shadow-sm">
                                                                                        <a href="{{ asset('storage/' . $foto->foto) }}"
                                                                                            data-bs-toggle="tooltip"
                                                                                            title="Lihat ukuran penuh">
                                                                                            <img src="{{ asset('storage/' . $foto->foto) }}"
                                                                                                class="card-img-top"
                                                                                                alt="Foto Dokumentasi"
                                                                                                style="height: 200px; object-fit: cover; cursor: pointer;">
                                                                                        </a>
                                                                                        <div
                                                                                            class="card-footer text-center">
                                                                                            <small class="text-muted">
                                                                                                Diunggah:
                                                                                                {{ $foto->created_at->format('d/m/Y H:i') }}
                                                                                            </small>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    @else
                                                                        {{-- Pesan jika tidak ada foto --}}
                                                                        <div class="alert alert-warning text-center">
                                                                            <i class="bi bi-exclamation-triangle-fill"></i>
                                                                            Belum ada foto dokumentasi yang diunggah.
                                                                        </div>
                                                                    @endif

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-bs-dismiss="modal">Tutup</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>





                                                    <td class="text-center align-middle">
                                                        <div class="d-flex justify-content-center gap-1">
                                                            <button type="button" class="btn btn-info btn-sm btn-upload"
                                                                data-bs-toggle="modal" data-bs-target="#uploadFotoModal"
                                                                data-id="{{ $data->id }}">
                                                                <i class="fas fa-camera"></i> Upload
                                                            </button>
                                                            <form action="{{ route('monev.edit', $data->id) }}"
                                                                method="GET">
                                                                <button class="btn btn-primary btn-sm">
                                                                    Edit/Lengkapi
                                                                </button>
                                                            </form>

                                                            @if (auth()->guard('pengguna')->user()->level == 'Super Admin')
                                                                <button
                                                                    class="btn btn-sm {{ $data->status == 'Valid' ? 'btn-warning' : 'btn-success' }}"
                                                                    onclick="updateStatus('{{ $data->id }}', '{{ $data->status }}')">
                                                                    @if ($data->status == 'Valid')
                                                                        Batalkan
                                                                    @else
                                                                        Validasi
                                                                    @endif
                                                                </button>

                                                                <form id="form-status-{{ $data->id }}"
                                                                    action="{{ route('monev.validasi', $data->id) }}"
                                                                    method="POST" style="display:none;">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <input type="hidden" name="status" value="">
                                                                </form>
                                                                <button type="button" class="btn btn-info btn-sm"
                                                                    data-bs-toggle="modal" data-bs-target="#modalPesan"
                                                                    data-id="{{ $data->id }}"
                                                                    data-pesan="{{ $data->pesan ?? '' }}">
                                                                    <i class="fa-solid fa-envelope"></i>
                                                                </button>
                                                            @endif



                                                            {{-- Tombol Delete --}}
                                                            <form id="formDelete-{{ $data->id }}"
                                                                action="{{ route('monev.delete', $data->id) }}"
                                                                method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    onclick="confirmDelete('{{ $data->id }}')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </form>

                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>



                                    <!-- Modal Pesan (satu saja, di luar foreach) -->
                                    <div class="modal fade" id="modalPesan" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form id="formPesan" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="id_monev" id="idMonev">

                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Kirim Catatan ke Admin Perangkat Daerah
                                                        </h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Catatan</label>
                                                            <textarea name="pesan" id="inputPesan" class="form-control" rows="4"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            var modalPesan = document.getElementById('modalPesan');
                                            modalPesan.addEventListener('show.bs.modal', function(event) {
                                                var button = event.relatedTarget;
                                                var idMonev = button.getAttribute('data-id');
                                                var pesan = button.getAttribute('data-pesan') || '';

                                                // isi hidden input
                                                modalPesan.querySelector('#idMonev').value = idMonev;

                                                // isi textarea dengan pesan lama (kalau ada)
                                                modalPesan.querySelector('#inputPesan').value = pesan;

                                                // set action form ke route updatePesan
                                                var form = modalPesan.querySelector('#formPesan');
                                                form.action = "/monev/" + idMonev + "/pesan";
                                            });
                                        });
                                    </script>


                                </div>
                                <div class="mt-3">
                                    {{ $monev->links('vendor.pagination.bootstrap-5') }}
                                </div>

                            </div>
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="uploadFotoModal" tabindex="-1" aria-labelledby="uploadFotoModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content">
                            <form id="uploadFotoForm" method="POST" action="{{ route('foto-progres.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="monev_id" id="monev_id_input">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadFotoModalLabel">Upload Foto Dokumentasi</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <div id="dropZone" class="drop-zone mb-3">
                                        <div class="drop-zone-content">
                                            <i class="bi bi-cloud-arrow-up" style="font-size: 1rem; color: #6c757d;"></i>
                                            <p class="mb-1"><strong>Upload gambar progres</strong></p>
                                            <p class="text-muted small">Drag & drop atau klik untuk pilih (JPG, PNG, Maks
                                                2MB)</p>
                                        </div>
                                        <input type="file" id="fileInput" name="foto[]" accept="image/*" multiple
                                            style="display: none;">
                                    </div>

                                    <div id="previewContainer" class="mb-3"></div>

                                    <div class="form-group">
                                        <label for="deskripsi_input" class="form-label">Keterangan Foto</label>
                                        <textarea name="deskripsi" id="deskripsi_input" class="form-control"
                                            placeholder="Masukkan keterangan untuk semua foto yang diunggah..." rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <style>
                    .drop-zone {
                        border: 2px dashed #ced4da;
                        border-radius: 8px;
                        padding: 40px 20px;
                        text-align: center;
                        cursor: pointer;
                        transition: all 0.3s ease;
                        background-color: #f8f9fa;
                    }

                    .drop-zone:hover,
                    .drop-zone.drag-over {
                        border-color: #0d6efd;
                        background-color: #e7f1ff;
                    }

                    .drop-zone-content {
                        pointer-events: none;
                    }
                </style>

                @push('scripts')
                    <script>
                        $(document).ready(function() {
                            const dropZone = document.getElementById('dropZone');
                            const fileInput = document.getElementById('fileInput');
                            const previewContainer = document.getElementById('previewContainer');
                            const deskripsiInput = document.getElementById('deskripsi_input');
                            let filesArray = [];

                            // Event listener ketika modal akan ditampilkan untuk mengambil ID
                            $('#uploadFotoModal').on('show.bs.modal', function(event) {
                                var button = $(event.relatedTarget);
                                var monevId = button.data('id');
                                var modal = $(this);
                                modal.find('#monev_id_input').val(monevId);
                            });

                            // Membersihkan form saat modal ditutup
                            $('#uploadFotoModal').on('hidden.bs.modal', function() {
                                filesArray = [];
                                previewContainer.innerHTML = '';
                                fileInput.value = '';
                                deskripsiInput.value = ''; // Kosongkan juga textarea deskripsi
                            });

                            // Fungsi untuk trigger klik input file
                            dropZone.addEventListener('click', () => {
                                fileInput.click();
                            });

                            // Event listeners untuk Drag & Drop
                            dropZone.addEventListener('dragover', (e) => {
                                e.preventDefault();
                                dropZone.classList.add('drag-over');
                            });

                            dropZone.addEventListener('dragleave', () => {
                                dropZone.classList.remove('drag-over');
                            });

                            dropZone.addEventListener('drop', (e) => {
                                e.preventDefault();
                                dropZone.classList.remove('drag-over');
                                const files = Array.from(e.dataTransfer.files);
                                handleFiles(files);
                            });

                            // Event listener untuk perubahan input file
                            fileInput.addEventListener('change', (e) => {
                                const files = Array.from(e.target.files);
                                handleFiles(files);
                            });

                            // Fungsi untuk memproses file yang dipilih
                            function handleFiles(files) {
                                files.forEach(file => {
                                    if (!file.type.startsWith('image/')) {
                                        alert('Hanya file gambar yang diperbolehkan');
                                        return;
                                    }
                                    if (file.size > 2 * 1024 * 1024) { // 2MB
                                        alert('Ukuran file maksimal 2MB');
                                        return;
                                    }
                                    filesArray.push({
                                        file: file,
                                        id: Date.now() + Math.random() // ID unik sementara
                                    });
                                });
                                renderPreviews();
                            }

                            // Fungsi untuk menampilkan preview gambar
                            function renderPreviews() {
                                previewContainer.innerHTML = '';

                                // Mengatur style grid untuk preview
                                previewContainer.style.display = 'grid';
                                previewContainer.style.gridTemplateColumns = 'repeat(auto-fill, minmax(100px, 1fr))';
                                previewContainer.style.gap = '10px';

                                filesArray.forEach((item, index) => {
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        const previewHTML = `
                        <div class="preview-item-simple" data-id="${item.id}" style="position: relative;">
                            <img src="${e.target.result}" alt="Preview" style="width: 100%; height: 100px; object-fit: cover; border-radius: 4px;">
                            <button type="button"
                                    class="btn btn-danger btn-sm"
                                    onclick="removeFile('${item.id}')"
                                    style="position: absolute; top: 5px; right: 5px; line-height: 1; padding: 2px 5px; border-radius: 50%;">
                                &times;
                            </button>
                        </div>
                    `;
                                        previewContainer.insertAdjacentHTML('beforeend', previewHTML);
                                    };
                                    reader.readAsDataURL(item.file);
                                });
                                updateFileInput();
                            }

                            // Fungsi untuk sinkronisasi array file dengan input file
                            function updateFileInput() {
                                const dataTransfer = new DataTransfer();
                                filesArray.forEach(item => {
                                    dataTransfer.items.add(item.file);
                                });
                                fileInput.files = dataTransfer.files;
                            }

                            // Fungsi untuk menghapus file dari preview
                            window.removeFile = function(id) {
                                filesArray = filesArray.filter(item => item.id != id);
                                renderPreviews();
                            };
                        });
                    </script>
                @endpush


        </section>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modalPesan = document.getElementById('modalPesan');
            modalPesan.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var idMonev = button.getAttribute('data-id');
                modalPesan.querySelector('#idMonev').value = idMonev;
            });
        });
    </script>
@endsection
