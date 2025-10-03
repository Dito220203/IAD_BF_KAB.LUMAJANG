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
                                             <th>Nama Program</th>
                                             <th class="text-center">Tahun</th>
                                             <th class="text-center">Status</th>
                                             <th class="text-center">Aksi</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @foreach ($progres as $data)
                                             <tr id="row-{{ $data->id }}">
                                                 <td>{{ $progres->firstItem() + $loop->index }}</td>
                                                 <td>{{ $data->monev->nama_program ?? '-' }}</td>
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

                                 <!-- Semua modal diletakkan di sini, setelah table -->
                                 @foreach ($progres as $data)
                                     <div class="modal fade" id="detailModal{{ $data->id }}" tabindex="-1"
                                         aria-labelledby="detailModalLabel{{ $data->id }}" aria-hidden="true">
                                         <div class="modal-dialog modal-lg modal-dialog-centered">
                                             <div class="modal-content">
                                                 <div class="modal-header">
                                                     <h5 class="modal-title" id="detailModalLabel{{ $data->id }}">
                                                         Detail Progres</h5>
                                                     <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                         aria-label="Close"></button>
                                                 </div>
                                                 <div class="modal-body">
                                                     <table class="table table-bordered">
                                                         <tr>
                                                             <th>Nama Program</th>
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
                                                             <th>Foto</th>
                                                             <td>
                                                                 @if ($data->monev && $data->monev->fotoProgres->count() > 0)
                                                                     @foreach ($data->monev->fotoProgres as $foto)
                                                                         <img src="{{ asset('storage/' . $foto->foto) }}"
                                                                             alt="Foto Progres"
                                                                             class="img-fluid rounded mb-2"
                                                                             style="max-height: 250px;">
                                                                     @endforeach
                                                                 @else
                                                                     <span class="text-muted">Belum ada foto</span>
                                                                 @endif
                                                             </td>
                                                         </tr>

                                                         <tr>
                                                             <th>Uraian</th>
                                                             <td>
                                                                 @if ($data->monev && $data->monev->fotoProgres->count() > 0)
                                                                     @foreach ($data->monev->fotoProgres as $foto)
                                                                         {{ $foto->deskripsi ?? '-' }}
                                                                     @endforeach
                                                                 @else
                                                                     <span class="text-muted">Belum ada Uraian</span>
                                                                 @endif
                                                             </td>
                                                         </tr>
                                                     </table>
                                                 </div>
                                                 <div class="modal-footer">
                                                     <button type="button" class="btn btn-secondary"
                                                         data-bs-dismiss="modal">Tutup</button>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 @endforeach

                                 {{-- <tbody>
                                         @foreach ($progres as $data)
                                             <tr id="row-{{ $data->id }}">
                                                 <td>{{ $progres->firstItem() + $loop->index }}</td>


                                                 <td class="text-center">{{ $data->monev->subprogram->subprogram ?? '-' }}
                                                 </td>


                                                 <td>
                                                     @if (!empty($data->monev->rencanaAksi->rencana_aksi))
                                                         {{ $data->monev->rencanaAksi->rencana_aksi }}
                                                     @elseif(!empty($data->monev->rencana_aksi))
                                                         {{ $data->rencanakerja->rencana_aksi ?? '-' }}
                                                     @else
                                                         -
                                                     @endif
                                                 </td>




                                                 <td>{{ $data->monev->sub_kegiatan ?? '-' }}</td>


                                                 <td>{{ $data->monev->kegiatan ?? '-' }}</td>


                                                 <td>{{ $data->monev->nama_program ?? '-' }}</td>
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


                                                         <!-- Tombol Detail -->
                                                         <button type="button" class="btn btn-info btn-sm" title="Lihat"
                                                             data-bs-toggle="modal"
                                                             data-bs-target="#detailModal{{ $data->id }}">
                                                             <i class="fa-solid fa-eye"></i>
                                                         </button>

                                                     </div>
                                                 </td>

                                             </tr>
                                         @endforeach
                                     </tbody> --}}
                                 </table>
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
