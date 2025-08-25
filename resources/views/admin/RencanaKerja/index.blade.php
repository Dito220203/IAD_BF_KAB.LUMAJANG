@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Rencana Kerja</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Beranda</a></li>
                    <li class="breadcrumb-item">Rencana Kerja</li>
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

                                <a href="{{ route('rencana.create') }}" class="btn btn-primary">
                                    + Tambah Rencana Kerja
                                </a>

                                <div class="d-flex align-items-center ">
                                    <label for="entries" class="form-label mb-0">Tampilkan</label>
                                    <select id="entries" class="form-select form-select-sm w-auto">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                    <span>data</span>
                                </div>

                                <div class="input-group w-auto">
                                    <input type="text" id="searchInput" class="form-control"
                                        placeholder="Cari informasi...">
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table .table-active  text-center" id="infoTable">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Judul</th>
                                            <th>Lokasi</th>
                                            {{-- <th>Tahun</th> --}}
                                            {{-- <th>Perangkat Daerah</th> --}}
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($rencana as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->judul }}</td>
                                                <td>{{ $data->lokasi }}</td>
                                                {{-- <td>{{ $data->tahun }}</td> --}}
                                                {{-- <td>{{ $data->anggaran }}</td> --}}
                                                {{-- <td>{{ $data->id_opd }}</td> --}}
                                                <td>
                                                    @if ($data->status === 'Valid')
                                                        <span class="badge bg-success">{{ $data->status }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $data->status }}</span>
                                                    @endif
                                                </td>

                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        @if (auth()->guard('pengguna')->user()->level == 'Super Admin')
                                                            <button
                                                                class="btn btn-sm {{ $data->status == 'Valid' ? 'btn-warning' : 'btn-success' }}"
                                                                onclick="updateStatus('{{ $data->id }}', '{{ $data->status }}')">
                                                                @if ($data->status == 'Valid')
                                                                    Batalkan
                                                                @else
                                                                    Validasi
                                                                @endif
                                                            </button>

                                                            <form id="form-status-{{ $data->id }}"
                                                                action="{{ route('rencana.validasi', $data->id) }}"
                                                                method="POST" style="display:none;">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="">
                                                            </form>
                                                        @endif
                                                        <form action="{{ route('rencana.show', $data->id) }}"
                                                            method="GET" style="display:inline;">
                                                            <button class="btn btn-info btn-sm" title="Lihat">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </button>
                                                        </form>


                                                        {{-- Tombol Edit --}}
                                                        <form action="{{ route('rencana.edit', $data->id) }}"
                                                            method="GET">
                                                            <button class="btn btn-primary btn-sm">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </button>
                                                        </form>

                                                        {{-- Tombol Delete --}}
                                                        <form id="formDelete-{{ $data->id }}"
                                                            action="{{ route('rencana.delete', $data->id) }}"
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

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
                <!-- Optional: JS untuk search sederhana -->
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
        </section>
    </main>
@endsection
