@extends('components.layout')
@section('content')
    {{-- CSS untuk sel tabel multi-baris --}}
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
            border-bottom: 1px solid #cccccc;
        }

        /* Styling utama untuk drop zone */
        .drop-zone {
            border: 2px dashed #007bff;
            /* Garis putus-putus dengan warna primer */
            border-radius: 10px;
            /* Sudut lebih tumpul */
            padding: 30px;
            text-align: center;
            color: #6c757d;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            /* Animasi halus untuk semua perubahan */
            background-color: #f8f9fa;
        }

        /* Efek saat mouse berada di atas drop zone */
        .drop-zone:hover {
            background-color: #e9ecef;
            border-color: #0056b3;
        }

        /* Class ini ditambahkan via JavaScript saat file di-drag di atas zona */
        .drop-zone--over {
            border-style: solid;
            /* Garis menjadi solid */
            background-color: #d1e7fd;
            /* Latar belakang biru muda */
            border-color: #0056b3;
        }

        /* Styling untuk ikon */
        .drop-zone-content .bi-cloud-arrow-up {
            font-size: 3rem;
            /* Ikon jauh lebih besar */
            color: #007bff;
            margin-bottom: 10px;
        }

        /* Styling untuk teks utama */
        .drop-zone-content p strong {
            font-size: 1.1rem;
            color: #343a40;
        }

        /* Styling untuk container pratinjau */
        #previewContainer {
            display: flex;
            /* Menggunakan flexbox agar rapi */
            flex-wrap: wrap;
            /* Gambar akan pindah ke baris baru jika tidak muat */
            gap: 15px;
            /* Jarak antar gambar */
            margin-top: 20px;
        }

        /* Styling untuk setiap item pratinjau */
        .preview-item {
            position: relative;
            /* Diperlukan untuk tombol hapus */
            width: 120px;
            height: 120px;
            border: 1px solid #ddd;
            border-radius: 8px;
            overflow: hidden;
            /* Memastikan gambar tidak keluar dari kotak */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Styling untuk gambar pratinjau */
        .preview-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Gambar akan mengisi kotak tanpa distorsi */
        }

        /* Styling untuk tombol hapus pada pratinjau */
        .remove-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            width: 20px;
            height: 20px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            border: none;
            border-radius: 50%;
            /* Membuatnya menjadi lingkaran */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: bold;
            cursor: pointer;
            opacity: 0;
            /* Sembunyikan secara default */
            transition: opacity 0.2s ease;
        }

        /* Tampilkan tombol hapus saat mouse di atas gambar */
        .preview-item:hover .remove-btn {
            opacity: 1;
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
                    <div class="card">
                        <div class="card-body">


                            <div class="table-container">
                                <div class="table-responsive">
                                    <table class="detail-table" id="TableMonev" style="min-width: 3000px;">
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
                                                    <td class="text-center">{{ $data->opd->nama ?? '-' }}</td>

                                                    {{-- Kolom Anggaran & Sumber Dana dengan multi-baris --}}
                                                    @php
                                                        $anggarans = explode('; ', $data->anggaran);
                                                        $sumberdanas = explode('; ', $data->sumberdana);
                                                    @endphp
                                                    <td class="multi-item text-center align-middle">
                                                        @foreach ($anggarans as $anggaran)
                                                            <div>{{ $anggaran ?: '-' }}</div>
                                                        @endforeach
                                                    </td>
                                                    <td class="multi-item text-center align-middle">
                                                        @foreach ($sumberdanas as $sumber)
                                                            <div>{{ $sumber ?: '-' }}</div>
                                                        @endforeach
                                                    </td>

                                                    <td class="text-center">
                                                        @if ($data->status === 'Valid')
                                                            <span class="badge bg-success">{{ $data->status }}</span>
                                                        @else
                                                            <span class="badge bg-secondary">{{ $data->status }}</span>
                                                        @endif
                                                    </td>

                                                    {{-- Kolom Dokumen, Realisasi, Volume Target --}}
                                                    <td>{{-- ... (kode Anda untuk dokumen anggaran) ... --}}</td>
                                                    <td>{{-- ... (kode Anda untuk realisasi) ... --}}</td>
                                                    <td>{{-- ... (kode Anda untuk volume target) ... --}}</td>
                                                    <td>{{ $data->uraian }}</td>

                                                    {{-- Tombol Lihat Dokumentasi --}}
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#ModalDetailProduk{{ $data->id }}">
                                                            Lihat Dokumentasi
                                                        </button>
                                                    </td>

                                                    {{-- Kolom Aksi --}}
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group" aria-label="Aksi">
                                                            <div class="d-flex justify-content-center gap-1">
                                                            <button type="button" class="btn btn-success btn-sm"
                                                                data-bs-toggle="modal" data-bs-target="#uploadFotoModal"
                                                                data-id="{{ $data->id }}">
                                                                <i class="fas fa-camera"></i> Upload
                                                            </button>
                                                            <a href="{{ route('monev.edit', $data->id) }}"
                                                                class="btn btn-warning btn-sm">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                            <form action="{{ route('monev.delete', $data->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Yakin ingin menghapus data ini?');"
                                                                style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </button>
                                                            </form>
                                                        </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="mt-3">
                                {{ $monev->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>




    </main>
@endsection


