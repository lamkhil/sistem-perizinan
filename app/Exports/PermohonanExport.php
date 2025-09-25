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
            'SEKSI',
            'WAKTU',
            'NO. PERMOHONAN (PD TEKNIS)',
            'NO. PROYEK (PD TEKNIS)',
            'TANGGAL PERMOHONAN (PD TEKNIS)',
            'NIB (PD TEKNIS)',
            'KBLI (PD TEKNIS)',
            'KEGIATAN (PD TEKNIS)',
            'JENIS USAHA (PD TEKNIS)',
            'NAMA PERUSAHAAN (PD TEKNIS)',
            'NAMA USAHA (DPM)',
            'ALAMAT PERUSAHAAN (DPM)',
            'MODAL USAHA (DPM)',
            'JENIS PROYEK (DPM)',
            'NAMA PERIZINAN (DPM)',
            'SKALA USAHA (DPM)',
            'RISIKO (DPM)',
            'JANGKA WAKTU (HARI KERJA) (DPM)',
            'NO TELPHONE (DPM)',
            'VERIFIKASI OLEH PD TEKNIS',
            'VERIFIKASI OLEH DPMPTSP',
            'PENGEMBALIAN (TANGGAL)',
            'KETERANGAN',
            'MENGHADAP NO (TANGGAL)',
            'KETERANGAN',
            'APPROVED (TANGGAL)',
            'KETERANGAN',
            'TERBIT (TANGGAL)',
            'KETERANGAN',
            'PEMROSES DAN TGL E-SURAT DAN TGL PERTEK',
            'VERIFIKATOR',
            'STATUS'
        ];
    }

    /**
     * @param mixed $permohonan
     * @return array
     */
    public function map($permohonan): array
    {
        return [
            // SEKSI (sektor)
            $permohonan->sektor ?? '',
            // WAKTU (tahun)
            $permohonan->created_at ? \Carbon\Carbon::parse($permohonan->created_at)->format('Y') : '',
            // NO. PERMOHONAN (PD TEKNIS)
            $permohonan->no_permohonan ?? '',
            // NO. PROYEK (PD TEKNIS)
            $permohonan->no_proyek ?? '',
            // TANGGAL PERMOHONAN (PD TEKNIS)
            $permohonan->tanggal_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->format('d/m/Y') : '',
            // NIB (PD TEKNIS)
            $permohonan->nib ?? '',
            // KBLI (PD TEKNIS)
            $permohonan->kbli ?? '',
            // KEGIATAN (PD TEKNIS)
            $permohonan->inputan_teks ?? '',
            // JENIS USAHA (PD TEKNIS)
            $permohonan->jenis_pelaku_usaha ?? '',
            // NAMA PERUSAHAAN (PD TEKNIS)
            $permohonan->nama_perusahaan ?? '',
            // NAMA USAHA (DPM)
            $permohonan->nama_usaha ?? '',
            // ALAMAT PERUSAHAAN (DPM)
            $permohonan->alamat_perusahaan ?? '',
            // MODAL USAHA (DPM)
            $permohonan->modal_usaha ? number_format($permohonan->modal_usaha, 0, ',', '.') : '',
            // JENIS PROYEK (DPM)
            $permohonan->jenis_proyek ?? '',
            // NAMA PERIZINAN (DPM)
            $permohonan->nama_perizinan ?? '',
            // SKALA USAHA (DPM)
            $permohonan->skala_usaha ?? '',
            // RISIKO (DPM)
            $permohonan->risiko ?? '',
            // JANGKA WAKTU (HARI KERJA) (DPM)
            $permohonan->jangka_waktu ?? '',
            // NO TELPHONE (DPM)
            $permohonan->no_telephone ?? '',
            // VERIFIKASI OLEH PD TEKNIS
            $permohonan->verifikasi_pd_teknis ?? '',
            // VERIFIKASI OLEH DPMPTSP
            $permohonan->verifikasi_dpmptsp ?? '',
            // PENGEMBALIAN (TANGGAL)
            $permohonan->pengembalian ? \Carbon\Carbon::parse($permohonan->pengembalian)->format('d/m/Y') : '',
            // KETERANGAN (pengembalian)
            $permohonan->keterangan_pengembalian ?? '',
            // MENGHADAP NO (TANGGAL)
            $permohonan->menghubungi ? \Carbon\Carbon::parse($permohonan->menghubungi)->format('d/m/Y') : '',
            // KETERANGAN (menghubungi)
            $permohonan->keterangan_menghubungi ?? '',
            // APPROVED (TANGGAL)
            $permohonan->perbaikan ? \Carbon\Carbon::parse($permohonan->perbaikan)->format('d/m/Y') : '',
            // KETERANGAN (perbaikan)
            $permohonan->keterangan_perbaikan ?? '',
            // TERBIT (TANGGAL)
            $permohonan->terbit ? \Carbon\Carbon::parse($permohonan->terbit)->format('d/m/Y') : '',
            // KETERANGAN (terbit)
            $permohonan->keterangan_terbit ?? '',
            // PEMROSES DAN TGL E-SURAT DAN TGL PERTEK
            $permohonan->created_at ? \Carbon\Carbon::parse($permohonan->created_at)->format('d/m/Y') : '',
            // VERIFIKATOR
            $permohonan->verifikator ?? '',
            // STATUS
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
            'A' => 12,  // SEKSI
            'B' => 8,   // WAKTU
            'C' => 25,  // NO. PERMOHONAN
            'D' => 20,  // NO. PROYEK
            'E' => 15,  // TANGGAL PERMOHONAN
            'F' => 15,  // NIB
            'G' => 8,   // KBLI
            'H' => 20,  // KEGIATAN
            'I' => 15,  // JENIS USAHA
            'J' => 25,  // NAMA PERUSAHAAN
            'K' => 25,  // NAMA USAHA
            'L' => 35,  // ALAMAT PERUSAHAAN
            'M' => 15,  // MODAL USAHA
            'N' => 15,  // JENIS PROYEK
            'O' => 20,  // NAMA PERIZINAN
            'P' => 15,  // SKALA USAHA
            'Q' => 10,  // RISIKO
            'R' => 15,  // JANGKA WAKTU
            'S' => 15,  // NO TELPHONE
            'T' => 20,  // VERIFIKASI PD TEKNIS
            'U' => 20,  // VERIFIKASI DPMPTSP
            'V' => 15,  // PENGEMBALIAN
            'W' => 20,  // KETERANGAN
            'X' => 15,  // MENGHADAP NO
            'Y' => 20,  // KETERANGAN
            'Z' => 15,  // APPROVED
            'AA' => 20, // KETERANGAN
            'AB' => 15, // TERBIT
            'AC' => 20, // KETERANGAN
            'AD' => 30, // PEMROSES
            'AE' => 15, // VERIFIKATOR
            'AF' => 15, // STATUS
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
                $sheet->getStyle('A:AF')->getAlignment()->setWrapText(true);
                
                // Set row height for header
                $sheet->getRowDimension(1)->setRowHeight(25);
                
                // Set borders for all data
                $sheet->getStyle('A1:AF' . ($sheet->getHighestRow()))->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                
                // Auto-fit columns
                foreach (range('A', 'AF') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(false);
                }
            },
        ];
    }
}
