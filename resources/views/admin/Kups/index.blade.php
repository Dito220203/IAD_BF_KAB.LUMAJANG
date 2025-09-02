@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel KUPS</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item active">KUPS</li>
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
                            @if (isset($kupsEdit))
                                <h5 class="card-title">Update KUPS</h5>
                                <form action="{{ route('kups.update', $kupsEdit->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label">Kelompok Tani Hutan (KTH)</label>
                                        <select name="id_kth" class="form-control" required>
                                            <option value="">-- Pilih KTH --</option>
                                            @foreach ($kth as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ $item->id == $kupsEdit->id_kth ? 'selected' : '' }}>
                                                    {{ $item->kth }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jenis Komoditas KUPS</label>
                                        <input type="text" name="e_kups" class="form-control"
                                            value="{{ $kupsEdit->kups }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="kategori" class="form-select" required>
                                            <option value="">Pilih</option>
                                            <option value="Biru"
                                                {{ old('kategori', $kupsEdit->kategori) == 'Biru' ? 'selected' : '' }}>Biru
                                            </option>
                                            <option value="Silver"
                                                {{ old('kategori', $kupsEdit->kategori) == 'Silver' ? 'selected' : '' }}>
                                                Silver</option>
                                            <option value="Emas"
                                                {{ old('kategori', $kupsEdit->kategori) == 'Emas' ? 'selected' : '' }}>Emas
                                            </option>
                                            <option value="Platinum"
                                                {{ old('kategori', $kupsEdit->kategori) == 'Platinum' ? 'selected' : '' }}>
                                                Platinum</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Tahun</label>
                                        <input type="text" name="e_tahun" class="form-control"
                                            value="{{ $kupsEdit->tahun }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jumlah Pendapatan</label>
                                        <input type="text" name="e_pendapatan" class="form-control"
                                            value="{{ $kupsEdit->pendapatan }}" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Update</button>
                                    <a href="{{ route('kups') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
                                </form>
                            @else
                                <h5 class="card-title">Tambah KUPS</h5>
                                <form action="{{ route('kups.store') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Kelompok Tani Hutan (KTH)</label>
                                        <select name="id_kth" class="form-select" required>
                                            <option value="">Pilih</option>
                                            @foreach ($kth as $data)
                                                <option value="{{ $data->id }}">{{ $data->kth }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jenis Komoditas KUPS</label>
                                        <input type="text" name="kups" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="kategori" class="form-select" required>
                                            <option value="">Pilih</option>
                                            <option value="Biru">Biru</option>
                                            <option value="Silver">Silver</option>
                                            <option value="Emas">Emas</option>
                                            <option value="Platinum">Platinum</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tahun</label>
                                        <input type="text" name="tahun" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jumlah Pendapatan</label>
                                        <input type="text" name="pendapatan" class="form-control" required>
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
                            <h5 class="card-title">Daftar KUPS</h5>

                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">

                                <!-- Entries -->
                                <div class="d-flex align-items-center gap-2">
                                    <label for="entries" class="form-label mb-0">Tampilkan</label>
                                    <select id="entries"
                                        class="form-select form-select-sm w-auto entriesSelect"data-target="TableKUPS">
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
                                    <input type="text" class="form-control searchInput" data-target="TableKUPS"
                                        placeholder="Cari Data...">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="TableKUPS" class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>KTH</th>
                                            <th>KUPS</th>
                                            <th>Tahun</th>
                                            <th>Pendapatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kups as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->kth->kth ?? '-' }}</td>
                                                <td>{{ $data->kups }}</td>
                                                <td>{{ $data->tahun }}</td>
                                                <td>{{ $data->pendapatan }}</td>
                                                <td>
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <a href="{{ route('kups.edit', $data->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="fa-solid fa-pen-to-square"></i>
                                                        </a>
                                                        <form id="formDelete-{{ $data->id }}"
                                                            action="{{ route('kups.delete', $data->id) }}"
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
    </main>
@endsection
