 @extends('components.layout')
 @section('content')
     <main id="main" class="main">

         <div class="pagetitle">
             <h1>Tambah Video</h1>
             <nav>
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="index.html">Beranda</a></li>
                     <li class="breadcrumb-item">Video</li>
                     <li class="breadcrumb-item active">Tambah Video</li>
                 </ol>
             </nav>
         </div>
         <section class="section">
             <div class="row">
                 <div class="col-lg-12"> {{-- Full width --}}
                     <div class="card">
                         <div class="card-body pt-4">
                             <form action="{{route('storevideo')}}" method="POST" enctype="multipart/form-data">
                                 @csrf
                                 <div class="row mb-3">
                                     <label class="col-sm-2 col-form-label">Judul Video</label>
                                     <div class="col-sm-10">
                                         <input type="text" name="judul" class="form-control" required>
                                     </div>
                                 </div>
                                 <div class="row mb-3">
                                     <label class="col-sm-2 col-form-label">Link Video</label>
                                     <div class="col-sm-10">
                                         <input type="text" name="link" class="form-control" required>
                                     </div>
                                 </div>
                                 <div class="row mb-3">
                                     <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                         <button type="submit" class="btn btn-success">Simpan</button>
                                         <a href="{{route('video')}}" class="btn btn-secondary">Kembali</a>
                                     </div>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>
             </div>
             </main>
@endsection
