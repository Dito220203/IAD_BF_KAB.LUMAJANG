@extends('components.layout')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Edit Potensi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('potensi') }}">Beranda</a></li>
                    <li class="breadcrumb-item">Potensi</li>
                    <li class="breadcrumb-item active">Edit Potensi</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3 mt-3">

                                <form action="{{ route('potensi.update', $potensi->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- Judul --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Judul Potensi</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="judul" class="form-control"
                                                value="{{ old('judul', $potensi->judul) }}" required>
                                        </div>
                                    </div>

                                    {{-- Kecamatan --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Kecamatan</label>
                                        <div class="col-sm-10">
                                            <select id="kecamatan" name="kecamatan" class="form-select">
                                                <option value="">Pilih</option>
                                                @foreach ($kecamatan as $data)
                                                    <option value="{{ $data->id }}"
                                                        {{ $data->kecamatan == $potensi->kecamatan ? 'selected' : '' }}>
                                                        {{ $data->kecamatan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Desa --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Desa</label>
                                        <div class="col-sm-10">
                                            <select id="desa" name="desa" class="form-select">
                                                <option value="">Pilih</option>
                                                {{-- Akan diisi via JS --}}
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Gambar --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Gambar Depan</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="image" id="preview-image-input"
                                                class="form-control" accept=".jpg,.jpeg,.png"
                                                onchange="validateAndPreview(event)">
                                            <small class="text-muted">* Format jpeg, jpg atau png. Maks. 2 MB</small>

                                            {{-- Error dari Laravel --}}
                                            @error('image')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror

                                            {{-- Wrapper untuk gambar --}}
                                            <div class="mt-2">
                                                <img id="preview-image"
                                                    src="{{ $potensi->gambar ? asset('storage/' . $potensi->gambar) : '#' }}"
                                                    alt="Preview Gambar"
                                                    style="max-height: 150px; {{ $potensi->gambar ? '' : 'display:none;' }} border:1px solid #ccc; padding:5px;">
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Script untuk validasi + preview --}}
                                    <script>
                                        function validateAndPreview(event) {
                                            const file = event.target.files[0];
                                            const preview = document.getElementById('preview-image');

                                            if (file) {
                                                // cek ukuran max 2MB
                                                if (file.size > 2 * 1024 * 1024) {
                                                    alert("Ukuran file melebihi 2 MB. Silakan pilih gambar lain.");
                                                    event.target.value = ""; // reset input
                                                    preview.style.display = "none";
                                                    return;
                                                }

                                                // tampilkan preview
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
                                            <input type="date" name="tanggal" class="form-control"
                                                value="{{ old('tanggal', $potensi->tanggal) }}" required>
                                        </div>
                                    </div>

                                    {{-- Uraian --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Uraian</label>
                                        <div class="col-sm-10">
                                            <textarea name="uraian" class="form-control" rows="4" required>{{ old('uraian', $potensi->uraian) }}</textarea>
                                        </div>
                                    </div>

                                    {{-- Tombol --}}
                                    <div class="row mb-3">
                                        <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                            <button type="submit" class="btn btn-success">Update</button>
                                            <a href="{{ route('potensi') }}" class="btn btn-warning">Kembali</a>
                                        </div>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Script isi desa otomatis --}}
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const kecamatanSelect = document.getElementById("kecamatan");
                const desaSelect = document.getElementById("desa");
                const desaLama = "{{ $potensi->desa }}";

                function loadDesa(kecamatanId) {
                    desaSelect.innerHTML = '<option value="">Pilih</option>';
                    if (kecamatanId) {
                        fetch(`/get-desa/${kecamatanId}`)
                            .then(response => response.json())
                            .then(data => {
                                data.forEach(desa => {
                                    const option = document.createElement("option");
                                    option.value = desa.id;
                                    option.textContent = desa.desa;
                                    if (desa.desa === desaLama) {
                                        option.selected = true;
                                    }
                                    desaSelect.appendChild(option);
                                });
                            });
                    }
                }

                kecamatanSelect.addEventListener("change", function() {
                    loadDesa(this.value);
                });

                // Load desa saat halaman dibuka
                if (kecamatanSelect.value) {
                    loadDesa(kecamatanSelect.value);
                }
            });
        </script>

    </main>
@endsection
