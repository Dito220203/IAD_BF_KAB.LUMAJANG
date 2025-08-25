@extends('components.layout')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Tambah Progres</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Beranda</a></li>
                    <li class="breadcrumb-item">Progres Kerja</li>
                    <li class="breadcrumb-item active">Tambah Progres</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        {{-- Tambahkan Leaflet CSS --}}
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" crossorigin="" />

        {{-- Tambahkan style untuk map --}}
        <style>
            #map {
                width: 100%;
                height: 400px;
                margin-top: 10px;
            }
        </style>

        <section class="section">
            <div class="row">
                <div class="col-lg-12"> {{-- Full width --}}
                    <div class="card">
                        <div class="card-body pt-4">


                            <form action="{{ route('progres.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- Sub Program --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Sub Program</label>
                                    <div class="col-sm-10">
                                        <select name="subprogram" class="form-select" required>
                                            <option value="">Pilih</option>
                                            @foreach ($subprogram as $data)
                                                <option value="{{ $data->id }}">{{ $data->subprogram }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Judul Informasi --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Judul Progres</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="judul" class="form-control" required>
                                    </div>
                                </div>

                                {{-- Tahun --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Tahun</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tahun" class="form-control" required>
                                    </div>
                                </div>

                                {{-- Sumber Dana --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Sumber Dana</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="sumber_dana" class="form-control">
                                    </div>
                                </div>

                                {{-- Jumlah Anggaran --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Jumlah Anggaran</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="jumlah_anggaran" class="form-control">
                                    </div>
                                </div>

                                {{-- Penerima --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Penerima</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="penerima" class="form-control">
                                    </div>
                                </div>

                                {{-- Uraian --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Uraian</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="uraian" class="form-control">
                                    </div>
                                </div>

                                {{-- Map Lokasi --}}
                                <div class="row mb-4">
                                    <label class="col-sm-2 col-form-label">Map Lokasi</label>
                                    <div class="col-sm-10">
                                        <div class="coordinates-container"></div>
                                        <div id="map"></div>
                                    </div>
                                </div>

                                {{-- Upload Foto Progres (diletakkan di bawah tombol) --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Foto Progres</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="file" name="foto" accept="image/*"
                                            onchange="previewFoto(event)">
                                        <small class="text-muted">Opsional. Format: jpg, jpeg, png. Maks 2MB.</small>
                                        <div class="mt-3">
                                            <img id="preview-foto"
                                                src="{{ asset('images/placeholder-image.png') }}"
                                                alt="Preview Foto"
                                                style="display:block;width:350px;height:250px;object-fit:cover;border-radius:5px;border:1px solid #ddd;">
                                            <div class="text-muted mt-1" id="foto-placeholder-ket">Belum ada foto, silakan upload jika ada.</div>
                                        </div>
                                        @error('foto')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <script>
                                    function previewFoto(event) {
                                        const input = event.target;
                                        const preview = document.getElementById('preview-foto');
                                        const ket = document.getElementById('foto-placeholder-ket');
                                        if (input.files && input.files[0]) {
                                            const reader = new FileReader();
                                            reader.onload = function(e) {
                                                preview.src = e.target.result;
                                                ket.style.display = 'none';
                                            }
                                            reader.readAsDataURL(input.files[0]);
                                        } else {
                                            preview.src = "{{ asset('images/placeholder-image.png') }}";
                                            ket.style.display = 'block';
                                        }
                                    }
                                </script>
                                {{-- Tombol --}}
                                <div class="row mb-3">
                                    <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                        <a href="{{ route('progres') }}" class="btn btn-warning">Kembali</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Tambahkan Leaflet JS --}}
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" crossorigin=""></script>

        {{-- Script Map --}}
        <script>
            var mymap = L.map('map').setView([-8.13439, 113.22208], 13); // Koordinat default

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 18
            }).addTo(mymap);

            var marker = [];
            var index = 0;

            function onMapClick(e) {
                marker[index] = L.marker(e.latlng).addTo(mymap).bindPopup("<button type='button' onclick='hapus_marker(" +
                    index + ")'>Hapus</button>");
                let html =
                    `<input type="hidden" name="longitude[${index}]" class="coordinates_${index} longitudes" value="${e.latlng.lng}">
                            <input type="hidden" name="latitude[${index}]" class="coordinates_${index} latitudes" value="${e.latlng.lat}">`;
                document.querySelector('.coordinates-container').insertAdjacentHTML('beforeend', html);
                index++;
            }

            function hapus_marker(id) {
                document.querySelectorAll('.coordinates_' + id).forEach(el => el.remove());
                mymap.removeLayer(marker[id]);
                rapikan_input();
            }

            function rapikan_input() {
                document.querySelectorAll('.longitudes').forEach((el, i) => {
                    el.name = `longitude[${i}]`;
                    el.className = `coordinates_${i} longitudes`;
                });
                document.querySelectorAll('.latitudes').forEach((el, i) => {
                    el.name = `latitude[${i}]`;
                    el.className = `coordinates_${i} latitudes`;
                });
            }

            mymap.on('click', onMapClick);
        </script>

    </main>
@endsection
