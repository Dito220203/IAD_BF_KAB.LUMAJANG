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


                            <form action="" method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- Sub Program --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Sub Program</label>
                                    <div class="col-sm-10">
                                        <select name="sub_program" class="form-select" required>
                                            <option value="">Pilih</option>
                                            <option>AKSES HUTSOS DAN REDISTRIBUSI</option>
                                            <option>INTERKONEKSI WISATA</option>
                                            <option>AGROINDUSTRI</option>
                                            <option>AGROSILVOPASTURA</option>
                                            <option>RESTORASI BERBASIS AGRIKULTUR</option>
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

                                {{-- Tombol --}}
                                <div class="row mb-3">
                                    <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                        <a href="#" class="btn btn-secondary">Kembali</a>
                                    </div>
                                </div>
                            </form>
{{-- Tambah Foto --}}
<div class="card mt-4">
  <div class="card-body">

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="card-title mb-0">Tabel Foto Progres</h5>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahFotoModal">
        <i class="bi bi-upload"></i> Tambah Foto
      </button>
    </div>

    <table class="table table-hover table-bordered text-center">
      <thead class="table-light">
        <tr>
          <th scope="col">Foto</th>
        </tr>
      </thead>
      <tbody>
        {{-- @forelse ($fotos as $foto) --}}
        <tr>
          <td>
            <img src="" alt="Foto Progres" class="img-fluid rounded" style="max-width: 200px;">
          </td>
        </tr>
        {{-- @empty --}}
        <tr>
          <td colspan="1" class="text-muted">Belum ada foto ditambahkan.</td>
        </tr>
        {{-- @endforelse --}}
      </tbody>
    </table>

  </div>
</div>

<!-- Modal Tambah Foto -->
<div class="modal fade" id="tambahFotoModal" tabindex="-1" aria-labelledby="tambahFotoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="" method="POST" enctype="multipart/form-data" class="modal-content">
      {{-- @csrf --}}
      <input type="hidden" name="progres_id" value="">
      <div class="modal-header">
        <h5 class="modal-title" id="tambahFotoModalLabel"><i class="bi bi-image"></i> Upload Foto Progres</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="foto" class="form-label">Pilih Foto</label>
          <input class="form-control" type="file" name="foto" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </form>
  </div>
</div>

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
                marker[index] = L.marker(e.latlng).addTo(mymap).bindPopup("<button type='button' onclick='hapus_marker(" + index + ")'>Hapus</button>");
                let html = `<input type="hidden" name="longitude[${index}]" class="coordinates_${index} longitudes" value="${e.latlng.lng}">
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
