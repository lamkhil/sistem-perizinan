<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Berita Acara Pemeriksaan</title>
    <style>
        @page {
            margin-top: 10mm;
            margin-bottom: 20mm;
            margin-left: 10mm;
            margin-right: 10mm;
            size: A4;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            font-size: 11pt;
            line-height: 1.6;
            color: #000;
            margin: 0;
            padding: 0;
        }
        
        .doc-header-wrapper {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }
        
        .doc-header {
            display: table-row;
        }
        
        .doc-logo-container {
            display: table-cell;
            vertical-align: top;
            width: 150px;
            padding-right: 20px;
        }
        
        .doc-logo {
            width: auto;
            height: auto;
            background: transparent;
            display: inline-block;
            text-align: center;
        }
        
        .doc-logo img {
            width: auto;
            height: auto;
            max-width: 130px;
            max-height: 130px;
            object-fit: contain;
        }
        
        .doc-header-text {
            display: table-cell;
            vertical-align: top;
            text-align: center;
        }
        
        .doc-header-text h1 {
            font-size: 12pt;
            font-weight: bold;
            margin: 0 0 2px 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .doc-header-text h2 {
            font-size: 12pt;
            font-weight: bold;
            margin: 0 0 2px 0;
            text-transform: uppercase;
        }
        
        .doc-address {
            font-size: 11pt;
            margin: 1px 0;
            font-weight: bold;
        }
        
        .doc-contact {
            font-size: 11pt;
            margin: 1px 0 8px 0;
            text-decoration: underline;
            font-weight: bold;
        }
        
        .doc-header-separator {
            display: block;
            width: auto;
            margin-left: 170px;
            margin-right: 0;
            border-bottom: 1px solid #ffffff;
            margin-top: 5px;
            margin-bottom: 15px;
        }
        
        .doc-title {
            text-align: center;
            font-size: 14pt;
            font-weight: bold;
            margin: 5px auto 12px auto;
            text-transform: uppercase;
            width: 100%;
            display: block;
            text-decoration: underline;
        }
        
        .doc-title-number {
            font-size: 11pt;
            font-weight: normal;
            margin-top: 5px;
            text-decoration: none;
        }
        
        .doc-intro {
            text-align: justify;
            margin: 15px 0;
            text-indent: 0;
            font-size: 11pt;
            line-height: 1.8;
        }
        
        .doc-intro strong {
            font-weight: bold;
        }
        
        .doc-table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
            font-size: 11pt;
        }
        
        .doc-table th,
        .doc-table td {
            border: none;
            padding: 6px;
            text-align: left;
            background: transparent;
        }
        
        .doc-table th {
            background: transparent;
            font-weight: bold;
            text-align: center;
            font-size: 11pt;
            color: #000000;
        }
        
        .doc-table td {
            vertical-align: top;
            font-size: 11pt;
            background: transparent;
        }
        
        /* Tabel persyaratan dengan background warna */
        .doc-table-persyaratan {
            border: 1px solid #D1D5DB;
        }
        
        .doc-table-persyaratan thead tr {
            background-color: #F9FAFB;
        }
        
        .doc-table-persyaratan thead th {
            background-color: #F9FAFB;
            border: 1px solid #D1D5DB;
            padding: 8px;
        }
        
        .doc-table-persyaratan tbody td {
            border: 1px solid #D1D5DB;
            padding: 8px;
            background-color: #FFFFFF;
        }
        
        .doc-table-persyaratan tbody tr:nth-child(even) {
            background-color: #F9FAFB;
        }
        
        .doc-table-persyaratan tbody tr:nth-child(even) td {
            background-color: #F9FAFB;
        }
        
        .doc-table .text-center {
            text-align: center;
        }
        
        .doc-table .no-col {
            width: 5%;
            text-align: center;
        }
        
        .doc-table .nama-col {
            width: 60%;
        }
        
        .doc-table .checkbox-col {
            width: 17.5%;
            text-align: center;
        }
        
        .checkbox {
            width: 18px;
            height: 18px;
            border: 2px solid #ffffff;
            display: inline-block;
            margin: 0 auto;
            position: relative;
            background-color: #fff;
            text-align: center;
            line-height: 18px;
            vertical-align: middle;
        }
        
        .checkbox.checked {
            background-color: #000;
            color: #fff;
        }
        
        .checkbox-checkmark {
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            display: inline-block;
            line-height: 18px;
            vertical-align: middle;
        }
        
        .sub-item {
            margin-left: 15px;
            margin-top: 4px;
            font-size: 10pt;
            line-height: 1.4;
        }
        
        .sub-item div {
            margin-bottom: 2px;
        }
        
        .doc-section {
            margin-bottom: 15px;
        }
        
        .doc-section-title {
            font-size: 11pt;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
        
        .doc-field {
            margin-bottom: 8px;
            position: relative;
            width: 100%;
            display: block;
        }
        
        .doc-field-label {
            font-weight: bold;
            display: inline-block;
            min-width: 200px;
            padding-right: 5px;
            vertical-align: top;
        }
        
        .doc-field-value {
            display: inline-block;
            min-width: 300px;
            padding-left: 5px;
            vertical-align: top;
        }
        
        
        .doc-paragraph {
            text-align: left;
            margin: 10px 0;
            text-indent: 0;
            font-size: 11pt;
            line-height: 1.8;
        }
        
        .doc-paragraph.no-indent {
            text-indent: 0;
            text-align: left;
        }
        
        .doc-catatan-box {
            border: 1px solid #ffffff;
            padding: 10px;
            margin: 10px 0;
            min-height: 50px;
        }
        
        .doc-catatan-box p {
            text-indent: 0;
            margin: 0;
            font-size: 11pt;
        }
        
        .doc-signature {
            width: 100%;
            margin-top: 50px;
        }
        
        .doc-signature-row {
            display: table;
            width: 100%;
            margin-bottom: 0;
        }
        
        .doc-signature-item {
            display: table-cell;
            text-align: center;
            vertical-align: top;
        }
        
        .doc-signature-item.left {
            width: 50%;
            text-align: center;
        }
        
        .doc-signature-item.right {
            width: 50%;
            text-align: center;
        }
        
        .doc-signature-item.center {
            width: 100%;
            text-align: center;
            margin-top: 30px;
        }
        
        .doc-signature-line {
            width: 250px;
            margin: 0 auto;
            padding: 0;
            text-align: center;
        }
        
        .doc-signature-line p {
            margin: 3px 0;
            font-size: 10pt;
        }
        
        .doc-signature-line .ttd-label {
            margin: 8px 0 5px 0;
            font-size: 10pt;
            font-weight: normal;
        }
        
        .doc-signature-line .nama-label {
            margin: 10px 0 3px 0;
            font-size: 10pt;
            font-weight: normal;
        }
        
        .doc-signature-img {
            max-width: 250px;
            max-height: 80px;
            margin: 15px auto 10px auto;
            display: block;
            object-fit: contain;
            width: auto;
            height: auto;
        }
        
        .doc-signature-item.left .doc-signature-img,
        .doc-signature-item.right .doc-signature-img {
            margin-left: auto;
            margin-right: auto;
        }
        
        .doc-signature-name {
            margin-top: 5px;
            font-weight: bold;
            font-size: 11pt;
        }
    </style>
</head>
<body>
    <!-- Document Header -->
    <div class="doc-header-wrapper">
        <div class="doc-header">
            <div class="doc-logo-container">
                @php
                    $logoPath = public_path('images/BAP.jpg');
                    $logoExists = false;
                    $logoSrc = null;
                    
                    if (file_exists($logoPath)) {
                        $logoExists = true;
                        try {
                            $logoData = base64_encode(file_get_contents($logoPath));
                            $imageInfo = getimagesize($logoPath);
                            $mimeType = $imageInfo ? $imageInfo['mime'] : 'image/jpeg';
                            $logoSrc = 'data:' . $mimeType . ';base64,' . $logoData;
                        } catch (Exception $e) {
                            $logoExists = false;
                        }
                    }
                @endphp
                @if($logoExists && $logoSrc)
                    <div class="doc-logo" style="background: transparent;">
                        <img src="{{ $logoSrc }}" alt="Logo" style="max-width: 130px; max-height: 130px; width: auto; height: auto; object-fit: contain; background: transparent;">
                    </div>
                @else
                    <div class="doc-logo" style="background: transparent; color: #000; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 24pt; border: 1px solid #ffffff; width: 130px; height: 130px;">S</div>
                @endif
            </div>
            <div class="doc-header-text">
                <h1>PEMERINTAH KOTA SURABAYA</h1>
                <h2>DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</h2>
                <div class="doc-address" style="margin-top: 1px; font-weight: bold;">Gedung Siola Lt. 3 Jalan Tunjungan No.1-3 Surabaya (60275)</div>
                <div class="doc-contact" style="margin-top: 1px; font-weight: bold; text-decoration: underline;">Tlp. 031-99001785 Fax. 031-99001785</div>
            </div>
        </div>
    </div>
    
    <div class="doc-header-separator"></div>
    
    <!-- Document Title -->
    <div class="doc-title">BERITA ACARA PEMERIKSAAN</div>
    <div class="doc-title-number" style="text-align: center; margin-top: 5px;">
        <strong>Nomor:</strong> {{ $data['nomor_bap'] ?? 'N/A' }}
    </div>
    
    <!-- Introductory Paragraph -->
    <p class="doc-paragraph no-indent">
        @php
            $tanggalPemeriksaan = null;
            if (isset($data['tanggal_pemeriksaan'])) {
                try {
                    $tanggalPemeriksaan = \Carbon\Carbon::parse($data['tanggal_pemeriksaan'])->locale('id')->translatedFormat('l, d F Y');
                } catch (\Exception $e) {
                    $tanggalPemeriksaan = $data['tanggal_pemeriksaan'];
                }
            }
            
            $namaUsaha = $permohonan->nama_usaha ?? 'N/A';
            $alamatUsaha = $permohonan->alamat_perusahaan ?? 'N/A';
        @endphp
        Pada hari ini <strong>{{ $tanggalPemeriksaan ?? 'N/A' }}</strong>, telah dilakukan pemeriksaan terhadap permohonan 
        <strong>({{ $namaUsaha }}) {{ $alamatUsaha }}</strong> yang diajukan oleh:
    </p>
    
    <!-- Data Permohonan -->
    <div class="doc-section">
        <table class="doc-table">
            <tbody>
                <tr>
                    <td style="width: 35%; font-weight: bold; padding: 8px; border: none; background: transparent;">Nomor Permohonan</td>
                    <td style="width: 65%; padding: 8px; border: none; background: transparent;">{{ $permohonan->no_permohonan ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px; border: none; background: transparent;">Tanggal Permohonan</td>
                    <td style="padding: 8px; border: none; background: transparent;">
                        {{ $permohonan->tanggal_permohonan ? $permohonan->tanggal_permohonan->locale('id')->translatedFormat('d F Y') : ($permohonan->created_at ? $permohonan->created_at->locale('id')->translatedFormat('d F Y') : 'N/A') }}
                    </td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px; border: none; background: transparent;">Nama Pelaku Usaha</td>
                    <td style="padding: 8px; border: none; background: transparent;">{{ $data['nama_pelaku_usaha'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px; border: none; background: transparent;">Alamat Pelaku Usaha</td>
                    <td style="padding: 8px; border: none; background: transparent;">{{ $data['alamat_pelaku_usaha'] ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px; border: none; background: transparent;">Nama Usaha</td>
                    <td style="padding: 8px; border: none; background: transparent;">{{ $permohonan->nama_usaha ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px; border: none; background: transparent;">Alamat Usaha</td>
                    <td style="padding: 8px; border: none; background: transparent;">{{ $permohonan->alamat_perusahaan ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px; border: none; background: transparent;">Nomor Induk Berusaha (NIB)</td>
                    <td style="padding: 8px; border: none; background: transparent;">{{ $permohonan->nib ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px; border: none; background: transparent;">KBLI</td>
                    <td style="padding: 8px; border: none; background: transparent;">{{ $permohonan->kbli ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px; border: none; background: transparent;">Skala Usaha</td>
                    <td style="padding: 8px; border: none; background: transparent;">{{ $permohonan->skala_usaha ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td style="font-weight: bold; padding: 8px; border: none; background: transparent;">Tingkat Risiko</td>
                    <td style="padding: 8px; border: none; background: transparent;">{{ $permohonan->risiko ?? 'N/A' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Paragraf sebelum tabel persyaratan -->
    <p class="doc-paragraph no-indent">
        Bahwa terhadap permohonan tersebut, pemohon telah melengkapi persyaratan, yaitu:
    </p>
    
    <!-- Tabel Persyaratan -->
    <table class="doc-table doc-table-persyaratan">
        <thead>
            <tr>
                <th class="no-col">No.</th>
                <th class="nama-col">Jenis Persyaratan</th>
                <th class="checkbox-col">Sesuai</th>
                <th class="checkbox-col">Tidak Sesuai</th>
            </tr>
        </thead>
        <tbody>
            @php
                $persyaratan = isset($data['persyaratan']) && is_array($data['persyaratan']) ? $data['persyaratan'] : [];
                $no = 1;
            @endphp
            @if(count($persyaratan) > 0)
                @foreach($persyaratan as $index => $item)
                    @php
                        if (!is_array($item)) {
                            continue;
                        }
                        
                        $subItems = [];
                        if (isset($item['subItems']) && is_array($item['subItems'])) {
                            foreach ($item['subItems'] as $subItem) {
                                if (is_array($subItem) && !empty($subItem['nama'])) {
                                    $subItems[] = $subItem;
                                }
                            }
                        }
                    @endphp
                    <tr>
                        <td class="text-center">{{ $no++ }}</td>
                        <td>
                            {{ $item['nama'] ?? '' }}
                            @if(count($subItems) > 0)
                                <div class="sub-item">
                                    @foreach($subItems as $subItem)
                                        <div>• {{ $subItem['nama'] ?? '' }}</div>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="text-center" style="vertical-align: top;">
                            @if(isset($item['status']) && $item['status'] === 'Sesuai')
                                <div class="checkbox checked">
                                    <span class="checkbox-checkmark">✓</span>
                                </div>
                            @else
                                <div class="checkbox"></div>
                            @endif
                            @if(count($subItems) > 0)
                                <div style="margin-top: 5px;">
                                    @foreach($subItems as $subItem)
                                        <div style="margin-bottom: 3px;">
                                            @if(isset($subItem['status']) && $subItem['status'] === 'Sesuai')
                                                <div class="checkbox checked" style="display: inline-block;">
                                                    <span class="checkbox-checkmark">✓</span>
                                                </div>
                                            @else
                                                <div class="checkbox" style="display: inline-block;"></div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                        <td class="text-center" style="vertical-align: top;">
                            @if(isset($item['status']) && $item['status'] === 'Tidak Sesuai')
                                <div class="checkbox checked">
                                    <span class="checkbox-checkmark">✓</span>
                                </div>
                            @else
                                <div class="checkbox"></div>
                            @endif
                            @if(count($subItems) > 0)
                                <div style="margin-top: 5px;">
                                    @foreach($subItems as $subItem)
                                        <div style="margin-bottom: 3px;">
                                            @if(isset($subItem['status']) && $subItem['status'] === 'Tidak Sesuai')
                                                <div class="checkbox checked" style="display: inline-block;">
                                                    <span class="checkbox-checkmark">✓</span>
                                                </div>
                                            @else
                                                <div class="checkbox" style="display: inline-block;"></div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="4" style="text-align: center; padding: 20px;">
                        Tidak ada persyaratan yang ditambahkan.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Hasil Peninjauan Lapangan -->
    @if(isset($data['nomor_surat_tugas']) || isset($data['tanggal_surat_tugas']) || isset($data['hasil_peninjauan_lapangan']))
    <div class="doc-section">
        <p class="doc-paragraph no-indent">
            Terhadap permohonan juga telah dilakukan peninjauan lapangan terhadap lokasi usaha, yaitu:
        </p>
        @if(isset($data['tanggal_surat_tugas']))
        <p class="doc-paragraph no-indent" style="margin-bottom: 5px;">
            <strong>Hari/Tanggal:</strong> 
            <span style="margin-left: 40px;">
                @php
                    try {
                        echo \Carbon\Carbon::parse($data['tanggal_surat_tugas'])->locale('id')->translatedFormat('d F Y');
                    } catch (\Exception $e) {
                        echo $data['tanggal_surat_tugas'];
                    }
                @endphp
            </span>
        </p>
        @endif
        @if(isset($data['nomor_surat_tugas']))
        <p class="doc-paragraph no-indent" style="margin-bottom: 5px;">
            <strong>Nomor Surat Perintah Tugas:</strong> 
            <span style="margin-left: 40px;">{{ $data['nomor_surat_tugas'] }}</span>
        </p>
        @endif
        @if(isset($data['hasil_peninjauan_lapangan']))
        <p class="doc-paragraph no-indent" style="margin-bottom: 5px;">
            <strong>Hasil Peninjauan Lapangan:</strong> 
            <span style="margin-left: 40px;">{{ $data['hasil_peninjauan_lapangan'] }}</span>
        </p>
        @endif
    </div>
    @endif

    <!-- Keputusan -->
    <div class="doc-section">
        @if(isset($data['keputusan']) && $data['keputusan'] === 'Disetujui')
            <p class="doc-paragraph no-indent">
                Berdasarkan hal tersebut, maka permohonan tersebut diatas 
                <strong>({{ $data['keputusan'] }} Perizinan)</strong> dengan catatan:
            </p>
        @else
            <p class="doc-paragraph no-indent">
                Berdasarkan hal tersebut, maka permohonan tersebut diatas 
                <strong>({{ $data['keputusan'] ?? 'Disetujui' }} Perizinan)</strong> dengan catatan:
            </p>
            <div class="doc-catatan-box">
                <p>{{ $data['catatan'] ?? '&nbsp;' }}</p>
            </div>
        @endif
    </div>

    <!-- Penutup -->
    <p class="doc-paragraph no-indent">
        Demikian Berita Acara Verifikasi ini dibuat dengan sebenarnya dan penuh tanggungjawab untuk digunakan sebagaimana mestinya.
    </p>
    
    <!-- Tanda Tangan -->
    <div class="doc-signature">
        <!-- Baris 1: Memeriksa (kiri) dan Menyetujui (kanan) -->
        <div class="doc-signature-row">
            <div class="doc-signature-item left">
                <div class="doc-signature-line">
                    <p style="font-weight: bold;">Memeriksa,</p>
                    <p style="font-weight: bold;">Verifikator Tim Perizinan</p>
                    @php
                        $ttdMemeriksa = $data['ttd_memeriksa'] ?? null;
                        if ($ttdMemeriksa && !empty($ttdMemeriksa)) {
                            // Pastikan format base64 benar
                            if (!str_starts_with($ttdMemeriksa, 'data:image')) {
                                $ttdMemeriksa = 'data:image/png;base64,' . $ttdMemeriksa;
                            }
                        }
                    @endphp
                    @if($ttdMemeriksa && !empty($ttdMemeriksa))
                        <img src="{{ $ttdMemeriksa }}" alt="TTD Memeriksa" class="doc-signature-img" style="max-width: 250px; max-height: 80px; object-fit: contain;">
                    @else
                        <div style="height: 80px; margin: 15px 0;"></div>
                    @endif
                    <p>{{ $data['nama_memeriksa'] ?? '_________________________' }}</p>
                    <p>NIP: {{ $data['nip_memeriksa'] ?? '_________________________' }}</p>
                </div>
            </div>
            <div class="doc-signature-item right">
                <div class="doc-signature-line">
                    <p style="font-weight: bold;">Menyetujui,</p>
                    <p style="font-weight: bold;">Validator Tim Perizinan</p>
                    @php
                        $ttdMenyetujui = $data['ttd_menyetujui'] ?? null;
                        if ($ttdMenyetujui && !empty($ttdMenyetujui)) {
                            // Pastikan format base64 benar
                            if (!str_starts_with($ttdMenyetujui, 'data:image')) {
                                $ttdMenyetujui = 'data:image/png;base64,' . $ttdMenyetujui;
                            }
                        }
                    @endphp
                    @if($ttdMenyetujui && !empty($ttdMenyetujui))
                        <img src="{{ $ttdMenyetujui }}" alt="TTD Menyetujui" class="doc-signature-img" style="max-width: 250px; max-height: 80px; object-fit: contain;">
                    @else
                        <div style="height: 80px; margin: 15px 0;"></div>
                    @endif
                    <p>{{ $data['nama_menyetujui'] ?? '_________________________' }}</p>
                    <p>NIP: {{ $data['nip_menyetujui'] ?? '_________________________' }}</p>
                </div>
            </div>
        </div>
        
        <!-- Baris 2: Mengetahui (tengah, agak bawah) -->
        <div class="doc-signature-row" style="margin-top: 40px;">
            <div class="doc-signature-item center">
                <div class="doc-signature-line">
                    <p style="font-weight: bold;">Mengetahui,</p>
                    <p style="font-weight: bold;">Koordinator Ketua Tim Kerja</p>
                    <p style="font-weight: bold;">Pelayanan Terpadu Satu Pintu</p>
                    @php
                        $ttdMengetahui = $data['ttd_mengetahui'] ?? null;
                        if ($ttdMengetahui && !empty($ttdMengetahui)) {
                            // Pastikan format base64 benar
                            if (!str_starts_with($ttdMengetahui, 'data:image')) {
                                $ttdMengetahui = 'data:image/png;base64,' . $ttdMengetahui;
                            }
                        }
                    @endphp
                    @if($ttdMengetahui && !empty($ttdMengetahui))
                        <img src="{{ $ttdMengetahui }}" alt="TTD Mengetahui" class="doc-signature-img" style="max-width: 250px; max-height: 80px; object-fit: contain;">
                    @else
                        <div style="height: 80px; margin: 15px 0;"></div>
                    @endif
                    <p>{{ $data['nama_mengetahui'] ?? '_________________________' }}</p>
                    <p>NIP: {{ $data['nip_mengetahui'] ?? '_________________________' }}</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
