@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Gambaran Umum</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</a></li>
                    <li class="breadcrumb-item active">Gambaran Umum</li>
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
                                    data-bs-target="#modalGambaranUmum">
                                    + Tambah Gambaran
                                </button>
                                <!-- modal-gambaranUmum -->
                                <div class="modal fade" id="modalGambaranUmum" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Tambah Gambaran Umum</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ route('creategambaran') }}" method="POST">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label>Judul</label>
                                                        <input type="text" class="form-control" name="judul" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>uraian</label>
                                                        <textarea class="form-control" name="uraian" rows="4" required></textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label>Status</label>
                                                        <select name="status" class="form-select" required>
                                                            <option value="">Pilih</option>
                                                            <option value="Aktif">Aktif</option>
                                                            <option value="Non Aktif">Non Aktif</option>
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

                                
                         <div class="col-12 col-lg-auto">
     <form method="GET" class="input-group w-auto">
    <input type="text" name="search" class="form-control"
           placeholder="Cari Data"
           value="{{ request('search') }}">
    <button class="btn btn-primary" type="submit">Cari</button>
    @if(request('search'))
        <a href="{{ route('gambaran') }}" class="btn btn-secondary">Reset</a>
    @endif
</form>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="detail-table" id="Table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul Gambaran Umum</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($gambaran as $data)
                                            <tr>
                                                <td>{{ $gambaran->firstItem() + $loop->index }}</td>
                                                <td>{{ $data->judul }}</td>
                                                <td>
                                                    @if ($data->status === 'Aktif')
                                                        <span class="badge bg-success">{{ $data->status }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $data->status }}</span>
                                                    @endif
                                                </td>

                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#Modalupdate{{ $data->id }}">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </button>
                                                        <form id="formDelete-{{ $data->id }}"
                                                            action="{{ route('deletegambaran', $data->id) }}" method="POST"
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
                                                <div class="modal fade" id="Modalupdate{{ $data->id }}" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Update Gambaran Umum</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('updategambaran', $data->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="mb-3">
                                                                        <label>Judul</label>
                                                                        <input type="text" class="form-control"
                                                                            name="e_judul" value="{{ $data->judul }}"
                                                                            required>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Uraian</label>
                                                                        <textarea class="form-control" name="e_uraian" rows="4" required>{{ $data->uraian }}</textarea>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label>Status</label>
                                                                        <select name="e_status" class="form-select"
                                                                            required>
                                                                            <option value="Aktif"
                                                                                {{ $data->status == 'Aktif' ? 'selected' : '' }}>
                                                                                Aktif</option>
                                                                            <option value="Non Aktif"
                                                                                {{ $data->status == 'Non Aktif' ? 'selected' : '' }}>
                                                                                Non Aktif</option>
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
                             <div class="mt-3">
                                {{ $gambaran->links('vendor.pagination.bootstrap-5') }}
                            </div>
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
        </section>
    </main>
@endsection
