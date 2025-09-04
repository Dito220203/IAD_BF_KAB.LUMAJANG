@extends('componentsclient.layout')
@section('content')
<section class="section_page">
    <div class="global-title" data-aos="fade-up">
        <h2>IAD Nilai Ekonomi</h2>
    </div>

    <section class="monev-section container no-tabs">
        <div class="table-wrapper">
            <div class="table-content active" id="tableluasperhut">
                <table class="monev-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>KELOMPOK TANI HUTAN (KTH)</th>
                            <th>JENIS KOMODITAS KUPS</th>
                            <th>KATEGORI</th>
                            <th>TAHUN</th>
                            <th>JUMLAH PENDAPATAN PERTAHUN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Kups as $data)
                        <tr>
                             <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->kth->kth ?? '-' }}</td>
                            <td>{{ $data->kups}}</td>
                            <td>{{ $data->kategori}}</td>
                            <td>{{ $data->tahun}}</td>
                            <td>{{ $data->pendapatan }}</td>
                        </tr>
                         @endforeach
                    </tbody>
                </table>
            </div>
       
    </section>
     </div>
        <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="btn-footer-back">
                ← Kembali
            </a>
        </div>
</section>
@endsection
