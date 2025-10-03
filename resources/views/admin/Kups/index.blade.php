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
                                        <select name="e_kategori" class="form-select" required>
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
                                        <input type="text" name="e_pendapatan" id="e_pendapatan" class="form-control"
                                            value="{{ old('e_pendapatan', $kupsEdit->pendapatan) }}" required>
                                    </div>

                                    <script>
                                        const pendapatanUpdateInput = document.getElementById('e_pendapatan');
                                        const form = document.querySelector('form');

                                        // Format value awal saat halaman dibuka
                                        if (pendapatanUpdateInput.value) {
                                            let numeric = pendapatanUpdateInput.value.replace(/\D/g, '');
                                            if (numeric) {
                                                numeric = parseInt(numeric).toLocaleString('id-ID');
                                                pendapatanUpdateInput.value = 'Rp. ' + numeric;
                                            }
                                        }


                                        // Format saat user mengetik
                                        pendapatanUpdateInput.addEventListener('input', function() {
                                            let raw = this.value;

                                            // Kalau hanya angka → diformat
                                            if (/^\d+$/.test(raw.replace(/\./g, ''))) {
                                                let value = raw.replace(/\D/g, ''); // ambil angka
                                                if (value) {
                                                    value = parseInt(value).toLocaleString('id-ID'); // format ribuan
                                                    this.value = 'Rp. ' + value;
                                                }
                                            }
                                            // Kalau teks → biarkan apa adanya
                                        });
                                    </script>

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
                                        <input type="text" name="pendapatan" id="pendapatan" class="form-control"
                                            required>
                                    </div>

                                    <script>
                                        const pendapatanCreateInput = document.getElementById('pendapatan');
                                        const form = document.querySelector('form');

                                        // Format saat user mengetik
                                        pendapatanCreateInput.addEventListener('input', function() {
                                            let raw = this.value;

                                            // Kalau isinya angka → diformat Rp
                                            if (/^\d+$/.test(raw.replace(/\./g, ''))) {
                                                let value = raw.replace(/\D/g, ''); // ambil angka saja
                                                if (value) {
                                                    value = parseInt(value).toLocaleString('id-ID'); // format ribuan
                                                    this.value = 'Rp. ' + value;
                                                }
                                            }
                                            // Kalau teks → biarkan apa adanya (tidak diformat)
                                        });
                                    </script>

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
                                <!-- Search -->
                                <div class="col-12 col-lg-auto">
                                    <!-- Pencarian -->
                                    <form method="GET" class="input-group w-auto mb-3">
                                        <input type="text" name="search" class="form-control" placeholder="Cari Data"
                                            value="{{ request('search') }}">
                                        <button class="btn btn-primary" type="submit">Cari</button>
                                        @if (request('search'))
                                            <a href="{{ route('kups') }}" class="btn btn-secondary">Reset</a>
                                        @endif
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="TableKUPS" class="detail-table">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>KTH</th>
                                            <th>KUPS</th>
                                            <th>Tahun</th>
                                            <th>Kategori</th>
                                            <th>Pendapatan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kups as $data)
                                            <tr>
                                                <td>{{ $kups->firstItem() + $loop->index }}</td>
                                                <td>{{ $data->kth->kth ?? '-' }}</td>
                                                <td>{{ $data->kups }}</td>
                                                <td>{{ $data->tahun }}</td>
                                                <td>{{ $data->kategori }}</td>
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
                            <div class="mt-3">
                                {{ $kups->links('vendor.pagination.bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>
@endsection
