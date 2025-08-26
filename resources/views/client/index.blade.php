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
                <div class="perhutanan-title">
                    <h2>PERHUTANAN SOSIAL KABUPATEN LUMAJANG</h2>
                </div>
                <div class="perhut-cards" data-aos="fade-down" data-aos-delay="200" id="PerhutCards">
                    <div class="row gy-4">

                        <!-- Card 1 -->
                        <div class="col-lg-3 col-md-6">
                            <a href="#" class="stats-link">
                                <div class="stats-card">
                                    <div>
                                        <div class="stats-icon"><i class="fa fa-tree"></i></div>
                                    </div>
                                    <p class="stats-label">Luas Perhutanan Sosial</p>

                                    <span class="stats-number purecounter" data-purecounter-start="0"
                                        data-purecounter-end="123" data-purecounter-decimals="0"
                                        data-purecounter-duration="1"></span>

                                </div>
                            </a>
                        </div>
                        <!-- Card 2 -->
                        <div class="col-lg-3 col-md-6">
                            <div class="stats-card">
                                <div>
                                    <div class="stats-icon"><i class="fas fa-users"></i></div>
                                </div>
                                <p class="stats-label">Kelompok Tani Hutan (KTH)</p>
                                <span class="stats-number purecounter" data-purecounter-start="0" data-purecounter-end="123"
                                    data-purecounter-decimals="0" data-purecounter-duration="1"></span>
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="col-lg-3 col-md-6">
                            <div class="stats-card">
                                <div>
                                    <div class="stats-icon"><i class="fas fa-store"></i></div>
                                </div>
                                <p class="stats-label"> Kelompok Usaha Perhutanan Sosial (KUPS)</p>
                                <span class="stats-number purecounter" data-purecounter-start="0" data-purecounter-end="123"
                                    data-purecounter-decimals="0" data-purecounter-duration="1"></span>
                            </div>
                        </div>
                        <!-- Card 4 -->
                        <div class="col-lg-3 col-md-6">
                            <div class="stats-card">
                                <div>

                                    <div class="stats-icon">
                                        <i class="fas fa-sack-dollar"></i>
                                    </div>

                                </div>
                                <p class="stats-label">Nilai Ekonomi</p>

                                <span class="stats-number"><span class="purecounter" data-purecounter-start="0"
                                        data-purecounter-end="123" data-purecounter-decimals="0"
                                        data-purecounter-duration="1"></span></span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- chart perhut Section -->
            <section id="chart_perhut" class="perhutanan">
                <div class="chart-container"
                    style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: center; "data-aos="fade-up"
                    data-aos-delay="250">

                    <!-- Chart Kiri -->
                    <div class="chart-box"
                        style="flex: 1; min-width: 300px; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <canvas id="barChart"></canvas>
                    </div>

                    <!-- Chart Kanan -->
                    <div class="chart-box"
                        style="flex: 1; min-width: 300px; background: white; padding: 20px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                        <canvas id="donutChart"></canvas>
                    </div>
                </div>
            </section>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // BAR CHART
                    const barCtx = document.getElementById('barChart').getContext('2d');
                    new Chart(barCtx, {
                        type: 'bar',
                        data: {
                            labels: ['Platinum', 'Emas', 'Perak', 'Biru'],
                            datasets: [{
                                label: '2020',
                                data: [12, 88, 77, 74],
                                backgroundColor: ['#6a5acd', '#ffd700', '#c0c0c0', '#1e90ff']
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });

                    // DONUT CHART
                    const donutCtx = document.getElementById('donutChart').getContext('2d');
                    new Chart(donutCtx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Platinum', 'Emas', 'Perak', 'Biru'],
                            datasets: [{
                                data: [12, 88, 77, 74],
                                backgroundColor: ['#6a5acd', '#ffd700', '#c0c0c0', '#1e90ff']
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
        <section id="kups" class="kups">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="perhutanan-title">
                    <h2>PERHUTANAN SOSIAL KABUPATEN LUMAJANG</h2>
                </div>
                <div class="perhut-cards" data-aos="fade-down" data-aos-delay="200" id="PerhutCards">
                    <div class="row gy-4 justify-content-center">

                        <!-- Card 1 -->
                        <div class="col-lg-3 col-md-6">
                            <a href="#">
                                <div class="stats-card">
                                    <div>
                                        <div class="stats-icon"><i class="fa fa-tree"></i></div>
                                    </div>
                                    <p class="stats-label">Luas Perhutanan Sosial</p>

                                    <span class="stats-number purecounter" data-purecounter-start="0"
                                        data-purecounter-end="123" data-purecounter-decimals="0"
                                        data-purecounter-duration="1"></span>

                                </div>
                            </a>
                        </div>
                        <!-- Card 2 -->
                        <div class="col-lg-3 col-md-6">
                            <div class="stats-card">
                                <div>
                                    <div class="stats-icon"><i class="fas fa-users"></i></div>
                                </div>
                                <p class="stats-label">Kelompok Tani Hutan (KTH)</p>
                                <span class="stats-number purecounter" data-purecounter-start="0"
                                    data-purecounter-end="123" data-purecounter-decimals="0"
                                    data-purecounter-duration="1"></span>
                            </div>
                        </div>
                        <!-- Card 3 -->
                        <div class="col-lg-3 col-md-6">
                            <div class="stats-card">
                                <div>
                                    <div class="stats-icon"><i class="fas fa-store"></i></div>
                                </div>
                                <p class="stats-label"> Kelompok Usaha Perhutanan Sosial (KUPS)</p>
                                <span class="stats-number purecounter" data-purecounter-start="0"
                                    data-purecounter-end="123" data-purecounter-decimals="0"
                                    data-purecounter-duration="1"></span>
                            </div>
                        </div>


                    </div>
                </div>

            </div>

            <!-- chart perhut Section -->
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
                            text: 'Jumlah Pendapatan Tiap KUPS'
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

        </section>
        <!-- /JUMLAH PENDAPATAN TIAP KUPS -->



        <!-- Informasi Section -->
        <section class="informasi-section" id="informasisection">
            <div class="perhutanan-title">
                <h2>INFORMASI</h2>
            </div>
            <div class="informasi-wrapper">
                <div class="informasi-cards" data-aos="fade-left" data-aos-delay="200" id="informasiCards">
                    <!-- Card 1 -->
                    <div class="informasi-card">
                        <div class="informasi-image">
                            <img src="{{ asset('client/assets/img/tes.jpg') }}" alt="Informasi">
                        </div>
                        <div class="informasi-content">
                            <h3>What is Lorem Ipsum?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a
                                page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                uncover many web sites still in their infancy. Various versions have evolved over the years,
                                sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            <div class="informasi-footer">
                                <span>01 Agustus 2025</span>
                                <a href="#">Lebih Lengkap...</a>
                            </div>
                        </div>
                    </div>
                    <div class="informasi-card">
                        <div class="informasi-image">
                            <img src="{{ asset('client/assets/img/tes.jpg') }}" alt="Informasi">
                        </div>
                        <div class="informasi-content">
                            <h3>What is Lorem Ipsum?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a
                                page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                uncover many web sites still in their infancy. Various versions have evolved over the years,
                                sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            <div class="informasi-footer">
                                <span>01 Agustus 2025</span>
                                <a href="#">Lebih Lengkap...</a>
                            </div>
                        </div>
                    </div>
                    <div class="informasi-card">
                        <div class="informasi-image">
                            <img src="{{ asset('client/assets/img/tes.jpg') }}" alt="Informasi">
                        </div>
                        <div class="informasi-content">
                            <h3>What is Lorem Ipsum?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a
                                page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                uncover many web sites still in their infancy. Various versions have evolved over the years,
                                sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            <div class="informasi-footer">
                                <span>01 Agustus 2025</span>
                                <a href="#">Lebih Lengkap...</a>
                            </div>
                        </div>
                    </div>
                    <div class="informasi-card">
                        <div class="informasi-image">
                            <img src="{{ asset('client/assets/img/tes.jpg') }}" alt="Informasi">
                        </div>
                        <div class="informasi-content">
                            <h3>What is Lorem Ipsum?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a
                                page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                uncover many web sites still in their infancy. Various versions have evolved over the years,
                                sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            <div class="informasi-footer">
                                <span>01 Agustus 2025</span>
                                <a href="#">Lebih Lengkap...</a>
                            </div>
                        </div>
                    </div>
                    <div class="informasi-card">
                        <div class="informasi-image">
                            <img src="{{ asset('client/assets/img/tes.jpg') }}" alt="Informasi">
                        </div>
                        <div class="informasi-content">
                            <h3>What is Lorem Ipsum?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a
                                page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                uncover many web sites still in their infancy. Various versions have evolved over the years,
                                sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            <div class="informasi-footer">
                                <span>01 Agustus 2025</span>
                                <a href="#">Lebih Lengkap...</a>
                            </div>
                        </div>
                    </div>
                    <div class="informasi-card">
                        <div class="informasi-image">
                            <img src="{{ asset('client/assets/img/tes.jpg') }}" alt="Informasi">
                        </div>
                        <div class="informasi-content">
                            <h3>What is Lorem Ipsum?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a
                                page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                uncover many web sites still in their infancy. Various versions have evolved over the years,
                                sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            <div class="informasi-footer">
                                <span>01 Agustus 2025</span>
                                <a href="#">Lebih Lengkap...</a>
                            </div>
                        </div>
                    </div>
                    <div class="informasi-card">
                        <div class="informasi-image">
                            <img src="{{ asset('client/assets/img/tes.jpg') }}" alt="Informasi">
                        </div>
                        <div class="informasi-content">
                            <h3>What is Lorem Ipsum?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a
                                page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                uncover many web sites still in their infancy. Various versions have evolved over the years,
                                sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            <div class="informasi-footer">
                                <span>01 Agustus 2025</span>
                                <a href="#">Lebih Lengkap...</a>
                            </div>
                        </div>
                    </div>
                    <div class="informasi-card">
                        <div class="informasi-image">
                            <img src="{{ asset('client/assets/img/tes.jpg') }}" alt="Informasi">
                        </div>
                        <div class="informasi-content">
                            <h3>What is Lorem Ipsum?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a
                                page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                uncover many web sites still in their infancy. Various versions have evolved over the years,
                                sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            <div class="informasi-footer">
                                <span>01 Agustus 2025</span>
                                <a href="#">Lebih Lengkap...</a>
                            </div>
                        </div>
                    </div>
                    <div class="informasi-card">
                        <div class="informasi-image">
                            <img src="{{ asset('client/assets/img/tes.jpg') }}" alt="Informasi">
                        </div>
                        <div class="informasi-content">
                            <h3>What is Lorem Ipsum?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a
                                page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                uncover many web sites still in their infancy. Various versions have evolved over the years,
                                sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            <div class="informasi-footer">
                                <span>01 Agustus 2025</span>
                                <a href="#">Lebih Lengkap...</a>
                            </div>
                        </div>
                    </div>
                    <div class="informasi-card">
                        <div class="informasi-image">
                            <img src="{{ asset('client/assets/img/tes.jpg') }}" alt="Informasi">
                        </div>
                        <div class="informasi-content">
                            <h3>What is Lorem Ipsum?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a
                                page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                uncover many web sites still in their infancy. Various versions have evolved over the years,
                                sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            <div class="informasi-footer">
                                <span>01 Agustus 2025</span>
                                <a href="#">Lebih Lengkap...</a>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Pagination -->
                <div class="informasi-pagination" id="informasiPagination">
                    <span class="dot active"></span>


                </div>
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

                        // update setiap resize window
                        window.addEventListener("resize", updateCardWidth);
                        // update saat scroll
                        cardsContainer.addEventListener("scroll", setActiveDot);

                        // pertama kali jalan
                        updateCardWidth();
                    });
                </script>

            </div>


        </section>


        <!-- video Section -->
        <section class="video-section" id="videosection">
            <div class="perhutanan-title" data-aos="fade-up">
                <h2>VIDEO</h2>
            </div>
            <div class="video-wrapper">
                <div class="video-cards" data-aos="fade-left" data-aos-delay="200" id="informasiCards">
                    <!-- Card 1 -->
                    <div class="video-card">
                        <div class="video-image">
                            <img src="{{ asset('client/assets/img/pulau.jpg') }}" alt="Informasi">
                        </div>
                        <div class="video-content">
                            <h3>What is Lorem Ipsum?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a
                                page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                uncover many web sites still in their infancy. Various versions have evolved over the years,
                                sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            <div class="video-footer">
                                <span>01 Agustus 2025</span>
                                <a href="#">Lebih Lengkap...</a>
                            </div>
                        </div>
                    </div>

                    <div class="video-card">
                        <div class="video-image">
                            <img src="{{ asset('client/assets/img/pulau.jpg') }}" alt="Informasi">
                        </div>
                        <div class="video-content">
                            <h3>What is Lorem Ipsum?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a
                                page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                uncover many web sites still in their infancy. Various versions have evolved over the years,
                                sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            <div class="video-footer">
                                <span>01 Agustus 2025</span>
                                <a href="#">Lebih Lengkap...</a>
                            </div>
                        </div>
                    </div>

                    <div class="video-card">
                        <div class="video-image">
                            <img src="{{ asset('client/assets/img/pulau.jpg') }}" alt="Informasi">
                        </div>
                        <div class="video-content">
                            <h3>What is Lorem Ipsum?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a
                                page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                uncover many web sites still in their infancy. Various versions have evolved over the years,
                                sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            <div class="video-footer">
                                <span>01 Agustus 2025</span>
                                <a href="#">Lebih Lengkap...</a>
                            </div>
                        </div>
                    </div>

                    <div class="video-card">
                        <div class="video-image">
                            <img src="{{ asset('client/assets/img/pulau.jpg') }}" alt="Informasi">
                        </div>
                        <div class="video-content">
                            <h3>What is Lorem Ipsum?</h3>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a
                                page when looking at its layout. The point of using Lorem Ipsum is that it has a
                                more-or-less normal distribution of letters, as opposed to using 'Content here, content
                                here', making it look like readable English. Many desktop publishing packages and web page
                                editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will
                                uncover many web sites still in their infancy. Various versions have evolved over the years,
                                sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                            <div class="video-footer">
                                <span>01 Agustus 2025</span>
                                <a href="#">Lebih Lengkap...</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="video-pagination" id="videoPagination">
                    <span class="dot active"></span>


                </div>
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



            </div>


        </section>
        <!-- /video Section -->


        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="perhutanan-title" data-aos="fade-up">
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

                                <div class="col-md-12 text-center">
                                    <div class="loading">Loading</div>
                                    <div class="error-message"></div>
                                    <div class="sent-message">Your message has been sent. Thank you!</div>

                                    <button type="submit">Send Message</button>
                                </div>

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
                                        <p>A108 Adam Street, New York, NY 535022</p>
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

        </section><!-- /Contact Section -->

    </main>
