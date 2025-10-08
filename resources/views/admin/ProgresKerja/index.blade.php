@extends('components.layout')
 @section('content')
     <main id="main" class="main">
         <div class="pagetitle">
             <h1>Tabel Progres</h1>
             <nav>
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item">Beranda</a></li>
                     <li class="breadcrumb-item active">Progres Kerja</li>
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

                                 <form method="GET" class="input-group w-auto mb-1">
                                     <input type="text" name="search" class="form-control" placeholder="Cari Data"
                                         value="{{ request('search') }}">
                                     <button class="btn btn-primary" type="submit">Cari</button>
                                     @if (request('search'))
                                         <a href="{{ route('progres') }}" class="btn btn-secondary">Reset</a>
                                     @endif
                                 </form>

                             </div>

                             <!-- Table -->
                             <div class="table-responsive">
                                 <table class="detail-table" id="TableProgres">
                                     <thead>
                                         <tr>
                                             <th>No</th>
                                             {{-- <th class="text-center" style="width: 30px;">Sub Program</th> --}}
                                             {{-- <th style="width: 100px;">Rencana Aksi / Aktivitas</th>
                                             <th style="width: 100px;">Sub Kegiatan</th>
                                             <th style="width: 100px;">Kegiatan</th> --}}
                                             <th>Rencana Aksi / Aktivitas</th>
                                             <th class="text-center">Tahun</th>
                                             <th class="text-center">Status</th>
                                             <th class="text-center">Aksi</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @foreach ($progres as $data)
                                             <tr id="row-{{ $data->id }}">
                                                 <td>{{ $progres->firstItem() + $loop->index }}</td>
                                                 <td>
                                                     {{-- Panggil relasi 'rencanakerja', lalu kolom 'rencana_aksi' dari tabel RencanaKerja --}}
                                                     {{ $data->monev?->rencanakerja?->rencana_aksi ?? '-' }}
                                                 </td>
                                                 <td class="text-center">{{ $data->monev->tahun ?? '-' }}</td>
                                                 <td class="text-center">
                                                     @if ($data->status === 'Valid')
                                                         <span class="badge bg-success">{{ $data->status }}</span>
                                                     @else
                                                         <span class="badge bg-secondary">{{ $data->status }}</span>
                                                     @endif
                                                 </td>
                                                 <td class="text-center align-middle">
                                                     <div class="d-flex justify-content-center gap-1">
                                                         <!-- Tombol Detail -->
                                                         <button type="button" class="btn btn-info btn-sm" title="Lihat"
                                                             data-bs-toggle="modal"
                                                             data-bs-target="#detailModal{{ $data->id }}">
                                                             <i class="fa-solid fa-eye"></i>
                                                         </button>

                                                         @if (auth()->guard('pengguna')->user()->level == 'Super Admin')
                                                             <button
                                                                 class="btn btn-sm {{ $data->status == 'Valid' ? 'btn-warning' : 'btn-success' }}"
                                                                 onclick="updateStatus('{{ $data->id }}', '{{ $data->status }}')">
                                                                 @if ($data->status == 'Valid')
                                                                     Batalkan Validasi
                                                                 @else
                                                                     Validasi
                                                                 @endif
                                                             </button>

                                                             <form id="form-status-{{ $data->id }}"
                                                                 action="{{ route('progres.updateStatus', $data->id) }}"
                                                                 method="POST" style="display:none;">
                                                                 @csrf
                                                                 @method('PUT')
                                                                 <input type="hidden" name="status" value="">
                                                             </form>
                                                         @endif
                                                     </div>
                                                 </td>
                                             </tr>
                                         @endforeach
                                     </tbody>
                                 </table>
                                 <!-- End Table -->

                                 {{-- Ganti @foreach yang lama dengan ini --}}
@foreach ($progres as $data)
    <div class="modal fade" id="detailModal{{ $data->id }}" tabindex="-1"
         aria-labelledby="detailModalLabel{{ $data->id }}" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered"> {{-- Ubah menjadi modal-xl --}}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel{{ $data->id }}">
                        Detail Progres
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Gunakan sistem grid Bootstrap --}}
                    <div class="row">

                        <div class="col-lg-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%;">Nama Program</th>
                                    <td>{{ $data->monev->nama_program ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Tahun</th>
                                    <td>{{ $data->monev->tahun ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>{{ $data->status }}</td>
                                </tr>
                                <tr>
                                    <th>Uraian</th>
                                    <td>
                                        @if($data->monev && $data->monev->fotoProgres->isNotEmpty())
                                            {{ $data->monev->fotoProgres->first()->deskripsi ?? 'Tidak ada uraian.' }}
                                        @else
                                            <span class="text-muted">Tidak ada uraian</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Foto</th>
                                    <td>
                                        @if ($data->monev && $data->monev->fotoProgres->isNotEmpty())
                                            <div class="row">
                                                @foreach ($data->monev->fotoProgres as $foto)
                                                    <div class="col-6 mb-2">
                                                        <a href="{{ asset('storage/' . $foto->foto) }}" target="_blank">
                                                            <img src="{{ asset('storage/' . $foto->foto) }}"
                                                                 alt="Foto Progres" class="img-fluid rounded">
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-muted">Belum ada foto</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="col-lg-6">
                            <h6 class="mb-2">Lokasi Peta</h6>
                            @if($data->monev && $data->monev->map)
                                <div id="detailMapProgres{{ $data->id }}"
                                     class="detail-map-container"
                                     style="height: 100%; min-height: 400px; width: 100%; border-radius: 8px; z-index: 0;"
                                     data-latitude="{{ $data->monev->map->latitude }}"
                                     data-longitude="{{ $data->monev->map->longitude }}">
                                </div>
                            @else
                                <div class="alert alert-light text-center p-2 h-100 d-flex align-items-center justify-content-center">
                                    Lokasi belum ditandai.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

                                 <!-- End Table with stripped rows -->

                             </div>
                             <div class="mt-3">
                                 {{ $progres->links('vendor.pagination.bootstrap-5') }}
                             </div>
                         </div>

                     </div>
                 </div>
             </div>
         </section>
     </main>
 @endsection
 @push('scripts')
    {{-- Pastikan library Leaflet sudah dimuat di layout utama atau di sini --}}
    {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> --}}

    <script>
        // Event listener ini akan berjalan untuk SEMUA modal di halaman
        document.addEventListener('shown.bs.modal', function(event) {
            // Cari kontainer peta di dalam modal yang BARU SAJA DIBUKA
            const modal = event.target;
            const mapContainer = modal.querySelector('.detail-map-container');

            // Jika tidak ada kontainer peta di modal ini, atau peta sudah dibuat, hentikan
            if (!mapContainer || mapContainer._leaflet_id) {
                return;
            }

            const lat = mapContainer.dataset.latitude;
            const lng = mapContainer.dataset.longitude;
            const mapId = mapContainer.id;

            // Inisialisasi peta dalam mode 'view-only'
            const detailMap = L.map(mapId, {
                center: [lat, lng],
                zoom: 15,
                scrollWheelZoom: false, // Matikan zoom scroll
                dragging: false,        // Matikan drag
                zoomControl: true       // Tampilkan kontrol zoom +/-
            });

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(detailMap);

            // Tambahkan penanda yang tidak bisa digeser
            L.marker([lat, lng]).addTo(detailMap);

            // Penting: Sesuaikan ukuran peta setelah modal tampil
            setTimeout(function() {
                detailMap.invalidateSize();
            }, 200);
        });
    </script>
@endpush