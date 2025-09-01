

<header id="header"
    class="header d-flex align-items-center fixed-top {{ request()->is('/') ? '' : 'header-scrolled' }}">

    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

        <!-- Logo Kiri -->
        <a class="logo d-flex align-items-center me-auto">
            <img src="{{ asset('client/assets/img/logo-kabupaten.png') }}" alt="" data-aos="fade-in">
        </a>

        <!-- Menu Navigasi -->
        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ url('/') }}#hero" class="{{ request()->is('/') ? 'active' : '' }}">BERANDA</a></li>

                <li class="dropdown"><a href="#"><span>PROGRAM IAD</span> <i
                            class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>

                        @foreach ($subprograms as $subprogram)
                            <li class="dropdown">
                                <a href="#">
                                    <span>{{ $subprogram->subprogram }}</span>
                                    <i class="bi bi-chevron-down toggle-dropdown"></i>
                                </a>

                                <ul>
                                    <li>
                                        <a href="{{ route('client.tentangkegiatan', ['id' => $subprogram->id]) }}"
                                            class="{{ request()->is('subprogram/' . $subprogram->id . '/tentang') ? 'active' : '' }}">
                                            TENTANG {{ strtoupper($subprogram->subprogram) }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('client.rencanakegiatan', ['id' => $subprogram->id]) }}"
                                            class="{{ request()->is('subprogram/' . $subprogram->id . '/rencana') ? 'active' : '' }}">
                                            RENCANA KEGIATAN
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('client.progreskegiatan', ['id' => $subprogram->id]) }}"
                                            class="{{ request()->is('subprogram/' . $subprogram->id . '/progres') ? 'active' : '' }}">
                                            PROGRES KEGIATAN
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('client.monev', ['id' => $subprogram->id]) }}"
                                            class="{{ request()->is('subprogram/' . $subprogram->id . '/monev') ? 'active' : '' }}">
                                            MONITORING & EVALUASI
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('client.petasebarankegiatan', ['id' => $subprogram->id]) }}"
                                            class="{{ request()->is('subprogram/' . $subprogram->id . '/peta') ? 'active' : '' }}">
                                            PETA SEBARAN
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endforeach

                        {{-- <li class="dropdown"><a href="#"><span>AGROSILVOPASUTRA</span><i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>

                            <ul>
                                <li><a href="#">TENTANG AGROSILVOPASUTRA</a></li>
                                <li><a href="#">RENCANA KEGIATAN</a></li>
                                <li><a href="#">PROGRES KEGIATAN</a></li>
                                <li><a href="#">PETA SEBARAN</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#"><span>AKSES HUTSOS DAN REDISTRIBUSI</span><i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="#">TENTANG AKSES HUTSOS DAN REDISTRIBUSI</a></li>
                                <li><a href="#">RENCANA KEGIATAN</a></li>
                                <li><a href="#">PROGRES KEGIATAN</a></li>
                                <li><a href="#">PETA SEBARAN</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#"><span>INTERKONEKSI WISATA</span><i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="#">TENTANG INTERKONEKSI WISATA</a></li>
                                <li><a href="#">RENCANA KEGIATAN</a></li>
                                <li><a href="#">PROGRES KEGIATAN</a></li>
                                <li><a href="#">PETA SEBARAN</a></li>
                            </ul>
                        </li>
                        <li class="dropdown"><a href="#"><span>RESTORASI BERBASIS AGRIKULTUR</span><i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="#">TENTANG RESTORASI BERBASIS AGRIKULTUR</a></li>
                                <li><a href="#">RENCANA KEGIATAN</a></li>
                                <li><a href="#">PROGRES KEGIATAN</a></li>
                                <li><a href="#">PETA SEBARAN</a></li>
                            </ul>
                        </li> --}}
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#"><span>PROFIL KAWASAN IAD</span>
                        <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li>
                            <div class="profil-dropdown">
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <select id="kecamatan" class="dropdown-select">
                                        <option value="">Pilih</option>
                                        <option value="1">Kecamatan 1</option>
                                        <option value="2">Kecamatan 2</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="desa">Kel/Desa</label>
                                    <select id="desa" class="dropdown-select">
                                        <option value="">Pilih</option>
                                        <option value="desa1">Desa 1</option>
                                        <option value="desa2">Desa 2</option>
                                    </select>
                                </div>
                                <a href="{{ route('client.profilkawasan') }}"
                                    class="{{ request()->is('profilkawasan') ? 'active' : '' }}">
                                    <button type="button"
                                        class="profil-search-btn">
                                        <i class="bi bi-search"></i> Cari
                                    </button></a>
                            </div>
                        </li>
                    </ul>
                </li>

                <li><a href="{{ route('client.regulasi') }}"
                        class="{{ request()->is('regulasi') ? 'active' : '' }}">REGULASI IAD</a></li>
                <li><a href="{{ route('client') }}#videosection">VIDEO</a></li>
                <li><a href="{{ route('client') }}#contact">CONTACT</a></li>
                <li><a href="{{ url('login') }}">SIGN IN</a></li>
            </ul>
        </nav>

        <!-- Logo Kanan -->
        <a class="logo logo-right d-flex align-items-center">
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            <img src="{{ asset('client/assets/img/iad.png') }}" alt="" data-aos="fade-in">
        </a>

    </div>
</header>
