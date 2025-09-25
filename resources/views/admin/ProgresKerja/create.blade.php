@extends('components.layout')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Tambah Progres</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</a></li>
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

            /* ===== Upload Foto Custom ===== */
            .upload-box {
                border: 2px dashed #4caf50;
                border-radius: 10px;
                padding: 30px;
                text-align: center;
                background: #f9fdf9;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .upload-box:hover {
                background: #f1fff1;
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
                border: 1px solid #ddd;
            }

            .upload-item span {
                flex: 1;
                font-size: 14px;
                color: #333;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .upload-item {
                position: relative;
                /* penting supaya child bisa absolute */

            }


            .upload-item .remove-btn {
                position: absolute;
                color: red;
                cursor: pointer;
                font-weight: bold;
                 right: 10px;

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

                            <form action="{{ route('progres.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                {{-- Sub Program --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Sub Program</label>
                                    <div class="col-sm-10">
                                        <select name="subprogram"
                                            class="form-select @error('subprogram') is-invalid @enderror" required>
                                            <option value="">Pilih</option>
                                            @foreach ($subprogram as $data)
                                                <option value="{{ $data->id }}"
                                                    {{ old('subprogram') == $data->id ? 'selected' : '' }}>
                                                    {{ $data->subprogram }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('subprogram')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Judul --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Judul Progres</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="judul"
                                            class="form-control @error('judul') is-invalid @enderror"
                                            value="{{ old('judul') }}" required>
                                        @error('judul')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Tahun --}}
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label">Tahun</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="tahun"
                                            class="form-control @error('tahun') is-invalid @enderror"
                                            value="{{ old('tahun') }}" required>
                                        @error('tahun')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
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
        <input type="text" name="jumlah_anggaran" id="jumlah_anggaran" 
               class="form-control" value="{{ old('jumlah_anggaran') }}">
    </div>
</div>

<script>
    document.getElementById('jumlah_anggaran').addEventListener('input', function(e) {
        let value = this.value.replace(/\D/g, ''); // hapus semua non-digit
        if (value) {
            value = parseInt(value).toLocaleString('id-ID'); // format ribuan
            this.value = 'Rp. ' + value; // tampil Rp. xx.xxx.xxx
        } else {
            this.value = '';
        }
    });
</script>

                                

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
                                        <div class="upload-box" onclick="document.getElementById('fileInput').click()">
                                            <p>Upload gambar progres<br>
                                                <small>Drag & drop atau klik untuk pilih (JPG, PNG, Maks 2MB)</small>
                                            </p>
                                            <input id="fileInput" type="file" name="foto[]" accept="image/*"
                                                class="hidden-input" multiple onchange="handleFiles(this.files)">
                                        </div>
                                        <div class="upload-list" id="uploadList"></div>
                                        <small class="text-muted d-block mt-2">
                                            Opsional. Format: jpg, jpeg, png. Maks 2MB per foto.
                                        </small>
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
            // ================== UPLOAD FOTO (Drag & Drop + Preview + Hapus) ==================
            let fileList = [];

            function handleFiles(files) {
                for (let file of files) {
                    if (file.size > 2 * 1024 * 1024) {
                        alert("Ukuran foto maksimal 2MB!");
                        continue;
                    }
                    if (!['image/jpeg', 'image/png', 'image/jpg'].includes(file.type)) {
                        alert("Format harus JPG atau PNG!");
                        continue;
                    }
                    fileList.push(file);
                }
                renderFileList();
            }

            function renderFileList() {
                const uploadList = document.getElementById("uploadList");
                uploadList.innerHTML = "";

                fileList.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const item = document.createElement("div");
                        item.classList.add("upload-item");
                        item.innerHTML = `
                            <img src="${e.target.result}">
                            <span>${file.name} (${(file.size / 1024).toFixed(1)} KB)</span>
                            <span class="remove-btn" onclick="removeFile(${index})">&times;</span>
                        `;
                        uploadList.appendChild(item);
                    }
                    reader.readAsDataURL(file);
                });

                // Sinkronkan ke input hidden supaya tetap terkirim ke backend
                const dt = new DataTransfer();
                fileList.forEach(file => dt.items.add(file));
                document.getElementById("fileInput").files = dt.files;
            }

            function removeFile(index) {
                fileList.splice(index, 1);
                renderFileList();
            }

            // Drag & Drop support
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

            // ================== LEAFLET MAP ==================
            var mymap = L.map('map').setView([-8.13439, 113.22208], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors',
                maxZoom: 18
            }).addTo(mymap);

            mymap.dragging.enable();
            mymap.scrollWheelZoom.enable();
            mymap.doubleClickZoom.enable();
            mymap.boxZoom.enable();
            mymap.keyboard.enable();

            var markers = [];

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

                let html = `
                    <input type="hidden" id="longitude" name="longitude" value="${e.latlng.lng}">
                    <input type="hidden" id="latitude" name="latitude" value="${e.latlng.lat}">
                `;
                document.querySelector('.coordinates-container').insertAdjacentHTML('beforeend', html);

                marker.on('dragend', function(event) {
                    let pos = event.target.getLatLng();
                    document.getElementById("latitude").value = pos.lat;
                    document.getElementById("longitude").value = pos.lng;
                });
            }

            mymap.on('click', onMapClick);
        </script>
    </main>
@endsection
