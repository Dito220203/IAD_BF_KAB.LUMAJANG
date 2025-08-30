@extends('componentsclient.layout')
@section('content')

<section class="section_page">
    <div class="global-title" data-aos="fade-up">
        <h2>What is Lorem Ipsum?</h2>
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
                    <h4 class="progres-title">Daftar Progres Kegiatan</h4>
                    <div class="progres-list" id="progresList">
                        @php
                            $progres = [
                                (object) [
                                    'judul' => 'Normalisasi Ranu Pani',
                                    'tanggal' => '01 Agustus 2025 13:45',
                                    'sumber' => 'APBD',
                                    'anggaran' => 'Rpxx.xxx.xxx,xx',
                                    'penerima' => 'Masyarakat',
                                    'tahun' => '2023',
                                ],
                                (object) [
                                    'judul' => 'Pembangunan Irigasi Sawah',
                                    'tanggal' => '10 Agustus 2025 09:30',
                                    'sumber' => 'Dana Desa',
                                    'anggaran' => 'Rp yy.yyy.yyy,yy',
                                    'penerima' => 'Petani',
                                    'tahun' => '2024',
                                ],
                                (object) [
                                    'judul' => 'Rehabilitasi Hutan',
                                    'tanggal' => '15 Agustus 2025 11:00',
                                    'sumber' => 'APBN',
                                    'anggaran' => 'Rp zz.zzz.zzz,zz',
                                    'penerima' => 'Kelompok Tani',
                                    'tahun' => '2025',
                                ],
                                (object) [
                                    'judul' => 'Pembangunan Embung Desa',
                                    'tanggal' => '20 Agustus 2025 14:00',
                                    'sumber' => 'APBD',
                                    'anggaran' => 'Rp aa.aaa.aaa,aa',
                                    'penerima' => 'Masyarakat',
                                    'tahun' => '2025',
                                ],
                            ];
                        @endphp

                        @foreach ($progres as $item)
                            <div class="progres-item">
                                <div class="progres-header">
                                    <h6>{{ strtoupper($item->judul) }}</h6>
                                </div>
                                <div class="progres-meta">
                                    <span class="tahun">{{ $item->tahun }}</span>
                                    <span class="tanggal"><i class="fas fa-calendar-alt"></i> {{ $item->tanggal }}</span>
                                </div>
                                <div class="progres-body">
                                    <p>Sumber Anggaran : {{ $item->sumber }}</p>
                                    <p>Jumlah Anggaran : {{ $item->anggaran }}</p>
                                    <p>Penerima : {{ $item->penerima }}</p>
                                </div>
                                <div class="progres-footer">
                                    <button class="btn-lihat">Lihat</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</section>

@endsection

