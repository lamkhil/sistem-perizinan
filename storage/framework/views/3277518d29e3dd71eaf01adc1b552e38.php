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
            font-weight: bold;
            font-size: 9px;
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
        <p>Dicetak pada: <?php echo e(\Carbon\Carbon::now()->setTimezone('Asia/Jakarta')->format('d/m/Y H:i')); ?></p>
        <p>Total Data: <?php echo e($permohonans->count()); ?> permohonan</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 8%;">No. Permohonan</th>
                <th style="width: 8%;">No. Proyek</th>
                <th style="width: 6%;">Tanggal</th>
                <th style="width: 8%;">Nama Usaha</th>
                <th style="width: 10%;">Alamat</th>
                <th style="width: 5%;">Sektor</th>
                <th style="width: 6%;">Modal</th>
                <th style="width: 5%;">Status</th>
                <th style="width: 6%;">Verifikasi PD</th>
                <th style="width: 6%;">Verifikasi Analisa</th>
                <th style="width: 5%;">KBLI</th>
                <th style="width: 8%;">Kegiatan</th>
                <th style="width: 6%;">User</th>
                <th style="width: 6%;">Dibuat</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $permohonans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $permohonan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($index + 1); ?></td>
                <td><?php echo e($permohonan->no_permohonan); ?></td>
                <td><?php echo e($permohonan->no_proyek); ?></td>
                <td><?php echo e($permohonan->tanggal_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->format('d/m/Y') : '-'); ?></td>
                <td><?php echo e($permohonan->nama_usaha); ?></td>
                <td><?php echo e(\Illuminate\Support\Str::limit($permohonan->alamat_perusahaan, 30)); ?></td>
                <td><?php echo e($permohonan->sektor); ?></td>
                <td><?php echo e($permohonan->modal_usaha ? 'Rp ' . number_format($permohonan->modal_usaha, 0, ',', '.') : '-'); ?></td>
                <td>
                    <?php if($permohonan->status == 'Diterima'): ?>
                        <span class="status-diterima"><?php echo e($permohonan->status); ?></span>
                    <?php elseif($permohonan->status == 'Dikembalikan'): ?>
                        <span class="status-dikembalikan"><?php echo e($permohonan->status); ?></span>
                    <?php elseif($permohonan->status == 'Ditolak'): ?>
                        <span class="status-ditolak"><?php echo e($permohonan->status); ?></span>
                    <?php else: ?>
                        <span class="status-menunggu"><?php echo e($permohonan->status); ?></span>
                    <?php endif; ?>
                </td>
                <td><?php echo e($permohonan->verifikasi_pd_teknis ?? '-'); ?></td>
                <td><?php echo e($permohonan->verifikasi_dpmptsp ?? '-'); ?></td>
                <td><?php echo e($permohonan->kbli ?? '-'); ?></td>
                <td><?php echo e(\Illuminate\Support\Str::limit($permohonan->inputan_teks, 20)); ?></td>
                <td><?php echo e($permohonan->user ? $permohonan->user->name : '-'); ?></td>
                <td><?php echo e($permohonan->created_at ? \Carbon\Carbon::parse($permohonan->created_at)->setTimezone('Asia/Jakarta')->format('d/m/Y') : '-'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="15" style="text-align: center; padding: 20px;">Tidak ada data permohonan</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Sistem Perizinan</p>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/permohonan/export-pdf.blade.php ENDPATH**/ ?>