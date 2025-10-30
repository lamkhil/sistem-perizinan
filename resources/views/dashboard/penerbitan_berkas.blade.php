<x-sidebar-layout>
    <x-slot name="header">
        Dashboard Penerbitan Berkas
    </x-slot>

    @section('head')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            /* Remove default select arrow in all browsers */
            select.custom-select {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background-image: none;
            }
            select.custom-select::-ms-expand {
                display: none; /* IE 10+ */
            }
        </style>
    @endsection

    <!-- Header dengan Judul Laporan -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-center text-gray-900 mb-2">
            PERIZINAN BERUSAHA DISETUJUI
        </h1>
        <h2 class="text-xl font-semibold text-center text-gray-800 mb-1">
            DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU
        </h2>
        <h3 class="text-lg font-medium text-center text-gray-700">
            KOTA SURABAYA TAHUN {{ date('Y') }}
        </h3>
    </div>

            <!-- Notifikasi Success/Error -->
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <span class="font-medium">Terjadi kesalahan:</span>
                            <ul class="mt-1 list-disc list-inside text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif


            <!-- Tabel Data Permohonan -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 mb-8">
                <div class="px-6 py-5 border-b border-gray-200" style="background-color: #F8FAFC;">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:gap-8">
                        <div class="flex items-center gap-4 flex-shrink-0">
                            <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                                 <svg class="w-6 h-6 text-gray-700 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                 </svg>
                                 Data Permohonan
                            </h3>
                            <!-- Export Buttons -->
                            <div class="flex gap-3 flex-shrink-0 flex-wrap">
                                <!-- Kolom kiri: Excel -->
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('penerbitan-berkas.export.excel') }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors text-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Export Excel (Semua)
                                    </a>
                                    <a href="{{ route('penerbitan-berkas.export.excel', request()->only(['date_filter','custom_date'])) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-emerald-600 text-white rounded-md hover:bg-emerald-700 transition-colors text-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Export Excel (Per Tanggal)
                                    </a>
                                </div>

                                <!-- Kolom kanan: PDF -->
                                <div class="flex flex-col gap-2">
                                    <a href="{{ route('penerbitan-berkas.export.pdf.landscape') }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors text-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Export PDF (Semua)
                                    </a>
                                    <a href="{{ route('penerbitan-berkas.export.pdf.landscape', request()->only(['date_filter','custom_date'])) }}" 
                                       class="inline-flex items-center px-3 py-1.5 bg-violet-600 text-white rounded-md hover:bg-violet-700 transition-colors text-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Export PDF (Per Tanggal)
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Filter Section - Vertical Stacked Layout -->
                        <div class="w-full">
                            <form method="GET" action="{{ route('penerbitan-berkas') }}" class="flex flex-col gap-3">
                                <!-- Row 1: Per Page & Date Filter -->
                                <div class="flex items-center gap-3">
                                    <div class="relative inline-block w-auto">
                                        <select name="per_page" onchange="this.form.submit()" class="custom-select w-full pl-4 pr-12 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm bg-white cursor-pointer" style="min-width: 170px; background-image: none !important;">
                                            <option value="10" @selected(($perPage ?? 20)==10)>10 per halaman</option>
                                            <option value="20" @selected(($perPage ?? 20)==20)>20 per halaman</option>
                                            <option value="50" @selected(($perPage ?? 20)==50)>50 per halaman</option>
                                            <option value="100" @selected(($perPage ?? 20)==100)>100 per halaman</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-600">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    <div class="relative inline-block w-auto">
                                        <select name="date_filter" onchange="this.form.submit()" class="custom-select w-full pl-4 pr-12 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm bg-white cursor-pointer" style="min-width: 180px; background-image: none !important;">
                                            <option value="">Semua Periode</option>
                                            <option value="today" @selected(($selectedDateFilter ?? '')==='today')>Hari Ini</option>
                                            <option value="yesterday" @selected(($selectedDateFilter ?? '')==='yesterday')>Kemarin</option>
                                            <option value="this_week" @selected(($selectedDateFilter ?? '')==='this_week')>Minggu Ini</option>
                                            <option value="last_week" @selected(($selectedDateFilter ?? '')==='last_week')>Minggu Lalu</option>
                                            <option value="this_month" @selected(($selectedDateFilter ?? '')==='this_month')>Bulan Ini</option>
                                            <option value="last_month" @selected(($selectedDateFilter ?? '')==='last_month')>Bulan Lalu</option>
                                            <option value="custom" @selected(($selectedDateFilter ?? '')==='custom')>Custom</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-600">
                                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </div>
                                    
                                    @if(($selectedDateFilter ?? '')==='custom')
                                    <input type="date" name="custom_date" value="{{ $customDate ?? '' }}" onchange="this.form.submit()" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm cursor-pointer" />
                                    @endif
                                </div>
                                
                                <!-- Row 2: Search & Buttons -->
                                <div class="flex items-center gap-3">
                                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari berdasarkan No. Permohonan atau Nama Usaha..." class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm" />
                                    
                                    <button type="submit" class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 flex items-center justify-center text-sm whitespace-nowrap">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        Cari
                                    </button>
                                    
                                    <a href="{{ route('penerbitan-berkas') }}" class="px-5 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 text-sm whitespace-nowrap flex items-center justify-center">
                                        Reset
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead style="background-color: #253B7E;">
                                <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 3%; color: #E0E7FF;">NO</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 12%; color: #E0E7FF;">NO. PERMOHONAN</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 12%; color: #E0E7FF;">NO. PROYEK</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 10%; color: #E0E7FF;">TANGGAL PERMOHONAN</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 8%; color: #E0E7FF;">NIB</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 6%; color: #E0E7FF;">KBLI</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 12%; color: #E0E7FF;">NAMA USAHA</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 12%; color: #E0E7FF;">KEGIATAN</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 8%; color: #E0E7FF;">JENIS PERUSAHAAN</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 10%; color: #E0E7FF;">PEMILIK</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 8%; color: #E0E7FF;">MODAL USAHA</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 12%; color: #E0E7FF;">ALAMAT</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 6%; color: #E0E7FF;">JENIS PROYEK</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 12%; color: #E0E7FF;">NAMA PERIZINAN</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 8%; color: #E0E7FF;">SKALA USAHA</th>
                                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 8%; color: #E0E7FF;">RISIKO</th>
                                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 15%; color: #E0E7FF;">PEMROSES DAN TGL. E SURAT DAN TGL PERTEK</th>
                                  @if(in_array(auth()->user() && auth()->user()->role, ['admin', 'penerbitan_berkas']))
                                  <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="width: 8%; color: #E0E7FF;">AKSI</th>
                                  @endif
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @if($permohonans->count() > 0)
                                @foreach($permohonans as $index => $permohonan)
                                <tr class="hover:bg-primary-50 transition-colors duration-200">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-primary-500 rounded-full mr-3"></div>
                                            {{ (($permohonans->firstItem() ?? 1) + $index) }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="font-mono text-xs">{{ $permohonan->no_permohonan ?? '-' }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="font-mono text-xs">{{ $permohonan->no_proyek ?? '-' }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $permohonan->tanggal_permohonan ? \Carbon\Carbon::parse($permohonan->tanggal_permohonan)->format('d F Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="font-mono text-xs">{{ $permohonan->nib ?? '-' }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <span class="font-mono text-xs">{{ $permohonan->kbli ?? '-' }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="max-w-xs">
                                            <p class="font-medium text-gray-900 truncate">{{ $permohonan->nama_usaha ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="max-w-xs">
                                            <p class="text-gray-900 truncate">{{ $permohonan->inputan_teks ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        @if($permohonan->jenis_pelaku_usaha)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-800">
                                                {{ $permohonan->jenis_pelaku_usaha }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="max-w-xs">
                                            <p class="text-gray-900 truncate">{{ $permohonan->pemilik ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($permohonan->modal_usaha)
                                            <span class="font-mono text-xs">Rp {{ number_format($permohonan->modal_usaha, 0, ',', '.') }}</span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="max-w-xs">
                                            <p class="text-gray-900 truncate">{{ $permohonan->alamat_perusahaan ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        @if($permohonan->jenis_proyek)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                {{ $permohonan->jenis_proyek }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="max-w-xs">
                                            <p class="text-gray-900 truncate">{{ $permohonan->nama_perizinan ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        @if($permohonan->skala_usaha)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $permohonan->skala_usaha }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        @if($permohonan->risiko)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $permohonan->getRisikoBadgeClass() }}">
                                                {{ $permohonan->risiko }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="text-xs">
                                            <p class="font-medium">DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</p>
                                            <p class="font-mono">No: BAP/OSS/IX/{{ $permohonan->no_permohonan ?? 'N/A' }}/436.7.15/{{ date('Y') }}</p>
                                            <p class="text-gray-600">tanggal BAP: {{ date('d F Y') }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if(in_array(auth()->user() && auth()->user()->role, ['admin', 'penerbitan_berkas']))
                                        <div class="flex items-center space-x-2">
                                            <!-- Edit Button -->
                                            <button data-edit-id="{{ $permohonan->id }}" 
                                                    class="edit-btn inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                                Edit
                                            </button>
                                            
                                            <!-- Delete Button -->
                                            <button data-delete-id="{{ $permohonan->id }}" 
                                                    class="delete-btn inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                        @if($permohonan->created_at)
                                        <div class="mt-1 text-[10px] text-gray-500">Dibuat: {{ $permohonan->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y') }}</div>
                                        @endif
                                        @else
                                        <span class="text-gray-400 text-xs">Tidak ada akses</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="{{ in_array(auth()->user() && auth()->user()->role, ['admin', 'penerbitan_berkas']) ? '18' : '17' }}" class="px-4 py-8 text-center text-sm text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada data permohonan</h3>
                                            <p class="mt-1 text-sm text-gray-500">Belum ada data permohonan yang tersedia.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination -->
                    <div class="px-6 py-4 border-t border-gray-200 bg-white">
                        {{ $permohonans->appends(request()->query())->links() }}
                    </div>
                </div>

            <!-- Form Input Data Baru -->
            @if(in_array(auth()->user() && auth()->user()->role, ['admin', 'penerbitan_berkas']))
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-8">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 mb-6 -m-6">
                    <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Data Permohonan Baru
                    </h3>
                </div>
                
                <form method="POST" action="{{ route('penerbitan-berkas.store') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- No. Permohonan -->
                        <div>
                            <x-input-label for="no_permohonan" value="No. Permohonan" />
                            <x-text-input id="no_permohonan" class="block mt-1 w-full" type="text" name="no_permohonan" :value="old('no_permohonan')" required />
                            <x-input-error :messages="$errors->get('no_permohonan')" class="mt-2" />
                        </div>

                        <!-- No. Proyek -->
                        <div>
                            <x-input-label for="no_proyek" value="No. Proyek" />
                            <x-text-input id="no_proyek" class="block mt-1 w-full" type="text" name="no_proyek" :value="old('no_proyek')" required />
                            <x-input-error :messages="$errors->get('no_proyek')" class="mt-2" />
                        </div>

                        <!-- Tanggal Permohonan -->
                        <div>
                            <x-input-label for="tanggal_permohonan" value="Tanggal Permohonan" />
                            <x-text-input id="tanggal_permohonan" class="block mt-1 w-full" type="date" name="tanggal_permohonan" :value="old('tanggal_permohonan')" required />
                            <x-input-error :messages="$errors->get('tanggal_permohonan')" class="mt-2" />
                        </div>

                        <!-- NIB -->
                        <div>
                            <x-input-label for="nib" value="NIB" />
                            <x-text-input id="nib" class="block mt-1 w-full" type="text" name="nib" :value="old('nib')" required />
                            <x-input-error :messages="$errors->get('nib')" class="mt-2" />
                        </div>

                        <!-- KBLI -->
                        <div>
                            <x-input-label for="kbli" value="KBLI" />
                            <x-text-input id="kbli" class="block mt-1 w-full" type="text" name="kbli" :value="old('kbli')" required />
                            <x-input-error :messages="$errors->get('kbli')" class="mt-2" />
                        </div>

                        <!-- Nama Usaha -->
                        <div>
                            <x-input-label for="nama_usaha" value="Nama Usaha" />
                            <x-text-input id="nama_usaha" class="block mt-1 w-full" type="text" name="nama_usaha" :value="old('nama_usaha')" required />
                            <x-input-error :messages="$errors->get('nama_usaha')" class="mt-2" />
                        </div>

                        <!-- Kegiatan -->
                        <div>
                            <x-input-label for="inputan_teks" value="Kegiatan" />
                            <x-text-input id="inputan_teks" class="block mt-1 w-full" type="text" name="inputan_teks" :value="old('inputan_teks')" required />
                            <x-input-error :messages="$errors->get('inputan_teks')" class="mt-2" />
                        </div>

                        <!-- Jenis Perusahaan -->
                        <div>
                            <x-input-label for="jenis_pelaku_usaha" value="Jenis Perusahaan" />
                            <select name="jenis_pelaku_usaha" id="jenis_pelaku_usaha" class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm text-gray-700" required>
                                <option value="">Pilih Jenis Perusahaan</option>
                                <option value="Orang Perseorangan" @selected(old('jenis_pelaku_usaha') == 'Orang Perseorangan')>Orang Perseorangan</option>
                                <option value="Badan Usaha" @selected(old('jenis_pelaku_usaha') == 'Badan Usaha')>Badan Usaha</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis_pelaku_usaha')" class="mt-2" />
                        </div>

                        <!-- Jenis Badan Usaha (conditional) -->
                        <div id="jenis_badan_usaha_container" style="display: none;">
                            <x-input-label for="jenis_badan_usaha" value="Jenis Badan Usaha" />
                            <select name="jenis_badan_usaha" id="jenis_badan_usaha" class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm text-gray-700">
                                <option value="">Pilih Jenis Badan Usaha</option>
                                <option value="Perseroan Terbatas (PT)" @selected(old('jenis_badan_usaha') == 'Perseroan Terbatas (PT)')>Perseroan Terbatas (PT)</option>
                                <option value="Perseroan Terbatas (PT) Perorangan" @selected(old('jenis_badan_usaha') == 'Perseroan Terbatas (PT) Perorangan')>Perseroan Terbatas (PT) Perorangan</option>
                                <option value="Persekutuan Komanditer (CV/Commanditaire Vennootschap)" @selected(old('jenis_badan_usaha') == 'Persekutuan Komanditer (CV/Commanditaire Vennootschap)')>Persekutuan Komanditer (CV/Commanditaire Vennootschap)</option>
                                <option value="Persekutuan Firma (FA / Venootschap Onder Firma)" @selected(old('jenis_badan_usaha') == 'Persekutuan Firma (FA / Venootschap Onder Firma)')>Persekutuan Firma (FA / Venootschap Onder Firma)</option>
                                <option value="Persekutuan Perdata" @selected(old('jenis_badan_usaha') == 'Persekutuan Perdata')>Persekutuan Perdata</option>
                                <option value="Perusahaan Umum (Perum)" @selected(old('jenis_badan_usaha') == 'Perusahaan Umum (Perum)')>Perusahaan Umum (Perum)</option>
                                <option value="Perusahaan Umum Daerah (Perumda)" @selected(old('jenis_badan_usaha') == 'Perusahaan Umum Daerah (Perumda)')>Perusahaan Umum Daerah (Perumda)</option>
                                <option value="Badan Hukum Lainnya" @selected(old('jenis_badan_usaha') == 'Badan Hukum Lainnya')>Badan Hukum Lainnya</option>
                                <option value="Koperasi" @selected(old('jenis_badan_usaha') == 'Koperasi')>Koperasi</option>
                                <option value="Persekutuan dan Perkumpulan" @selected(old('jenis_badan_usaha') == 'Persekutuan dan Perkumpulan')>Persekutuan dan Perkumpulan</option>
                                <option value="Yayasan" @selected(old('jenis_badan_usaha') == 'Yayasan')>Yayasan</option>
                                <option value="Badan Layanan Umum" @selected(old('jenis_badan_usaha') == 'Badan Layanan Umum')>Badan Layanan Umum</option>
                                <option value="BUM Desa" @selected(old('jenis_badan_usaha') == 'BUM Desa')>BUM Desa</option>
                                <option value="BUM Desa Bersama" @selected(old('jenis_badan_usaha') == 'BUM Desa Bersama')>BUM Desa Bersama</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis_badan_usaha')" class="mt-2" />
                        </div>

                        <!-- Pemilik -->
                        <div>
                            <x-input-label for="pemilik" value="Pemilik" />
                            <x-text-input id="pemilik" class="block mt-1 w-full" type="text" name="pemilik" :value="old('pemilik')" required />
                            <x-input-error :messages="$errors->get('pemilik')" class="mt-2" />
                        </div>

                        <!-- Modal Usaha -->
                        <div>
                            <x-input-label for="modal_usaha" value="Modal Usaha" />
                            <x-text-input id="modal_usaha" class="block mt-1 w-full" type="number" name="modal_usaha" :value="old('modal_usaha')" required />
                            <x-input-error :messages="$errors->get('modal_usaha')" class="mt-2" />
                        </div>

                        <!-- Alamat -->
                        <div>
                            <x-input-label for="alamat_perusahaan" value="Alamat" />
                            <x-text-input id="alamat_perusahaan" class="block mt-1 w-full" type="text" name="alamat_perusahaan" :value="old('alamat_perusahaan')" required />
                            <x-input-error :messages="$errors->get('alamat_perusahaan')" class="mt-2" />
                        </div>

                        <!-- Jenis Proyek -->
                        <div>
                            <x-input-label for="jenis_proyek" value="Jenis Proyek" />
                            <select name="jenis_proyek" id="jenis_proyek" class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm text-gray-700" required>
                                <option value="">Pilih Jenis Proyek</option>
                                <option value="Utama" @selected(old('jenis_proyek') == 'Utama')>Utama</option>
                                <option value="Pendukung" @selected(old('jenis_proyek') == 'Pendukung')>Pendukung</option>
                                <option value="Pendukung UMKU" @selected(old('jenis_proyek') == 'Pendukung UMKU')>Pendukung UMKU</option>
                                <option value="Kantor Cabang" @selected(old('jenis_proyek') == 'Kantor Cabang')>Kantor Cabang</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis_proyek')" class="mt-2" />
                        </div>

                        <!-- Nama Perizinan -->
                        <div>
                            <x-input-label for="nama_perizinan" value="Nama Perizinan" />
                            <x-text-input id="nama_perizinan" class="block mt-1 w-full" type="text" name="nama_perizinan" :value="old('nama_perizinan')" required />
                            <x-input-error :messages="$errors->get('nama_perizinan')" class="mt-2" />
                        </div>

                        <!-- Skala Usaha -->
                        <div>
                            <x-input-label for="skala_usaha" value="Skala Usaha" />
                            <select name="skala_usaha" id="skala_usaha" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Skala Usaha</option>
                                <option value="Mikro" @selected(old('skala_usaha') == 'Mikro')>Mikro</option>
                                <option value="Usaha Kecil" @selected(old('skala_usaha') == 'Usaha Kecil')>Usaha Kecil</option>
                                <option value="Usaha Menengah" @selected(old('skala_usaha') == 'Usaha Menengah')>Usaha Menengah</option>
                                <option value="Usaha Besar" @selected(old('skala_usaha') == 'Usaha Besar')>Usaha Besar</option>
                            </select>
                            <x-input-error :messages="$errors->get('skala_usaha')" class="mt-2" />
                        </div>

                        <!-- Risiko -->
                        <div>
                            <x-input-label for="risiko" value="Risiko" />
                            <select name="risiko" id="risiko" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Risiko</option>
                                <option value="Rendah" @selected(old('risiko') == 'Rendah')>Rendah</option>
                                <option value="Menengah Rendah" @selected(old('risiko') == 'Menengah Rendah')>Menengah Rendah</option>
                                <option value="Menengah Tinggi" @selected(old('risiko') == 'Menengah Tinggi')>Menengah Tinggi</option>
                                <option value="Tinggi" @selected(old('risiko') == 'Tinggi')>Tinggi</option>
                            </select>
                            <x-input-error :messages="$errors->get('risiko')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                        <x-primary-button>
                            {{ __('Simpan Data') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
            @endif

            <!-- Kolom TTD -->
            @if(in_array(auth()->user() && auth()->user()->role, ['admin', 'penerbitan_berkas']))
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6" x-data="{ editTTD: false }">
                <!-- Header dengan tombol edit -->
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-violet-50 mb-6 -m-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                            Tanda Tangan Digital
                        </h3>
                        <button @click="editTTD = !editTTD" 
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-purple-700 bg-purple-100 hover:bg-purple-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            <span x-text="editTTD ? 'Selesai Edit' : 'Edit TTD'"></span>
                        </button>
                    </div>
                </div>

                <!-- Form Edit TTD (Hidden by default) -->
                <div x-show="editTTD" x-transition class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <form method="POST" action="{{ route('ttd-settings.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Mengetahui Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Bagian Mengetahui</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="mengetahui_title" value="Judul" />
                                    <x-text-input id="mengetahui_title" class="block mt-1 w-full" type="text" name="mengetahui_title" :value="old('mengetahui_title', $ttdSettings->mengetahui_title)" required />
                                </div>

                                <div>
                                    <x-input-label for="mengetahui_jabatan" value="Jabatan" />
                                    <x-text-input id="mengetahui_jabatan" class="block mt-1 w-full" type="text" name="mengetahui_jabatan" :value="old('mengetahui_jabatan', $ttdSettings->mengetahui_jabatan)" required />
                                </div>

                                <div>
                                    <x-input-label for="mengetahui_unit" value="Unit Kerja" />
                                    <x-text-input id="mengetahui_unit" class="block mt-1 w-full" type="text" name="mengetahui_unit" :value="old('mengetahui_unit', $ttdSettings->mengetahui_unit)" required />
                                </div>

                                <div>
                                    <x-input-label for="mengetahui_nama" value="Nama Lengkap" />
                                    <x-text-input id="mengetahui_nama" class="block mt-1 w-full" type="text" name="mengetahui_nama" :value="old('mengetahui_nama', $ttdSettings->mengetahui_nama)" required />
                                </div>

                                <div>
                                    <x-input-label for="mengetahui_pangkat" value="Pangkat/Golongan" />
                                    <x-text-input id="mengetahui_pangkat" class="block mt-1 w-full" type="text" name="mengetahui_pangkat" :value="old('mengetahui_pangkat', $ttdSettings->mengetahui_pangkat)" required />
                                </div>

                                <div>
                                    <x-input-label for="mengetahui_nip" value="NIP" />
                                    <x-text-input id="mengetahui_nip" class="block mt-1 w-full" type="text" name="mengetahui_nip" :value="old('mengetahui_nip', $ttdSettings->mengetahui_nip)" required />
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="mengetahui_photo" value="Foto TTD Mengetahui" />
                                    <input id="mengetahui_photo" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100" type="file" name="mengetahui_photo" accept="image/*" />
                                    @if($ttdSettings->mengetahui_photo)
                                        <div class="mt-2 p-3 bg-gray-50 rounded-lg">
                                            <p class="text-xs text-gray-500 mb-2">Foto saat ini:</p>
                                            <div class="flex items-center space-x-3">
                                                @php
                                                    $file = $ttdSettings->mengetahui_photo;
                                                    $url = null;
                                                    if ($file) {
                                                        if (file_exists(public_path('storage/ttd_photos/' . $file))) {
                                                            $url = asset('storage/ttd_photos/' . $file);
                                                        } elseif (file_exists(public_path('storage/ttd-photos/' . $file))) {
                                                            $url = asset('storage/ttd-photos/' . $file);
                                                        }
                                                    }
                                                @endphp
                                                @if($url)
                                                    <img src="{{ $url }}" alt="TTD Mengetahui" class="w-20 h-20 object-cover rounded border">
                                                @endif
                                                <div>
                                                    <p class="text-sm text-gray-700">{{ $ttdSettings->mengetahui_photo }}</p>
                                                    <label class="inline-flex items-center mt-2">
                                                        <input type="checkbox" name="delete_mengetahui_photo" value="1" class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                                        <span class="ml-2 text-sm text-red-600">Hapus foto ini</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <x-input-error :messages="$errors->get('mengetahui_photo')" class="mt-2" />
            </div>
        </div>
    </div>

                        <!-- Menyetujui Section -->
                        <div class="pb-6">
                            <h4 class="text-md font-medium text-gray-900 mb-4">Bagian Menyetujui</h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="menyetujui_lokasi" value="Lokasi" />
                                    <x-text-input id="menyetujui_lokasi" class="block mt-1 w-full" type="text" name="menyetujui_lokasi" :value="old('menyetujui_lokasi', $ttdSettings->menyetujui_lokasi ?? 'Surabaya')" required />
                                </div>

                                <div>
                                    <x-input-label for="menyetujui_tanggal" value="Tanggal" />
                                    <x-text-input id="menyetujui_tanggal" class="block mt-1 w-full" type="date" name="menyetujui_tanggal" :value="old('menyetujui_tanggal', $ttdSettings->menyetujui_tanggal ?? date('Y-m-d'))" required />
                                    <p class="text-xs text-gray-500 mt-1">Tanggal akan otomatis terformat dalam PDF</p>
                                </div>

                                <div>
                                    <x-input-label for="menyetujui_jabatan" value="Jabatan" />
                                    <x-text-input id="menyetujui_jabatan" class="block mt-1 w-full" type="text" name="menyetujui_jabatan" :value="old('menyetujui_jabatan', $ttdSettings->menyetujui_jabatan)" required />
                                </div>

                                <div>
                                    <x-input-label for="menyetujui_nama" value="Nama Lengkap" />
                                    <x-text-input id="menyetujui_nama" class="block mt-1 w-full" type="text" name="menyetujui_nama" :value="old('menyetujui_nama', $ttdSettings->menyetujui_nama)" required />
                                </div>

                                <div>
                                    <x-input-label for="menyetujui_pangkat" value="Pangkat/Golongan" />
                                    <x-text-input id="menyetujui_pangkat" class="block mt-1 w-full" type="text" name="menyetujui_pangkat" :value="old('menyetujui_pangkat', $ttdSettings->menyetujui_pangkat)" required />
                                </div>

                                <div>
                                    <x-input-label for="menyetujui_nip" value="NIP" />
                                    <x-text-input id="menyetujui_nip" class="block mt-1 w-full" type="text" name="menyetujui_nip" :value="old('menyetujui_nip', $ttdSettings->menyetujui_nip)" required />
                                </div>

                                <div class="md:col-span-2">
                                    <x-input-label for="menyetujui_photo" value="Foto TTD Menyetujui" />
                                    <input id="menyetujui_photo" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100" type="file" name="menyetujui_photo" accept="image/*" />
                                    @if($ttdSettings->menyetujui_photo)
                                        <div class="mt-2 p-3 bg-gray-50 rounded-lg">
                                            <p class="text-xs text-gray-500 mb-2">Foto saat ini:</p>
                                            <div class="flex items-center space-x-3">
                                                @php
                                                    $file = $ttdSettings->menyetujui_photo;
                                                    $url = null;
                                                    if ($file) {
                                                        if (file_exists(public_path('storage/ttd_photos/' . $file))) {
                                                            $url = asset('storage/ttd_photos/' . $file);
                                                        } elseif (file_exists(public_path('storage/ttd-photos/' . $file))) {
                                                            $url = asset('storage/ttd-photos/' . $file);
                                                        }
                                                    }
                                                @endphp
                                                @if($url)
                                                    <img src="{{ $url }}" alt="TTD Menyetujui" class="w-20 h-20 object-cover rounded border">
                                                @endif
                                                <div>
                                                    <p class="text-sm text-gray-700">{{ $ttdSettings->menyetujui_photo }}</p>
                                                    <label class="inline-flex items-center mt-2">
                                                        <input type="checkbox" name="delete_menyetujui_photo" value="1" class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                                        <span class="ml-2 text-sm text-red-600">Hapus foto ini</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <x-input-error :messages="$errors->get('menyetujui_photo')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                            <button type="button" @click="editTTD = false" 
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Batal
                            </button>
                            <x-primary-button>
                                {{ __('Simpan Pengaturan') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <!-- Tampilan TTD -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Mengetahui -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">{{ $ttdSettings->mengetahui_title }}</p>
                        <p class="text-sm text-gray-600 mb-2">{{ $ttdSettings->mengetahui_jabatan }}</p>
                        <p class="text-sm text-gray-600 mb-4">{{ $ttdSettings->mengetahui_unit }}</p>
                        <div class="h-20 border-b border-gray-300 mb-2 flex items-center justify-center">
                            @if($ttdSettings->mengetahui_photo)
                                @php
                                    $file = $ttdSettings->mengetahui_photo;
                                    $url = null;
                                    if ($file) {
                                        if (file_exists(public_path('storage/ttd_photos/' . $file))) {
                                            $url = asset('storage/ttd_photos/' . $file);
                                        } elseif (file_exists(public_path('storage/ttd-photos/' . $file))) {
                                            $url = asset('storage/ttd-photos/' . $file);
                                        }
                                    }
                                @endphp
                                @if($url)
                                    <img src="{{ $url }}" alt="TTD Mengetahui" class="max-h-16 max-w-32 object-contain">
                                @endif
                            @endif
                        </div>
                        <p class="text-sm font-medium text-gray-900">{{ $ttdSettings->mengetahui_nama }}</p>
                        <p class="text-sm text-gray-600">{{ $ttdSettings->mengetahui_pangkat }}</p>
                        <p class="text-sm text-gray-600">NIP: {{ $ttdSettings->mengetahui_nip }}</p>
                    </div>

                    <!-- Menyetujui -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">{{ $ttdSettings->menyetujui_lokasi ?? 'Surabaya' }}, {{ $ttdSettings->menyetujui_tanggal ? \Carbon\Carbon::parse($ttdSettings->menyetujui_tanggal)->format('d F Y') : date('d F Y') }}</p>
                        <p class="text-sm text-gray-600 mb-2">{{ $ttdSettings->menyetujui_jabatan }}</p>
                        <div class="h-20 border-b border-gray-300 mb-2 flex items-center justify-center">
                            @if($ttdSettings->menyetujui_photo)
                                <img src="{{ asset('storage/ttd_photos/' . $ttdSettings->menyetujui_photo) }}" alt="TTD Menyetujui" class="max-h-16 max-w-32 object-contain">
                            @endif
                        </div>
                        <p class="text-sm font-medium text-gray-900">{{ $ttdSettings->menyetujui_nama }}</p>
                        <p class="text-sm text-gray-600">{{ $ttdSettings->menyetujui_pangkat }}</p>
                        <p class="text-sm text-gray-600">NIP: {{ $ttdSettings->menyetujui_nip }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Edit Modal -->
    @if(in_array(auth()->user() && auth()->user()->role, ['admin', 'penerbitan_berkas']))
    <div id="editModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Edit Data Permohonan</h3>
                    <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- No. Permohonan -->
                        <div>
                            <x-input-label for="edit_no_permohonan" value="No. Permohonan" />
                            <x-text-input id="edit_no_permohonan" class="block mt-1 w-full" type="text" name="no_permohonan" required />
                        </div>

                        <!-- No. Proyek -->
                        <div>
                            <x-input-label for="edit_no_proyek" value="No. Proyek" />
                            <x-text-input id="edit_no_proyek" class="block mt-1 w-full" type="text" name="no_proyek" />
                        </div>

                        <!-- Tanggal Permohonan -->
                        <div>
                            <x-input-label for="edit_tanggal_permohonan" value="Tanggal Permohonan" />
                            <x-text-input id="edit_tanggal_permohonan" class="block mt-1 w-full" type="date" name="tanggal_permohonan" />
                        </div>

                        <!-- NIB -->
                        <div>
                            <x-input-label for="edit_nib" value="NIB" />
                            <x-text-input id="edit_nib" class="block mt-1 w-full" type="text" name="nib" />
                        </div>

                        <!-- KBLI -->
                        <div>
                            <x-input-label for="edit_kbli" value="KBLI" />
                            <x-text-input id="edit_kbli" class="block mt-1 w-full" type="text" name="kbli" />
                        </div>

                        <!-- Nama Usaha -->
                        <div>
                            <x-input-label for="edit_nama_usaha" value="Nama Usaha" />
                            <x-text-input id="edit_nama_usaha" class="block mt-1 w-full" type="text" name="nama_usaha" required />
                        </div>

                        <!-- Kegiatan -->
                        <div class="md:col-span-2">
                            <x-input-label for="edit_inputan_teks" value="Kegiatan" />
                            <textarea id="edit_inputan_teks" name="inputan_teks" rows="3" class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm"></textarea>
                        </div>

                        <!-- Jenis Perusahaan -->
                        <div>
                            <x-input-label for="edit_jenis_pelaku_usaha" value="Jenis Perusahaan" />
                            <select name="jenis_pelaku_usaha" id="edit_jenis_pelaku_usaha" class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm text-gray-700">
                                <option value="">Pilih Jenis Perusahaan</option>
                                <option value="Orang Perseorangan">Orang Perseorangan</option>
                                <option value="Badan Usaha">Badan Usaha</option>
                            </select>
                        </div>

                        <!-- Jenis Badan Usaha (conditional) -->
                        <div id="edit_jenis_badan_usaha_container" style="display: none;">
                            <x-input-label for="edit_jenis_badan_usaha" value="Jenis Badan Usaha" />
                            <select name="jenis_badan_usaha" id="edit_jenis_badan_usaha" class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm text-gray-700">
                                <option value="">Pilih Jenis Badan Usaha</option>
                                <option value="Perseroan Terbatas (PT)">Perseroan Terbatas (PT)</option>
                                <option value="Perseroan Terbatas (PT) Perorangan">Perseroan Terbatas (PT) Perorangan</option>
                                <option value="Persekutuan Komanditer (CV/Commanditaire Vennootschap)">Persekutuan Komanditer (CV/Commanditaire Vennootschap)</option>
                                <option value="Persekutuan Firma (FA / Venootschap Onder Firma)">Persekutuan Firma (FA / Venootschap Onder Firma)</option>
                                <option value="Persekutuan Perdata">Persekutuan Perdata</option>
                                <option value="Perusahaan Umum (Perum)">Perusahaan Umum (Perum)</option>
                                <option value="Perusahaan Umum Daerah (Perumda)">Perusahaan Umum Daerah (Perumda)</option>
                                <option value="Badan Hukum Lainnya">Badan Hukum Lainnya</option>
                                <option value="Koperasi">Koperasi</option>
                                <option value="Persekutuan dan Perkumpulan">Persekutuan dan Perkumpulan</option>
                                <option value="Yayasan">Yayasan</option>
                                <option value="Badan Layanan Umum">Badan Layanan Umum</option>
                                <option value="BUM Desa">BUM Desa</option>
                                <option value="BUM Desa Bersama">BUM Desa Bersama</option>
                            </select>
                        </div>

                        <!-- Pemilik -->
                        <div>
                            <x-input-label for="edit_pemilik" value="Pemilik" />
                            <x-text-input id="edit_pemilik" class="block mt-1 w-full" type="text" name="pemilik" />
                        </div>

                        <!-- Modal Usaha -->
                        <div>
                            <x-input-label for="edit_modal_usaha" value="Modal Usaha" />
                            <x-text-input id="edit_modal_usaha" class="block mt-1 w-full" type="number" name="modal_usaha" />
                        </div>

                        <!-- Alamat Perusahaan -->
                        <div class="md:col-span-2">
                            <x-input-label for="edit_alamat_perusahaan" value="Alamat Perusahaan" />
                            <textarea id="edit_alamat_perusahaan" name="alamat_perusahaan" rows="2" class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm"></textarea>
                        </div>

                        <!-- Jenis Proyek -->
                        <div>
                            <x-input-label for="edit_jenis_proyek" value="Jenis Proyek" />
                            <select name="jenis_proyek" id="edit_jenis_proyek" class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm text-gray-700">
                                <option value="">Pilih Jenis Proyek</option>
                                <option value="Utama">Utama</option>
                                <option value="Pendukung">Pendukung</option>
                                <option value="Pendukung UMKU">Pendukung UMKU</option>
                                <option value="Kantor Cabang">Kantor Cabang</option>
                            </select>
                        </div>

                        <!-- Nama Perizinan -->
                        <div>
                            <x-input-label for="edit_nama_perizinan" value="Nama Perizinan" />
                            <x-text-input id="edit_nama_perizinan" class="block mt-1 w-full" type="text" name="nama_perizinan" />
                        </div>

                        <!-- Skala Usaha -->
                        <div>
                            <x-input-label for="edit_skala_usaha" value="Skala Usaha" />
                            <select name="skala_usaha" id="edit_skala_usaha" class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm text-gray-700" required>
                                <option value="">Pilih Skala Usaha</option>
                                <option value="Mikro">Mikro</option>
                                <option value="Usaha Kecil">Usaha Kecil</option>
                                <option value="Usaha Menengah">Usaha Menengah</option>
                                <option value="Usaha Besar">Usaha Besar</option>
                            </select>
                        </div>

                        <!-- Risiko -->
                        <div>
                            <x-input-label for="edit_risiko" value="Risiko" />
                            <select name="risiko" id="edit_risiko" class="block mt-1 w-full border-gray-300 focus:border-purple-500 focus:ring-purple-500 rounded-md shadow-sm text-gray-700" required>
                                <option value="">Pilih Risiko</option>
                                <option value="Rendah">Rendah</option>
                                <option value="Menengah Rendah">Menengah Rendah</option>
                                <option value="Menengah Tinggi">Menengah Tinggi</option>
                                <option value="Tinggi">Tinggi</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 pt-6">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisPelakuUsaha = document.getElementById('jenis_pelaku_usaha');
            const jenisBadanUsahaContainer = document.getElementById('jenis_badan_usaha_container');
            const jenisBadanUsaha = document.getElementById('jenis_badan_usaha');

            // Function to toggle jenis badan usaha dropdown
            function toggleJenisBadanUsaha() {
                if (jenisPelakuUsaha.value === 'Badan Usaha') {
                    jenisBadanUsahaContainer.style.display = 'block';
                    jenisBadanUsaha.required = true;
                } else {
                    jenisBadanUsahaContainer.style.display = 'none';
                    jenisBadanUsaha.required = false;
                    jenisBadanUsaha.value = '';
                }
            }

            // Event listener for jenis pelaku usaha change
            jenisPelakuUsaha.addEventListener('change', toggleJenisBadanUsaha);

            // Initialize on page load
            toggleJenisBadanUsaha();

            // Edit modal functionality (only for authorized users)
            const userRole = '{{ auth()->user() ? auth()->user()->role : "" }}';
            if (['admin', 'penerbitan_berkas'].includes(userRole)) {
                const editJenisPelakuUsaha = document.getElementById('edit_jenis_pelaku_usaha');
                const editJenisBadanUsahaContainer = document.getElementById('edit_jenis_badan_usaha_container');
                const editJenisBadanUsaha = document.getElementById('edit_jenis_badan_usaha');

                function toggleEditJenisBadanUsaha() {
                    if (editJenisPelakuUsaha.value === 'Badan Usaha') {
                        editJenisBadanUsahaContainer.style.display = 'block';
                        editJenisBadanUsaha.required = true;
                    } else {
                        editJenisBadanUsahaContainer.style.display = 'none';
                        editJenisBadanUsaha.required = false;
                        editJenisBadanUsaha.value = '';
                    }
                }

                editJenisPelakuUsaha.addEventListener('change', toggleEditJenisBadanUsaha);

                // Add event listeners for edit and delete buttons
                document.addEventListener('click', function(e) {
                    if (e.target.closest('.edit-btn')) {
                        const id = e.target.closest('.edit-btn').getAttribute('data-edit-id');
                        editPermohonan(id);
                    }
                    if (e.target.closest('.delete-btn')) {
                        const id = e.target.closest('.delete-btn').getAttribute('data-delete-id');
                        deletePermohonan(id);
                    }
                });
            }
        });

        // Global functions for edit and delete (only for authorized users)
        const userRole = '{{ auth()->user() ? auth()->user()->role : "" }}';
        if (['admin', 'penerbitan_berkas'].includes(userRole)) {
            function editPermohonan(id) {
            // Fetch data via AJAX
            fetch(`/penerbitan-berkas/${id}/edit`)
                .then(response => response.json())
                .then(data => {
                    // Populate form fields
                    document.getElementById('edit_no_permohonan').value = data.no_permohonan || '';
                    document.getElementById('edit_no_proyek').value = data.no_proyek || '';
                    document.getElementById('edit_tanggal_permohonan').value = data.tanggal_permohonan || '';
                    document.getElementById('edit_nib').value = data.nib || '';
                    document.getElementById('edit_kbli').value = data.kbli || '';
                    document.getElementById('edit_nama_usaha').value = data.nama_usaha || '';
                    document.getElementById('edit_inputan_teks').value = data.inputan_teks || '';
                    document.getElementById('edit_jenis_pelaku_usaha').value = data.jenis_pelaku_usaha || '';
                    document.getElementById('edit_jenis_badan_usaha').value = data.jenis_badan_usaha || '';
                    document.getElementById('edit_pemilik').value = data.pemilik || '';
                    document.getElementById('edit_modal_usaha').value = data.modal_usaha || '';
                    document.getElementById('edit_alamat_perusahaan').value = data.alamat_perusahaan || '';
                    document.getElementById('edit_jenis_proyek').value = data.jenis_proyek || '';
                    document.getElementById('edit_nama_perizinan').value = data.nama_perizinan || '';
                    document.getElementById('edit_skala_usaha').value = data.skala_usaha || '';
                    document.getElementById('edit_risiko').value = data.risiko || '';

                    // Update form action
                    document.getElementById('editForm').action = `/penerbitan-berkas/${id}`;

                    // Toggle jenis badan usaha
                    toggleEditJenisBadanUsaha();

                    // Show modal
                    document.getElementById('editModal').classList.remove('hidden');
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal memuat data permohonan');
                });
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        function deletePermohonan(id) {
            // Show custom confirmation modal
            showDeleteModal(id);
        }

        function showDeleteModal(id) {
            // Create modal if it doesn't exist
            let modal = document.getElementById('deleteModal');
            if (!modal) {
                modal = document.createElement('div');
                modal.id = 'deleteModal';
                modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50';
                modal.innerHTML = `
                    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                        <div class="mt-3 text-center">
                            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Konfirmasi Hapus</h3>
                            <div class="mt-2 px-7 py-3">
                                <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus data permohonan ini? Tindakan ini tidak dapat dibatalkan.</p>
                            </div>
                            <div class="items-center px-4 py-3">
                                <button id="confirmDelete" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                                    Hapus
                                </button>
                                <button id="cancelDelete" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-24 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(modal);
            }

            // Show modal
            modal.classList.remove('hidden');

            // Handle confirm button
            document.getElementById('confirmDelete').onclick = function() {
                // Create form for DELETE request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/penerbitan-berkas/${id}`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            };

            // Handle cancel button
            document.getElementById('cancelDelete').onclick = function() {
                modal.classList.add('hidden');
            };

            // Handle click outside modal
            modal.onclick = function(e) {
                if (e.target === modal) {
                    modal.classList.add('hidden');
                }
            };
        }

            function toggleEditJenisBadanUsaha() {
                const editJenisPelakuUsaha = document.getElementById('edit_jenis_pelaku_usaha');
                const editJenisBadanUsahaContainer = document.getElementById('edit_jenis_badan_usaha_container');
                const editJenisBadanUsaha = document.getElementById('edit_jenis_badan_usaha');

                if (editJenisPelakuUsaha.value === 'Badan Usaha') {
                    editJenisBadanUsahaContainer.style.display = 'block';
                    editJenisBadanUsaha.required = true;
                } else {
                    editJenisBadanUsahaContainer.style.display = 'none';
                    editJenisBadanUsaha.required = false;
                    editJenisBadanUsaha.value = '';
                }
            }
        }
    </script>
</x-sidebar-layout>