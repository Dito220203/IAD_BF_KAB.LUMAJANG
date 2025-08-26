@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Video</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item">Video</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">

                <!-- Kolom Form -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">

                            @if (isset($videoEdit))
                                <h5 class="card-title">Update Video</h5>
                                <form action="{{ route('video.update', $videoEdit->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label">Judul</label>
                                        <input type="text" name="e_judul" class="form-control"
                                            value="{{ $videoEdit->judul }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Link Video</label>
                                        <input type="text" name="e_link" class="form-control"
                                            value="{{ $videoEdit->link }}" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Update</button>
                                    <a href="{{ route('video') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
                                </form>
                            @else
                                <h5 class="card-title">Tambah Video</h5>
                                <form action="{{ route('video.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul</label>
                                        <input type="text" name="judul" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="link" class="form-label">Link Video</label>
                                        <input type="text" name="link" class="form-control" required>
                                    </div>

                                    <button type="submit" class="btn btn-success w-100">Simpan</button>
                                </form>
                            @endif

                        </div>
                    </div>
                </div>

                <!-- Kolom Tabel -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body" id="tabelVideo">
                            <h5 class="card-title">Daftar Video</h5>

                            <!-- Entries & Search -->
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">

                                <!-- Entries -->
                                <div class="d-flex align-items-center gap-2">
                                    <label for="entries" class="form-label mb-0">Tampilkan</label>
                                    <select id="entries" class="form-select form-select-sm w-auto">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span>data</span>
                                </div>

                                <!-- Search -->
                                <div class="input-group w-auto">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                    <input type="text" id="searchInput" class="form-control" placeholder="Cari Data...">
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table text-center" id="infoTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Link</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($video as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->judul }}</td>
                                                <td>
                                                    <a href="{{ $data->link }}" target="_blank"
                                                        class="btn btn-sm btn-info">Lihat</a>
                                                </td>
                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <a href="{{ route('video.edit', $data->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <form id="formDelete-{{ $data->id }}"
                                                            action="{{ route('deletevideo', $data->id) }}" method="POST"
                                                            style="display:inline;">
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

            </div>
        </section>
    </main>
@endsection
