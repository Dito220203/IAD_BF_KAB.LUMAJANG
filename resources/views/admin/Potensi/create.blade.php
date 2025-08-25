@extends('components.layout')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Tambah Potensi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('potensi') }}">Beranda</a></li>
                    <li class="breadcrumb-item">Potensi</li>
                    <li class="breadcrumb-item active">Tambah Potensi</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3 mt-3">

                                <form action="{{ route('potensi.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    {{-- Judul --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Judul Potensi</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="judul" class="form-control" required>
                                        </div>
                                    </div>
                                    {{-- Kecamatan --}}
                                    {{-- Kecamatan --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Kecamatan</label>
                                        <div class="col-sm-10">
                                            <select id="kecamatan" name="kecamatan" class="form-select">
                                                <option value="">Pilih</option>
                                                @foreach ($kecamatan as $data)
                                                    <option value="{{ $data->id }}">
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
                                            </select>
                                        </div>
                                    </div>

                                    {{-- Gambar --}}
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
                                            <small class="text-muted">* Format jpeg, jpg atau png. Maks. 2 MB</small>
                                        </div>
                                    </div>

                                    {{-- Script Preview --}}
                                    <script>
                                        function previewImage(event) {
                                            const input = event.target;
                                            const preview = document.getElementById('image-preview');

                                            if (input.files && input.files[0]) {
                                                preview.src = URL.createObjectURL(input.files[0]);
                                                preview.style.display = 'block';
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

                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Keterangan</label>
                                        <div class="col-sm-10">
                                            <textarea name="keterangan" class="form-control" rows="4" placeholder="Tulis keterangan..." required></textarea>
                                        </div>
                                    </div>


                                    {{-- Tombol --}}
                                    <div class="row mb-3">
                                        <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                            <button type="submit" class="btn btn-success">Simpan</button>
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
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const kecamatanSelect = document.getElementById("kecamatan");
                const desaSelect = document.getElementById("desa");

                kecamatanSelect.addEventListener("change", function() {
                    const kecamatanId = this.value;
                    desaSelect.innerHTML = '<option value="">Pilih</option>'; // reset

                    if (kecamatanId) {
                        fetch(`/get-desa/${kecamatanId}`)
                            .then(response => response.json())
                            .then(data => {
                                data.forEach(desa => {
                                    const option = document.createElement("option");
                                    option.value = desa.id;
                                    option.textContent = desa.desa;
                                    desaSelect.appendChild(option);
                                });
                            })
                            .catch(error => console.error("Error fetching desa:", error));
                    }
                });
            });
        </script>

    </main>
@endsection
