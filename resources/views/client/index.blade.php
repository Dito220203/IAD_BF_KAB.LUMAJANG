@extends('componentsclient.layout')
@section('content')
    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">
            @foreach ($banner as $item)
                @php
                    $extension = pathinfo($item->file, PATHINFO_EXTENSION);
                @endphp

                @if (in_array(strtolower($extension), ['mp4', 'webm', 'ogg']))
                    <!-- Video -->
                    <video autoplay loop muted playsinline class="background-video">
                        <source src="{{ asset('storage/' . $item->file) }}" type="video/{{ $extension }}">
                    </video>
                @else
                    <!-- Gambar -->
                    <img src="{{ asset('storage/' . $item->file) }}" alt="{{ $item->judul }}" class="img-fluid w-100">
                @endif
            @endforeach
            <div class="content-wrapper">
                <div class="container d-flex flex-column align-items-center">
                    <img src="{{ asset('client/assets/img/logo-kabupaten.png') }}" alt="Logo Kabupaten"
                        data-aos="fade-in"class="hero-logo">
                    @foreach ($gambaran as $tulis)
                        <p data-aos="fade-up" data-aos-delay="200">{{ $tulis->uraian }}</p>
                    @endforeach
                </div>
            </div>
        </section><!-- /Hero Section -->

        <!-- card perhut -->
        <section id="perhut" class="perhutanan">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="global-title">
                    <h2>IAD PERHUTANAN SOSIAL KABUPATEN LUMAJANG</h2>
                </div>
                <div class="perhut-cards" data-aos="fade-down" data-aos-delay="200" id="PerhutCards">
                    <div class="row gy-4">

                        <!-- Card 1 -->
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ url('/detailluasperhutanan') }}" class="stats-link">
                                <div class="stats-card">
                                    <div>
                                        <div class="stats-icon"><i class="fa fa-tree"></i></div>
                                    </div>
                                    <p class="stats-label">Luas Perhutanan Sosial</p>

                                    <span class="stats-number purecounter" data-purecounter-start="0"
                                        data-purecounter-end="{{ $jumlahKth }}" data-purecounter-decimals="0"
                                        data-purecounter-duration="1"></span>
                                </div>
                            </a>
                        </div>
                        <!-- Card 2 -->
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ url('/detailkth_kups') }}">
                                <div class="stats-card">
                                    <div>
                                        <div class="stats-icon"><i class="fas fa-users"></i></div>
                                    </div>
                                    <p class="stats-label">Kelompok Tani Hutan (KTH)</p>
                                    <span class="stats-number purecounter" data-purecounter-start="0"
                                        data-purecounter-end="{{ $jumlahKth }}" data-purecounter-decimals="0"
                                        data-purecounter-duration="1"></span>
                                </div>
                            </a>
                        </div>
                        <!-- Card 3 -->

                        <div class="col-lg-3 col-md-6">
                            <a href="{{ url('/detaikups') }}">
                                <div class="stats-card">
                                    <div>
                                        <div class="stats-icon"><i class="fas fa-store"></i></div>
                                    </div>
                                    <p class="stats-label"> Kelompok Usaha Perhutanan Sosial (KUPS)</p>
                                    <span class="stats-number purecounter" data-purecounter-start="0"
                                        data-purecounter-end="{{ $jumlahKups }}" data-purecounter-decimals="0"
                                        data-purecounter-duration="1"></span>
                                </div>
                            </a>
                        </div>

                        <!-- Card 4 -->
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ url('/detailekonomi') }}">
                                <div class="stats-card">
                                    <div>
                                        <div class="stats-icon">
                                            <i class="fas fa-sack-dollar"></i>
                                        </div>

                                    </div>
                                    <p class="stats-label">Nilai Ekonomi</p>

                                    <span class="stats-number"><span class="purecounter" data-purecounter-start="0"
                                            data-purecounter-end="{{ $jumlahKups }}" data-purecounter-decimals="0"
                                            data-purecounter-duration="1"></span></span>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>

            </div>

            @php
                use Illuminate\Support\Arr;

                // Ambil kategori unik dan hitung jumlah produk per kategori
                $kategoriData = \App\Models\Kups::select('kategori')
                    ->selectRaw('COUNT(*) as total')
                    ->groupBy('kategori')
                    ->get();

                // Labels (kategori)
                $labels = $kategoriData->pluck('kategori')->toArray();

                // Data (jumlah per kategori)
                $data = $kategoriData->pluck('total')->toArray();

                // Generate warna random untuk setiap kategori
                $backgroundColor = [];
                foreach ($labels as $label) {
                    $backgroundColor[] = '#' . substr(md5($label), 0, 6); // warna unik dari nama kategori
                }
            @endphp

            <section id="chart_perhut" class="perhutanan">
                <div class="chart-container" style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: center;"
                    data-aos="fade-up" data-aos-delay="250">
                    <div class="chart-box"
                        style="flex: 1; min-width: 300px; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <canvas id="donutChart"></canvas>
                    </div>
                </div>
            </section>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const donutCtx = document.getElementById('donutChart').getContext('2d');
                    new Chart(donutCtx, {
                        type: 'doughnut',
                        data: {
                            labels: @json($labels),
                            datasets: [{
                                data: @json($data),
                                backgroundColor: @json($backgroundColor)
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                });
            </script>


        </section>

        <!-- JUMLAH PENDAPATAN TIAP KUPS -->
        {{-- <section id="kups" class="kups">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="global-title">
                    <h2>IAD POTENSI TIAP KUPS</h2>
                </div>

                <!-- SCROLL WRAPPER -->
                <div class="kups-cards" data-aos="fade-down" data-aos-delay="200">
                    <div class="kups-scroll">
                        <div class="row gy-4 flex-nowrap">

                            <!-- Card 1 -->
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ url('/daftarpotensi') }}">
                                    <div class="stats-card">
                                        <div class="stats-icon"><i class="fa-solid fa-cow"></i></div>
                                        <p class="stats-label">POTENSI PETERNAKAN</p>
                                        <span class="stats-number purecounter" data-purecounter-start="0"
                                            data-purecounter-end="123" data-purecounter-duration="1"></span>
                                    </div>
                                </a>
                            </div>

                            <!-- Card 2 -->
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ url('/daftarpotensi') }}">
                                    <div class="stats-card">
                                        <div class="stats-icon"><i class="fas fa-mountain"></i></div>
                                        <p class="stats-label">POTENSI GUNUNG</p>
                                        <span class="stats-number">88</span>
                                    </div>
                                </a>
                            </div>

                            <!-- Card lainnya... -->
                            <div class="col-lg-3 col-md-6">
                                <a href="{{ url('/daftarpotensi') }}">
                                    <div class="stats-card">
                                        <div class="stats-icon"><i class="fas fa-mountain"></i></div>
                                        <p class="stats-label">POTENSI GUNUNG</p>
                                        <span class="stats-number">88</span>
                                    </div>
                                </a>
                            </div>
                            
                        </div>
                    </div>
                </div>


            </div>

            <!-- chart kups Section -->
            <div data-aos="fade-up" data-aos-delay="250" id="pendapatanChart" class="pendapatanChart">
            </div>

            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    // Contoh data, nanti bisa diganti dari card
                    const dataValues = [
                        ['Pisang', 182.93],
                        ['Olahan Susu', 222.44],
                        ['Potensi Peternakan', 151.41],
                        ['Olahan Kopi', 154.00]
                    ];

                    Highcharts.chart('pendapatanChart', {
                        chart: {
                            type: 'pie',
                            backgroundColor: '#fff', // putih
                            options3d: {
                                enabled: true,
                                alpha: 30, // kemiringan pas, tidak terlalu miring
                                beta: 0
                            }
                        },
                        title: {
                            text: 'Nilai Ekonomi Tiap KUPS'
                        },
                        subtitle: {
                            text: 'Unit: Dalam Rupiah',
                            align: 'right'
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                depth: 25, // tipis → tidak timpang tindih
                                borderWidth: 2, // garis pemisah antar slice
                                borderColor: '#fff', // garis putih biar rapi
                                dataLabels: {
                                    enabled: true,
                                    format: '{point.name} <br> <span style="color:{point.color};">{point.y:,.2f}</span> ({point.percentage:.2f}%)',
                                    connectorColor: 'silver'
                                },
                                showInLegend: true
                            }
                        },
                        tooltip: {
                            pointFormat: '{series.name}: <b>{point.y:,.2f}</b> ({point.percentage:.2f}%)'
                        },
                        series: [{
                            name: 'Pendapatan',
                            data: [
                                ['Pisang', 182.93],
                                ['Olahan Susu', 222.44],
                                ['Potensi Peternakan', 151.41],
                                ['Olahan Kopi', 154.00]
                            ],
                            colors: ['#9370DB', '#FF7F7F', '#00CED1', '#FFA500']
                        }]
                    });

                });
            </script>

        </section> --}}
        <section id="kups" class="kups">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="global-title">
                    <h2>IAD POTENSI TIAP KUPS</h2>
                </div>

                <div class="kups-cards" data-aos="fade-down" data-aos-delay="200">
                    <div class="kups-scroll">
                        <div class="row gy-4 flex-nowrap">

                            <div class="col-lg-4 col-md-6">
                                <a href="{{ url('/daftarpotensi') }}">
                                    <div class="stats-card">
                                        <div class="stats-icon"><i class="fa-solid fa-cow"></i></div>
                                        <p class="stats-label">POTENSI PETERNAKAN</p>
                                        <span class="stats-number purecounter" data-purecounter-start="0"
                                            data-purecounter-end="123" data-purecounter-duration="1"></span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <a href="{{ url('/daftarpotensi') }}">
                                    <div class="stats-card">
                                        <div class="stats-icon"><i class="fas fa-mountain"></i></div>
                                        <p class="stats-label">POTENSI GUNUNG</p>
                                        <span class="stats-number">88</span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <a href="{{ url('/daftarpotensi') }}">
                                    <div class="stats-card">
                                        <div class="stats-icon"><i class="fa-solid fa-leaf"></i></div>
                                        <p class="stats-label">POTENSI PERKEBUNAN</p>
                                        <span class="stats-number">154</span>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-4 col-md-6">
                                <a href="{{ url('/daftarpotensi') }}">
                                    <div class="stats-card">
                                        <div class="stats-icon"><i class="fa-solid fa-fish"></i></div>
                                        <p class="stats-label">POTENSI PERIKANAN</p>
                                        <span class="stats-number">72</span>
                                    </div>
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="kups-pagination" id="kupsPagination"></div>

                <div data-aos="fade-up" data-aos-delay="250" id="pendapatanChart" class="pendapatanChart">
                </div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        // Contoh data, nanti bisa diganti dari card
                        const dataValues = [
                            ['Pisang', 182.93],
                            ['Olahan Susu', 222.44],
                            ['Potensi Peternakan', 151.41],
                            ['Olahan Kopi', 154.00]
                        ];

                        Highcharts.chart('pendapatanChart', {
                            chart: {
                                type: 'pie',
                                backgroundColor: '#fff', // putih
                                options3d: {
                                    enabled: true,
                                    alpha: 30, // kemiringan pas, tidak terlalu miring
                                    beta: 0
                                }
                            },
                            title: {
                                text: 'Nilai Ekonomi Tiap KUPS'
                            },
                            subtitle: {
                                text: 'Unit: Dalam Rupiah',
                                align: 'right'
                            },
                            plotOptions: {
                                pie: {
                                    allowPointSelect: true,
                                    cursor: 'pointer',
                                    depth: 25, // tipis → tidak timpang tindih
                                    borderWidth: 2, // garis pemisah antar slice
                                    borderColor: '#fff', // garis putih biar rapi
                                    dataLabels: {
                                        enabled: true,
                                        format: '{point.name} <br> <span style="color:{point.color};">{point.y:,.2f}</span> ({point.percentage:.2f}%)',
                                        connectorColor: 'silver'
                                    },
                                    showInLegend: true
                                }
                            },
                            tooltip: {
                                pointFormat: '{series.name}: <b>{point.y:,.2f}</b> ({point.percentage:.2f}%)'
                            },
                            series: [{
                                name: 'Pendapatan',
                                data: [
                                    ['Pisang', 182.93],
                                    ['Olahan Susu', 222.44],
                                    ['Potensi Peternakan', 151.41],
                                    ['Olahan Kopi', 154.00]
                                ],
                                colors: ['#9370DB', '#FF7F7F', '#00CED1', '#FFA500']
                            }]
                        });


                        // --- GANTI SCRIPT PAGINATION LAMA ANDA DENGAN YANG INI ---

                        const kupsCardsContainer = document.querySelector(".kups-scroll .row");
                        const kupsPagination = document.getElementById("kupsPagination");

                        if (kupsCardsContainer && kupsPagination) {
                            let cardWidth = 0;
                            let scrollStep = 0;
                            let totalPages = 0;

                            function setupKupsPagination() {
                                // ==================================================================
                                // INI PERBAIKANNYA: Targetkan '.col-lg-4' sesuai HTML Anda
                                const firstCard = kupsCardsContainer.querySelector(".col-lg-4");
                                // ==================================================================
                                if (!firstCard) return;

                                const isMobile = window.innerWidth < 992;
                                const cardsToScroll = isMobile ? 1 : 3;

                                const gap = parseInt(window.getComputedStyle(kupsCardsContainer).gap) || 20;
                                cardWidth = firstCard.offsetWidth + gap;
                                scrollStep = cardWidth * cardsToScroll;

                                // Cek jika ada cukup kartu untuk di-scroll
                                if (kupsCardsContainer.scrollWidth > kupsCardsContainer.clientWidth) {
                                    totalPages = Math.ceil((kupsCardsContainer.scrollWidth - kupsCardsContainer.clientWidth +
                                        gap) / scrollStep) + 1;
                                } else {
                                    totalPages = 1;
                                }

                                updateKupsPaginationDots();
                            }

                            function updateKupsPaginationDots() {
                                kupsPagination.innerHTML = "";

                                if (totalPages <= 1) {
                                    return;
                                }

                                for (let i = 0; i < totalPages; i++) {
                                    const dot = document.createElement("span");
                                    dot.classList.add("dot");
                                    if (i === 0) dot.classList.add("active");

                                    dot.addEventListener("click", () => {
                                        kupsCardsContainer.parentElement.scrollTo({
                                            left: i * scrollStep,
                                            behavior: "smooth",
                                        });
                                    });
                                    kupsPagination.appendChild(dot);
                                }
                            }

                            function setActiveKupsDot() {
                                const dots = kupsPagination.querySelectorAll(".dot");
                                if (dots.length === 0) return;

                                const container = kupsCardsContainer.parentElement;
                                // Gunakan pembulatan yang lebih presisi untuk posisi scroll
                                const index = Math.floor((container.scrollLeft + container.clientWidth / 2) / scrollStep);

                                dots.forEach((dot, i) => {
                                    dot.classList.toggle("active", i === index);
                                });
                            }

                            // Event listeners
                            window.addEventListener("resize", setupKupsPagination);
                            kupsCardsContainer.parentElement.addEventListener("scroll", setActiveKupsDot);
                            window.addEventListener('load', setupKupsPagination);
                            setupKupsPagination();
                        }
                    });
                </script>

        </section>
        <!-- /JUMLAH PENDAPATAN TIAP KUPS -->

        <!-- PRODUCT KUPS -->
        <section class="product-slider">
            <div class="slider-wrapper">
                @foreach ($produkKups as $index => $produk)
                    <div class="slide {{ $index === 0 ? 'active' : '' }}">
                        <div class="slide-image">
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}">
                        </div>
                        <div class="slide-content">
                            <h2>{{ $produk->nama }}</h2>
                            <p>{{ $produk->keterangan }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <!-- /PRODUCT KUPS -->

        <!-- Informasi Section -->
        <section class="informasi-section" id="informasisection">
            <div class="global-title">
                <h2>INFORMASI</h2>
            </div>
            <div class="informasi-wrapper">
                <div class="informasi-cards" data-aos="fade-left" data-aos-delay="200" id="informasiCards">

                    @forelse ($informasi as $info)
                        <div class="informasi-card">
                            <div class="informasi-image">
                                <img src="{{ asset('storage/' . $info->foto) }}" alt="{{ $info->judul }}">
                            </div>
                            <div class="informasi-content">
                                <h3 class="card-title">{{ $info->judul }}</h3>
                                <p>
                                    {!! Str::words($info->isi, 20, '...') !!}
                                </p>

                                <div class="informasi-footer">
                                    <span>{{ $info->tanggal }}</span>
                                    <a href="{{ route('informasi.show', $info->id) }}">Lebih Lengkap...</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Tidak ada informasi.</p>
                    @endforelse

                </div>

                <!-- Pagination -->
                <div class="informasi-pagination" id="informasiPagination"></div>

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        const cardsContainer = document.querySelector(".informasi-cards");
                        const pagination = document.querySelector(".informasi-pagination");

                        let cardWidth = 0;
                        let scrollStep = 0;
                        let totalPages = 0;

                        function updateCardWidth() {
                            const firstCard = cardsContainer.querySelector(".informasi-card");
                            if (!firstCard) return;

                            const style = window.getComputedStyle(firstCard);
                            const marginRight = parseInt(style.marginRight) || 0;
                            cardWidth = firstCard.offsetWidth + marginRight;

                            // tampilkan 4 card, scroll 3 card
                            scrollStep = cardWidth * 3;

                            // hitung total page
                            totalPages = Math.ceil(cardsContainer.scrollWidth / scrollStep);

                            updatePagination();
                        }

                        function updatePagination() {
                            pagination.innerHTML = "";

                            for (let i = 0; i < totalPages; i++) {
                                const dot = document.createElement("span");
                                dot.classList.add("dot");
                                if (i === 0) dot.classList.add("active");

                                dot.addEventListener("click", () => {
                                    cardsContainer.scrollTo({
                                        left: i * scrollStep,
                                        behavior: "smooth",
                                    });
                                });

                                pagination.appendChild(dot);
                            }
                        }

                        function setActiveDot() {
                            const dots = pagination.querySelectorAll(".dot");
                            const index = Math.round(cardsContainer.scrollLeft / scrollStep);

                            dots.forEach((dot, i) => {
                                dot.classList.toggle("active", i === index);
                            });
                        }

                        window.addEventListener("resize", updateCardWidth);
                        cardsContainer.addEventListener("scroll", setActiveDot);

                        updateCardWidth();
                    });
                </script>
            </div>
        </section>

        <!-- video Section -->
        <section class="video-section" id="videosection">
            <div class="global-title" data-aos="fade-up">
                <h2>VIDEO</h2>
            </div>
            <div class="video-wrapper">
                <div class="video-cards" data-aos="fade-left" data-aos-delay="200" id="informasiCards">
                    @forelse ($videos as $video)
                        @php
                            // Ambil video ID dari link YouTube
                            preg_match(
                                '/(?:youtu\.be\/|youtube\.com\/(?:watch\?v=|embed\/))([\w\-]+)/',
                                $video->link,
                                $matches,
                            );
                            $videoId = $matches[1] ?? null;
                            $thumbnail = $videoId
                                ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg"
                                : asset('client/assets/img/default-video.jpg');
                        @endphp

                        <div class="video-card">
                            <a href="{{ $video->link }}" target="_blank"> <!-- buka langsung video -->
                                <div class="video-image">
                                    <img src="{{ $thumbnail }}" alt="{{ $video->judul }}">
                                </div>
                                <div class="video-content">
                                    <h3>{{ $video->judul }}</h3>
                                    <p>{{ Str::limit(strip_tags($video->deskripsi ?? ''), 100) }}</p>
                                    <div class="video-footer">
                                        <span>{{ \Carbon\Carbon::parse($video->created_at)->translatedFormat('d F Y') }}</span>
                                        <span>Lebih Lengkap...</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p>Tidak ada video tersedia.</p>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="video-pagination" id="videoPagination"></div>
            </div>
        </section>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const cardsContainer = document.querySelector(".video-cards");
                const pagination = document.querySelector(".video-pagination");

                let cardWidth = 0;
                let scrollStep = 0;
                let totalPages = 0;

                function updateCardWidth() {
                    const firstCard = cardsContainer.querySelector(".video-card");
                    if (!firstCard) return;

                    const style = window.getComputedStyle(firstCard);
                    const marginRight = parseInt(style.marginRight) || 0;
                    cardWidth = firstCard.offsetWidth + marginRight;

                    // tampilkan 4 card, scroll 3 card
                    scrollStep = cardWidth * 3;

                    // hitung total page
                    totalPages = Math.ceil(cardsContainer.scrollWidth / scrollStep);

                    updatePagination();
                }

                function updatePagination() {
                    pagination.innerHTML = "";

                    for (let i = 0; i < totalPages; i++) {
                        const dot = document.createElement("span");
                        dot.classList.add("dot");
                        if (i === 0) dot.classList.add("active");

                        dot.addEventListener("click", () => {
                            cardsContainer.scrollTo({
                                left: i * scrollStep,
                                behavior: "smooth",
                            });
                        });

                        pagination.appendChild(dot);
                    }
                }

                function setActiveDot() {
                    const dots = pagination.querySelectorAll(".dot");
                    const index = Math.round(cardsContainer.scrollLeft / scrollStep);

                    dots.forEach((dot, i) => {
                        dot.classList.toggle("active", i === index);
                    });
                }

                // update setiap resize window
                window.addEventListener("resize", updateCardWidth);
                // update saat scroll
                cardsContainer.addEventListener("scroll", setActiveDot);

                // pertama kali jalan
                updateCardWidth();
            });
        </script>
        </section>
        <!-- /video Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="global-title" data-aos="fade-up">
                <h2>Contact</h2>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">
                    <div class="col-lg-6">
                        <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up"
                            data-aos-delay="500">
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name"
                                        required="">
                                </div>

                                <div class="col-md-6 ">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email"
                                        required="">
                                </div>

                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="subject" placeholder="Subject"
                                        required="">
                                </div>

                                <div class="col-md-12">
                                    <textarea class="form-control" name="message" rows="4" placeholder="Message" required=""></textarea>
                                </div>
                            </div>

                            <div class="col-mt-3 text-center">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>

                                <button type="submit">Send Message</button>
                            </div>


                        </form>
                    </div>

                    <div class="col-lg-6 ">
                        <div class="row gy-4">
                            @foreach ($contact as $kontak)
                                <div class="col-lg-12">
                                    <div class="info-item d-flex flex-column justify-content-center align-items-center"
                                        data-aos="fade-up" data-aos-delay="200">
                                        <i class="bi bi-geo-alt"></i>
                                        <h3>Address</h3>
                                        <p>{{ $kontak->alamat }}</p>
                                    </div>
                                </div><!-- End Info Item -->

                                <div class="col-md-6">
                                    <div class="info-item d-flex flex-column justify-content-center align-items-center"
                                        data-aos="fade-up" data-aos-delay="300">
                                        <i class="bi bi-telephone"></i>
                                        <h3>Call Us</h3>
                                        <p>{{ $kontak->telepon }}</p>
                                    </div>
                                </div><!-- End Info Item -->

                                <div class="col-md-6">
                                    <div class="info-item d-flex flex-column justify-content-center align-items-center"
                                        data-aos="fade-up" data-aos-delay="400">
                                        <i class="bi bi-envelope"></i>
                                        <h3>Email Us</h3>
                                        <p>{{ $kontak->email }}</p>
                                    </div>
                                </div><!-- End Info Item -->
                            @endforeach
                        </div>
                    </div>

                    <!-- End Contact Form -->

                </div>

            </div>

        </section>
        <!-- /Contact Section -->

    </main>
