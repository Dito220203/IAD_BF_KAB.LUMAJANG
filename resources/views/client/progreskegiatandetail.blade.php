@extends('componentsclient.layout')

@section('content')

    <section class="section_page ">
        <div class="global-title" data-aos="fade-up">
            <h2>Detail Progres Kegiatan</h2>
        </div>

        <section id="detail-kegiatan" class="container">
            <div class="detail-card">
                <h3>{{ $progres->judul }}</h3>
                <p><strong>Tahun Pelaksanaan :</strong> {{ $progres->monev->tahun ?? '-' }}</p>
                <p><strong>Uraian :</strong>
                    @forelse($progres->fotoProgres as $foto)
                        {{ $foto->deskripsi ?? '-' }}
                        @break
                    @empty
                        Belum ada Uraian
                    @endforelse
                </p>

                <hr>

                <h4>Dokumentasi</h4>
                <div class="documentation-gallery mySwiper">
                    <div class="swiper-wrapper">
                        @forelse($progres->fotoProgres as $foto)
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/' . $foto->foto) }}" alt="Dokumentasi Kegiatan">
                            </div>
                        @empty
                            <p class="text-center">Tidak ada dokumentasi.</p>
                        @endforelse
                    </div>
                </div>

                <hr>

                <h4>Peta Lokasi</h4>
                <div id="map" style="height: 400px;"></div>
            </div>
        </section>

        <div class="text-center mt-4">
            <a href="{{ route('client.progreskegiatan', $progres->monev->id_subprogram) }}" class="btn-footer-back">
                ← Kembali ke Daftar
            </a>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
      const gallery = document.querySelector(".mySwiper");

    if (gallery) {
        const slideCount = gallery.querySelectorAll(".swiper-slide").length;
        const screenWidth = window.innerWidth;

        // 🔧 Ubah logika agar loop aktif jika ada lebih dari 1 gambar
        if (slideCount > 1) {

            var swiper = new Swiper(".mySwiper", {
                effect: "slide",
                loop: true, // ✅ Selalu aktif jika gambar > 1
                grabCursor: true,
                speed: 900,

                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },

                // Default: mobile
                slidesPerView: 1.2,
                spaceBetween: 10,
                centeredSlides: true, // tetap center agar visual halus

                breakpoints: {
                    768: {
                        slidesPerView: 1.5,
                        spaceBetween: 20,
                        centeredSlides: true,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 30,
                        centeredSlides: true,
                    }
                }
            });

        } else {
            // Layout statis (jika cuma 1 gambar)
            gallery.classList.add('static-layout');
            gallery.classList.add('static-layout-1');
        }
    }
            // --- Bagian Peta (Leaflet.js) tidak diubah ---
            delete L.Icon.Default.prototype._getIconUrl;
            L.Icon.Default.mergeOptions({
                iconRetinaUrl: "{{ asset('assets/vendor/leaflet/images/marker-icon-2x.png') }}",
                iconUrl: "{{ asset('assets/vendor/leaflet/images/marker-icon.png') }}",
                shadowUrl: "{{ asset('assets/vendor/leaflet/images/marker-shadow.png') }}"
            });

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
        });
    </script>
@endpush