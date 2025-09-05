<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>IAD BF Kabupaten Lumajang</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&family=Raleway:wght@300;400;500;700;900&family=Inter:wght@300;400;500;700;900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('client/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('client/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('client/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('client/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('client/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('client/assets/css/main.css') }}" rel="stylesheet">

    <!-- Fontawesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

</head>


<style>
    .card-title {
        display: -webkit-box;
        -webkit-line-clamp: 4;
        /* tampil maksimal 4 baris */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .informasi-content p {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        /* tampil max 3 baris */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<body class="{{ request()->is('/') ? 'index-page' : '' }}">

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
                    <p>
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been
                        the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book.
                    </p>
                </div>
            </div>

            <div class="footer-right">
                <h4>Lokasi Kami</h4>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1149.7691005550853!2d113.22426593916795!3d-8.133718248713254!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd66788df5ac777%3A0x450462d4a3dc7616!2sBadan%20Perencanaan%20Pembangunan%20Daerah%20(BAPPEDA)%20Kabupaten%20Lumajang!5e0!3m2!1sid!2sid!4v1754984376758!5m2!1sid!2sid"
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                </iframe>
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
            <p>Support by <a href="https://diskominfo.lumajangkab.go.id/" class="showinfo">Dinas Komunikasi dan Informatika Kab.
                    Lumajang</a></p>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('client/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('client/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="{{ asset('client/assets/js/main.js') }}"></script>

    <!-- chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/highcharts-3d.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
</body>

</html>
