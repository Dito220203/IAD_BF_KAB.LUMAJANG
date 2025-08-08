 @extends('components.layout')
 @section('content')
     <main id="main" class="main">

         <div class="pagetitle">
             <h1>Update Banner</h1>
             <nav>
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="index.html">Beranda</a></li>
                     <li class="breadcrumb-item">Banner</li>
                     <li class="breadcrumb-item active">Update Banner</li>
                 </ol>
             </nav>
         </div><!-- End Page Title -->

         <section class="section">
             <div class="row">
                 <div class="col-lg-12"> {{-- Ubah jadi full width jika butuh --}}
                     <div class="card">
                         <div class="card-body">
                             <div class="mb-3 mt-3">

                                 <form action="{{ route('update.banner', $banner->id) }}" method="POST"
                                     enctype="multipart/form-data">
                                     @csrf
                                     @method('PUT') <!-- penting untuk method PUT -->

                                     {{-- Judul Informasi --}}
                                     <div class="row mb-3">
                                         <label class="col-sm-2 col-form-label">Nama Banner</label>
                                         <div class="col-sm-10">
                                             <input type="text" name="e_judul" value="{{ $banner->judul }}"
                                                 class="form-control" required>
                                         </div>
                                     </div>

                                     {{-- Status Informasi --}}
                                     <div class="row mb-3">
                                         <label class="col-sm-2 col-form-label">Status</label>
                                         <div class="col-sm-10">
                                             <select name="e_status" class="form-select" required>
                                                 <option value="Aktif" {{ $banner->status == 'Aktif' ? 'selected' : '' }}>
                                                     Aktif</option>
                                                 <option value="Non Aktif"
                                                     {{ $banner->status == 'Non Aktif' ? 'selected' : '' }}>Non Aktif
                                                 </option>
                                             </select>
                                         </div>
                                     </div>

                                     {{-- Gambar Depan --}}
                                     <div class="row mb-3 align-items-center">
                                         <label class="col-sm-2 col-form-label">Gambar Depan</label>
                                         <div class="col-sm-10 d-flex align-items-center gap-3">
                                             <input type="file" name="e_image" class="form-control"
                                                 accept=".jpg,.jpeg,.png" style="max-width: 70%;" id="preview-image-input">

                                             <div>
                                                 <small class="text-muted d-block">Gambar sekarang:</small>
                                                 <img id="preview-image" src="{{ asset('images/' . $banner->image) }}"
                                                     alt="Gambar Banner" width="80" height="80"
                                                     style="object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
                                             </div>
                                         </div>
                                     </div>
                                     {{-- scrip untuk menampilkan gambar ketika di update --}}
                                     <script>
                                         document.getElementById('preview-image-input').addEventListener('change', function(event) {
                                             const file = event.target.files[0];
                                             if (file) {
                                                 const preview = document.getElementById('preview-image');
                                                 preview.src = URL.createObjectURL(file);
                                             }
                                         });
                                     </script>



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
