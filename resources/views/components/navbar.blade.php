 <!-- ======= Header ======= -->
 <header id="header" class="header fixed-top d-flex align-items-center">

     <div class="d-flex align-items-center justify-content-between">
         <a href="index.html" class="logo d-flex align-items-center">
             <img src="{{ asset('assets/img/logo kabupaten.png') }}" alt="">
             <span style="font-family: 'Roboto', sans-serif;">Halaman Admin</span>

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
                             <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                         </li>
                         <li>
                             <hr class="dropdown-divider">
                         </li>

                         @forelse($notifikasi as $item)
                             <li class="notification-item">
                                 @if ($item instanceof \App\Models\RencanaKerja)
                                     <i class="bi bi-calendar-check text-info"></i>
                                     <div>
                                         <h4>Rencana Kerja Baru</h4>
                                         <p>{{ $item->judul }}</p>
                                         <p>{{ $item->created_at->diffForHumans() }}</p>
                                     </div>
                                 @elseif($item instanceof \App\Models\ProgresKerja)
                                     <i class="bi bi-graph-up text-success"></i>
                                     <div>
                                         <h4>Progres Kerja Baru</h4>
                                         <p>{{ $item->judul }}</p>
                                         <p>{{ $item->created_at->diffForHumans() }}</p>
                                     </div>
                                 @elseif($item instanceof \App\Models\Monev)
                                     <i class="bi bi-calendar-check text-info"></i>
                                     <div>
                                         <h4>Monitoring & Evaluasi</h4>
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

                         <li class="dropdown-footer">
                             <a href="#">Show all notifications</a>
                         </li>
                     </ul>
                 </li>

                 <li class="nav-item dropdown">

                     <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                         <i class="bi bi-chat-left-text"></i>
                         {{-- <span class="badge bg-success badge-number">3</span> --}}
                     </a><!-- End Messages Icon -->

                     {{-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                         <li class="dropdown-header">
                             You have 3 new messages
                             <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                         </li>
                         <li>
                             <hr class="dropdown-divider">
                         </li>

                         <li class="message-item">
                             <a href="#">
                                 <img src="#" alt="" class="rounded-circle">
                                 <div>
                                     <h4>Maria Hudson</h4>
                                     <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                     <p>4 hrs. ago</p>
                                 </div>
                             </a>
                         </li>
                         <li>
                             <hr class="dropdown-divider">
                         </li>

                         <li class="message-item">
                             <a href="#">
                                 <img src="#" alt="" class="rounded-circle">
                                 <div>
                                     <h4>Anna Nelson</h4>
                                     <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                     <p>6 hrs. ago</p>
                                 </div>
                             </a>
                         </li>
                         <li>
                             <hr class="dropdown-divider">
                         </li>

                         <li class="message-item">
                             <a href="#">
                                 <img src="#" alt="" class="rounded-circle">
                                 <div>
                                     <h4>David Muldon</h4>
                                     <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                                     <p>8 hrs. ago</p>
                                 </div>
                             </a>
                         </li>
                         <li>
                             <hr class="dropdown-divider">
                         </li>

                         <li class="dropdown-footer">
                             <a href="#">Show all messages</a>
                         </li>

                     </ul> --}}
                 </li>
            @endif
                 <li class="nav-item dropdown pe-3">

                     <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                         data-bs-toggle="dropdown">

                         <span
                             >{{ Auth::guard('pengguna')->user()->nama }}</span>
                     </a><!-- End Profile Iamge Icon -->

             </li><!-- End Profile Nav -->

         </ul>
     </nav>

 </header><!-- End Header -->
