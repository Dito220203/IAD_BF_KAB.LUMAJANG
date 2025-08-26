@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Potensi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Beranda</a></li>
                    <li class="breadcrumb-item">Potensi</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card ">
                        <div class="card-body">
                            <!-- Header control: Tambah, Search, Tampilkan Data -->
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">

                                <a href="{{ route('potensi.create') }}" class="btn btn-primary">
                                    + Tambah Potensi
                                </a>

                                <div class="d-flex align-items-center ">
                                    <label for="entries" class="form-label mb-0">Tampilkan</label>
                                    <select id="entries" class="form-select form-select-sm w-auto">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span>data</span>
                                </div>

                                <div class="input-group w-auto">
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Cari informasi...">
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table .table-active text-center" id="infoTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Potensi</th>
                                            <th>Lokasi</th>
                                            <th data-type="date" data-format="YYYY/DD/MM">Tanggal Dibuat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($potensi as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->judul }}</td>
                                                <td>Desa/Kelurahan {{ $data->desa }}, Kecamatan {{ $data->kecamatan }}
                                                </td>
                                                <td>{{ $data->tanggal }}</td>

                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <form action="{{ route('potensi.edit', $data->id) }}"
                                                            method="GET">
                                                            <button class="btn btn-primary btn-sm">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>
                                                        </form>

                                                        <form id="formDelete-{{ $data->id }}"
                                                            action="{{ route('potensi.destroy', $data->id) }}"
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
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
        </section>
    </main>
@endsection
