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
                                                <i class="fa-solid fa-leaf"></i>
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

                    {{-- Header sekarang berisi JUDUL dan FILTER --}}
                    <div class="chart-header">
                        <h3 class="chart-title">Nilai Ekonomi Tiap KUPS</h3>

                        {{-- TAMBAHKAN KEMBALI PEMBUNGKUS INI --}}
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

                    {{-- Chart Area --}}
                    <div id="pendapatanChart" class="pendapatanChart"></div>
                </div>

                <script src="https://code.highcharts.com/highcharts.js"></script>
                <script src="https://code.highcharts.com/highcharts-3d.js"></script>
                <script>
                    // Ganti dari DOMContentLoaded menjadi window.addEventListener('load', ...)
                    window.addEventListener('load', function() {
                        const tahunSelect = document.getElementById("tahunSelect");
                        const pendapatanChart = document.getElementById("pendapatanChart");

                        // Fungsi untuk merender chart (tidak ada perubahan)
                        function renderChart(dataValues, tahun) {
                            Highcharts.chart('pendapatanChart', {
                                chart: {
                                    type: 'pie',
                                    backgroundColor: '#f0f0f0',
                                    options3d: {
                                        enabled: true,
                                        alpha: 30
                                    }
                                },
                                title: {
                                    text: null
                                },
                                subtitle: {
                                    text: 'Unit: Dalam Rupiah - Tahun: ' + tahun,
                                    align: 'left'
                                },
                                plotOptions: {
                                    pie: {
                                        allowPointSelect: true,
                                        cursor: 'pointer',
                                        depth: 25,
                                        borderWidth: 2,
                                        borderColor: '#fff',
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
                                    data: dataValues,
                                    colors: ['#9370DB', '#FF7F7F', '#00CED1', '#FFA500']
                                }]
                            });
                        }

                        // Jalankan logika chart hanya jika elemennya ada di halaman ini
                        if (pendapatanChart && tahunSelect) {
                            renderChart(@json($chartData), {{ $currentYear }});
                            tahunSelect.addEventListener("change", function() {
                                const selectedYear = this.value;
                                fetch(`/kups/chart-data/${selectedYear}`)
                                    .then(res => res.json())
                                    .then(data => renderChart(data, selectedYear));
                            });
                        }

                        // Logika untuk custom dropdown (tidak ada perubahan)
                        var x, i, j, l, ll, selElmnt, a, b, c;
                        x = document.getElementsByClassName("custom-select-wrapper");
                        l = x.length;
                        for (i = 0; i < l; i++) {
                            selElmnt = x[i].getElementsByTagName("select")[0];
                            if (!selElmnt) continue;
                            ll = selElmnt.length;
                            a = document.createElement("DIV");
                            a.setAttribute("class", "select-selected");
                            a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
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
                                            s.dispatchEvent(new Event('change')); // Memicu event change untuk chart
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
                            });
                        }

                        function closeAllSelect(elmnt) {
                            var x, y, i, xl, yl, arrNo = [];
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
                                if (elmnt != y[i]) {
                                    x[i].classList.add("select-hide");
                                }
                            }
                        }
                        document.addEventListener("click", closeAllSelect);
<<<<<<< HEAD

=======
>>>>>>> 1b179040c006ff33d5ea0e57c0ce6af8768d3dff
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

                <script>
                    document.addEventListener("DOMContentLoaded", function() {
                        function initializeSlider(sliderSelector, paginationId, cardSelector) {
                            const slider = document.querySelector(sliderSelector);
                            const pagination = document.getElementById(paginationId);
                            const cards = document.querySelectorAll(cardSelector);

                            // Pengecekan ini sangat penting, akan menghentikan error
                            if (!slider || !pagination || cards.length === 0) {
                                return;
                            }

                            pagination.innerHTML = '';
                            const gap = parseInt(window.getComputedStyle(slider).gap) || 20;

                            // 1. Buat dots
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

                            // 2. Fungsi Klik
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

                            // 3. Fungsi Scroll
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

            <!-- Section Title -->
            <div class="global-title" data-aos="fade-up">
                <h2>Contact</h2>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">
                    <div class="col-lg-6">
                        <form action="#" class="php-email-form" id="contactForm" data-aos="fade-up"
                            data-aos-delay="500">
                            <div class="row gy-4">
                                <div class="col-md-6">
                                    <input type="text" name="name" class="form-control" placeholder="Your Name"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email"
                                        required>
                                </div>

                                <div class="col-md-12">
                                    <input type="text" class="form-control" name="subject" placeholder="Subject"
                                        required>
                                </div>

                                <div class="col-md-12">
                                    <textarea class="form-control" name="message" rows="4" placeholder="Message" required></textarea>
                                </div>
                            </div>

                            <div class="col-mt-3 text-center">
                                <div class="loading" style="display:none;">Loading...</div>
                                <div class="sent-message" style="display:none; color:green;">✅ Your message has been sent.
                                    Thank you!</div>

                                <button type="submit">Send Message</button>
                            </div>
                        </form>

                        <script>
                            document.getElementById("contactForm").addEventListener("submit", function(e) {
                                e.preventDefault();

                                let form = this;
                                let loading = form.querySelector(".loading");
                                let sentMsg = form.querySelector(".sent-message");

                                // Reset tampilan
                                sentMsg.style.display = "none";
                                loading.style.display = "block";

                                // Simulasi kirim (2 detik)
                                setTimeout(() => {
                                    // HILANGKAN paksa loading
                                    loading.style.setProperty("display", "none", "important");

                                    // Baru tampil pesan sukses
                                    sentMsg.style.display = "block";

                                    // Reset form
                                    form.reset();
                                }, 2000);
                            });
                        </script>




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
