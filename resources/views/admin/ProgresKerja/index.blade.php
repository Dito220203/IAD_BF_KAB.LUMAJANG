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
                             <div class="d-flex flex-column flex-md-row justify-content-between gap-5 mb-3 mt-3">
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
                                 <table class="table table-bordered" id="infoTable">
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
                                         <tr>
                                             <td>Unity Pugh</td>
                                             <td>9958</td>
                                             <td>Curicó</td>
                                             <td>2005/02/11</td>
                                             <td>37%</td>
                                             <td class="text-center align-middle">
                                                 <div class="d-flex justify-content-center gap-1">
                                                     <form action="">
                                                         <button class="btn btn-primary btn-sm">
                                                             <i class="fa-solid fa-pen-to-square"></i>
                                                         </button>
                                                     </form>
                                                     <form action="">
                                                         <button class="btn btn-danger btn-sm">
                                                             <i class="fa-solid fa-trash"></i>
                                                         </button>
                                                     </form>
                                                 </div>
                                             </td>

                                         </tr>
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
