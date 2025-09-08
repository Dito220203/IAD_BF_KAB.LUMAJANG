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
                    {{ \Carbon\Carbon::parse($progres->created_at)->translatedFormat('d F Y H:i') }}</p>
                <p><strong>Sumber Anggaran:</strong> {{ $progres->sumber_dana }}</p>
                <p><strong>Jumlah Anggaran:</strong> {{ $progres->jumlah_anggaran }}</p>
                <p><strong>Penerima:</strong> {{ $progres->penerima }}</p>

                <hr>
                @php

                    $photoCount = $progres->fotoProgres->count();
                @endphp

                <h4>Dokumentasi</h4>
                <div class="documentation-gallery mySwiper" data-photo-count="{{ $photoCount }}">
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

                <div id="map" style="height: 400px;"></div>

                <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
                <script>
                    // Default center dan zoom kecil
                    var map = L.map('map').setView([0, 0], 5); // zoom 5 = jauh

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);

                    @foreach ($progres->maps as $point)
                        var marker = L.marker([{{ $point->latitude }}, {{ $point->longitude }}]).addTo(map);
                    @endforeach

                    // Kalau ada titik, pindah ke titik pertama saja (tanpa zoom otomatis)
                    @if ($progres->maps->count())
                        map.setView([{{ $progres->maps->first()->latitude }}, {{ $progres->maps->first()->longitude }}], 5);
                    @endif
                </script>



            </div>


            <div class="text-center mt-4">
                <a href="{{ url('/progreskegiatan') }}" class="btn-footer-back">
                    ← Kembali ke Daftar
                </a>
            </div>

            {{-- HANYA JALANKAN SWIPER JIKA GAMBAR LEBIH DARI 3 --}}

            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
            <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Targetkan elemen dengan class .mySwiper
                    const gallery = document.querySelector(".mySwiper");

                    // Pastikan elemen galeri ada di halaman ini
                    if (gallery) {
                        const slideCount = gallery.querySelectorAll(".swiper-slide").length;

                        // HANYA AKTIFKAN SWIPER JIKA GAMBAR LEBIH DARI 3
                        if (slideCount > 3) {
                            var swiper = new Swiper(".mySwiper", {
                                effect: "coverflow",
                                grabCursor: true,
                                centeredSlides: true,
                                loop: true,
                                slidesPerView: "auto",
                                speed: 800,
                                autoplay: {
                                    delay: 3000,
                                    disableOnInteraction: false,
                                },
                                coverflowEffect: {
                                    rotate: 0,
                                    stretch: 80,
                                    depth: 200,
                                    modifier: 1,
                                    slideShadows: false,
                                },
                                breakpoints: {
                                    768: {
                                        slidesPerView: 2,
                                    },
                                    1024: {
                                        slidesPerView: 3,
                                    }
                                }
                            });
                        }
                    }
                    // Jika gambar 3 atau kurang, tidak ada JS yang dijalankan,
                    // dan tampilan akan diatur sepenuhnya oleh CSS.
                });
            </script>

        </section>
    </section>
@endsection
