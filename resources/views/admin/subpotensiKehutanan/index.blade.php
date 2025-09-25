@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel SubPotensi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item active">SubPotensi</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="card mx-auto">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">

                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalSubpotensi">
                                    + Tambah Subpotensi
                                </button>

                                <div class="col-12 col-lg-auto">
                                                <!-- Pencarian -->
                                                <form method="GET" class="input-group w-auto mb-2">
        <input type="text" name="search" class="form-control"
               placeholder="Cari Data"
               value="{{ request('search') }}">
        <button class="btn btn-primary" type="submit">Cari</button>
        @if(request('search'))
            <a href="{{ route('SubpotensiKehutanan') }}" class="btn btn-secondary">Reset</a>
        @endif
    </form>
                                </div>
                            </div>

                                <!-- Modal Tambah Subpotensi -->
                                <div class="modal fade" id="modalSubpotensi" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Subpotensi</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('subpotensi.store') }}" method="POST">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label>Nama Subpotensi</label>
                                                        <input type="text" class="form-control" name="sub_potensi"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Deskripsi</label>
                                                        <textarea class="form-control" name="keterangan" rows="4" required></textarea>
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

                                <!-- Tabel Subpotensi -->
                                <div class="table-responsive">
                                    <table class="detail-table" id="TableSubPotensi">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Subpotensi</th>
                                                <th>Keterangan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subpotensi as $item)
                                                <tr>
                                                    <td>{{ $subpotensi->firstItem() + $loop->index }}</td>
                                                    <td>{{ $item->sub_potensi }}</td>
                                                    <td>{{ $item->keterangan }}</td>
                                                    <td>
                                                        <div class="d-flex justify-content-center gap-1">
                                                            <button type="button" class="btn btn-primary btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#modalEditSubpotensi{{ $item->id }}">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>
                                                            <form id="formDelete-{{ $item->id }}"
                                                                action="{{ route('subpotensi.delete', $item->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="button" class="btn btn-danger btn-sm"
                                                                    onclick="confirmDelete('{{ $item->id }}')">
                                                                    <i class="fa-solid fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Modal Edit Subpotensi -->
                                                <div class="modal fade" id="modalEditSubpotensi{{ $item->id }}"
                                                    tabindex="-1">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Edit Subpotensi</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('subpotensi.update', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="mb-3">
                                                                        <label>Nama Subpotensi</label>
                                                                        <input type="text" name="e_sub_potensi"
                                                                            class="form-control"
                                                                            value="{{ $item->sub_potensi }}" required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Deskripsi</label>
                                                                        <textarea name="e_keterangan" class="form-control" rows="4" required>{{ $item->keterangan }}</textarea>
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
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    {{ $subpotensi->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
        </section>
    </main>

    <script>
        function validateAndPreview(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('image-preview');

            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert("Ukuran file melebihi 2 MB. Silakan pilih gambar lain.");
                    event.target.value = "";
                    preview.style.display = "none";
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = "block";
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = "#";
                preview.style.display = "none";
            }
        }
    </script>
@endsection
