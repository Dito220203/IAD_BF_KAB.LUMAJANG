@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>RENCANA AKSI TAHUNAN</h2>
        </div>

        <section class="rencana-section" id="rencanaaksi">
            <div class="container">
                <div class="table-wrapper">
                    <table class="rencana-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Sub Program</th>
                                <th>Rencana Aksi/Aktivitas</th>
                                <th>Sub Kegiatan</th>
                                <th>Kegiatan</th>
                                <th>Program</th>
                                <th>Lokasi</th>
                                <th>Volume</th>
                                <th>Satuan</th>
                                <th>Anggaran</th>
                                <th>Sumber Dana</th>
                                <th>Tahun Pelaksanaan</th>
                                <th>Perangkat Daerah</th>
                                <th>keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @forelse($rencanaKegiatan as $index => $rk) --}}
                            <tr>
                                <td>1</td>
                                <td>Sub Program</td>
                                <td>Rencana Aksi/Aktivitas</td>
                                <td>Sub Kegiatan</td>
                                <td>Kegiatan</td>
                                <td>Program</td>
                                <td>Lokasi</td>
                                <td>Volume</td>
                                <td>Satuan</td>
                                <td>Anggaran</td>
                                <td>Sumber Dana</td>
                                <td>Tahun Pelaksanaan</td>
                                <td>Perangkat Daerah</td>
                                <td>keterangan</td>
                            </tr>
                            {{-- @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data rencana kegiatan untuk subprogram
                                        ini.</td>
                                </tr>
                            @endforelse --}}
                        </tbody>
                    </table>
                    
                </div>
            </div>
        </section>

    </section>
@endsection
