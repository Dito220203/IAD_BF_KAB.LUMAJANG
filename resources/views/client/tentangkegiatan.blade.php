@extends('componentsclient.layout')
@section('content')
<section class="section_page">
    <div class="global-title" data-aos="fade-up">
        <h2>{{ $subprogram->subprogram }}</h2>
        <p>{{ $subprogram->uraian }}</p>
    </div>

    <section class="product-slider">
        <div class="slider-wrapper produk-tiap-program">
            @foreach ($fotosubprogram as $index => $foto)
                <div class="slide {{ $index == 0 ? 'active' : '' }}">
                    <div class="slide-image">
                        <img src="{{ asset('storage/' . $foto->foto) }}" alt="{{ $foto->judul }}">
                    </div>
                    <div class="slide-content">
                        <h3>{{ $foto->judul }}</h3>
                        <p>{{ $foto->keterangan }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
</section>
@endsection
