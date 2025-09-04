@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Sub Program</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item active">Sub Program</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <!-- Kolom Sub Program -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3 mt-3">
                                <h5 class="card-title">Tabel Sub Program</h5>
                                <!-- Tombol Tambah Sub Program -->
                                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
                                    data-bs-target="#modalSubProgram">
                                    + Tambah Sub Program
                                </button>
                            </div>

                            <!-- Modal Tambah Sub Program -->
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
                                                    <input type="text" class="form-control" name="subprogram" required>
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
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">
                                <div class="d-flex align-items-center gap-2">
                                    <label class="form-label mb-0">Tampilkan</label>
                                    <select class="form-select form-select-sm w-auto entriesSelect"
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

                            <!-- Table Sub Program -->
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
                                                        <!-- Edit -->
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

                                                <!-- Modal Update Sub Program -->
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
                            <!-- End Table Sub Program -->
                        </div>
                    </div>
                </div>

                <!-- Kolom Produk -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3 mt-3">

                            <h5 class="card-title">Daftar Produk</h5>
                            <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal"
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
                                            <form action="{{ route('produk.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label>Sub Program</label>
                                                    <select name="id_subprogram" class="form-select" required>
                                                        <option value="">Pilih Sub Program</option>
                                                        @foreach ($subprogram as $program)
                                                            <option value="{{ $program->id }}">
                                                                {{ $program->subprogram }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Nama Produk</label>
                                                    <input type="text" name="judul" class="form-control" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Keterangan</label>
                                                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label>Upload Foto</label>
                                                    <input type="file" name="foto" id="fotoInput"
                                                        class="form-control" accept="image/*" required>
                                                    <small class="text-muted">Maksimal ukuran 2MB</small>
                                                    <div class="mt-2">
                                                        <img id="previewFoto" src="#" alt="Preview Foto"
                                                            style="max-width: 200px; display: none; border: 1px solid #ddd; padding: 5px;">
                                                    </div>
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

                            <!-- Filter & Search Produk -->
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">
                                <div class="d-flex align-items-center gap-2">
                                    <label class="form-label mb-0">Tampilkan</label>
                                    <select class="form-select form-select-sm w-auto entriesSelect"
                                        data-target="TableProduk">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span>data</span>
                                </div>
                                <div class="input-group w-auto">
                                    <input type="text" class="form-control searchInput" data-target="TableProduk"
                                        placeholder="Cari Data...">
                                </div>
                            </div>

                            <!-- Table Produk -->
                            <div class="table-responsive">
                                <table id="TableProduk" class="table .table-active text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Program</th>
                                            <th>Judul</th>
                                            <th>Keterangan</th>
                                            <th>Foto</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($produk as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->subprogram->subprogram ?? '-' }}</td>
                                                <td>{{ $data->judul }}</td>
                                                <td>{{ $data->keterangan }}</td>
                                                <td>{{ $data->foto }}</td>
                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <!-- Edit -->
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#ModalupdateProduk{{ $data->id }}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                        <!-- Hapus -->
                                                        <form id="formDeleteSub-{{ $data->id }}"
                                                            action="{{ route('delete.produk', $data->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmDeleteSub('{{ $data->id }}')">
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
                            <!-- Modal Update Produk -->
                            @foreach ($produk as $data)
                                <div class="modal fade" id="ModalupdateProduk{{ $data->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Produk Subprogram</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('update.produk', $data->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')

                                                    <!-- Pilih Sub Program -->
                                                    <div class="mb-3">
                                                        <label>Sub Program</label>
                                                        <select name="e_id_subprogram" class="form-select" required>
                                                            <option value="">Pilih Sub Program</option>
                                                            @foreach ($subprogram as $program)
                                                                <option value="{{ $program->id }}"
                                                                    {{ $data->id_subprogram == $program->id ? 'selected' : '' }}>
                                                                    {{ $program->subprogram }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Nama Produk -->
                                                    <div class="mb-3">
                                                        <label>Nama Produk</label>
                                                        <input type="text" name="e_judul" class="form-control"
                                                            value="{{ $data->judul }}" required>
                                                    </div>

                                                    <!-- Keterangan -->
                                                    <div class="mb-3">
                                                        <label>Keterangan</label>
                                                        <textarea name="e_keterangan" class="form-control" rows="3">{{ $data->keterangan }}</textarea>
                                                    </div>

                                                    <!-- Upload Foto -->
                                                    <div class="mb-3">
                                                        <label>Upload Foto</label>
                                                        <input type="file" name="e_foto"
                                                            id="fotoInput{{ $data->id }}" class="form-control"
                                                            accept="image/*">
                                                        <small class="text-muted">Maksimal ukuran 2MB</small>
                                                        <div class="mt-2">
                                                            <img id="previewFoto{{ $data->id }}"
                                                                src="{{ $data->foto ? asset('storage/' . $data->foto) : '#' }}"
                                                                alt="Preview Foto"
                                                                style="max-width:200px; border:1px solid #ddd; padding:5px; {{ $data->foto ? '' : 'display:none;' }}">
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    // Preview foto update
                                    document.getElementById('fotoInput{{ $data->id }}').addEventListener('change', function(e) {
                                        const file = e.target.files[0];
                                        if (!file) return;

                                        const maxSize = 2 * 1024 * 1024; // 2MB
                                        if (file.size > maxSize) {
                                            alert('Ukuran file terlalu besar! Maksimal 2MB.');
                                            e.target.value = '';
                                            document.getElementById('previewFoto{{ $data->id }}').style.display = 'none';
                                            return;
                                        }

                                        const reader = new FileReader();
                                        reader.onload = function(event) {
                                            const img = document.getElementById('previewFoto{{ $data->id }}');
                                            img.src = event.target.result;
                                            img.style.display = 'block';
                                        }
                                        reader.readAsDataURL(file);
                                    });
                                </script>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
