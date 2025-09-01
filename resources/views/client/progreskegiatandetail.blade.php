@extends('componentsclient.layout')
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
@endsection
