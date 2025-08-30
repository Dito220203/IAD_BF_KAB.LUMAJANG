@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>Peta Sebaran ..</h2>
        </div>
        <section id="peta-program" class="peta-section">
            <div class="container">
                <!-- Judul Global -->

                <!-- Wrapper Peta -->
                <div class="map-wrapper">
                    <div id="programMap"></div>
                </div>

            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Inisialisasi peta
                    var map = L.map('programMap').setView([-8.137, 113.226], 10); // contoh Lumajang

                    // Tambah tile layer
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="https://www.openstreetmap.org/">OSM</a>'
                    }).addTo(map);

                    // Contoh data program
                    var programs = [{
                            name: "Normalisasi Ranu Pani",
                            lokasi: "Lumajang",
                            coords: [-8.018, 112.944]
                        },
                        {
                            name: "Penanaman Mangrove",
                            lokasi: "Senduro",
                            coords: [-8.117, 113.117]
                        }
                    ];

                    // Loop marker
                    programs.forEach(p => {
                        L.marker(p.coords).addTo(map)
                            .bindPopup(`<b>${p.name}</b><br>${p.lokasi}`);
                    });
                });
            </script>
        </section>


    </section>
@endsection
