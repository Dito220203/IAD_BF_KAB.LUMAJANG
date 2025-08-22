@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Banner</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item">Banner</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">

                <!-- Kolom Form -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">

                            {{-- Jika klik edit tampilkan update, kalau tidak create --}}
                            @if (isset($bannerEdit))
                                <h5 class="card-title">Update Banner</h5>
                                <form action="{{ route('banner.update', $bannerEdit->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label">Judul</label>
                                        <input type="text" name="e_judul" class="form-control"
                                            value="{{ $bannerEdit->judul }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Status</label>
                                        <select name="e_status" class="form-select" required>
                                            <option value="Aktif" {{ $bannerEdit->status == 'Aktif' ? 'selected' : '' }}>
                                                Aktif</option>
                                            <option value="Nonaktif"
                                                {{ $bannerEdit->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Upload Gambar</label>
                                        <input type="file" name="e_image" class="form-control" accept=".jpg,.jpeg,.png"
                                            onchange="previewImage(event)">
                                        <div class="mt-2">
                                            <img id="image-preview" src="{{ asset('storage/' . $bannerEdit->image) }}"
                                                style="max-height: 120px; border: 1px solid #ccc; padding: 5px;">
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Update</button>
                                    <a href="{{ route('banner') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
                                </form>
                            @else
                                <h5 class="card-title">Tambah Banner</h5>
                                <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="judul" class="form-label">Judul</label>
                                        <input type="text" name="judul" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select name="status" class="form-select">
                                            <option value="">Pilih</option>
                                            <option value="Aktif">Aktif</option>
                                            <option value="Nonaktif">Nonaktif</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="image" class="form-label">Upload Gambar</label>
                                        <input type="file" name="image" class="form-control" accept=".jpg,.jpeg,.png"
                                            onchange="previewImage(event)">
                                        <div class="mt-2">
                                            <img id="image-preview" src="#"
                                                style="max-height: 120px; display:none; border:1px solid #ccc; padding:5px;">
                                        </div>
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
                        <div class="card-body">
                            <h5 class="card-title">Daftar Banner</h5>

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
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Cari Data...">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table  id="infoTable" class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Status</th>
                                            <th>Image</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                                        data-bs-target="#imageModal{{ $data->id }}">
                                                        Lihat
                                                    </button>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="imageModal{{ $data->id }}"
                                                        tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center">
                                                                    <img src="{{ asset('storage/' . $data->image) }}"
                                                                        class="img-fluid rounded">
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
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </section>
          <script>
                    document.getElementById('searchInput').addEventListener('keyup', function() {
                        let value = this.value.toLowerCase();
                        let rows = document.querySelectorAll('#infoTable tbody tr');
                        rows.forEach(row => {
                            let text = row.innerText.toLowerCase();
                            row.style.display = text.includes(value) ? '' : 'none';
                        });
                    });
                </script>
    </main>

@endsection
