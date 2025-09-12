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
                                       <a href="{{ route('client.rencanaaksi', ['id' => $subprogram->id]) }}"
                                            class="{{ request()->is('subprogram/' . $subprogram->id . '/rencana-aksi') ? 'active' : '' }}">
                                            RENCANA AKSI
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
                                    {{-- <li>
                                        <a href="{{ route('client.monev', ['id' => $subprogram->id]) }}"
                                            class="{{ request()->is('subprogram/' . $subprogram->id . '/monev') ? 'active' : '' }}">
                                            MONITORING & EVALUASI
                                        </a>
                                    </li> --}}
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
                    <a href="{{ route('profilkawasan.search') }}"><span>PROFIL KAWASAN IAD</span>
                        <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li>
                            <div class="profil-dropdown">
                                <div class="form-group">
                                    <label for="kecamatan">Kecamatan</label>
                                    <select id="kecamatan" class="dropdown-select">
                                        <option value="">Pilih</option>
                                        @foreach ($kecamatan as $k)
                                            <option value="{{ $k->id }}" data-code="{{ $k->code }}">
                                                {{ $k->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="desa">Kel/Desa</label>
                                    <select id="desa" class="dropdown-select">
                                        <option value="">Pilih</option>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", function() {
                                                const kecamatanSelect = document.getElementById('kecamatan');
                                                const desaSelect = document.getElementById('desa');

                                                function loadDesa(kecamatanId, selectedDesa = null) {
                                                    desaSelect.innerHTML = '<option value="">Pilih</option>';
                                                    if (!kecamatanId) return;

                                                    fetch(`/get-desa/client/${kecamatanId}`)
                                                        .then(res => res.json())
                                                        .then(data => {
                                                            data.forEach(desa => {
                                                                const option = document.createElement('option');
                                                                option.value = desa.id;
                                                                option.textContent = desa.name;
                                                                if (desa.id == selectedDesa) option.selected = true;
                                                                desaSelect.appendChild(option);
                                                            });
                                                        })
                                                        .catch(err => console.error(err));
                                                }

                                                // Load desa jika ada kecamatan yang sudah dipilih
                                                if (kecamatanSelect.value) {
                                                    loadDesa(kecamatanSelect.value);
                                                }

                                                // Event change kecamatan
                                                kecamatanSelect.addEventListener('change', function() {
                                                    loadDesa(this.value);
                                                });
                                            });
                                        </script>

                                    </select>
                                </div>


                                    <button type="submit" class="profil-search-btn">
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
