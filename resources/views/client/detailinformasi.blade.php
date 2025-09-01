@extends('componentsclient.layout')

@section('content')
<section class="section_page berita-detail">
    <div class="global-title" data-aos="fade-up">
        <h2>Judul Berita</h2>
    </div>

    <div class="berita-card" data-aos="fade-up">
        <!-- Foto -->
        <div class="berita-image">
            <img src="{{ asset('client/assets/img/tes.jpg') }}" alt="Gambar Berita">
        </div>

        <!-- Tanggal -->
        <div class="berita-date">
            01 Agustus 2025
        </div>
        <div class="berita-divider"></div>

        <!-- Deskripsi -->
        <div class="berita-desc">
            <p>
                Contrary to popular belief, Lorem Ipsum is not simply random text. 
                It has roots in a piece of classical Latin literature from 45 BC, 
                making it over 2000 years old. Richard McClintock, a Latin professor 
                at Hampden-Sydney College in Virginia, looked up one of the more 
                obscure Latin words, consectetur, from a Lorem Ipsum passage...
            </p>
        </div>
    </div>

    <div class="text-center mt-4">
        <a href="{{ url('/') }}" class="btn-footer-back">
            ← Kembali
        </a>
    </div>
</section>
@endsection
