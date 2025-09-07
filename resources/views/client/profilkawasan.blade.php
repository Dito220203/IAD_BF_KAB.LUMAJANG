@extends('componentsclient.layout')
@section('content')
    <section class="section_page profilkawasan">
        <div class="global-title" data-aos="fade-up">
            <h2>PROFIL KAWASAN IAD</h2>
        </div>

        <section id="progres-kegiatan" class="progres-section container">
            <div class="row">
                <!-- Search Box -->
                <div class="col-lg-3 col-md-4 col-12 mb-3">
                    <div class="search-box">
                        <h5>PENCARIAN</h5>
                        <input type="text" id="searchInput" placeholder="Masukkan Judul">
                        <button id="searchBtn"><i class="fas fa-search"></i> Search</button>
                    </div>
                </div>

                <!-- Daftar Progres -->
                <div class="col-lg-9 col-md-8 col-12">
                    <div class="progres-wrapper">
                        <h4 class="progres-title">Daftar Potensi IAD</h4>
                        <div class="progres-list" id="progresList">

                            @forelse ($potensis as $item)
                                <div class="progres-item">
                                    <div class="progres-header">
                                        <h6>{{ strtoupper($item->judul) }}</h6>
                                    </div>
                                    <div class="progres-meta">
                                        <span class="tanggal"><i class="fas fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y') }}
                                        </span>
                                    </div>
                                    <div class="progres-body">
                                        <p>Deskripsi : {{ $item->uraian }}</p>
                                    </div>
                                    <div class="progres-footer">
                                        <a href="{{ route('profilkawasan.detail', $item->id) }}">
                                            <button class="btn-lihat">Lihat</button>
                                        </a>

                                    </div>

                                </div>
                            @empty
                                <p>Tidak ada potensi ditemukan untuk filter ini.</p>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>
@endsection
