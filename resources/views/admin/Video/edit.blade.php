@extends('components.layout')
@section('content')
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Update Video</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Beranda</a></li>
                <li class="breadcrumb-item">Video</li>
                <li class="breadcrumb-item active">Update Video</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12"> {{-- Full width --}}
                <div class="card">
                    <div class="card-body pt-4">
                        <form action="{{ route('video.update', $video->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Judul Video --}}
                            <div class="row mb-3">
                                <label for="judul" class="col-sm-2 col-form-label">Judul Video</label>
                                <div class="col-sm-10">
                                    <input type="text" id="judul" name="e_judul"
                                           class="form-control"
                                           value="{{ old('judul', $video->judul) }}"
                                           required>
                                </div>
                            </div>

                            {{-- Link Video --}}
                            <div class="row mb-3">
                                <label for="link" class="col-sm-2 col-form-label">Link Video</label>
                                <div class="col-sm-10">
                                    <input type="text" id="link" name="e_link"
                                           class="form-control"
                                           value="{{ old('link', $video->link) }}"
                                           required>
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="row mb-3">
                                <div class="col-sm-10 offset-sm-2 d-flex gap-2">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <a href="{{ route('video') }}" class="btn btn-secondary">Kembali</a>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection
