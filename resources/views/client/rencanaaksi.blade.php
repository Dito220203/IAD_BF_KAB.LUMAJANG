@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>RENCANA AKSI {{ $subprogram->subprogram }}</h2>
        </div>

        <section class="rencana-section" id="rencanaaksi">
            <div class="container">
                <div class="card-table-container">
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
                                @forelse($rencanaAksi as $index => $rk)
                                    <tr>
                                        <td>{{ ($rencanaAksi->currentPage() - 1) * $rencanaAksi->perPage() + $loop->iteration }}
                                        </td>
                                        <td>{{ $rk->subprogram->subprogram ?? '-' }}</td>
                                        <td>{{ $rk->rencana_aksi }}</td>
                                        <td>{{ $rk->sub_kegiatan }}</td>
                                        <td>{{ $rk->kegiatan }}</td>
                                        <td>{{ $rk->nama_program }}</td>
                                        <td>{{ $rk->lokasi }}</td>
                                        <td>{{ $rk->volume }}</td>
                                        <td>{{ $rk->satuan }}</td>
                                        <td>{{ $rk->anggaran }}</td>
                                        <td>{{ $rk->sumberdana }}</td>
                                        <td>{{ $rk->tahun }}</td>
                                        <td>{{ $rk->opd->nama ?? '-' }}</td>
                                        <td class="kolom-keterangan">{{ $rk->keterangan }}</td>

                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="14" class="text-center">
                                            Belum ada data rencana kegiatan untuk subprogram ini.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div class="table-footer">
                        {{-- Taruh info pagination di sini --}}
                        <div class="summary">
                            Showing {{ $rencanaAksi->firstItem() ?? 0 }} to {{ $rencanaAksi->lastItem() ?? 0 }} of
                            {{ $rencanaAksi->total() }} results
                        </div>
                        <div class="pagination-sm">
                            {{-- Panggil view pagination kustom kita --}}
                            {{ $rencanaAksi->onEachSide(1)->links('vendor.pagination.buttons-only') }}
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </section>
@endsection
