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
        Daftar Permohonan
        <?php if(auth()->user()->role === 'pd_teknis' && auth()->user()->sektor): ?>
            - Sektor <?php echo e(auth()->user()->sektor); ?>

        <?php endif; ?>
     <?php $__env->endSlot(); ?>

    

    <!-- Header dengan Action Buttons -->
    <div class="mb-6 bg-white rounded-xl shadow-sm p-6">
        <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-6">
            <!-- Left: Search dan Filter -->
            <div class="flex-1 min-w-0">
                <form method="GET" action="<?php echo e(route('permohonan.index')); ?>" class="space-y-4" id="filterForm">
                    <!-- Search Bar -->
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <div class="flex h-11">
                                <input type="text" name="search" value="<?php echo e($searchQuery ?? ''); ?>" 
                                       placeholder="Cari berdasarkan No. Permohonan atau Nama Usaha..."
                                       class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <button type="submit" class="px-4 bg-primary-600 text-white rounded-r-lg hover:bg-primary-700 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Filter Buttons -->
                        <div class="flex gap-2">
                            <div class="relative custom-dropdown">
                                <select name="sektor" onchange="this.form.submit()" class="h-11 pl-3 pr-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm appearance-none bg-white cursor-pointer">
                                    <option value="">Semua Sektor</option>
                                    <?php $__currentLoopData = $sektors ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sektor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($sektor); ?>" <?php echo e(($selectedSektor ?? '') == $sektor ? 'selected' : ''); ?>>
                                            <?php echo e($sektor); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-600 dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="relative custom-dropdown">
                                <select name="date_filter" onchange="this.form.submit()" class="h-11 pl-3 pr-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm appearance-none bg-white cursor-pointer">
                                    <option value="">Semua Periode</option>
                                    <option value="today" <?php echo e(($selectedDateFilter ?? '') == 'today' ? 'selected' : ''); ?>>Hari Ini</option>
                                    <option value="yesterday" <?php echo e(($selectedDateFilter ?? '') == 'yesterday' ? 'selected' : ''); ?>>Kemarin</option>
                                    <option value="this_week" <?php echo e(($selectedDateFilter ?? '') == 'this_week' ? 'selected' : ''); ?>>Minggu Ini</option>
                                    <option value="last_week" <?php echo e(($selectedDateFilter ?? '') == 'last_week' ? 'selected' : ''); ?>>Minggu Lalu</option>
                                    <option value="this_month" <?php echo e(($selectedDateFilter ?? '') == 'this_month' ? 'selected' : ''); ?>>Bulan Ini</option>
                                    <option value="last_month" <?php echo e(($selectedDateFilter ?? '') == 'last_month' ? 'selected' : ''); ?>>Bulan Lalu</option>
                                    <option value="custom" <?php echo e(($selectedDateFilter ?? '') == 'custom' ? 'selected' : ''); ?>>Custom</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-600 dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="relative custom-dropdown">
                                <select name="status" onchange="this.form.submit()" class="h-11 pl-3 pr-8 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm appearance-none bg-white cursor-pointer">
                                    <option value="">Semua Status</option>
                                    <option value="Diterima" <?php echo e(($selectedStatus ?? '') == 'Diterima' ? 'selected' : ''); ?>>Diterima</option>
                                    <option value="Dikembalikan" <?php echo e(($selectedStatus ?? '') == 'Dikembalikan' ? 'selected' : ''); ?>>Dikembalikan</option>
                                    <option value="Ditolak" <?php echo e(($selectedStatus ?? '') == 'Ditolak' ? 'selected' : ''); ?>>Ditolak</option>
                                    <option value="Terlambat" <?php echo e(($selectedStatus ?? '') == 'Terlambat' ? 'selected' : ''); ?>>Terlambat</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-600 dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <?php if(($searchQuery || $selectedSektor || $selectedDateFilter || $selectedStatus) && ($selectedDateFilter ?? '') != 'custom'): ?>
                            <a href="<?php echo e(route('permohonan.index')); ?>" class="h-11 px-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 flex items-center text-sm font-medium transition-colors">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Reset
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Custom Date Range -->
                    <?php if(($selectedDateFilter ?? '') == 'custom'): ?>
                    <div class="bg-primary-50 border border-primary-200 rounded-lg p-4 mt-3">
                        <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                            <div class="flex items-center gap-2">
                                <label class="text-sm font-medium text-primary-700 flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Pilih Tanggal:
                                </label>
                                <input type="date" name="custom_date" value="<?php echo e($customDate ?? ''); ?>" 
                                       class="h-10 px-3 border border-primary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm bg-white">
                            </div>
                            <div class="flex gap-2">
                                <button type="submit" class="h-10 px-4 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm font-medium transition-colors flex items-center shadow-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                    Terapkan Filter
                                </button>
                                <a href="<?php echo e(route('permohonan.index')); ?>" class="h-10 px-4 bg-gray-500 text-white rounded-lg hover:bg-gray-600 text-sm font-medium transition-colors flex items-center shadow-sm">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Reset
                                </a>
                            </div>
                        </div>
                        <p class="text-xs text-primary-600 mt-2 flex items-center">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Pilih tanggal untuk memfilter data permohonan berdasarkan tanggal tersebut
                        </p>
                    </div>
                    <?php endif; ?>
                </form>
            </div>
            
            <!-- Right: Action Buttons -->
            <div class="flex flex-col gap-3 w-full xl:w-auto xl:min-w-0">
                <!-- Export Buttons -->
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="<?php echo e(route('permohonan.export.excel')); ?>" 
                       class="inline-flex items-center justify-center px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium transition-colors whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Excel
                    </a>
                    <a href="<?php echo e(route('permohonan.export.pdf')); ?>" 
                       class="inline-flex items-center justify-center px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-medium transition-colors whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        PDF Lengkap
                    </a>
                    <a href="<?php echo e(route('permohonan.export.pdf-compact')); ?>" 
                       class="inline-flex items-center justify-center px-3 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 text-sm font-medium transition-colors whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        PDF Ringkasan
                    </a>
                </div>
                
                <!-- Add Button -->
                <a href="<?php echo e(route('permohonan.create')); ?>" 
                   class="inline-flex items-center justify-center px-3 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm font-medium transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Permohonan
                </a>
            </div>
        </div>
        
        <!-- Active Filters Display -->
        <?php if($searchQuery || $selectedSektor || $selectedDateFilter): ?>
        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex flex-wrap gap-2">
                <?php if($searchQuery): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search: "<?php echo e($searchQuery); ?>"
                </span>
                <?php endif; ?>
                <?php if($selectedSektor): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Sektor: <?php echo e($selectedSektor); ?>

                </span>
                <?php endif; ?>
                <?php if($selectedDateFilter): ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <?php if($selectedDateFilter == 'custom'): ?>
                        Periode: <?php echo e($customDate ?? ''); ?>

                    <?php elseif($selectedDateFilter == 'today'): ?>
                        Periode: Hari Ini
                    <?php elseif($selectedDateFilter == 'yesterday'): ?>
                        Periode: Kemarin
                    <?php elseif($selectedDateFilter == 'this_week'): ?>
                        Periode: Minggu Ini
                    <?php elseif($selectedDateFilter == 'last_week'): ?>
                        Periode: Minggu Lalu
                    <?php elseif($selectedDateFilter == 'this_month'): ?>
                        Periode: Bulan Ini
                    <?php elseif($selectedDateFilter == 'last_month'): ?>
                        Periode: Bulan Lalu
                    <?php else: ?>
                        Periode: <?php echo e($selectedDateFilter ?? 'Periode Tidak Diketahui'); ?>

                    <?php endif; ?>
                </span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Tabel Permohonan -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-primary-50 to-primary-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Daftar Permohonan
                </h3>
                <span class="bg-primary-100 text-primary-800 text-sm font-medium px-3 py-1 rounded-full"><?php echo e($permohonans->count()); ?> Data</span>
            </div>
        </div>
        
        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No. Permohonan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Usaha</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Sektor</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Verifikasi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $permohonans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permohonan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        $isOverdue = $permohonan && $permohonan->status === 'Dikembalikan' && $permohonan->isOverdue();
                        $rowClass = $isOverdue ? 'bg-red-50 hover:bg-red-100 border-l-4 border-red-500' : 'hover:bg-primary-50';
                    ?>
                    <tr class="<?php echo e($rowClass); ?> transition-colors duration-200">
                        <!-- No. Permohonan -->
                        <td class="px-4 py-4 text-sm font-medium text-gray-900">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-primary-500 rounded-full mr-3"></div>
                                <span class="font-mono text-xs"><?php echo e($permohonan?->no_permohonan ?? '-'); ?></span>
                            </div>
                        </td>
                        <!-- Nama Usaha -->
                        <td class="px-4 py-4 text-sm text-gray-900">
                            <div class="max-w-xs">
                                <p class="font-medium text-gray-900 truncate"><?php echo e($permohonan?->nama_usaha ?? '-'); ?></p>
                            </div>
                        </td>
                        <!-- Sektor -->
                        <td class="px-4 py-4 text-sm">
                            <?php if($permohonan && $permohonan->sektor): ?>
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                    <?php echo e($permohonan->sektor); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-gray-400 text-xs">-</span>
                            <?php endif; ?>
                        </td>
                        <!-- Status -->
                        <td class="px-4 py-4 text-sm">
                            <?php
                                $status = ($permohonan && $permohonan->status) ? $permohonan->status : 'Menunggu';
                                $statusColors = [
                                    'Diterima' => 'bg-green-100 text-green-800',
                                    'Dikembalikan' => 'bg-yellow-100 text-yellow-800',
                                    'Ditolak' => 'bg-red-100 text-red-800',
                                    'Menunggu' => 'bg-primary-100 text-primary-800'
                                ];
                                $statusColor = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                                
                                // Jika status Dikembalikan dan terlambat, ubah ke warna merah penuh
                                if ($status === 'Dikembalikan' && $permohonan->isOverdue()) {
                                    $statusColor = 'bg-red-500 text-white';
                                }
                            ?>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium <?php echo e($statusColor); ?>">
                                <?php echo e($status); ?>

                            </span>
                        </td>
                        <!-- Verifikasi -->
                        <td class="px-4 py-4 text-sm">
                            <div class="space-y-1">
                                <?php if($permohonan && ($permohonan->verifikasi_pd_teknis ?? '') == 'Berkas Disetujui'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        ✓ PD Teknis
                                    </span>
                                <?php elseif($permohonan && ($permohonan->verifikasi_pd_teknis ?? '') == 'Berkas Diperbaiki'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                        ⚠ PD Teknis
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                        - PD Teknis
                                    </span>
                                <?php endif; ?>
                                
                                <?php if($permohonan && ($permohonan->verifikasi_dpmptsp ?? '') == 'Berkas Disetujui'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        ✓ DPMPTSP
                                    </span>
                                <?php elseif($permohonan && ($permohonan->verifikasi_dpmptsp ?? '') == 'Berkas Diperbaiki'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                        ⚠ DPMPTSP
                                    </span>
                                <?php elseif($permohonan && ($permohonan->verifikasi_dpmptsp ?? '') == 'Sudah Menghubungi Pemohon'): ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                        📞 DPMPTSP
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                        - DPMPTSP
                                    </span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <!-- Tanggal -->
                        <td class="px-4 py-4 text-sm text-gray-500">
                            <div class="flex flex-col">
                                <span class="text-xs"><?php echo e(($permohonan && $permohonan->created_at) ? $permohonan->created_at->setTimezone('Asia/Jakarta')->format('d M Y') : '-'); ?></span>
                            </div>
                        </td>
                        <!-- Aksi -->
                        <td class="px-4 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <?php if($permohonan): ?>
                                    <a href="<?php echo e(route('permohonan.show', $permohonan)); ?>" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-primary-700 bg-primary-100 rounded-lg hover:bg-primary-200 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Lihat
                                    </a>
                                    <a href="<?php echo e(route('permohonan.edit', $permohonan)); ?>" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-amber-700 bg-amber-100 rounded-lg hover:bg-amber-200 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                <?php else: ?>
                                    <span class="text-gray-400 text-xs">-</span>
                                <?php endif; ?>
                            </div>
                            
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <p class="text-gray-500 text-sm">Tidak ada data permohonan</p>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Mobile Card View -->
        <div class="lg:hidden">
            <div class="p-4 space-y-4">
                <?php $__empty_1 = true; $__currentLoopData = $permohonans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permohonan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $isOverdue = $permohonan && $permohonan->status === 'Dikembalikan' && $permohonan->isOverdue();
                    $cardClass = $isOverdue ? 'bg-red-50 border-red-200 border-l-4 border-l-red-500' : 'bg-white border-gray-200';
                ?>
                <div class="<?php echo e($cardClass); ?> rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 text-sm"><?php echo e($permohonan?->nama_usaha ?? '-'); ?></h4>
                            <p class="text-xs text-gray-500 font-mono mt-1"><?php echo e($permohonan?->no_permohonan ?? '-'); ?></p>
                        </div>
                        <?php
                            $status = ($permohonan && $permohonan->status) ? $permohonan->status : 'Menunggu';
                            $statusColors = [
                                'Diterima' => 'bg-green-100 text-green-800',
                                'Dikembalikan' => 'bg-yellow-100 text-yellow-800',
                                'Ditolak' => 'bg-red-100 text-red-800',
                                'Menunggu' => 'bg-primary-100 text-primary-800'
                            ];
                            $statusColor = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                            
                            // Jika status Dikembalikan dan terlambat, ubah ke warna merah penuh
                            if ($status === 'Dikembalikan' && $permohonan->isOverdue()) {
                                $statusColor = 'bg-red-500 text-white';
                            }
                        ?>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium <?php echo e($statusColor); ?>">
                            <?php echo e($status); ?>

                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Sektor</p>
                            <?php if($permohonan && $permohonan->sektor): ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-primary-100 text-primary-800">
                                    <?php echo e($permohonan->sektor); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-gray-400 text-xs">-</span>
                            <?php endif; ?>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tanggal</p>
                            <p class="text-xs text-gray-900"><?php echo e(($permohonan && $permohonan->created_at) ? $permohonan->created_at->setTimezone('Asia/Jakarta')->format('d M Y') : '-'); ?></p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-2">Verifikasi</p>
                        <div class="flex flex-wrap gap-2">
                            <?php if($permohonan && ($permohonan->verifikasi_pd_teknis ?? '') == 'Berkas Disetujui'): ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                    ✓ PD Teknis
                                </span>
                            <?php elseif($permohonan && ($permohonan->verifikasi_pd_teknis ?? '') == 'Berkas Diperbaiki'): ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                    ⚠ PD Teknis
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                    - PD Teknis
                                </span>
                            <?php endif; ?>
                            
                            <?php if($permohonan && ($permohonan->verifikasi_dpmptsp ?? '') == 'Berkas Disetujui'): ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                    ✓ DPMPTSP
                                </span>
                            <?php elseif($permohonan && ($permohonan->verifikasi_dpmptsp ?? '') == 'Berkas Diperbaiki'): ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                    ⚠ DPMPTSP
                                </span>
                            <?php elseif($permohonan && ($permohonan->verifikasi_dpmptsp ?? '') == 'Sudah Menghubungi Pemohon'): ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                    📞 DPMPTSP
                                </span>
                            <?php else: ?>
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                    - DPMPTSP
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="flex space-x-2 items-center">
                        <?php if($permohonan): ?>
                            <a href="<?php echo e(route('permohonan.show', $permohonan)); ?>" 
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-medium text-primary-700 bg-primary-100 rounded-lg hover:bg-primary-200 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat Detail
                            </a>
                            <a href="<?php echo e(route('permohonan.edit', $permohonan)); ?>" 
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-medium text-amber-700 bg-amber-100 rounded-lg hover:bg-amber-200 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-12">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-sm">Tidak ada data permohonan</p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <style>
        /* Custom dropdown styling */
        .custom-dropdown {
            position: relative;
        }
        
        .custom-dropdown select {
            background-image: none;
        }
        
        .custom-dropdown:hover .dropdown-arrow {
            color: #0E2A66;
            transform: translateY(1px);
        }
        
        .custom-dropdown select:focus + .dropdown-arrow {
            color: #0E2A66;
        }
        
        .dropdown-arrow {
            transition: all 0.2s ease;
        }
    </style>

    <script>
        // Handle date filter dropdown change
        document.addEventListener('DOMContentLoaded', function() {
            const dateFilterSelect = document.querySelector('select[name="date_filter"]');
            const customDateSection = document.querySelector('div:has(input[name="custom_date"])');
            
            if (dateFilterSelect) {
                dateFilterSelect.addEventListener('change', function() {
                    if (this.value === 'custom') {
                        // Show custom date section with animation
                        const customSection = document.querySelector('div:has(input[name="custom_date"])');
                        if (customSection) {
                            customSection.style.display = 'block';
                            customSection.style.opacity = '0';
                            customSection.style.transform = 'translateY(-10px)';
                            
                            setTimeout(() => {
                                customSection.style.transition = 'all 0.3s ease';
                                customSection.style.opacity = '1';
                                customSection.style.transform = 'translateY(0)';
                            }, 10);
                        }
                    } else {
                        // Hide custom date section
                        const customSection = document.querySelector('div:has(input[name="custom_date"])');
                        if (customSection) {
                            customSection.style.transition = 'all 0.3s ease';
                            customSection.style.opacity = '0';
                            customSection.style.transform = 'translateY(-10px)';
                            
                            setTimeout(() => {
                                customSection.style.display = 'none';
                            }, 300);
                        }
                    }
                });
            }
        });
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
<?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/permohonan/index.blade.php ENDPATH**/ ?>