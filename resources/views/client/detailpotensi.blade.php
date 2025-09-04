@extends('componentsclient.layout')
@section('content')
<section class="section_page">
    <div class="global-title" data-aos="fade-up">
        <h2>IAD POTENSI WISATA</h2>
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
                    

                        <div class="produk">
                            <img src="{{ asset('client/assets/img/prdt3.jpg') }}" alt="Dokumentasi 1">
                        
                    </div>
                </div>

                <hr>
            </div>
        </section>

    
    <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="btn-footer-back">
                ← Kembali
            </a>
        </div>
</section>
@endsection