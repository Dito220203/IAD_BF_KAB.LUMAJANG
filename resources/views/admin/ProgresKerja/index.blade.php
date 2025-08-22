 @extends('components.layout')
 @section('content')
     <main id="main" class="main">
         <div class="pagetitle">
             <h1>Tabel Progres</h1>
             <nav>
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="index.html">Beranda</a></li>
                     <li class="breadcrumb-item">Progres Kerja</li>
                 </ol>
             </nav>
         </div>
         <section class="section">
             <div class="row">
                 <div class="col-lg-12">

                     <div class="card">
                         <div class="card-body">
                             <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-3 mt-3">
                                 <a href="{{ route('progrescreate') }}" class="btn btn-primary">
                                     + Tambah Progres
                                 </a>

                                 <div class="d-flex align-items-center gap-2">
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
                                 <table class="table .table-active text-center" id="infoTable">
                                     <thead>
                                         <tr>
                                             <th>
                                                 No
                                             </th>
                                             <th>Sub Program</th>
                                             <th>Judul</th>
                                             <th data-type="date">Tahun</th>
                                             <th>Status</th>
                                             <th>Aksi</th>
                                         </tr>
                                     </thead>
                                     <tbody>
                                         @foreach ($progres as $data)
                                             <tr>
                                                 <td>{{ $loop->iteration }}</td>
                                                 <td>{{ $data->subprogram->subprogram ?? '-' }}</td>

                                                 <td>{{ $data->judul }}</td>
                                                 <td>{{ $data->tahun }}</td>
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
                                                                     <i class="fa-solid fa-xmark"></i> Batalkan Validasi
                                                                 @else
                                                                     <i class="fa-solid fa-check"></i> Validasi
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


                                                         <form action="{{ route('progres.show', $data->id) }}"
                                                             method="GET" style="display:inline;">
                                                             <button class="btn btn-info btn-sm" title="Lihat">
                                                                 <i class="fa-solid fa-eye"></i>
                                                             </button>
                                                         </form>
                                                         <form action="{{ route('progres.edit', $data->id) }}"
                                                             method="GET">
                                                             <button class="btn btn-primary btn-sm">
                                                                 <i class="fa-solid fa-pen-to-square"></i>
                                                             </button>
                                                         </form>
                                                         <form id="formDelete-{{ $data->id }}"
                                                             action="{{ route('progres.delete', $data->id) }}"
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
                                 <!-- End Table with stripped rows -->

                             </div>
                         </div>

                     </div>
                 </div>
             </div>
         </section>
     </main>
 @endsection
