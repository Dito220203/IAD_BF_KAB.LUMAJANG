@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>IAD Kelompok Tani Hutan</h2>
        </div>

        <section class="monev-section container no-tabs">
            <div class="table-wrapper">
                <div class="table-content active" id="tableluasperhut">
                    <table class="monev-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>KELOMPOK TANI HUTAN (KTH)</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kthKups as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-center">{{ $data->kth->kth ?? '-' }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
        </section>
        <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="btn-footer-back">
                    ← Kembali
                </a>
            </div>
    </section>
@endsection
