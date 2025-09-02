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
                                <th>Kelompok Tani Hutan (KTH)</th>
                                <th>Jenis Komoditas KUPS</th>
                                <th>Jumlah Pendapatan Pertahun</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td data-label="No" rowspan="3">1</td>
                                <td data-label="Kelompok Tani Hutan (KTH)" rowspan="3">KTH sumber urip</td>
                                <td data-label="Jenis Komoditas KUPS">KUPS Kambing</td>
                                <td data-label="Jumlah Pendapatan Pertahun">Rp.1.234.000</td>
                            </tr>
                            <tr>
                                <td data-label="Jenis Komoditas KUPS">KUPS Kopi</td>
                                <td data-label="Jumlah Pendapatan Pertahun">Rp.1.234.567</td>
                            </tr>
                            <tr>
                                <td data-label="Jenis Komoditas KUPS">KUPS Susu</td>
                                <td data-label="Jumlah Pendapatan Pertahun">Rp.3.234.567</td>
                            </tr>
                            {{-- table lain --}}
                            <tr>
                                <td data-label="No" rowspan="2">2</td>
                                <td data-label="Kelompok Tani Hutan (KTH)" rowspan="2">KTH sumber urip</td>
                                <td data-label="Jenis Komoditas KUPS">KUPS Kambing</td>
                                <td data-label="Jumlah Pendapatan Pertahun">Rp.1.234.000</td>
                            </tr>
                            <tr>
                                <td data-label="Jenis Komoditas KUPS">KUPS Susu</td>
                                <td data-label="Jumlah Pendapatan Pertahun">Rp.3.234.567</td>
                            </tr>
                            {{-- table lain --}}
                            <tr>
                                <td data-label="No" rowspan="4">3</td>
                                <td data-label="Kelompok Tani Hutan (KTH)" rowspan="4">KTH sumber urip</td>
                                <td data-label="Jenis Komoditas KUPS">KUPS Kambing</td>
                                <td data-label="Jumlah Pendapatan Pertahun">Rp.1.234.000</td>
                            </tr>
                            <tr>
                                <td data-label="Jenis Komoditas KUPS">KUPS Kopi</td>
                                <td data-label="Jumlah Pendapatan Pertahun">Rp.1.234.567</td>
                            </tr>
                            <tr>
                                <td data-label="Jenis Komoditas KUPS">KUPS Susu</td>
                                <td data-label="Jumlah Pendapatan Pertahun">Rp.3.234.567</td>
                            </tr>
                            <tr>
                                <td data-label="Jenis Komoditas KUPS">KUPS Kopi</td>
                                <td data-label="Jumlah Pendapatan Pertahun">Rp.1.234.567</td>
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
