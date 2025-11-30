<?php if (isset($component)) { $__componentOriginal1f7b3c69a858611a4ccc5f2ea9729c12 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1f7b3c69a858611a4ccc5f2ea9729c12 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.sidebar-layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('sidebar-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> Dashboard Admin <?php $__env->endSlot(); ?>

    <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <div class="bg-gradient-to-r from-blue-400 to-blue-600 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs font-medium text-blue-100 truncate">Total Permohonan</dt>
                                    <dd class="text-xl font-bold text-white"><?php echo e($stats['totalPermohonan'] ?? 0); ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-green-400 to-green-600 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs font-medium text-green-100 truncate">Diterima</dt>
                                    <dd class="text-xl font-bold text-white"><?php echo e($stats['diterima'] ?? 0); ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-yellow-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs font-medium text-yellow-100 truncate">Dikembalikan</dt>
                                    <dd class="text-xl font-bold text-white"><?php echo e($stats['dikembalikan'] ?? 0); ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-red-400 to-red-600 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-red-600 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs font-medium text-red-100 truncate">Ditolak</dt>
                                    <dd class="text-xl font-bold text-white"><?php echo e($stats['ditolak'] ?? 0); ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-r from-orange-400 to-orange-600 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 bg-orange-700 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4 w-0 flex-1">
                                <dl>
                                    <dt class="text-xs font-medium text-orange-100 truncate">Terlambat</dt>
                                    <dd class="text-xl font-bold text-white"><?php echo e($stats['terlambat'] ?? 0); ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Recent Permohonan -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-200 bg-header-light">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 text-gray-700 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Data Permohonan Terbaru
                            </h3>
                        </div>
                        <span class="text-sm font-medium px-3 py-1 rounded-full bg-status-blue text-status-blue">
                            <?php echo e($permohonans->count()); ?> Data
                        </span>
                    </div>
                </div>
                <?php if($permohonans->count() > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-table-header">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-table-header">No. Permohonan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-table-header">No. Proyek</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-table-header">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-table-header">Nama Usaha</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-table-header">Alamat Perusahaan</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-table-header">Verifikasi</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider text-table-header">Status</th>
                                <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider text-table-header">Aksi</th>
                            </tr>
                        </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php $__currentLoopData = $permohonans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permohonan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-primary-50 transition-colors duration-200">
                                        <!-- No. Permohonan -->
                                        <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 bg-primary-500 rounded-full mr-3"></div>
                                                <span class="font-mono text-xs"><?php echo e($permohonan->no_permohonan ?? '-'); ?></span>
                                            </div>
                                        </td>
                                        <!-- No. Proyek -->
                                        <td class="px-4 py-4 text-sm text-gray-900">
                                            <p class="font-medium text-gray-900"><?php echo e($permohonan->no_proyek ?? '-'); ?></p>
                                        </td>
                                        <!-- Tanggal -->
                                        <td class="px-4 py-4 text-sm text-gray-900">
                                            <span class="text-xs"><?php echo e($permohonan->tanggal_permohonan ? $permohonan->tanggal_permohonan->setTimezone('Asia/Jakarta')->format('d M Y') : ($permohonan->created_at->setTimezone('Asia/Jakarta')->format('d M Y'))); ?></span>
                                        </td>
                                        <!-- Nama Usaha -->
                                        <td class="px-4 py-4 text-sm text-gray-900">
                                            <p class="font-medium text-gray-900 text-xs"><?php echo e($permohonan->nama_usaha ?? '-'); ?></p>
                                        </td>
                                        <!-- Alamat Perusahaan -->
                                        <td class="px-4 py-4 text-sm text-gray-900">
                                            <p class="text-gray-600 text-xs"><?php echo e($permohonan->alamat_perusahaan ?? '-'); ?></p>
                                        </td>
                                        <!-- Verifikasi -->
                                        <td class="px-4 py-4 text-sm text-gray-900">
                                            <div class="space-y-1">
                                                <?php if($permohonan->verifikasi_pd_teknis): ?>
                                                    <div class="flex items-center">
                                                        <?php
                                                            $verifikasiColor = match($permohonan->verifikasi_pd_teknis) {
                                                                'Berkas Disetujui' => 'bg-green-100 text-green-800',
                                                                'Berkas Diperbaiki' => 'bg-yellow-100 text-yellow-800',
                                                                'Pemohon Dihubungi' => 'bg-orange-100 text-orange-800',
                                                                'Berkas Diunggah Ulang' => 'bg-red-100 text-red-800',
                                                                'Pemohon Belum Dihubungi' => 'bg-purple-100 text-purple-800',
                                                                default => 'bg-gray-100 text-gray-800'
                                                            };
                                                        ?>
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium <?php echo e($verifikasiColor); ?>">
                                                            <?php echo e($permohonan->verifikasi_pd_teknis); ?>

                                                        </span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if($permohonan->verifikasi_dpmptsp): ?>
                                                    <div class="flex items-center">
                                                        <?php
                                                            $verifikasiColor = match($permohonan->verifikasi_dpmptsp) {
                                                                'Berkas Disetujui' => 'bg-green-100 text-green-800',
                                                                'Berkas Diperbaiki' => 'bg-yellow-100 text-yellow-800',
                                                                'Pemohon Dihubungi' => 'bg-orange-100 text-orange-800',
                                                                'Berkas Diunggah Ulang' => 'bg-red-100 text-red-800',
                                                                'Pemohon Belum Dihubungi' => 'bg-purple-100 text-purple-800',
                                                                default => 'bg-gray-100 text-gray-800'
                                                            };
                                                        ?>
                                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium <?php echo e($verifikasiColor); ?>">
                                                            <?php echo e($permohonan->verifikasi_dpmptsp); ?>

                                                        </span>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if(!$permohonan->verifikasi_pd_teknis && !$permohonan->verifikasi_dpmptsp): ?>
                                                    <span class="text-gray-400 text-xs">Belum diverifikasi</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <!-- Status -->
                                        <td class="px-4 py-4 text-sm">
                                            <?php
                                                $status = $permohonan->status ?? 'Menunggu';
                                                $statusColors = [
                                                    'Diterima' => 'bg-green-100 text-green-800',
                                                    'Dikembalikan' => 'bg-yellow-100 text-yellow-800',
                                                    'Ditolak' => 'bg-red-100 text-red-800',
                                                    'Menunggu' => 'bg-blue-100 text-blue-800',
                                                    'Terlambat' => 'bg-orange-100 text-orange-800'
                                                ];
                                                $statusColor = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                                            ?>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?php echo e($statusColor); ?>">
                                                <?php echo e($status); ?>

                                            </span>
                                        </td>
                                        <!-- Aksi -->
                                        <td class="px-4 py-4 text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="<?php echo e(route('permohonan.show', $permohonan)); ?>" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                                    Lihat
                                                </a>
                                                <a href="<?php echo e(route('permohonan.bap', $permohonan)); ?>" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                    BAP
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada permohonan</h3>
                            <p class="mt-1 text-sm text-gray-500">Belum ada data permohonan yang tersedia.</p>
                        </div>
                <?php endif; ?>
            </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1f7b3c69a858611a4ccc5f2ea9729c12)): ?>
<?php $attributes = $__attributesOriginal1f7b3c69a858611a4ccc5f2ea9729c12; ?>
<?php unset($__attributesOriginal1f7b3c69a858611a4ccc5f2ea9729c12); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1f7b3c69a858611a4ccc5f2ea9729c12)): ?>
<?php $component = $__componentOriginal1f7b3c69a858611a4ccc5f2ea9729c12; ?>
<?php unset($__componentOriginal1f7b3c69a858611a4ccc5f2ea9729c12); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>