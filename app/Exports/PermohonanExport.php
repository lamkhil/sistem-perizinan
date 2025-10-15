<?php

namespace App\Exports;

use App\Models\Permohonan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class PermohonanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithEvents, WithColumnFormatting
{
    protected $user;

    public function __construct($user = null)
    {
        $this->user = $user;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $permohonans = Permohonan::with('user');

        // Filter berdasarkan peran jika user diberikan
        if ($this->user) {
            if ($this->user->role === 'dpmptsp') {
                // DPMPTSP melihat semua permohonan kecuali yang dibuat oleh penerbitan_berkas
                $permohonans->whereHas('user', function($query) {
                    $query->where('role', '!=', 'penerbitan_berkas');
                });
            } elseif ($this->user->role === 'pd_teknis') {
                // PD Teknis melihat permohonan sesuai sektornya saja
                if ($this->user->sektor) {
                    $permohonans->where('sektor', $this->user->sektor)
                        ->whereHas('user', function($query) {
                            $query->where('role', '!=', 'penerbitan_berkas');
                        });
                } else {
                    // Jika PD Teknis belum ada sektor, tampilkan semua (fallback)
                    $permohonans->whereHas('user', function($query) {
                        $query->where('role', '!=', 'penerbitan_berkas');
                    });
                }
            } elseif ($this->user->role === 'penerbitan_berkas') {
                // Penerbitan Berkas hanya melihat data yang dibuat oleh role penerbitan_berkas
                $permohonans->whereHas('user', function($query) {
                    $query->where('role', 'penerbitan_berkas');
                });
            }
            // Admin melihat semua permohonan secara default
        }

        return $permohonans->orderBy('created_at', 'asc')->get();
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
            'JENIS PERUSAHAAN (PD TEKNIS)',
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
            $permohonan->tanggal_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->locale('id')->translatedFormat('d/m/Y') : '',
            // NIB (PD TEKNIS)
            $permohonan->nib ?? '',
            // KBLI (PD TEKNIS)
            $permohonan->kbli ?? '',
            // KEGIATAN (PD TEKNIS)
            $permohonan->inputan_teks ?? '',
            // JENIS PERUSAHAAN (PD TEKNIS)
            $permohonan->jenis_perusahaan_display,
            // NAMA PERUSAHAAN (PD TEKNIS)
            $permohonan->nama_perusahaan ?? '',
            // NAMA USAHA (DPM)
            $permohonan->nama_usaha ?? '',
            // ALAMAT PERUSAHAAN (DPM)
            $permohonan->alamat_perusahaan ?? '',
            // MODAL USAHA (DPM)
            $permohonan->modal_usaha ? number_format((float) $permohonan->modal_usaha, 0, ',', '.') : '',
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
            $permohonan->pengembalian ? \Carbon\Carbon::parse($permohonan->pengembalian)->locale('id')->translatedFormat('d/m/Y') : '',
            // KETERANGAN (pengembalian)
            $permohonan->keterangan_pengembalian ?? '',
            // MENGHADAP NO (TANGGAL)
            $permohonan->menghubungi ? \Carbon\Carbon::parse($permohonan->menghubungi)->locale('id')->translatedFormat('d/m/Y') : '',
            // KETERANGAN (menghubungi)
            $permohonan->keterangan_menghubungi ?? '',
            // APPROVED (TANGGAL)
            $permohonan->perbaikan ? \Carbon\Carbon::parse($permohonan->perbaikan)->locale('id')->translatedFormat('d/m/Y') : '',
            // KETERANGAN (disetujui)
            $permohonan->keterangan_disetujui ?? '',
            // TERBIT (TANGGAL)
            $permohonan->terbit ? \Carbon\Carbon::parse($permohonan->terbit)->locale('id')->translatedFormat('d/m/Y') : '',
            // KETERANGAN (terbit)
            $permohonan->keterangan_terbit ?? '',
            // PEMROSES DAN TGL E-SURAT DAN TGL PERTEK
            $permohonan->created_at ? \Carbon\Carbon::parse($permohonan->created_at)->locale('id')->translatedFormat('d/m/Y') : '',
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
            // Style the first row as normal text with font size 12
            1    => [
                'font' => ['bold' => false, 'size' => 12],
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
            'A' => 15,  // SEKTOR
            'B' => 10,  // WAKTU
            'C' => 20,  // NO. PERMOHONAN
            'D' => 18,  // NO. PROYEK
            'E' => 12,  // TANGGAL PERMOHONAN
            'F' => 12,  // NIB
            'G' => 10,  // KBLI
            'H' => 20,  // KEGIATAN
            'I' => 15,  // JENIS USAHA
            'J' => 20,  // NAMA PERUSAHAAN
            'K' => 20,  // NAMA USAHA
            'L' => 25,  // ALAMAT PERUSAHAAN
            'M' => 15,  // MODAL USAHA
            'N' => 15,  // JENIS PROYEK
            'O' => 20,  // NAMA PERIZINAN
            'P' => 15,  // SKALA USAHA
            'Q' => 10,  // RISIKO
            'R' => 18,  // JANGKA WAKTU
            'S' => 15,  // NO TELPHONE
            'T' => 20,  // VERIFIKASI PD TEKNIS
            'U' => 20,  // VERIFIKASI ANALISA
            'V' => 12,  // TANGGAL PENGEMBALIAN
            'W' => 25,  // KETERANGAN PENGEMBALIAN
            'X' => 12,  // TANGGAL MENGHUBUNGI
            'Y' => 25,  // KETERANGAN MENGHUBUNGI
            'Z' => 12,  // TANGGAL DISETUJUI
            'AA' => 25, // KETERANGAN DISETUJUI
            'AB' => 12, // TANGGAL TERBIT
            'AC' => 25, // KETERANGAN TERBIT
            'AD' => 25, // PEMROSES
            'AE' => 12, // VERIFIKATOR
            'AF' => 10, // STATUS
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
                
                // Set NIB column (F) as text format to prevent scientific notation
                for ($row = 2; $row <= $highestRow; $row++) {
                    $cellValue = $sheet->getCell('F' . $row)->getValue();
                    if ($cellValue && $cellValue !== '') {
                        $sheet->setCellValueExplicit('F' . $row, $cellValue, DataType::TYPE_STRING);
                    }
                }
                
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

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_TEXT, // NIB column as text
        ];
    }
}
