
@extends('componentsclient.layout')

@section('content')
    <section class="section_page video-detail">
        <section>
        <div class="detail-title-wrapper">
            <div class="global-title" data-aos="fade-up">
                {{-- Judul video akan muncul di sini --}}
                <h2>{{ $video->judul }}</h2>
            </div>
        </div>
        <div class="berita-card" data-aos="fade-up">
            <div class="berita-image" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; background: #000;">
                <iframe
                    style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0; z-index: 2;"
                    src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=0&rel=0&modestbranding=1&playsinline=1"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    title="{{ $video->judul }}">
                </iframe>
            </div>

            <div class="berita-date">
                {{ \Carbon\Carbon::parse($video->created_at)->translatedFormat('d F Y') }}
            </div>
            {{-- <div class="berita-divider"></div>

            <div class="berita-desc">
                <p>{!! $video->deskripsi !!}</p>
            </div> --}}
        </div>
        </section>

        <div class="text-center mt-4">
            <a href="{{ url('/') }}#video" class="btn-footer-back">
                ← Kembali 
            </a>
        </div>
    </section>
@endsection
