<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Beranda</span>
            </a>
        </li><!-- End Dashboard Nav -->


        @if (auth()->guard('pengguna')->user()->level == 'admin')
            {{-- Menu khusus Admin --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('informasi*') ? '' : 'collapsed' }}"
                    href="{{ route('informasi') }}">
                    <i class="bi bi-question-circle"></i>
                    <span>Berita</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('rencanakerja*') ? '' : 'collapsed' }}"
                    href="{{ route('rencanakerja') }}">
                    <i class="bi bi-journal-check"></i>
                    <span>Rencana Kerja</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('progres*') ? '' : 'collapsed' }}"
                    href="{{ route('progres') }}">
                    <i class="bi bi-card-list"></i>
                    <span>Progres Kerja</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('monev*') ? '' : 'collapsed' }}" href="{{ route('monev') }}">
                    <i class="bi bi-clipboard-check"></i>
                    <span>Monitoring Evaluasi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="modal"
                    data-bs-target="#modalGantiPassword">
                    <i class="bi bi-key"></i>
                    <span>Ganti Password</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('logout') }}">
                    <i class="ri-logout-box-line"></i>
                    <span>Logout</span>
                </a>
            </li>
        @elseif (auth()->guard('pengguna')->user()->level == 'Super Admin')
            {{-- Manajemen Konten --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('banner*', 'gambaran*', 'informasi*', 'video*') ? '' : 'collapsed' }}"
                    data-bs-target="#tables-conten" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-gem"></i>
                    <span>Manajemen Konten</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>

                <ul id="tables-conten"
                    class="nav-content collapse {{ request()->routeIs('banner*', 'gambaran*', 'informasi*', 'video*') ? 'show' : '' }}"
                    data-bs-parent="#sidebar-nav">

                    <li>
                        <a class="{{ request()->routeIs('banner*') ? 'active' : '' }}" href="{{ route('banner') }}">
                            <i class="ri-image-fill"></i>
                            <span>Banner</span>
                        </a>
                    </li>

                    <li>
                        <a class="{{ request()->routeIs('gambaran*') ? 'active' : '' }}"
                            href="{{ route('gambaran') }}">
                            <i class="bi bi-graph-up"></i>
                            <span>Gambaran Umum</span>
                        </a>
                    </li>

                    <li>
                        <a class="{{ request()->routeIs('informasi*') ? 'active' : '' }}"
                            href="{{ route('informasi') }}">
                            <i class="bi bi-question-circle"></i>
                            <span>Berita</span>
                        </a>
                    </li>

                    <li>
                        <a class="{{ request()->routeIs('video*') ? 'active' : '' }}" href="{{ route('video') }}">
                            <i class="fa-solid fa-video"></i>
                            <span>Video</span>
                        </a>
                    </li>
                </ul>
            </li>




            {{-- informasi kehutanan --}}
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-layout-text-window-reverse"></i>
                    <span>Informasi Kehutanan</span>
                    <i class="bi bi-chevron-down ms-auto"></i>
                </a>

                <ul id="tables-nav"
                    class="nav-content collapse
            {{ request()->is('kth*') || request()->is('kups*') ? 'show' : '' }}">

                    <li>
                        <a href="{{ route('kth') }}" class="{{ request()->is('kth*') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>KTH</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kups') }}" class="{{ request()->is('kups*') ? 'active' : '' }}">
                            <i class="bi bi-circle"></i><span>KUPS</span>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('subprogram*') ? '' : 'collapsed' }}"
                    href="{{ route('subprogram') }}">
                    <i class="fa-solid fa-folder-tree"></i>
                    <span>Sub Program</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('rencanakerja*') ? '' : 'collapsed' }}"
                    href="{{ route('rencanakerja') }}">
                    <i class="bi bi-journal-check"></i>
                    <span>Rencana Kerja</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('progres*') ? '' : 'collapsed' }}"
                    href="{{ route('progres') }}">
                    <i class="bi bi-card-list"></i>
                    <span>Progres Kerja</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('monev*') ? '' : 'collapsed' }}" href="{{ route('monev') }}">
                    <i class="bi bi-clipboard-check"></i>

                    <span>Monitoring Evaluasi</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('potensi*') ? '' : 'collapsed' }}"
                    href="{{ route('potensi') }}">
                    <i class="bi bi-bar-chart-line"></i>
                    <span>Potensi</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('regulasi*') ? '' : 'collapsed' }}"
                    href="{{ route('regulasi') }}">
                    <i class="bi bi-file-earmark-text"></i>
                    <span>Regulasi</span>
                </a>
            </li>

            <li class="nav-heading">Pages</li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pengguna*') ? '' : 'collapsed' }}"
                    href="{{ route('pengguna') }}">
                    <i class="bi bi-person"></i>
                    <span>Pengguna</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('opd*') ? '' : 'collapsed' }}" href="{{ route('opd') }}">
                    <i class="fa-solid fa-house-user"></i>
                    <span>OPD</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('kontak*') ? '' : 'collapsed' }}"
                    href="{{ route('kontak') }}">
                    <i class="bi bi-envelope"></i>
                    <span>Kontak</span>
                </a>
            </li>


            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('aktivitas*') ? '' : 'collapsed' }}"
                    href="{{ route('aktivitas') }}">
                    <i class="bi bi-journal-text"></i>
                    <span>Log Aktivitas</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-bs-toggle="modal"
                    data-bs-target="#modalGantiPassword">
                    <i class="bi bi-key"></i>
                    <span>Ganti Password</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="{{ route('logout') }}">
                    <i class="ri-logout-box-line"></i>
                    <span>Logout</span>
                </a>
            </li>
        @endif

    </ul>
</aside><!-- End Sidebar-->
