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
                            @php
                                $progres = [
                                    (object) [
                                        'judul' => 'Wisata Ranu Pani',
                                        'tanggal' => '01 Agustus 2025 13:45',
                                        'deskripsi' => 'It is a long established fact that a reader will be 
                                            distracted by the readable content of a page when looking 
                                            at its layout. The point of using Lorem Ipsum is that it 
                                            has a more-or-less normal distribution of letters, 
                                            as opposed to using , making it look like readable English.',
                                    ],
                                    (object) [
                                        'judul' => 'Wisata Ranu Pani',
                                        'tanggal' => '01 Agustus 2025 13:45',
                                        'deskripsi' => 'It is a long established fact that a reader will be 
                                            distracted by the readable content of a page when looking 
                                            at its layout. The point of using Lorem Ipsum is that it 
                                            has a more-or-less normal distribution of letters, 
                                            as opposed to using , making it look like readable English.',
                                    ],
                                    (object) [
                                        'judul' => 'Wisata Ranu Pani',
                                        'tanggal' => '01 Agustus 2025 13:45',
                                        'deskripsi' => 'It is a long established fact that a reader will be 
                                            distracted by the readable content of a page when looking 
                                            at its layout. The point of using Lorem Ipsum is that it 
                                            has a more-or-less normal distribution of letters, 
                                            as opposed to using , making it look like readable English.',
                                    ],
                                    (object) [
                                        'judul' => 'Wisata Ranu Pani',
                                        'tanggal' => '01 Agustus 2025 13:45',
                                        'deskripsi' => 'It is a long established fact that a reader will be 
                                            distracted by the readable content of a page when looking 
                                            at its layout. The point of using Lorem Ipsum is that it 
                                            has a more-or-less normal distribution of letters, 
                                            as opposed to using , making it look like readable English.',
                                    ],
                                    (object) [
                                        'judul' => 'Wisata Ranu Pani',
                                        'tanggal' => '01 Agustus 2025 13:45',
                                        'deskripsi' => 'It is a long established fact that a reader will be 
                                            distracted by the readable content of a page when looking 
                                            at its layout. The point of using Lorem Ipsum is that it 
                                            has a more-or-less normal distribution of letters, 
                                            as opposed to using , making it look like readable English.',
                                    ],
                                    (object) [
                                        'judul' => 'Wisata Ranu Pani',
                                        'tanggal' => '01 Agustus 2025 13:45',
                                        'deskripsi' => 'It is a long established fact that a reader will be 
                                            distracted by the readable content of a page when looking 
                                            at its layout. The point of using Lorem Ipsum is that it 
                                            has a more-or-less normal distribution of letters, 
                                            as opposed to using , making it look like readable English.',
                                    ],
                                    (object) [
                                        'judul' => 'Wisata Ranu Pani',
                                        'tanggal' => '01 Agustus 2025 13:45',
                                        'deskripsi' => 'It is a long established fact that a reader will be 
                                            distracted by the readable content of a page when looking 
                                            at its layout. The point of using Lorem Ipsum is that it 
                                            has a more-or-less normal distribution of letters, 
                                            as opposed to using , making it look like readable English.',
                                    ],
                                ];
                            @endphp

                            @foreach ($progres as $item)
                                <div class="progres-item">
                                    <div class="progres-header">
                                        <h6>{{ strtoupper($item->judul) }}</h6>
                                    </div>
                                    <div class="progres-meta">
                                        <span class="tanggal"><i class="fas fa-calendar-alt"></i>
                                            {{ $item->tanggal }}</span>
                                    </div>
                                    <div class="progres-body">
                                        <p>Deskripsi : {{ $item->deskripsi }}</p>
                                    </div>
                                    <div class="progres-footer">
                                        <a href="{{ route('client.profilkawasandetail') }}"
                                            class="{{ request()->is('progreskegiatan') ? 'active' : '' }}"><button
                                                class="btn-lihat">Lihat</button></a>
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
