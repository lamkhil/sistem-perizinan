<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Permohonan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f5f5f5;
            font-weight: normal;
            font-size: 9px;
            padding: 10px 6px;
        }
        td {
            font-size: 8px;
        }
        .status-diterima {
            color: #059669;
            font-weight: bold;
        }
        .status-dikembalikan {
            color: #d97706;
            font-weight: bold;
        }
        .status-ditolak {
            color: #dc2626;
            font-weight: bold;
        }
        .status-menunggu {
            color: #6b7280;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 8px;
            color: #666;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DATA PERMOHONAN PERIZINAN</h1>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d/m/Y H:i') }}</p>
        <p>Total Data: {{ $permohonans->count() }} permohonan</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 2%;">No</th>
                <th style="width: 4%;">SEKTOR</th>
                <th style="width: 4%;">WAKTU</th>
                <th style="width: 6%;">NO. PERMOHONAN (PD TEKNIS)</th>
                <th style="width: 6%;">NO. PROYEK (PD TEKNIS)</th>
                <th style="width: 5%;">TANGGAL PERMOHONAN (PD TEKNIS)</th>
                <th style="width: 4%;">NIB (PD TEKNIS)</th>
                <th style="width: 4%;">KBU (PD TEKNIS)</th>
                <th style="width: 6%;">KEGIATAN (PD TEKNIS)</th>
                <th style="width: 5%;">JENIS PERUSAHAAN (PD TEKNIS)</th>
                <th style="width: 6%;">NAMA PERUSAHAAN (PD TEKNIS)</th>
                <th style="width: 6%;">NAMA USAHA (DPM)</th>
                <th style="width: 8%;">ALAMAT PERUSAHAAN (DPM)</th>
                <th style="width: 5%;">MODAL USAHA (DPM)</th>
                <th style="width: 5%;">JENIS PROYEK (DPM)</th>
                <th style="width: 5%;">VERIFIKASI OLEH PD TEKNIS</th>
                <th style="width: 5%;">VERIFIKASI OLEH DPMPTSP</th>
                <th style="width: 5%;">PENGEMBALIAN (TANGGAL)</th>
                <th style="width: 8%;">KETERANGAN PENGEMBALIAN</th>
                <th style="width: 5%;">MENGHUBUNGI (TANGGAL)</th>
                <th style="width: 8%;">KETERANGAN MENGHUBUNGI</th>
                <th style="width: 5%;">APPROVED (TANGGAL)</th>
                <th style="width: 8%;">KETERANGAN DISETUJUI</th>
                <th style="width: 5%;">TERBIT (TANGGAL)</th>
                <th style="width: 8%;">KETERANGAN TERBIT</th>
                <th style="width: 6%;">PEMROSES DAN TGL E SURAT DAN TGL PERTEK</th>
                <th style="width: 4%;">VERIFIKATOR</th>
                <th style="width: 4%;">KETERANGAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permohonans as $index => $permohonan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $permohonan->sektor ?? '-' }}</td>
                <td>{{ $permohonan->created_at ? \Carbon\Carbon::parse($permohonan->created_at)->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d/m/Y H:i') : '-' }}</td>
                <td>{{ $permohonan->no_permohonan ?? '-' }}</td>
                <td>{{ $permohonan->no_proyek ?? '-' }}</td>
                <td>{{ $permohonan->tanggal_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->locale('id')->translatedFormat('d/m/Y') : '-' }}</td>
                <td>{{ $permohonan->nib ?? '-' }}</td>
                <td>{{ $permohonan->kbli ?? '-' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->inputan_teks ?? '', 15) }}</td>
                <td>{{ $permohonan->jenis_perusahaan_display }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->nama_perusahaan ?? '', 15) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->nama_usaha ?? '', 15) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->alamat_perusahaan ?? '', 20) }}</td>
                <td>{{ $permohonan->modal_usaha ? 'Rp ' . number_format($permohonan->modal_usaha, 0, ',', '.') : '-' }}</td>
                <td>{{ $permohonan->jenis_proyek ?? '-' }}</td>
                <td>{{ $permohonan->verifikasi_pd_teknis ?? '-' }}</td>
                <td>{{ $permohonan->verifikasi_dpmptsp ?? '-' }}</td>
                <td>{{ $permohonan->pengembalian ? \Carbon\Carbon::parse($permohonan->pengembalian)->locale('id')->translatedFormat('d/m/Y') : '-' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->keterangan_pengembalian ?? '', 15) }}</td>
                <td>{{ $permohonan->menghubungi ? \Carbon\Carbon::parse($permohonan->menghubungi)->locale('id')->translatedFormat('d/m/Y') : '-' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->keterangan_menghubungi ?? '', 15) }}</td>
                <td>{{ $permohonan->perbaikan ? \Carbon\Carbon::parse($permohonan->perbaikan)->locale('id')->translatedFormat('d/m/Y') : '-' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->keterangan_disetujui ?? '', 15) }}</td>
                <td>{{ $permohonan->terbit ? \Carbon\Carbon::parse($permohonan->terbit)->locale('id')->translatedFormat('d/m/Y') : '-' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->keterangan_terbit ?? '', 15) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->pemroses_dan_tgl_surat ?? '', 15) }}</td>
                <td>{{ $permohonan->verifikator ?? '-' }}</td>
                <td>
                    @if($permohonan->status == 'Diterima')
                        <span class="status-diterima">{{ $permohonan->status }}</span>
                    @elseif($permohonan->status == 'Dikembalikan')
                        <span class="status-dikembalikan">{{ $permohonan->status }}</span>
                    @elseif($permohonan->status == 'Ditolak')
                        <span class="status-ditolak">{{ $permohonan->status }}</span>
                    @else
                        <span class="status-menunggu">{{ $permohonan->status }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="30" style="text-align: center; padding: 20px;">Tidak ada data permohonan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Sistem Perizinan</p>
    </div>
</body>
</html>
