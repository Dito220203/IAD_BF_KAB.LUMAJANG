@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>IAD POTENSI PERTANIAN</h2>
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

                <!-- Daftar Regulasi -->
                <div class="col-lg-9 col-md-8 col-12">
                    <div class="progres-wrapper">
                        <h4 class="progres-title">Daftar Potensi IAD</h4>
                        <div class="progres-list" id="progresList">
                            {{-- @foreach ($regulasi as $item) --}}
                                <div class="progres-item">
                                    <div class="progres-header">
                                        {{-- <h6>{{ strtoupper($item->judul) }}</h6> --}}
                                    </div>
                                    <div class="progres-meta">
                                        <span class="tanggal">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{-- {{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y H:i') }} --}}
                                        </span>
                                    </div>
                                    <div class="progres-body">
                                        {{-- &nbsp; --}}
                                    </div>
                                    <div class="progres-footer">
                                        {{-- @if ($item->file) --}}
                                            <a href="{{ url('/detailpotensi') }}" >
                                                <button class="btn-lihat">Lihat</button>
                                            </a>
                                        {{-- @else --}}
                                            <button class="btn-lihat" disabled>Tidak ada file</button>
                                        {{-- @endif --}}
                                    </div>
                                </div>
                            {{-- @endforeach --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="text-center mt-4">
    <a href="{{ url('/') }}" class="btn-footer-back">
        ← Kembali
    </a>
</div>
    </section>
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const items = document.querySelectorAll('#progresList .progres-item');

            searchInput.addEventListener('keyup', function() {
                let value = this.value.toLowerCase();

                items.forEach(item => {
                    let text = item.innerText.toLowerCase();
                    item.style.display = value === "" || text.includes(value) ? "" : "none";
                });
            });
        });
    </script>
@endsection


</section>
@endsection
