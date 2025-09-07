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
                border: 1px solid #ddd;
                border-radius: 8px;
                margin-top: 10px;
            }

            .upload-box {
                border: 2px dashed #4caf50;
                border-radius: 10px;
                padding: 30px;
                text-align: center;
                background: #f9fdf9;
                cursor: pointer;
                transition: 0.3s;
            }

            .upload-box:hover {
                background: #e6ffe6;
            }

            .upload-list {
                margin-top: 15px;
            }

            .upload-item {
                display: flex;
                align-items: center;
                justify-content: space-between;
                background: #fff;
                border: 1px solid #ddd;
                border-radius: 8px;
                padding: 10px;
                margin-bottom: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            }

            .upload-item img {
                width: 60px;
                height: 45px;
                object-fit: cover;
                border-radius: 5px;
                margin-right: 10px;
            }

            .upload-item span {
                flex: 1;
                font-size: 14px;
                overflow: hidden;
                white-space: nowrap;
                text-overflow: ellipsis;
            }

            .remove-btn {
                color: red;
                cursor: pointer;
                font-weight: bold;
            }

            .hidden-input {
                display: none;
            }
        </style>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
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

                                {{-- Judul --}}
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
                                        <textarea name="uraian" class="form-control" rows="3">{{ old('uraian', $progres->uraian) }}</textarea>
                                    </div>
                                </div>

                                {{-- Map --}}
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
                                        <div class="upload-box" onclick="document.getElementById('fileInput').click()">
                                            <p>Upload gambar progres<br>
                                                <small>Drag & drop atau klik untuk pilih (JPG, PNG, Maks 2MB)</small>
                                            </p>
                                            <input id="fileInput" type="file" name="foto[]" accept="image/*"
                                                class="hidden-input" multiple onchange="handleFiles(this.files)">
                                        </div>

                                        <div class="upload-list" id="uploadList">
                                            {{-- Foto lama --}}
                                            @foreach ($progres->fotoProgres as $foto)
                                                <div class="upload-item old-file-item">
                                                    <img src="{{ asset('storage/foto_progres/' . $foto->foto) }}">
                                                    <span>{{ $foto->foto }} (lama)</span>
                                                    <input type="hidden" name="foto_lama[]" value="{{ $foto->id }}">
                                                    <span class="remove-btn"
                                                        onclick="removeOldFile({{ $foto->id }}, this)">&times;</span>
                                                </div>
                                            @endforeach
                                        </div>

                                        <small class="text-muted d-block mt-2">
                                            Opsional. Format: jpg, jpeg, png. Maks 2MB per foto.
                                        </small>
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
            let fileList = [];

            function handleFiles(files) {
                for (let file of files) {
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Maks 2MB');
                        continue;
                    }
                    if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                        alert('Format JPG/PNG');
                        continue;
                    }
                    fileList.push(file);
                }
                renderFileList();
            }

            function renderFileList() {
                const uploadList = document.getElementById('uploadList');
                uploadList.innerHTML = '';

                // Foto lama
                document.querySelectorAll('.old-file-item').forEach(el => uploadList.appendChild(el));

                // Foto baru
                fileList.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const item = document.createElement('div');
                        item.classList.add('upload-item');
                        item.innerHTML = `
                        <img src="${e.target.result}">
                        <span>${file.name} (${(file.size/1024).toFixed(1)} KB)</span>
                        <span class="remove-btn" onclick="removeFile(${index})">&times;</span>
                    `;
                        uploadList.appendChild(item);
                    }
                    reader.readAsDataURL(file);
                });

                const dt = new DataTransfer();
                fileList.forEach(f => dt.items.add(f));
                document.getElementById('fileInput').files = dt.files;
            }

            function removeFile(index) {
                fileList.splice(index, 1);
                renderFileList();
            }

            function removeOldFile(id, el) {
                el.parentElement.remove();
                document.querySelector(`input[value="${id}"]`).remove();
            }

            // Drag & drop
            const uploadBox = document.querySelector('.upload-box');
            uploadBox.addEventListener('dragover', (e) => {
                e.preventDefault();
                uploadBox.style.background = '#e6ffe6';
            });
            uploadBox.addEventListener('dragleave', () => {
                uploadBox.style.background = '#f9fdf9';
            });
            uploadBox.addEventListener('drop', (e) => {
                e.preventDefault();
                uploadBox.style.background = '#f9fdf9';
                handleFiles(e.dataTransfer.files);
            });

            // =================== MAP ===================
            var mymap = L.map('map').setView([-8.13439, 113.22208], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 18
            }).addTo(mymap);

            let markers = [];

            var oldCoordinates = @json($progres->maps);
            if (oldCoordinates.length > 0) {
                let first = oldCoordinates[0];
                markers[0] = L.marker([first.latitude, first.longitude], {
                    draggable: true
                }).addTo(mymap);
                mymap.setView([first.latitude, first.longitude], 15);
                markers[0].on('dragend', function(e) {
                    const pos = e.target.getLatLng();
                    document.querySelector('input[name="latitude"]').value = pos.lat;
                    document.querySelector('input[name="longitude"]').value = pos.lng;
                });
            }

            function onMapClick(e) {
                if (markers.length > 0) {
                    mymap.removeLayer(markers[0]);
                    document.querySelectorAll('.coordinates-container input').forEach(el => el.remove());
                    markers = [];
                }
                let marker = L.marker(e.latlng, {
                    draggable: true
                }).addTo(mymap);
                markers.push(marker);
                document.querySelector('.coordinates-container').innerHTML = `
                <input type="hidden" name="longitude" value="${e.latlng.lng}">
                <input type="hidden" name="latitude" value="${e.latlng.lat}">
            `;
                marker.on('dragend', function(event) {
                    let pos = event.target.getLatLng();
                    document.querySelector('input[name="latitude"]').value = pos.lat;
                    document.querySelector('input[name="longitude"]').value = pos.lng;
                });
            }
            mymap.on('click', onMapClick);
        </script>

    </main>
@endsection
