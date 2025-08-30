@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Opd</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item">Opd</li>
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

                                <!-- Tombol Trigger Modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalOpd">
                                    + Tambah Opd
                                </button>
                                <!-- modal -->
                                <div class="modal fade" id="modalOpd" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Opd</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('opd.store') }}" method="POST">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label>Nama Opd</label>
                                                        <input type="text" class="form-control" name="nama" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Jenis</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="">Pilih</option>
                                                            <option value="Internal">Internal</option>
                                                            <option value="Eksternal">Eksternal</option>
                                                        </select>
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
                                </div>


                                <div class="d-flex align-items-center ">
                                    <label for="entries" class="form-label mb-0">Tampilkan</label>
                                    <select id="entries" class="form-select form-select-sm w-auto entriesSelect" data-target="TableOpd">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span>data</span>
                                </div>

                                <div class="input-group w-auto">
                                   <input type="text" class="form-control searchInput" data-target="TableOpd"
                                        placeholder="Cari Data...">
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table .table-active text-center" id="TableOpd">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($opd as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->nama }}</td>
                                                <td> {{ $data->status }}</td>
                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#Modalupdateopd{{ $data->id }}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                        </form>
                                                        <form id="formDelete-{{ $data->id }}"
                                                            action="{{ route('opd.destroy', $data->id) }}" method="POST"
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
                                                <!-- Modal Update -->
                                                <div class="modal fade" id="Modalupdateopd{{ $data->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Gambaran Umum</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('opd.update', $data->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="mb-3">
                                                                        <label>Judul</label>
                                                                        <input type="text" class="form-control"
                                                                            name="e_nama" value="{{ $data->nama }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Status</label>
                                                                        <select name="e_status" class="form-select"
                                                                            required>
                                                                            <option value="Internal"
                                                                                {{ $data->status == 'Internal' ? 'selected' : '' }}>
                                                                                Internal</option>
                                                                            <option value="Eksternal"
                                                                                {{ $data->status == 'Eksternal' ? 'selected' : '' }}>
                                                                                Eksternal</option>
                                                                        </select>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
