<?php

namespace App\Exports;

use App\Models\PenerbitanBerkas;
use App\Models\TtdSetting;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

class PenerbitanBerkasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithEvents, WithDrawings, WithColumnFormatting
{
    /**
     * Counter untuk kolom NO agar berurutan 1..n
     */
    private int $rowNumber = 0;
    public function collection()
    {
        return PenerbitanBerkas::with('user')->orderBy('created_at', 'asc')->get();
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

    public function map($row): array
    {
        // Format modal usaha dengan Rp
        $modalUsaha = $row->modal_usaha ? 'Rp' . number_format((float) $row->modal_usaha, 0, ',', '.') : '-';
        
        // Format tanggal permohonan
        $tanggalPermohonan = $row->tanggal_permohonan ? 
            \Carbon\Carbon::parse($row->tanggal_permohonan)->locale('id')->isoFormat('D MMMM Y') : '-';
        
        // Format pemroses dan tanggal (contoh format)
        $pemroses = 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU' . "\n" .
                   'No: BAP/OSS/IX/PARKIR-341/436.7.15/' . date('Y') . "\n" .
                   'tanggal BAP: ' . date('d');

        return [
            ++$this->rowNumber,
            $row->no_permohonan ?? '-',
            $row->no_proyek ?? '-',
            $tanggalPermohonan,
            $row->nib ?? '-',
            $row->kbli ?? '-',
            $row->nama_usaha ?? '-',
            $row->inputan_teks ?? '-',
            $row->jenis_perusahaan_display,
            $row->pemilik ?? '-',
            $modalUsaha,
            $row->alamat_perusahaan ?? '-',
            $row->jenis_proyek ?? '-',
            $row->nama_perizinan ?? '-',
            $row->skala_usaha ?? '-',
            $row->risiko ?? '-',
            $pemroses
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Styling header tabel akan diatur di AfterSheet (setelah kita menyisipkan judul di atas)
        return [];
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
            'G' => 20,  // NAMA USAHA (dipersempit dari 30)
            'H' => 20,  // KEGIATAN (dipersempit dari 30)
            'I' => 20,  // JENIS PERUSAHAAN
            'J' => 25,  // PEMILIK
            'K' => 20,  // MODAL USAHA
            'L' => 25,  // ALAMAT (dipersempit dari 40)
            'M' => 15,  // JENIS PROYEK (dipersempit dari 20)
            'N' => 30,  // NAMA PERIZINAN
            'O' => 12,  // SKALA USAHA (dipersempit dari 15)
            'P' => 15,  // RISIKO (dipersempit dari 20)
            'Q' => 50,  // PEMROSES DAN TGL. E SURAT DAN TGL PERTEK
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                
                // Sisipkan 4 baris di atas untuk judul
                $sheet->insertNewRowBefore(1, 4);
                
                // Tulis judul multi-baris
                $sheet->setCellValue('A1', 'PERIZINAN BERUSAHA DISETUJUI');
                $sheet->mergeCells('A1:Q1');
                $sheet->setCellValue('A2', 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU');
                $sheet->mergeCells('A2:Q2');
                $sheet->setCellValue('A3', 'KOTA SURABAYA');
                $sheet->mergeCells('A3:Q3');
                $sheet->setCellValue('A4', 'TAHUN ' . date('Y'));
                $sheet->mergeCells('A4:Q4');
                
                // Style judul
                $sheet->getStyle('A1:A4')->getFont()->setBold(true)->setSize(12);
                $sheet->getStyle('A1:A4')->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                
                // Sisipkan jarak 2 baris kosong antara judul dan tabel
                $sheet->insertNewRowBefore(5, 2);
                
                // Hitung ulang lastRow setelah penyisipan baris
                $lastRow = $sheet->getHighestRow();
                
                // Baris header tabel sekarang ada di baris 7 (setelah 2 baris jarak)
                $headerRow = 7;
                
                // Set text wrapping hanya untuk area tabel (mulai header)
                $sheet->getStyle('A' . $headerRow . ':Q' . $lastRow)->getAlignment()->setWrapText(true);
                
                // Set row height (lebih tinggi agar teks tidak tertutup)
                $sheet->getDefaultRowDimension()->setRowHeight(24);
                
                // Add borders untuk area tabel saja
                $sheet->getStyle('A' . $headerRow . ':Q' . $lastRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
                
                // Center align all data di area tabel
                $sheet->getStyle('A' . ($headerRow + 1) . ':Q' . $lastRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('A' . ($headerRow + 1) . ':Q' . $lastRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                // Styling header tabel (baris 5) polos dan bold
                $sheet->getStyle('A' . $headerRow . ':Q' . $headerRow)->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => '000000'],
                    ],
                    // tanpa fill (warna polos)
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                // Perbesar tinggi baris header
                $sheet->getRowDimension($headerRow)->setRowHeight(28);
                
                // Set NIB column (E) as text format to prevent scientific notation
                for ($row = $headerRow + 1; $row <= $lastRow; $row++) {
                    $cellValue = $sheet->getCell('E' . $row)->getValue();
                    if ($cellValue && $cellValue !== '-') {
                        $sheet->setCellValueExplicit('E' . $row, $cellValue, DataType::TYPE_STRING);
                    }
                }
                
                // Add TTD section after data - POSITIONED UNDER SPECIFIC COLUMNS
                $ttdRow = $lastRow + 3;
                
                // TTD Mengetahui (kiri) - di bawah kolom TANGGAL PERMOHONAN (kolom D)
                $sheet->setCellValue('D' . $ttdRow, 'Mengetahui');
                $sheet->getStyle('D' . $ttdRow)->getFont()->setBold(true);
                $sheet->getStyle('D' . $ttdRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D' . $ttdRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->setCellValue('D' . ($ttdRow + 1), 'Koordinator Ketua Tim Kerja');
                $sheet->getStyle('D' . ($ttdRow + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D' . ($ttdRow + 1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->setCellValue('D' . ($ttdRow + 2), 'Pelayanan Terpadu Satu Pintu');
                $sheet->getStyle('D' . ($ttdRow + 2))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D' . ($ttdRow + 2))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                // Tambahkan 4 baris kosong untuk spacing (ttdRow+3, +4, +5, +6)
                $sheet->setCellValue('D' . ($ttdRow + 7), 'Yohanes Franklin, S.H.');
                $sheet->getStyle('D' . ($ttdRow + 7))->getFont()->setBold(true);
                $sheet->getStyle('D' . ($ttdRow + 7))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D' . ($ttdRow + 7))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->setCellValue('D' . ($ttdRow + 8), 'Penata Tk.1');
                $sheet->getStyle('D' . ($ttdRow + 8))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D' . ($ttdRow + 8))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->setCellValue('D' . ($ttdRow + 9), 'NIP: 198502182010011008');
                $sheet->getStyle('D' . ($ttdRow + 9))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('D' . ($ttdRow + 9))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                
                // TTD Menyetujui (kanan) - di bawah kolom SKALA USAHA (kolom O)
                $sheet->setCellValue('O' . $ttdRow, 'Surabaya, ' . date('d F Y'));
                $sheet->getStyle('O' . $ttdRow)->getFont()->setBold(true);
                $sheet->getStyle('O' . $ttdRow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('O' . $ttdRow)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->setCellValue('O' . ($ttdRow + 1), 'Ketua Tim Kerja Pelayanan Perizinan Berusaha');
                $sheet->getStyle('O' . ($ttdRow + 1))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('O' . ($ttdRow + 1))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                // Tambahkan 3 baris kosong untuk spacing (kurangi 1 baris di sisi kanan)
                $sheet->setCellValue('O' . ($ttdRow + 6), 'Ulvia Zulvia, ST');
                $sheet->getStyle('O' . ($ttdRow + 6))->getFont()->setBold(true);
                $sheet->getStyle('O' . ($ttdRow + 6))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('O' . ($ttdRow + 6))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->setCellValue('O' . ($ttdRow + 7), 'Penata Tk. 1');
                $sheet->getStyle('O' . ($ttdRow + 7))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('O' . ($ttdRow + 7))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $sheet->setCellValue('O' . ($ttdRow + 8), 'NIP: 197710132006042012');
                $sheet->getStyle('O' . ($ttdRow + 8))->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle('O' . ($ttdRow + 8))->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            },
        ];
    }

    public function drawings()
    {
        $drawings = [];
        $ttdSettings = TtdSetting::getSettings();
        
        // Add TTD photos if they exist - positioned under specific columns
        if ($ttdSettings->mengetahui_photo) {
            $file = $ttdSettings->mengetahui_photo;
            $pathUnderscore = storage_path('app/public/ttd_photos/' . $file);
            $pathDash = storage_path('app/public/ttd-photos/' . $file);
            $path = file_exists($pathUnderscore) ? $pathUnderscore : (file_exists($pathDash) ? $pathDash : null);
        
            if ($path) {
            $drawing = new Drawing();
            $drawing->setName('TTD Mengetahui');
            $drawing->setDescription('TTD Mengetahui');
            $drawing->setPath($path);
            $drawing->setHeight(50);
            $drawing->setWidth(100);
            // Position under TANGGAL PERMOHONAN column (D)
            $drawing->setCoordinates('D' . ($this->collection()->count() + 9));
            $drawings[] = $drawing;
            }
        }
        
        if ($ttdSettings->menyetujui_photo) {
            $file = $ttdSettings->menyetujui_photo;
            $pathUnderscore = storage_path('app/public/ttd_photos/' . $file);
            $pathDash = storage_path('app/public/ttd-photos/' . $file);
            $path = file_exists($pathUnderscore) ? $pathUnderscore : (file_exists($pathDash) ? $pathDash : null);
            if ($path) {
            $drawing = new Drawing();
            $drawing->setName('TTD Menyetujui');
            $drawing->setDescription('TTD Menyetujui');
            $drawing->setPath($path);
            $drawing->setHeight(50);
            $drawing->setWidth(100);
            // Position under SKALA USAHA column (O)
            $drawing->setCoordinates('O' . ($this->collection()->count() + 8));
            $drawings[] = $drawing;
            }
        }
        
        return $drawings;
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_TEXT, // NIB column as text
        ];
    }
}
