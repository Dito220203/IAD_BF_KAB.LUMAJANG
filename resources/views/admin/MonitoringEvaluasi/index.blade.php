@extends('components.layout')
@section('content')
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Tabel Monitoring Evaluasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
                    <li class="breadcrumb-item active">Monitoring Evaluasi</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card ">
                        <div class="card-body">
                            <!-- Header control: Tambah, Search, Tampilkan Data -->
                            <div class="row g-3 align-items-center mb-4 mt-3">
                                <!-- Tambah Button -->
                                <div class="col-12 col-lg-auto">
                                    <a href="{{ route('monev.create') }}" class="btn btn-primary w-100 w-lg-auto">
                                        <i class="fas fa-plus me-2"></i>Tambah Monitoring Evaluasi
                                    </a>
                                </div>

                                <!-- Export Button -->
                                <div class="col-12 col-lg-auto">
                                    <a href="{{ route('monev.export', ['tahun' => request('tahun'), 'triwulan' => request('triwulan')]) }}"
                                        class="btn btn-danger w-100 w-lg-auto">
                                        <i class="fas fa-file-pdf me-2"></i>Export PDF
                                    </a>
                                </div>


                                <!-- Filter Controls -->
                                <div class="col-12">
                                    <form method="GET" action="{{ route('monev') }}" class="row g-2">
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <label for="tahun" class="form-label small mb-1">Tahun</label>
                                            <select name="tahun" id="tahun" class="form-select"
                                                onchange="this.form.submit()">
                                                <option value="">Semua</option>
                                                @foreach ($tahun_list as $tahun)
                                                    <option value="{{ $tahun }}"
                                                        {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                                        {{ $tahun }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <label for="triwulan" class="form-label small mb-1">Triwulan</label>
                                            <select name="triwulan" id="triwulan" class="form-select"
                                                onchange="this.form.submit()">
                                                <option value="">Semua</option>
                                                <option value="1" {{ request('triwulan') == 1 ? 'selected' : '' }}>
                                                    Triwulan 1 (Jan-Mar)
                                                </option>
                                                <option value="2" {{ request('triwulan') == 2 ? 'selected' : '' }}>
                                                    Triwulan 2 (Apr-Jun)
                                                </option>
                                                <option value="3" {{ request('triwulan') == 3 ? 'selected' : '' }}>
                                                    Triwulan 3 (Jul-Sep)
                                                </option>
                                                <option value="4" {{ request('triwulan') == 4 ? 'selected' : '' }}>
                                                    Triwulan 4 (Okt-Des)
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <label class="form-label small mb-1">Pencarian</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i class="fas fa-search"></i>
                                                </span>
                                                <input type="text" class="form-control searchInput"
                                                    data-target="TableMonev" placeholder="Cari monitoring evaluasi...">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="detail-table" id="TableMonev" style="min-width: 2000px;">
                                    @php
                                        $adaPesan = $monev->contains(function ($item) {
                                            return !empty($item->pesan);
                                        });
                                    @endphp
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="text-center">Sub Program</th>
                                            <th class="text-center">Rencana Aksi/Aktivitas</th>
                                            <th class="text-center">Sub Kegiatan</th>
                                            <th class="text-center">Kegiatan</th>
                                            <th class="text-center">Nama Program</th>
                                            <th class="text-center">Lokasi</th>
                                            <th class="text-center">Volume</th>
                                            <th class="text-center">Satuan</th>
                                            <th class="text-center">Anggaran</th>
                                            <th class="text-center">Sumber Dana</th>
                                            <th class="text-center">Tahun</th>
                                            <th class="text-center">Perangkat Daerah</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Input RKA</th>
                                            <th class="text-center">Realisasi</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center kolom-keterangan">Keterangan</th>
                                            @if ($adaPesan)
                                                <th class="text-center">Catatan</th>
                                            @endif
                                            <th class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($monev as $data)
                                            <tr id="row-{{ $data->id }}">
                                                <td class="text-center">{{ $monev->firstItem() + $loop->index }}</td>
                                                <td class="text-center">{{ $data->subprogram->subprogram ?? '-' }}</td>
                                                <td>{{ $data->rencanakerja->rencana_aksi ?? '-' }}</td>
                                                <td>{{ $data->sub_kegiatan }}</td>
                                                <td>{{ $data->kegiatan }}</td>
                                                <td>{{ $data->nama_program }}</td>
                                                <td class="text-center">{{ $data->lokasi }}</td>
                                                <td class="text-center">{{ $data->volume }}</td>
                                                <td class="text-center">{{ $data->satuan }}</td>
                                                <td class="text-center">{{ $data->anggaran }}</td>
                                                <td class="text-center">{{ $data->sumberdana }}</td>
                                                <td class="text-center">{{ $data->tahun }}</td>
                                                <td class="text-center" class="text-center">{{ $data->opd->nama ?? '-' }}
                                                </td>


                                                <td class="text-center">
                                                    @if ($data->status === 'Valid')
                                                        <span class="badge bg-success">{{ $data->status }}</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $data->status }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($data->rka === 'sudah')
                                                        <span class="badge bg-success">{{ $data->rka }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ $data->rka }}</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">{{ $data->realisasi }}</td>
                                                <td class="text-center">{{ $data->tanggal }}</td>
                                                <td>{{ $data->keterangan }}</td>
                                                @if ($adaPesan)
                                                    <td>{{ $data->pesan }}</td>
                                                @endif

                                                <td class="text-center align-middle">
                                                    <div class="d-flex justify-content-center gap-1">
                                                        <form id="form-lanjut-{{ $data->id }}"
                                                            action="{{ route('monev.lanjut', $data->id) }}"
                                                            method="POST" style="display:inline;">
                                                            @csrf
                                                            <button type="button"
                                                                class="btn btn-secondary btn-sm btn-lanjut"
                                                                data-id="{{ $data->id }}">
                                                                Lanjut
                                                            </button>
                                                        </form>


                                                        <form action="{{ route('monev.edit', $data->id) }}"
                                                            method="GET">
                                                            <button class="btn btn-primary btn-sm">
                                                               Edit/Lengkapi
                                                            </button>
                                                        </form>

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
                                                                action="{{ route('monev.validasi', $data->id) }}"
                                                                method="POST" style="display:none;">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="status" value="">
                                                            </form>
                                                             <button type="button" class="btn btn-info btn-sm"
                                                                data-bs-toggle="modal" data-bs-target="#modalPesan"
                                                                data-id="{{ $data->id }}"
                                                                data-pesan="{{ $data->pesan ?? '' }}">
                                                                <i class="fa-solid fa-envelope"></i>
                                                            </button>
                                                        @endif



                                                        {{-- Tombol Delete --}}
                                                        <form id="formDelete-{{ $data->id }}"
                                                            action="{{ route('monev.delete', $data->id) }}"
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
                                <!-- Modal Pesan (satu saja, di luar foreach) -->
                                <div class="modal fade" id="modalPesan" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form id="formPesan" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id_monev" id="idMonev">

                                                <div class="modal-header">
                                                    <h5 class="modal-title">Kirim Catatan ke Admin Perangkat Daerah</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Catatan</label>
                                                        <textarea name="pesan" id="inputPesan" class="form-control" rows="4"></textarea>
                                                    </div>
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
                                <script>
                                    document.addEventListener("DOMContentLoaded", function() {
                                        var modalPesan = document.getElementById('modalPesan');
                                        modalPesan.addEventListener('show.bs.modal', function(event) {
                                            var button = event.relatedTarget;
                                            var idMonev = button.getAttribute('data-id');
                                            var pesan = button.getAttribute('data-pesan') || '';

                                            // isi hidden input
                                            modalPesan.querySelector('#idMonev').value = idMonev;

                                            // isi textarea dengan pesan lama (kalau ada)
                                            modalPesan.querySelector('#inputPesan').value = pesan;

                                            // set action form ke route updatePesan
                                            var form = modalPesan.querySelector('#formPesan');
                                            form.action = "/monev/" + idMonev + "/pesan";
                                        });
                                    });
                                </script>


                            </div>
                            <div class="mt-3">
                                {{ $monev->links('vendor.pagination.bootstrap-5') }}
                            </div>

                            <!-- End Table -->
                        </div>
                    </div>
                </div>
        </section>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var modalPesan = document.getElementById('modalPesan');
            modalPesan.addEventListener('show.bs.modal', function(event) {
                var button = event.relatedTarget;
                var idMonev = button.getAttribute('data-id');
                modalPesan.querySelector('#idMonev').value = idMonev;
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-lanjut').forEach(function(button) {
                button.addEventListener('click', function() {
                    let id = this.getAttribute('data-id');
                    let form = document.getElementById('form-lanjut-' + id);

                    Swal.fire({
                        title: 'Yakin mau lanjut Ke Triwulan Selanjutnya ?',
                        text: "Pastikan data sudah benar sebelum dilanjutkan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, lanjutkan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection

