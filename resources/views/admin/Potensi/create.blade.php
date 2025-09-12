@extends('components.layout')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Tambah Profil Kawasan IAD Perhutanan Sosial</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('potensi') }}">Beranda</a></li>
                    <li class="breadcrumb-item">Profil Kawasan IAD Perhutanan Sosial</li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ol>
            </nav>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3 mt-3">

                                <form action="{{ route('potensi.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    {{-- Judul --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Judul</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="judul" class="form-control" required>
                                            @error('judul')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Kecamatan --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Kecamatan</label>
                                        <div class="col-sm-10">
                                            <select id="kecamatanCreate" name="kecamatan" class="form-select">
                                                <option value="">Pilih</option>
                                                @foreach ($kecamatan as $data)
                                                    <option value="{{ $data->id }}" data-code="{{ $data->code }}">
                                                        {{ $data->name }}</option>
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
                                            <select id="desaCreate" name="desa" class="form-select">
                                                <option value="">Pilih</option>
                                            </select>
                                            @error('desa')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Gambar --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Gambar Depan</label>
                                        <div class="col-sm-10">
                                            <input type="file" name="image" class="form-control"
                                                accept=".jpg,.jpeg,.png" onchange="validateAndPreview(event)">

                                            {{-- Tempat preview gambar --}}
                                            <div class="mt-2">
                                                <img id="image-preview" src="#" alt="Preview Gambar"
                                                    style="max-height: 120px; display: none; border: 1px solid #ccc; padding: 5px;">
                                            </div>
                                            <small class="text-muted">* Format jpeg, jpg atau png. Maks. 2 MB</small>
                                            @error('image')
                                                <br><small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Script Preview + Validasi 2MB --}}
                                    <script>
                                        function validateAndPreview(event) {
                                            const file = event.target.files[0];
                                            const preview = document.getElementById('image-preview');

                                            if (file) {
                                                // cek ukuran max 2MB
                                                if (file.size > 2 * 1024 * 1024) {
                                                    alert("Ukuran file melebihi 2 MB. Silakan pilih gambar lain.");
                                                    event.target.value = ""; // reset input
                                                    preview.style.display = "none";
                                                    return;
                                                }

                                                // tampilkan preview
                                                preview.src = URL.createObjectURL(file);
                                                preview.style.display = "block";
                                            } else {
                                                preview.src = "#";
                                                preview.style.display = "none";
                                            }
                                        }
                                    </script>

                                    {{-- Tanggal --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Tanggal</label>
                                        <div class="col-sm-10">
                                            <input type="date" name="tanggal" class="form-control" required>
                                            @error('tanggal')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Keterangan --}}
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label">Keterangan</label>
                                        <div class="col-sm-10">
                                            <textarea name="uraian" class="form-control" rows="4" placeholder="Tulis keterangan..." required></textarea>
                                            @error('uraian')
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Tombol --}}
                                    <div class="row mb-3">
                                        <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                            <button type="submit" class="btn btn-success">Simpan</button>
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


        <script>
            $(document).ready(function() {
                $('#kecamatanCreate').on('change', function() {
                    let codeKecamatan = $(this).find(':selected').data('code');
                    console.log("code:", codeKecamatan);

                    let $desaSelect = $('#desaCreate');
                    $desaSelect.html('<option value="">Pilih</option>'); // reset

                    if (codeKecamatan) {
                        let url = "{{ url('/get-desa') }}/" + codeKecamatan;
                        console.log("fetch URL:", url);

                        $.ajax({
                            url: "{{ url('/get-desa') }}/" + codeKecamatan,
                            method: "GET",
                            dataType: "json",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                console.log("Response JSON:", response);
                                console.log("Kode diterima controller:", response.code);

                                let data = response.desa;
                                if (Array.isArray(data)) {
                                    data.forEach(function(desa) {
                                        $('#desaCreate').append(
                                            $('<option>', {
                                                value: desa.id,
                                                text: desa.name
                                            })
                                        );
                                    });
                                }
                            },

                            error: function(xhr, status, error) {
                                console.error("AJAX Error:", status, error);
                                console.log("Response text:", xhr.responseText);
                            }
                        });

                    }
                });
            });
        </script>


    </main>
@endsection
