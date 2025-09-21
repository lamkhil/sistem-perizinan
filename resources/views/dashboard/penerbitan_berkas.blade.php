<x-sidebar-layout>
    <x-slot name="header">
        Dashboard Penerbitan Berkas
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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

            <!-- Tabel Data Permohonan -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 mb-8">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                                <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Data Permohonan
                            </h3>
                        </div>
                    </div>
                </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 3%;">NO</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 12%;">NO. PERMOHONAN</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 12%;">NO. PROYEK</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 10%;">TANGGAL PERMOHONAN</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 8%;">NIB</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 6%;">KBLI</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 12%;">NAMA USAHA</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 12%;">KEGIATAN</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 8%;">JENIS PERUSAHAAN</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 10%;">PEMILIK</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 8%;">MODAL USAHA</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 12%;">ALAMAT</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 6%;">JENIS PROYEK</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 12%;">NAMA PERIZINAN</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 8%;">SKALA USAHA</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 8%;">RISIKO</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider" style="width: 15%;">PEMROSES DAN TGL. E SURAT DAN TGL PERTEK</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @if($permohonans->count() > 0)
                                @foreach($permohonans as $index => $permohonan)
                                <tr class="hover:bg-blue-50 transition-colors duration-200">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-3"></div>
                                            {{ $index + 1 }}
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
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
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
                                        @if($permohonan->modal_usaha)
                                            @php
                                                $skala = '';
                                                if($permohonan->modal_usaha <= 1000000000) {
                                                    $skala = 'Mikro';
                                                } elseif($permohonan->modal_usaha <= 5000000000) {
                                                    $skala = 'Usaha Kecil';
                                                } elseif($permohonan->modal_usaha <= 10000000000) {
                                                    $skala = 'Usaha Menengah';
                                                } else {
                                                    $skala = 'Usaha Besar';
                                                }
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                {{ $skala }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Menengah Tinggi
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="text-xs">
                                            <p class="font-medium">DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</p>
                                            <p class="font-mono">No: BAP/OSS/IX/{{ $permohonan->no_permohonan ?? 'N/A' }}/436.7.15/{{ date('Y') }}</p>
                                            <p class="text-gray-600">tanggal BAP: {{ date('d F Y') }}</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="17" class="px-4 py-8 text-center text-sm text-gray-500">
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
                </div>

            <!-- Form Input Data Baru -->
            <!-- Export Button -->
            <div class="mb-4 flex flex-wrap gap-3">
                <a href="{{ route('penerbitan-berkas.export.excel') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export Excel
                </a>
                <a href="{{ route('permohonan.export.pdf-penerbitan') }}" 
                   class="inline-flex items-center px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export PDF dengan TTD
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-6 mb-8">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 mb-6 -m-6">
                    <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Tambah Data Permohonan Baru
                    </h3>
                </div>
                
                <form method="POST" action="{{ route('permohonan.store') }}" class="space-y-6">
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
                            <select name="jenis_pelaku_usaha" id="jenis_pelaku_usaha" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">Pilih Jenis Perusahaan</option>
                                <option value="Orang Perseorangan" @selected(old('jenis_pelaku_usaha') == 'Orang Perseorangan')>Orang Perseorangan</option>
                                <option value="Badan Usaha" @selected(old('jenis_pelaku_usaha') == 'Badan Usaha')>Badan Usaha</option>
                            </select>
                            <x-input-error :messages="$errors->get('jenis_pelaku_usaha')" class="mt-2" />
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
                            <select name="jenis_proyek" id="jenis_proyek" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
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

            <!-- Kolom TTD -->
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
                                                <img src="{{ asset('storage/ttd_photos/' . $ttdSettings->mengetahui_photo) }}" alt="TTD Mengetahui" class="w-20 h-20 object-cover rounded border">
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
                                    <x-input-label for="menyetujui_title" value="Judul & Tanggal" />
                                    <x-text-input id="menyetujui_title" class="block mt-1 w-full" type="text" name="menyetujui_title" :value="old('menyetujui_title', $ttdSettings->menyetujui_title)" required />
                                    <p class="text-xs text-gray-500 mt-1">Gunakan {{ date('d F Y') }} untuk tanggal otomatis</p>
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
                                                <img src="{{ asset('storage/ttd_photos/' . $ttdSettings->menyetujui_photo) }}" alt="TTD Menyetujui" class="w-20 h-20 object-cover rounded border">
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
                                <img src="{{ asset('storage/ttd_photos/' . $ttdSettings->mengetahui_photo) }}" alt="TTD Mengetahui" class="max-h-16 max-w-32 object-contain">
                            @endif
                        </div>
                        <p class="text-sm font-medium text-gray-900">{{ $ttdSettings->mengetahui_nama }}</p>
                        <p class="text-sm text-gray-600">{{ $ttdSettings->mengetahui_pangkat }}</p>
                        <p class="text-sm text-gray-600">NIP: {{ $ttdSettings->mengetahui_nip }}</p>
                    </div>

                    <!-- Menyetujui -->
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">{{ $menyetujuiTitle }}</p>
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
</x-sidebar-layout>