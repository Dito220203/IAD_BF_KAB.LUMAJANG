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
                            <tr>
                                <td>1</td>
                                <td>KTH sumber urip</td>
                                <td>2.198,9</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Kedawung</td>
                                <td>786</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Sukodadi</td>
                                <td>123,78</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Ayem Tentrem</td>
                                <td>578</td>
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
