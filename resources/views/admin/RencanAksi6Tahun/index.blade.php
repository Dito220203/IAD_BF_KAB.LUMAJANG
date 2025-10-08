@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Rencana Aksi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item active">Rencana Aksi</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <!-- Header tools -->
                            <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">
                                <div class="gap-2">
                                    <!-- Left side buttons - Only for Super Admin -->
                                    @if (Auth::guard('pengguna')->user()->level === 'Super Admin')
                                        <div class="d-flex flex-column flex-sm-row gap-2">
                                            <a href="{{ route('rencanaAksi.create') }}" class="btn btn-primary">
                                                <i class="fa-solid fa-plus me-1"></i>
                                                Tambah Rencana Aksi
                                            </a>
                                            <a href="{{ route('rencanaAksi.export.excel') }}" class="btn btn-success">
                                                <i class="fa-solid fa-file-excel me-1"></i>
                                                Export Excel
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <!-- Right side search -->
                                <div class="search-container" style="min-width: 300px;">
                                    <form method="GET" class="d-flex gap-3">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Cari program, kegiatan, OPD..." value="{{ request('search') }}"
                                                style="min-width: 250px;">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fa-solid fa-search"></i>
                                            </button>
                                        </div>
                                        @if (request('search'))
                                            <a href="{{ route('rencana6tahun') }}" class="btn btn-outline-secondary">
                                                <i class="fa-solid fa-times"></i>
                                            </a>
                                        @endif
                                    </form>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-container">
                                <div class="top-scrollbar-container">
                                    <div class="top-scrollbar-content"></div>
                                </div>
                                <div class="table-responsive">
                                    <table class="detail-table" id="TableRencanaAksi" style="min-width: 1800px;">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px;">No</th>
                                                <th style="width: 200px;">Sub Program</th>
                                                <th style="width: 300px;">Rencana Aksi / Aktivitas</th>
                                                <th style="width: 250px;">Nama Program</th>
                                                <th style="width: 300px;">Kegiatan</th>
                                                <th style="width: 300px;">Sub Kegiatan</th>
                                                <th style="width: 100px;">Tahun</th>
                                                <th style="width: 150px;">Lokasi</th>
                                                <th style="width: 100px;">Volume</th>
                                                <th style="width: 100px;">Satuan</th>
                                                <th style="width: 150px;">Anggaran</th>
                                                <th style="width: 150px;">Sumber Dana</th>
                                                <th style="width: 300px;">Perangkat Daerah</th>
                                                <th style="width: 300px;">Keterangan</th>
                                                @if (Auth::guard('pengguna')->user()->level === 'Super Admin')
                                                    <th style="width: 120px;">Aksi</th>
                                                @endif

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($rencanaAksi as $data)
                                                <tr>
                                                    <td class="text-center">{{ $rencanaAksi->firstItem() + $loop->index }}
                                                    </td>
                                                    <td class="text-center">{{ $data->subprogram->subprogram ?? '-' }}</td>
                                                    <td>{{ $data->rencana_aksi }}</td>
                                                    <td>{{ $data->nama_program }}</td>
                                                    <td>{{ $data->kegiatan }}</td>
                                                    <td>{{ $data->sub_kegiatan }}</td>
                                                    <td>{{ $data->tahun }}</td>
                                                    <td>{{ $data->lokasi }}</td>
                                                    <td>{{ $data->volume }}</td>
                                                    <td>{{ $data->satuan }}</td>
                                                    <td>{{ $data->anggaran }}</td>
                                                    <td>{{ $data->sumberdana }}</td>
                                                    <td>{{ $data->opd->nama ?? '-' }}</td>
                                                    <td>{{ $data->keterangan ?? '-' }}</td>
                                                    <td>
                                                        @if (Auth::guard('pengguna')->user()->level === 'Super Admin')
                                                            <div class="d-flex justify-content-center gap-1">
                                                                <a href="{{ route('rencanaAksi.edit', $data->id) }}"
                                                                    class="btn btn-primary btn-sm" title="Edit">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <form id="formDelete-{{ $data->id }}"
                                                                    action="{{ route('rencanaAksi.destroy', $data->id) }}"
                                                                    method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="button" class="btn btn-danger btn-sm"
                                                                        onclick="confirmDelete('{{ $data->id }}')">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @endif
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="mt-3">
                                    {{ $rencanaAksi->links('vendor.pagination.bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
 @push('scripts')
     <script>
         document.addEventListener('DOMContentLoaded', function() {
             // Cari semua kontainer tabel di halaman
             const allTableContainers = document.querySelectorAll('.table-container');

             allTableContainers.forEach(container => {
                 const topScrollbar = container.querySelector('.top-scrollbar-container');
                 const topScrollbarContent = container.querySelector('.top-scrollbar-content');
                 const tableWrapper = container.querySelector('.table-responsive');
                 const table = container.querySelector('.detail-table');

                 // Jika salah satu elemen tidak ditemukan, hentikan untuk kontainer ini
                 if (!topScrollbar || !tableWrapper || !table) {
                     return;
                 }

                 let isSyncing = false;

                 // 1. Atur lebar konten palsu agar sama dengan lebar tabel asli
                 //    Ini akan membuat scrollbar atas muncul jika tabelnya lebar
                 function updateTopScrollbarWidth() {
                     if (table.scrollWidth > tableWrapper.clientWidth) {
                         topScrollbarContent.style.width = table.scrollWidth + 'px';
                         topScrollbar.style.display = 'block'; // Tampilkan jika perlu
                     } else {
                         topScrollbar.style.display = 'none'; // Sembunyikan jika tidak perlu
                     }
                 }

                 // 2. Sinkronkan scroll dari atas ke bawah
                 topScrollbar.addEventListener('scroll', function() {
                     if (isSyncing) return;
                     isSyncing = true;
                     tableWrapper.scrollLeft = topScrollbar.scrollLeft;
                     isSyncing = false;
                 });

                 // 3. Sinkronkan scroll dari bawah ke atas
                 tableWrapper.addEventListener('scroll', function() {
                     if (isSyncing) return;
                     isSyncing = true;
                     topScrollbar.scrollLeft = tableWrapper.scrollLeft;
                     isSyncing = false;
                 });

                 // Panggil pertama kali saat halaman dimuat
                 updateTopScrollbarWidth();

                 // Panggil lagi jika ukuran window berubah (misal: rotasi HP)
                 window.addEventListener('resize', updateTopScrollbarWidth);
             });
         });
     </script>
 @endpush

