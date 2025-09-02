@extends('componentsclient.layout')

@section('content')
<section class="section_page berita-detail">
    <div class="global-title" data-aos="fade-up">
        <h2>{{ $info->judul }}</h2>
    </div>

    <div class="berita-card" data-aos="fade-up">
        <!-- Foto -->
        <div class="berita-image">
            <img src="{{ asset('storage/' . $info->foto) }}" alt="Gambar Berita">
        </div>

        <!-- Tanggal -->
        <div class="berita-date">
            {{ $info->tanggal }}
        </div>
        <div class="berita-divider"></div>

        <!-- Deskripsi -->
        <div class="berita-desc">
            <p>{!! $info->isi !!}</p>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ url('/') }}" class="btn-footer-back">
            ← Kembali
        </a>
    </div>
</section>
@endsection
