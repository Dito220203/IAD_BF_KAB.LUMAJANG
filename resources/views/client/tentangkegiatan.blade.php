{{-- STRUKTUR YANG BENAR --}}
@extends('componentsclient.layout')

@section('content')
    <section class="section_page">
        <div class="container">
            {{-- Bagian Judul Halaman --}}
            <div class="global-title" data-aos="fade-up">
                <h2>{{ $subprogram->subprogram }}</h2>
                <p>{{ $subprogram->uraian }}</p>
            </div> {{-- Tutup div global-title SEBELUM slider --}}

            {{-- Bagian Slider (sekarang berada di luar global-title) --}}
            <section class="product-slider">
                <div class="slider-wrapper">
                    @forelse ($fotosubprogram as $index => $foto)
                        <div class="slide {{ $index == 0 ? 'active' : '' }}">
                            <div class="slide-image">
                                <img src="{{ asset('storage/' . $foto->foto) }}" alt="{{ $foto->judul }}">
                            </div>
                            <div class="slide-content">
                                <h2>{{ $foto->judul }}</h2>
                                <p>{{ $foto->keterangan }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="slide">
                            <p>No photos available for this activity.</p>
                        </div>
                    @endforelse
                </div>
                <button class="slider-btn prev-btn">&lt;</button>
                <button class="slider-btn next-btn">&gt;</button>
            </section>
        </div>
    </section>
@endsection