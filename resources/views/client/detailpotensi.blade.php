@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>{{ strtoupper($detailpotensiKehutanan->SubpotensiKehutanan->sub_potensi ?? '-') }}</h2>
        </div>

        <section id="detail-kegiatan" class="container">
            <div class="detail-card">
                <h3>{{ $detailpotensiKehutanan->judul }}</h3>
                <span class="tanggal">
                    <div class="progres-meta">
                        <i class="fas fa-calendar-alt"></i>
                        {{ \Carbon\Carbon::parse($detailpotensiKehutanan->tanggal)->format('d F Y') }}
                </span>
            </div>
            <p><strong>Keterangan:</strong> {{ $detailpotensiKehutanan->keterangan }}</p>

            <hr>

            @if ($detailpotensiKehutanan->gambar)
                <h4>Dokumentasi</h4>
                <div class="produk">
                    <img src="{{ asset('storage/' . $detailpotensiKehutanan->gambar) }}"
                        alt="{{ $detailpotensiKehutanan->judul }}" style="max-width:100%; height:auto;">
                </div>
                <hr>
            @endif
            </div>
        </section>

        <div class="text-center mt-4">
            <a href="{{ url()->previous() }}" class="btn-footer-back">
                ← Kembali
            </a>
        </div>
    </section>
@endsection
