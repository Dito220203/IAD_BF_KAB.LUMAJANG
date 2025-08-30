@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>What is Lorem Ipsum?</h2>
        </div>

        <section class="monev-section container">

            <!-- Pilihan Triwulan -->
            <div class="triwulan-tabs">
                <button class="tab-btn active" data-target="triwulan1">Triwulan 1</button>
                <button class="tab-btn" data-target="triwulan2">Triwulan 2</button>
                <button class="tab-btn" data-target="triwulan3">Triwulan 3</button>
                <button class="tab-btn" data-target="triwulan4">Triwulan 4</button>
            </div>

            <!-- Table Wrapper -->
            <div class="table-wrapper">
                <!-- Triwulan 1 -->
                <div class="table-content active" id="triwulan1">
                    <table class="monev-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Program</th>
                                <th>Rencana Kegiatan</th>
                                <th>Lokasi</th>
                                <th>Tahun</th>
                                <th>Perangkat Daerah</th>
                                <th>Input RKA</th>
                                <th>Realisasi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Normalisasi Ranu Pani</td>
                                <td>Rehabilitasi Danau</td>
                                <td>Lumajang</td>
                                <td>2026</td>
                                <td>Dinas PU</td>
                                <td><span class="status success">Sudah</span></td>
                                <td>70%</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Penanaman Mangrove</td>
                                <td>Konservasi</td>
                                <td>Senduro</td>
                                <td>2026</td>
                                <td>Dinas Lingkungan</td>
                                <td><span class="status danger">Belum</span></td>
                                <td>0%</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Triwulan 2 -->
                <div class="table-content" id="triwulan2">
                    <table class="monev-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Program</th>
                                <th>Rencana Kegiatan</th>
                                <th>Lokasi</th>
                                <th>Tahun</th>
                                <th>Perangkat Daerah</th>
                                <th>Input RKA</th>
                                <th>Realisasi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Normalisasi Ranu Pani</td>
                                <td>Rehabilitasi Danau</td>
                                <td>Lumajang</td>
                                <td>2026</td>
                                <td>Dinas PU</td>
                                <td><span class="status success">Sudah</span></td>
                                <td>70%</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Penanaman Mangrove</td>
                                <td>Konservasi</td>
                                <td>Senduro</td>
                                <td>2026</td>
                                <td>Dinas Lingkungan</td>
                                <td><span class="status danger">Belum</span></td>
                                <td>0%</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Penanaman Mangrove</td>
                                <td>Konservasi</td>
                                <td>Senduro</td>
                                <td>2026</td>
                                <td>Dinas Lingkungan</td>
                                <td><span class="status success">sudah</span></td>
                                <td>0%</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Penanaman Mangrove</td>
                                <td>Konservasi</td>
                                <td>Senduro</td>
                                <td>2026</td>
                                <td>Dinas Lingkungan</td>
                                <td><span class="status danger">Belum</span></td>
                                <td>0%</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>Penanaman Mangrove</td>
                                <td>Konservasi</td>
                                <td>Senduro</td>
                                <td>2025</td>
                                <td>Dinas Lingkungan</td>
                                <td><span class="status success">sudah</span></td>
                                <td>0%</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Triwulan 3 -->
                <div class="table-content" id="triwulan3">
                    <table class="monev-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Program</th>
                                <th>Rencana Kegiatan</th>
                                <th>Lokasi</th>
                                <th>Tahun</th>
                                <th>Perangkat Daerah</th>
                                <th>Input RKA</th>
                                <th>Realisasi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Normalisasi Ranu Pani</td>
                                <td>Rehabilitasi Danau</td>
                                <td>Lumajang</td>
                                <td>2026</td>
                                <td>Dinas PU</td>
                                <td><span class="status success">Sudah</span></td>
                                <td>70%</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Penanaman Mangrove</td>
                                <td>Konservasi</td>
                                <td>Senduro</td>
                                <td>2026</td>
                                <td>Dinas Lingkungan</td>
                                <td><span class="status danger">Belum</span></td>
                                <td>0%</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Triwulan 4 -->
                <div class="table-content" id="triwulan4">
                    <table class="monev-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Program</th>
                                <th>Rencana Kegiatan</th>
                                <th>Lokasi</th>
                                <th>Tahun</th>
                                <th>Perangkat Daerah</th>
                                <th>Input RKA</th>
                                <th>Realisasi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Normalisasi Ranu Pani</td>
                                <td>Rehabilitasi Danau</td>
                                <td>Lumajang</td>
                                <td>2026</td>
                                <td>Dinas PU</td>
                                <td><span class="status success">Sudah</span></td>
                                <td>70%</td>
                                <td>Proses</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Penanaman Mangrove</td>
                                <td>Konservasi</td>
                                <td>Senduro</td>
                                <td>2026</td>
                                <td>Dinas Lingkungan</td>
                                <td><span class="status danger">Belum</span></td>
                                <td>0%</td>
                                <td>-</td>
                            </tr>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Penanaman Mangrove</td>
                                <td>Konservasi</td>
                                <td>Senduro</td>
                                <td>2026</td>
                                <td>Dinas Lingkungan</td>
                                <td><span class="status danger">Belum</span></td>
                                <td>0%</td>
                                <td>-</td>
                            </tr>
                            <tr>
                                <td>4s</td>
                                <td>Penanaman Mangrove</td>
                                <td>Konservasi</td>
                                <td>Senduro</td>
                                <td>2025</td>
                                <td>Dinas Lingkungan</td>
                                <td><span class="status success">sudah</span></td>
                                <td>0%</td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </section>
@endsection
