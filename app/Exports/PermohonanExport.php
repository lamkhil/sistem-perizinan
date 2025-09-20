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

class PermohonanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Permohonan::with('user')->orderBy('created_at', 'desc')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'SEKTOR',
            'WAKTU',
            'NO. PERMOHONAN (PD TEKNIS)',
            'NO. PROYEK (PD TEKNIS)',
            'TANGGAL PERMOHONAN (PD TEKNIS)',
            'NIB (PD TEKNIS)',
            'KBU (PD TEKNIS)',
            'KEGIATAN (PD TEKNIS)',
            'JENIS PERUSAHAAN (PD TEKNIS)',
            'NAMA PERUSAHAAN (PD TEKNIS)',
            'NAMA USAHA (DPM)',
            'ALAMAT PERUSAHAAN (DPM)',
            'MODAL USAHA (DPM)',
            'JENIS PROYEK (DPM)',
            'VERIFIKASI OLEH PD TEKNIS',
            'VERIFIKASI OLEH DPMPTSP',
            'PENGEMBALIAN (TANGGAL)',
            'KETERANGAN',
            'MENGHUBUNGI (TANGGAL)',
            'KETERANGAN',
            'APPROVED (TANGGAL)',
            'TERBIT (TANGGAL)',
            'KETERANGAN',
            'PEMROSES DAN TGL E SURAT DAN TGL PERTEK',
            'VERIFIKATOR',
            'KETERANGAN'
        ];
    }

    /**
     * @param mixed $permohonan
     * @return array
     */
    public function map($permohonan): array
    {
        return [
            // SEKTOR
            $permohonan->sektor ?? '',
            // WAKTU (created_at)
            $permohonan->created_at ? \Carbon\Carbon::parse($permohonan->created_at)->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') : '',
            // NO. PERMOHONAN (PD TEKNIS)
            $permohonan->no_permohonan ?? '',
            // NO. PROYEK (PD TEKNIS)
            $permohonan->no_proyek ?? '',
            // TANGGAL PERMOHONAN (PD TEKNIS)
            $permohonan->tanggal_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->format('d/m/Y') : '',
            // NIB (PD TEKNIS)
            $permohonan->nib ?? '',
            // KBU (PD TEKNIS) - menggunakan kbli
            $permohonan->kbli ?? '',
            // KEGIATAN (PD TEKNIS) - menggunakan inputan_teks
            $permohonan->inputan_teks ?? '',
            // JENIS PERUSAHAAN (PD TEKNIS)
            $permohonan->jenis_perusahaan ?? '',
            // NAMA PERUSAHAAN (PD TEKNIS) - menggunakan nama_usaha
            $permohonan->nama_usaha ?? '',
            // NAMA USAHA (DPM) - menggunakan nama_usaha
            $permohonan->nama_usaha ?? '',
            // ALAMAT PERUSAHAAN (DPM)
            $permohonan->alamat_perusahaan ?? '',
            // MODAL USAHA (DPM)
            $permohonan->modal_usaha ? 'Rp ' . number_format($permohonan->modal_usaha, 0, ',', '.') : '',
            // JENIS PROYEK (DPM)
            $permohonan->jenis_proyek ?? '',
            // VERIFIKASI OLEH PD TEKNIS
            $permohonan->verifikasi_pd_teknis ?? '',
            // VERIFIKASI OLEH DPMPTSP
            $permohonan->verifikasi_dpmptsp ?? '',
            // PENGEMBALIAN (TANGGAL)
            $permohonan->pengembalian ? \Carbon\Carbon::parse($permohonan->pengembalian)->format('d/m/Y') : '',
            // KETERANGAN (pengembalian)
            $permohonan->keterangan_pengembalian ?? '',
            // MENGHUBUNGI (TANGGAL)
            $permohonan->menghubungi ? \Carbon\Carbon::parse($permohonan->menghubungi)->format('d/m/Y') : '',
            // KETERANGAN (menghubungi)
            $permohonan->keterangan_menghubungi ?? '',
            // APPROVED (TANGGAL) - menggunakan perbaikan
            $permohonan->perbaikan ? \Carbon\Carbon::parse($permohonan->perbaikan)->format('d/m/Y') : '',
            // TERBIT (TANGGAL)
            $permohonan->terbit ? \Carbon\Carbon::parse($permohonan->terbit)->format('d/m/Y') : '',
            // KETERANGAN (terbit)
            $permohonan->keterangan_terbit ?? '',
            // PEMROSES DAN TGL E SURAT DAN TGL PERTEK
            $permohonan->pemroses_dan_tgl_surat ?? '',
            // VERIFIKATOR
            $permohonan->verifikator ?? '',
            // KETERANGAN (umum) - menggunakan status
            $permohonan->status ?? ''
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => [
                'font' => ['bold' => true, 'size' => 12],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E3F2FD']
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                ]
            ],
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 12,  // SEKTOR
            'B' => 15,  // WAKTU
            'C' => 25,  // NO. PERMOHONAN
            'D' => 20,  // NO. PROYEK
            'E' => 15,  // TANGGAL PERMOHONAN
            'F' => 15,  // NIB
            'G' => 8,   // KBU
            'H' => 20,  // KEGIATAN
            'I' => 20,  // JENIS PERUSAHAAN
            'J' => 25,  // NAMA PERUSAHAAN
            'K' => 25,  // NAMA USAHA
            'L' => 35,  // ALAMAT PERUSAHAAN
            'M' => 15,  // MODAL USAHA
            'N' => 15,  // JENIS PROYEK
            'O' => 20,  // VERIFIKASI PD TEKNIS
            'P' => 20,  // VERIFIKASI DPMPTSP
            'Q' => 15,  // PENGEMBALIAN
            'R' => 20,  // KETERANGAN
            'S' => 15,  // MENGHUBUNGI
            'T' => 20,  // KETERANGAN
            'U' => 15,  // APPROVED
            'V' => 15,  // TERBIT
            'W' => 20,  // KETERANGAN
            'X' => 30,  // PEMROSES
            'Y' => 15,  // VERIFIKATOR
            'Z' => 15,  // KETERANGAN
        ];
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Set all cells to wrap text
                $sheet->getStyle('A:Z')->getAlignment()->setWrapText(true);
                
                // Set row height for header
                $sheet->getRowDimension(1)->setRowHeight(25);
                
                // Set borders for all data
                $sheet->getStyle('A1:Z' . ($sheet->getHighestRow()))->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                
                // Auto-fit columns
                foreach (range('A', 'Z') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(false);
                }
            },
        ];
    }
}
