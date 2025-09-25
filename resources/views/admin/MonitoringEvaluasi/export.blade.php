<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Monitoring dan Evaluasi</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 10mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.2;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        .header-section {
            text-align: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #1f4e79;
        }

        .header-section h1 {
            font-size: 16px;
            font-weight: bold;
            color: #1f4e79;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }

        .header-section h2 {
            font-size: 12px;
            color: #666;
            margin: 0;
        }

        .info-section {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 15px;
            font-size: 10px;
        }

        .info-row {
            display: inline-block;
            margin-right: 25px;
            font-weight: bold;
        }

        .info-label {
            color: #495057;
        }

        .info-value {
            color: #1f4e79;
            background-color: #e3f2fd;
            padding: 2px 6px;
            border-radius: 3px;
            margin-left: 3px;
        }

        .table-container {
            width: 100%;
            overflow: visible;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8px;
            background: white;
        }

        thead {
            background-color: #0084ff;
            color: white;
        }

        thead th {
            font-weight: bold;
            font-size: 7px;
            text-transform: uppercase;
            padding: 6px 3px;
            border: 1px solid #fff;
            text-align: center;
            vertical-align: middle;
        }

        tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        td {
            padding: 4px 2px;
            border: 1px solid #dee2e6;
            font-size: 7px;
            word-wrap: break-word;
            vertical-align: top;
            line-height: 1.2;
        }

        /* Optimized column widths untuk landscape A4 */
        .col-no { width: 2%; min-width: 15px; }
        .col-subprogram { width: 6%; min-width: 40px; }
        .col-rencana { width: 12%; min-width: 80px; }
        .col-sub-kegiatan { width: 10%; min-width: 70px; }
        .col-kegiatan { width: 8%; min-width: 60px; }
        .col-program { width: 10%; min-width: 70px; }
        .col-lokasi { width: 5%; min-width: 35px; }
        .col-volume { width: 3%; min-width: 25px; }
        .col-satuan { width: 4%; min-width: 30px; }
        .col-anggaran { width: 7%; min-width: 50px; }
        .col-sumber { width: 5%; min-width: 40px; }
        .col-tahun { width: 3%; min-width: 25px; }
        .col-opd { width: 8%; min-width: 55px; }
        .col-realisasi { width: 6%; min-width: 45px; }
        .col-rka { width: 3%; min-width: 25px; }
        .col-status { width: 4%; min-width: 30px; }
        .col-tanggal { width: 5%; min-width: 35px; }
        .col-pesan { width: 7%; min-width: 50px; }
        .col-keterangan { width: 8%; min-width: 55px; }

        .text-center { text-align: center; }
        .text-left { text-align: left; }
        .text-right { text-align: right; }

        .status-badge {
            padding: 1px 4px;
            border-radius: 2px;
            font-weight: bold;
            font-size: 6px;
            text-transform: uppercase;
        }

        .status-valid {
            background-color: #d4edda;
            color: #155724;
        }

        .status-pending {
            background-color: #f8d7da;
            color: #721c24;
        }

        .rka-sudah {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .rka-belum {
            background-color: #fff3cd;
            color: #856404;
        }

        .currency {
            font-weight: bold;
            color: #1f4e79;
            font-size: 6px;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 8px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 8px;
        }

        /* Text handling untuk konten panjang */
        .long-text {
            font-size: 6px;
            line-height: 1.1;
            word-break: break-word;
            hyphens: auto;
        }

        .truncate-text {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Print optimizations */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }

            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>
    <div class="header-section">
        <h1>Monitoring dan Evaluasi IAD Perhutanan Sosial </h1>
        {{-- <h2>Sistem Informasi Perencanaan Daerah</h2> --}}
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Periode Tahun:</span>
            <span class="info-value">{{ $tahun ?? 'Semua Tahun' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Triwulan:</span>
            <span class="info-value">
                @if($triwulan)
                    Triwulan {{ $triwulan }}
                    @switch($triwulan)
                        @case(1) (Jan-Mar) @break
                        @case(2) (Apr-Jun) @break
                        @case(3) (Jul-Sep) @break
                        @case(4) (Okt-Des) @break
                    @endswitch
                @else
                    Semua Triwulan
                @endif
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Data:</span>
            <span class="info-value">{{ count($monev) }} Data</span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Cetak:</span>
            <span class="info-value">{{ date('d/m/Y H:i') }}</span>
        </div>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-subprogram">Sub Program</th>
                    <th class="col-rencana">Rencana Aksi</th>
                    <th class="col-sub-kegiatan">Sub Kegiatan</th>
                    <th class="col-kegiatan">Kegiatan</th>
                    <th class="col-program">Program</th>
                    <th class="col-lokasi">Lokasi</th>
                    <th class="col-volume">Vol</th>
                    <th class="col-satuan">Satuan</th>
                    <th class="col-anggaran">Anggaran</th>
                    <th class="col-sumber">Sumber Dana</th>
                    <th class="col-tahun">Tahun</th>
                    <th class="col-opd">Perangkat Daerah</th>
                    <th class="col-realisasi">Realisasi</th>
                    <th class="col-rka">RKA</th>
                    <th class="col-status">Status</th>
                    <th class="col-tanggal">Tanggal</th>
                    <th class="col-pesan">Catatan</th>
                    <th class="col-keterangan">Ket</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monev as $i => $row)
                    <tr>
                        <td class="text-center">{{ $i + 1 }}</td>
                        <td class="text-left long-text">{{ $row->subprogram->subprogram ?? '-' }}</td>
                        <td class="text-left long-text">{{ Str::limit($row->rencanakerja->rencana_aksi ?? '-' ) }}</td>
                        <td class="text-left long-text">{{ Str::limit($row->sub_kegiatan, 80) }}</td>
                        <td class="text-left long-text">{{ Str::limit($row->kegiatan, 70) }}</td>
                        <td class="text-left long-text">{{ Str::limit($row->nama_program, 80) }}</td>
                        <td class="text-center">{{ $row->lokasi }}</td>
                         <td class="text-center">{{ $row->volume}}</td>
                        <td class="text-center">{{ $row->satuan }}</td>
                        <td class="text-center">
                           {{$row->anggaran}}
                        </td>
                        <td class="text-center">{{ Str::limit($row->sumberdana, 20) }}</td>
                        <td class="text-center">{{ $row->tahun }}</td>
                        <td class="text-left long-text">{{ Str::limit($row->opd->nama ?? '-', 60) }}</td>
                        <td class="text-left long-text">{{ Str::limit($row->realisasi ?? '-', 50) }}</td>
                        <td class="text-center">
                            {{$row->rka}}
                        </td>
                        <td class="text-center">
                           {{$row->status}}
                        </td>
                        <td class="text-center">
                            @if($row->tanggal)
                                {{ date('d/m/y', strtotime($row->tanggal)) }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-left long-text">
                            @if($row->pesan)
                                {{ Str::limit($row->pesan, 60) }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-left long-text">
                            @if($row->keterangan)
                                {{ Str::limit($row->keterangan, 60) }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <strong>Total Program:</strong> {{ count($monev) }} |
        <strong>Dicetak:</strong> {{ date('d F Y, H:i:s') }} WIB |
        <strong>Halaman:</strong> 1
    </div>
</body>

</html>
