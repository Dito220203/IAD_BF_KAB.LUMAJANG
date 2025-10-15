@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>Peta Sebaran {{ $subprogram->subprogram }}</h2>
        </div>
        <section id="peta-program" class="peta-section">
            <div class="container">
                <div class="map-wrapper">
                    <div id="programMap"></div>
                </div>
            </div>

            <style>
                #programMap {
                    height: 500px;
                    width: 100%;
                }
            </style>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    var map = L.map('programMap').setView([-8.137, 113.226], 10);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="https://www.openstreetmap.org/">OSM</a>'
                    }).addTo(map);

                    delete L.Icon.Default.prototype._getIconUrl;

                    L.Icon.Default.mergeOptions({
                        iconRetinaUrl: "{{ asset('assets/vendor/leaflet/images/marker-icon-2x.png') }}",
                iconUrl: "{{ asset('assets/vendor/leaflet/images/marker-icon.png') }}",
                shadowUrl: "{{ asset('assets/vendor/leaflet/images/marker-shadow.png') }}"
                    });
                    var programs = @json($maps);

                    programs.forEach(p => {
                        if (p.latitude && p.longitude) {
                            L.marker([p.latitude, p.longitude]).addTo(map)
                                .bindPopup(`<b>${p.monev?.nama_progres ?? 'Tanpa Nama'}</b><br>ID: ${p.id}`);
                        } else {
                            console.warn("Data tidak punya koordinat:", p);
                        }
                    });
                });
            </script>
        </section>
    </section>
@endsection
