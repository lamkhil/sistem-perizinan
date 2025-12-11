<x-sidebar-layout>
    <x-slot name="header">
        Daftar Permohonan
        @if(auth()->user() && auth()->user()->role === 'pd_teknis' && auth()->user()->sektor)
            - Sektor {{ auth()->user()->sektor }}
        @endif
    </x-slot>

    

    <!-- Header dengan Action Buttons -->
    <div class="mb-6 bg-white rounded-xl shadow-md border border-gray-200 p-6">
        <div class="flex flex-col xl:flex-row xl:items-start xl:justify-between gap-6">
            <!-- Left: Search dan Filter -->
            <div class="flex-1 min-w-0">
                <form method="GET" action="{{ route('permohonan.index') }}" class="space-y-4" id="filterForm">
                    <!-- Search Bar -->
                    <div class="flex gap-3">
                        <div class="flex-1">
                            <div class="flex h-11">
                                <input type="text" name="search" value="{{ $searchQuery ?? '' }}" 
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
                        <div class="flex gap-2 flex-wrap">
                            @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'dpmptsp']))
                            <!-- Filter Sektor dan Status - Sejajar Vertikal -->
                            <div class="flex flex-col gap-2">
                                <div class="relative custom-dropdown min-w-[150px] overflow-hidden">
                                    <select name="sektor" onchange="this.form.submit()" class="h-11 pl-3 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm appearance-none bg-white cursor-pointer w-full">
                                        <option value="">Semua Sektor</option>
                                        @foreach($sektors ?? [] as $sektor)
                                            <option value="{{ $sektor }}" {{ ($selectedSektor ?? '') == $sektor ? 'selected' : '' }}>
                                                {{ $sektor }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute top-0 bottom-0 right-0 flex items-center pr-3 pointer-events-none" style="width: 2.5rem; max-width: 100%;">
                                        <svg class="w-4 h-4 text-gray-600 dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                                
                                <div class="relative custom-dropdown min-w-[150px] overflow-hidden">
                                    <select name="status" onchange="this.form.submit()" class="h-11 pl-3 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm appearance-none bg-white cursor-pointer w-full">
                                        <option value="">Semua Status</option>
                                        <option value="Diterima" {{ ($selectedStatus ?? '') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                        <option value="Dikembalikan" {{ ($selectedStatus ?? '') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                        <option value="Ditolak" {{ ($selectedStatus ?? '') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        <option value="Menunggu" {{ ($selectedStatus ?? '') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                        <option value="Terlambat" {{ ($selectedStatus ?? '') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                                    </select>
                                    <div class="absolute top-0 bottom-0 right-0 flex items-center pr-3 pointer-events-none" style="width: 2.5rem; max-width: 100%;">
                                        <svg class="w-4 h-4 text-gray-600 dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            @else
                            <!-- Untuk role selain admin/dpmptsp, hanya tampilkan status -->
                            <div class="relative custom-dropdown min-w-[150px] overflow-hidden">
                                <select name="status" onchange="this.form.submit()" class="h-11 pl-3 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm appearance-none bg-white cursor-pointer w-full">
                                    <option value="">Semua Status</option>
                                    <option value="Diterima" {{ ($selectedStatus ?? '') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="Dikembalikan" {{ ($selectedStatus ?? '') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                                    <option value="Ditolak" {{ ($selectedStatus ?? '') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                    <option value="Menunggu" {{ ($selectedStatus ?? '') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                    <option value="Terlambat" {{ ($selectedStatus ?? '') == 'Terlambat' ? 'selected' : '' }}>Terlambat</option>
                                </select>
                                <div class="absolute top-0 bottom-0 right-0 flex items-center pr-3 pointer-events-none" style="width: 2.5rem; max-width: 100%;">
                                    <svg class="w-4 h-4 text-gray-600 dropdown-arrow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                            @endif
                            
                            <!-- Custom Date Range - Dikelompokkan dalam satu container -->
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-2 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg">
                                    <svg class="w-4 h-4 text-gray-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <label class="text-xs font-medium text-gray-700 whitespace-nowrap">Dari:</label>
                                    <input type="date" name="custom_date_from" value="{{ $customDateFrom ?? '' }}" 
                                           onchange="this.form.submit()"
                                           class="h-9 px-2 border border-gray-300 rounded focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm bg-white min-w-[140px]">
                                    <label class="text-xs font-medium text-gray-700 whitespace-nowrap ml-1">Sampai:</label>
                                    <input type="date" name="custom_date_to" value="{{ $customDateTo ?? '' }}" 
                                           onchange="this.form.submit()"
                                           class="h-9 px-2 border border-gray-300 rounded focus:ring-2 focus:ring-primary-500 focus:border-primary-500 text-sm bg-white min-w-[140px]">
                                </div>
                                @if($searchQuery || ($selectedSektor && auth()->user() && in_array(auth()->user()->role, ['admin', 'dpmptsp'])) || $customDateFrom || $customDateTo || $selectedStatus)
                                <a href="{{ route('permohonan.index', array_filter(['sektor' => (auth()->user() && in_array(auth()->user()->role, ['admin', 'dpmptsp']) && $selectedSektor) ? $selectedSektor : null])) }}" class="h-9 px-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 flex items-center justify-center text-sm font-medium transition-colors">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Reset
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            
            <!-- Right: Action Buttons -->
            <div class="flex flex-col gap-3 w-full xl:w-auto xl:min-w-0">
                <!-- Export Buttons -->
                <div class="flex flex-col sm:flex-row gap-2">
                    <a href="{{ route('permohonan.export.excel') }}" 
                       class="inline-flex items-center justify-center px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm font-medium transition-colors whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export Excel
                    </a>
                    <a href="{{ route('permohonan.export.pdf-landscape') }}" 
                       class="inline-flex items-center justify-center px-3 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 text-sm font-medium transition-colors whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export PDF
                    </a>
                </div>
                
                <!-- Add Button -->
                <a href="{{ route('permohonan.create') }}" 
                   class="inline-flex items-center justify-center px-3 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 text-sm font-medium transition-colors whitespace-nowrap">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Tambah Permohonan
                </a>
            </div>
        </div>
        
        <!-- Active Filters Display -->
        @if($searchQuery || ($selectedSektor && auth()->user() && in_array(auth()->user()->role, ['admin', 'dpmptsp'])) || $customDateFrom || $customDateTo)
        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex flex-wrap gap-2">
                @if($searchQuery)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search: "{{ $searchQuery }}"
                </span>
                @endif
                @if($selectedSektor && auth()->user() && in_array(auth()->user()->role, ['admin', 'dpmptsp']))
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Sektor: {{ $selectedSektor }}
                </span>
                @endif
                @if($customDateFrom || $customDateTo)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Periode: 
                    @if($customDateFrom && $customDateTo)
                        {{ \Carbon\Carbon::parse($customDateFrom)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($customDateTo)->format('d/m/Y') }}
                    @elseif($customDateFrom)
                        Dari {{ \Carbon\Carbon::parse($customDateFrom)->format('d/m/Y') }}
                    @elseif($customDateTo)
                        Sampai {{ \Carbon\Carbon::parse($customDateTo)->format('d/m/Y') }}
                    @endif
                </span>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Tabel Permohonan -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200" style="background-color: #F8FAFC;">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                    <svg class="w-5 h-5 text-gray-700 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Daftar Permohonan
                </h3>
                <span class="text-sm font-medium px-3 py-1 rounded-full" style="background-color: #E0E7FF; color: #3B82F6;">{{ $permohonans->count() }} Data</span>
            </div>
        </div>
        
        <!-- Desktop Table View -->
        <div class="hidden lg:block overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead style="background-color: #253B7E;">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #E0E7FF;">No. Permohonan</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #E0E7FF;">Nama Usaha</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #E0E7FF;">Sektor</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #E0E7FF;">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #E0E7FF;">Verifikasi</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #E0E7FF;">Tanggal</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider" style="color: #E0E7FF;">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($permohonans as $permohonan)
                    @php
                        // Tandai baris merah untuk semua data yang terlambat, tidak hanya saat status Dikembalikan
                        $isOverdue = $permohonan && $permohonan->isOverdue();
                        $rowClass = $isOverdue ? 'bg-red-50 hover:bg-red-100 border-l-4 border-red-500' : 'hover:bg-primary-50';
                    @endphp
                    <tr class="{{ $rowClass }} transition-colors duration-200">
                        <!-- No. Permohonan -->
                        <td class="px-4 py-4 text-sm font-medium text-gray-900">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-primary-500 rounded-full mr-3"></div>
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
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
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
                                    'Menunggu' => 'bg-blue-100 text-blue-800',
                                    'Terlambat' => 'bg-orange-100 text-orange-800'
                                ];
                                $statusColor = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                                
                                // Jika terlambat, ubah badge menjadi merah penuh apapun statusnya
                                if ($permohonan->isOverdue()) {
                                    $statusColor = 'bg-red-500 text-white';
                                }
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
                                <span class="text-xs">{{ ($permohonan && $permohonan->created_at) ? $permohonan->created_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y') : '-' }}</span>
                            </div>
                        </td>
                        <!-- Aksi -->
                        <td class="px-4 py-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                @if($permohonan)
                                    <a href="{{ route('permohonan.show', $permohonan) }}" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-primary-700 bg-primary-100 rounded-lg hover:bg-primary-200 transition-colors">
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
                @php
                    $isOverdue = $permohonan && $permohonan->isOverdue();
                    $cardClass = $isOverdue ? 'bg-red-50 border-red-200 border-l-4 border-l-red-500' : 'bg-white border-gray-200';
                @endphp
                <div class="{{ $cardClass }} rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
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
                                'Menunggu' => 'bg-blue-100 text-blue-800',
                                'Terlambat' => 'bg-orange-100 text-orange-800'
                            ];
                            $statusColor = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                            
                            // Jika terlambat, ubah badge menjadi merah penuh
                            if ($permohonan->isOverdue()) {
                                $statusColor = 'bg-red-500 text-white';
                            }
                        @endphp
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                            {{ $status }}
                        </span>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3 mb-4">
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Sektor</p>
                            @if($permohonan && $permohonan->sektor)
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-primary-100 text-primary-800">
                                    {{ $permohonan->sektor }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 mb-1">Tanggal</p>
                            <p class="text-xs text-gray-900">{{ ($permohonan && $permohonan->created_at) ? $permohonan->created_at->setTimezone('Asia/Jakarta')->locale('id')->translatedFormat('d M Y') : '-' }}</p>
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
                    
                    <div class="flex space-x-2 items-center">
                        @if($permohonan)
                            <a href="{{ route('permohonan.show', $permohonan) }}" 
                               class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-medium text-primary-700 bg-primary-100 rounded-lg hover:bg-primary-200 transition-colors">
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
        }
        
        .custom-dropdown select:focus ~ div .dropdown-arrow {
            color: #0E2A66;
        }
        
        .dropdown-arrow {
            transition: color 0.2s ease;
        }
        
        /* Pastikan arrow tidak keluar dari container */
        .custom-dropdown.overflow-hidden {
            overflow: hidden !important;
        }
        
        /* Pastikan arrow container tidak keluar dari batas */
        .custom-dropdown .absolute {
            right: 0 !important;
            max-width: 100% !important;
            box-sizing: border-box;
        }
        
        /* Pastikan select memiliki padding yang cukup */
        .custom-dropdown select {
            padding-right: 2.5rem !important;
        }
    </style>

    @php
        $successMessage = session('success');
        $errorMessages = $errors->any() ? $errors->all() : [];
    @endphp
    <script>
        // Script untuk custom date sudah tidak diperlukan karena langsung muncul

        // Tampilkan notifikasi success jika ada
        var successMessage = {!! $successMessage ? json_encode($successMessage) : 'null' !!};
        if (successMessage) {
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: successMessage,
                        timer: 4000,
                        timerProgressBar: true,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        toast: false,
                        position: 'center'
                    });
                } else {
                    alert(successMessage);
                }
            });
        }

        // Tampilkan notifikasi error jika ada
        var errorMessages = {!! json_encode($errorMessages) !!};
        if (errorMessages && errorMessages.length > 0) {
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Swal !== 'undefined') {
                    var errorHtml = '<ul class="text-left list-disc list-inside mt-2">';
                    errorMessages.forEach(function(error) {
                        errorHtml += '<li class="mb-1">' + error + '</li>';
                    });
                    errorHtml += '</ul>';
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        html: errorHtml,
                        showConfirmButton: true,
                        confirmButtonText: 'OK',
                        width: '500px'
                    });
                } else {
                    alert(errorMessages.join('\n'));
                }
            });
        }
    </script>
</x-sidebar-layout>
