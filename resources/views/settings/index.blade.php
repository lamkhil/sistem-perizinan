<x-sidebar-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-gradient-to-br from-primary-500 to-primary-700">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </div>
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Pengaturan
                </h2>
                <p class="text-sm text-gray-500">Kelola pengaturan sistem</p>
            </div>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <!-- TTD Settings Card -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-shadow duration-300 mb-6">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-white">Pengaturan TTD Penerbitan Berkas</h3>
                </div>
                <a href="{{ route('ttd-settings.index') }}" class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-white text-sm font-medium transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    Kelola
                </a>
            </div>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-600 mb-4">
                Kelola pengaturan tanda tangan digital untuk dokumen penerbitan berkas, termasuk informasi Mengetahui dan Menyetujui.
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Status:</p>
                    <p class="font-medium text-gray-900">
                        @if($ttdSettings && $ttdSettings->mengetahui_nama)
                            <span class="text-green-600">✓ Terkonfigurasi</span>
                        @else
                            <span class="text-yellow-600">⚠ Belum dikonfigurasi</span>
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Terakhir diupdate:</p>
                    <p class="font-medium text-gray-900">
                        @if($ttdSettings && $ttdSettings->updated_at)
                            {{ $ttdSettings->updated_at->format('d M Y H:i') }}
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- App Settings / Koordinator BAP Card -->
    <div class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-shadow duration-300">
        <div class="bg-gradient-to-r from-primary-500 to-primary-600 px-6 py-4">
            <div class="flex items-center space-x-3">
                <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-white/20 backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-white">Pengaturan Koordinator BAP</h3>
            </div>
        </div>
        <div class="p-6">
            <p class="text-sm text-gray-600 mb-6">
                Kelola informasi koordinator untuk bagian "Mengetahui" pada dokumen BAP (Berita Acara Pemeriksaan).
            </p>
            
            <form method="POST" action="{{ route('bap.ttd.update') }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="nama_mengetahui" :value="__('Nama Koordinator')" class="text-gray-700 font-medium" />
                        <div class="mt-2 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <x-text-input id="nama_mengetahui" name="nama_mengetahui" type="text" class="pl-10 block w-full" :value="old('nama_mengetahui', $appSettings->nama_mengetahui ?? '')" required autocomplete="off" />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('nama_mengetahui')" />
                    </div>

                    <div>
                        <x-input-label for="nip_mengetahui" :value="__('NIP Koordinator')" class="text-gray-700 font-medium" />
                        <div class="mt-2 relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path>
                                </svg>
                            </div>
                            <x-text-input id="nip_mengetahui" name="nip_mengetahui" type="text" class="pl-10 block w-full" :value="old('nip_mengetahui', $appSettings->nip_mengetahui ?? '')" required autocomplete="off" />
                        </div>
                        <x-input-error class="mt-2" :messages="$errors->get('nip_mengetahui')" />
                    </div>
                </div>

                <div>
                    <x-input-label for="ttd_bap_mengetahui_file" :value="__('Tanda Tangan Digital (Opsional)')" class="text-gray-700 font-medium" />
                    <div class="mt-2">
                        <input id="ttd_bap_mengetahui_file" name="ttd_bap_mengetahui_file" type="file" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100" />
                        <p class="text-xs text-gray-500 mt-1">Upload gambar tanda tangan (JPG, PNG, maksimal 2MB)</p>
                        @if($appSettings && $appSettings->ttd_bap_mengetahui)
                            <div class="mt-2 p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-green-600 mb-2">✓ TTD sudah tersimpan</p>
                                <label class="flex items-center">
                                    <input type="checkbox" name="delete_ttd_bap_mengetahui" value="1" class="rounded border-gray-300 text-red-600 shadow-sm focus:border-red-300 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-red-600">Hapus TTD yang tersimpan</span>
                                </label>
                            </div>
                        @endif
                    </div>
                    <x-input-error class="mt-2" :messages="$errors->get('ttd_bap_mengetahui_file')" />
                </div>

                <div class="flex items-center justify-end gap-4 pt-4 border-t border-gray-200">
                    <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-primary-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wider hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-800 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm hover:shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-sidebar-layout>

