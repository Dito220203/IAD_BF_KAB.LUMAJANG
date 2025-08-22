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

                                {{-- Map Lokasi --}}
                                <div class="row mb-4">
                                    <label class="col-sm-2 col-form-label">Map Lokasi</label>
                                    <div class="col-sm-10">
                                        <div id="map"></div>
                                    </div>
                                </div>

                                {{-- Foto Progres (jika ada) --}}
                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label">Foto Progres</label>
                                    <div class="col-sm-10">
                                        @php
                                            $fotoProgres = $progres->fotoProgres()->first();
                                        @endphp
                                        @if($fotoProgres)
                                            <img src="{{ asset('storage/foto_progres/'.$fotoProgres->foto) }}"
                                                alt="Foto Progres"
                                                style="width:350px;height:250px;object-fit:cover;border-radius:5px;border:1px solid #ddd;">
                                        @else
                                            <img src="{{ asset('images/placeholder-image.png') }}"
                                                alt="Preview Foto"
                                                style="width:350px;height:250px;object-fit:cover;border-radius:5px;border:1px solid #ddd;">
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

        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" crossorigin=""></script>
        <script>
            var mymap = L.map('map').setView([-8.13439, 113.22208], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 18
            }).addTo(mymap);

            // Kalau ada koordinat tersimpan di progres
            @if ($progres->latitude && $progres->longitude)
                L.marker([{{ $progres->latitude }}, {{ $progres->longitude }}]).addTo(mymap);
                mymap.setView([{{ $progres->latitude }}, {{ $progres->longitude }}], 15);
            @endif
        </script>
    </main>
@endsection
