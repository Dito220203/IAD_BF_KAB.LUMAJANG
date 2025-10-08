<?php

namespace App\Exports;

use App\Models\Monev;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MonevExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize, WithCustomStartCell, WithColumnWidths
{
    protected $tahun;
    protected $user;

    public function __construct($user, $tahun)
    {
        $this->user = $user;
        $this->tahun = $tahun;
    }

    // =============================================================
    // MODIFIKASI TOTAL: Method ini diubah agar bisa membuat baris baru
    // untuk anggaran/sumberdana, sama seperti di RencanaExport.
    // =============================================================
    public function collection()
    {
        // Query untuk mengambil data tetap sama
        $query = Monev::with(['subprogram', 'opd', 'rencanakerja']);

        if ($this->user->level !== 'Super Admin') {
            $query->where('id_pengguna', $this->user->id);
        }

        if ($this->tahun) {
            $query->where('tahun', $this->tahun);
        }

        $monevs = $query->get();

        // Logika baru untuk menyusun baris-baris Excel
        $rows = collect();
        $no = 1;

        foreach ($monevs as $item) {
            // 1. Pecah string anggaran dan sumberdana menjadi array
            $anggarans = $item->anggaran ? explode('; ', $item->anggaran) : ['-'];
            $sumberdanas = $item->sumberdana ? explode('; ', $item->sumberdana) : ['-'];
            $maxRows = max(count($anggarans), count($sumberdanas));

            // Logika pemrosesan data lainnya (Realisasi, Vol Target, dll) tetap sama
            $dokAnggaranStr = is_array($item->dokumen_anggaran) ? implode("\n", array_filter($item->dokumen_anggaran)) : 'Belum';
            if (empty($dokAnggaranStr)) $dokAnggaranStr = 'Belum';

            $realisasiStr = '';
            if (is_array($item->realisasi)) {
                $realisasiLines = [];
                $romanMap = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV'];
                foreach($item->realisasi as $tw => $val) {
                    if ($val) $realisasiLines[] = "TW " . ($romanMap[$tw] ?? $tw) . ": " . $val;
                }
                $realisasiStr = implode("\n", $realisasiLines);
            }
            if (empty($realisasiStr)) $realisasiStr = '-';

            $volTargetStr = '';
            if (is_array($item->volumeTarget)) {
                $volTargetLines = [];
                $romanMap = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV'];
                foreach($item->volumeTarget as $tw => $val) {
                    if ($val) $volTargetLines[] = "TW " . ($romanMap[$tw] ?? $tw) . ": " . $val;
                }
                $volTargetStr = implode("\n", $volTargetLines);
            }
            if (empty($volTargetStr)) $volTargetStr = '-';

            // 2. Looping untuk membuat baris Excel
            for ($i = 0; $i < $maxRows; $i++) {
                if ($i === 0) {
                    // Baris pertama berisi semua data
                    $rows->push([
                        'No'                => $no,
                        'Sub Program'       => $item->subprogram->subprogram ?? '-',
                        'Rencana Aksi'      => $item->rencanakerja->rencana_aksi ?? '-',
                        'Sub Kegiatan'      => $item->sub_kegiatan,
                        'Kegiatan'          => $item->kegiatan,
                        'Program'           => $item->nama_program,
                        'Lokasi'            => $item->lokasi,
                        'Vol'               => $item->volume,
                        'Satuan'            => $item->satuan,
                        'Anggaran'          => $anggarans[$i] ?? '-',
                        'Sumber Dana'       => $sumberdanas[$i] ?? '-',
                        'Tahun'             => $item->tahun,
                        'Perangkat Daerah'  => $item->opd->nama ?? '-',
                        'Dokumen Anggaran'  => $dokAnggaranStr,
                        'Realisasi'         => $realisasiStr,
                        'Vol Target'        => $volTargetStr,
                        'Status'            => $item->status,
                        'Catatan'           => $item->pesan ?? '-',
                        'Ket'               => $item->uraian ?? '-',
                    ]);
                } else {
                    // Baris selanjutnya hanya berisi anggaran dan sumber dana
                    $rows->push([
                        'No' => '', 'Sub Program' => '', 'Rencana Aksi' => '', 'Sub Kegiatan' => '',
                        'Kegiatan' => '', 'Program' => '', 'Lokasi' => '', 'Vol' => '', 'Satuan' => '',
                        'Anggaran'          => $anggarans[$i] ?? '-',
                        'Sumber Dana'       => $sumberdanas[$i] ?? '-',
                        'Tahun' => '', 'Perangkat Daerah' => '', 'Dokumen Anggaran' => '', 'Realisasi' => '',
                        'Vol Target' => '', 'Status' => '', 'Catatan' => '', 'Ket' => '',
                    ]);
                }
            }
            $no++;
        }

        return $rows;
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function headings(): array
    {
        return [
            'No', 'Sub Program', 'Rencana Aksi', 'Sub Kegiatan', 'Kegiatan', 'Program',
            'Lokasi', 'Vol', 'Satuan', 'Anggaran', 'Sumber Dana', 'Tahun',
            'Perangkat Daerah', 'Dokumen Anggaran', 'Realisasi', 'Vol Target',
            'Status', 'Catatan', 'Ket',
        ];
    }

    // =============================================================
    // MODIFIKASI: Menambahkan logika MERGE CELL di method styles()
    // =============================================================
    public function styles(Worksheet $sheet)
    {
        $lastColumn = 'S';
        $sheet->mergeCells("A1:{$lastColumn}1");
        $sheet->setCellValue('A1', 'Monitoring dan Evaluasi IAD Perhutanan Sosial');
        $sheet->getRowDimension(1)->setRowHeight(30);
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 16],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ]);

        $headerRange = "A3:{$lastColumn}3";
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['argb' => 'FFFFFFFF']],
            'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF4F81BD']],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(28);

        $collection = $this->collection(); // Panggil collection di sini
        $rowCount = $collection->count();
        $lastRow = $rowCount > 0 ? (3 + $rowCount) : 3;

        $sheet->getStyle("A3:{$lastColumn}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
        ]);

        if ($rowCount > 0) {
            $leftAlignedColumns = ['B', 'C', 'D', 'E', 'F'];
            foreach ($leftAlignedColumns as $column) {
                $sheet->getStyle("{$column}4:{$column}{$lastRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            }
            $centerAlignedColumns = ['A', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S'];
            foreach ($centerAlignedColumns as $column) {
                $sheet->getStyle("{$column}4:{$column}{$lastRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            }

            // =============================================================
            // LOGIKA BARU: Menggabungkan sel (MERGE CELL)
            // =============================================================
            $currentRow = 4;
            foreach ($collection as $index => $row) {
                // Cek jika baris ini adalah baris pertama dari sebuah data (ada nomornya)
                if (!empty($row['No'])) {
                    $mergeCount = 0;
                    // Hitung berapa baris berikutnya yang kosong (untuk anggaran & sumberdana tambahan)
                    for ($j = $index + 1; $j < $rowCount; $j++) {
                        if (empty($collection[$j]['No'])) $mergeCount++;
                        else break;
                    }
                    // Jika ada baris tambahan, gabungkan selnya
                    if ($mergeCount > 0) {
                        $endRow = $currentRow + $mergeCount;
                        // Kolom yang akan di-merge (semua kecuali Anggaran 'J' dan Sumber Dana 'K')
                        $columnsToMerge = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S'];
                        foreach ($columnsToMerge as $column) {
                            $sheet->mergeCells("{$column}{$currentRow}:{$column}{$endRow}");
                        }
                    }
                }
                $currentRow++;
            }
        }
    }

    public function title(): string
    {
        return 'Monitoring dan Evaluasi';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   'B' => 25,  'C' => 30,  'D' => 30,  'E' => 25,
            'F' => 30,  'G' => 20,  'H' => 10,  'I' => 10,  'J' => 20,
            'K' => 20,  'L' => 10,  'M' => 25,  'N' => 20,  'O' => 20,
            'P' => 20,  'Q' => 15,  'R' => 30,  'S' => 30,
        ];
    }
}
