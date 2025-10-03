<?php
// FILE: app/Exports/PermohonanSemuaExport.php

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

class PermohonanSemuaExport implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithColumnFormatting
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
                'Sektor' => $p->sektor,
                'No. Permohonan' => $p->no_permohonan,
                'No. Proyek' => $p->no_proyek,
                'Tgl. Permohonan' => $p->tanggal_permohonan,
                'NIB' => "'" . $p->nib,
                'Nama Usaha' => $p->nama_usaha,
                'Alamat' => $p->alamat_perusahaan,
                'Modal Usaha' => $p->modal_usaha,
                'Jenis Proyek' => $p->jenis_proyek,
                'Verifikasi PD Teknis' => $p->verifikasi_pd_teknis,
                'Verifikasi DPMPTSP' => $p->verifikasi_dpmptsp,
                'Status' => $p->status,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Sektor',
            'No. Permohonan',
            'No. Proyek',
            'Tgl. Permohonan',
            'NIB',
            'Nama Usaha',
            'Alamat',
            'Modal Usaha',
            'Jenis Proyek',
            'Verifikasi PD Teknis',
            'Verifikasi DPMPTSP',
            'Status',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, 'B' => 35, 'C' => 20, 'D' => 20, 'E' => 25,
            'F' => 30, 'G' => 45, 'H' => 20, 'I' => 20, 'J' => 30,
            'K' => 30, 'L' => 15,
        ];
    }

    public function columnFormats(): array
    {
        return ['E' => NumberFormat::FORMAT_TEXT]; // Paksa kolom NIB menjadi format Teks
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:L1')->getFont()->setBold(true);
        $styleArray = ['borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]];
        $sheet->getStyle('A1:L' . ($this->permohonans->count() + 1))->applyFromArray($styleArray);
    }
}