@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Sub Program</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</a></li>
                    <li class="breadcrumb-item">Sub Program</li>
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
                                    data-bs-target="#modalSubProgram">
                                    + Tambah Sub Program
                                </button>
                                <!-- modal-gambaranUmum -->
                                <div class="modal fade" id="modalSubProgram" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Sub Program</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('subrogram.store') }}" method="POST">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label>Program</label>
                                                        <select name="program" class="form-select" required>
                                                            <option value="">Pilih</option>
                                                            <option value="Program 1">Program 1</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Judul Sub Program</label>
                                                        <input type="text" class="form-control" name="subprogram"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Uraian</label>
                                                        <textarea class="form-control" name="uraian" rows="4" required></textarea>
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
                                    <select id="entries" class="form-select form-select-sm w-auto entriesSelect" data-target="TableSubprogram">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span>data</span>
                                </div>

                                <div class="input-group w-auto">
                                    <input type="text" class="form-control searchInput" data-target="TableSubprogram"
                                        placeholder="Cari Data...">
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table .table-active text-center" id="TableSubprogram">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Program</th>
                                            <th>Sub Program</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subprogram as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->program }}</td>
                                                <td>{{ $data->subprogram }}</td>


                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#Modalupdate{{ $data->id }}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>

                                                        <form id="formDelete-{{ $data->id }}"
                                                            action="{{ route('subrogram.delete', $data->id) }}"
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
                                                <!-- modal-update-subprogram -->
                                                <div class="modal fade" id="Modalupdate{{ $data->id }}" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Sub Program</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('subprogram.update', $data->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')

                                                                    <div class="mb-3">
                                                                        <label>Program</label>
                                                                        <select name="e_program" class="form-select"
                                                                            required>
                                                                            <option value="">Pilih</option>
                                                                            <option value="Program 1"
                                                                                {{ $data->program == 'Program 1' ? 'selected' : '' }}>
                                                                                Program 1</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label>Judul Sub Program</label>
                                                                        <input type="text" class="form-control"
                                                                            name="e_subprogram"
                                                                            value="{{ $data->subprogram }}" required>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label>Uraian</label>
                                                                        <textarea class="form-control" name="e_uraian" rows="4" required>{{ $data->uraian }}</textarea>
                                                                    </div>

                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-bs-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Update</button>
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
