<?php
// FILE: app/Exports/PermohonanPdTeknisExport.php

namespace App\Exports;

use App\Models\Permohonan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Ramsey\Uuid\Type\Integer;

class PermohonanPdTeknisExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithColumnFormatting
{
    protected $permohonans;

    public function __construct(Collection $permohonans)
    {
        $this->permohonans = $permohonans;
    }

    public function collection()
    {
        return $this->permohonans->map(function ($p) {
            return [
                'No. Permohonan' => $p->no_permohonan,
                'No. Proyek' => $p->no_proyek,
                'Tgl. Permohonan' => $p->tanggal_permohonan,
                'NIB' => $p->nib,
                'Verifikasi PD Teknis' => $p->verifikasi_pd_teknis,
                'Status' => $p->status,
            ];
        });
    }

    public function headings(): array
    {
        return ['No. Permohonan', 'No. Proyek', 'Tgl. Permohonan', 'NIB', 'Verifikasi PD Teknis', 'Status'];
    }

    public function columnWidths(): array
    {
        return ['A' => 35, 'B' => 20, 'C' => 20, 'D' => 25, 'E' => 30, 'F' => 15];
    }

    public function columnFormats(): array
    {
        return ['D' => NumberFormat::FORMAT_TEXT]; // Paksa kolom NIB menjadi format Teks
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]];
        $sheet->getStyle('A1:F' . ($this->permohonans->count() + 1))->applyFromArray($styleArray);
    }
}