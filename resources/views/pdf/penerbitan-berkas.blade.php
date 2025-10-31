<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penerbitan Berkas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 5px;
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
            padding: 3px;
            text-align: center;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
        
        /* Jangan ulangi judul tabel (thead) pada halaman berikutnya di DomPDF */
        thead { display: table-row-group; }
        tfoot { display: table-row-group; }
        
        
        th {
            background-color: transparent;
            font-weight: bold;
            font-size: 10px;
        }
        
        td {
            font-size: 9px;
        }

        /* TTD Section Styling */
        .ttd-section {
            margin-top: 20px;
            page-break-inside: avoid;
            position: relative;
        }
        
        /* TTD menggunakan tabel 17 kolom agar kompatibel DomPDF */
        .ttd-table {
            width: 100%;
            table-layout: fixed;
            border-collapse: collapse;
            margin-top: 12px;
        }
        .ttd-table td {
            border: none;
            font-size: 9px;
            vertical-align: bottom;
            padding: 0 2px;
        }
        
        .ttd-left { text-align: center; }
        
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
        
        .ttd-right { text-align: center; }
        
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
                    DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU<br>
                    No: {{ $item->nomor_bap ?? '-' }}<br>
                    tanggal BAP: {{ $item->tanggal_bap ? \Carbon\Carbon::parse($item->tanggal_bap)->locale('id')->translatedFormat('d F Y') : '-' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TTD Section -->
    <div class="ttd-section">
        <!-- Tabel 17 kolom dengan lebar mengikuti header -->
        <table class="ttd-table">
            <colgroup>
                <col style="width:3%">
                <col style="width:8%">
                <col style="width:8%">
                <col style="width:7%">
                <col style="width:7%">
                <col style="width:5%">
                <col style="width:10%">
                <col style="width:8%">
                <col style="width:7%">
                <col style="width:8%">
                <col style="width:7%">
                <col style="width:12%">
                <col style="width:5%">
                <col style="width:8%">
                <col style="width:5%">
                <col style="width:5%">
                <col style="width:12%">
            </colgroup>

            <!-- Baris 1: judul kiri dan tanggal kanan -->
            <tr>
                <td colspan="1"></td>
                <td colspan="3" class="ttd-left">
                    <div class="ttd-left-title">Mengetahui</div>
                </td>
                <td colspan="8"></td>
                <td colspan="5" class="ttd-right">
                    <div class="ttd-right-date">{{ $ttdSettings->menyetujui_lokasi ?? 'Surabaya' }}, {{ $ttdSettings->menyetujui_tanggal ? \Carbon\Carbon::parse($ttdSettings->menyetujui_tanggal)->format('d F Y') : date('d F Y') }}</div>
                </td>
            </tr>

            <!-- Baris 2: jabatan kiri dan jabatan kanan -->
            <tr>
                <td colspan="1"></td>
                <td colspan="3" class="ttd-left">
                    <div class="ttd-left-position">Koordinator Ketua Tim Kerja</div>
                </td>
                <td colspan="8"></td>
                <td colspan="5" class="ttd-right">
                    <div class="ttd-right-position">Ketua Tim Kerja Pelayanan Perizinan Berusaha</div>
                </td>
            </tr>

            <!-- Baris 3: unit kiri -->
            <tr>
                <td colspan="1"></td>
                <td colspan="3" class="ttd-left">
                    <div class="ttd-left-position">Pelayanan Terpadu Satu Pintu</div>
                </td>
                <td colspan="13"></td>
            </tr>

            <!-- Baris 4: ruang tanda tangan -->
            <tr>
                <td colspan="1"></td>
                <td colspan="3" class="ttd-left">
                    <div style="height:60px; display: flex; align-items: center; justify-content: center;">
                        @php
                            $mengetahuiFile = $ttdSettings->mengetahui_photo ?? null;
                            $mengetahuiBase64 = null;
                            if ($mengetahuiFile) {
                                // Coba path yang benar terlebih dahulu
                                $mengetahuiPath = storage_path('app/public/ttd_photos/' . $mengetahuiFile);
                                if (!file_exists($mengetahuiPath)) {
                                    // Fallback ke path lama jika ada
                                    $candidates = [
                                        public_path('storage/ttd_photos/' . $mengetahuiFile),
                                        public_path('storage/ttd-photos/' . $mengetahuiFile),
                                        storage_path('app/public/ttd-photos/' . $mengetahuiFile),
                                    ];
                                    foreach ($candidates as $c) {
                                        if ($c && file_exists($c)) { $mengetahuiPath = $c; break; }
                                    }
                                }
                                
                                // Convert ke base64 untuk DomPDF
                                if ($mengetahuiPath && file_exists($mengetahuiPath)) {
                                    $mengetahuiBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($mengetahuiPath));
                                }
                            }
                        @endphp
                        @if(!empty($mengetahuiBase64))
                            <img src="{{ $mengetahuiBase64 }}" alt="TTD Mengetahui" style="max-height: 50px; max-width: 100px; object-fit: contain;">
                        @endif
                    </div>
                </td>
                <td colspan="8"></td>
                <td colspan="5" class="ttd-right">
                    <div style="height:60px; display: flex; align-items: center; justify-content: center;">
                        @php
                            $menyetujuiFile = $ttdSettings->menyetujui_photo ?? null;
                            $menyetujuiBase64 = null;
                            if ($menyetujuiFile) {
                                // Coba path yang benar terlebih dahulu
                                $menyetujuiPath = storage_path('app/public/ttd_photos/' . $menyetujuiFile);
                                if (!file_exists($menyetujuiPath)) {
                                    // Fallback ke path lama jika ada
                                    $candidates = [
                                        public_path('storage/ttd_photos/' . $menyetujuiFile),
                                        public_path('storage/ttd-photos/' . $menyetujuiFile),
                                        storage_path('app/public/ttd-photos/' . $menyetujuiFile),
                                    ];
                                    foreach ($candidates as $c) {
                                        if ($c && file_exists($c)) { $menyetujuiPath = $c; break; }
                                    }
                                }
                                
                                // Convert ke base64 untuk DomPDF
                                if ($menyetujuiPath && file_exists($menyetujuiPath)) {
                                    $menyetujuiBase64 = 'data:image/jpeg;base64,' . base64_encode(file_get_contents($menyetujuiPath));
                                }
                            }
                        @endphp
                        @if(!empty($menyetujuiBase64))
                            <img src="{{ $menyetujuiBase64 }}" alt="TTD Menyetujui" style="max-height: 50px; max-width: 100px; object-fit: contain;">
                        @endif
                    </div>
                </td>
            </tr>

            <!-- Baris 5: nama kiri dan nama kanan -->
            <tr>
                <td colspan="1"></td>
                <td colspan="3" class="ttd-left">
                    <div class="ttd-left-name" style="text-decoration: underline;">{{ $ttdSettings->mengetahui_nama ?? 'Yohanes Franklin, S.H.' }}</div>
                </td>
                <td colspan="8"></td>
                <td colspan="5" class="ttd-right">
                    <div class="ttd-right-name" style="text-decoration: underline;">{{ $ttdSettings->menyetujui_nama ?? 'Ulvia Zulvia, ST' }}</div>
                </td>
            </tr>

            <!-- Baris 6: pangkat kiri dan pangkat kanan -->
            <tr>
                <td colspan="1"></td>
                <td colspan="3" class="ttd-left">
                    <div class="ttd-left-position">{{ $ttdSettings->mengetahui_pangkat ?? 'Penata Tk. 1' }}</div>
                </td>
                <td colspan="8"></td>
                <td colspan="5" class="ttd-right">
                    <div class="ttd-right-position">{{ $ttdSettings->menyetujui_pangkat ?? 'Penata Tk. 1' }}</div>
                </td>
            </tr>

            <!-- Baris 7: NIP kiri dan NIP kanan -->
            <tr>
                <td colspan="1"></td>
                <td colspan="3" class="ttd-left">
                    <div class="ttd-left-nip">NIP: {{ $ttdSettings->mengetahui_nip ?? '198502182010011008' }}</div>
                </td>
                <td colspan="8"></td>
                <td colspan="5" class="ttd-right">
                    <div class="ttd-right-nip">NIP: {{ $ttdSettings->menyetujui_nip ?? '197710132006042012' }}</div>
                </td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis pada {{ date('d F Y H:i:s') }}</p>
    </div>
</body>
</html>
