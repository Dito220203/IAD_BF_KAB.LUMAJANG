 @extends('components.layout')
 @section('content')
     <main id="main" class="main">

         <div class="pagetitle">
             <h1>Update Informasi</h1>
             <nav>
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="index.html">Beranda</a></li>
                     <li class="breadcrumb-item">Informasi</li>
                     <li class="breadcrumb-item active">Update Informasi</li>
                 </ol>
             </nav>
         </div><!-- End Page Title -->

         <section class="section">
             <div class="row">
                 <div class="col-lg-12"> {{-- Ubah jadi full width jika butuh --}}
                     <div class="card">
                         <div class="card-body">
                             <div class="mb-3 mt-3">
                                 <form action="{{ route('informasi.update', $informasi->id) }}" method="POST"
                                     enctype="multipart/form-data">
                                     @csrf
                                     @method('PUT')

                                     {{-- Judul Informasi --}}
                                     <div class="row mb-3">
                                         <label class="col-sm-2 col-form-label">Judul Informasi</label>
                                         <div class="col-sm-10">
                                             <input type="text" name="judul"
                                                 value="{{ old('judul', $informasi->judul) }}" class="form-control"
                                                 required>
                                         </div>
                                     </div>

                                     {{-- Gambar Depan --}}
                                     <div class="row mb-3">
                                         <label class="col-sm-2 col-form-label">Gambar Depan</label>
                                         <div class="col-sm-10">
                                             <input type="file" name="foto" class="form-control"
                                                 id="preview-image-input" accept=".jpg,.jpeg,.png">
                                             <small class="text-muted">* Harus format jpeg, jpg atau png dan maks. ukuran 2
                                                 MB</small>

                                             @if ($informasi->foto)
                                                 <div class="mt-2">
                                                     <img id="preview-image"
                                                         src="{{ asset('storage/' . $informasi->foto) }}"
                                                         alt="Gambar Banner" width="80" height="80"
                                                         style="object-fit: cover; border-radius: 5px; border: 1px solid #ddd;">
                                                 </div>
                                             @else
                                                 <div class="mt-2">
                                                     <img id="preview-image" src="#" alt="Preview Gambar"
                                                         style="display:none; object-fit: cover; border-radius: 5px; border: 1px solid #ddd;"
                                                         width="80" height="80">
                                                 </div>
                                             @endif
                                         </div>
                                     </div>

                                     {{-- Script untuk menampilkan preview saat file dipilih --}}
                                     <script>
                                         document.getElementById('preview-image-input').addEventListener('change', function(event) {
                                             const file = event.target.files[0];
                                             const preview = document.getElementById('preview-image');

                                             if (file) {
                                                 preview.src = URL.createObjectURL(file);
                                                 preview.style.display = 'block';
                                             }
                                         });
                                     </script>


                                     {{-- Tanggal --}}
                                     <div class="row mb-3">
                                         <label class="col-sm-2 col-form-label">Tanggal</label>
                                         <div class="col-sm-10">
                                             <input type="date" name="tanggal"
                                                 value="{{ old('tanggal', $informasi->tanggal) }}" class="form-control"
                                                 required>
                                         </div>
                                     </div>

                                     {{-- Status Informasi --}}
                                     <div class="row mb-3">
                                         <label class="col-sm-2 col-form-label">Status Informasi</label>
                                         <div class="col-sm-10">
                                             <select name="status" class="form-select" required>
                                                 <option value="Belum Validasi"
                                                     {{ old('status', $informasi->status) == 'Belum Validasi' ? 'selected' : '' }}>
                                                     Belum Validasi</option>
                                                 <option value="Valid"
                                                     {{ old('status', $informasi->status) == 'Valid' ? 'selected' : '' }}>
                                                     Valid</option>
                                             </select>
                                         </div>
                                     </div>

                                     {{-- Isi Berita --}}
                                     <div class="row mb-3">
                                         <label for="isi" class="col-sm-2 col-form-label">Isi Berita</label>
                                         <div class="col-sm-10">
                                             <div class="card">
                                                 <div class="card-body">
                                                     <!-- Quill Editor -->
                                                     <div class="quill-editor-full" style="min-height: 250px;">
                                                         {!! old('isi', $informasi->isi) !!}</div>
                                                     <!-- End Quill Editor -->
                                                 </div>

                                                 <!-- Hidden Textarea untuk dikirim ke server -->
                                                 <textarea name="isi" id="isi" class="form-control d-none">{{ old('isi', $informasi->isi) }}</textarea>
                                             </div>
                                         </div>
                                     </div>

                                     {{-- Tombol --}}
                                     <div class="row mb-3">
                                         <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                             <button type="submit" class="btn btn-success">Publikasi Informasi</button>
                                             <a href="{{ route('informasi') }}" class="btn btn-warning">Kembali</a>
                                         </div>
                                     </div>
                                 </form>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

         </section>
     </main>
 @endsection
