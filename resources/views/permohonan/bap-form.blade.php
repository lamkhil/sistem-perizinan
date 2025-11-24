{{-- FILE: resources/views/permohonan/bap-form.blade.php --}}
{{-- FORM BAP dengan field otomatis dan tabel persyaratan dinamis --}}
<style>
    .sr-only {
        position: absolute;
        width: 1px;
        height: 1px;
        padding: 0;
        margin: -1px;
        overflow: hidden;
        clip: rect(0, 0, 0, 0);
        white-space: nowrap;
        border-width: 0;
    }
    /* Ensure form doesn't overflow */
    .bap-form-container {
        max-width: 100%;
        overflow-x: hidden;
        position: relative;
    }
    /* Ensure table doesn't cause overflow */
    .persyaratan-table-container {
        max-height: none;
        overflow-y: visible;
    }
</style>
<x-sidebar-layout>
    <x-slot name="header">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex-1">
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Form Berita Acara Pemeriksaan</h1>
                        <p class="text-sm text-gray-500 font-mono">{{ $permohonan->no_permohonan }}</p>
                    </div>
                </div>
            </div>
            
            <div class="flex items-center space-x-3">
                <a href="{{ route('permohonan.show', $permohonan) }}" 
                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Main Content -->
    <div class="space-y-6 pb-12 bap-form-container">
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">Terjadi kesalahan saat memproses form:</h3>
                        <div class="mt-2 text-sm text-red-700">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('permohonan.bap.generate', $permohonan) }}" 
              x-data="{
                  persyaratan: [],
                  addPersyaratan() {
                      this.persyaratan.push({ nama: '', status: '', subItems: [] });
                  },
                  removePersyaratan(index) {
                      this.persyaratan.splice(index, 1);
                  },
                  addSubItem(parentIndex) {
                      if (!this.persyaratan[parentIndex].subItems) {
                          this.$set(this.persyaratan[parentIndex], 'subItems', []);
                      }
                      this.persyaratan[parentIndex].subItems.push({ nama: '', status: '' });
                  },
                  removeSubItem(parentIndex, subIndex) {
                      if (this.persyaratan[parentIndex].subItems && this.persyaratan[parentIndex].subItems.length > 0) {
                          this.persyaratan[parentIndex].subItems.splice(subIndex, 1);
                      }
                  },
                  validateForm() {
                      if (this.persyaratan.length === 0) {
                          alert('Mohon tambahkan minimal 1 persyaratan sebelum generate PDF!');
                          return false;
                      }
                      // Validasi setiap persyaratan harus punya nama dan status
                      for (let i = 0; i < this.persyaratan.length; i++) {
                          if (!this.persyaratan[i].nama || !this.persyaratan[i].status) {
                              alert('Mohon lengkapi semua persyaratan (nama dan status) sebelum generate PDF!');
                              return false;
                          }
                      }
                      return true;
                  },
                  toggleCatatan() {
                      const disetujui = document.getElementById('keputusan_disetujui');
                      const catatanContainer = document.getElementById('catatan-container');
                      const catatan = document.getElementById('catatan');
                      if (disetujui && disetujui.checked) {
                          catatanContainer.classList.add('hidden');
                          catatan.removeAttribute('required');
                      } else {
                          catatanContainer.classList.remove('hidden');
                          catatan.setAttribute('required', 'required');
                      }
                  }
              }"
              @submit.prevent="if (validateForm()) { $el.submit(); }">
            @csrf

            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="text-center mb-6">
                    <div class="flex items-center justify-center mb-4">
                        <img src="{{ asset('images/BAP.jpg') }}" alt="Logo Surabaya" class="h-20 w-auto">
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-2">PEMERINTAH KOTA SURABAYA</h2>
                    <h3 class="text-lg font-bold text-gray-800 mb-1">DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU</h3>
                    <p class="text-sm text-gray-600">Gedung Siola Lt. 3 Jalan Tunjungan No.1-3 Surabaya (60275)</p>
                    <p class="text-sm text-gray-600">Tlp.031-99001785 Fax. 031-99001785</p>
                </div>

                <div class="text-center mb-6">
                    <h1 class="text-xl font-bold text-gray-900 mb-2 underline">BERITA ACARA PEMERIKSAAN</h1>
                    <div class="space-y-2">
                        <div class="flex items-center justify-center gap-4">
                            <label for="nomor_bap" class="text-sm font-medium text-gray-700">Nomor BAP:</label>
                            <input type="text" id="nomor_bap" name="nomor_bap" required
                                   class="px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                   placeholder="BAP/OSS/X/PARKIR-377/436.7.15/2025">
                        </div>
                        <div class="flex items-center justify-center gap-4">
                            <label for="tanggal_pemeriksaan" class="text-sm font-medium text-gray-700">Hari/Tanggal Pemeriksaan:</label>
                            <input type="date" id="tanggal_pemeriksaan" name="tanggal_pemeriksaan" required
                                   value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                                   class="px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Permohonan (Auto-filled) -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Permohonan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="no_permohonan" class="block text-sm font-medium text-gray-700 mb-1">Nomor Permohonan</label>
                        <input type="text" id="no_permohonan" name="no_permohonan" value="{{ $permohonan->no_permohonan ?? 'N/A' }}" readonly
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm text-gray-600">
                    </div>
                    <div>
                        <label for="tanggal_permohonan" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Permohonan</label>
                        <input type="text" id="tanggal_permohonan" name="tanggal_permohonan"
                               value="{{ $permohonan->tanggal_permohonan ? $permohonan->tanggal_permohonan->locale('id')->translatedFormat('d F Y') : ($permohonan->created_at ? $permohonan->created_at->locale('id')->translatedFormat('d F Y') : 'N/A') }}" 
                               readonly
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm text-gray-600">
                    </div>
                    <div>
                        <label for="nama_pelaku_usaha" class="block text-sm font-medium text-gray-700 mb-1">Nama Pelaku Usaha <span class="text-red-500">*</span></label>
                        <input type="text" id="nama_pelaku_usaha" name="nama_pelaku_usaha" 
                               value="{{ old('nama_pelaku_usaha', '') }}" 
                               required
                               autocomplete="off"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                               placeholder="Masukkan nama pelaku usaha">
                    </div>
                    <div>
                        <label for="alamat_pelaku_usaha" class="block text-sm font-medium text-gray-700 mb-1">Alamat Pelaku Usaha <span class="text-red-500">*</span></label>
                        <input type="text" id="alamat_pelaku_usaha" name="alamat_pelaku_usaha" 
                               value="{{ old('alamat_pelaku_usaha', '') }}" 
                               required
                               autocomplete="off"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                               placeholder="Masukkan alamat pelaku usaha">
                    </div>
                    <div>
                        <label for="nama_usaha" class="block text-sm font-medium text-gray-700 mb-1">Nama Usaha</label>
                        <input type="text" id="nama_usaha" name="nama_usaha" value="{{ $permohonan->nama_usaha ?? 'N/A' }}" readonly
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm text-gray-600">
                    </div>
                    <div>
                        <label for="alamat_usaha" class="block text-sm font-medium text-gray-700 mb-1">Alamat Usaha</label>
                        <input type="text" id="alamat_usaha" name="alamat_usaha" value="{{ $permohonan->alamat_perusahaan ?? 'N/A' }}" readonly
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm text-gray-600">
                    </div>
                    <div>
                        <label for="nib" class="block text-sm font-medium text-gray-700 mb-1">Nomor Induk Berusaha (NIB)</label>
                        <input type="text" id="nib" name="nib" value="{{ $permohonan->nib ?? 'N/A' }}" readonly
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm text-gray-600">
                    </div>
                    <div>
                        <label for="kbli" class="block text-sm font-medium text-gray-700 mb-1">KBLI</label>
                        <input type="text" id="kbli" name="kbli" value="{{ $permohonan->kbli ?? 'N/A' }}" readonly
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm text-gray-600">
                    </div>
                    <div>
                        <label for="skala_usaha" class="block text-sm font-medium text-gray-700 mb-1">Skala Usaha</label>
                        <input type="text" id="skala_usaha" name="skala_usaha" value="{{ $permohonan->skala_usaha ?? 'N/A' }}" readonly
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm text-gray-600">
                    </div>
                    <div>
                        <label for="tingkat_risiko" class="block text-sm font-medium text-gray-700 mb-1">Tingkat Risiko</label>
                        <input type="text" id="tingkat_risiko" name="tingkat_risiko" value="{{ $permohonan->risiko ?? 'N/A' }}" readonly
                               class="w-full px-3 py-2 bg-gray-50 border border-gray-300 rounded-md text-sm text-gray-600">
                    </div>
                </div>
            </div>

            <!-- Tabel Persyaratan -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Jenis Persyaratan</h3>
                    <button type="button" @click="addPersyaratan()"
                            class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Persyaratan
                    </button>
                </div>

                <div class="overflow-x-auto overflow-y-visible">
                    <table class="min-w-full border border-gray-300">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">No</th>
                                <th class="border border-gray-300 px-4 py-2 text-left text-sm font-semibold text-gray-700">Jenis Persyaratan</th>
                                <th class="border border-gray-300 px-4 py-2 text-center text-sm font-semibold text-gray-700">Sesuai</th>
                                <th class="border border-gray-300 px-4 py-2 text-center text-sm font-semibold text-gray-700">Tidak Sesuai</th>
                                <th class="border border-gray-300 px-4 py-2 text-center text-sm font-semibold text-gray-700">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-if="persyaratan.length === 0">
                                <tr>
                                    <td colspan="5" class="border border-gray-300 px-4 py-8 text-center text-sm text-gray-500 bg-yellow-50">
                                        <div class="flex flex-col items-center gap-2">
                                            <svg class="w-8 h-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                            <p class="font-medium text-yellow-800">Belum ada persyaratan!</p>
                                            <p class="text-yellow-700">Klik tombol "Tambah Persyaratan" di atas untuk menambahkan minimal 1 persyaratan sebelum generate PDF.</p>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            <template x-for="(item, index) in persyaratan" :key="index">
                                <tr>
                                    <td class="border border-gray-300 px-4 py-2 text-sm text-center" x-text="index + 1"></td>
                                    <td class="border border-gray-300 px-4 py-2">
                                        <label :for="`persyaratan_${index}_nama`" class="sr-only">Jenis Persyaratan</label>
                                        <input type="text" 
                                               x-model="item.nama"
                                               :id="`persyaratan_${index}_nama`"
                                               :name="`persyaratan[${index}][nama]`"
                                               :aria-label="`Jenis Persyaratan ${index + 1}`"
                                               required
                                               class="w-full px-2 py-1 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="Masukkan jenis persyaratan">
                                        <div class="mt-2 space-y-2">
                                            <template x-if="item.subItems && item.subItems.length > 0">
                                                <div class="ml-4 space-y-2 border-l-2 border-gray-300 pl-3">
                                                    <template x-for="(subItem, subIndex) in item.subItems" :key="subIndex">
                                                        <div class="flex items-center gap-2 bg-gray-50 p-2 rounded">
                                                            <label :for="`persyaratan_${index}_subItems_${subIndex}_nama`" class="sr-only">Sub Item</label>
                                                            <input type="text" 
                                                                   x-model="subItem.nama"
                                                                   :id="`persyaratan_${index}_subItems_${subIndex}_nama`"
                                                                   :name="`persyaratan[${index}][subItems][${subIndex}][nama]`"
                                                                   :aria-label="`Sub Item ${subIndex + 1} untuk Persyaratan ${index + 1}`"
                                                                   class="flex-1 px-2 py-1 border border-gray-300 rounded text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                                                   placeholder="Masukkan sub item">
                                                            <label :for="`persyaratan_${index}_subItems_${subIndex}_status_sesuai`" class="flex items-center gap-1 text-xs whitespace-nowrap cursor-pointer">
                                                                <input type="radio" 
                                                                       :id="`persyaratan_${index}_subItems_${subIndex}_status_sesuai`"
                                                                       :name="`persyaratan[${index}][subItems][${subIndex}][status]`"
                                                                       :aria-label="`Status Sesuai untuk Sub Item ${subIndex + 1}`"
                                                                       value="Sesuai"
                                                                       x-model="subItem.status"
                                                                       class="w-4 h-4 text-blue-600">
                                                                <span>Sesuai</span>
                                                            </label>
                                                            <label :for="`persyaratan_${index}_subItems_${subIndex}_status_tidak`" class="flex items-center gap-1 text-xs whitespace-nowrap cursor-pointer">
                                                                <input type="radio" 
                                                                       :id="`persyaratan_${index}_subItems_${subIndex}_status_tidak`"
                                                                       :name="`persyaratan[${index}][subItems][${subIndex}][status]`"
                                                                       :aria-label="`Status Tidak Sesuai untuk Sub Item ${subIndex + 1}`"
                                                                       value="Tidak Sesuai"
                                                                       x-model="subItem.status"
                                                                       class="w-4 h-4 text-red-600">
                                                                <span>Tidak</span>
                                                            </label>
                                                            <button type="button" 
                                                                    @click="removeSubItem(index, subIndex)"
                                                                    class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 border border-red-300 rounded hover:bg-red-200 transition-colors">
                                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                </svg>
                                                                Hapus
                                                            </button>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                            <button type="button" 
                                                    @click="addSubItem(index)"
                                                    class="ml-4 inline-flex items-center px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 border border-blue-300 rounded hover:bg-blue-200 transition-colors">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Tambah Sub Item
                                            </button>
                                        </div>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <label :for="`persyaratan_${index}_status_sesuai`" class="flex items-center justify-center cursor-pointer">
                                            <input type="radio" 
                                                   :id="`persyaratan_${index}_status_sesuai`"
                                                   :name="`persyaratan[${index}][status]`"
                                                   :aria-label="`Status Sesuai untuk Persyaratan ${index + 1}`"
                                                   value="Sesuai"
                                                   x-model="item.status"
                                                   required
                                                   class="w-5 h-5 text-blue-600">
                                        </label>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <label :for="`persyaratan_${index}_status_tidak`" class="flex items-center justify-center cursor-pointer">
                                            <input type="radio" 
                                                   :id="`persyaratan_${index}_status_tidak`"
                                                   :name="`persyaratan[${index}][status]`"
                                                   :aria-label="`Status Tidak Sesuai untuk Persyaratan ${index + 1}`"
                                                   value="Tidak Sesuai"
                                                   x-model="item.status"
                                                   required
                                                   class="w-5 h-5 text-red-600">
                                        </label>
                                    </td>
                                    <td class="border border-gray-300 px-4 py-2 text-center">
                                        <button type="button" 
                                                @click="removePersyaratan(index)"
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-red-700 bg-red-100 border border-red-300 rounded hover:bg-red-200 transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Data Tambahan -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Tambahan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nomor_surat_tugas" class="block text-sm font-medium text-gray-700 mb-1">Nomor Surat Perintah Tugas</label>
                        <input type="text" id="nomor_surat_tugas" name="nomor_surat_tugas"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div>
                        <label for="tanggal_surat_tugas" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Surat Perintah Tugas</label>
                        <input type="date" id="tanggal_surat_tugas" name="tanggal_surat_tugas"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label for="hasil_peninjauan_lapangan" class="block text-sm font-medium text-gray-700 mb-1">Hasil Peninjauan Lapangan</label>
                        <textarea id="hasil_peninjauan_lapangan" name="hasil_peninjauan_lapangan" rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                  placeholder="Masukkan hasil peninjauan lapangan"></textarea>
                    </div>
                </div>
            </div>

            <!-- Keputusan -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Keputusan</h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-700 mb-2">
                            Berdasarkan hal tersebut, maka permohonan tersebut diatas 
                            <strong>(Disetujui / Perbaikan / Penolakan Perizinan)</strong> dengan catatan:
                        </p>
                        <div class="flex gap-4 mb-3">
                            <label class="flex items-center">
                                <input type="radio" id="keputusan_disetujui" name="keputusan" value="Disetujui" required class="mr-2" x-on:change="toggleCatatan()">
                                <span class="text-sm">Disetujui</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" id="keputusan_perbaikan" name="keputusan" value="Perbaikan" required class="mr-2" x-on:change="toggleCatatan()">
                                <span class="text-sm">Perbaikan</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" id="keputusan_penolakan" name="keputusan" value="Penolakan" required class="mr-2" x-on:change="toggleCatatan()">
                                <span class="text-sm">Penolakan Perizinan</span>
                            </label>
                        </div>
                        <div id="catatan-container" class="hidden">
                            <textarea id="catatan" name="catatan" rows="4"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                      placeholder="Masukkan catatan..."></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tanda Tangan Digital -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tanda Tangan Digital</h3>
                
                <!-- Baris 1: Memeriksa (kiri) dan Menyetujui (kanan) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <!-- Memeriksa -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2 text-center">Memeriksa</label>
                        <p class="text-xs text-gray-600 mb-1 text-center">Verifikator Tim Perizinan</p>
                        <div class="border-2 border-gray-300 rounded-lg bg-white" style="position: relative;">
                            <canvas id="signatureCanvasMemeriksa" width="800" height="200" style="display: block; width: 100%; height: 200px; touch-action: none;"></canvas>
                        </div>
                        <div class="mt-2 flex gap-2 justify-center">
                            <button type="button" id="clearMemeriksa" class="px-3 py-1 bg-gray-500 text-white text-xs rounded hover:bg-gray-600">
                                Hapus
                            </button>
                            <button type="button" id="saveMemeriksa" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                                Simpan TTD
                            </button>
                        </div>
                        <input type="hidden" id="ttd_memeriksa" name="ttd_memeriksa" value="">
                        <div class="mt-3 space-y-2">
                            <div>
                                <label for="nama_memeriksa" class="block text-xs font-medium text-gray-700 mb-1">Nama</label>
                                <input type="text" id="nama_memeriksa" name="nama_memeriksa" 
                                       class="w-full px-2 py-1 text-xs border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Masukkan nama">
                            </div>
                            <div>
                                <label for="nip_memeriksa" class="block text-xs font-medium text-gray-700 mb-1">NIP</label>
                                <input type="text" id="nip_memeriksa" name="nip_memeriksa" 
                                       class="w-full px-2 py-1 text-xs border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       placeholder="Masukkan NIP">
                            </div>
                        </div>
                        <div id="previewMemeriksa" class="mt-2 hidden text-center">
                            <p class="text-xs text-gray-600 mb-1">Preview:</p>
                            <img id="previewImgMemeriksa" src="" alt="TTD Preview" class="max-h-20 border border-gray-300 rounded mx-auto">
                        </div>
                    </div>

                    <!-- Menyetujui -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2 text-center">Menyetujui</label>
                        <p class="text-xs text-gray-600 mb-1 text-center">Validator Tim Perizinan</p>
                        <div class="border-2 border-gray-300 rounded-lg bg-white" style="position: relative;">
                            <canvas id="signatureCanvasMenyetujui" width="800" height="200" style="display: block; width: 100%; height: 200px; touch-action: none;"></canvas>
                        </div>
                        <div class="mt-2 flex gap-2 justify-center">
                            <button type="button" id="clearMenyetujui" class="px-3 py-1 bg-gray-500 text-white text-xs rounded hover:bg-gray-600">
                                Hapus
                            </button>
                            <button type="button" id="saveMenyetujui" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                                Simpan TTD
                            </button>
                        </div>
                        <input type="hidden" id="ttd_menyetujui" name="ttd_menyetujui" value="">
                        <div class="mt-3 space-y-2">
                            <div>
                                <label for="nama_menyetujui" class="block text-xs font-medium text-gray-700 mb-1">Nama</label>
                                <input type="text" id="nama_menyetujui" name="nama_menyetujui" 
                                       class="w-full px-2 py-1 text-xs border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <label for="nip_menyetujui" class="block text-xs font-medium text-gray-700 mb-1">NIP</label>
                                <input type="text" id="nip_menyetujui" name="nip_menyetujui" 
                                       class="w-full px-2 py-1 text-xs border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        <div id="previewMenyetujui" class="mt-2 hidden text-center">
                            <p class="text-xs text-gray-600 mb-1">Preview:</p>
                            <img id="previewImgMenyetujui" src="" alt="TTD Preview" class="max-h-20 border border-gray-300 rounded mx-auto">
                        </div>
                    </div>
                </div>
                
                <!-- Baris 2: Mengetahui (tengah) -->
                <div class="flex justify-center mb-8">
                    <div class="w-full md:w-1/2">
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-sm font-medium text-gray-700 text-center flex-1">Mengetahui</label>
                            @if($isAdmin ?? false)
                                <button type="button" 
                                        @click="$refs.editTtdForm.classList.toggle('hidden')"
                                        class="px-3 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit TTD
                                </button>
                            @endif
                        </div>
                        <p class="text-xs text-gray-600 mb-1 text-center">Koordinator Ketua Tim Kerja</p>
                        <p class="text-xs text-gray-600 mb-1 text-center">Pelayanan Terpadu Satu Pintu</p>
                        
                        <!-- Form Edit TTD (Admin Only, Hidden by default) -->
                        @if($isAdmin ?? false)
                            <div x-ref="editTtdForm" x-data="{ show: false }" class="hidden mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <form method="POST" action="{{ route('bap.ttd.update') }}" enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <div>
                                            <label for="edit_nama_mengetahui" class="block text-xs font-medium text-gray-700 mb-1">Nama</label>
                                            <input type="text" id="edit_nama_mengetahui" name="nama_mengetahui" 
                                                   value="{{ $koordinator->nama_mengetahui ?? '' }}"
                                                   required
                                                   class="w-full px-2 py-1 text-xs border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                        </div>
                                        <div>
                                            <label for="edit_nip_mengetahui" class="block text-xs font-medium text-gray-700 mb-1">NIP</label>
                                            <input type="text" id="edit_nip_mengetahui" name="nip_mengetahui" 
                                                   value="{{ $koordinator->nip_mengetahui ?? '' }}"
                                                   required
                                                   class="w-full px-2 py-1 text-xs border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="ttd_bap_mengetahui_file" class="block text-xs font-medium text-gray-700 mb-1">Upload TTD (File)</label>
                                        <input type="file" id="ttd_bap_mengetahui_file" name="ttd_bap_mengetahui_file" 
                                               accept="image/*"
                                               class="w-full px-2 py-1 text-xs border border-gray-300 rounded-md focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
                                    </div>
                                    <div class="border-2 border-gray-300 rounded-lg bg-white" style="position: relative;">
                                        <canvas id="editSignatureCanvasMengetahui" width="800" height="200" style="display: block; width: 100%; height: 200px; touch-action: none;"></canvas>
                                    </div>
                                    <div class="flex gap-2 justify-center">
                                        <button type="button" id="clearEditMengetahui" class="px-3 py-1 bg-gray-500 text-white text-xs rounded hover:bg-gray-600">
                                            Hapus
                                        </button>
                                        <button type="button" id="saveEditMengetahui" class="px-3 py-1 bg-yellow-600 text-white text-xs rounded hover:bg-yellow-700">
                                            Simpan TTD
                                        </button>
                                    </div>
                                    <input type="hidden" id="edit_ttd_bap_mengetahui" name="ttd_bap_mengetahui" value="">
                                    <div class="flex gap-2 justify-end">
                                        <button type="button" 
                                                @click="$refs.editTtdForm.classList.add('hidden')"
                                                class="px-3 py-1 bg-gray-500 text-white text-xs rounded hover:bg-gray-600">
                                            Batal
                                        </button>
                                        <button type="submit" class="px-3 py-1 bg-yellow-600 text-white text-xs rounded hover:bg-yellow-700">
                                            Simpan Pengaturan
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                        
                        <!-- TTD Display Area -->
                        <div class="border-2 border-gray-300 rounded-lg bg-white" style="position: relative;">
                            @if($koordinator->ttd_bap_mengetahui)
                                @php
                                    $ttdSrc = $koordinator->ttd_bap_mengetahui;
                                    // Jika bukan base64, berarti path file
                                    if (!str_starts_with($ttdSrc, 'data:image')) {
                                        $ttdSrc = asset('storage/ttd_photos/' . $ttdSrc);
                                    }
                                @endphp
                                <img id="displayTtdMengetahui" src="{{ $ttdSrc }}" alt="TTD Mengetahui" class="w-full h-48 object-contain">
                            @else
                                <canvas id="signatureCanvasMengetahui" width="800" height="200" style="display: block; width: 100%; height: 200px; touch-action: none;"></canvas>
                            @endif
                        </div>
                        <div class="mt-2 flex gap-2 justify-center">
                            @if(!$koordinator->ttd_bap_mengetahui)
                                <button type="button" id="clearMengetahui" class="px-3 py-1 bg-gray-500 text-white text-xs rounded hover:bg-gray-600">
                                    Hapus
                                </button>
                                <button type="button" id="saveMengetahui" class="px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">
                                    Simpan TTD
                                </button>
                            @endif
                        </div>
                        <input type="hidden" id="ttd_mengetahui" name="ttd_mengetahui" value="{{ $koordinator->ttd_bap_mengetahui ?? '' }}">
                        <div class="mt-3 space-y-2">
                            <div>
                                <label for="nama_mengetahui" class="block text-xs font-medium text-gray-700 mb-1">Nama</label>
                                <input type="text" id="nama_mengetahui" name="nama_mengetahui" 
                                       class="w-full px-2 py-1 text-xs border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ $koordinator->nama_mengetahui ?? '' }}"
                                       placeholder="Masukkan nama"
                                       @if($koordinator->ttd_bap_mengetahui) readonly @endif>
                            </div>
                            <div>
                                <label for="nip_mengetahui" class="block text-xs font-medium text-gray-700 mb-1">NIP</label>
                                <input type="text" id="nip_mengetahui" name="nip_mengetahui" 
                                       class="w-full px-2 py-1 text-xs border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       value="{{ $koordinator->nip_mengetahui ?? '' }}"
                                       placeholder="Masukkan NIP"
                                       @if($koordinator->ttd_bap_mengetahui) readonly @endif>
                            </div>
                        </div>
                        <div id="previewMengetahui" class="mt-2 hidden">
                            <p class="text-xs text-gray-600 mb-1">Preview:</p>
                            <img id="previewImgMengetahui" src="" alt="TTD Preview" class="max-h-20 border border-gray-300 rounded mx-auto">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('permohonan.show', $permohonan) }}"
                   class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                    Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Generate PDF BAP
                </button>
            </div>
        </form>
    </div>

    <!-- Script untuk Signature Pad -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Tunggu sampai SignaturePad tersedia
            function initSignaturePads() {
                if (typeof SignaturePad === 'undefined') {
                    setTimeout(initSignaturePads, 100);
                    return;
                }

                // Initialize Signature Pad untuk Memeriksa
                const canvasMemeriksa = document.getElementById('signatureCanvasMemeriksa');
                let signaturePadMemeriksa = null;

                if (canvasMemeriksa) {
                    setTimeout(() => {
                        const rect = canvasMemeriksa.getBoundingClientRect();
                        if (rect.width > 0 && rect.height > 0) {
                            const ratio = Math.max(window.devicePixelRatio || 1, 1);
                            canvasMemeriksa.width = rect.width * ratio;
                            canvasMemeriksa.height = rect.height * ratio;
                            const ctx = canvasMemeriksa.getContext('2d');
                            ctx.scale(ratio, ratio);

                            signaturePadMemeriksa = new SignaturePad(canvasMemeriksa, {
                                backgroundColor: 'rgb(255, 255, 255)',
                                penColor: 'rgb(0, 0, 0)',
                                minWidth: 1,
                                maxWidth: 3,
                            });

                            // Clear button
                            document.getElementById('clearMemeriksa').addEventListener('click', () => {
                                signaturePadMemeriksa.clear();
                                document.getElementById('ttd_memeriksa').value = '';
                                document.getElementById('previewMemeriksa').classList.add('hidden');
                            });

                            // Save button
                            document.getElementById('saveMemeriksa').addEventListener('click', () => {
                                if (signaturePadMemeriksa.isEmpty()) {
                                    alert('Mohon buat tanda tangan terlebih dahulu!');
                                    return;
                                }
                                const dataURL = signaturePadMemeriksa.toDataURL('image/png', 1.0);
                                document.getElementById('ttd_memeriksa').value = dataURL;
                                document.getElementById('previewImgMemeriksa').src = dataURL;
                                document.getElementById('previewMemeriksa').classList.remove('hidden');
                                
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'TTD Tersimpan',
                                        text: 'Tanda tangan Memeriksa telah disimpan.',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            });
                        }
                    }, 300);
                }

                // Initialize Signature Pad untuk Menyetujui
                const canvasMenyetujui = document.getElementById('signatureCanvasMenyetujui');
                let signaturePadMenyetujui = null;

                if (canvasMenyetujui) {
                    setTimeout(() => {
                        const rect = canvasMenyetujui.getBoundingClientRect();
                        if (rect.width > 0 && rect.height > 0) {
                            const ratio = Math.max(window.devicePixelRatio || 1, 1);
                            canvasMenyetujui.width = rect.width * ratio;
                            canvasMenyetujui.height = rect.height * ratio;
                            const ctx = canvasMenyetujui.getContext('2d');
                            ctx.scale(ratio, ratio);

                            signaturePadMenyetujui = new SignaturePad(canvasMenyetujui, {
                                backgroundColor: 'rgb(255, 255, 255)',
                                penColor: 'rgb(0, 0, 0)',
                                minWidth: 1,
                                maxWidth: 3,
                            });

                            // Clear button
                            document.getElementById('clearMenyetujui').addEventListener('click', () => {
                                signaturePadMenyetujui.clear();
                                document.getElementById('ttd_menyetujui').value = '';
                                document.getElementById('previewMenyetujui').classList.add('hidden');
                            });

                            // Save button
                            document.getElementById('saveMenyetujui').addEventListener('click', () => {
                                if (signaturePadMenyetujui.isEmpty()) {
                                    alert('Mohon buat tanda tangan terlebih dahulu!');
                                    return;
                                }
                                const dataURL = signaturePadMenyetujui.toDataURL('image/png', 1.0);
                                document.getElementById('ttd_menyetujui').value = dataURL;
                                document.getElementById('previewImgMenyetujui').src = dataURL;
                                document.getElementById('previewMenyetujui').classList.remove('hidden');
                                
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'TTD Tersimpan',
                                        text: 'Tanda tangan Menyetujui telah disimpan.',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            });
                        }
                    }, 300);
                }

                // Initialize Signature Pad untuk Mengetahui
                const canvasMengetahui = document.getElementById('signatureCanvasMengetahui');
                let signaturePadMengetahui = null;

                if (canvasMengetahui) {
                    setTimeout(() => {
                        const rect = canvasMengetahui.getBoundingClientRect();
                        if (rect.width > 0 && rect.height > 0) {
                            const ratio = Math.max(window.devicePixelRatio || 1, 1);
                            canvasMengetahui.width = rect.width * ratio;
                            canvasMengetahui.height = rect.height * ratio;
                            const ctx = canvasMengetahui.getContext('2d');
                            ctx.scale(ratio, ratio);

                            signaturePadMengetahui = new SignaturePad(canvasMengetahui, {
                                backgroundColor: 'rgb(255, 255, 255)',
                                penColor: 'rgb(0, 0, 0)',
                                minWidth: 1,
                                maxWidth: 3,
                            });

                            // Clear button
                            document.getElementById('clearMengetahui').addEventListener('click', () => {
                                signaturePadMengetahui.clear();
                                document.getElementById('ttd_mengetahui').value = '';
                                document.getElementById('previewMengetahui').classList.add('hidden');
                            });

                            // Save button
                            document.getElementById('saveMengetahui').addEventListener('click', () => {
                                if (signaturePadMengetahui.isEmpty()) {
                                    alert('Mohon buat tanda tangan terlebih dahulu!');
                                    return;
                                }
                                const dataURL = signaturePadMengetahui.toDataURL('image/png', 1.0);
                                document.getElementById('ttd_mengetahui').value = dataURL;
                                document.getElementById('previewImgMengetahui').src = dataURL;
                                document.getElementById('previewMengetahui').classList.remove('hidden');
                                
                                if (typeof Swal !== 'undefined') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'TTD Tersimpan',
                                        text: 'Tanda tangan Mengetahui telah disimpan.',
                                        toast: true,
                                        position: 'top-end',
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            });
                        }
                    }, 300);
                }
            }

            initSignaturePads();
            
            // Initialize Signature Pad untuk Edit TTD Mengetahui (Admin Only)
            @if($isAdmin ?? false)
                const editCanvasMengetahui = document.getElementById('editSignatureCanvasMengetahui');
                let editSignaturePadMengetahui = null;

                if (editCanvasMengetahui) {
                    setTimeout(() => {
                        const rect = editCanvasMengetahui.getBoundingClientRect();
                        if (rect.width > 0 && rect.height > 0) {
                            const ratio = Math.max(window.devicePixelRatio || 1, 1);
                            editCanvasMengetahui.width = rect.width * ratio;
                            editCanvasMengetahui.height = rect.height * ratio;
                            const ctx = editCanvasMengetahui.getContext('2d');
                            ctx.scale(ratio, ratio);

                            editSignaturePadMengetahui = new SignaturePad(editCanvasMengetahui, {
                                backgroundColor: 'rgb(255, 255, 255)',
                                penColor: 'rgb(0, 0, 0)',
                                minWidth: 1,
                                maxWidth: 3,
                            });

                            // Load existing TTD if available
                            @if($koordinator->ttd_bap_mengetahui && str_starts_with($koordinator->ttd_bap_mengetahui, 'data:image'))
                                const existingTtd = '{{ $koordinator->ttd_bap_mengetahui }}';
                                const img = new Image();
                                img.onload = function() {
                                    ctx.drawImage(img, 0, 0, rect.width, rect.height);
                                };
                                img.src = existingTtd;
                            @endif

                            // Clear button
                            const clearEditBtn = document.getElementById('clearEditMengetahui');
                            if (clearEditBtn) {
                                clearEditBtn.addEventListener('click', () => {
                                    editSignaturePadMengetahui.clear();
                                    document.getElementById('edit_ttd_bap_mengetahui').value = '';
                                });
                            }

                            // Save button
                            const saveEditBtn = document.getElementById('saveEditMengetahui');
                            if (saveEditBtn) {
                                saveEditBtn.addEventListener('click', () => {
                                    if (editSignaturePadMengetahui.isEmpty()) {
                                        alert('Mohon buat tanda tangan terlebih dahulu!');
                                        return;
                                    }
                                    const dataURL = editSignaturePadMengetahui.toDataURL('image/png', 1.0);
                                    document.getElementById('edit_ttd_bap_mengetahui').value = dataURL;
                                    
                                    if (typeof Swal !== 'undefined') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'TTD Tersimpan',
                                            text: 'Tanda tangan telah disimpan. Klik "Simpan Pengaturan" untuk menyimpan ke database.',
                                            toast: true,
                                            position: 'top-end',
                                            showConfirmButton: false,
                                            timer: 3000
                                        });
                                    }
                                });
                            }
                        }
                    }, 300);
                }
            @endif
        });
    </script>
</x-sidebar-layout>

