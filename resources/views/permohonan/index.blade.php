<x-sidebar-layout>
    <x-slot name="header">Daftar Permohonan</x-slot>

    <!-- Export Buttons -->
    <div class="mb-4 flex flex-wrap gap-3">
        <a href="{{ route('permohonan.export.excel') }}" 
           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Ekspor Excel
        </a>
        <a href="{{ route('permohonan.export.pdf') }}" 
           class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Ekspor PDF Lengkap
        </a>
        <a href="{{ route('permohonan.export.pdf-compact') }}" 
           class="inline-flex items-center px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Ekspor PDF Ringkasan
        </a>
    </div>

    <!-- Search dan Filter -->
    <div class="mb-6 bg-white rounded-lg shadow-sm p-6">
        <form method="GET" action="{{ route('permohonan.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="flex">
                    <input type="text" name="search" value="{{ $searchQuery ?? '' }}" 
                           placeholder="Cari berdasarkan No. Permohonan atau Nama Usaha..."
                           class="flex-1 px-4 py-2 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-r-lg hover:bg-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Filter Sektor -->
            <div class="md:w-48">
                <select name="sektor" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Sektor</option>
                    @foreach($sektors ?? [] as $sektor)
                        <option value="{{ $sektor }}" {{ ($selectedSektor ?? '') == $sektor ? 'selected' : '' }}>
                            {{ $sektor }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Filter Periode -->
            <div class="md:w-48">
                <select name="date_filter" onchange="this.form.submit()" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Semua Periode</option>
                    <option value="today" {{ ($selectedDateFilter ?? '') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="yesterday" {{ ($selectedDateFilter ?? '') == 'yesterday' ? 'selected' : '' }}>Kemarin</option>
                    <option value="this_week" {{ ($selectedDateFilter ?? '') == 'this_week' ? 'selected' : '' }}>Minggu Ini</option>
                    <option value="last_week" {{ ($selectedDateFilter ?? '') == 'last_week' ? 'selected' : '' }}>Minggu Lalu</option>
                    <option value="this_month" {{ ($selectedDateFilter ?? '') == 'this_month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="last_month" {{ ($selectedDateFilter ?? '') == 'last_month' ? 'selected' : '' }}>Bulan Lalu</option>
                    <option value="custom" {{ ($selectedDateFilter ?? '') == 'custom' ? 'selected' : '' }}>Custom Range</option>
                </select>
            </div>
            
            <!-- Custom Date (muncul jika Custom Range dipilih) -->
            @if(($selectedDateFilter ?? '') == 'custom')
            <div class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1 md:w-48">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Tanggal</label>
                    <input type="date" name="custom_date" value="{{ $customDate ?? '' }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium transition-colors">
                        Filter
                    </button>
                    <a href="{{ route('permohonan.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 text-sm font-medium transition-colors">
                        Reset
                    </a>
                </div>
            </div>
            @endif
            
            <!-- Reset Filter (hanya muncul jika bukan custom range) -->
            @if(($searchQuery || $selectedSektor || $selectedDateFilter) && ($selectedDateFilter ?? '') != 'custom')
            <div>
                <a href="{{ route('permohonan.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Reset
                </a>
            </div>
            @endif
            
            <!-- Tambah Permohonan -->
            <div>
                <a href="{{ route('permohonan.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Permohonan
                </a>
            </div>
        </form>
    </div>

    <!-- Tabel Permohonan -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Daftar Permohonan
                    </h3>
                    @if($searchQuery || $selectedSektor || $selectedDateFilter)
                    <div class="mt-2 flex flex-wrap gap-2">
                        @if($searchQuery)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Search: "{{ $searchQuery }}"
                        </span>
                        @endif
                        @if($selectedSektor)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Sektor: {{ $selectedSektor }}
                        </span>
                        @endif
                        @if($selectedDateFilter)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            @if($selectedDateFilter == 'custom')
                                Periode: {{ $customDate ?? '' }}
                            @elseif($selectedDateFilter == 'today')
                                Periode: Hari Ini
                            @elseif($selectedDateFilter == 'yesterday')
                                Periode: Kemarin
                            @elseif($selectedDateFilter == 'this_week')
                                Periode: Minggu Ini
                            @elseif($selectedDateFilter == 'last_week')
                                Periode: Minggu Lalu
                            @elseif($selectedDateFilter == 'this_month')
                                Periode: Bulan Ini
                            @elseif($selectedDateFilter == 'last_month')
                                Periode: Bulan Lalu
                            @else
                                Periode: {{ $selectedDateFilter ?? 'Periode Tidak Diketahui' }}
                            @endif
                        </span>
                        @endif
                    </div>
                    @endif
                </div>
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                    {{ $permohonans->total() }} Data
                </span>
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
                    @forelse($permohonans as $permohonan)
                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                        <!-- No. Permohonan -->
                        <td class="px-4 py-4 text-sm font-medium text-gray-900">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                <span class="font-mono text-xs">{{ $permohonan?->no_permohonan ?? '-' }}</span>
                            </div>
                        </td>
                        <!-- Nama Usaha -->
                        <td class="px-4 py-4 text-sm text-gray-900">
                            <div class="max-w-xs">
                                <p class="font-medium text-gray-900 truncate">{{ $permohonan?->nama_usaha ?? '-' }}</p>
                            </div>
                        </td>
                        <!-- Sektor -->
                        <td class="px-4 py-4 text-sm">
                            @if($permohonan && $permohonan->sektor)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $permohonan->sektor }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <!-- Status -->
                        <td class="px-4 py-4 text-sm">
                            @php
                                $status = ($permohonan && $permohonan->status) ? $permohonan->status : 'Menunggu';
                                $statusColors = [
                                    'Diterima' => 'bg-green-100 text-green-800',
                                    'Dikembalikan' => 'bg-yellow-100 text-yellow-800',
                                    'Ditolak' => 'bg-red-100 text-red-800',
                                    'Menunggu' => 'bg-blue-100 text-blue-800'
                                ];
                                $statusColor = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                {{ $status }}
                            </span>
                        </td>
                        <!-- Verifikasi -->
                        <td class="px-4 py-4 text-sm">
                            <div class="space-y-1">
                                @if($permohonan && ($permohonan->verifikasi_pd_teknis ?? '') == 'Berkas Disetujui')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        ✓ PD Teknis
                                    </span>
                                @elseif($permohonan && ($permohonan->verifikasi_pd_teknis ?? '') == 'Berkas Diperbaiki')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                        ⚠ PD Teknis
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                        - PD Teknis
                                    </span>
                                @endif
                                
                                @if($permohonan && ($permohonan->verifikasi_dpmptsp ?? '') == 'Berkas Disetujui')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                        ✓ DPMPTSP
                                    </span>
                                @elseif($permohonan && ($permohonan->verifikasi_dpmptsp ?? '') == 'Berkas Diperbaiki')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                        ⚠ DPMPTSP
                                    </span>
                                @elseif($permohonan && ($permohonan->verifikasi_dpmptsp ?? '') == 'Sudah Menghubungi Pemohon')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                        📞 DPMPTSP
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                        - DPMPTSP
                                    </span>
                                @endif
                            </div>
                        </td>
                        <!-- Tanggal -->
                        <td class="px-4 py-4 text-sm text-gray-500">
                            <div class="flex flex-col">
                                <span class="text-xs">{{ ($permohonan && $permohonan->created_at) ? $permohonan->created_at->setTimezone('Asia/Jakarta')->format('d M Y') : '-' }}</span>
                            </div>
                        </td>
                        <!-- Aksi -->
                        <td class="px-4 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                @if($permohonan)
                                    <a href="{{ route('permohonan.show', $permohonan) }}" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Lihat
                                    </a>
                                    <a href="{{ route('permohonan.edit', $permohonan) }}" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-amber-700 bg-amber-100 rounded-lg hover:bg-amber-200 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
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
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Mobile Card View -->
        <div class="lg:hidden">
            <div class="p-4 space-y-4">
                @forelse($permohonans as $permohonan)
                <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <h4 class="font-semibold text-gray-900 text-sm">{{ $permohonan?->nama_usaha ?? '-' }}</h4>
                            <p class="text-xs text-gray-500 font-mono mt-1">{{ $permohonan?->no_permohonan ?? '-' }}</p>
                        </div>
                        @php
                            $status = ($permohonan && $permohonan->status) ? $permohonan->status : 'Menunggu';
                            $statusColors = [
                                'Diterima' => 'bg-green-100 text-green-800',
                                'Dikembalikan' => 'bg-yellow-100 text-yellow-800',
                                'Ditolak' => 'bg-red-100 text-red-800',
                                'Menunggu' => 'bg-blue-100 text-blue-800'
                            ];
                            $statusColor = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                            {{ $status }}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Sektor</p>
                            @if($permohonan && $permohonan->sektor)
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $permohonan->sektor }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tanggal</p>
                            <p class="text-xs text-gray-900">{{ ($permohonan && $permohonan->created_at) ? $permohonan->created_at->setTimezone('Asia/Jakarta')->format('d M Y') : '-' }}</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p class="text-xs text-gray-500 mb-2">Verifikasi</p>
                        <div class="flex flex-wrap gap-2">
                            @if($permohonan && ($permohonan->verifikasi_pd_teknis ?? '') == 'Berkas Disetujui')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                    ✓ PD Teknis
                                </span>
                            @elseif($permohonan && ($permohonan->verifikasi_pd_teknis ?? '') == 'Berkas Diperbaiki')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                    ⚠ PD Teknis
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                    - PD Teknis
                                </span>
                            @endif
                            
                            @if($permohonan && ($permohonan->verifikasi_dpmptsp ?? '') == 'Berkas Disetujui')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                    ✓ DPMPTSP
                                </span>
                            @elseif($permohonan && ($permohonan->verifikasi_dpmptsp ?? '') == 'Berkas Diperbaiki')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                    ⚠ DPMPTSP
                                </span>
                            @elseif($permohonan && ($permohonan->verifikasi_dpmptsp ?? '') == 'Sudah Menghubungi Pemohon')
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                    📞 DPMPTSP
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-600">
                                    - DPMPTSP
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex space-x-2">
                        @if($permohonan)
                            <a href="{{ route('permohonan.show', $permohonan) }}" 
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-medium text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat Detail
                            </a>
                            <a href="{{ route('permohonan.edit', $permohonan) }}" 
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-medium text-amber-700 bg-amber-100 rounded-lg hover:bg-amber-200 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                        @endif
                    </div>
                </div>
                @empty
                <div class="text-center py-12">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="text-gray-500 text-sm">Tidak ada data permohonan</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-sidebar-layout>
