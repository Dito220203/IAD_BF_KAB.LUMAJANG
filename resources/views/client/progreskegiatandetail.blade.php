{{-- @extends('componentsclient.layout')
@section('content')


    <section class="section_page ">

        <div class="global-title" data-aos="fade-up">
            <h2>Detail Progres Kegiatan</h2>
        </div>

        <section id="detail-kegiatan" class="container">
            <div class="detail-card">
                <h3>Normalisasi Ranu Pani</h3>
                <p><strong>Tanggal:</strong> 01 Agustus 2025 13:45</p>
                <p><strong>Sumber Anggaran:</strong> APBD</p>
                <p><strong>Jumlah Anggaran:</strong> Rp xx.xxx.xxx,xx</p>
                <p><strong>Penerima:</strong> Masyarakat</p>

                <hr>

                <h4>Dokumentasi</h4>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">

                        <div class="swiper-slide">
                            <img src="{{ asset('client/assets/img/prdt3.jpg') }}" alt="Dokumentasi 1">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('client/assets/img/prdt5.jpg') }}" alt="Dokumentasi 2">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('client/assets/img/prdt4.jpg') }}" alt="Dokumentasi 3">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('client/assets/img/prdt3.jpg') }}" alt="Dokumentasi 1">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('client/assets/img/prdt5.jpg') }}" alt="Dokumentasi 2">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('client/assets/img/prdt4.jpg') }}" alt="Dokumentasi 3">
                        </div>


                    </div>
                </div>

                <hr>

                <h4>Peta Lokasi</h4>
                <iframe src="https://www.google.com/maps?q=-8.023,112.92&hl=id&z=14&output=embed" width="100%"
                    height="400" style="border:0;" allowfullscreen>
                </iframe>
            </div>
        </section>

        <div class="text-center mt-4">
            <a href="{{ url('/progreskegiatan') }}" class="btn-footer-back">
                ← Kembali ke Daftar
            </a>
        </div>

        <!-- SwiperJS CSS & JS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <script>
            var swiper = new Swiper(".mySwiper", {
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                slidesPerView: 1, // default mobile
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 150,
                    modifier: 1,
                    slideShadows: false,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2
                    },
                    1024: {
                        slidesPerView: 3
                    }
                }
            });
        </script>

    </section>
@endsection --}}

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

                <h4>Dokumentasi</h4>
                <div class="swiper mySwiper">
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
                {{-- @if ($progres->maps->count())
                    @php
                        $firstMap = $progres->maps->first();
                        $lat = $firstMap->latitude;
                        $lng = $firstMap->longitude;
                    @endphp

                    <iframe
                        src="https://www.google.com/maps?q={{ $lat }},{{ $lng }}&hl=id&z=14&output=embed"
                        width="100%" height="400" style="border:0;" allowfullscreen>
                    </iframe>
                @endif --}}
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
        </section>

        <div class="text-center mt-4">
            <a href="{{ url('/progreskegiatan') }}" class="btn-footer-back">
                ← Kembali ke Daftar
            </a>
        </div>

        <!-- SwiperJS CSS & JS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <script>
            var swiper = new Swiper(".mySwiper", {
                effect: "coverflow",
                grabCursor: true,
                centeredSlides: true,
                loop: true,
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                slidesPerView: 1, // default mobile
                coverflowEffect: {
                    rotate: 0,
                    stretch: 0,
                    depth: 150,
                    modifier: 1,
                    slideShadows: false,
                },
                breakpoints: {
                    768: {
                        slidesPerView: 2
                    },
                    1024: {
                        slidesPerView: 3
                    }
                }
            });
        </script>

    </section>
@endsection
