<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>iad_bf_kabupaten_lumajang</title>
    <style>
        /* 1. Tampilkan preloader sejak awal */
        #preloader {
            position: fixed;
            inset: 0;
            z-index: 999999;
            overflow: hidden;
            background: #fff;
            transition: all 0.6s ease-out;
            display: grid;
            place-items: center;
        }


        #preloader:before {
            content: "";
            width: 120px;
            height: 120px;
            border: 5px solid #196b4a;
            border-top-color: transparent;
            border-radius: 50%;
            animation: preloader-spin 1.5s linear infinite;
            grid-area: 1 / 1;
            z-index: 10;
        }

        #preloader img {
            /* Atur ukuran logo agar pas di DALAM spinner */
            width: 110px;
            /* Sesuaikan ukurannya */
            height: 110px;
            object-fit: contain;
            /* Biar logo tidak gepeng */

            /* --- TAMBAHAN PENTING --- */
            /* Taruh di tumpukan grid yang sama */
            grid-area: 1 / 1;
            z-index: 5;
            /* Pastikan logo di bawah spinner */
        }

        @keyframes preloader-spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Aturan untuk memunculkan konten setelah loading selesai */
        body.loaded>*:not(#preloader) {
            opacity: 1;
            visibility: visible;
        }

        /* Aturan untuk menghilangkan preloader dengan efek fade-out */
        body.loaded #preloader {
            opacity: 0;
            visibility: hidden;
        }


        /* 2. Sembunyikan semua elemen lain KECUALI preloader */
        body>*:not(#preloader) {
            opacity: 0;
            visibility: hidden;
        }

        /* 3. Atur transisi untuk konten saat muncul nanti */
        .main,
        .footer,
        .header {
            transition: opacity 0.5s ease-in-out;
        }
    </style>
    <meta name="description" content="">
    <meta name="keywords" content="">


    <link href="{{ asset('client/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('client/assets/css/main.css?v=1.2') }}" rel="stylesheet">
    <link href="{{ asset('client/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('client/assets/vendor/aos/aos.css') }}" rel="stylesheet">

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    {{-- <link href="{{ asset('client/assets/vendor/fontawesome5/css/all.min.css') }}"></link> --}}
    <link href="{{ asset('client/assets/vendor/fontawesome5/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('client/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <link href="{{ asset('client/assets/vendor/leaflet/leaflet.css') }}" rel="stylesheet">



    <style>
        .card-title {
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .informasi-content p {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        [data-aos] {
            opacity: 0;
            transition-property: opacity, transform;
        }


        /* 2. Sembunyikan konten utama SEBELUM halaman selesai loading */
        body:not(.loaded)>.main,
        body:not(.loaded)>.footer {
            opacity: 0;
        }

        /* 3. Atur efek transisi saat konten utama muncul */
        .main,
        .footer {
            transition: opacity 0.5s ease-in-out;
        }

        html.turbo-visit-from-cache .main,
        html.turbo-visit-from-cache .footer {
            opacity: 1 !important;
            transform: none !important;
        }

        html.turbo-visit .main,
        html.turbo-visit .footer {
            opacity: 0 !important;
            transition: none !important;
        }
    </style>

</head>

<body class="{{ request()->is('/') ? 'index-page' : '' }}">

    <div id="preloader">
        <img src="{{ asset('client/assets/img/logo-kabupaten.png') }}" alt="Logo Kabupaten">
    </div>
    @include('componentsclient.navbar')

    <main class="main">
        @yield('content')
    </main>

    <footer class="footer" data-aos="fade" data-aos-delay="200">
        <div class="footer-top">
            <div class="footer-left">
                <img src="{{ asset('client/assets/img/logo-kabupaten.png') }}" alt="Logo" class="footer-logo">
                <div class="footer-text">
                    <h2>Sekretariat IAD BF Kab.Lumajang</h2>
                    <p>IAD BF (Integrated Area Development Base Forestry) Lumajang yang merupakan sebuah sistem
                        pengelolaan hutan lestari dalam kawasan hutan negara</p>
                </div>
            </div>

            <div class="footer-right">
                <h4>Lokasi Kami</h4>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.6827081172446!2d113.22204627476988!3d-8.133748791896071!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd66788df5ac777%3A0x450462d4a3dc7616!2sBadan%20Perencanaan%20Pembangunan%20Daerah%20(BAPPEDA)%20Kabupaten%20Lumajang!5e0!3m2!1sid!2sid!4v1758613406822!5m2!1sid!2sid"
                    width="800" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>
        </div>
        @foreach ($contact as $kontak)
            <!-- Ikon sosial media -->
            <div class="footer-social">
                <a href="{{ $kontak->linkfb }}"><i class="bi bi-facebook"></i></a>
                <a href="{{ $kontak->linkig }}"><i class="bi bi-instagram"></i></a>
                <a href="{{ $kontak->linkyt }}"><i class="bi bi-youtube"></i></a>
            </div>
        @endforeach
        <!-- Copyright -->
        <div class="footer-bottom">
            <p>Support by <a href="https://diskominfo.lumajangkab.go.id/" class="showinfo">Dinas Komunikasi dan
                    Informatika Kab.
                    Lumajang</a></p>
        </div>
    </footer>

    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <script src="{{ asset('client/assets/vendor/jquery/jquery-3.6.0.min.js') }}"></script>

    <script src="{{ asset('client/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

    <script src="{{ asset('client/assets/vendor/leaflet/leaflet.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/chart/chart.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/highchart/highcharts.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/highchart/exporting.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/highchart/export-data.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/highchart/accessibility.js') }}"></script>


    <script>
        window.scrollToSection = @json($scrollTo ?? null);
    </script>
    <script src="{{ asset('client/assets/js/main.js') }}"></script>

    @stack('scripts')


    {{-- ↓↓↓ TAMBAHKAN SCRIPT BARU DI SINI ↓↓↓ --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Cek dulu apakah kita ada di halaman utama
            if (document.body.classList.contains('index-page')) {
                const sections = document.querySelectorAll("section[id]");
                if (sections.length > 0) {
                    const navLinks = document.querySelectorAll("#navmenu a");
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach((entry) => {
                            if (entry.isIntersecting) {
                                navLinks.forEach((link) => link.classList.remove("active"));
                                const id = entry.target.getAttribute("id");
                                const activeLink = document.querySelector(
                                    `#navmenu a[href*="#${id}"]`);
                                if (activeLink) {
                                    activeLink.classList.add("active");
                                }
                            }
                        });
                    }, {
                        threshold: 0.7
                    });
                    sections.forEach((section) => {
                        observer.observe(section);
                    });
                }
            }
        });
    </script>
</body>

</html>
