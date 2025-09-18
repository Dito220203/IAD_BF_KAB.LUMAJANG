@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Rencana Aksi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item active">Rencana Aksi</li>
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
                                    <a href="{{ route('rencanaAksi.create') }}" class="btn btn-primary">
                                        + Tambah Rencana Aksi
                                    </a>
                                    <a href="{{ route('rencanaAksi.export.excel') }}" class="btn btn-success">
                                        <i class="fa-solid fa-file-excel"></i> Export Excel
                                    </a>
                                </div>

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

                                <div class="input-group w-auto">
                                    <input type="text" class="form-control searchInput" data-target="TableRencanaAksi"
                                        placeholder="Cari Data...">
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="detail-table" id="TableRencanaAksi"
                                    style="min-width: 1800px;">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">No</th>
                                            <th style="width: 200px;">Sub Program</th>
                                            <th style="width: 300px;">Rencana Aksi / Aktivitas</th>
                                            <th style="width: 250px;">Nama Program</th>
                                            <th style="width: 300px;">Kegiatan</th>
                                            <th style="width: 300px;">Sub Kegiatan</th>
                                            <th style="width: 100px;">Tahun</th>
                                            <th style="width: 150px;">Lokasi</th>
                                            <th style="width: 100px;">Volume</th>
                                            <th style="width: 100px;">Satuan</th>
                                            <th style="width: 150px;">Anggaran</th>
                                            <th style="width: 150px;">Sumber Dana</th>
                                            <th style="width: 300px;">Perangkat Daerah</th>
                                            <th style="width: 300px;">Keterangan</th>
                                            <th style="width: 120px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rencanaAksi as $data)
                                            <tr>
                                                <td class="text-center">{{ $rencanaAksi->firstItem() + $loop->index }}</td>
                                                <td class="text-center">{{ $data->subprogram->subprogram ?? '-' }}</td>
                                                <td>{{ $data->rencana_aksi }}</td>
                                                <td>{{ $data->nama_program }}</td>
                                                <td>{{ $data->kegiatan }}</td>
                                                <td>{{ $data->sub_kegiatan }}</td>
                                                <td>{{ $data->tahun }}</td>
                                                <td>{{ $data->lokasi }}</td>
                                                <td>{{ $data->volume }}</td>
                                                <td>{{ $data->satuan }}</td>
                                                <td>{{ $data->anggaran }}</td>
                                                <td>{{ $data->sumberdana }}</td>
                                                <td>{{ $data->opd->nama ?? '-' }}</td>
                                                <td>{{ $data->keterangan ?? '-' }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <a href="{{ route('rencanaAksi.edit', $data->id) }}"
                                                            class="btn btn-primary btn-sm" title="Edit">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <form id="formDelete-{{ $data->id }}"
                                                            action="{{ route('rencanaAksi.destroy', $data->id) }}"
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
                                {{ $rencanaAksi->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
