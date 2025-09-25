<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
        <a href="#" class="logo d-flex align-items-center">
            <img src="{{ asset('assets/img/logo kabupaten.png') }}" alt="" style="height: 100px; width: auto;">
            <span style="font-family: 'Roboto', sans-serif; font-size: 13px; margin-left: 10px;">
                Halaman Admin
            </span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            @if (auth()->guard('pengguna')->user()->level == 'Super Admin')
                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number">{{ $notifikasi->count() ?? 0 }}</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have {{ $notifikasi->count() ?? 0 }} new notifications
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        @forelse($notifikasi as $item)
                            <li class="notification-item">
                                @if ($item instanceof \App\Models\RencanaKerja)
                                    <i class="bi bi-journal-check"></i>
                                    <div>
                                        <h4>
    @php
    $perPage = 10;
    $position = \App\Models\RencanaKerja::where('delete_at', '0')
        ->where('id', '<=', $item->id)
        ->count();

    $page = ceil($position / $perPage);
@endphp

<a href="{{ route('rencanakerja', ['page' => $page]) }}#row-{{ $item->id }}">
    Rencana Kerja Baru
</a>
                           </h4>
                                        <p>{{ $item->judul }}</p>
                                        <p>{{ $item->created_at->diffForHumans() }}</p>
                                    </div>
                                @elseif($item instanceof \App\Models\ProgresKerja)
                                    <i class="bi bi-card-list"></i>
                                    <div>
                                         <h4>
                    @php
                        $perPage = 10;
                        $position = \App\Models\ProgresKerja::where('id', '<=', $item->id)->count();
                        $page = ceil($position / $perPage);
                    @endphp
                    <a href="{{ route('progres', ['page' => $page]) }}#row-{{ $item->id }}">
                        Progres Kerja Baru
                    </a>
                </h4>
                                        <p>{{ $item->judul }}</p>
                                        <p>{{ $item->created_at->diffForHumans() }}</p>
                                    </div>
                                @elseif($item instanceof \App\Models\Monev)
                                    <i class="bi bi-clipboard-check"></i>
                                    <div>
                                       <h4>
                    @php
                        $perPage = 10;
                        $position = \App\Models\Monev::where('id', '<=', $item->id)->count();
                        $page = ceil($position / $perPage);
                    @endphp
                    <a href="{{ route('monev', ['page' => $page]) }}#row-{{ $item->id }}">
                        Monitoring & Evaluasi
                    </a>
                </h4>
                                        <p>{{ $item->keterangan }}</p>
                                        <p>{{ $item->created_at->diffForHumans() }}</p>
                                    </div>
                                @endif
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @empty
                            <li class="notification-item text-center text-muted">
                                <i class="bi bi-bell-slash"></i>
                                <div>Tidak ada notifikasi</div>
                            </li>
                        @endforelse
                    </ul>
                </li>
            @endif

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                   data-bs-toggle="dropdown">
                    <span>{{ Auth::guard('pengguna')->user()->nama }}</span>
                </a><!-- End Profile Image Icon -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav>
</header><!-- End Header -->

{{-- Tambahkan script highlight baris saat diarahkan dari notifikasi --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (window.location.hash) {
            const row = document.querySelector(window.location.hash);
            if (row) {
                row.style.backgroundColor = "#ffeeba"; // highlight kuning
                setTimeout(() => row.style.backgroundColor = "", 2000);
            }
        }
    });
</script>
