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
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">
                                    <h5 class="card-title">Tabel Sub Program</h5>
                                    <!-- Header control: Tambah, Search, Tampilkan Data -->
                                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">
                                        <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                                            data-bs-target="#modalSubProgram">
                                            + Tambah Sub Program
                                        </button>


                                        <!-- Modal Tambah Sub Program -->
                                        <div class="modal fade" id="modalSubProgram" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
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
                                                                <button type="submit"
                                                                    class="btn btn-primary">Simpan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- Pencarian -->
                                        <form method="GET" class="input-group w-auto mb-2">
                                            <input type="text" name="search_sub" class="form-control"
                                                placeholder="Cari Sub Program" value="{{ request('search_sub') }}">
                                            <button class="btn btn-primary" type="submit">Cari</button>
                                            @if (request('search_sub'))
                                                <a href="{{ route('subprogram') }}" class="btn btn-secondary">Reset</a>
                                            @endif
                                        </form>

                                    </div>
                                </div>
                                <!-- Table Sub Program -->
                                <div class="table-responsive">
                                    <table class="detail-table" id="TableSubprogram">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th class="text-center">Program</th>
                                                <th class="text-center">Sub Program</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($subprogram as $data)
                                                <tr>
                                                    <td class="text-center">{{ $subprogram->firstItem() + $loop->index }}
                                                    </td>
                                                    <td class="text-center">{{ $data->program }}</td>
                                                    <td class="text-center">{{ $data->subprogram }}</td>
                                                    <td class="text-center align-middle">
                                                        <div class="d-flex justify-content-center gap-1">
                                                            <!-- Detail -->
                                                            <button type="button" class="btn btn-info btn-sm"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#ModalDetailSub{{ $data->id }}">
                                                                <i class="fa-solid fa-circle-info"></i>
                                                            </button>
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
                                                    <div class="modal fade" id="Modalupdate{{ $data->id }}"
                                                        tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Edit Sub Program</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form
                                                                        action="{{ route('subprogram.update', $data->id) }}"
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
                                                                            <button type="button"
                                                                                class="btn btn-secondary"
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
                                <div class="mt-3">
                                    {{ $subprogram->links('vendor.pagination.bootstrap-5') }}
                                </div>
                                <!-- End Table Sub Program -->
                            </div>
                        </div>
                    </div>
                    @foreach ($subprogram as $data)
                        <!-- Modal Detail Sub Program -->
                        <div class="modal fade" id="ModalDetailSub{{ $data->id }}" tabindex="-1"
                            aria-labelledby="DetailSubLabel{{ $data->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-info text-white">
                                        <h5 class="modal-title" id="DetailSubLabel{{ $data->id }}">Detail Sub Program
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Program:</strong> {{ $data->program }}</p>
                                        <p><strong>Sub Program:</strong> {{ $data->subprogram }}</p>
                                        <p><strong>Uraian:</strong></p>
                                        <div class="border p-2 rounded bg-light">
                                            {!! nl2br(e($data->uraian)) !!}
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                    <!-- Kolom Produk -->
                    
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-3">

                                    <h5 class="card-title">Daftar Produk</h5>
                                    <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">
                                        <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                                            data-bs-target="#modalProduk">
                                            + Tambah Produk
                                        </button>

                                        <!-- Modal Tambah Produk -->
                                        <div class="modal fade" id="modalProduk" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
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
                                                                <input type="text" name="judul" class="form-control"
                                                                    required>
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
                                                                    <img id="previewFoto" src="#"
                                                                        alt="Preview Foto"
                                                                        style="max-width: 200px; display: none; border: 1px solid #ddd; padding: 5px;">
                                                                </div>
                                                            </div>
                                                            {{-- <script>
                                                                // Preview foto create
                                                                document.getElementById('fotoInput').addEventListener('change', function(e) {
                                                                    const file = e.target.files[0];
                                                                    if (!file) return;

                                                                    const maxSize = 2 * 1024 * 1024; // 2MB
                                                                    if (file.size > maxSize) {
                                                                        alert('Ukuran file terlalu besar! Maksimal 2MB.');
                                                                        e.target.value = '';
                                                                        document.getElementById('previewFoto').style.display = 'none';
                                                                        return;
                                                                    }

                                                                    const reader = new FileReader();
                                                                    reader.onload = function(event) {
                                                                        const img = document.getElementById('previewFoto');
                                                                        img.src = event.target.result;
                                                                        img.style.display = 'block';
                                                                    }
                                                                    reader.readAsDataURL(file);
                                                                });
                                                            </script> --}}
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

                                        <!-- Filter & Search Produk -->

                                        <form method="GET" class="input-group w-auto mb-2">
                                            <input type="text" name="search_produk" class="form-control"
                                                placeholder="Cari Produk" value="{{ request('search_produk') }}">
                                            <button class="btn btn-primary" type="submit">Cari</button>
                                            @if (request('search_produk'))
                                                <a href="{{ route('subprogram') }}" class="btn btn-secondary">Reset</a>
                                            @endif
                                        </form>

                                    </div>

                                </div>

                                <!-- Table Produk -->
                                <div class="table-container">
                                    <div class="top-scrollbar-container">
                                        <div class="top-scrollbar-content"></div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="TableProduk" class="detail-table">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Program</th>
                                                    <th>Judul</th>
                                                    {{-- <th>Keterangan</th> --}}
                                                    <th>Foto</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($produk as $data)
                                                    <tr>
                                                        <td>{{ $produk->firstItem() + $loop->index }}</td>
                                                        <td>{{ $data->subprogram->subprogram ?? '-' }}</td>
                                                        <td>{{ $data->judul }}</td>
                                                        {{-- <td>{{ $data->keterangan }}</td> --}}
                                                        <td>{{ $data->foto }}</td>
                                                        <td class="text-center align-middle">
                                                            <div class="d-flex justify-content-center gap-1">
                                                                <button type="button" class="btn btn-info btn-sm"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#ModalDetailProduk{{ $data->id }}">
                                                                    <i class="fa-solid fa-circle-info"></i>
                                                                </button>
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
                                            @foreach ($produk as $data)
                                                <!-- Modal Detail -->
                                                <div class="modal fade" id="ModalDetailProduk{{ $data->id }}"
                                                    tabindex="-1" aria-labelledby="DetailLabel{{ $data->id }}"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-info text-white">
                                                                <h5 class="modal-title"
                                                                    id="DetailLabel{{ $data->id }}">
                                                                    Detail Produk</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Program:</strong>
                                                                    {{ $data->subprogram->subprogram ?? '-' }}</p>
                                                                <p><strong>Judul:</strong> {{ $data->judul }}</p>
                                                                <p><strong>Keterangan:</strong> {{ $data->keterangan }}</p>
                                                                <p><strong>Foto:</strong></p>
                                                                @if ($data->foto)
                                                                    <img src="{{ asset('storage/' . $data->foto) }}"
                                                                        class="img-fluid rounded">
                                                                @else
                                                                    <span class="text-muted">Tidak ada foto</span>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-bs-dismiss="modal">Tutup</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </table>
                                    </div>
                                    <div class="mt-3">
                                        {{ $produk->links('vendor.pagination.bootstrap-5') }}
                                    </div>
                                    <!-- Modal Update Produk -->
                                    @foreach ($produk as $data)
                                        <div class="modal fade" id="ModalupdateProduk{{ $data->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Update Produk Subprogram</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('update.produk', $data->id) }}"
                                                            method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')

                                                            <!-- Pilih Sub Program -->
                                                            <div class="mb-3">
                                                                <label>Sub Program</label>
                                                                <select name="e_id_subprogram" class="form-select"
                                                                    required>
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
                                                                    id="fotoInput{{ $data->id }}"
                                                                    class="form-control" accept="image/*">
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
                                                                <button type="submit"
                                                                    class="btn btn-primary">Update</button>
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
            </section>
        </main>
    @endsection
    @push('scripts')
        <script>
            // Preview foto create
            document.getElementById('fotoInput').addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (!file) return;

                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar! Maksimal 2MB.');
                    e.target.value = '';
                    document.getElementById('previewFoto').style.display = 'none';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = document.getElementById('previewFoto');
                    img.src = event.target.result;
                    img.style.display = 'block';
                }
                reader.readAsDataURL(file);
            });
        </script>
    @endpush
