@extends('componentsclient.layout')
@section('content')
    <section class="section_page ">

        <div class="global-title" data-aos="fade-up">
            <h2>Detail Progres Kegiatan</h2>
        </div>

        <section id="detail-kegiatan" class="container">
            <div class="detail-card">
                <h3>{{ $progres->judul }}</h3>
                <p><strong>Tanggal:</strong>
                    {{ \Carbon\Carbon::parse($progres->created_at)->translatedFormat('d F Y') }}</p>
                <p><strong>Sumber Anggaran:</strong> {{ $progres->sumber_dana }}</p>
                <p><strong>Jumlah Anggaran:</strong> {{ $progres->jumlah_anggaran }}</p>
                <p><strong>Penerima:</strong> {{ $progres->penerima }}</p>

                <hr>
                {{-- @php

                    $photoCount = $progres->fotoProgres->count();
                @endphp --}}

                <h4>Dokumentasi</h4>
                <div class="documentation-gallery mySwiper">
                    <div class="swiper-wrapper">
                        @forelse($progres->fotoProgres as $foto)
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/foto_progres/' . $foto->foto) }}" alt="Dokumentasi">
                            </div>
                        @empty
                            <div class="swiper-slide">
                                <img src="{{ asset('client/assets/img/default-video.jpg') }}" alt="Tidak ada dokumentasi">
                            </div>
                        @endforelse
                    </div>
                </div>

                <hr>

                <h4>Peta Lokasi</h4>
                <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

                <div id="map" style="height: 400px;"></div>
                <script>
                    var map = L.map('map').setView([0, 0], 5); 

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    @foreach ($progres->maps as $point)
                        var marker = L.marker([{{ $point->latitude }}, {{ $point->longitude }}]).addTo(map);
                    @endforeach

                    @if ($progres->maps->count())
                        map.setView([{{ $progres->maps->first()->latitude }}, {{ $progres->maps->first()->longitude }}], 5);
                    @endif
                </script>
            </div>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
            <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const gallery = document.querySelector(".mySwiper");

                    if (gallery) {
                        const slideCount = gallery.querySelectorAll(".swiper-slide").length;

                        // FINAL: Slider hanya aktif jika gambar 4 atau lebih
                        if (slideCount > 3) {

                            var swiper = new Swiper(".mySwiper", {
                                effect: "slide",
                                loop: true,
                                grabCursor: true,
                                speed: 900,

                                // KUNCI: Membuat slide aktif selalu di tengah
                                centeredSlides: true,

                                slidesPerView: 1.5, // Tampilkan 1 slide penuh dan sedikit slide sampingnya di mobile
                                spaceBetween: 20,

                                breakpoints: {
                                    // Tampilan untuk desktop
                                    1024: {
                                        slidesPerView: 3, // Tampilkan 3 slide
                                        spaceBetween: 30,
                                    }
                                },

                                autoplay: {
                                    delay: 3000,
                                    disableOnInteraction: false,
                                },

                                pagination: {
                                    el: '.swiper-pagination',
                                    clickable: true,
                                },

                                navigation: {
                                    nextEl: '.swiper-button-next',
                                    prevEl: '.swiper-button-prev',
                                },
                            });
                        }
                    }
                });
            </script>
        </section>
        <div class="text-center mt-4">
            <a href="{{ route('client.progreskegiatan', $progres->subprogram) }}" class="btn-footer-back">
                ← Kembali ke Daftar
            </a>
        </div>
    </section>
@endsection



