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
            'VERIFIKASI ANALISA (DPMPTSP)',
            'TANGGAL PENGEMBALIAN',
            'KETERANGAN PENGEMBALIAN',
            'TANGGAL MENGHUBUNGI',
            'KETERANGAN MENGHUBUNGI',
            'TANGGAL DISETUJUI',
            'KETERANGAN DISETUJUI',
            'TANGGAL TERBIT',
            'KETERANGAN TERBIT',
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
            // Style the first row as bold text with font size 12
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
            'A' => 18,  // SEKTOR
            'B' => 12,  // WAKTU
            'C' => 25,  // NO. PERMOHONAN
            'D' => 22,  // NO. PROYEK
            'E' => 15,  // TANGGAL PERMOHONAN
            'F' => 15,  // NIB
            'G' => 12,  // KBLI
            'H' => 25,  // KEGIATAN
            'I' => 18,  // JENIS USAHA
            'J' => 25,  // NAMA PERUSAHAAN
            'K' => 25,  // NAMA USAHA
            'L' => 30,  // ALAMAT PERUSAHAAN
            'M' => 18,  // MODAL USAHA
            'N' => 18,  // JENIS PROYEK
            'O' => 25,  // NAMA PERIZINAN
            'P' => 18,  // SKALA USAHA
            'Q' => 12,  // RISIKO
            'R' => 20,  // JANGKA WAKTU
            'S' => 18,  // NO TELPHONE
            'T' => 25,  // VERIFIKASI PD TEKNIS
            'U' => 25,  // VERIFIKASI ANALISA
            'V' => 15,  // TANGGAL PENGEMBALIAN
            'W' => 25,  // KETERANGAN PENGEMBALIAN
            'X' => 15,  // TANGGAL MENGHUBUNGI
            'Y' => 25,  // KETERANGAN MENGHUBUNGI
            'Z' => 15,  // TANGGAL DISETUJUI
            'AA' => 25, // KETERANGAN DISETUJUI
            'AB' => 15, // TANGGAL TERBIT
            'AC' => 25, // KETERANGAN TERBIT
            'AD' => 30, // PEMROSES
            'AE' => 15, // VERIFIKATOR
            'AF' => 12, // STATUS
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
                
                // Set all cells to wrap text and center alignment
                $sheet->getStyle('A:AF')->getAlignment()->setWrapText(true);
                $sheet->getStyle('A:AF')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A:AF')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                
                // Set font size 10 for data rows (excluding header)
                $highestRow = $sheet->getHighestRow();
                if ($highestRow > 1) {
                    $sheet->getStyle('A2:AF' . $highestRow)->getFont()->setSize(10);
                }
                
                // Set row height for header (wider)
                $sheet->getRowDimension(1)->setRowHeight(50);
                
                // Set borders for all data
                $sheet->getStyle('A1:AF' . $highestRow)->getBorders()->getAllBorders()
                    ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                
                // Auto-fit columns
                foreach (range('A', 'AF') as $column) {
                    $sheet->getColumnDimension($column)->setAutoSize(false);
                }
            },
        ];
    }
}
