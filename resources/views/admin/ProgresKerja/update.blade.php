@extends('components.layout')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Edit Progres</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('progres') }}">Beranda</a></li>
                    <li class="breadcrumb-item">Progres Kerja</li>
                    <li class="breadcrumb-item active">Edit Progres</li>
                </ol>
            </nav>
        </div>

        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" crossorigin="" />

        <style>
            #map {
                width: 100%;
                height: 400px;
                margin-top: 10px;
            }
        </style>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body pt-4">

                            <form action="{{ route('progres.update', $progres->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                {{-- Sub Program --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Sub Program</label>
                                    <div class="col-sm-10">
                                        <select name="subprogram" class="form-select" required>
                                            <option value="">Pilih</option>
                                            @foreach ($subprogram as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ $data->id == $progres->id_subprogram ? 'selected' : '' }}>
                                                    {{ $data->subprogram }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Judul Informasi --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Judul Progres</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="judul" value="{{ old('judul', $progres->judul) }}"
                                            class="form-control" required>
                                    </div>
                                </div>

                                {{-- Tahun --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Tahun</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tahun" value="{{ old('tahun', $progres->tahun) }}"
                                            class="form-control" required>
                                    </div>
                                </div>

                                {{-- Sumber Dana --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Sumber Dana</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="sumber_dana"
                                            value="{{ old('sumber_dana', $progres->sumber_dana) }}" class="form-control">
                                    </div>
                                </div>

                                {{-- Jumlah Anggaran --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Jumlah Anggaran</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="jumlah_anggaran"
                                            value="{{ old('jumlah_anggaran', $progres->jumlah_anggaran) }}"
                                            class="form-control">
                                    </div>
                                </div>

                                {{-- Penerima --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Penerima</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="penerima"
                                            value="{{ old('penerima', $progres->penerima) }}" class="form-control">
                                    </div>
                                </div>

                                {{-- Uraian --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Uraian</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="uraian" value="{{ old('uraian', $progres->uraian) }}"
                                            class="form-control">
                                    </div>
                                </div>

                                {{-- Map Lokasi --}}
                                <div class="row mb-4">
                                    <label class="col-sm-2 col-form-label">Map Lokasi</label>
                                    <div class="col-sm-10">
                                        <div class="coordinates-container">
                                            {{-- Kalau ada koordinat lama, taruh di sini --}}
                                        </div>
                                        <div id="map"></div>
                                    </div>
                                </div>

                                {{-- Upload Foto Progres (Update) --}}
                                @php
                                    $fotoProgres = $progres->fotoProgres()->first();
                                @endphp
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Foto Progres</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="foto" class="form-control"
                                            accept=".jpg,.jpeg,.png" id="preview-foto-input">
                                        <small class="text-muted">Opsional. Maks 2MB.</small>
                                        <div class="mt-3">
                                            <img id="preview-foto"
                                                src="{{ $fotoProgres ? asset('storage/foto_progres/' . $fotoProgres->foto) : asset('images/placeholder-image.png') }}"
                                                alt="Foto Progres"
                                                style="display:block;width:350px;height:250px;object-fit:cover;border-radius:5px;border:1px solid #ddd;">
                                            <div class="text-muted mt-1" id="foto-placeholder-ket" style="{{ $fotoProgres ? 'display:none;' : '' }}">
                                                Belum ada foto, silakan upload jika ada.
                                            </div>
                                        </div>
                                        @error('foto')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                {{-- Tombol --}}
                                <div class="row mb-3">
                                    <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                        <button type="submit" class="btn btn-success">Update</button>
                                        <a href="{{ route('progres') }}" class="btn btn-warning">Kembali</a>
                                    </div>
                                </div>

                            </form>

                            {{-- Bagian tabel foto tetap sama seperti form tambah --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" crossorigin=""></script>
        <script>
            var mymap = L.map('map').setView([-8.13439, 113.22208], 13);
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

        <script>
            document.getElementById('preview-foto-input').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('preview-foto');
                const ket = document.getElementById('foto-placeholder-ket');
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        ket.style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.src = "{{ asset('images/placeholder-image.png') }}";
                    ket.style.display = 'block';
                }
            });
        </script>
    </main>
@endsection
