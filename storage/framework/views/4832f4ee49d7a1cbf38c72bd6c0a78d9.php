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
        <p>KOTA SURABAYA TAHUN <?php echo e(date('Y')); ?></p>
    </div>

    <?php if($permohonans->count() > 0): ?>
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
                <?php $__currentLoopData = $permohonans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $permohonan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($permohonan->no_permohonan ?? '-'); ?></td>
                    <td><?php echo e($permohonan->no_proyek ?? '-'); ?></td>
                    <td><?php echo e($permohonan->tanggal_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->locale('id')->isoFormat('D MMMM Y') : '-'); ?></td>
                    <td><?php echo e($permohonan->nib ?? '-'); ?></td>
                    <td><?php echo e($permohonan->kbli ?? '-'); ?></td>
                    <td><?php echo e($permohonan->nama_usaha ?? '-'); ?></td>
                    <td><?php echo e($permohonan->inputan_teks ?? '-'); ?></td>
                    <td><?php echo e($permohonan->jenis_pelaku_usaha ?? '-'); ?></td>
                    <td><?php echo e($permohonan->pemilik ?? '-'); ?></td>
                    <td><?php echo e($permohonan->modal_usaha ? 'Rp ' . number_format($permohonan->modal_usaha, 0, ',', '.') : '-'); ?></td>
                    <td><?php echo e($permohonan->alamat_perusahaan ?? '-'); ?></td>
                    <td><?php echo e($permohonan->jenis_proyek ?? '-'); ?></td>
                    <td><?php echo e($permohonan->nama_perizinan ?? '-'); ?></td>
                    <td><?php echo e($permohonan->skala_usaha ?? '-'); ?></td>
                    <td><?php echo e($permohonan->risiko ?? '-'); ?></td>
                    <td>
                        DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU<br>
                        No: BAP/OSS/IX/<?php echo e($permohonan->no_permohonan ?? 'N/A'); ?>/436.7.15/<?php echo e(date('Y')); ?><br>
                        tanggal BAP: <?php echo e(date('d F Y')); ?>

                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-data">
            <p>Tidak ada data permohonan yang tersedia.</p>
        </div>
    <?php endif; ?>

    <!-- TTD Section - SIDE BY SIDE LAYOUT -->
    <div class="ttd-section">
        <div class="ttd-container">
            <!-- Mengetahui (kiri) -->
            <div class="ttd-item">
                <div class="ttd-text" style="font-weight: bold;">Mengetahui</div>
                <div class="ttd-text">Koordinator Ketua Tim Kerja</div>
                <div class="ttd-text">Pelayanan Terpadu Satu Pintu</div>
                <!-- Tambahkan spacing seperti referensi -->
                <div style="height: 20px;"></div>
                <div class="ttd-line">
                    <?php if($ttdSettings->mengetahui_photo): ?>
                        <img src="<?php echo e(public_path('storage/ttd_photos/' . $ttdSettings->mengetahui_photo)); ?>" alt="TTD Mengetahui" class="ttd-photo">
                    <?php endif; ?>
                </div>
                <div class="ttd-name"><?php echo e($ttdSettings->mengetahui_nama); ?></div>
                <div class="ttd-text"><?php echo e($ttdSettings->mengetahui_pangkat); ?></div>
                <div class="ttd-nip">NIP: <?php echo e($ttdSettings->mengetahui_nip); ?></div>
            </div>

            <!-- Menyetujui (kanan) -->
            <div class="ttd-item">
                <div class="ttd-text" style="font-weight: bold;"><?php echo e($menyetujuiTitle); ?></div>
                <div class="ttd-text">Ketua Tim Kerja Pelayanan Perizinan Berusaha</div>
                <!-- Tambahkan spacing seperti referensi -->
                <div style="height: 20px;"></div>
                <div class="ttd-line">
                    <?php if($ttdSettings->menyetujui_photo): ?>
                        <img src="<?php echo e(public_path('storage/ttd_photos/' . $ttdSettings->menyetujui_photo)); ?>" alt="TTD Menyetujui" class="ttd-photo">
                    <?php endif; ?>
                </div>
                <div class="ttd-name"><?php echo e($ttdSettings->menyetujui_nama); ?></div>
                <div class="ttd-text"><?php echo e($ttdSettings->menyetujui_pangkat); ?></div>
                <div class="ttd-nip">NIP: <?php echo e($ttdSettings->menyetujui_nip); ?></div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/permohonan/export-pdf-penerbitan.blade.php ENDPATH**/ ?>