<x-sidebar-layout>
    <x-slot name="header">
        Pengaturan TTD
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Pengaturan Tanda Tangan Digital</h3>
                
                <form method="POST" action="{{ route('ttd-settings.update') }}" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <!-- Mengetahui Section -->
                    <div class="border-b border-gray-200 pb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Bagian Mengetahui</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="mengetahui_title" value="Judul" />
                                <x-text-input id="mengetahui_title" class="block mt-1 w-full" type="text" name="mengetahui_title" :value="old('mengetahui_title', $ttdSettings->mengetahui_title)" required />
                                <x-input-error :messages="$errors->get('mengetahui_title')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="mengetahui_jabatan" value="Jabatan" />
                                <x-text-input id="mengetahui_jabatan" class="block mt-1 w-full" type="text" name="mengetahui_jabatan" :value="old('mengetahui_jabatan', $ttdSettings->mengetahui_jabatan)" required />
                                <x-input-error :messages="$errors->get('mengetahui_jabatan')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="mengetahui_unit" value="Unit Kerja" />
                                <x-text-input id="mengetahui_unit" class="block mt-1 w-full" type="text" name="mengetahui_unit" :value="old('mengetahui_unit', $ttdSettings->mengetahui_unit)" required />
                                <x-input-error :messages="$errors->get('mengetahui_unit')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="mengetahui_nama" value="Nama Lengkap" />
                                <x-text-input id="mengetahui_nama" class="block mt-1 w-full" type="text" name="mengetahui_nama" :value="old('mengetahui_nama', $ttdSettings->mengetahui_nama)" required />
                                <x-input-error :messages="$errors->get('mengetahui_nama')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="mengetahui_pangkat" value="Pangkat/Golongan" />
                                <x-text-input id="mengetahui_pangkat" class="block mt-1 w-full" type="text" name="mengetahui_pangkat" :value="old('mengetahui_pangkat', $ttdSettings->mengetahui_pangkat)" required />
                                <x-input-error :messages="$errors->get('mengetahui_pangkat')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="mengetahui_nip" value="NIP" />
                                <x-text-input id="mengetahui_nip" class="block mt-1 w-full" type="text" name="mengetahui_nip" :value="old('mengetahui_nip', $ttdSettings->mengetahui_nip)" required />
                                <x-input-error :messages="$errors->get('mengetahui_nip')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="mengetahui_photo" value="Foto TTD Mengetahui" />
                                <input id="mengetahui_photo" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" type="file" name="mengetahui_photo" accept="image/*" />
                                <p class="text-xs text-gray-500 mt-1">Upload foto tanda tangan untuk bagian Mengetahui (JPG, PNG, maksimal 2MB)</p>
                                @if($ttdSettings->mengetahui_photo)
                                    <div class="mt-2">
                                        <p class="text-sm text-green-600">✓ Foto TTD sudah diupload: {{ $ttdSettings->mengetahui_photo }}</p>
                                        <label class="flex items-center mt-1">
                                            <input type="checkbox" name="delete_mengetahui_photo" value="1" class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-red-600">Hapus foto TTD</span>
                                        </label>
                                    </div>
                                @endif
                                <x-input-error :messages="$errors->get('mengetahui_photo')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Menyetujui Section -->
                    <div class="border-b border-gray-200 pb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Bagian Menyetujui</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="menyetujui_lokasi" value="Lokasi" />
                                <x-text-input id="menyetujui_lokasi" class="block mt-1 w-full" type="text" name="menyetujui_lokasi" :value="old('menyetujui_lokasi', $ttdSettings->menyetujui_lokasi ?? 'Surabaya')" required />
                                <x-input-error :messages="$errors->get('menyetujui_lokasi')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="menyetujui_tanggal" value="Tanggal" />
                                <x-text-input id="menyetujui_tanggal" class="block mt-1 w-full" type="date" name="menyetujui_tanggal" :value="old('menyetujui_tanggal', $ttdSettings->menyetujui_tanggal ?? date('Y-m-d'))" required />
                                <p class="text-xs text-gray-500 mt-1">Tanggal akan otomatis terformat dalam PDF</p>
                                <x-input-error :messages="$errors->get('menyetujui_tanggal')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="menyetujui_jabatan" value="Jabatan" />
                                <x-text-input id="menyetujui_jabatan" class="block mt-1 w-full" type="text" name="menyetujui_jabatan" :value="old('menyetujui_jabatan', $ttdSettings->menyetujui_jabatan)" required />
                                <x-input-error :messages="$errors->get('menyetujui_jabatan')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="menyetujui_nama" value="Nama Lengkap" />
                                <x-text-input id="menyetujui_nama" class="block mt-1 w-full" type="text" name="menyetujui_nama" :value="old('menyetujui_nama', $ttdSettings->menyetujui_nama)" required />
                                <x-input-error :messages="$errors->get('menyetujui_nama')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="menyetujui_pangkat" value="Pangkat/Golongan" />
                                <x-text-input id="menyetujui_pangkat" class="block mt-1 w-full" type="text" name="menyetujui_pangkat" :value="old('menyetujui_pangkat', $ttdSettings->menyetujui_pangkat)" required />
                                <x-input-error :messages="$errors->get('menyetujui_pangkat')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="menyetujui_nip" value="NIP" />
                                <x-text-input id="menyetujui_nip" class="block mt-1 w-full" type="text" name="menyetujui_nip" :value="old('menyetujui_nip', $ttdSettings->menyetujui_nip)" required />
                                <x-input-error :messages="$errors->get('menyetujui_nip')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="menyetujui_photo" value="Foto TTD Menyetujui" />
                                <input id="menyetujui_photo" class="block mt-1 w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" type="file" name="menyetujui_photo" accept="image/*" />
                                <p class="text-xs text-gray-500 mt-1">Upload foto tanda tangan untuk bagian Menyetujui (JPG, PNG, maksimal 2MB)</p>
                                @if($ttdSettings->menyetujui_photo)
                                    <div class="mt-2">
                                        <p class="text-sm text-green-600">✓ Foto TTD sudah diupload: {{ $ttdSettings->menyetujui_photo }}</p>
                                        <label class="flex items-center mt-1">
                                            <input type="checkbox" name="delete_menyetujui_photo" value="1" class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                            <span class="ml-2 text-sm text-red-600">Hapus foto TTD</span>
                                        </label>
                                    </div>
                                @endif
                                <x-input-error :messages="$errors->get('menyetujui_photo')" class="mt-2" />
                            </div>
                        </div>
                    </div>

                    <!-- Preview Section -->
                    <div class="bg-gray-50 p-6 rounded-lg">
                        <h4 class="text-md font-medium text-gray-900 mb-4">Preview TTD</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Mengetahui Preview -->
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-4">{{ $ttdSettings->mengetahui_title }}</p>
                                <p class="text-sm text-gray-600 mb-2">{{ $ttdSettings->mengetahui_jabatan }}</p>
                                <p class="text-sm text-gray-600 mb-4">{{ $ttdSettings->mengetahui_unit }}</p>
                                
                                <!-- Tampilkan foto TTD jika ada -->
                                @if($ttdSettings->mengetahui_photo)
                                    <div class="mb-2">
                                        <img src="{{ secure_asset('storage/ttd_photos/' . $ttdSettings->mengetahui_photo) }}" 
                                             alt="TTD Mengetahui" 
                                             class="mx-auto h-16 w-auto object-contain border border-gray-300 rounded">
                                        <p class="text-xs text-gray-500 mt-1">Preview TTD</p>
                                    </div>
                                @else
                                    <div class="h-20 border-b border-gray-300 mb-2"></div>
                                @endif
                                
                                <p class="text-sm font-medium text-gray-900">{{ $ttdSettings->mengetahui_nama }}</p>
                                <p class="text-sm text-gray-600">{{ $ttdSettings->mengetahui_pangkat }}</p>
                                <p class="text-sm text-gray-600">NIP: {{ $ttdSettings->mengetahui_nip }}</p>
                            </div>

                            <!-- Menyetujui Preview -->
                            <div class="text-center">
                                <p class="text-sm text-gray-600 mb-4">{{ $ttdSettings->menyetujui_lokasi ?? 'Surabaya' }}, {{ $ttdSettings->menyetujui_tanggal ? \Carbon\Carbon::parse($ttdSettings->menyetujui_tanggal)->format('d F Y') : date('d F Y') }}</p>
                                <p class="text-sm text-gray-600 mb-2">{{ $ttdSettings->menyetujui_jabatan }}</p>
                                
                                <!-- Tampilkan foto TTD jika ada -->
                                @if($ttdSettings->menyetujui_photo)
                                    <div class="mb-2">
                                        <img src="{{ secure_asset('storage/ttd_photos/' . $ttdSettings->menyetujui_photo) }}" 
                                             alt="TTD Menyetujui" 
                                             class="mx-auto h-16 w-auto object-contain border border-gray-300 rounded">
                                        <p class="text-xs text-gray-500 mt-1">Preview TTD</p>
                                    </div>
                                @else
                                    <div class="h-20 border-b border-gray-300 mb-2"></div>
                                @endif
                                
                                <p class="text-sm font-medium text-gray-900">{{ $ttdSettings->menyetujui_nama }}</p>
                                <p class="text-sm text-gray-600">{{ $ttdSettings->menyetujui_pangkat }}</p>
                                <p class="text-sm text-gray-600">NIP: {{ $ttdSettings->menyetujui_nip }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end space-x-4 pt-6">
                        <x-primary-button>
                            {{ __('Simpan Pengaturan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-sidebar-layout>
