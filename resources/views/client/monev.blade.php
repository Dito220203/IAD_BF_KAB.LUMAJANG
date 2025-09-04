@extends('componentsclient.layout')
@section('content')
    <section class="section_page">
        <div class="global-title" data-aos="fade-up">
            <h2>MONITORING EVALUASI {{ $subprogram->subprogram }}</h2>
        </div>

        <section class="monev-section container">

            

            <!-- Table Wrapper -->
            <div class="table-wrapper">
                <!-- Pilihan Triwulan -->
            <div class="triwulan-tabs">
                <button class="tab-btn active" data-target="triwulan1">Triwulan 1</button>
                <button class="tab-btn" data-target="triwulan2">Triwulan 2</button>
                <button class="tab-btn" data-target="triwulan3">Triwulan 3</button>
                <button class="tab-btn" data-target="triwulan4">Triwulan 4</button>
            </div>
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
                            @forelse ($triwulan[1] as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->subprogram->subprogram ?? '-' }}</td>
                                    <td>{{ $item->rencanaKerja->judul ?? '-' }}</td>
                                    <td>{{ $item->lokasi }}</td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>{{ $item->opd->nama ?? '-' }}</td>
                                    <td>
                                        @if ($item->rka == 'sudah')
                                            <span class="status success">Sudah</span>
                                        @else
                                            <span class="status danger">Belum</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->realisasi ?? '0%' }}</td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada data triwulan 1</td>
                                </tr>
                            @endforelse
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
                            @forelse ($triwulan[2] as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->subprogram->subprogram ?? '-' }}</td>
                                    <td>{{ $item->rencanaKerja->judul ?? '-' }}</td>
                                    <td>{{ $item->lokasi }}</td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>{{ $item->opd->nama ?? '-' }}</td>
                                    <td>
                                        @if ($item->rka == 'sudah')
                                            <span class="status success">Sudah</span>
                                        @else
                                            <span class="status danger">Belum</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->realisasi ?? '0%' }}</td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada data triwulan 2</td>
                                </tr>
                            @endforelse
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
                            @forelse ($triwulan[3] as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->subprogram->subprogram ?? '-' }}</td>
                                    <td>{{ $item->rencanaKerja->judul ?? '-' }}</td>
                                    <td>{{ $item->lokasi }}</td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>{{ $item->opd->nama ?? '-' }}</td>
                                    <td>
                                        @if ($item->rka == 'sudah')
                                            <span class="status success">Sudah</span>
                                        @else
                                            <span class="status danger">Belum</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->realisasi ?? '0%' }}</td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada data triwulan 3</td>
                                </tr>
                            @endforelse
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
                            @forelse ($triwulan[4] as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $item->subprogram->subprogram ?? '-' }}</td>
                                    <td>{{ $item->rencanaKerja->judul ?? '-' }}</td>
                                    <td>{{ $item->lokasi }}</td>
                                    <td>{{ $item->tahun }}</td>
                                    <td>{{ $item->opd->nama ?? '-' }}</td>
                                    <td>
                                        @if ($item->rka == 'sudah')
                                            <span class="status success">Sudah</span>
                                        @else
                                            <span class="status danger">Belum</span>
                                        @endif
                                    </td>
                                    <td>{{ $item->realisasi ?? '0%' }}</td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Belum ada data triwulan 4</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </section>
@endsection
