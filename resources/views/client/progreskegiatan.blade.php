@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>PROGRES KEGIATAN {{ $subprogram->subprogram }}</h2>
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
                            @forelse ($progres as $item)
                                <div class="progres-item">
                                    <div class="progres-header">
                                        <h6>{{ strtoupper($item->judul) }}</h6>
                                    </div>
                                    <div class="progres-meta">
                                        <span class="tahun">{{ $item->tahun }}</span>
                                        <span class="tanggal">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i') }}
                                        </span>
                                    </div>
                                    <div class="progres-body">
                                        <p>Sumber Anggaran : {{ $item->sumber_dana }}</p>
                                        <p>Jumlah Anggaran : {{ $item->jumlah_anggaran }}</p>
                                        <p>Penerima : {{ $item->penerima }}</p>
                                    </div>
                                    <div class="progres-footer">
                                        <form action="{{ route('client.progreskegiatandetail', $item->id) }}" method="GET">
                                            <button type="submit" class="btn-lihat">Lihat</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-center">Belum ada progres kegiatan untuk subprogram ini.</p>
                            @endforelse
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </section>
    @section('scripts')
        <script>
            document.getElementById('searchInput').addEventListener('keyup', function() {
                let value = this.value.toLowerCase();
                let items = document.querySelectorAll('#progresList .progres-item');

                items.forEach(item => {
                    let text = item.innerText.toLowerCase();
                    if (value === "") {

                        item.style.display = "";
                    } else {

                        item.style.display = text.includes(value) ? "" : "none";
                    }
                });
            });
        </script>
    @endsection
@endsection
