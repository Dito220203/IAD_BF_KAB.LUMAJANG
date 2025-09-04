@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>IAD Luas Perhutanan Sosial</h2>
        </div>

        <section class="monev-section container no-tabs">
            <!-- Table Wrapper -->
            <div class="table-wrapper">
                <!-- Table -->
                <div class="table-content active" id="tableluasperhut">
                    <table class="monev-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>KELOMPOK TANI HUTAN (KTH)</th>
                                <th>LUAS AREAL KELOLA SESUAI SK (Ha)</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kth as $data)
                                <tr>
                                    <td>1</td>
                                    <td>{{ $data->kth }}</td>
                                    <td>{{ $data->luas }}</td>
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
