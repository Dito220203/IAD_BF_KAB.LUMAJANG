@extends('components.layout')
@section('content')
<main id="main" class="main">
    <div class="pagetitle">
        <h1>Tabel KTH</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Beranda</li>
                <li class="breadcrumb-item">KTH</li>
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
                        @if (isset($kthEdit))
                            <h5 class="card-title">Update KTH</h5>
                           <form action="{{ route('kth.update', $kthEdit->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label class="form-label">Nama KTH</label>
                                    <input type="text" name="e_kth" class="form-control"
                                        value="{{ $kthEdit->kth }}" required>
                                 </div>

                                <div class="mb-3">
                                    <label class="form-label">Luas (Ha)</label>
                                    <input type="text" name="e_luas" class="form-control"
                                        value="{{ $kthEdit->luas }}" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Update</button>
                                <a href="{{ route('kth') }}" class="btn btn-secondary w-100 mt-2">Batal</a>
                            </form>
                        @else
                            <h5 class="card-title">Tambah KTH</h5>
                            <form action="{{route('kth.store')}}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="kth" class="form-label">Nama KTH</label>
                                    <input type="text" name="kth" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label for="luas" class="form-label">Luas (Ha)</label>
                                    <input type="text" name="luas" class="form-control" required>
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
                        <h5 class="card-title">Daftar KTH</h5>

                        <!-- Search -->
                        <div class="input-group mb-3 mt-3 w-auto">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari Data...">
                        </div>

                        <div class="table-responsive">
                            <table id="infoTable" class="table text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama KTH</th>
                                        <th>Luas (Ha)</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kth as $data)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $data->kth }}</td>
                                            <td>{{ $data->luas }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center gap-1">
                                                    <a href="{{ route('kth.edit', $data->id)}}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <form id="formDelete-{{ $data->id }}"
                                                        action="{{ route('kth.delete', $data->id)}}"
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
