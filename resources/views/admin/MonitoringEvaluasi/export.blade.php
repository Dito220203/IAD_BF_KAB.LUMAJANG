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

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 5px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 6px;
            text-transform: uppercase;
            margin-bottom: 2px;
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

        .long-text {
            font-size: 6px;
            line-height: 1.1;
            word-break: break-word;
        }
    </style>
</head>

<body>
    <div class="header-section">
        <h1>Monitoring dan Evaluasi IAD Perhutanan Sosial</h1>
    </div>

    <div class="info-section">
        <div class="info-row">
            <span class="info-label">Periode Tahun:</span>
            <span class="info-value">{{ $tahun ?? 'Semua Tahun' }}</span>
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
                    <th style="width: 2%;">No</th>
                    <th style="width: 6%;">Sub Program</th>
                    <th style="width: 8%;">Rencana Aksi</th>
                    <th style="width: 8%;">Sub Kegiatan</th>
                    <th style="width: 8%;">Kegiatan</th>
                    <th style="width: 8%;">Program</th>
                    <th style="width: 5%;">Lokasi</th>
                    <th style="width: 2%;">Vol</th>
                    <th style="width: 3%;">Satuan</th>
                    <th style="width: 4%;">Anggaran</th>
                    <th style="width: 4%;">Sumber Dana</th>
                    <th style="width: 3%;">Tahun</th>
                    <th style="width: 6%;">Perangkat Daerah</th>
                    <th style="width: 7%;">Dokumen Anggaran</th>
                    <th style="width: 7%;">Realisasi</th>
                    <th style="width: 6%;">Vol Target</th>
                    <th style="width: 4%;">Status</th>
                    <th style="width: 4%;">Catatan</th>
                    <th style="width: 4%;">Ket</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monev as $i => $row)
                    <tr>
                        {{-- No --}}
                        <td class="text-center">{{ $i + 1 }}</td>

                        {{-- Kolom Data Utama --}}
                        <td class="text-left long-text">{{ $row->subprogram->subprogram ?? '-' }}</td>
                        <td class="text-left long-text">{{ $row->rencanakerja->rencana_aksi ?? '-' }}</td>
                        <td class="text-left long-text">{{ $row->sub_kegiatan }}</td>
                        <td class="text-left long-text">{{ $row->kegiatan }}</td>
                        <td class="text-left long-text">{{ $row->nama_program }}</td>
                        <td class="text-center">{{ $row->lokasi }}</td>
                        <td class="text-center">{{ $row->volume }}</td>
                        <td class="text-center">{{ $row->satuan }}</td>
                        {{-- Anggaran (dengan logika multi-baris & format Rupiah) --}}
                        {{-- ANGGARAN (dengan garis pemisah) --}}
                        <td class="text-center">
                            @php $anggarans = explode('; ', $row->anggaran); @endphp
                            @foreach ($anggarans as $anggaran)
                                {{-- Bungkus setiap item dengan div untuk styling --}}
                                <div
                                    style="padding: 4px 2px; @if (!$loop->last) border-bottom: 1px solid #dee2e6; @endif">
                                    @if (is_numeric($anggaran))
                                        {{ 'Rp ' . number_format((float) $anggaran, 0, ',', '.') }}
                                    @else
                                        {{ $anggaran ?: '-' }}
                                    @endif
                                </div>
                            @endforeach
                        </td>

                        {{-- SUMBER DANA (dengan garis pemisah) --}}
                        <td class="text-center">
                            @php $sumberdanas = explode('; ', $row->sumberdana); @endphp
                            @foreach ($sumberdanas as $sumber)
                                {{-- Bungkus setiap item dengan div untuk styling --}}
                                <div
                                    style="padding: 4px 2px; @if (!$loop->last) border-bottom: 1px solid #dee2e6; @endif">
                                    {{ $sumber ?: '-' }}
                                </div>
                            @endforeach
                        </td>

                        {{-- Tahun --}}
                        <td class="text-center">{{ $row->tahun }}</td>

                        {{-- Perangkat Daerah --}}
                        <td class="text-center">{{ $row->opd->nama ?? '-' }}</td>

                        {{-- RKA / Dokumen Anggaran (menggunakan style PDF) --}}
                        <td class="text-center">
                            @if (is_array($row->dokumen_anggaran) && !empty(array_filter($row->dokumen_anggaran)))
                                @foreach ($row->dokumen_anggaran ?? [] as $status)
                                    @if ($status)
                                        <span
                                            class="status-badge {{ str_contains($status, 'ADA') ? 'rka-sudah' : 'rka-belum' }}">{{ $status }}</span><br>
                                    @endif
                                @endforeach
                            @else
                                <span class="status-badge rka-belum">Belum</span>
                            @endif
                        </td>

                        {{-- REALISASI (dengan jarak nilai yang lebih dekat) --}}
                        <td class="text-left">
                            @if (is_array($row->realisasi) && !empty(array_filter($row->realisasi)))
                                @php $romanMap = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV']; @endphp

                                <table style="border: none; width: 100%; font-size: 7px;">
                                    @foreach ($row->realisasi as $triwulan => $nilai)
                                        @if ($nilai)
                                            <tr style="background-color: transparent !important;">
                                                <td
                                                    style="border: none; padding: 1px; width: 35%; vertical-align: middle;">
                                                    TW {{ $romanMap[$triwulan] ?? $triwulan }}
                                                </td>
                                                <td
                                                    style="border: none; padding: 1px; width: 5%; vertical-align: middle;">
                                                    :</td>
                                                <td
                                                    style="border: none; padding: 1px; text-align: left; font-weight: bold; vertical-align: middle; padding-left: 5px;">
                                                    {{ $nilai }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            @else
                                <span style="display: block; text-align: center;">-</span>
                            @endif
                        </td>

                        {{-- VOL TARGET (dengan perataan titik dua yang presisi) --}}
                        <td class="text-left">
                            @if (is_array($row->volumeTarget) && !empty(array_filter($row->volumeTarget)))
                                @php $romanMap = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV']; @endphp

                                <table style="border: none; width: 100%; font-size: 7px;">
                                    @foreach ($row->volumeTarget as $triwulan => $nilai)
                                        @if ($nilai)
                                            <tr style="background-color: transparent !important;">
                                                {{-- Kolom 1: Untuk Label (rata kiri) --}}
                                                <td
                                                    style="border: none; padding: 1px; width: 35%; vertical-align: middle; text-align: left;">
                                                    TW {{ $romanMap[$triwulan] ?? $triwulan }}
                                                </td>

                                                {{-- Kolom 2: Khusus untuk Titik Dua (rata tengah) --}}
                                                <td
                                                    style="border: none; padding: 1px; width: 5%; vertical-align: middle; text-align: center;">
                                                    :
                                                </td>

                                                {{-- Kolom 3: Untuk Nilai (rata tengah) --}}
                                                <td
                                                    style="border: none; padding: 1px; vertical-align: middle; font-weight: bold; text-align: center;">
                                                    {{ $nilai }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </table>
                            @else
                                <span style="display: block; text-align: center;">-</span>
                            @endif
                        </td>



                        {{-- Status (menggunakan style PDF) --}}
                        <td class="text-center">
                            @if ($row->status == 'Valid')
                                <span class="status-badge status-valid">Valid</span>
                            @else
                                <span class="status-badge status-pending">Pending</span>
                            @endif
                        </td>

                        {{-- Catatan (Pesan) & Keterangan (Uraian) --}}
                        <td class="text-center">{{ $row->pesan ?? '-' }}</td>
                        <td class="text-center">{{ $row->uraian ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <strong>Total Program:</strong> {{ count($monev) }} |
        <strong>Dicetak pada:</strong> {{ date('d F Y, H:i:s') }} WIB |
        Halaman 1
    </div>
</body>

</html>
