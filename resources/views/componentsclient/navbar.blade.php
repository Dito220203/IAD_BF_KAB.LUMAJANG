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

                <li class="dropdown"> <a href="#" class="{{ request()->is('subprogram/*') ? 'active' : '' }}">
                        <span>PROGRAM IAD</span>
                        <i class="bi bi-chevron-down toggle-dropdown"></i>
                    </a>
                    <ul>

                        @foreach ($subprograms as $subprogram)
                            <li class="dropdown">
                                <a href="#" class="{{ request()->is('subprogram/' . $subprogram->id . '*') ? 'active' : '' }}">
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
                                            class="{{ request()->is('subprogram/' . $subprogram->id . '/progres*') ? 'active' : '' }}">
                                            PROGRES KEGIATAN
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


                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="{{ request()->is('profil-kawasan*') ? 'active' : '' }}">
                        <span>PROFIL KAWASAN IAD</span>
                        <i class="bi bi-chevron-down toggle-dropdown"></i>
                    </a>
                    <ul>
                        <li>
                            <div class="profil-dropdown">
                                <form action="{{ route('profilkawasan.search') }}" method="GET">
                                    <div class="form-group">
                                        <label for="kecamatan">Kecamatan</label>
                                        <select id="kecamatan" name="kecamatan" class="dropdown-select" required>
                                            <option value="">Pilih</option>
                                            @foreach ($kecamatan as $k)
                                                <option value="{{ $k->id }}">{{ $k->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="desa">Kel/Desa</label>
                                        <select id="desa" name="desa" class="dropdown-select" required>
                                            <option value="">Pilih</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="profil-search-btn">
                                        <i class="bi bi-search"></i> Cari
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>


                <li>
                    <a href="{{ route('client.regulasi') }}"
       class="{{ request()->routeIs('client.regulasi', 'client.detailregulasi') ? 'active' : '' }}">
        REGULASI IAD
    </a>
                </li>

                <li><a href="{{ route('client') }}#video">VIDEO</a></li>
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

        kecamatanSelect.addEventListener('change', function() {
            loadDesa(this.value);
        });
    });
</script>
