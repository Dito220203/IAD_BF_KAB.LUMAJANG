@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>What is Lorem Ipsum?</h2>
            <p>Kegiatan agorindustri di lokasi IAD Lumajang telah berkembang dengan baik diantaranya produksi susu sapi,
                susu kambing, kripik pisang, kripik talas, kopi, kapulaga dan sudah memliki jaringan pasca produksi
                (jaringan pasar) baik regional maupun nasional. Sasaran kegiatan agroindustri ini adalah membangun
                sentra-sentra pengolahan home industri berdasarkan potensi yang ada sehingga akan terbangun sentra
                pengolahan di tingkat desa antara lain Pengolahan kopi akan dibangun di Desa Burno, Desa Jambekumbu, Desa
                Pasrujambe, Pengolahan susu sapi dan kambing di Desa Burno., Pengolahan keripik pisang dan keripik talas di
                Desa Burno dan Desa Pasrujambe, Pengolahan Porang di Desa Pasrujambe.</p>
        </div>

        <section class="product-slider">

            <div class="slider-wrapper">
                <!-- Slide 1 -->
                <div class="slide active">
                    <div class="slide-image">
                        <img src="{{ asset('client/assets/img/prdt2.png') }}" alt="Produk 1">
                    </div>
                    <div class="slide-content">
                        <h2>Produk Pisang</h2>
                        <p>Pisang hasil KUPS yang segar dan siap konsumsi.</p>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="slide">
                    <div class="slide-image">
                        <img src="{{ asset('client/assets/img/prdt1.png') }}" alt="Produk 2">
                    </div>
                    <div class="slide-content">
                        <h2>Olahan Susu</h2>
                        <p>Susu segar yang diolah menjadi produk berkualitas tinggi.</p>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="slide">
                    <div class="slide-image">
                        <img src="{{ asset('client/assets/img/prdt1.png') }}" alt="Produk 3">
                    </div>
                    <div class="slide-content">
                        <h2>Kerajinan Bambu</h2>
                        <p>Produk ramah lingkungan hasil dari kreativitas masyarakat.</p>
                    </div>
                </div>
            </div>

        </section>
    </section>
@endsection
