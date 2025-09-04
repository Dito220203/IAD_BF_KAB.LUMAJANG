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
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .foto-item { position: relative; display: inline-block; margin-right:10px; margin-bottom:10px;}
        .foto-item img { width: 150px; height: 100px; object-fit: cover; border-radius:5px; border:1px solid #ddd;}
        .foto-item button { position: absolute; top:0; right:0; z-index:10; }
    </style>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm">
                    <div class="card-body pt-4">

                        <form action="{{ route('progres.update', $progres->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Sub Program --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Sub Program</label>
                                <div class="col-sm-10">
                                    <select name="subprogram" class="form-select" required>
                                        <option value="">Pilih</option>
                                        @foreach ($subprogram as $data)
                                            <option value="{{ $data->id }}" {{ $data->id == $progres->id_subprogram ? 'selected' : '' }}>
                                                {{ $data->subprogram }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Judul --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Judul Progres</label>
                                <div class="col-sm-10">
                                    <input type="text" name="judul" value="{{ old('judul', $progres->judul) }}" class="form-control" required>
                                </div>
                            </div>

                            {{-- Tahun --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Tahun</label>
                                <div class="col-sm-10">
                                    <input type="text" name="tahun" value="{{ old('tahun', $progres->tahun) }}" class="form-control" required>
                                </div>
                            </div>

                            {{-- Sumber Dana --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Sumber Dana</label>
                                <div class="col-sm-10">
                                    <input type="text" name="sumber_dana" value="{{ old('sumber_dana', $progres->sumber_dana) }}" class="form-control">
                                </div>
                            </div>

                            {{-- Jumlah Anggaran --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Jumlah Anggaran</label>
                                <div class="col-sm-10">
                                    <input type="text" name="jumlah_anggaran" value="{{ old('jumlah_anggaran', $progres->jumlah_anggaran) }}" class="form-control">
                                </div>
                            </div>

                            {{-- Penerima --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Penerima</label>
                                <div class="col-sm-10">
                                    <input type="text" name="penerima" value="{{ old('penerima', $progres->penerima) }}" class="form-control">
                                </div>
                            </div>

                            {{-- Uraian --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Uraian</label>
                                <div class="col-sm-10">
                                    <textarea name="uraian" class="form-control" rows="3">{{ old('uraian', $progres->uraian) }}</textarea>
                                </div>
                            </div>

                            {{-- Map Lokasi --}}
                            <div class="row mb-4">
                                <label class="col-sm-2 col-form-label">Map Lokasi</label>
                                <div class="col-sm-10">
                                    <div class="coordinates-container">
                                        @foreach ($progres->maps as $map)
                                            <input type="hidden" name="longitude" value="{{ $map->longitude }}">
                                            <input type="hidden" name="latitude" value="{{ $map->latitude }}">
                                        @endforeach
                                    </div>
                                    <div id="map"></div>
                                </div>
                            </div>

                            {{-- Foto Progres --}}
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Foto Progres</label>
                                <div class="col-sm-10" id="foto-container">
                                    @php
                                        $fotoProgresAll = $progres->fotoProgres()->get();
                                    @endphp
                                    @if($fotoProgresAll->count() > 0)
                                        @foreach ($fotoProgresAll as $foto)
                                            <div class="foto-item">
                                                <img src="{{ asset('storage/foto_progres/' . $foto->foto) }}">
                                                <button type="button" class="btn btn-sm btn-danger" onclick="hapusFoto(this)">&times;</button>
                                                <input type="hidden" name="foto_lama[]" value="{{ $foto->id }}">
                                            </div>
                                        @endforeach
                                    @endif
                                    <div class="foto-item">
                                        <input class="form-control mb-2" type="file" name="foto[]" accept="image/*" onchange="previewFoto(event, this)">
                                        <img src="{{ asset('images/placeholder-image.png') }}">
                                    </div>
                                    <button type="button" class="btn btn-primary mt-2" onclick="tambahFoto()">+ Tambah Foto</button>
                                    <small class="text-muted d-block mt-2">Opsional. Maks 2MB per foto.</small>
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

                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" crossorigin=""></script>
    <script>
        // =================== FOTO ===================
        function previewFoto(event, input) {
            const file = event.target.files[0];
            const img = input.nextElementSibling;
            if(file){
                if(file.size > 2*1024*1024){ alert("Ukuran maksimal 2MB"); input.value=""; return; }
                const reader = new FileReader();
                reader.onload = function(e){ img.src = e.target.result; }
                reader.readAsDataURL(file);
            } else {
                img.src = "{{ asset('images/placeholder-image.png') }}";
            }
        }
        function tambahFoto(){
            const container = document.getElementById('foto-container');
            const div = document.createElement('div'); div.classList.add('foto-item');
            div.innerHTML = `
                <input class="form-control mb-2" type="file" name="foto[]" accept="image/*" onchange="previewFoto(event, this)">
                <img src="{{ asset('images/placeholder-image.png') }}">
            `;
            container.appendChild(div);
        }
        function hapusFoto(btn){
            btn.parentElement.remove();
        }

        // =================== MAP ===================
        var mymap = L.map('map').setView([-8.13439, 113.22208], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution:'&copy; OpenStreetMap contributors', maxZoom:18
        }).addTo(mymap);
        let markers = [];

        var oldCoordinates = @json($progres->maps);
        if(oldCoordinates.length > 0){
            let first = oldCoordinates[0];
            markers[0] = L.marker([first.latitude, first.longitude], {draggable:true}).addTo(mymap);
            mymap.setView([first.latitude, first.longitude], 15);
            markers[0].on('dragend', function(e){
                const pos = e.target.getLatLng();
                document.querySelector('input[name="latitude"]').value = pos.lat;
                document.querySelector('input[name="longitude"]').value = pos.lng;
            });
        }

        function onMapClick(e){
            if(markers.length>0){
                mymap.removeLayer(markers[0]);
                document.querySelectorAll('.coordinates-container input').forEach(el=>el.remove());
                markers=[];
            }
            let marker = L.marker(e.latlng,{draggable:true}).addTo(mymap);
            markers.push(marker);
            document.querySelector('.coordinates-container').innerHTML = `
                <input type="hidden" name="longitude" value="${e.latlng.lng}">
                <input type="hidden" name="latitude" value="${e.latlng.lat}">
            `;
            marker.on('dragend', function(event){
                let pos = event.target.getLatLng();
                document.querySelector('input[name="latitude"]').value = pos.lat;
                document.querySelector('input[name="longitude"]').value = pos.lng;
            });
        }
        mymap.on('click', onMapClick);
    </script>
</main>
@endsection
