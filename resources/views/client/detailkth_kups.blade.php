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
                            <th>JENIS KOMODITAS KUPS</th>
                            <th>JUMLAH PENDAPATAN PERTAHUN</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Contoh KTH dengan banyak KUPS -->
                        <tr>
                            <td rowspan="3">1</td>
                            <td rowspan="3">KTH Lestari Makmur</td>
                            <td>KUPS Kambing</td>
                            <td>Rp. 1.560.000.000</td>
                        </tr>
                        <tr>
                            <td>KUPS Kapulaga</td>
                            <td>Rp. 772.200.000</td>
                        </tr>
                        <tr>
                            <td>KUPS Kopi</td>
                            <td>Rp. 2.065.500.000</td>
                        </tr>

                        <!-- KTH berikutnya -->
                        <tr>
                            <td rowspan="2">2</td>
                            <td rowspan="2">KTH Sukowono</td>
                            <td>KUPS Pisang</td>
                            <td>Rp. 760.320.000</td>
                        </tr>
                        <tr>
                            <td>KUPS Kopi</td>
                            <td>Rp. 1.680.000.000</td>
                        </tr>

                        <!-- KTH lain -->
                        <tr>
                            <td>3</td>
                            <td>Rimba Jaya</td>
                            <td>KUPS Kambing</td>
                            <td>Rp. 984.000.000</td>
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
