@extends('componentsclient.layout')

@section('content')
    {{-- Section for the page title --}}
    <section class="section_page">
        <div class="container">
            <div class="global-title" data-aos="fade-up">
                <h2>{{ $subprogram->subprogram }}</h2>
                <p>{{ $subprogram->uraian }}</p>
            </div>
        </div>
    </section>

    {{-- A completely SEPARATE section for the slider --}}
    <section class="product-slider">
        <div class="slider-wrapper">
            @forelse ($fotosubprogram as $index => $foto)
                <div class="slide {{ $index == 0 ? 'active' : '' }}">
                    <div class="slide-image">
                        <img src="{{ asset('storage/' . $foto->foto) }}" alt="{{ $foto->judul }}">
                    </div>
                    <div class="slide-content">
                        <h3>{{ $foto->judul }}</h3>
                        <p>{{ $foto->keterangan }}</p>
                    </div>
                </div>
            @empty
                <div class="slide">
                    <p>No photos available for this activity.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection