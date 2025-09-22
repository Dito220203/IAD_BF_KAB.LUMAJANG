@extends('components.layout')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Potensi Potensi</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beranda</a></li>
                    <li class="breadcrumb-item">Potensi</li>
                    <li class="breadcrumb-item active">Edit Potensi</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3 mt-3">

                                <form action="{{ route('potensi.update', $potensi->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Subpotensi</label>
                                        <div class="col-sm-10">
                                            <select name="id_subpotensi" class="form-select" required>
                                                <option value="">Pilih Subpotensi</option>
                                                @foreach ($subpotensi as $sub)
                                                    <option value="{{ $sub->id }}"
                                                        {{ $sub->id == $potensi->id_subpotensi ? 'selected' : '' }}>
                                                        {{ $sub->sub_potensi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                    {{-- Judul --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Judul</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="judul" class="form-control"
                                                value="{{ old('judul', $potensi->judul) }}" required>
                                            @error('judul')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Kecamatan --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Kecamatan</label>
                                        <div class="col-sm-10">
                                            <select id="kecamatanUpdate" name="kecamatan" class="form-select" required>
                                                <option value="">Pilih</option>
                                                @foreach ($kecamatan as $data)
                                                    <option value="{{ $data->id }}" data-code="{{ $data->code }}"
                                                        {{ old('kecamatan', $potensi->id_kecamatan) == $data->id ? 'selected' : '' }}>
                                                        {{ $data->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('kecamatan')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Desa --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Desa</label>
                                        <div class="col-sm-10">
                                            <select id="desaUpdate" name="desa" class="form-select" required>
                                                @foreach ($desa as $d)
                                                    <option value="{{ $d->id }}"
                                                        {{ old('desa', $potensi->id_desa) == $d->id ? 'selected' : '' }}>
                                                        {{ $d->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('desa')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Gambar (preview langsung ganti ke gambar baru saat pilih file) --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Gambar Depan</label>
                                        <div class="col-sm-10">
                                            <input type="file" id="imageInput" name="image" class="form-control"
                                                accept=".jpg,.jpeg,.png">

                                            <div class="mt-2">
                                                {{-- single img: tampilkan gambar lama di load pertama (jika ada) --}}
                                                <img id="image-preview"
                                                    src="{{ $potensi->gambar ? asset('storage/' . $potensi->gambar) : '#' }}"
                                                    alt="Preview Gambar"
                                                    style="max-height: 120px; {{ $potensi->gambar ? '' : 'display:none;' }}; border:1px solid #ccc; padding:5px;">
                                            </div>

                                            <small class="text-muted">* Format jpeg, jpg atau png. Maks. 2 MB</small>
                                            @error('image')
                                                <br><small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Tanggal --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Tanggal</label>
                                        <div class="col-sm-10">
                                            <input type="date" name="tanggal" class="form-control"
                                                value="{{ old('tanggal', $potensi->tanggal) }}" required>
                                            @error('tanggal')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Keterangan --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Keterangan</label>
                                        <div class="col-sm-10">
                                            <textarea name="uraian" class="form-control" rows="4" required>{{ old('uraian', $potensi->uraian) }}</textarea>
                                            @error('uraian')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Tombol --}}
                                    <div class="row mb-3">
                                        <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                            <button type="submit" class="btn btn-primary">Update</button>
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

        {{-- Script Ajax Desa + Preview Gambar --}}
        <script>
            $(document).ready(function() {
                // --- DESA / KECAMATAN (tetap seperti sebelumnya) ---
                let $desaSelect = $('#desaUpdate');
                let kecamatanId = $('#kecamatanUpdate').val();
                let desaId = "{{ old('desa', $potensi->id_desa) }}";

                if (kecamatanId) {
                    let codeKecamatan = $('#kecamatanUpdate').find(':selected').data('code');

                    $.ajax({
                        url: "{{ url('/get-desa') }}/" + codeKecamatan,
                        method: "GET",
                        dataType: "json",
                        success: function(response) {
                            let data = response.desa;
                            $desaSelect.empty();

                            if (Array.isArray(data)) {
                                data.forEach(function(desa) {
                                    $desaSelect.append(
                                        $('<option>', {
                                            value: desa.id,
                                            text: desa.name,
                                            selected: desa.id == desaId
                                        })
                                    );
                                });
                            }
                        }
                    });
                }

                $('#kecamatanUpdate').on('change', function() {
                    let codeKecamatan = $(this).find(':selected').data('code');
                    $desaSelect.html('<option value="">Pilih</option>');

                    if (codeKecamatan) {
                        $.ajax({
                            url: "{{ url('/get-desa') }}/" + codeKecamatan,
                            method: "GET",
                            dataType: "json",
                            success: function(response) {
                                let data = response.desa;
                                $desaSelect.html('<option value="">Pilih</option>');
                                if (Array.isArray(data)) {
                                    data.forEach(function(desa) {
                                        $desaSelect.append(
                                            $('<option>', {
                                                value: desa.id,
                                                text: desa.name
                                            })
                                        );
                                    });
                                }
                            }
                        });
                    }
                });

                // --- PREVIEW GAMBAR: langsung ganti ke gambar baru saat pilih file ---
                const imageInput = document.getElementById('imageInput');
                const previewImg = document.getElementById('image-preview');

                // simpan src asli (gambar lama) untuk revert jika user batal pilih
                const originalSrc = {!! json_encode($potensi->gambar ? asset('storage/' . $potensi->gambar) : '') !!};
                let objectUrl = null;

                function showOriginalOrHide() {
                    if (originalSrc) {
                        previewImg.src = originalSrc;
                        previewImg.style.display = 'block';
                    } else {
                        previewImg.src = '#';
                        previewImg.style.display = 'none';
                    }
                }

                function validateAndPreviewFile(file) {
                    if (!file) {
                        // user batal pilih -> kembalikan ke gambar lama
                        if (objectUrl) {
                            URL.revokeObjectURL(objectUrl);
                            objectUrl = null;
                        }
                        showOriginalOrHide();
                        return;
                    }

                    // cek ukuran max 2MB
                    if (file.size > 2 * 1024 * 1024) {
                        alert("Ukuran file melebihi 2 MB. Silakan pilih gambar lain.");
                        imageInput.value = '';
                        validateAndPreviewFile(null);
                        return;
                    }

                    // revoke objectUrl sebelumnya bila ada
                    if (objectUrl) {
                        URL.revokeObjectURL(objectUrl);
                        objectUrl = null;
                    }
                    objectUrl = URL.createObjectURL(file);
                    previewImg.src = objectUrl;
                    previewImg.style.display = 'block';
                }

                // bind event
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    validateAndPreviewFile(file);
                });

                // kalau page pertama kali load, pastikan tampil sesuai originalSrc
                showOriginalOrHide();
            });
        </script>

    </main>
@endsection
