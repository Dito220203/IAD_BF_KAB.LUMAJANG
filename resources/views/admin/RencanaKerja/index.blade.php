@extends('components.layout')
@section('content')
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
                                <div class="d-flex gap-2">
                                    <a href="{{ route('rencana.create') }}" class="btn btn-primary">
                                        + Tambah Rencana
                                    </a>
                                    <a href="{{ route('rencana.export.excel') }}" class="btn btn-success">
                                        <i class="fa-solid fa-file-excel"></i> Export Excel
                                    </a>
                                </div>

                                <!-- Select entries -->
                                <div class="d-flex align-items-center gap-2">
                                    <label for="entries" class="form-label mb-0">Tampilkan</label>
                                    <select id="entries" class="form-select form-select-sm w-auto entriesSelect"
                                        data-target="TableRencanaAksi">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span>data</span>
                                </div>

                                <!-- Pencarian -->
                                <div class="input-group w-auto">
                                    <input type="text" class="form-control searchInput" data-target="TableRencanaAksi"
                                        placeholder="Cari Data...">
                                </div>
                            </div>


                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="detail-table" id="TableRencanaAksi" style="min-width: 1800px;">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 50px;">No</th>
                                            <th class="text-center" style="width: 200px;">Sub Program</th>
                                            <th class="text-center" style="width: 250px;">Rencana Aksi/Aktivitas</th>
                                            <th class="text-center" style="width: 350px;">Sub Kegiatan</th>
                                            <th class="text-center" style="width: 250px;">Kegiatan</th>
                                            <th class="text-center" style="width: 300px;">Nama Program</th>
                                            <th class="text-center" style="width: 200px;">Lokasi</th>
                                            <th class="text-center" style="width: 100px;">Volume</th>
                                            <th class="text-center" style="width: 100px;">Satuan</th>
                                            <th class="text-center" style="width: 150px;">Anggaran</th>
                                            <th class="text-center" style="width: 200px;">Sumber Dana</th>
                                            <th class="text-center" style="width: 100px;">Tahun</th>
                                            <th class="text-center" style="width: 200px;">Perangkat Daerah</th>
                                            <th class="text-center" style="width: 100px;">Status</th>
                                            <th class="text-center" style="width: 300px;">Keterangan</th>
                                            <th class="text-center" style="width: 120px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rencana as $data)
                                            <tr id="row-{{ $data->id }}">
                                                <td class="text-center">{{ $rencana->firstItem() + $loop->index }}</td>
                                                <td class="text-center">{{ $data->subprogram->subprogram ?? '-' }}</td>
                                                <td>{{ $data->rencana_aksi}}</td>
                                                <td>{{ $data->sub_kegiatan }}</td>
                                                <td>{{ $data->kegiatan }}</td>
                                                <td>{{ $data->nama_program }}</td>
                                                <td>{{ $data->lokasi }}</td>
                                                <td class="text-center">{{ $data->volume }}</td>
                                                <td class="text-center">{{ $data->satuan }}</td>
                                                <td class="text-center">{{ $data->anggaran }}</td>
                                                <td class="text-center">{{ $data->sumberdana }}</td>
                                                <td class="text-center">{{ $data->tahun }}</td>
                                                <td class="text-center">{{ $data->opd->nama ?? '-' }}</td>
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
