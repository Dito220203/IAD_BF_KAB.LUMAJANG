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
                                <th>Kelompok Tani Hutan (KTH)</th>
                                <th>Luas Areal Kelola (Ha)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="No" >1</td>
                                <td data-label="Kelompok Tani Hutan (KTH)">KTH sumber urip</td>
                                <td data-label="Luas Areal Kelola (Ha)">2.198,9</td>
                            </tr>
                            <tr>
                                <td data-label="No">2</td>
                                <td data-label="Kelompok Tani Hutan (KTH)">Kedawung</td>
                                <td data-label="Luas Areal Kelola (Ha)">786</td>
                            </tr>
                            <tr>
                                <td data-label="No">3</td>
                                <td data-label="Kelompok Tani Hutan (KTH)">Sukodadi</td>
                                <td data-label="Luas Areal Kelola (Ha)">123,78</td>
                            </tr>
                            <tr>
                                <td data-label="No">4</td>
                                <td data-label="Kelompok Tani Hutan (KTH)">Ayem Tentrem</td>
                                <td data-label="Luas Areal Kelola (Ha)">578</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

            </div>
            <div class="text-center mt-4">
                <a href="{{ url('/') }}" class="btn-footer-back">
                    ← Kembali
                </a>
            </div>
        </section>

    </section>
@endsection
