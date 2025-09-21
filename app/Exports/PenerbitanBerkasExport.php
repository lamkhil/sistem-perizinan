<?php

namespace App\Exports;

use App\Models\Permohonan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenerbitanBerkasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithEvents
{
    public function collection()
    {
        return Permohonan::with('user')->orderBy('created_at', 'desc')->get();
    }

    public function headings(): array
    {
        return [
            'NO',
            'NO. PERMOHONAN',
            'NO. PROYEK',
            'TANGGAL PERMOHONAN',
            'NIB',
            'KBU',
            'KEGIATAN',
            'JENIS PERUSAHAAN',
            'NAMA PERUSAHAAN',
            'NAMA USAHA',
            'PEMILIK',
            'MODAL USAHA',
            'ALAMAT PERUSAHAAN',
            'JENIS PROYEK',
            'NAMA PERIZINAN',
            'SKALA USAHA',
            'RISIKO',
            'VERIFIKATOR',
            'STATUS',
            'SEKTOR',
            'TANGGAL DIBUAT',
            'TANGGAL DIPERBARUI'
        ];
    }

    public function map($permohonan): array
    {
        return [
            $permohonan->id,
            $permohonan->no_permohonan ?? '-',
            $permohonan->no_proyek ?? '-',
            $permohonan->tanggal_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->format('d/m/Y') : '-',
            $permohonan->nib ?? '-',
            $permohonan->kbli ?? '-',
            $permohonan->inputan_teks ?? '-',
            $permohonan->jenis_pelaku_usaha ?? '-',
            $permohonan->nama_perusahaan ?? '-',
            $permohonan->nama_usaha ?? '-',
            $permohonan->pemilik ?? '-',
            $permohonan->modal_usaha ?? '-',
            $permohonan->alamat_perusahaan ?? '-',
            $permohonan->jenis_proyek ?? '-',
            $permohonan->nama_perizinan ?? '-',
            $permohonan->skala_usaha ?? '-',
            $permohonan->risiko ?? '-',
            $permohonan->verifikator ?? '-',
            $permohonan->status ?? '-',
            $permohonan->sektor ?? '-',
            $permohonan->created_at ? \Carbon\Carbon::parse($permohonan->created_at)->format('d/m/Y H:i') : '-',
            $permohonan->updated_at ? \Carbon\Carbon::parse($permohonan->updated_at)->format('d/m/Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Header row styling
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,   // NO
            'B' => 20,  // NO. PERMOHONAN
            'C' => 20,  // NO. PROYEK
            'D' => 18,  // TANGGAL PERMOHONAN
            'E' => 15,  // NIB
            'F' => 15,  // KBU
            'G' => 25,  // KEGIATAN
            'H' => 20,  // JENIS PERUSAHAAN
            'I' => 25,  // NAMA PERUSAHAAN
            'J' => 25,  // NAMA USAHA
            'K' => 20,  // PEMILIK
            'L' => 15,  // MODAL USAHA
            'M' => 30,  // ALAMAT PERUSAHAAN
            'N' => 20,  // JENIS PROYEK
            'O' => 25,  // NAMA PERIZINAN
            'P' => 15,  // SKALA USAHA
            'Q' => 15,  // RISIKO
            'R' => 20,  // VERIFIKATOR
            'S' => 15,  // STATUS
            'T' => 15,  // SEKTOR
            'U' => 20,  // TANGGAL DIBUAT
            'V' => 20,  // TANGGAL DIPERBARUI
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Set text wrapping for all cells
                $sheet->getStyle('A1:V' . $sheet->getHighestRow())->getAlignment()->setWrapText(true);
                
                // Set row height
                $sheet->getDefaultRowDimension()->setRowHeight(20);
                
                // Add borders to all cells
                $sheet->getStyle('A1:V' . $sheet->getHighestRow())->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                
                // Center align all data
                $sheet->getStyle('A2:V' . $sheet->getHighestRow())->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A2:V' . $sheet->getHighestRow())->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            },
        ];
    }
}
