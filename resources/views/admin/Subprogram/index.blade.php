@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Sub Program</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item">Sub Program</li>
                </ol>
            </nav>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-6">

                    <div class="card ">
                        <div class="card-body">
                            <!-- Header control: Tambah, Search, Tampilkan Data -->
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">

                                <!-- Tombol Trigger Modal -->
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalSubProgram">
                                    + Tambah Sub Program
                                </button>

                                <!-- modal-tambah-subprogram -->
                                <div class="modal fade" id="modalSubProgram" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Sub Program</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('subrogram.store') }}" method="POST"
                                                    enctype="multipart/form-data">
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

                                <!-- Filter & Search -->
                                <div class="d-flex align-items-center ">
                                    <label for="entries" class="form-label mb-0">Tampilkan</label>
                                    <select id="entries" class="form-select form-select-sm w-auto entriesSelect"
                                        data-target="TableSubprogram">
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
                                <table class="table table-bordered text-center" id="TableSubprogram">
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
                                                        <!-- Tombol Edit -->
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#Modalupdate{{ $data->id }}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>

                                                        <!-- Hapus -->
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
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Sub Program</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('subprogram.update', $data->id) }}"
                                                                    method="POST" enctype="multipart/form-data">
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

                                                                    <div class="mb-3">
                                                                        <label>Update Gambar (Minimal 4, Maksimal
                                                                            10)</label>
                                                                        <input type="file" class="form-control"
                                                                            name="e_gambar[]" multiple accept="image/*">
                                                                        <small class="text-muted">Pilih 4–10 gambar
                                                                            sekaligus jika ingin ganti.</small>
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
                <!-- Kolom Tabel -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Produk</h5>
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                data-bs-target="#modalProduk">
                                + Tambah Produk
                            </button>

                            <!-- Modal Tambah Produk -->
                            <div class="modal fade" id="modalProduk" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah Produk Subprogram</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
                                                <div class="mb-3">
                                                    <label>Sub Program</label>
                                                    <select name="program" class="form-select" required>
                                                        <option value="">Pilih Sub Program</option>
                                                        @foreach ($subprogram as $program)
                                                            <option value="{{ $program->id }}">{{ $program->subprogram }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Nama Produk</label>
                                                    <input type="text" name="produk" class="form-control"
                                                        required>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Keterangan</label>
                                                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Upload Foto</label>
                                                    <input type="file" name="foto" class="form-control"
                                                        accept="image/*" required>
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
                            <!-- Entries & Search -->
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">
                                <div class="d-flex align-items-center gap-2">
                                    <label class="form-label mb-0">Tampilkan</label>
                                    <select class="form-select form-select-sm w-auto entriesSelect"
                                        data-target="infoTable">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span>data</span>
                                </div>

                                <div class="input-group w-auto">
                                    <input type="text" class="form-control searchInput" data-target="infoTable"
                                        placeholder="Cari Data...">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="infoTable" class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Program</th>
                                            <th>Judul</th>
                                            <th>Keteangan</th>
                                            <th>Foto</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    {{-- <tbody>
                                        @foreach ($banner as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->judul }}</td>
                                                <td>
                                                    @if ($data->status === 'Aktif')
                                                        <span class="badge bg-success">{{ $data->status }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $data->status }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                        data-bs-target="#fileModal{{ $data->id }}">
                                                        Lihat
                                                    </button>
                                                    <div class="modal fade" id="fileModal{{ $data->id }}"
                                                        tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center">
                                                                    @php
                                                                        $ext = pathinfo(
                                                                            $data->file,
                                                                            PATHINFO_EXTENSION,
                                                                        );
                                                                    @endphp
                                                                    @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif']))
                                                                        <img src="{{ asset('storage/' . $data->file) }}"
                                                                            class="img-fluid rounded">
                                                                    @elseif(in_array(strtolower($ext), ['mp4', 'mov', 'avi', 'wmv']))
                                                                        <video controls class="w-100">
                                                                            <source
                                                                                src="{{ asset('storage/' . $data->file) }}"
                                                                                type="video/{{ $ext }}">
                                                                        </video>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <a href="{{ route('banner.edit', $data->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <form id="formDelete-{{ $data->id }}"
                                                            action="{{ route('banner.delete', $data->id) }}"
                                                            method="POST">
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
                                    </tbody> --}}
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
        </section>
    </main>
@endsection
