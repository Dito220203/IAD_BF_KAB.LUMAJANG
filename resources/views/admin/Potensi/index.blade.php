@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Potensi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</a></li>
                    <li class="breadcrumb-item active">Potensi</li>
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
                                    + Tambah
                                </a>

                                <div class="col-12 col-lg-auto">
                                    <!-- Pencarian -->
                                    <form method="GET" class="input-group w-auto mb-1">
                                        <input type="text" name="search" class="form-control" placeholder="Cari Data"
                                            value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">Cari</button>
                                        @if (request('search'))
                                            <a href="{{ route('potensi') }}" class="btn btn-secondary">Reset</a>
                                        @endif
                                    </form>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="detail-table" id="TablePotensi">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Sub Potensi</th>
                                            <th>Nama Potensi</th>
                                            <th>Lokasi</th>
                                            <th data-type="date" data-format="YYYY/DD/MM">Tanggal Dibuat</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($potensi as $data)
                                            <tr>
                                                <td>{{ $potensi->firstItem() + $loop->index }}</td>
                                                <td>{{ $data->SubpotensiKehutanan->sub_potensi ?? '-' }}</td>
                                                <td>{{ $data->judul }}</td>
                                                <td> Desa/Kelurahan: {{ $data->desa->name ?? '-' }},
                                                    Kecamatan: {{ $data->kecamatan->name ?? '-' }}
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
                            <div class="mt-3">
                                {{ $potensi->links('vendor.pagination.bootstrap-5') }}
                            </div>
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
        </section>
    </main>
@endsection
