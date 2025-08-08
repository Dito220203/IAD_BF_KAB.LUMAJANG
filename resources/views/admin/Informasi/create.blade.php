@extends('components.layout')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Tambah Informasi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('informasi') }}">Beranda</a></li>
                <li class="breadcrumb-item">Informasi</li>
                <li class="breadcrumb-item active">Tambah Informasi</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="mb-3 mt-3">

                            <form action="{{ route('informasi.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- Judul --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Judul Informasi</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="judul" class="form-control" required>
                                    </div>
                                </div>

                                {{-- Gambar --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Gambar Depan</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="foto" class="form-control" accept=".jpg,.jpeg,.png">
                                        <small class="text-muted">* Format jpeg, jpg atau png. Maks. 2 MB</small>
                                    </div>
                                </div>

                                {{-- Tanggal --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Tanggal</label>
                                    <div class="col-sm-10">
                                        <input type="date" name="tanggal" class="form-control" required>
                                    </div>
                                </div>

                                {{-- Status --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Status Informasi</label>
                                    <div class="col-sm-10">
                                        <select name="status" class="form-select" required>
                                            <option value="Belum Validasi">Belum Validasi</option>
                                            <option value="Valid">Valid</option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Isi Berita --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Isi Berita</label>
                                    <div class="col-sm-10">
                                          <div class="card">
                                                 <div class="card-body">
                                        <div id="quillEditor" style="min-height: 250px;"></div>
                                        <textarea name="isi" id="isi" class="d-none"></textarea>
                                    </div>
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

{{-- Script Quill --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const quill = new Quill('#quillEditor', {
        theme: 'snow'
    });

    const form = document.querySelector('form');
    form.addEventListener('submit', function () {
        document.querySelector('#isi').value = quill.root.innerHTML;
    });
});
</script>
@endsection
