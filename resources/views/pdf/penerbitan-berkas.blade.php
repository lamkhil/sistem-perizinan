<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penerbitan Berkas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 20px;
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
            padding: 4px;
            text-align: left;
            vertical-align: top;
        }
        
        th {
            background-color: #f0f0f0;
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
        
        .ttd-header {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .ttd-header h3 {
            font-size: 12px;
            font-weight: bold;
            margin: 0;
        }
        
        .ttd-line {
            border-top: 1px solid #000;
            margin: 20px 0;
        }
        
        .ttd-content {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        
        .ttd-left, .ttd-right {
            width: 45%;
        }
        
        .ttd-left {
            text-align: left;
        }
        
        .ttd-right {
            text-align: right;
        }
        
        .ttd-name {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .ttd-title {
            font-size: 9px;
            margin-bottom: 3px;
        }
        
        .ttd-nip {
            font-size: 8px;
        }
        
        .ttd-date {
            font-size: 9px;
            margin-bottom: 10px;
        }
        
        .ttd-position {
            font-size: 9px;
            margin-bottom: 5px;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .footer {
            margin-top: 20px;
            font-size: 8px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>PERIZINAN BERUSAHA DISETUJUI</h1>
        <h2>DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</h2>
        <h2>KOTA SURABAYA TAHUN {{ date('Y') }}</h2>
        <p>Data Penerbitan Berkas - {{ date('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">NO</th>
                <th style="width: 12%;">NO. PERMOHONAN</th>
                <th style="width: 12%;">NO. PROYEK</th>
                <th style="width: 8%;">TANGGAL PERMOHONAN</th>
                <th style="width: 10%;">NIB</th>
                <th style="width: 8%;">KBLI</th>
                <th style="width: 15%;">NAMA USAHA</th>
                <th style="width: 12%;">KEGIATAN</th>
                <th style="width: 8%;">JENIS PERUSAHAAN</th>
                <th style="width: 12%;">PEMILIK</th>
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
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd-section">
        <div class="ttd-header">
            <h3>Mengetahui</h3>
            <h3>Koordinator Ketua Tim Kerja</h3>
            <h3>Pelayanan Terpadu Satu Pintu</h3>
        </div>
        
        <div class="ttd-line"></div>
        
        <div class="ttd-content">
            <div class="ttd-left">
                <div class="ttd-name">Yohanes Franklin, S.H.</div>
                <div class="ttd-title">Penata Tk.1</div>
                <div class="ttd-nip">NIP: 198502182010011008</div>
            </div>
            
            <div class="ttd-right">
                <div class="ttd-date">Surabaya, {{ date('d F Y') }}</div>
                <div class="ttd-position">Ketua Tim Kerja Pelayanan Perizinan Berusaha</div>
                <div class="ttd-name">Ulvia Zulvia, ST</div>
                <div class="ttd-title">Penata Tk. 1</div>
                <div class="ttd-nip">NIP: 197710132006042012</div>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis pada {{ date('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
