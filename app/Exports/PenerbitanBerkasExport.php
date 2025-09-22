<?php

namespace App\Exports;

use App\Models\Permohonan;
use App\Models\TtdSetting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class PenerbitanBerkasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithEvents, WithDrawings
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
            'KBLI',
            'NAMA USAHA',
            'KEGIATAN',
            'JENIS PERUSAHAAN',
            'PEMILIK',
            'MODAL USAHA',
            'ALAMAT',
            'JENIS PROYEK',
            'NAMA PERIZINAN',
            'SKALA USAHA',
            'RISIKO',
            'PEMROSES DAN TGL. E SURAT DAN TGL PERTEK'
        ];
    }

    public function map($permohonan): array
    {
        // Format modal usaha dengan Rp
        $modalUsaha = $permohonan->modal_usaha ? 'Rp' . number_format($permohonan->modal_usaha, 0, ',', '.') : '-';
        
        // Format tanggal permohonan
        $tanggalPermohonan = $permohonan->tanggal_permohonan ? 
            \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->locale('id')->isoFormat('D MMMM Y') : '-';
        
        // Format pemroses dan tanggal (contoh format)
        $pemroses = 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                   'No: BAP/OSS/IX/PARKIR-341/436.7.15/' . date('Y') . "\n" .
                   'tanggal BAP: ' . date('d');

        return [
            $permohonan->id,
            $permohonan->no_permohonan ?? '-',
            $permohonan->no_proyek ?? '-',
            $tanggalPermohonan,
            $permohonan->nib ?? '-',
            $permohonan->kbli ?? '-',
            $permohonan->nama_usaha ?? '-',
            $permohonan->inputan_teks ?? '-',
            $permohonan->jenis_pelaku_usaha ?? '-',
            $permohonan->pemilik ?? '-',
            $modalUsaha,
            $permohonan->alamat_perusahaan ?? '-',
            $permohonan->jenis_proyek ?? '-',
            $permohonan->nama_perizinan ?? '-',
            $permohonan->skala_usaha ?? '-',
            $permohonan->risiko ?? '-',
            $pemroses
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
            'B' => 25,  // NO. PERMOHONAN
            'C' => 25,  // NO. PROYEK
            'D' => 20,  // TANGGAL PERMOHONAN
            'E' => 15,  // NIB
            'F' => 10,  // KBLI
            'G' => 30,  // NAMA USAHA
            'H' => 30,  // KEGIATAN
            'I' => 20,  // JENIS PERUSAHAAN
            'J' => 25,  // PEMILIK
            'K' => 20,  // MODAL USAHA
            'L' => 40,  // ALAMAT
            'M' => 20,  // JENIS PROYEK
            'N' => 30,  // NAMA PERIZINAN
            'O' => 15,  // SKALA USAHA
            'P' => 20,  // RISIKO
            'Q' => 50,  // PEMROSES DAN TGL. E SURAT DAN TGL PERTEK
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                
                // Set text wrapping for all cells
                $sheet->getStyle('A1:Q' . $lastRow)->getAlignment()->setWrapText(true);
                
                // Set row height
                $sheet->getDefaultRowDimension()->setRowHeight(20);
                
                // Add borders to all cells
                $sheet->getStyle('A1:Q' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                
                // Center align all data
                $sheet->getStyle('A2:Q' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A2:Q' . $lastRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                
                // Add TTD section after data - POSITIONED UNDER SPECIFIC COLUMNS
                $ttdRow = $lastRow + 3;
                
                // TTD Mengetahui (kiri) - di bawah kolom TANGGAL PERMOHONAN (kolom D)
                $sheet->setCellValue('D' . $ttdRow, 'Mengetahui');
                $sheet->getStyle('D' . $ttdRow)->getFont()->setBold(true);
                $sheet->getStyle('D' . $ttdRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->setCellValue('D' . ($ttdRow + 1), 'Koordinator Ketua Tim Kerja');
                $sheet->getStyle('D' . ($ttdRow + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->setCellValue('D' . ($ttdRow + 2), 'Pelayanan Terpadu Satu Pintu');
                $sheet->getStyle('D' . ($ttdRow + 2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                // Tambahkan baris kosong untuk spacing
                $sheet->setCellValue('D' . ($ttdRow + 4), 'Yohanes Franklin, S.H.');
                $sheet->getStyle('D' . ($ttdRow + 4))->getFont()->setBold(true);
                $sheet->setCellValue('D' . ($ttdRow + 5), 'Penata Tk.1');
                $sheet->setCellValue('D' . ($ttdRow + 6), 'NIP: 198502182010011008');
                
                // TTD Menyetujui (kanan) - di bawah kolom SKALA USAHA (kolom O)
                $sheet->setCellValue('O' . $ttdRow, 'Surabaya, ' . date('d F Y'));
                $sheet->getStyle('O' . $ttdRow)->getFont()->setBold(true);
                $sheet->getStyle('O' . $ttdRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->setCellValue('O' . ($ttdRow + 1), 'Ketua Tim Kerja Pelayanan Perizinan Berusaha');
                $sheet->getStyle('O' . ($ttdRow + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                // Tambahkan baris kosong untuk spacing
                $sheet->setCellValue('O' . ($ttdRow + 3), 'Ulvia Zulvia, ST');
                $sheet->getStyle('O' . ($ttdRow + 3))->getFont()->setBold(true);
                $sheet->getStyle('O' . ($ttdRow + 3))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->setCellValue('O' . ($ttdRow + 4), 'Penata Tk. 1');
                $sheet->getStyle('O' . ($ttdRow + 4))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
                $sheet->setCellValue('O' . ($ttdRow + 5), 'NIP: 197710132006042012');
                $sheet->getStyle('O' . ($ttdRow + 5))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            },
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $ttdSettings = TtdSetting::getSettings();
        
        // Add TTD photos if they exist - positioned under specific columns
        if ($ttdSettings->mengetahui_photo && file_exists(storage_path('app/public/ttd_photos/' . $ttdSettings->mengetahui_photo))) {
            $drawing = new Drawing();
            $drawing->setName('TTD Mengetahui');
            $drawing->setDescription('TTD Mengetahui');
            $drawing->setPath(storage_path('app/public/ttd_photos/' . $ttdSettings->mengetahui_photo));
            $drawing->setHeight(50);
            $drawing->setWidth(100);
            // Position under TANGGAL PERMOHONAN column (D)
            $drawing->setCoordinates('D' . ($this->collection()->count() + 8));
            $drawings[] = $drawing;
        }
        
        if ($ttdSettings->menyetujui_photo && file_exists(storage_path('app/public/ttd_photos/' . $ttdSettings->menyetujui_photo))) {
            $drawing = new Drawing();
            $drawing->setName('TTD Menyetujui');
            $drawing->setDescription('TTD Menyetujui');
            $drawing->setPath(storage_path('app/public/ttd_photos/' . $ttdSettings->menyetujui_photo));
            $drawing->setHeight(50);
            $drawing->setWidth(100);
            // Position under SKALA USAHA column (O)
            $drawing->setCoordinates('O' . ($this->collection()->count() + 8));
            $drawings[] = $drawing;
        }
        
        return $drawings;
    }
}
