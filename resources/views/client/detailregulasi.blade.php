@extends('componentsclient.layout')

@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>IAD DETAIL REGULASI</h2>
        </div>

        <section id="detail-kegiatan" class="container">
            <div class="detail-card">
                <h3>{{ strtoupper($item->judul) }}</h3>

                <span class="tanggal">
                    <i class="fas fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::parse($item->tanggal)->format('d F Y H:i') }}
                </span>

                <hr>

                @if ($item->file)
                    {{-- Viewer PDF --}}
                    <div style="border:1px solid #e5e7eb;border-radius:10px;overflow:hidden">
                        <iframe src="{{ Storage::url('regulasi/' . $item->file) }}" width="100%" height="700">
                        </iframe>

                    </div>
                @else
                    <p><em>Tidak ada file regulasi.</em></p>
                @endif

                <hr>
            </div>
        </section>

        <div class="text-center mt-4">
            <a href="{{ route('client.regulasi') }}" class="btn-footer-back">
                ← Kembali
            </a>
        </div>
    </section>
@endsection
