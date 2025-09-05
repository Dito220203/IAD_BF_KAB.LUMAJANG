@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>RENCANA KEGIATAN {{ $subprogram->subprogram }}</h2>
        </div>

        <section class="rencana-section" id="rencana">
            <div class="container">
                <div class="table-wrapper">
                    <table class="rencana-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Program</th>
                                <th>Rencana Kegiatan</th>
                                <th>Lokasi</th>
                                <th>Tahun</th>
                                <th>Perangkat Daerah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rencanaKegiatan as $index => $rk)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $rk->subprogram->subprogram ?? '-'  }}</td>
                                    <td>{{ $rk->judul }}</td>
                                    <td>{{ $rk->lokasi }}</td>
                                    <td>{{ $rk->tanggal }}</td>
                                    <td>{{ $rk->opd->nama ?? '-'  }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Belum ada data rencana kegiatan untuk subprogram
                                        ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </section>
@endsection
