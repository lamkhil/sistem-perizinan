<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Permohonan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 6px;
            margin: 0;
            padding: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 2px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #E3F2FD;
            font-weight: normal;
            font-size: 6px;
            padding: 4px 2px;
            text-align: center;
        }
        td {
            font-size: 5px;
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
    </style>
</head>
<body>
    <?php if($permohonans->count() > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>SEKTOR</th>
                    <th>WAKTU</th>
                    <th>NO. PERMOHONAN (PD TEKNIS)</th>
                    <th>NO. PROYEK (PD TEKNIS)</th>
                    <th>TANGGAL PERMOHONAN (PD TEKNIS)</th>
                    <th>NIB (PD TEKNIS)</th>
                    <th>KBLI (PD TEKNIS)</th>
                    <th>KEGIATAN (PD TEKNIS)</th>
                    <th>JENIS PERUSAHAAN (PD TEKNIS)</th>
                    <th>NAMA PERUSAHAAN (PD TEKNIS)</th>
                    <th>NAMA USAHA (DPM)</th>
                    <th>ALAMAT PERUSAHAAN (DPM)</th>
                    <th>MODAL USAHA (DPM)</th>
                    <th>JENIS PROYEK (DPM)</th>
                    <th>NAMA PERIZINAN (DPM)</th>
                    <th>SKALA USAHA (DPM)</th>
                    <th>RISIKO (DPM)</th>
                    <th>JANGKA WAKTU (HARI KERJA) (DPM)</th>
                    <th>NO TELPHONE (DPM)</th>
                    <th>VERIFIKASI OLEH PD TEKNIS</th>
                    <th>VERIFIKASI ANALISA (DPMPTSP)</th>
                    <th>TANGGAL PENGEMBALIAN</th>
                    <th>KETERANGAN PENGEMBALIAN</th>
                    <th>TANGGAL MENGHUBUNGI</th>
                    <th>KETERANGAN MENGHUBUNGI</th>
                    <th>TANGGAL DISETUJUI</th>
                    <th>KETERANGAN DISETUJUI</th>
                    <th>TANGGAL TERBIT</th>
                    <th>KETERANGAN TERBIT</th>
                    <th>PEMROSES DAN TGL E-SURAT DAN TGL PERTEK</th>
                    <th>VERIFIKATOR</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $permohonans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permohonan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($permohonan->sektor ?? ''); ?></td>
                        <td><?php echo e($permohonan->created_at ? \Carbon\Carbon::parse($permohonan->created_at)->format('Y') : ''); ?></td>
                        <td><?php echo e($permohonan->no_permohonan ?? ''); ?></td>
                        <td><?php echo e($permohonan->no_proyek ?? ''); ?></td>
                        <td><?php echo e($permohonan->tanggal_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->locale('id')->translatedFormat('d/m/Y') : ''); ?></td>
                        <td><?php echo e($permohonan->nib ?? ''); ?></td>
                        <td><?php echo e($permohonan->kbli ?? ''); ?></td>
                        <td><?php echo e($permohonan->inputan_teks ?? ''); ?></td>
                        <td><?php echo e($permohonan->jenis_perusahaan_display ?? ''); ?></td>
                        <td><?php echo e($permohonan->nama_perusahaan ?? ''); ?></td>
                        <td><?php echo e($permohonan->nama_usaha ?? ''); ?></td>
                        <td><?php echo e($permohonan->alamat_perusahaan ?? ''); ?></td>
                        <td><?php echo e($permohonan->modal_usaha ? number_format((float) $permohonan->modal_usaha, 0, ',', '.') : ''); ?></td>
                        <td><?php echo e($permohonan->jenis_proyek ?? ''); ?></td>
                        <td><?php echo e($permohonan->nama_perizinan ?? ''); ?></td>
                        <td><?php echo e($permohonan->skala_usaha ?? ''); ?></td>
                        <td><?php echo e($permohonan->risiko ?? ''); ?></td>
                        <td><?php echo e($permohonan->jangka_waktu ?? ''); ?></td>
                        <td><?php echo e($permohonan->no_telephone ?? ''); ?></td>
                        <td><?php echo e($permohonan->verifikasi_pd_teknis ?? ''); ?></td>
                        <td><?php echo e($permohonan->verifikasi_dpmptsp ?? ''); ?></td>
                        <td><?php echo e($permohonan->pengembalian ? \Carbon\Carbon::parse($permohonan->pengembalian)->locale('id')->translatedFormat('d/m/Y') : ''); ?></td>
                        <td><?php echo e($permohonan->keterangan_pengembalian ?? ''); ?></td>
                        <td><?php echo e($permohonan->menghubungi ? \Carbon\Carbon::parse($permohonan->menghubungi)->locale('id')->translatedFormat('d/m/Y') : ''); ?></td>
                        <td><?php echo e($permohonan->keterangan_menghubungi ?? ''); ?></td>
                        <td><?php echo e($permohonan->perbaikan ? \Carbon\Carbon::parse($permohonan->perbaikan)->locale('id')->translatedFormat('d/m/Y') : ''); ?></td>
                        <td><?php echo e($permohonan->keterangan_disetujui ?? ''); ?></td>
                        <td><?php echo e($permohonan->terbit ? \Carbon\Carbon::parse($permohonan->terbit)->locale('id')->translatedFormat('d/m/Y') : ''); ?></td>
                        <td><?php echo e($permohonan->keterangan_terbit ?? ''); ?></td>
                        <td><?php echo e($permohonan->created_at ? \Carbon\Carbon::parse($permohonan->created_at)->locale('id')->translatedFormat('d/m/Y') : ''); ?></td>
                        <td><?php echo e($permohonan->verifikator ?? ''); ?></td>
                        <td><?php echo e($permohonan->status ?? ''); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-data">
            <p>Tidak ada data permohonan yang ditemukan.</p>
        </div>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/permohonan/export-pdf-landscape.blade.php ENDPATH**/ ?>