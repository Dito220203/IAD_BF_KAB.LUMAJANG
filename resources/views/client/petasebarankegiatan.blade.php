@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>Peta Sebaran {{ $subprogram->subprogram }}</h2>
        </div>
        <section id="peta-program" class="peta-section">
            <div class="container">
                <!-- Wrapper Peta -->
                <div class="map-wrapper">
                    <div id="programMap"></div>
                </div>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var map = L.map('programMap').setView([-8.137, 113.226], 10);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="https://www.openstreetmap.org/">OSM</a>'
                    }).addTo(map);

                    // Data dari Laravel
                    var programs = @json($maps);

                    programs.forEach(p => {
                        L.marker([p.latitude, p.longitude]).addTo(map)
                            .bindPopup(`<b>${p.progres?.nama_progres ?? 'Tanpa Nama'}</b><br>ID: ${p.id}`);
                    });
                });
            </script>

        </section>
    </section>
@endsection
