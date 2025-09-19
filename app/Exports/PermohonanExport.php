<?php

namespace App\Exports;

use App\Models\Permohonan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PermohonanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
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
            'No. Permohonan',
            'No. Proyek',
            'Tanggal Permohonan',
            'NIK',
            'Nama Usaha',
            'NIB',
            'Alamat Perusahaan',
            'Sektor',
            'Modal Usaha',
            'Jenis Proyek',
            'Verifikator',
            'Status',
            'Verifikasi PD Teknis',
            'Verifikasi Analisa',
            'KBLI',
            'Kegiatan',
            'Pengembalian',
            'Keterangan Pengembalian',
            'Menghubungi',
            'Keterangan Menghubungi',
            'Status Menghubungi',
            'Perbaikan',
            'Keterangan Perbaikan',
            'Terbit',
            'Keterangan Terbit',
            'Pemroses dan Tgl Surat',
            'Jenis Pelaku Usaha',
            'User',
            'Tanggal Dibuat',
            'Tanggal Diupdate'
        ];
    }

    /**
     * @param mixed $permohonan
     * @return array
     */
    public function map($permohonan): array
    {
        return [
            $permohonan->no_permohonan,
            $permohonan->no_proyek,
            $permohonan->tanggal_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->format('d/m/Y') : '',
            $permohonan->nik,
            $permohonan->nama_usaha,
            $permohonan->nib,
            $permohonan->alamat_perusahaan,
            $permohonan->sektor,
            $permohonan->modal_usaha ? 'Rp ' . number_format($permohonan->modal_usaha, 0, ',', '.') : '',
            $permohonan->jenis_proyek,
            $permohonan->verifikator,
            $permohonan->status,
            $permohonan->verifikasi_pd_teknis,
            $permohonan->verifikasi_dpmptsp,
            $permohonan->kbli,
            $permohonan->inputan_teks,
            $permohonan->pengembalian ? \Carbon\Carbon::parse($permohonan->pengembalian)->format('d/m/Y') : '',
            $permohonan->keterangan_pengembalian,
            $permohonan->menghubungi ? \Carbon\Carbon::parse($permohonan->menghubungi)->format('d/m/Y') : '',
            $permohonan->keterangan_menghubungi,
            $permohonan->status_menghubungi,
            $permohonan->perbaikan ? \Carbon\Carbon::parse($permohonan->perbaikan)->format('d/m/Y') : '',
            $permohonan->keterangan_perbaikan,
            $permohonan->terbit ? \Carbon\Carbon::parse($permohonan->terbit)->format('d/m/Y') : '',
            $permohonan->keterangan_terbit,
            $permohonan->pemroses_dan_tgl_surat,
            $permohonan->jenis_pelaku_usaha,
            $permohonan->user ? $permohonan->user->name : '',
            $permohonan->created_at ? \Carbon\Carbon::parse($permohonan->created_at)->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') : '',
            $permohonan->updated_at ? \Carbon\Carbon::parse($permohonan->updated_at)->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') : ''
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
            1    => ['font' => ['bold' => true]],
        ];
    }
}
