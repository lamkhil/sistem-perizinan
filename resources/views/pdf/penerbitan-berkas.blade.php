<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penerbitan Berkas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 8px;
            margin: 0;
            padding: 10px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }
        
        .header h2 {
            font-size: 14px;
            font-weight: bold;
            margin: 5px 0;
        }
        
        .header p {
            font-size: 10px;
            margin: 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        th, td {
            border: 1px solid #000;
            padding: 2px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 7px;
        }
        
        td {
            font-size: 6px;
        }

        /* TTD Section Styling */
        .ttd-section {
            margin-top: 80px;
            page-break-inside: avoid;
            position: relative;
        }
        
        /* Grid 17 kolom mengikuti lebar header tabel */
        .ttd-grid {
            display: grid;
            grid-template-columns: 3% 8% 8% 7% 7% 5% 10% 8% 7% 8% 7% 12% 5% 8% 5% 5% 12%;
            column-gap: 0;
            margin-top: 12px;
            align-items: end;
            min-height: 120px;
        }
        
        /* TTD Kiri - diletakkan tepat di bawah kolom SKALA USAHA (kolom 15) */
        .ttd-left {
            grid-column: 15 / span 3; /* 15-17 */
            text-align: left;
        }
        
        .ttd-left-content {
            position: relative;
            width: 100%;
        }
        
        .ttd-left-title {
            font-size: 10px;
            margin-bottom: 0;
        }
        
        .ttd-left-spacing {
            height: 50px;
        }
        
        .ttd-left-name {
            font-size: 10px;
            margin-bottom: 5px;
        }
        
        .ttd-left-position {
            font-size: 9px;
            margin-bottom: 2px;
            line-height: 1.2;
        }
        
        .ttd-left-nip {
            font-size: 8px;
            margin-bottom: 0;
        }
        
        /* TTD Kanan - diletakkan tepat di bawah kolom TANGGAL PERMOHONAN (kolom 4) */
        .ttd-right {
            grid-column: 4 / span 5; /* 4-8 */
            text-align: right;
        }
        
        .ttd-right-content {
            position: relative;
            width: 100%;
        }
        
        .ttd-right-date {
            font-size: 10px;
            margin-bottom: 0;
        }
        
        .ttd-right-spacing {
            height: 50px;
        }
        
        .ttd-right-name {
            font-size: 10px;
            margin-bottom: 5px;
        }
        
        .ttd-right-position {
            font-size: 9px;
            margin-bottom: 2px;
            line-height: 1.2;
        }
        
        .ttd-right-nip {
            font-size: 8px;
            margin-bottom: 0;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .footer {
            margin-top: 40px;
            font-size: 8px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PERIZINAN BERUSAHA DISETUJUI</h1>
        <h2>DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</h2>
        <h2>KOTA SURABAYA TAHUN {{ date('Y') }}</h2>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">NO</th>
                <th style="width: 8%;">NO. PERMOHONAN</th>
                <th style="width: 8%;">NO. PROYEK</th>
                <th style="width: 7%;">TANGGAL PERMOHONAN</th>
                <th style="width: 7%;">NIB</th>
                <th style="width: 5%;">KBLI</th>
                <th style="width: 10%;">NAMA USAHA</th>
                <th style="width: 8%;">KEGIATAN</th>
                <th style="width: 7%;">JENIS PERUSAHAAN</th>
                <th style="width: 8%;">PEMILIK</th>
                <th style="width: 7%;">MODAL USAHA</th>
                <th style="width: 12%;">ALAMAT</th>
                <th style="width: 5%;">JENIS PROYEK</th>
                <th style="width: 8%;">NAMA PERIZINAN</th>
                <th style="width: 5%;">SKALA USAHA</th>
                <th style="width: 5%;">RISIKO</th>
                <th style="width: 12%;">PEMROSES DAN TGL. E SURAT DAN TGL PERTEK</th>
            </tr>
        </thead>
        <tbody>
            @foreach($penerbitanBerkas as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->no_permohonan ?? '-' }}</td>
                <td>{{ $item->no_proyek ?? '-' }}</td>
                <td>{{ $item->tanggal_permohonan ? \Carbon\Carbon::parse($item->tanggal_permohonan)->format('d/m/Y') : '-' }}</td>
                <td>{{ $item->nib ?? '-' }}</td>
                <td>{{ $item->kbli ?? '-' }}</td>
                <td>{{ $item->nama_usaha ?? '-' }}</td>
                <td>{{ $item->inputan_teks ?? '-' }}</td>
                <td>{{ $item->jenis_pelaku_usaha ?? '-' }}</td>
                <td>{{ $item->pemilik ?? '-' }}</td>
                <td>{{ $item->modal_usaha ? 'Rp ' . number_format($item->modal_usaha, 0, ',', '.') : '-' }}</td>
                <td>{{ $item->alamat_perusahaan ?? '-' }}</td>
                <td>{{ $item->jenis_proyek ?? '-' }}</td>
                <td>{{ $item->nama_perizinan ?? '-' }}</td>
                <td>{{ $item->skala_usaha ?? '-' }}</td>
                <td>{{ $item->risiko ?? '-' }}</td>
                <td>
                    @if($item->pemroses_dan_tgl_surat)
                        {{ $item->pemroses_dan_tgl_surat }}
                    @else
                        DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU<br>
                        No: BAP/OSS/IX/PARKIR-341/436.7.15/{{ date('Y') }}<br>
                        tanggal BAP: {{ date('d') }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TTD Section -->
    <div class="ttd-section">
        <!-- Susun TTD dengan grid 17 kolom agar sejajar dengan tabel -->
        <div class="ttd-grid">
            <!-- Blok kanan di bawah kolom 4 (Tanggal Permohonan) -->
            <div class="ttd-right">
                <div class="ttd-right-content">
                    <div class="ttd-right-date"><strong>Surabaya, {{ date('d F Y') }}</strong></div>
                    <div class="ttd-right-spacing"></div>
                    <div class="ttd-right-position">Ketua Tim Kerja Pelayanan Perizinan Berusaha</div>
                    <div class="ttd-right-spacing"></div>
                    <div class="ttd-right-name"><strong>Ulvia Zulvia, ST</strong></div>
                    <div class="ttd-right-position">Penata Tk. 1</div>
                    <div class="ttd-right-nip">NIP: 197710132006042012</div>
                </div>
            </div>

            <!-- Blok kiri di bawah kolom 15 (Skala Usaha) -->
            <div class="ttd-left">
                <div class="ttd-left-content">
                    <div class="ttd-left-title"><strong>Mengetahui</strong></div>
                    <div class="ttd-left-spacing"></div>
                    <div class="ttd-left-name"><strong>Yohanes Franklin, S.H.</strong></div>
                    <div class="ttd-left-position">Koordinator Ketua Tim Kerja</div>
                    <div class="ttd-left-position">Pelayanan Terpadu Satu Pintu</div>
                    <div class="ttd-left-nip">NIP: 198502182010011008</div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis pada {{ date('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
