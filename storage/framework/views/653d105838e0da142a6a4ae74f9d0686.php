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
     <?php $__env->slot('header', null, []); ?> Statistik Permohonan <?php $__env->endSlot(); ?>

    


        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Permohonan</dt>
                                <dd class="text-lg font-medium text-gray-900"><?php echo e($stats['totalPermohonan'] ?? 0); ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Diterima</dt>
                                <dd class="text-lg font-medium text-gray-900"><?php echo e($stats['diterima'] ?? 0); ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Dikembalikan</dt>
                                <dd class="text-lg font-medium text-gray-900"><?php echo e($stats['dikembalikan'] ?? 0); ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Ditolak</dt>
                                <dd class="text-lg font-medium text-gray-900"><?php echo e($stats['ditolak'] ?? 0); ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-orange-500 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Terlambat</dt>
                                <dd class="text-lg font-medium text-gray-900"><?php echo e($stats['terlambat'] ?? 0); ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-primary-50 to-primary-100 px-4 sm:px-6 py-4 border-b border-gray-200">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h2 class="text-lg sm:text-xl font-bold text-gray-900">Distribusi Status Permohonan</h2>
                        <p class="text-gray-600 text-xs sm:text-sm">Visualisasi data dalam bentuk pie chart</p>
                    </div>
                    <div class="w-full lg:w-auto">
                        <form method="GET" action="<?php echo e(route('statistik')); ?>" class="space-y-4">
                            <div class="flex items-end gap-3 flex-wrap">
                                <?php if(in_array($user->role ?? auth()->user()->role, ['dpmptsp', 'admin'])): ?>
                                <div class="w-full sm:w-auto sm:min-w-[280px] md:min-w-[320px] lg:min-w-[360px]">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Filter Sektor</label>
                                    <select name="sektor" id="sektor-filter" onchange="updateFormOnChange()" class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                        <option value="">Semua Sektor</option>
                                        <?php $__currentLoopData = $sektors ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($code); ?>" <?php echo e(($selectedSektor ?? '') == $code ? 'selected' : ''); ?>><?php echo e($name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <?php endif; ?>
                                <div class="w-full sm:w-auto sm:min-w-[200px] md:min-w-[220px]">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Filter Periode</label>
                                    <select name="date_filter" id="date-filter" onchange="updateFormOnChange()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                                        <option value="">Semua Periode</option>
                                        <option value="today" <?php echo e(($selectedDateFilter ?? '') == 'today' ? 'selected' : ''); ?>>Hari Ini</option>
                                        <option value="yesterday" <?php echo e(($selectedDateFilter ?? '') == 'yesterday' ? 'selected' : ''); ?>>Kemarin</option>
                                        <option value="this_week" <?php echo e(($selectedDateFilter ?? '') == 'this_week' ? 'selected' : ''); ?>>Minggu Ini</option>
                                        <option value="last_week" <?php echo e(($selectedDateFilter ?? '') == 'last_week' ? 'selected' : ''); ?>>Minggu Lalu</option>
                                        <option value="this_month" <?php echo e(($selectedDateFilter ?? '') == 'this_month' ? 'selected' : ''); ?>>Bulan Ini</option>
                                        <option value="last_month" <?php echo e(($selectedDateFilter ?? '') == 'last_month' ? 'selected' : ''); ?>>Bulan Lalu</option>
                                        <option value="custom" <?php echo e(($selectedDateFilter ?? '') == 'custom' ? 'selected' : ''); ?>>Custom</option>
                                    </select>
                                </div>
                                <?php if(($selectedSektor ?? '') || ($selectedDateFilter ?? '')): ?>
                                <div class="w-full sm:w-auto pb-0.5">
                                    <a href="<?php echo e(route('statistik')); ?>" class="w-full sm:w-auto px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 text-sm font-medium inline-block text-center">Reset Semua</a>
                                </div>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Custom Date Range -->
                            <?php if(($selectedDateFilter ?? '') == 'custom'): ?>
                            <div class="bg-primary-50 border border-primary-200 rounded-lg p-4">
                                <div class="flex flex-col sm:flex-row gap-3 items-start sm:items-center">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <label class="text-sm font-medium text-primary-700 flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Dari Tanggal:
                                        </label>
                                        <input type="date" name="custom_date_from" value="<?php echo e($customDateFrom ?? ''); ?>" 
                                               class="h-10 px-3 border border-primary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm bg-white">
                                    </div>
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <label class="text-sm font-medium text-primary-700 flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            Sampai Tanggal:
                                        </label>
                                        <input type="date" name="custom_date_to" value="<?php echo e($customDateTo ?? ''); ?>" 
                                               class="h-10 px-3 border border-primary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm bg-white">
                                    </div>
                                    <div class="flex gap-2">
                                        <button type="submit" class="h-10 px-4 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm font-medium transition-colors flex items-center shadow-sm">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                            </svg>
                                            Terapkan Filter
                                        </button>
                                        <a href="<?php echo e(route('statistik', array_filter(['sektor' => $selectedSektor ?? '']))); ?>" class="h-10 px-4 bg-gray-500 text-white rounded-lg hover:bg-gray-600 text-sm font-medium transition-colors flex items-center shadow-sm">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Reset Tanggal
                                        </a>
                                    </div>
                                </div>
                                <p class="text-xs text-primary-600 mt-2 flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Pilih range tanggal (dari tanggal sampai tanggal) untuk memfilter data statistik
                                </p>
                            </div>
                            <?php endif; ?>
                        </form>
                        <script>
                            function updateFormOnChange() {
                                // Submit form saat dropdown berubah, mempertahankan semua parameter
                                document.querySelector('form').submit();
                            }
                        </script>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex items-center justify-center">
                    <!-- Legend di sebelah kiri dengan padding -->
                    <div class="flex flex-col space-y-4 w-1/4 pl-8">
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-blue-500 rounded-full"></div>
                            <span class="text-sm font-medium text-gray-700">Total Permohonan</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                            <span class="text-sm font-medium text-gray-700">Diterima</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                            <span class="text-sm font-medium text-gray-700">Dikembalikan</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                            <span class="text-sm font-medium text-gray-700">Ditolak</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-4 h-4 bg-orange-500 rounded-full"></div>
                            <span class="text-sm font-medium text-gray-700">Terlambat</span>
                        </div>
                    </div>
                    
                    <!-- Chart di tengah -->
                    <div class="w-3/4 flex justify-center">
                        <div class="w-full max-w-md">
                            <canvas id="permohonanChart" width="400" height="400"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-8 flex justify-center">
            <a href="<?php echo e(route('dashboard')); ?>" 
               class="inline-flex items-center px-6 py-3 bg-gradient-primary text-white font-medium rounded-lg hover:opacity-95 transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

    <script>
        // Tunggu sampai Chart.js tersedia
        function initChart() {
            // Cek apakah Chart sudah tersedia
            if (typeof Chart === 'undefined' || typeof ChartDataLabels === 'undefined') {
                // Jika belum, coba lagi setelah 100ms
                setTimeout(initChart, 100);
                return;
            }

            // Data untuk chart dari PHP
            const statsData = JSON.parse('<?php echo json_encode($stats); ?>');

            // Data untuk chart
            const chartData = {
                labels: ['Total Permohonan', 'Diterima', 'Dikembalikan', 'Ditolak', 'Terlambat'],
                datasets: [{
                    data: [
                        statsData.totalPermohonan,
                        statsData.diterima,
                        statsData.dikembalikan,
                        statsData.ditolak,
                        statsData.terlambat
                    ],
                    backgroundColor: [
                        '#60A5FA',
                        '#34D399',
                        '#FBBF24',
                        '#F87171',
                        '#FB923C'
                    ],
                    borderColor: [
                        '#3B82F6',
                        '#10B981',
                        '#F59E0B',
                        '#EF4444',
                        '#F97316'
                    ],
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            };

            // Konfigurasi chart
            const config = {
                type: 'pie',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false  // Menyembunyikan legend default karena sudah ada di sebelah kiri
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        },
                        datalabels: {
                            display: true,
                            color: 'white',
                            font: {
                                weight: 'bold',
                                size: 14
                            },
                            formatter: function(value, context) {
                                // Jangan tampilkan label jika nilai 0
                                if (value === 0 || value === null || value === undefined) {
                                    return '';
                                }
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return percentage + '%';
                            }
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 2000,
                        easing: 'easeOutQuart'
                    }
                }
            };

            // Registrasi plugin datalabels (jika belum terdaftar)
            // Chart.js akan otomatis menangani duplikasi registrasi
            if (ChartDataLabels) {
                try {
                    Chart.register(ChartDataLabels);
                } catch (e) {
                    // Plugin mungkin sudah terdaftar, abaikan error
                    console.log('ChartDataLabels plugin already registered or error:', e);
                }
            }

            // Inisialisasi chart
            const ctx = document.getElementById('permohonanChart');
            if (ctx) {
                new Chart(ctx, config);

                // Responsive handling
                window.addEventListener('resize', function() {
                    const chart = Chart.getChart('permohonanChart');
                    if (chart) {
                        chart.resize();
                    }
                });
            }
        }

        // Mulai inisialisasi saat DOM ready
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initChart);
        } else {
            initChart();
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
<?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/statistik.blade.php ENDPATH**/ ?>