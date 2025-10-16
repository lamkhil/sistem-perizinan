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

    

    <!-- Header Section -->
    <div class="mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-primary rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Statistik Permohonan</h1>
                        <p class="text-gray-600">Visualisasi data permohonan dalam bentuk grafik</p>
                        <?php if($selectedDateFilter): ?>
                        <div class="mt-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-primary-100 text-primary-800">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                        </div>
                        <?php endif; ?>
                    </div>
                    </div>
                    <div>
                        <form method="GET" action="<?php echo e(route('statistik')); ?>" class="flex items-end gap-3">
                            <div class="md:w-48">
                                <select name="date_filter" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
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
                            <?php if(($selectedDateFilter ?? '') == 'custom'): ?>
                            <div class="flex items-end gap-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal</label>
                                    <input type="date" name="custom_date" value="<?php echo e($customDate ?? ''); ?>" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                                </div>
                                <div class="pb-0.5 flex gap-2">
                                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm font-medium">Filter</button>
                                    <a href="<?php echo e(route('statistik')); ?>" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 text-sm font-medium">Reset</a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
            <div class="bg-gradient-to-r from-primary-50 to-primary-100 px-6 py-4 border-b border-gray-200">
                <h2 class="text-xl font-bold text-gray-900">Distribusi Status Permohonan</h2>
                <p class="text-gray-600 text-sm">Visualisasi data dalam bentuk pie chart</p>
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

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    
    <script>
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

        // Registrasi plugin datalabels
        Chart.register(ChartDataLabels);

        // Inisialisasi chart
        const ctx = document.getElementById('permohonanChart').getContext('2d');
        new Chart(ctx, config);

        // Responsive handling
        window.addEventListener('resize', function() {
            const chart = Chart.getChart('permohonanChart');
            if (chart) {
                chart.resize();
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
<?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/statistik.blade.php ENDPATH**/ ?>