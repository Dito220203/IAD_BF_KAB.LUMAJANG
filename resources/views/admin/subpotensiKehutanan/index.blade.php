@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Potensi Kehutanan Sosial</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item active">Potensi Kehutanan Sosial</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <!-- Kolom Subpotensi Kehutanan -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Subpotensi Kehutanan</h5>
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                data-bs-target="#modalSubpotensi">
                                + Tambah Subpotensi
                            </button>

                            <!-- Modal Tambah Subpotensi -->
                            <div class="modal fade" id="modalSubpotensi" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah Subpotensi Kehutanan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('subpotensi.store') }}" method="POST">
                                                @csrf
                                                <div class="mb-3">
                                                    <label>Nama Subpotensi</label>
                                                    <input type="text" class="form-control" name="sub_potensi" required>
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
                                <table class="table table-bordered text-center" id="TablesubPotensi">
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
                                                <td>{{ $loop->iteration }}</td>
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
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
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

                        </div>
                    </div>
                </div>

                <!-- Kolom Potensi Kehutanan -->
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Potensi Kehutanan</h5>
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                data-bs-target="#modalPotensi">
                                + Tambah Potensi Kehutanan
                            </button>

                            <!-- Modal Tambah Potensi -->
                            <div class="modal fade" id="modalPotensi" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah Potensi Kehutanan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('potensikehutanan.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="mb-3">
                                                    <label>Subpotensi Terkait</label>
                                                    <select name="id_subpotensi" class="form-select" required>
                                                        <option value="">Pilih Subpotensi</option>
                                                        @foreach ($subpotensi as $sub)
                                                            <option value="{{ $sub->id }}">{{ $sub->sub_potensi }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Gambar</label>
                                                    <input type="file" name="gambar" class="form-control"
                                                        accept=".jpg,.jpeg,.png" onchange="validateAndPreview(event)">
                                                    <small class="text-muted">* Format jpeg, jpg atau png. Maks. 2
                                                        MB</small>
                                                    <div class="mt-2">
                                                        <img id="image-preview" src="#" alt="Preview Gambar"
                                                            style="max-height:120px; border:1px solid #ccc; padding:5px; display:none;">
                                                    </div>
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

                            <!-- Tabel Potensi Kehutanan-->
                            <div class="table-responsive">
                                <table class="table table-bordered text-center" id="TablepotensiKehutanan">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Subpotensi</th>
                                            <th>Gambar</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($potensi as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->SubpotensiKehutanan->sub_potensi ?? '-' }}</td>
                                                <td>
                                                    @if ($item->gambar)
                                                        <button type="button" class="btn btn-info btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalViewImage{{ $item->id }}">
                                                            Lihat
                                                        </button>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                @if ($item->gambar)
                                                    <div class="modal fade" id="modalViewImage{{ $item->id }}"
                                                        tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Preview Gambar</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"></button>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                    <img src="{{ asset('storage/' . $item->gambar) }}"
                                                                        alt="Gambar Potensi"
                                                                        style="max-width:100%; height:auto; border:1px solid #ccc; padding:5px;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                                <td>{{ $item->keterangan }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalEditPotensi{{ $item->id }}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                        <form id="formDeleteSub-{{ $item->id }}"
                                                            action="{{ route('potensikehutanan.delete', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-danger btn-sm"
                                                                onclick="confirmDeleteSub('{{ $item->id }}')">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal Edit Potensi -->
                                            <div class="modal fade" id="modalEditPotensi{{ $item->id }}"
                                                tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Potensi Kehutanan</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('potensikehutanan.update', $item->id) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label>Subpotensi Terkait</label>
                                                                    <select name="id_subpotensi" class="form-select"
                                                                        required>
                                                                        @foreach ($subpotensi as $sub)
                                                                            <option value="{{ $sub->id }}"
                                                                                {{ $item->id_subpotensi == $sub->id ? 'selected' : '' }}>
                                                                                {{ $sub->sub_potensi }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label>Gambar</label>
                                                                    <input type="file" name="e_gambar"
                                                                        class="form-control" accept=".jpg,.jpeg,.png"
                                                                        onchange="previewEditImage(event, {{ $item->id }})">
                                                                </div>

                                                                @if ($item->gambar)
                                                                    <div class="mb-3">
                                                                        <label>Preview Gambar Lama</label><br>
                                                                        <img id="edit-image-preview-{{ $item->id }}"
                                                                            src="{{ asset('storage/' . $item->gambar) }}"
                                                                            alt="Preview Lama"
                                                                            style="max-height:120px; border:1px solid #ccc; padding:5px;">
                                                                    </div>
                                                                @else
                                                                    <img id="edit-image-preview-{{ $item->id }}"
                                                                        style="display:none; max-height:120px; border:1px solid #ccc; padding:5px;">
                                                                @endif
                                                                <script>
                                                                    function previewEditImage(event, id) {
                                                                        const file = event.target.files[0];
                                                                        const preview = document.getElementById('edit-image-preview-' + id);

                                                                        if (file) {
                                                                            if (file.size > 2 * 1024 * 1024) {
                                                                                alert("Ukuran file melebihi 2 MB. Silakan pilih gambar lain.");
                                                                                event.target.value = "";
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

                                                                <div class="mb-3">
                                                                    <label>Deskripsi</label>
                                                                    <textarea name="e_keterangan" class="form-control" required>{{ $item->keterangan }}</textarea>
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
