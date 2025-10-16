<x-sidebar-layout>
    <x-slot name="header">Dashboard DPMPTSP</x-slot>

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
                                    <dd class="text-xl font-bold text-white">{{ $stats['totalPermohonan'] ?? 0 }}</dd>
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
                                    <dd class="text-xl font-bold text-white">{{ $stats['diterima'] ?? 0 }}</dd>
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
                                    <dd class="text-xl font-bold text-white">{{ $stats['dikembalikan'] ?? 0 }}</dd>
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
                                    <dd class="text-xl font-bold text-white">{{ $stats['ditolak'] ?? 0 }}</dd>
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
                                    <dd class="text-xl font-bold text-white">{{ $stats['terlambat'] ?? 0 }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Permohonan -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-200" style="background-color: #F8FAFC;">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 text-gray-700 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Data Permohonan Terbaru
                            </h3>
                        </div>
                        <span class="text-sm font-medium px-3 py-1 rounded-full" style="background-color: #E0E7FF; color: #3B82F6;">
                            {{ $permohonans->count() }} Data
                        </span>
                    </div>
                </div>
                @if($permohonans->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead style="background-color: #253B7E;">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #E0E7FF;">No. Permohonan</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #E0E7FF;">Nama Usaha</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #E0E7FF;">Sektor</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #E0E7FF;">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wider" style="color: #E0E7FF;">Tanggal Dibuat</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wider" style="color: #E0E7FF;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($permohonans as $permohonan)
                                    <tr class="hover:bg-primary-50 transition-colors duration-200">
                                        <!-- No. Permohonan -->
                                        <td class="px-4 py-4 text-sm font-medium text-gray-900">
                                            <div class="flex items-center">
                                                <div class="w-2 h-2 bg-primary-500 rounded-full mr-3"></div>
                                                <span class="font-mono text-xs">{{ $permohonan->no_permohonan ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <!-- Nama Usaha -->
                                        <td class="px-4 py-4 text-sm text-gray-900">
                                            <p class="font-medium text-gray-900 text-xs">{{ $permohonan->nama_usaha ?? '-' }}</p>
                                        </td>
                                        <!-- Sektor -->
                                        <td class="px-4 py-4 text-sm">
                                            @if($permohonan && $permohonan->sektor)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    {{ $permohonan->sektor }}
                                                </span>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                        <!-- Status -->
                                        <td class="px-4 py-4 text-sm">
                                            @php
                                                $status = $permohonan->status ?? 'Menunggu';
                                                $statusColors = [
                                                    'Diterima' => 'bg-green-100 text-green-800',
                                                    'Dikembalikan' => 'bg-yellow-100 text-yellow-800',
                                                    'Ditolak' => 'bg-red-100 text-red-800',
                                                    'Menunggu' => 'bg-blue-100 text-blue-800',
                                                    'Terlambat' => 'bg-orange-100 text-orange-800'
                                                ];
                                                $statusColor = $statusColors[$status] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusColor }}">
                                                {{ $status }}
                                            </span>
                                        </td>
                                        <!-- Tanggal Dibuat -->
                                        <td class="px-4 py-4 text-sm text-gray-900">
                                            <span class="text-xs">{{ $permohonan->created_at->setTimezone('Asia/Jakarta')->format('d M Y') }}</span>
                                        </td>
                                        <!-- Aksi -->
                                        <td class="px-4 py-4 text-center">
                                            <a href="{{ route('permohonan.show', $permohonan) }}" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                                                Lihat
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada permohonan</h3>
                            <p class="mt-1 text-sm text-gray-500">Belum ada data permohonan yang tersedia.</p>
                        </div>
                @endif
            </div>

        </div>
    </x-sidebar-layout>