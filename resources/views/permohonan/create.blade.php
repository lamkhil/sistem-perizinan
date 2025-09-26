<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Permohonan Baru
        </h2>
    </x-slot>


    <div class="py-12 {{ $cssClasses }}">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <p class="font-bold">Oops! Ada beberapa hal yang perlu diperbaiki:</p>
                            <ul class="list-disc list-inside mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('permohonan.store') }}"
                          x-data="{ jenisPelakuUsaha: '{{ old('jenis_pelaku_usaha', 'Badan Usaha') }}' }">
                        @csrf

                        @php
                            $user = Auth::user();
                            $isAdmin = $user && $user->role === 'admin';
                            $verificationStatusOptions = ['Berkas Disetujui', 'Berkas Diperbaiki', 'Pemohon Dihubungi', 'Berkas Diunggah Ulang', 'Pemohon Belum Dihubungi'];

                            $isReadOnly = function($allowedRoles) use ($isAdmin, $user) {
                                if (!$user) { return true; }
                                if ($isAdmin) { return false; }
                                return !in_array($user->role, (array)$allowedRoles);
                            };

                            $isDisabled = function($allowedRoles) use ($isAdmin, $user) {
                                if (!$user) { return true; }
                                if ($isAdmin) { return false; }
                                return !in_array($user->role, (array)$allowedRoles);
                            };
                        @endphp

                        @php
                            $cssClasses = ($user && $user->role) ? 'role-' . $user->role : '';
                        @endphp

                        <!-- Role-based CSS -->
                        <link rel="stylesheet" href="{{ asset('css/role-based.css') }}">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            {{-- KOLOM KIRI --}}
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Data Pemohon</h3>

                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="no_permohonan" class="block font-medium text-sm text-gray-700">No. Permohonan</label>
                                    <input id="no_permohonan" name="no_permohonan" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['pd_teknis']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('no_permohonan') }}" {{ $isReadOnly(['pd_teknis']) ? 'readonly' : '' }} required />
                                    @error('no_permohonan')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <!-- Pindah No. Proyek ke Data Pemohon untuk Admin & PD Teknis -->
                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="no_proyek" class="block font-medium text-sm text-gray-700">No. Proyek</label>
                                    <input id="no_proyek" name="no_proyek" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['pd_teknis','admin']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('no_proyek') }}" {{ $isReadOnly(['pd_teknis','admin']) ? 'readonly' : '' }} />
                                    @error('no_proyek')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="tanggal_permohonan" class="block font-medium text-sm text-gray-700">Tanggal Permohonan</label>
                                    <input id="tanggal_permohonan" name="tanggal_permohonan" type="date"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['pd_teknis']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('tanggal_permohonan') }}" {{ $isReadOnly(['pd_teknis']) ? 'readonly' : '' }} required />
                                    @error('tanggal_permohonan')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="jenis_pelaku_usaha" class="block font-medium text-sm text-gray-700">Jenis Perusahaan</label>
                                    <select name="jenis_pelaku_usaha" id="jenis_pelaku_usaha"
                                        x-model="jenisPelakuUsaha"
                                        class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isDisabled(['pd_teknis']) ? 'bg-gray-100' : '' }}" {{ $isDisabled(['pd_teknis']) ? 'disabled' : '' }} required>
                                        <option value="">Pilih Jenis Perusahaan</option>
                                        @foreach($jenisPelakuUsahas as $jenis)
                                            <option value="{{ $jenis }}" @selected(old('jenis_pelaku_usaha') == $jenis)>
                                                {{ $jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_pelaku_usaha')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp hide-for-pd-teknis" x-show="jenisPelakuUsaha === 'Orang Perseorangan'">
                                    <label for="nik" class="block font-medium text-sm text-gray-700">Nomor Induk Kependudukan (NIK)</label>
                                    <input id="nik" name="nik" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['pd_teknis']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('nik') }}" placeholder="Masukkan 16 digit NIK" maxlength="16" {{ $isReadOnly(['pd_teknis']) ? 'readonly' : '' }} />
                                    @error('nik')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp hide-for-pd-teknis" x-show="jenisPelakuUsaha === 'Badan Usaha'">
                                    <label for="jenis_badan_usaha" class="block font-medium text-sm text-gray-700">Jenis Badan Usaha</label>
                                    <select name="jenis_badan_usaha" id="jenis_badan_usaha"
                                        class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['pd_teknis']) ? 'bg-gray-100' : '' }}"
                                        {{ $isReadOnly(['pd_teknis']) ? 'disabled' : '' }}>
                                        <option value="">Pilih Jenis Badan Usaha</option>
                                        <option value="Perseroan Terbatas (PT)" @selected(old('jenis_badan_usaha') == 'Perseroan Terbatas (PT)')>
                                            Perseroan Terbatas (PT)
                                        </option>
                                        <option value="Perseroan Terbatas (PT) Perorangan" @selected(old('jenis_badan_usaha') == 'Perseroan Terbatas (PT) Perorangan')>
                                            Perseroan Terbatas (PT) Perorangan
                                        </option>
                                        <option value="Persekutuan Komanditer (CV/Commanditaire Vennootschap)" @selected(old('jenis_badan_usaha') == 'Persekutuan Komanditer (CV/Commanditaire Vennootschap)')>
                                            Persekutuan Komanditer (CV/Commanditaire Vennootschap)
                                        </option>
                                        <option value="Persekutuan Firma (FA / Venootschap Onder Firma)" @selected(old('jenis_badan_usaha') == 'Persekutuan Firma (FA / Venootschap Onder Firma)')>
                                            Persekutuan Firma (FA / Venootschap Onder Firma)
                                        </option>
                                        <option value="Persekutuan Perdata" @selected(old('jenis_badan_usaha') == 'Persekutuan Perdata')>
                                            Persekutuan Perdata
                                        </option>
                                        <option value="Perusahaan Umum (Perum)" @selected(old('jenis_badan_usaha') == 'Perusahaan Umum (Perum)')>
                                            Perusahaan Umum (Perum)
                                        </option>
                                        <option value="Perusahaan Umum Daerah (Perumda)" @selected(old('jenis_badan_usaha') == 'Perusahaan Umum Daerah (Perumda)')>
                                            Perusahaan Umum Daerah (Perumda)
                                        </option>
                                        <option value="Badan Hukum Lainnya" @selected(old('jenis_badan_usaha') == 'Badan Hukum Lainnya')>
                                            Badan Hukum Lainnya
                                        </option>
                                        <option value="Koperasi" @selected(old('jenis_badan_usaha') == 'Koperasi')>
                                            Koperasi
                                        </option>
                                        <option value="Persekutuan dan Perkumpulan" @selected(old('jenis_badan_usaha') == 'Persekutuan dan Perkumpulan')>
                                            Persekutuan dan Perkumpulan
                                        </option>
                                        <option value="Yayasan" @selected(old('jenis_badan_usaha') == 'Yayasan')>
                                            Yayasan
                                        </option>
                                        <option value="Badan Layanan Umum" @selected(old('jenis_badan_usaha') == 'Badan Layanan Umum')>
                                            Badan Layanan Umum
                                        </option>
                                        <option value="BUM Desa" @selected(old('jenis_badan_usaha') == 'BUM Desa')>
                                            BUM Desa
                                        </option>
                                        <option value="BUM Desa Bersama" @selected(old('jenis_badan_usaha') == 'BUM Desa Bersama')>
                                            BUM Desa Bersama
                                        </option>
                                    </select>
                                    @error('jenis_badan_usaha')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                {{-- DPMPTSP mengisi Nama Usaha manual, berbeda dari "Jenis Perusahaan" milik PD Teknis --}}
                                <div class="field-data-pemohon hide-for-pd-teknis">
                                    <label for="nama_usaha" class="block font-medium text-sm text-gray-700">Nama Usaha</label>
                                    <input id="nama_usaha" name="nama_usaha" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['dpmptsp']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('nama_usaha') }}" {{ $isReadOnly(['dpmptsp']) ? 'readonly' : '' }} required />
                                    @error('nama_usaha')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <!-- Nama Perusahaan (kolom milik PD Teknis) -->
                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="nama_perusahaan" class="block font-medium text-sm text-gray-700">Nama Perusahaan</label>
                                    <input id="nama_perusahaan" name="nama_perusahaan" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['pd_teknis']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('nama_perusahaan') }}" {{ $isReadOnly(['pd_teknis']) ? 'readonly' : '' }} />
                                    @error('nama_perusahaan')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="nib" class="block font-medium text-sm text-gray-700">NIB</label>
                                    <input id="nib" name="nib" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['pd_teknis']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('nib') }}" placeholder="Masukkan 20 digit NIB" maxlength="20" {{ $isReadOnly(['pd_teknis']) ? 'readonly' : '' }} required />
                                    @error('nib')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                                
                                <div class="field-data-pemohon hide-for-pd-teknis">
                                    <label for="alamat_perusahaan" class="block font-medium text-sm text-gray-700">Alamat Perusahaan</label>
                                    <textarea id="alamat_perusahaan" name="alamat_perusahaan"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['dpmptsp']) ? 'bg-gray-100' : '' }}" {{ $isReadOnly(['dpmptsp']) ? 'readonly' : '' }} required>{{ old('alamat_perusahaan') }}</textarea>
                                    @error('alamat_perusahaan')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-data-pemohon hide-for-pd-teknis">
                                    <label for="sektor" class="block font-medium text-sm text-gray-700">Sektor</label>
                                    <select name="sektor" id="sektor"
                                        class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isDisabled(['dpmptsp','admin']) ? 'bg-gray-100' : '' }}" {{ $isDisabled(['dpmptsp','admin']) ? 'disabled' : '' }}>
                                        <option value="">Pilih Sektor</option>
                                        @foreach($sektors as $sektor)
                                            <option value="{{ $sektor }}" @selected(old('sektor') == $sektor)>
                                                {{ $sektor }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sektor')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                @if(in_array($user->role, ['admin', 'pd_teknis']))
                                <div>
                                    <label for="kbli" class="block font-medium text-sm text-gray-700">KBLI</label>
                                    <input id="kbli" name="kbli" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"
                                        value="{{ old('kbli') }}" placeholder="Masukkan nomor KBLI" />
                                    @error('kbli')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="inputan_teks" class="block font-medium text-sm text-gray-700">Kegiatan</label>
                                    <input id="inputan_teks" name="inputan_teks" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"
                                        value="{{ old('inputan_teks') }}" placeholder="Masukkan kegiatan" />
                                    @error('inputan_teks')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                                @endif

                                <div class="field-data-pemohon hide-for-pd-teknis">
                                    <label for="modal_usaha" class="block font-medium text-sm text-gray-700">Modal Usaha</label>
                                    <input id="modal_usaha" name="modal_usaha" type="number"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['dpmptsp']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('modal_usaha') }}" {{ $isReadOnly(['dpmptsp']) ? 'readonly' : '' }} required />
                                    @error('modal_usaha')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-data-pemohon hide-for-pd-teknis">
                                    <label for="jenis_proyek" class="block font-medium text-sm text-gray-700">Jenis Proyek</label>
                                    <select name="jenis_proyek" id="jenis_proyek"
                                        class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isDisabled(['dpmptsp']) ? 'bg-gray-100' : '' }}" {{ $isDisabled(['dpmptsp']) ? 'disabled' : '' }} required>
                                        <option value="">Pilih Jenis Proyek</option>
                                        @foreach($jenisProyeks as $proyek)
                                            <option value="{{ $proyek }}" @selected(old('jenis_proyek') == $proyek)>
                                                {{ $proyek }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_proyek')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                @if(in_array($user->role, ['admin', 'dpmptsp']))
                                <div>
                                    <label for="nama_perizinan" class="block font-medium text-sm text-gray-700">Nama Perizinan</label>
                                    <input id="nama_perizinan" name="nama_perizinan" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"
                                        value="{{ old('nama_perizinan') }}" placeholder="Masukkan nama perizinan" />
                                    @error('nama_perizinan')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="skala_usaha" class="block font-medium text-sm text-gray-700">Skala Usaha</label>
                                    <select name="skala_usaha" id="skala_usaha"
                                        class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                        <option value="">Pilih Skala Usaha</option>
                                        <option value="Mikro" @selected(old('skala_usaha') == 'Mikro')>Mikro</option>
                                        <option value="Kecil" @selected(old('skala_usaha') == 'Kecil')>Kecil</option>
                                        <option value="Menengah" @selected(old('skala_usaha') == 'Menengah')>Menengah</option>
                                        <option value="Besar" @selected(old('skala_usaha') == 'Besar')>Besar</option>
                                    </select>
                                    @error('skala_usaha')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="risiko" class="block font-medium text-sm text-gray-700">Risiko</label>
                                    <select name="risiko" id="risiko"
                                        class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">
                                        <option value="">Pilih Risiko</option>
                                        <option value="Rendah" @selected(old('risiko') == 'Rendah')>Rendah</option>
                                        <option value="Sedang" @selected(old('risiko') == 'Sedang')>Sedang</option>
                                        <option value="Tinggi" @selected(old('risiko') == 'Tinggi')>Tinggi</option>
                                    </select>
                                    @error('risiko')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                        <div>
                            <label for="jangka_waktu" class="block font-medium text-sm text-gray-700">Jangka Waktu (Hari Kerja)</label>
                            <input id="jangka_waktu" name="jangka_waktu" type="number"
                                class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"
                                value="{{ old('jangka_waktu') }}" placeholder="Masukkan jangka waktu dalam hari kerja" />
                            @error('jangka_waktu')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="deadline" class="block font-medium text-sm text-gray-700">Deadline (Hari Kerja)</label>
                            <input id="deadline" name="deadline" type="date"
                                class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"
                                value="{{ old('deadline') }}" />
                            @error('deadline')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                        </div>

                                <div>
                                    <label for="no_telephone" class="block font-medium text-sm text-gray-700">No. Telephone</label>
                                    <input id="no_telephone" name="no_telephone" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm"
                                        value="{{ old('no_telephone') }}" placeholder="Masukkan nomor telephone" />
                                    @error('no_telephone')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                                @endif
                            </div> {{-- END: KOLOM KIRI --}}

                            {{-- START: KOLOM KANAN: Verifikasi & Tracking --}}
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Verifikasi & Tracking</h3>

                                
                                
                                <div class="hide-for-pd-teknis">
                                    <label for="verifikator" class="block font-medium text-sm text-gray-700">Verifikator</label>
                                    <select name="verifikator" id="verifikator"
                                        class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isDisabled(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}" {{ $isDisabled(['admin','dpmptsp']) ? 'disabled' : '' }} required>
                                        <option value="">Pilih Verifikator</option>
                                        @foreach($verifikators as $verifikator)
                                            <option value="{{ $verifikator }}" @selected(old('verifikator') == $verifikator)>{{ $verifikator }}</option>
                                        @endforeach
                                    </select>
                                    @error('verifikator')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="status" class="block font-medium text-sm text-gray-700">Status Permohonan</label>
                                    <select name="status" id="status" class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isDisabled(['admin','dpmptsp','pd_teknis']) ? 'bg-gray-100' : '' }}" {{ $isDisabled(['admin','dpmptsp','pd_teknis']) ? 'disabled' : '' }} required>
                                        <option value="Diterima" @selected(old('status') == 'Diterima')>Diterima</option>
                                        <option value="Dikembalikan" @selected(old('status') == 'Dikembalikan')>Dikembalikan</option>
                                        <option value="Ditolak" @selected(old('status') == 'Ditolak')>Ditolak</option>
                                        <option value="Terlambat" @selected(old('status') == 'Terlambat')>Terlambat</option>
                                    </select>
                                    @error('status')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-pd-teknis-only">
                                    <label for="verifikasi_pd_teknis" class="block font-medium text-sm text-gray-700">Verifikasi PD Teknis</label>
                                    <select name="verifikasi_pd_teknis" id="verifikasi_pd_teknis"
                                        class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isDisabled(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}" {{ $isDisabled(['admin','dpmptsp']) ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Status --</option>
                                        @foreach($verificationStatusOptions as $opt)
                                            <option value="{{ $opt }}" @selected(old('verifikasi_pd_teknis') == $opt)>
                                                {{ $opt }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('verifikasi_pd_teknis')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                
                                <div>
                                    <label for="pengembalian" class="block font-medium text-sm text-gray-700">Tanggal Pengembalian</label>
                                    <input id="pengembalian" name="pengembalian" type="date"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['pd_teknis','dpmptsp','admin']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('pengembalian') }}" {{ $isReadOnly(['pd_teknis','dpmptsp','admin']) ? 'readonly' : '' }} />
                                    @error('pengembalian')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="keterangan_pengembalian" class="block font-medium text-sm text-gray-700">Keterangan Pengembalian</label>
                                    <textarea id="keterangan_pengembalian" name="keterangan_pengembalian"
                                        class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm">{{ old('keterangan_pengembalian') }}</textarea>
                                    @error('keterangan_pengembalian')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                                
                                <!-- Toggle Button untuk Field Opsional -->
                                <div class="hide-for-pd-teknis">
                                    <button type="button" onclick="toggleOptionalFields()" 
                                        class="w-full flex items-center justify-between px-4 py-3 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                        <span class="font-medium text-blue-700">📋 Field Opsional (Klik untuk menampilkan)</span>
                                        <svg id="toggle-icon" class="w-5 h-5 text-blue-600 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                </div>

                                <!-- Field Opsional yang bisa di-toggle -->
                                <div id="optional-fields" class="hide-for-pd-teknis hidden space-y-4 mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                    <div>
                                        <label for="menghubungi" class="block font-medium text-sm text-gray-700">Tanggal Menghubungi</label>
                                        <input id="menghubungi" name="menghubungi" type="date"
                                            class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}"
                                            value="{{ old('menghubungi') }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }} />
                                        @error('menghubungi')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label for="keterangan_menghubungi" class="block font-medium text-sm text-gray-700">Keterangan Menghubungi</label>
                                        <textarea id="keterangan_menghubungi" name="keterangan_menghubungi"
                                            class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }}>{{ old('keterangan_menghubungi') }}</textarea>
                                        @error('keterangan_menghubungi')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label for="status_menghubungi" class="block font-medium text-sm text-gray-700">Status Menghubungi</label>
                                        <input id="status_menghubungi" name="status_menghubungi" type="text"
                                            class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}"
                                            value="{{ old('status_menghubungi') }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }} />
                                        @error('status_menghubungi')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label for="perbaikan" class="block font-medium text-sm text-gray-700">Tanggal Perbaikan</label>
                                        <input id="perbaikan" name="perbaikan" type="date"
                                            class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}"
                                            value="{{ old('perbaikan') }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }} />
                                        @error('perbaikan')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label for="keterangan_perbaikan" class="block font-medium text-sm text-gray-700">Keterangan Perbaikan</label>
                                        <textarea id="keterangan_perbaikan" name="keterangan_perbaikan"
                                            class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }}>{{ old('keterangan_perbaikan') }}</textarea>
                                        @error('keterangan_perbaikan')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                    </div>
                                </div>

                                <div class="field-dpmptsp-only">
                                    <label for="verifikasi_dpmptsp" class="block font-medium text-sm text-gray-700">Verifikasi Analisa</label>
                                    <select name="verifikasi_dpmptsp" id="verifikasi_dpmptsp"
                                        class="block mt-1 w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isDisabled(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}" {{ $isDisabled(['admin','dpmptsp']) ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Status --</option>
                                        @foreach($verificationStatusOptions as $opt)
                                            <option value="{{ $opt }}" @selected(old('verifikasi_dpmptsp') == $opt)>
                                                {{ $opt }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('verifikasi_dpmptsp')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                    <div>
                                        <label for="terbit" class="block font-medium text-sm text-gray-700">Tanggal Terbit</label>
                                        <input id="terbit" name="terbit" type="date"
                                            class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}"
                                            value="{{ old('terbit') }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }} />
                                        @error('terbit')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label for="keterangan_terbit" class="block font-medium text-sm text-gray-700">Keterangan Terbit</label>
                                        <textarea id="keterangan_terbit" name="keterangan_terbit"
                                            class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }}>{{ old('keterangan_terbit') }}</textarea>
                                        @error('keterangan_terbit')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label for="keterangan" class="block font-medium text-sm text-gray-700">Keterangan</label>
                                        <textarea id="keterangan" name="keterangan"
                                            class="mt-1 block w-full border-gray-300 focus:border-primary-500 focus:ring-primary-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }}>{{ old('keterangan') }}</textarea>
                                        @error('keterangan')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                    </div>
                                </div>
                            </div> {{-- END: KOLOM KANAN --}}
                        </div> {{-- END: grid grid-cols-1 md:grid-cols-2 --}}

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-end mt-8 pt-6 border-t">
                            <a href="{{ route('dashboard') }}"
                                class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md mr-2 hover:bg-gray-300">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Simpan') }}
                            </button>
                        </div>
                    </form>
                    {{-- END: Form --}}
                </div> {{-- END: p-6 md:p-8 text-gray-900 --}}
            </div> {{-- END: bg-white overflow-hidden shadow-sm sm:rounded-lg --}}
        </div> {{-- END: max-w-6xl mx-auto sm:px-6 lg:px-8 --}}
    </div> {{-- END: py-12 --}}
</x-app-layout>

<script>
function toggleOptionalFields() {
    const fields = document.getElementById('optional-fields');
    const icon = document.getElementById('toggle-icon');
    const button = document.querySelector('button[onclick="toggleOptionalFields()"]');
    const buttonText = button.querySelector('span');
    
    if (fields.classList.contains('hidden')) {
        // Show fields
        fields.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
        buttonText.textContent = '📋 Field Opsional (Klik untuk menyembunyikan)';
        button.classList.remove('bg-blue-50', 'border-blue-200', 'hover:bg-blue-100');
        button.classList.add('bg-green-50', 'border-green-200', 'hover:bg-green-100');
        buttonText.classList.remove('text-blue-700');
        buttonText.classList.add('text-green-700');
        icon.classList.remove('text-blue-600');
        icon.classList.add('text-green-600');
    } else {
        // Hide fields
        fields.classList.add('hidden');
        icon.style.transform = 'rotate(0deg)';
        buttonText.textContent = '📋 Field Opsional (Klik untuk menampilkan)';
        button.classList.remove('bg-green-50', 'border-green-200', 'hover:bg-green-100');
        button.classList.add('bg-blue-50', 'border-blue-200', 'hover:bg-blue-100');
        buttonText.classList.remove('text-green-700');
        buttonText.classList.add('text-blue-700');
        icon.classList.remove('text-green-600');
        icon.classList.add('text-blue-600');
    }
}
</script>


