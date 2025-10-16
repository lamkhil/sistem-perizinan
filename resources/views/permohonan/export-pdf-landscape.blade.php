<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Permohonan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 4px;
            margin: 0;
            padding: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 1px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
            overflow: hidden;
        }
        th {
            background-color: #E3F2FD;
            font-weight: normal;
            font-size: 4px;
            padding: 2px 1px;
            text-align: center;
        }
        td {
            font-size: 3px;
        }
        .text-center {
            text-align: center;
        }
        .no-data {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }
        /* Column widths - much narrower */
        .col-1 { width: 2%; }
        .col-2 { width: 2%; }
        .col-3 { width: 4%; }
        .col-4 { width: 3%; }
        .col-5 { width: 3%; }
        .col-6 { width: 3%; }
        .col-7 { width: 3%; }
        .col-8 { width: 4%; }
        .col-9 { width: 3%; }
        .col-10 { width: 4%; }
        .col-11 { width: 4%; }
        .col-12 { width: 5%; }
        .col-13 { width: 3%; }
        .col-14 { width: 3%; }
        .col-15 { width: 3%; }
        .col-16 { width: 2%; }
        .col-17 { width: 2%; }
        .col-18 { width: 3%; }
        .col-19 { width: 3%; }
        .col-20 { width: 3%; }
        .col-21 { width: 3%; }
        .col-22 { width: 3%; }
        .col-23 { width: 4%; }
        .col-24 { width: 3%; }
        .col-25 { width: 4%; }
        .col-26 { width: 3%; }
        .col-27 { width: 3%; }
        .col-28 { width: 4%; }
        .col-29 { width: 3%; }
        .col-30 { width: 4%; }
        .col-31 { width: 3%; }
        .col-32 { width: 3%; }
        .col-33 { width: 2%; }
    </style>
</head>
<body>
    @if($permohonans->count() > 0)
        <table>
            <thead>
                <tr>
                    <th class="col-1">SEKTOR</th>
                    <th class="col-2">WAKTU</th>
                    <th class="col-3">NO. PERMOHONAN (PD TEKNIS)</th>
                    <th class="col-4">NO. PROYEK (PD TEKNIS)</th>
                    <th class="col-5">TANGGAL PERMOHONAN (PD TEKNIS)</th>
                    <th class="col-6">NIB (PD TEKNIS)</th>
                    <th class="col-7">KBLI (PD TEKNIS)</th>
                    <th class="col-8">KEGIATAN (PD TEKNIS)</th>
                    <th class="col-9">JENIS PERUSAHAAN (PD TEKNIS)</th>
                    <th class="col-10">NAMA PERUSAHAAN (PD TEKNIS)</th>
                    <th class="col-11">NAMA USAHA (DPM)</th>
                    <th class="col-12">ALAMAT PERUSAHAAN (DPM)</th>
                    <th class="col-13">MODAL USAHA (DPM)</th>
                    <th class="col-14">JENIS PROYEK (DPM)</th>
                    <th class="col-15">NAMA PERIZINAN (DPM)</th>
                    <th class="col-16">SKALA USAHA (DPM)</th>
                    <th class="col-17">RISIKO (DPM)</th>
                    <th class="col-18">JANGKA WAKTU (HARI KERJA) (DPM)</th>
                    <th class="col-19">NO TELPHONE (DPM)</th>
                    <th class="col-20">VERIFIKASI OLEH PD TEKNIS</th>
                    <th class="col-21">VERIFIKASI ANALISA (DPMPTSP)</th>
                    <th class="col-22">TANGGAL PENGEMBALIAN</th>
                    <th class="col-23">KETERANGAN PENGEMBALIAN</th>
                    <th class="col-24">TANGGAL MENGHUBUNGI</th>
                    <th class="col-25">KETERANGAN MENGHUBUNGI</th>
                    <th class="col-26">TANGGAL DISETUJUI</th>
                    <th class="col-27">KETERANGAN DISETUJUI</th>
                    <th class="col-28">TANGGAL TERBIT</th>
                    <th class="col-29">KETERANGAN TERBIT</th>
                    <th class="col-30">PEMROSES DAN TGL E-SURAT DAN TGL PERTEK</th>
                    <th class="col-31">VERIFIKATOR</th>
                    <th class="col-32">STATUS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permohonans as $permohonan)
                    <tr>
                        <td class="col-1">{{ $permohonan->sektor ?? '' }}</td>
                        <td class="col-2">{{ $permohonan->created_at ? \Carbon\Carbon::parse($permohonan->created_at)->format('Y') : '' }}</td>
                        <td class="col-3">{{ $permohonan->no_permohonan ?? '' }}</td>
                        <td class="col-4">{{ $permohonan->no_proyek ?? '' }}</td>
                        <td class="col-5">{{ $permohonan->tanggal_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->locale('id')->translatedFormat('d/m/Y') : '' }}</td>
                        <td class="col-6">{{ $permohonan->nib ?? '' }}</td>
                        <td class="col-7">{{ $permohonan->kbli ?? '' }}</td>
                        <td class="col-8">{{ $permohonan->inputan_teks ?? '' }}</td>
                        <td class="col-9">{{ $permohonan->jenis_perusahaan_display ?? '' }}</td>
                        <td class="col-10">{{ $permohonan->nama_perusahaan ?? '' }}</td>
                        <td class="col-11">{{ $permohonan->nama_usaha ?? '' }}</td>
                        <td class="col-12">{{ $permohonan->alamat_perusahaan ?? '' }}</td>
                        <td class="col-13">{{ $permohonan->modal_usaha ? number_format((float) $permohonan->modal_usaha, 0, ',', '.') : '' }}</td>
                        <td class="col-14">{{ $permohonan->jenis_proyek ?? '' }}</td>
                        <td class="col-15">{{ $permohonan->nama_perizinan ?? '' }}</td>
                        <td class="col-16">{{ $permohonan->skala_usaha ?? '' }}</td>
                        <td class="col-17">{{ $permohonan->risiko ?? '' }}</td>
                        <td class="col-18">{{ $permohonan->jangka_waktu ?? '' }}</td>
                        <td class="col-19">{{ $permohonan->no_telephone ?? '' }}</td>
                        <td class="col-20">{{ $permohonan->verifikasi_pd_teknis ?? '' }}</td>
                        <td class="col-21">{{ $permohonan->verifikasi_dpmptsp ?? '' }}</td>
                        <td class="col-22">{{ $permohonan->pengembalian ? \Carbon\Carbon::parse($permohonan->pengembalian)->locale('id')->translatedFormat('d/m/Y') : '' }}</td>
                        <td class="col-23">{{ $permohonan->keterangan_pengembalian ?? '' }}</td>
                        <td class="col-24">{{ $permohonan->menghubungi ? \Carbon\Carbon::parse($permohonan->menghubungi)->locale('id')->translatedFormat('d/m/Y') : '' }}</td>
                        <td class="col-25">{{ $permohonan->keterangan_menghubungi ?? '' }}</td>
                        <td class="col-26">{{ $permohonan->perbaikan ? \Carbon\Carbon::parse($permohonan->perbaikan)->locale('id')->translatedFormat('d/m/Y') : '' }}</td>
                        <td class="col-27">{{ $permohonan->keterangan_disetujui ?? '' }}</td>
                        <td class="col-28">{{ $permohonan->terbit ? \Carbon\Carbon::parse($permohonan->terbit)->locale('id')->translatedFormat('d/m/Y') : '' }}</td>
                        <td class="col-29">{{ $permohonan->keterangan_terbit ?? '' }}</td>
                        <td class="col-30">{{ $permohonan->created_at ? \Carbon\Carbon::parse($permohonan->created_at)->locale('id')->translatedFormat('d/m/Y') : '' }}</td>
                        <td class="col-31">{{ $permohonan->verifikator ?? '' }}</td>
                        <td class="col-32">{{ $permohonan->status ?? '' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p>Tidak ada data permohonan yang ditemukan.</p>
        </div>
    @endif
</body>
</html>
