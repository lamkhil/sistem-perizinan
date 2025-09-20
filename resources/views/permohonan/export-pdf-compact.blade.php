<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Permohonan - Ringkasan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 15px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }
        .header h1 {
            margin: 0;
            font-size: 16px;
            color: #333;
        }
        .header p {
            margin: 3px 0 0 0;
            font-size: 10px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f5f5f5;
            font-weight: bold;
            font-size: 8px;
        }
        td {
            font-size: 7px;
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
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 7px;
            color: #666;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DATA PERMOHONAN PERIZINAN - RINGKASAN</h1>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') }}</p>
        <p>Total Data: {{ $permohonans->count() }} permohonan</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 8%;">No. Permohonan</th>
                <th style="width: 8%;">No. Proyek</th>
                <th style="width: 6%;">Tanggal</th>
                <th style="width: 12%;">Nama Usaha</th>
                <th style="width: 8%;">Sektor</th>
                <th style="width: 8%;">KBLI</th>
                <th style="width: 8%;">Modal</th>
                <th style="width: 6%;">Status</th>
                <th style="width: 8%;">Verifikasi PD</th>
                <th style="width: 8%;">Verifikasi Analisa</th>
                <th style="width: 6%;">Pengembalian</th>
                <th style="width: 6%;">Terbit</th>
                <th style="width: 8%;">Verifikator</th>
            </tr>
        </thead>
        <tbody>
            @forelse($permohonans as $index => $permohonan)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->no_permohonan ?? '', 15) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->no_proyek ?? '', 15) }}</td>
                <td>{{ $permohonan->tanggal_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->format('d/m/Y') : '-' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->nama_usaha ?? '', 20) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->sektor ?? '', 12) }}</td>
                <td>{{ $permohonan->kbli ?? '-' }}</td>
                <td>{{ $permohonan->modal_usaha ? 'Rp ' . number_format($permohonan->modal_usaha, 0, ',', '.') : '-' }}</td>
                <td>
                    @if($permohonan->status == 'Diterima')
                        <span class="status-diterima">{{ $permohonan->status }}</span>
                    @elseif($permohonan->status == 'Dikembalikan')
                        <span class="status-dikembalikan">{{ $permohonan->status }}</span>
                    @elseif($permohonan->status == 'Ditolak')
                        <span class="status-ditolak">{{ $permohonan->status }}</span>
                    @else
                        <span>{{ $permohonan->status }}</span>
                    @endif
                </td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->verifikasi_pd_teknis ?? '', 10) }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->verifikasi_dpmptsp ?? '', 10) }}</td>
                <td>{{ $permohonan->pengembalian ? \Carbon\Carbon::parse($permohonan->pengembalian)->format('d/m/Y') : '-' }}</td>
                <td>{{ $permohonan->terbit ? \Carbon\Carbon::parse($permohonan->terbit)->format('d/m/Y') : '-' }}</td>
                <td>{{ \Illuminate\Support\Str::limit($permohonan->verifikator ?? '', 10) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="14" style="text-align: center; padding: 15px;">Tidak ada data permohonan</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Sistem Perizinan</p>
    </div>
</body>
</html>
