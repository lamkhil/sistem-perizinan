


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
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Detail Permohonan</h1>
                        <p class="text-sm text-gray-500 font-mono"><?php echo e($permohonan->no_permohonan); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="<?php echo e(route('permohonan.index')); ?>" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
                
                <a href="<?php echo e(route('permohonan.edit', $permohonan)); ?>" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-amber-500 to-orange-500 rounded-lg hover:from-amber-600 hover:to-orange-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Ubah Data
                </a>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $permohonan)): ?>
                <form method="POST" action="<?php echo e(route('permohonan.destroy', $permohonan)); ?>" id="delete-form-<?php echo e($permohonan->id); ?>" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="button" onclick="confirmDelete(this)" data-permohonan-id="<?php echo e($permohonan->id); ?>"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-gradient-to-r from-red-500 to-pink-500 rounded-lg hover:from-red-600 hover:to-pink-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Hapus
                    </button>
                </form>
                <?php endif; ?>
                
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <!-- Main Content -->
    <div class="space-y-8">
        <!-- Status Banner -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-600 p-8 text-white">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold"><?php echo e($permohonan->nama_usaha ?? $permohonan->nama_perusahaan ?? 'Nama Usaha'); ?></h2>
                            <p class="text-blue-100 font-mono text-sm"><?php echo e($permohonan->no_permohonan ?? 'No. Permohonan'); ?></p>
                        </div>
                    </div>
                    <?php
                        $statusConfig = match ($permohonan->status ?? 'Menunggu') {
                            'Diterima' => ['class' => 'bg-green-500', 'icon' => 'M5 13l4 4L19 7', 'text' => 'Diterima'],
                            'Ditolak' => ['class' => 'bg-red-500', 'icon' => 'M6 18L18 6M6 6l12 12', 'text' => 'Ditolak'],
                            'Dikembalikan' => ['class' => 'bg-yellow-500', 'icon' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z', 'text' => 'Dikembalikan'],
                            default => ['class' => 'bg-blue-500', 'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'text' => 'Menunggu'],
                                };
                            ?>
                    <div class="flex items-center space-x-3">
                        <div class="w-3 h-3 <?php echo e($statusConfig['class']); ?> rounded-full animate-pulse"></div>
                        <span class="text-lg font-semibold"><?php echo e($statusConfig['text']); ?></span>
                    </div>
                </div>
            </div>
            <div class="absolute -top-4 -right-4 w-24 h-24 bg-white/10 rounded-full"></div>
            <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-white/5 rounded-full"></div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Main Information & History -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Informasi Utama Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-50 to-blue-50 px-8 py-6 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Informasi Utama</h3>
                        </div>
                    </div>
                    
                    <div class="p-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column - DPMPTSP -->
                            <div class="space-y-6">
                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Nama Usaha</label>
                                    <p class="text-gray-900 font-medium"><?php echo e($permohonan->nama_usaha ?? '-'); ?></p>
                                </div>
                                
                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Alamat Perusahaan</label>
                                    <p class="text-gray-900"><?php echo e($permohonan->alamat_perusahaan ?? '-'); ?></p>
                                </div>
                                
                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Sektor</label>
                                    <?php if($permohonan->sektor): ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            <?php echo e($permohonan->sektor); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-500">-</span>
                                    <?php endif; ?>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Modal Usaha</label>
                                    <p class="text-gray-900"><?php echo e($permohonan->modal_usaha ?? '-'); ?></p>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Jenis Proyek</label>
                                    <p class="text-gray-900"><?php echo e($permohonan->jenis_proyek ?? '-'); ?></p>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Verifikasi Analisa</label>
                                    <?php
                                        $dpmptspStatus = $permohonan->verifikasi_dpmptsp ?? '';
                                        $dpmptspClass = match($dpmptspStatus) {
                                            'Berkas Disetujui' => 'bg-green-100 text-green-800',
                                            'Berkas Diperbaiki' => 'bg-yellow-100 text-yellow-800',
                                            'Pemohon Dihubungi' => 'bg-orange-100 text-orange-800',
                                            'Berkas Diunggah Ulang' => 'bg-red-100 text-red-800',
                                            'Pemohon Belum Dihubungi' => 'bg-blue-100 text-blue-800',
                                            default => 'bg-gray-100 text-gray-600'
                                        };
                                    ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo e($dpmptspClass); ?>">
                                        <?php if($dpmptspStatus == 'Berkas Disetujui'): ?>
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        <?php elseif($dpmptspStatus == 'Berkas Diperbaiki'): ?>
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                        <?php elseif($dpmptspStatus == 'Pemohon Dihubungi'): ?>
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        <?php elseif($dpmptspStatus == 'Berkas Diunggah Ulang'): ?>
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                        <?php elseif($dpmptspStatus == 'Pemohon Belum Dihubungi'): ?>
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        <?php endif; ?>
                                        <?php echo e($dpmptspStatus ?: '-'); ?>

                                    </span>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Verifikator</label>
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <span class="text-blue-600 font-semibold text-sm"><?php echo e(substr($permohonan->verifikator ?? 'V', 0, 1)); ?></span>
                                        </div>
                                        <span class="text-gray-900"><?php echo e($permohonan->verifikator ?? '-'); ?></span>
                                    </div>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Nama Perizinan</label>
                                    <p class="text-gray-900"><?php echo e($permohonan->nama_perizinan ?? '-'); ?></p>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Skala Usaha</label>
                                    <?php if($permohonan->skala_usaha): ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <?php echo e($permohonan->skala_usaha); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-500">-</span>
                                    <?php endif; ?>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Risiko</label>
                                    <?php if($permohonan->risiko): ?>
                                        <?php
                                            $risikoClass = match($permohonan->risiko) {
                                                'Rendah' => 'bg-green-100 text-green-800',
                                                'Sedang' => 'bg-yellow-100 text-yellow-800',
                                                'Tinggi' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-600'
                                            };
                                        ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo e($risikoClass); ?>">
                                            <?php echo e($permohonan->risiko); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-gray-500">-</span>
                                    <?php endif; ?>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Jangka Waktu (Hari Kerja)</label>
                                    <p class="text-gray-900"><?php echo e($permohonan->jangka_waktu ? $permohonan->jangka_waktu . ' hari' : '-'); ?></p>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Deadline (Hari Kerja)</label>
                                    <?php if($permohonan->deadline): ?>
                                        <?php
                                            $deadlineStatus = $permohonan->getDeadlineStatus();
                                            $deadlineClass = match($deadlineStatus) {
                                                'overdue' => 'bg-red-100 text-red-800 border-red-200',
                                                'due_today' => 'bg-orange-100 text-orange-800 border-orange-200',
                                                'due_soon' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                                'on_time' => 'bg-green-100 text-green-800 border-green-200',
                                                default => 'bg-gray-100 text-gray-600 border-gray-200'
                                            };
                                            $deadlineIcon = match($deadlineStatus) {
                                                'overdue' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z',
                                                'due_today' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                                'due_soon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                                'on_time' => 'M5 13l4 4L19 7',
                                                default => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'
                                            };
                                        ?>
                                        <div class="inline-flex items-center px-3 py-2 rounded-lg border <?php echo e($deadlineClass); ?>">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($deadlineIcon); ?>"></path>
                                            </svg>
                                            <span class="font-medium"><?php echo e($permohonan->deadline->locale('id')->translatedFormat('d/m/Y')); ?></span>
                                            <?php if($deadlineStatus == 'overdue'): ?>
                                                <span class="ml-2 text-xs font-bold">TERLAMBAT!</span>
                                            <?php elseif($deadlineStatus == 'due_today'): ?>
                                                <span class="ml-2 text-xs font-bold">HARI INI!</span>
                                            <?php elseif($deadlineStatus == 'due_soon'): ?>
                                                <span class="ml-2 text-xs font-bold">SEGERA!</span>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-500">-</span>
                                    <?php endif; ?>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">No. Telephone / Email</label>
                                    <p class="text-gray-900 font-mono"><?php echo e($permohonan->no_telephone ?? '-'); ?></p>
                                </div>
                            </div>
                            
                            <!-- Right Column - PD Teknis -->
                            <div class="space-y-6">
                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Nama Perusahaan</label>
                                    <p class="text-gray-900"><?php echo e($permohonan->nama_perusahaan ?? '-'); ?></p>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">No. Permohonan</label>
                                    <div class="flex items-center space-x-3">
                                        <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                        <span class="font-mono text-sm text-gray-900 bg-gray-50 px-3 py-2 rounded-lg"><?php echo e($permohonan->no_permohonan ?? '-'); ?></span>
                                    </div>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">No. Proyek</label>
                                    <p class="text-gray-900"><?php echo e($permohonan->no_proyek ?? '-'); ?></p>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Tanggal Permohonan</label>
                                    <p class="text-gray-900"><?php echo e($permohonan->tanggal_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->locale('id')->translatedFormat('d/m/Y') : '-'); ?></p>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Jenis Perusahaan</label>
                                    <p class="text-gray-900"><?php echo e($permohonan->jenis_perusahaan_display); ?></p>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">NIB</label>
                                    <p class="text-gray-900"><?php echo e($permohonan->nib ?? '-'); ?></p>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">KBLI</label>
                                    <p class="text-gray-900"><?php echo e($permohonan->kbli ?? '-'); ?></p>
                                </div>

                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Kegiatan</label>
                                    <p class="text-gray-900"><?php echo e($permohonan->inputan_teks ?? '-'); ?></p>
                                </div>
                                
                                <div class="group">
                                    <label class="text-sm font-medium text-gray-500 block mb-2">Verifikasi PD Teknis</label>
                                    <?php
                                        $pdTeknisStatus = $permohonan->verifikasi_pd_teknis ?? '';
                                        $pdTeknisClass = match($pdTeknisStatus) {
                                            'Berkas Disetujui' => 'bg-green-100 text-green-800',
                                            'Berkas Diperbaiki' => 'bg-yellow-100 text-yellow-800',
                                            'Pemohon Dihubungi' => 'bg-orange-100 text-orange-800',
                                            'Berkas Diunggah Ulang' => 'bg-red-100 text-red-800',
                                            'Pemohon Belum Dihubungi' => 'bg-purple-100 text-purple-800',
                                            default => 'bg-gray-100 text-gray-600'
                                        };
                                    ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium <?php echo e($pdTeknisClass); ?>">
                                        <?php if($pdTeknisStatus == 'Berkas Disetujui'): ?>
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        <?php elseif($pdTeknisStatus == 'Berkas Diperbaiki'): ?>
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                            </svg>
                                        <?php elseif($pdTeknisStatus == 'Pemohon Dihubungi'): ?>
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                        <?php elseif($pdTeknisStatus == 'Berkas Diunggah Ulang'): ?>
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                        <?php elseif($pdTeknisStatus == 'Pemohon Belum Dihubungi'): ?>
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        <?php endif; ?>
                                        <?php echo e($pdTeknisStatus ?: '-'); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Riwayat Perubahan Status -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-8 py-6 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900">Riwayat Perubahan Status</h3>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-4">
                            <?php $__empty_1 = true; $__currentLoopData = $permohonan->logs ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $userRole = $log->user->role ?? 'user';
                                $userName = $log->user->name ?? 'Unknown User';
                                $userInitial = substr($userName, 0, 1);
                                $currentUser = Auth::user();
                                $currentUserId = $currentUser->id ?? null;
                                $logUserId = $log->user->id ?? null;
                                
                                // Tentukan warna berdasarkan role
                                $roleColors = [
                                    'admin' => ['bg' => 'bg-gradient-to-br from-red-500 to-pink-500', 'text' => 'text-white'],
                                    'dpmptsp' => ['bg' => 'bg-gradient-to-br from-blue-500 to-indigo-500', 'text' => 'text-white'],
                                    'pd_teknis' => ['bg' => 'bg-gradient-to-br from-green-500 to-emerald-500', 'text' => 'text-white'],
                                    'user' => ['bg' => 'bg-gradient-to-br from-gray-500 to-slate-500', 'text' => 'text-white']
                                ];
                                
                                $roleConfig = $roleColors[$userRole] ?? $roleColors['user'];
                                
                                // Posisi chat: jika user yang login sama dengan user yang membuat log, maka di kanan (seperti mengirim pesan)
                                $isRightAligned = ($currentUserId && $logUserId && $currentUserId == $logUserId);
                                $position = $isRightAligned ? 'justify-end' : 'justify-start';
                            ?>
                            
                            <div class="flex <?php echo e($position); ?>">
                                <div class="flex items-end space-x-2 max-w-xs lg:max-w-md">
                                    <?php if(!$isRightAligned): ?>
                                    <div class="w-8 h-8 <?php echo e($roleConfig['bg']); ?> rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                                        <span class="text-xs font-bold <?php echo e($roleConfig['text']); ?>"><?php echo e($userInitial); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex flex-col <?php echo e($isRightAligned ? 'items-end' : 'items-start'); ?>">
                                        <div class="bg-white rounded-2xl px-4 py-3 shadow-lg border border-gray-200 <?php echo e($isRightAligned ? 'rounded-br-md' : 'rounded-bl-md'); ?>">
                                            <div class="text-xs font-semibold text-gray-700 mb-1">
                                                Perubahan dicatat oleh <?php echo e(strtoupper($userRole)); ?> USER
                                            </div>
                                            <div class="text-sm text-gray-800 leading-relaxed">
                                                <?php if(strpos($log->keterangan, '•') !== false): ?>
                                                    <div class="space-y-1">
                                                        <?php $__currentLoopData = explode("\n• ", $log->keterangan); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($index === 0): ?>
                                                                <div>• <?php echo e($item); ?></div>
                                                            <?php else: ?>
                                                                <div>• <?php echo e($item); ?></div>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </div>
                                                <?php else: ?>
                                        <?php echo $log->keterangan; ?>

                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1 px-2">
                                            <?php echo e($log->created_at->setTimezone('Asia/Jakarta')->format('H:i')); ?> • <?php echo e($log->created_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y')); ?>

                                        </div>
                                    </div>
                                    
                                    <?php if($isRightAligned): ?>
                                    <div class="w-8 h-8 <?php echo e($roleConfig['bg']); ?> rounded-full flex items-center justify-center shadow-lg flex-shrink-0">
                                        <span class="text-xs font-bold <?php echo e($roleConfig['text']); ?>"><?php echo e($userInitial); ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-12">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Riwayat</h3>
                                <p class="text-gray-500">Belum ada riwayat perubahan status untuk permohonan ini.</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Process Tracking -->
            <div class="space-y-6">
                <!-- Process Tracking Card -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden sticky top-6">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">Proses Tracking</h3>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <div class="space-y-6">
                            <!-- Pengembalian -->
                            <div class="group">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-8 h-8 <?php echo e($permohonan->pengembalian ? 'bg-orange-500' : 'bg-gray-300'); ?> rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900">Pengembalian</h4>
                                </div>
                                <div class="ml-11 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Tanggal:</span>
                                        <span class="text-sm font-medium <?php echo e($permohonan->pengembalian ? 'text-orange-600' : 'text-gray-400'); ?>">
                                            <?php echo e($permohonan->pengembalian ? \Carbon\Carbon::parse($permohonan->pengembalian)->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y') : 'Belum ada'); ?>

                                        </span>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-sm text-gray-600"><?php echo e($permohonan->keterangan_pengembalian ?? 'Tidak ada keterangan'); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Menghubungi -->
                            <div class="group">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-8 h-8 <?php echo e($permohonan->menghubungi ? 'bg-blue-500' : 'bg-gray-300'); ?> rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900">Menghubungi</h4>
                                </div>
                                <div class="ml-11 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Tanggal:</span>
                                        <span class="text-sm font-medium <?php echo e($permohonan->menghubungi ? 'text-blue-600' : 'text-gray-400'); ?>">
                                            <?php echo e($permohonan->menghubungi ? \Carbon\Carbon::parse($permohonan->menghubungi)->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y') : 'Belum ada'); ?>

                                        </span>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-sm text-gray-600"><?php echo e($permohonan->keterangan_menghubungi ?? 'Tidak ada keterangan'); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Perbaikan -->
                            <div class="group">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-8 h-8 <?php echo e($permohonan->perbaikan ? 'bg-yellow-500' : 'bg-gray-300'); ?> rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900">Disetujui</h4>
                                </div>
                                <div class="ml-11 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Tanggal:</span>
                                        <span class="text-sm font-medium <?php echo e($permohonan->perbaikan ? 'text-yellow-600' : 'text-gray-400'); ?>">
                                            <?php echo e($permohonan->perbaikan ? \Carbon\Carbon::parse($permohonan->perbaikan)->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y') : 'Belum ada'); ?>

                                        </span>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-sm text-gray-600"><?php echo e($permohonan->keterangan_perbaikan ?? 'Tidak ada keterangan'); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Terbit -->
                            <div class="group">
                                <div class="flex items-center space-x-3 mb-3">
                                    <div class="w-8 h-8 <?php echo e($permohonan->terbit ? 'bg-green-500' : 'bg-gray-300'); ?> rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900">Terbit</h4>
                                </div>
                                <div class="ml-11 space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Tanggal:</span>
                                        <span class="text-sm font-medium <?php echo e($permohonan->terbit ? 'text-green-600' : 'text-gray-400'); ?>">
                                            <?php echo e($permohonan->terbit ? \Carbon\Carbon::parse($permohonan->terbit)->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y') : 'Belum ada'); ?>

                                        </span>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3">
                                        <p class="text-sm text-gray-600"><?php echo e($permohonan->keterangan_terbit ?? 'Tidak ada keterangan'); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(button) {
            const permohonanId = button.getAttribute('data-permohonan-id');
            Swal.fire({
                title: 'Konfirmasi Penghapusan',
                text: 'Apakah Anda yakin ingin menghapus permohonan ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + permohonanId).submit();
                }
            });
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1f7b3c69a858611a4ccc5f2ea9729c12)): ?>
<?php $attributes = $__attributesOriginal1f7b3c69a858611a4ccc5f2ea9729c12; ?>
<?php unset($__attributesOriginal1f7b3c69a858611a4ccc5f2ea9729c12); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1f7b3c69a858611a4ccc5f2ea9729c12)): ?>
<?php $component = $__componentOriginal1f7b3c69a858611a4ccc5f2ea9729c12; ?>
<?php unset($__componentOriginal1f7b3c69a858611a4ccc5f2ea9729c12); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/permohonan/show.blade.php ENDPATH**/ ?>