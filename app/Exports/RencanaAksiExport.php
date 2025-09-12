<?php

namespace App\Exports;

use App\Models\RencanaAksi_6_tahun;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;


class RencanaAksiExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize, WithCustomStartCell, WithColumnWidths
{
    public function collection()
    {
        return RencanaAksi_6_tahun::with(['subprogram', 'opd', 'penggunas'])->get()->map(function ($item) {
            return [
                'ID'             => $item->id,
                'Sub Program'    => $item->subprogram->subprogram ?? '-',
                'Rencana Aksi'   => $item->rencana_aksi,
                'Sub Kegiatan'   => $item->sub_kegiatan,
                'Kegiatan'       => $item->kegiatan,
                'Nama Program'   => $item->nama_program,
                'Lokasi'         => $item->lokasi,
                'Volume'         => $item->volume,
                'Satuan'         => $item->satuan,
                'Anggaran'       => $item->anggaran,
                'Sumber Dana'    => $item->sumberdana,
                'Tahun'          => $item->tahun,
                'Perangkat Daerah' => $item->opd->nama ?? '-',
                'Keterangan'     => $item->keterangan,
            ];
        });
    }

    public function startCell(): string
    {
        return 'A3';
    }

    public function headings(): array
    {
        return [
            'NO',
            'Sub Program',
            'Rencana Aksi',
            'Sub Kegiatan',
            'Kegiatan',
            'Nama Program',
            'Lokasi',
            'Volume',
            'Satuan',
            'Anggaran',
            'Sumber Dana',
            'Tahun',
            'Perangkat Daerah',
            'Keterangan',
        ];
    }





    public function styles(Worksheet $sheet)
    {
        // Judul
        $sheet->mergeCells('A1:O1');
        $sheet->setCellValue('A1', 'Rencana Aksi IAD Perhutanan Sosial');

        $lastColumn = $sheet->getHighestColumn();
        $lastRow    = $sheet->getHighestRow();

        // Header abu-abu baris 3
        $headerRange = "A3:{$lastColumn}3";
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => [
                'bold' => true,
                'size' => 11,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText'   => true,
            ],
            'fill' => [
                'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFD3D3D3'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ]);
        $sheet->getRowDimension(3)->setRowHeight(28);

        // Isi data: row 4 sampai terakhir
        for ($row = 4; $row <= $lastRow; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(60); // 👈 tinggi lebih besar
        }

        // Supaya teks panjang tidak tenggelam
        $sheet->getStyle("A1:{$lastColumn}{$lastRow}")
            ->getAlignment()
            ->setWrapText(true)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

        return [
            1 => [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical'   => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }




    public function title(): string
    {
        return 'Rencana Aksi';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // ID
            'B' => 20,  // Sub Program
            'C' => 20,  // Rencana Aksi
            'D' => 30,  // Sub Kegiatan
            'E' => 20,  // Kegiatan
            'F' => 25,  // Nama Program
            'G' => 20,  // Lokasi
            'H' => 10,  // Volume
            'I' => 10,  // Satuan
            'J' => 10,  // Anggaran
            'K' => 10,  // Sumber Dana
            'L' => 10,  // Tahun
            'M' => 20,  // Perangkat Daerah
            'N' => 20,  // Keterangan
        ];
    }
}
