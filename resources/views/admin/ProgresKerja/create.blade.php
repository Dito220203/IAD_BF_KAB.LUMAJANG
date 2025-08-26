@extends('components.layout')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Tambah Progres</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                <li class="breadcrumb-item">Progres Kerja</li>
                <li class="breadcrumb-item active">Tambah Progres</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" crossorigin="" />

    <style>
        #map {
            width: 100%;
            height: 400px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
    </style>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body pt-4">

                        <form action="{{ route('progres.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            {{-- Sub Program --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Sub Program</label>
                                <div class="col-sm-10">
                                    <select name="subprogram" class="form-select @error('subprogram') is-invalid @enderror" required>
                                        <option value="">Pilih</option>
                                        @foreach ($subprogram as $data)
                                            <option value="{{ $data->id }}" {{ old('subprogram') == $data->id ? 'selected' : '' }}>
                                                {{ $data->subprogram }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subprogram')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- Judul --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Judul Progres</label>
                                <div class="col-sm-10">
                                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror"
                                        value="{{ old('judul') }}" required>
                                    @error('judul')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- Tahun --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tahun</label>
                                <div class="col-sm-10">
                                    <input type="text" name="tahun" class="form-control @error('tahun') is-invalid @enderror"
                                        value="{{ old('tahun') }}" required>
                                    @error('tahun')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            {{-- Sumber Dana --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Sumber Dana</label>
                                <div class="col-sm-10">
                                    <input type="text" name="sumber_dana" class="form-control"
                                        value="{{ old('sumber_dana') }}">
                                </div>
                            </div>

                            {{-- Jumlah Anggaran --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Jumlah Anggaran</label>
                                <div class="col-sm-10">
                                    <input type="text" name="jumlah_anggaran" class="form-control"
                                        value="{{ old('jumlah_anggaran') }}">
                                </div>
                            </div>

                            {{-- Penerima --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Penerima</label>
                                <div class="col-sm-10">
                                    <input type="text" name="penerima" class="form-control"
                                        value="{{ old('penerima') }}">
                                </div>
                            </div>

                            {{-- Uraian --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Uraian</label>
                                <div class="col-sm-10">
                                    <textarea name="uraian" class="form-control" rows="3">{{ old('uraian') }}</textarea>
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

                            {{-- Foto --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Foto Progres</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" name="foto" accept="image/*" onchange="previewFoto(event)">
                                    <small class="text-muted">Opsional. Format: jpg, jpeg, png. Maks 2MB.</small>
                                    <div class="mt-3">
                                        <img id="preview-foto"
                                            src="{{ asset('images/placeholder-image.png') }}"
                                            alt="Preview Foto"
                                            style="display:block;width:350px;height:250px;object-fit:cover;border-radius:5px;border:1px solid #ddd;">
                                        <div class="text-muted mt-1" id="foto-placeholder-ket">
                                            Belum ada foto, silakan upload jika ada.
                                        </div>
                                    </div>
                                    @error('foto')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>

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

    {{-- Leaflet JS --}}
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" crossorigin=""></script>

    <script>
        // Leaflet map init
        var mymap = L.map('map').setView([-8.13439, 113.22208], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors',
            maxZoom: 18
        }).addTo(mymap);

        var markers = [];
        var index = 0;

        function onMapClick(e) {
            markers[index] = L.marker(e.latlng).addTo(mymap).bindPopup(
                "<button type='button' class='btn btn-sm btn-danger' onclick='hapusMarker(" + index + ")'>Hapus</button>"
            );
            let html = `<input type="hidden" name="longitude[${index}]" class="coord_${index} longitudes" value="${e.latlng.lng}">
                        <input type="hidden" name="latitude[${index}]" class="coord_${index} latitudes" value="${e.latlng.lat}">`;
            document.querySelector('.coordinates-container').insertAdjacentHTML('beforeend', html);
            index++;
        }

        function hapusMarker(id) {
            document.querySelectorAll('.coord_' + id).forEach(el => el.remove());
            mymap.removeLayer(markers[id]);
            rapikanInput();
        }

        function rapikanInput() {
            document.querySelectorAll('.longitudes').forEach((el, i) => {
                el.name = `longitude[${i}]`;
                el.className = `coord_${i} longitudes`;
            });
            document.querySelectorAll('.latitudes').forEach((el, i) => {
                el.name = `latitude[${i}]`;
                el.className = `coord_${i} latitudes`;
            });
        }

        mymap.on('click', onMapClick);

        // Foto Preview
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

</main>
@endsection
