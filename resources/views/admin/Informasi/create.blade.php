@extends('components.layout')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Tambah Informasi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</li>
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

                                <form id="informasiForm" action="{{ route('informasi.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    {{-- Judul --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Judul Informasi</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="judul" class="form-control" required>
                                        </div>
                                    </div>

                                    {{-- Gambar Depan --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Gambar Depan</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="foto" id="foto" class="form-control"
                                                accept=".jpg,.jpeg,.png" onchange="validateAndPreview(event)">
                                            <small class="text-muted">* Format jpeg, jpg atau png. Maks. 2 MB</small>

                                            {{-- Tempat preview gambar --}}
                                            <div class="mt-2">
                                                <img id="image-preview"
                                                    src="{{ isset($informasi) && $informasi->foto ? asset('storage/' . $informasi->foto) : '#' }}"
                                                    alt="Preview Gambar"
                                                    style="max-height: 120px; border: 1px solid #ccc; padding: 5px; {{ isset($informasi) && $informasi->foto ? '' : 'display:none;' }}">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Script Validasi + Preview Gambar --}}
                                    <script>
                                        function validateAndPreview(event) {
                                            const file = event.target.files[0];
                                            const preview = document.getElementById('image-preview');

                                            if (file) {
                                                // Cek ukuran file (maks 2 MB)
                                                if (file.size > 2 * 1024 * 1024) {
                                                    alert("Ukuran file melebihi 2 MB. Silakan pilih gambar lain.");
                                                    event.target.value = ""; // reset input file
                                                    preview.style.display = "none";
                                                    return;
                                                }

                                                // Jika valid → tampilkan preview
                                                const reader = new FileReader();
                                                reader.onload = function(e) {
                                                    preview.src = e.target.result;
                                                    preview.style.display = "block";
                                                }
                                                reader.readAsDataURL(file);
                                            } else {
                                                preview.src = "#";
                                                preview.style.display = "none";
                                            }
                                        }
                                    </script>

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
                                                <option value="">Pilih</option>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi Quill
        const quill = new Quill('#quillEditor', {
            theme: 'snow'
        });

        const form = document.getElementById('informasiForm');
        const hiddenInput = document.getElementById('isi');

        // Saat submit, isi textarea dengan konten Quill
        form.addEventListener('submit', function(e) {
            hiddenInput.value = quill.root.innerHTML;
        });
    });
</script>

@endsection
