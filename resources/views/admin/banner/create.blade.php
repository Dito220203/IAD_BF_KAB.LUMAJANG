 @extends('components.layout')
 @section('content')
     <main id="main" class="main">

         <div class="pagetitle">
             <h1>Tambah Banner</h1>
             <nav>
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="index.html">Beranda</a></li>
                     <li class="breadcrumb-item">Banner</li>
                     <li class="breadcrumb-item active">Tambah Banner</li>
                 </ol>
             </nav>
         </div><!-- End Page Title -->

         <section class="section">
             <div class="row">
                 <div class="col-lg-12"> {{-- Ubah jadi full width jika butuh --}}
                     <div class="card">
                         <div class="card-body">
                             <div class="mb-3 mt-3">

                                 <form action="{{ route('banner.store') }}" method="POST" enctype="multipart/form-data">
                                     @csrf

                                     {{-- Judul Informasi --}}
                                     <div class="row mb-3">
                                         <label class="col-sm-2 col-form-label">Nama Banner</label>
                                         <div class="col-sm-10">
                                             <input type="text" name="judul" class="form-control" required>
                                         </div>
                                     </div>

                                     {{-- Status Informasi --}}
                                     <div class="row mb-3">
                                         <label class="col-sm-2 col-form-label">Status</label>
                                         <div class="col-sm-10">
                                             <select name="status" class="form-select" required>
                                                 <option value="Aktif">Aktif</option>
                                                 <option value="Non Aktif">Non Aktif</option>
                                             </select>
                                         </div>
                                     </div>

                                     {{-- Gambar Depan --}}
                                     <div class="row mb-3">
                                         <label class="col-sm-2 col-form-label">Gambar Depan</label>
                                         <div class="col-sm-10">
                                             <input type="file" name="image" class="form-control"
                                                 accept=".jpg,.jpeg,.png" onchange="previewImage(event)">

                                             {{-- Tempat preview gambar --}}
                                             <div class="mt-2">
                                                 <img id="image-preview" src="#" alt="Preview Gambar"
                                                     style="max-height: 120px; display: none; border: 1px solid #ccc; padding: 5px;">
                                             </div>
                                         </div>
                                     </div>



                                     {{-- Tombol --}}
                                     <div class="row mb-3">
                                         <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                             <button type="submit" class="btn btn-success">Simpan</button>
                                             <a href="{{ route('banner') }}" class="btn btn-warning">Kembali</a>
                                         </div>
                                     </div>

                                 </form>

                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </section>
     @endsection
