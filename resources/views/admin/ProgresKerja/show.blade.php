@extends('components.layout')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Lihat Progres</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('progres') }}">Beranda</a></li>
                    <li class="breadcrumb-item">Progres Kerja</li>
                    <li class="breadcrumb-item active">Lihat Progres</li>
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

                            {{-- Tidak ada action atau method, cuma tampilan --}}
                            <form>
                                {{-- Sub Program --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Sub Program</label>
                                    <div class="col-sm-10">
                                        <select class="form-select" disabled>
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
                                        <input type="text" value="{{ $progres->judul }}" class="form-control" disabled>
                                    </div>
                                </div>

                                {{-- Tahun --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Tahun</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{ $progres->tahun }}" class="form-control" disabled>
                                    </div>
                                </div>

                                {{-- Sumber Dana --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Sumber Dana</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{ $progres->sumber_dana }}" class="form-control"
                                            disabled>
                                    </div>
                                </div>

                                {{-- Jumlah Anggaran --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Jumlah Anggaran</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{ $progres->jumlah_anggaran }}" class="form-control"
                                            disabled>
                                    </div>
                                </div>

                                {{-- Penerima --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Penerima</label>
                                    <div class="col-sm-10">
                                        <input type="text" value="{{ $progres->penerima }}" class="form-control"
                                            disabled>
                                    </div>
                                </div>

                                {{-- Uraian --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Uraian</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" rows="3" disabled>{{ $progres->uraian }}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label class="col-sm-2 col-form-label">Map Lokasi</label>
                                    <div class="col-sm-10">
                                        <div id="map" style="height: 400px;"></div>

                                        {{-- input hidden (tidak wajib kalau hanya show) --}}
                                        <input type="hidden" name="latitude" id="latitude"
                                            value="{{ $progres->latitude }}">
                                        <input type="hidden" name="longitude" id="longitude"
                                            value="{{ $progres->longitude }}">
                                    </div>
                                </div>



                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Foto Progres</label>
                                    <div class="col-sm-10">
                                        @php
                                            $fotoProgres = $progres->fotoProgres()->get();
                                        @endphp
                                        @if ($fotoProgres->isNotEmpty())
                                            <div class="d-flex flex-wrap gap-3">
                                                @foreach ($fotoProgres as $foto)
                                                    <img src="{{ asset('storage/foto_progres/' . $foto->foto) }}"
                                                        alt="Foto Progres"
                                                        style="width:200px;height:150px;object-fit:cover;border-radius:5px;border:1px solid #ddd;">
                                                @endforeach
                                            </div>
                                        @else
                                            <img src="{{ asset('images/placeholder-image.png') }}" alt="Preview Foto"
                                                style="width:200px;height:150px;object-fit:cover;border-radius:5px;border:1px solid #ddd;">
                                            <div class="text-muted mt-1">Belum ada foto progres.</div>
                                        @endif
                                    </div>
                                </div>


                                {{-- Tombol Kembali --}}
                                <div class="row mb-3">
                                    <div class="col-sm-10 offset-sm-2">
                                        <a href="{{ route('progres') }}" class="btn btn-warning">Kembali</a>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="map" style="height: 400px;"></div>

        {{-- Leaflet JS --}}
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" crossorigin=""></script>
        <script>
            var mymap = L.map('map').setView([-8.13439, 113.22208], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 18
            }).addTo(mymap);

            @if ($progres->maps->isNotEmpty())
                // ambil titik pertama untuk view
                var firstMap = @json($progres->maps->first());

                var marker = L.marker([firstMap.latitude, firstMap.longitude], {
                    draggable: false // tidak bisa digeser
                }).addTo(mymap);

                // update input hidden saat digeser
                marker.on('dragend', function(e) {
                    var position = e.target.getLatLng();
                    document.getElementById("latitude").value = position.lat;
                    document.getElementById("longitude").value = position.lng;
                });

                mymap.setView([firstMap.latitude, firstMap.longitude], 15);
            @endif
        </script>
    @endsection
