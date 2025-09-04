@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Produk KUPS</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item">Produk KUPS</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">

                <!-- Kolom Form -->
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            @if (isset($produkKupsEdit))
                                <h5 class="card-title">Update Produk</h5>
                                <form action="{{ route('produkKups.update', $produkKupsEdit->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label">Nama Produk</label>
                                        <input type="text" name="e_nama" class="form-control"
                                            value="{{ old('e_nama', $produkKupsEdit->nama) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Gambar Produk</label>
                                        <input type="file" name="e_gambar" class="form-control"
                                            onchange="validateFileSize(this); previewReplaceImage(event, 'previewUpdate')">

                                        <img id="previewUpdate"
                                            src="{{ $produkKupsEdit->gambar ? asset('storage/' . $produkKupsEdit->gambar) : '' }}"
                                            class="img-fluid mt-2 rounded"
                                            width="150"
                                            style="{{ $produkKupsEdit->gambar ? '' : 'display:none;' }}">

                                        @error('e_gambar')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <textarea name="e_keterangan" class="form-control" rows="3" required>{{ old('e_keterangan', $produkKupsEdit->keterangan) }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Update</button>
                                    <a href="{{ route('produkKups') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
                                </form>
                            @else
                                <h5 class="card-title">Tambah Produk</h5>
                                <form action="{{ route('produkKups.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Nama Produk</label>
                                        <input type="text" name="nama" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Gambar Produk</label>
                                        <input type="file" name="gambar" class="form-control"
                                            onchange="validateFileSize(this); previewReplaceImage(event, 'previewTambah')">
                                        <img id="previewTambah" class="img-fluid mt-2 rounded" width="150"
                                            style="display:none;">

                                        @error('gambar')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Keterangan</label>
                                        <textarea name="keterangan" class="form-control" rows="3" required></textarea>
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
                            <h5 class="card-title">Daftar Produk KUPS</h5>

                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">
                                <div class="d-flex align-items-center gap-2">
                                    <label class="form-label mb-0">Tampilkan</label>
                                    <select class="form-select form-select-sm w-auto entriesSelect"
                                        data-target="produkKups">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span>data</span>
                                </div>
                                <div class="input-group w-auto">
                                    <input type="text" class="form-control searchInput" data-target="produkKups"
                                        placeholder="Cari Data...">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="produkKups" class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Gambar</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($produkKups as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->nama }}</td>
                                                <td>
                                                    @if ($data->gambar)
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalGambar{{ $data->id }}">
                                                            Lihat
                                                        </button>
                                                    @else
                                                        <span class="text-muted">Tidak ada gambar</span>
                                                    @endif
                                                </td>
                                                <td>{{ $data->keterangan }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <a href="{{ route('produkKups.edit', $data->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <form id="formDelete-{{ $data->id }}"
                                                            action="{{ route('produkKups.delete', $data->id) }}"
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

        <!-- Modal Gambar -->
        @foreach ($produkKups as $data)
            <div class="modal fade" id="modalGambar{{ $data->id }}" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            @if ($data->gambar)
                                <img src="{{ asset('storage/' . $data->gambar) }}" class="img-fluid rounded">
                            @else
                                <p class="text-muted">Tidak ada gambar</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </main>
@endsection

@push('scripts')
<script>
    function validateFileSize(input) {
        const file = input.files[0];
        if (file && file.size > 2 * 1024 * 1024) { // 2MB
            alert('Ukuran gambar tidak boleh lebih dari 2MB.');
            input.value = "";
            return false;
        }
        return true;
    }

    // Ganti gambar lama dengan gambar baru
    function previewReplaceImage(event, previewId) {
        const file = event.target.files[0];
        const preview = document.getElementById(previewId);

        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                preview.src = "";
                preview.style.display = "none";
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    }

</script>
@endpush
