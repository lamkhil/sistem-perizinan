<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Permohonan - Penerbitan Berkas</title>
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
            font-weight: bold;
            font-size: 9px;
        }
        td {
            font-size: 8px;
        }
        .ttd-section {
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .ttd-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .ttd-item {
            text-align: center;
            width: 45%;
        }
        .ttd-line {
            border-bottom: 1px solid #333;
            height: 60px;
            margin: 10px 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .ttd-photo {
            max-width: 100px;
            max-height: 50px;
            object-fit: contain;
        }
        .ttd-text {
            font-size: 10px;
            margin: 2px 0;
        }
        .ttd-name {
            font-weight: bold;
            margin-top: 10px;
        }
        .ttd-nip {
            font-size: 9px;
            color: #666;
        }
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PERIZINAN BERUSAHA DISETUJUI</h1>
        <p>DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</p>
        <p>KOTA SURABAYA TAHUN {{ date('Y') }}</p>
    </div>

    @if($permohonans->count() > 0)
        <table>
            <thead>
                <tr>
                    <th style="width: 3%;">NO</th>
                    <th style="width: 12%;">NO. PERMOHONAN</th>
                    <th style="width: 12%;">NO. PROYEK</th>
                    <th style="width: 10%;">TANGGAL PERMOHONAN</th>
                    <th style="width: 8%;">NIB</th>
                    <th style="width: 6%;">KBLI</th>
                    <th style="width: 12%;">NAMA USAHA</th>
                    <th style="width: 12%;">KEGIATAN</th>
                    <th style="width: 8%;">JENIS PERUSAHAAN</th>
                    <th style="width: 10%;">PEMILIK</th>
                    <th style="width: 8%;">MODAL USAHA</th>
                    <th style="width: 12%;">ALAMAT</th>
                    <th style="width: 6%;">JENIS PROYEK</th>
                    <th style="width: 12%;">NAMA PERIZINAN</th>
                    <th style="width: 8%;">SKALA USAHA</th>
                    <th style="width: 8%;">RISIKO</th>
                    <th style="width: 15%;">PEMROSES DAN TGL. E SURAT DAN TGL PERTEK</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permohonans as $index => $permohonan)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $permohonan->no_permohonan ?? '-' }}</td>
                    <td>{{ $permohonan->no_proyek ?? '-' }}</td>
                    <td>{{ $permohonan->tanggal_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->locale('id')->isoFormat('D MMMM Y') : '-' }}</td>
                    <td>{{ $permohonan->nib ?? '-' }}</td>
                    <td>{{ $permohonan->kbli ?? '-' }}</td>
                    <td>{{ $permohonan->nama_usaha ?? '-' }}</td>
                    <td>{{ $permohonan->inputan_teks ?? '-' }}</td>
                    <td>{{ $permohonan->jenis_pelaku_usaha ?? '-' }}</td>
                    <td>{{ $permohonan->pemilik ?? '-' }}</td>
                    <td>{{ $permohonan->modal_usaha ? 'Rp ' . number_format($permohonan->modal_usaha, 0, ',', '.') : '-' }}</td>
                    <td>{{ $permohonan->alamat_perusahaan ?? '-' }}</td>
                    <td>{{ $permohonan->jenis_proyek ?? '-' }}</td>
                    <td>{{ $permohonan->nama_perizinan ?? '-' }}</td>
                    <td>{{ $permohonan->skala_usaha ?? '-' }}</td>
                    <td>{{ $permohonan->risiko ?? '-' }}</td>
                    <td>
                        DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU<br>
                        No: BAP/OSS/IX/{{ $permohonan->no_permohonan ?? 'N/A' }}/436.7.15/{{ date('Y') }}<br>
                        tanggal BAP: {{ date('d F Y') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>Tidak ada data permohonan yang tersedia.</p>
        </div>
    @endif

    <!-- TTD Section - SIDE BY SIDE LAYOUT -->
    <div class="ttd-section">
        <div class="ttd-container">
            <!-- Mengetahui (kiri) -->
            <div class="ttd-item" style="text-align: left;">
                <div class="ttd-text" style="font-weight: bold; text-align: center;">Mengetahui</div>
                <div class="ttd-text" style="text-align: center;">Koordinator Ketua Tim Kerja</div>
                <div class="ttd-text" style="text-align: center;">Pelayanan Terpadu Satu Pintu</div>
                <div class="ttd-line" style="margin: 15px 0;">
                    @if($ttdSettings->mengetahui_photo)
                        <img src="{{ public_path('storage/ttd_photos/' . $ttdSettings->mengetahui_photo) }}" alt="TTD Mengetahui" class="ttd-photo">
                    @endif
                </div>
                <div class="ttd-name" style="text-align: left;">{{ $ttdSettings->mengetahui_nama }}</div>
                <div class="ttd-text" style="text-align: left;">{{ $ttdSettings->mengetahui_pangkat }}</div>
                <div class="ttd-nip" style="text-align: left;">NIP: {{ $ttdSettings->mengetahui_nip }}</div>
            </div>

            <!-- Menyetujui (kanan) -->
            <div class="ttd-item" style="text-align: right;">
                <div class="ttd-text" style="font-weight: bold; text-align: right;">{{ $menyetujuiTitle }}</div>
                <div class="ttd-text" style="text-align: right;">Ketua Tim Kerja Pelayanan Perizinan Berusaha</div>
                <div class="ttd-line" style="margin: 15px 0;">
                    @if($ttdSettings->menyetujui_photo)
                        <img src="{{ public_path('storage/ttd_photos/' . $ttdSettings->menyetujui_photo) }}" alt="TTD Menyetujui" class="ttd-photo">
                    @endif
                </div>
                <div class="ttd-name" style="text-align: right;">{{ $ttdSettings->menyetujui_nama }}</div>
                <div class="ttd-text" style="text-align: right;">{{ $ttdSettings->menyetujui_pangkat }}</div>
                <div class="ttd-nip" style="text-align: right;">NIP: {{ $ttdSettings->menyetujui_nip }}</div>
            </div>
        </div>
    </div>
</body>
</html>
