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

        .highlight-manual {
            background-color: #fff3cd !important;
            /* kuning */
        }
    </style>
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Rencana Kerja</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item active">Rencana Kerja</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Header tools -->
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">
                                <div class="gap-2">
                                    <div class="d-flex flex-column flex-sm-row gap-2">
                                        <a href="{{ route('rencana.create') }}" class="btn btn-primary">
                                            + Tambah Rencana
                                        </a>

                                        <a href="{{ route('rencana.export.excel') }}" class="btn btn-success">
                                            <i class="fa-solid fa-file-excel"></i> Export Excel
                                        </a>
                                    </div>
                                </div>

                                {{-- UBAH FORM MENJADI SEPERTI INI --}}
                                <form method="GET" class="d-flex flex-column flex-md-row gap-2">
                                    {{-- TAMBAHKAN DROPDOWN FILTER TAHUN DI SINI --}}
                                    <div class="input-group w-auto">
                                        <label class="input-group-text" for="tahun-filter">
                                            <i class="fas fa-calendar-alt"></i>
                                        </label>
                                        <select name="tahun" class="form-select" onchange="this.form.submit()">
                                            <option value="">Semua Tahun</option>
                                            @foreach ($daftarTahun as $thn)
                                                <option value="{{ $thn }}" {{ $tahun == $thn ? 'selected' : '' }}>
                                                    {{ $thn }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Form pencarian yang sudah ada --}}
                                    <div class="input-group w-auto">
                                        <input type="text" name="search" class="form-control" placeholder="Cari Data..."
                                            value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">Cari</button>
                                    </div>

                                    {{-- Tombol Reset untuk membersihkan semua filter --}}
                                    @if (request('search') || request('tahun'))
                                        <a href="{{ route('rencanakerja') }}" class="btn btn-secondary"> <i
                                                class="fas fa-sync-alt"></i></a>
                                    @endif
                                </form>

                                {{-- ... sisa kode Anda ... --}}
                            </div>


                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="detail-table" id="TableRencanaAksi" style="min-width: 2500px;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 50px;">No</th>
                                            <th class="text-center" style="width: 200px;">Sub Program</th>
                                            <th class="text-center" style="width: 300px;">Rencana Aksi/Aktivitas</th>
                                            <th class="text-center" style="width: 350px;">Sub Kegiatan</th>
                                            <th class="text-center" style="width: 250px;">Kegiatan</th>
                                            <th class="text-center" style="width: 300px;">Nama Program</th>
                                            <th class="text-center" style="width: 200px;">Lokasi</th>
                                            <th class="text-center" style="width: 100px;">Volume</th>
                                            <th class="text-center" style="width: 100px;">Satuan</th>
                                            <th class="text-center" style="width: 100px;">Tahun</th>
                                            <th class="text-center" style="width: 200px;">Perangkat Daerah</th>
                                            <th class="text-center" style="width: 150px;">Anggaran</th>
                                            <th class="text-center" style="width: 200px;">Sumber Dana</th>
                                            <th class="text-center" style="width: 100px;">Status</th>
                                            <th class="text-center" style="width: 300px;">Keterangan</th>
                                            <th class="text-center" style="width: 120px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rencana as $data)
                                            <tr id="row-{{ $data->id }}"
                                                class="{{ $data->input === 'manual' ? 'highlight-manual' : '' }}">

                                                <td class="text-center">{{ $rencana->firstItem() + $loop->index }}</td>
                                                <td class="text-center">{{ $data->subprogram->subprogram ?? '-' }}</td>
                                                <td>{{ $data->rencana_aksi }}</td>
                                                <td>{{ $data->sub_kegiatan }}</td>
                                                <td>{{ $data->kegiatan }}</td>
                                                <td>{{ $data->nama_program }}</td>
                                                <td>{{ $data->lokasi }}</td>
                                                <td class="text-center">{{ $data->volume }}</td>
                                                <td class="text-center">{{ $data->satuan }}</td>
                                                <td class="text-center">{{ $data->tahun }}</td>
                                                <td class="text-center">{{ $data->opd->nama ?? '-' }}</td>
                                                @php
                                                    $anggarans = explode('; ', $data->anggaran);
                                                    $sumberdanas = explode('; ', $data->sumberdana);
                                                @endphp

                                                {{-- Cek untuk Kolom Anggaran --}}
                                                @if (count($anggarans) > 1)
                                                    {{-- Jika data lebih dari satu, gunakan tampilan multi-baris --}}
                                                    <td class="multi-item align-middle">
                                                        @foreach ($anggarans as $anggaran)
                                                            <div>{{ $anggaran ?: '-' }}</div>
                                                        @endforeach
                                                    </td>
                                                @else
                                                    {{-- Jika data hanya satu, tampilkan seperti biasa --}}
                                                    <td class="align-middle">{{ $data->anggaran ?: '-' }}</td>
                                                @endif

                                                {{-- Cek untuk Kolom Sumber Dana --}}
                                                @if (count($sumberdanas) > 1)
                                                    {{-- Jika data lebih dari satu, gunakan tampilan multi-baris --}}
                                                    <td class="multi-item align-middle">
                                                        @foreach ($sumberdanas as $sumber)
                                                            <div>{{ $sumber ?: '-' }}</div>
                                                        @endforeach
                                                    </td>
                                                @else
                                                    {{-- Jika data hanya satu, tampilkan seperti biasa --}}
                                                    <td class="align-middle">{{ $data->sumberdana ?: '-' }}</td>
                                                @endif

                                                <td class="text-center">
                                                    @if ($data->status === 'Valid')
                                                        <span class="badge bg-success">{{ $data->status }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $data->status }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ $data->keterangan }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-1">
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
                                                                action="{{ route('rencana.validasi', $data->id) }}"
                                                                method="POST" style="display:none;">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="">
                                                            </form>
                                                        @endif
                                                        <a href="{{ route('rencana.edit', $data->id) }}"
                                                            class="btn btn-primary btn-sm" title="Edit">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <form id="formDelete-{{ $data->id }}"
                                                            action="{{ route('rencana.delete', $data->id) }}"
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
                            </div>

                            <!-- Pagination -->
                            <div class="mt-3">
                                {{ $rencana->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
