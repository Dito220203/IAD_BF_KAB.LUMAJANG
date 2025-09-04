@extends('componentsclient.layout')
@section('content')
    <section class="section_page">

        <div class="global-title" data-aos="fade-up">
            <h2>sesuai judul</h2>
        </div>

        <section id="detail-kegiatan" class="container">
            <div class="detail-card">
                <h3>Normalisasi Ranu Pani</h3>
                <p><strong>Keterangan:</strong> There are many variations of passages of Lorem Ipsum available, but the
                    majority have suffered alteration in some form, by injected humour, or randomised words which don't look
                    even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there
                    isn't anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet
                    tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.</p>

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
            </div>
        </section>

        <div class="text-center mt-4">
            <a href="{{ url('/profilkawasan') }}" class="btn-footer-back">
                ← Kembali ke Daftar
            </a>
        </div>

        <!-- SwiperJS CSS & JS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const slideCount = document.querySelectorAll(".mySwiper .swiper-slide").length;

                var swiper = new Swiper(".mySwiper", {
                    effect: "coverflow",
                    grabCursor: true,
                    centeredSlides: true,
                    loop: slideCount > 1, // aktifkan loop kalau lebih dari 1 gambar
                    loopedSlides: slideCount, // duplikasi semua supaya seamless
                    speed: 800, // biar halus
                    autoplay: slideCount > 3 ? {
                        delay: 2500,
                        disableOnInteraction: false,
                    } : false,
                    slidesPerView: Math.min(slideCount, 3),
                    coverflowEffect: {
                        rotate: 0,
                        stretch: 0,
                        depth: 150,
                        modifier: 1,
                        slideShadows: false,
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: Math.min(slideCount, 3)
                        },
                        1024: {
                            slidesPerView: Math.min(slideCount, 3)
                        }
                    }
                });
            });
        </script>



    </section>
@endsection
