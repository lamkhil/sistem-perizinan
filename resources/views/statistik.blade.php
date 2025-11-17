<x-sidebar-layout>
    <x-slot name="header">Statistik Permohonan</x-slot>

    


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
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['totalPermohonan'] ?? 0 }}</dd>
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
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['diterima'] ?? 0 }}</dd>
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
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['dikembalikan'] ?? 0 }}</dd>
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
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['ditolak'] ?? 0 }}</dd>
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
                                <dd class="text-lg font-medium text-gray-900">{{ $stats['terlambat'] ?? 0 }}</dd>
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
                        <form method="GET" action="{{ route('statistik') }}" class="flex items-end gap-3 flex-wrap">
                            @if(in_array($user->role ?? auth()->user()->role, ['dpmptsp', 'admin']))
                            <div class="w-full sm:w-auto sm:min-w-[280px] md:min-w-[320px] lg:min-w-[360px]">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Filter Sektor</label>
                                <select name="sektor" id="sektor-filter" onchange="updateFormOnChange()" class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap;">
                                    <option value="">Semua Sektor</option>
                                    @foreach($sektors ?? [] as $code => $name)
                                        <option value="{{ $code }}" {{ ($selectedSektor ?? '') == $code ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="w-full sm:w-auto sm:min-w-[200px] md:min-w-[220px]">
                                <label class="block text-xs font-medium text-gray-700 mb-1">Filter Periode</label>
                                <select name="date_filter" id="date-filter" onchange="updateFormOnChange()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                                    <option value="">Semua Periode</option>
                                    <option value="today" {{ ($selectedDateFilter ?? '') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                                    <option value="yesterday" {{ ($selectedDateFilter ?? '') == 'yesterday' ? 'selected' : '' }}>Kemarin</option>
                                    <option value="this_week" {{ ($selectedDateFilter ?? '') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                                    <option value="last_week" {{ ($selectedDateFilter ?? '') == 'last_week' ? 'selected' : '' }}>Minggu Lalu</option>
                                    <option value="this_month" {{ ($selectedDateFilter ?? '') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                                    <option value="last_month" {{ ($selectedDateFilter ?? '') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                                    <option value="custom" {{ ($selectedDateFilter ?? '') == 'custom' ? 'selected' : '' }}>Custom</option>
                                </select>
                            </div>
                            @if(($selectedDateFilter ?? '') == 'custom')
                            <div class="w-full sm:w-auto flex items-end gap-2 flex-wrap">
                                <div class="flex-1 sm:flex-none">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal</label>
                                    <input type="date" name="custom_date" value="{{ $customDate ?? '' }}" class="w-full sm:w-auto px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm">
                                </div>
                                <div class="pb-0.5 flex gap-2 w-full sm:w-auto">
                                    <button type="submit" class="flex-1 sm:flex-none px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm font-medium">Filter</button>
                                    <a href="{{ route('statistik', ['sektor' => $selectedSektor ?? '']) }}" class="flex-1 sm:flex-none px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 text-sm font-medium text-center">Reset</a>
                                </div>
                            </div>
                            @endif
                            @if(($selectedSektor ?? '') || ($selectedDateFilter ?? ''))
                            <div class="w-full sm:w-auto pb-0.5">
                                <a href="{{ route('statistik') }}" class="w-full sm:w-auto px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 text-sm font-medium inline-block text-center">Reset Semua</a>
                            </div>
                            @endif
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
            <a href="{{ route('dashboard') }}" 
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
            const statsData = JSON.parse('{!! json_encode($stats) !!}');

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
</x-sidebar-layout>
