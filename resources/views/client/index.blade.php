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
                            <a href="{{ route('client.detailluasperhutanan') }}" class="stats-link">
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
                            <a href="{{ route('client.detailkth_kups') }}">
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
                            <a href="{{ route('client.detailkups') }}">
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
                            <a href="{{ route('client.detailekonomi') }}">
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
                $colorMap = [
                    'biru' => '#3498db',
                    'silver' => '#C0C0C0',
                    'emas' => '#FFD700',
                    'platinum' => '#6c757d',
                ];
                $defaultColor = '#E0E0E0';

                $kategoriData = \App\Models\Kups::select('kategori')
                    ->selectRaw('COUNT(*) as total')
                    ->groupBy('kategori')
                    ->get();

                $labels = $kategoriData->pluck('kategori')->toArray();

                $data = $kategoriData->pluck('total')->toArray();

                $backgroundColor = [];
                foreach ($labels as $label) {
                    $lookupKey = strtolower($label);
                    $backgroundColor[] = $colorMap[$lookupKey] ?? $defaultColor;
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
        </section>

        <!-- IAD POTENSI TIAP KUPS -->
        <section id="kups" class="kups">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="global-title">
                    <h2>IAD POTENSI TIAP KUPS</h2>
                </div>

                <div class="kups-wrapper">
                    <div class="kups-slider">
                        @foreach ($subpotensis as $subpotensi)
                            <div class="kups-card-item">
                                <a href="{{ route('client.daftarpotensi', ['id' => $subpotensi->id]) }}">
                                    <div class="stats-card">
                                        <div class="stats-icon">
                                            @if (!empty($subpotensi->icon))
                                                <i class="{{ $subpotensi->icon }}"></i>
                                            @else
                                                <i class="fas fa-seedling"></i>
                                            @endif
                                        </div>
                                        <p class="stats-label">{{ strtoupper($subpotensi->sub_potensi) }}</p>
                                        <span class="stats-number purecounter" data-purecounter-start="0"
                                            data-purecounter-end="{{ $counts[$subpotensi->id] ?? 0 }}"
                                            data-purecounter-duration="1"></span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="kups-pagination" id="kupsPagination"></div>
                </div>

                <div class="chart-wrapper" data-aos="fade-up">
                    <div class="chart-header">
                        <h3 class="chart-title">Nilai Ekonomi Tiap KUPS</h3>
                        <div class="custom-select-wrapper">
                            <div class="year-filter">
                                <label for="tahunSelect">Pilih Tahun:</label>
                                <select id="tahunSelect">
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}"
                                            {{ $year == $currentYear ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div id="pendapatanChart" class="pendapatanChart"></div>
                </div>


        </section>
        <!-- /IAD POTENSI TIAP KUPS -->

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
                                    <a href="{{ route('informasi.show', $info->id) }}" class="showinfo">Lebih
                                        Lengkap...</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Tidak ada informasi.</p>
                    @endforelse
                </div>
                <div class="informasi-pagination" id="informasiPagination"></div>
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
                            <a href="{{ $video->link }}" target="_blank">
                                <div class="video-image">
                                    <img src="{{ $thumbnail }}" alt="{{ $video->judul }}">
                                </div>
                                <div class="video-content">
                                    <h3>{{ $video->judul }}</h3>
                                    <p>{{ Str::limit(strip_tags($video->deskripsi ?? ''), 100) }}</p>
                                    <div class="video-footer">
                                        <span>{{ \Carbon\Carbon::parse($video->created_at)->translatedFormat('d F Y') }}</span>
                                        <span class="showinfo">Lebih Lengkap...</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p>Tidak ada video tersedia.</p>
                    @endforelse
                </div>
                <div class="video-pagination" id="videoPagination"></div>
            </div>
        </section>
        <!-- /video Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">
            <div class="global-title">
                <h2>Contact</h2>
            </div>
            <div class="container" ><div class="col-lg-12  ">
                <div class="row gy-4">
                    @foreach ($contact as $kontak)
                        <div class="col-lg-12 ">
                            <div class="info-item d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-geo-alt"></i>
                                <h3>Address</h3>
                                <p>{{ $kontak->alamat }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-telephone"></i>
                                <h3>Call Us</h3>
                                <p>{{ $kontak->telepon }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-item d-flex flex-column justify-content-center align-items-center">
                                <i class="bi bi-envelope"></i>
                                <h3>Email Us</h3>
                                <p>{{ $kontak->email }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            </div>
        </section>
        <!-- /Contact Section -->

        <!-- Chart -->
        @push('scripts')
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    //chart perhut
                    if (document.getElementById('donutChart')) {
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
                    }
                    //bar chart kups
                    const tahunSelect = document.getElementById("tahunSelect");
                    const chartElementId = 'pendapatanChart';
                    let myChart;
                    const initialChartData = @json($chartData ?? []);
                    const initialYear = {{ $currentYear }};

                    if (document.getElementById(chartElementId) && tahunSelect) {
                        myChart = Highcharts.chart(chartElementId, {
                            chart: {
                                type: 'column',
                                backgroundColor: 'transparent',
                                style: {
                                    fontFamily: 'Poppins, sans-serif'
                                }
                            },
                            title: {
                                text: null
                            },
                            subtitle: {
                                text: 'Data Pendapatan KUPS Tahun: ' + initialYear,
                                align: 'left',
                                style: {
                                    color: '#666'
                                }
                            },
                            xAxis: {
                                type: 'category',
                                labels: {
                                    style: {
                                        fontSize: '12px',
                                        color: '#333'
                                    }
                                },
                                lineColor: 'transparent',
                                tickColor: 'transparent'
                            },
                            yAxis: {
                                title: {
                                    text: null
                                },
                                gridLineColor: '#E0E0E0',
                                labels: {
                                    format: 'Rp {value:,.0f}',
                                    style: {
                                        fontSize: '12px',
                                        color: '#666'
                                    }
                                }
                            },
                            legend: {
                                enabled: false
                            },
                            plotOptions: {
                                series: {
                                    borderRadius: 6,
                                    borderWidth: 0
                                }
                            },
                            tooltip: {
                                headerFormat: '<b>{point.key}</b><br>',
                                pointFormat: 'KTH: <b>{point.options.kth}</b><br><span style="color:{point.color}">●</span> {series.name}: <b>Rp {point.y:,.0f}</b>',
                                backgroundColor: 'rgba(255, 255, 255, 0.95)',
                                borderColor: '#DDD',
                                borderRadius: 8,
                                shadow: true,
                                style: {
                                    fontSize: '13px'
                                }
                            },
                            series: [{
                                name: 'Pendapatan',
                                colorByPoint: true,
                                data: initialChartData,
                                colors: ['#5A67D8', '#38A169', '#DD6B20', '#3182CE', '#805AD5']
                            }],
                            credits: {
                                enabled: false
                            },
                            lang: {
                                noData: "Tidak ada data untuk ditampilkan pada tahun ini."
                            },
                            noData: {
                                style: {
                                    fontWeight: 'bold',
                                    fontSize: '15px',
                                    color: '#303030'
                                }
                            }
                        });

                        function updateChartData() {
                            const selectedYear = tahunSelect.value;
                            myChart.showLoading('Memuat data...');
                            fetch(`/kups/chart-data/${selectedYear}`)
                                .then(response => response.json())
                                .then(data => {
                                    myChart.series[0].setData(data, true);
                                    myChart.setSubtitle({
                                        text: 'Data Pendapatan KUPS Tahun: ' + selectedYear
                                    });
                                    myChart.hideLoading();
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    myChart.showLoading('Gagal memuat data!');
                                });
                        }
                        tahunSelect.addEventListener("change", updateChartData);
                    }
                    //slider & pagination landingpage
                    function initializeSlider(sliderSelector, paginationId, cardSelector) {
                        const slider = document.querySelector(sliderSelector);
                        const pagination = document.getElementById(paginationId);
                        const cards = document.querySelectorAll(cardSelector);
                        if (!slider || !pagination || cards.length === 0) return;

                        pagination.innerHTML = '';
                        const gap = parseInt(window.getComputedStyle(slider).gap) || 20;

                        cards.forEach((_, index) => {
                            const dot = document.createElement("div");
                            dot.classList.add("dot");
                            if (index === 0) dot.classList.add("active");
                            pagination.appendChild(dot);
                        });

                        const allDots = pagination.querySelectorAll(".dot");
                        if (allDots.length <= 1) {
                            pagination.style.display = 'none';
                        }

                        allDots.forEach((dot, index) => {
                            dot.addEventListener("click", () => {
                                const cardWidth = cards[0].offsetWidth;
                                const scrollPosition = index * (cardWidth + gap);
                                slider.scrollTo({
                                    left: scrollPosition,
                                    behavior: "smooth"
                                });
                            });
                        });

                        slider.addEventListener("scroll", () => {
                            const cardWidth = cards[0].offsetWidth;
                            const activeIndex = Math.round(slider.scrollLeft / (cardWidth + gap));
                            allDots.forEach((dot, index) => {
                                dot.classList.toggle("active", index === activeIndex);
                            });
                        });
                    }
                    try {
                        initializeSlider(".kups-slider", "kupsPagination", ".kups-card-item");
                        initializeSlider(".informasi-cards", "informasiPagination", ".informasi-card");
                        initializeSlider(".video-cards", "videoPagination", ".video-card");
                    } catch (e) {
                        console.error("Terjadi error saat menginisialisasi slider:", e);
                    }
                    //dropdown custom
                    var x, i, j, l, ll, selElmnt, a, b, c;
                    x = document.getElementsByClassName("custom-select-wrapper");
                    l = x.length;
                    for (i = 0; i < l; i++) {
                        selElmnt = x[i].getElementsByTagName("select")[0];
                        if (!selElmnt) continue;
                        ll = selElmnt.length;
                        a = document.createElement("DIV");
                        a.setAttribute("class", "select-selected");
                        if (selElmnt.options.length > 0) {
                            a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
                        } else {
                            a.innerHTML = "Tidak ada data";
                        }
                        x[i].appendChild(a);
                        b = document.createElement("DIV");
                        b.setAttribute("class", "select-items select-hide");
                        for (j = 0; j < ll; j++) {
                            c = document.createElement("DIV");
                            c.innerHTML = selElmnt.options[j].innerHTML;
                            c.addEventListener("click", function(e) {
                                var y, i, k, s, h, sl, yl;
                                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                                sl = s.length;
                                h = this.parentNode.previousSibling;
                                for (i = 0; i < sl; i++) {
                                    if (s.options[i].innerHTML == this.innerHTML) {
                                        s.selectedIndex = i;
                                        h.innerHTML = this.innerHTML;
                                        y = this.parentNode.getElementsByClassName("same-as-selected");
                                        yl = y.length;
                                        for (k = 0; k < yl; k++) {
                                            y[k].removeAttribute("class");
                                        }
                                        this.setAttribute("class", "same-as-selected");
                                        s.dispatchEvent(new Event('change'));
                                        break;
                                    }
                                }
                                h.click();
                            });
                            b.appendChild(c);
                        }
                        x[i].appendChild(b);
                        a.addEventListener("click", function(e) {
                            e.stopPropagation();
                            closeAllSelect(this);
                            this.nextSibling.classList.toggle("select-hide");
                            this.classList.toggle("select-arrow-active");
                        });
                    }

                    function closeAllSelect(elmnt) {
                        var x, y, i, xl, yl;
                        x = document.getElementsByClassName("select-items");
                        y = document.getElementsByClassName("select-selected");
                        xl = x.length;
                        yl = y.length;
                        for (i = 0; i < yl; i++) {
                            if (elmnt != y[i]) {
                                y[i].classList.remove("select-arrow-active");
                            }
                        }
                        for (i = 0; i < xl; i++) {
                            if (elmnt.nextSibling != x[i]) {
                                x[i].classList.add("select-hide");
                            }
                        }
                    }
                    document.addEventListener("click", closeAllSelect);
                });
            </script>
        @endpush
        <!-- /Chart -->
    </main>
