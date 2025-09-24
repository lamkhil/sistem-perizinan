{{-- FILE: resources/views/permohonan/edit.blade.php --}}
{{-- PERBAIKAN: Menyesuaikan hak akses edit (readonly/disabled) untuk setiap field sesuai peran --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ubah Data Permohonan (Dinamis Sesuai Role)
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

                    <form method="POST" action="{{ route('permohonan.update', $permohonan) }}"
                          x-data="{ jenisPelakuUsaha: '{{ old('jenis_pelaku_usaha', $permohonan->jenis_pelaku_usaha) ?? 'Badan Usaha' }}' }">
                        @csrf
                        @method('PATCH')

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
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['pd_teknis']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('no_permohonan', $permohonan->no_permohonan) }}"
                                        {{ $isReadOnly(['pd_teknis']) ? 'readonly' : '' }} required />
                                    @error('no_permohonan')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="tanggal_permohonan" class="block font-medium text-sm text-gray-700">Tanggal Permohonan</label>
                                    <input id="tanggal_permohonan" name="tanggal_permohonan" type="date"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['pd_teknis']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('tanggal_permohonan', $permohonan->tanggal_permohonan ? $permohonan->tanggal_permohonan->format('Y-m-d') : '') }}"
                                        {{ $isReadOnly(['pd_teknis']) ? 'readonly' : '' }} />
                                    @error('tanggal_permohonan')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="jenis_pelaku_usaha" class="block font-medium text-sm text-gray-700">Jenis Perusahaan</label>
                                    <select name="jenis_pelaku_usaha" id="jenis_pelaku_usaha"
                                        x-model="jenisPelakuUsaha"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isDisabled(['pd_teknis']) ? 'bg-gray-100' : '' }}"
                                        {{ $isDisabled(['pd_teknis']) ? 'disabled' : '' }} required>
                                        <option value="">Pilih Jenis Perusahaan</option>
                                        @foreach($jenisPelakuUsahas as $jenis)
                                            <option value="{{ $jenis }}" @selected(old('jenis_pelaku_usaha', $permohonan->jenis_pelaku_usaha) == $jenis)>
                                                {{ $jenis }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_pelaku_usaha')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp" x-show="jenisPelakuUsaha === 'Orang Perseorangan'">
                                    <label for="nik" class="block font-medium text-sm text-gray-700">Nomor Induk Kependudukan (NIK)</label>
                                    <input id="nik" name="nik" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['pd_teknis']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('nik', $permohonan->nik) }}" placeholder="Masukkan 16 digit NIK" maxlength="16"
                                        {{ $isReadOnly(['pd_teknis']) ? 'readonly' : '' }} />
                                    @error('nik')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp" x-show="jenisPelakuUsaha === 'Badan Usaha'">
                                    <label for="jenis_badan_usaha" class="block font-medium text-sm text-gray-700">Jenis Badan Usaha</label>
                                    <select name="jenis_badan_usaha" id="jenis_badan_usaha"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['pd_teknis']) ? 'bg-gray-100' : '' }}"
                                        {{ $isReadOnly(['pd_teknis']) ? 'disabled' : '' }}>
                                        <option value="">Pilih Jenis Badan Usaha</option>
                                        <option value="Perseroan Terbatas (PT)" @selected(old('jenis_badan_usaha', $permohonan->jenis_badan_usaha) == 'Perseroan Terbatas (PT)')>
                                            Perseroan Terbatas (PT)
                                        </option>
                                        <option value="Perseroan Terbatas (PT) Perorangan" @selected(old('jenis_badan_usaha', $permohonan->jenis_badan_usaha) == 'Perseroan Terbatas (PT) Perorangan')>
                                            Perseroan Terbatas (PT) Perorangan
                                        </option>
                                        <option value="Persekutuan Komanditer (CV/Commanditaire Vennootschap)" @selected(old('jenis_badan_usaha', $permohonan->jenis_badan_usaha) == 'Persekutuan Komanditer (CV/Commanditaire Vennootschap)')>
                                            Persekutuan Komanditer (CV/Commanditaire Vennootschap)
                                        </option>
                                        <option value="Persekutuan Firma (FA / Venootschap Onder Firma)" @selected(old('jenis_badan_usaha', $permohonan->jenis_badan_usaha) == 'Persekutuan Firma (FA / Venootschap Onder Firma)')>
                                            Persekutuan Firma (FA / Venootschap Onder Firma)
                                        </option>
                                        <option value="Persekutuan Perdata" @selected(old('jenis_badan_usaha', $permohonan->jenis_badan_usaha) == 'Persekutuan Perdata')>
                                            Persekutuan Perdata
                                        </option>
                                        <option value="Perusahaan Umum (Perum)" @selected(old('jenis_badan_usaha', $permohonan->jenis_badan_usaha) == 'Perusahaan Umum (Perum)')>
                                            Perusahaan Umum (Perum)
                                        </option>
                                        <option value="Perusahaan Umum Daerah (Perumda)" @selected(old('jenis_badan_usaha', $permohonan->jenis_badan_usaha) == 'Perusahaan Umum Daerah (Perumda)')>
                                            Perusahaan Umum Daerah (Perumda)
                                        </option>
                                        <option value="Badan Hukum Lainnya" @selected(old('jenis_badan_usaha', $permohonan->jenis_badan_usaha) == 'Badan Hukum Lainnya')>
                                            Badan Hukum Lainnya
                                        </option>
                                        <option value="Koperasi" @selected(old('jenis_badan_usaha', $permohonan->jenis_badan_usaha) == 'Koperasi')>
                                            Koperasi
                                        </option>
                                        <option value="Persekutuan dan Perkumpulan" @selected(old('jenis_badan_usaha', $permohonan->jenis_badan_usaha) == 'Persekutuan dan Perkumpulan')>
                                            Persekutuan dan Perkumpulan
                                        </option>
                                        <option value="Yayasan" @selected(old('jenis_badan_usaha', $permohonan->jenis_badan_usaha) == 'Yayasan')>
                                            Yayasan
                                        </option>
                                        <option value="Badan Layanan Umum" @selected(old('jenis_badan_usaha', $permohonan->jenis_badan_usaha) == 'Badan Layanan Umum')>
                                            Badan Layanan Umum
                                        </option>
                                        <option value="BUM Desa" @selected(old('jenis_badan_usaha', $permohonan->jenis_badan_usaha) == 'BUM Desa')>
                                            BUM Desa
                                        </option>
                                        <option value="BUM Desa Bersama" @selected(old('jenis_badan_usaha', $permohonan->jenis_badan_usaha) == 'BUM Desa Bersama')>
                                            BUM Desa Bersama
                                        </option>
                                    </select>
                                    @error('jenis_badan_usaha')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                {{-- DPMPTSP mengisi Nama Usaha secara manual (terpisah dari Jenis Perusahaan milik PD Teknis) --}}
                                <div class="field-data-pemohon">
                                    <label for="nama_usaha" class="block font-medium text-sm text-gray-700">Nama Usaha</label>
                                    <input id="nama_usaha" name="nama_usaha" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['dpmptsp']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('nama_usaha', $permohonan->nama_usaha) }}" {{ $isReadOnly(['dpmptsp']) ? 'readonly' : '' }} />
                                    @error('nama_usaha')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="nib" class="block font-medium text-sm text-gray-700">NIB</label>
                                    <input id="nib" name="nib" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['pd_teknis']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('nib', $permohonan->nib) }}" placeholder="Masukkan 20 digit NIB" maxlength="20"
                                        {{ $isReadOnly(['pd_teknis']) ? 'readonly' : '' }} />
                                    @error('nib')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                                
                                <div class="field-data-pemohon">
                                    <label for="alamat_perusahaan" class="block font-medium text-sm text-gray-700">Alamat Perusahaan</label>
                                    <textarea id="alamat_perusahaan" name="alamat_perusahaan"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['dpmptsp']) ? 'bg-gray-100' : '' }}"
                                        {{ $isReadOnly(['dpmptsp']) ? 'readonly' : '' }}>{{ old('alamat_perusahaan', $permohonan->alamat_perusahaan) }}</textarea>
                                    @error('alamat_perusahaan')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="sektor" class="block font-medium text-sm text-gray-700">Sektor</label>
                                    <select name="sektor" id="sektor"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isDisabled(['admin', 'dpmptsp']) ? 'bg-gray-100' : '' }}"
                                        {{ $isDisabled(['admin', 'dpmptsp']) ? 'disabled' : '' }}>
                                        <option value="">Pilih Sektor</option>
                                        @foreach($sektors as $sektor)
                                            <option value="{{ $sektor }}" @selected(old('sektor', $permohonan->sektor) == $sektor)>
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
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        value="{{ old('kbli', $permohonan->kbli) }}" placeholder="Masukkan nomor KBLI" />
                                    @error('kbli')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="inputan_teks" class="block font-medium text-sm text-gray-700">Kegiatan</label>
                                    <input id="inputan_teks" name="inputan_teks" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        value="{{ old('inputan_teks', $permohonan->inputan_teks) }}" placeholder="Masukkan kegiatan" />
                                    @error('inputan_teks')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                                @endif

                                <div class="field-data-pemohon">
                                    <label for="modal_usaha" class="block font-medium text-sm text-gray-700">Modal Usaha</label>
                                    <input id="modal_usaha" name="modal_usaha" type="number"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['dpmptsp']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('modal_usaha', $permohonan->modal_usaha) }}"
                                        {{ $isReadOnly(['dpmptsp']) ? 'readonly' : '' }} />
                                    @error('modal_usaha')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-data-pemohon">
                                    <label for="jenis_proyek" class="block font-medium text-sm text-gray-700">Jenis Proyek</label>
                                    <select name="jenis_proyek" id="jenis_proyek"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isDisabled(['dpmptsp']) ? 'bg-gray-100' : '' }}"
                                        {{ $isDisabled(['dpmptsp']) ? 'disabled' : '' }}>
                                        <option value="">Pilih Jenis Proyek</option>
                                        @foreach($jenisProyeks as $proyek)
                                            <option value="{{ $proyek }}" @selected(old('jenis_proyek', $permohonan->jenis_proyek) == $proyek)>
                                                {{ $proyek }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('jenis_proyek')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                            </div> {{-- END: KOLOM KIRI --}}

                            {{-- START: KOLOM KANAN: Verifikasi & Tracking --}}
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Verifikasi & Tracking</h3>

                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="no_proyek" class="block font-medium text-sm text-gray-700">No. Proyek</label>
                                    <input id="no_proyek" name="no_proyek" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['pd_teknis']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('no_proyek', $permohonan->no_proyek) }}"
                                        {{ $isReadOnly(['pd_teknis']) ? 'readonly' : '' }} />
                                    @error('no_proyek')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                                
                                <div>
                                    <label for="verifikator" class="block font-medium text-sm text-gray-700">Verifikator</label>
                                    <select name="verifikator" id="verifikator"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isDisabled(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}" {{ $isDisabled(['admin','dpmptsp']) ? 'disabled' : '' }}>
                                        <option value="">Pilih Verifikator</option>
                                        @foreach($verifikators as $verifikator)
                                            <option value="{{ $verifikator }}" @selected(old('verifikator', $permohonan->verifikator) == $verifikator)>{{ $verifikator }}</option>
                                        @endforeach
                                    </select>
                                    @error('verifikator')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="hide-for-dpmptsp">
                                    <label for="status" class="block font-medium text-sm text-gray-700">Status Permohonan</label>
                                    <select name="status" id="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isDisabled(['admin','dpmptsp','pd_teknis']) ? 'bg-gray-100' : '' }}" {{ $isDisabled(['admin','dpmptsp','pd_teknis']) ? 'disabled' : '' }}>
                                        <option value="Diterima" @selected(old('status', $permohonan->status) == 'Diterima')>Diterima</option>
                                        <option value="Dikembalikan" @selected(old('status', $permohonan->status) == 'Dikembalikan')>Dikembalikan</option>
                                        <option value="Ditolak" @selected(old('status', $permohonan->status) == 'Ditolak')>Ditolak</option>
                                        <option value="Menunggu" @selected(old('status', $permohonan->status) == 'Menunggu')>Menunggu</option>
                                    </select>
                                    @error('status')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-pd-teknis-only">
                                    <label for="verifikasi_pd_teknis" class="block font-medium text-sm text-gray-700">Verifikasi PD Teknis</label>
                                    <select name="verifikasi_pd_teknis" id="verifikasi_pd_teknis"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isDisabled(['admin']) ? 'bg-gray-100' : '' }}"
                                        {{ $isDisabled(['admin']) ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Status --</option>
                                        @foreach($verificationStatusOptions as $opt)
                                            <option value="{{ $opt }}" @selected(old('verifikasi_pd_teknis', $permohonan->verifikasi_pd_teknis) == $opt)>
                                                {{ $opt }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('verifikasi_pd_teknis')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                
                                <div class="field-dpmptsp-only">
                                    <label for="pengembalian" class="block font-medium text-sm text-gray-700">Tanggal Pengembalian</label>
                                    <input id="pengembalian" name="pengembalian" type="date"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        value="{{ old('pengembalian', $permohonan->pengembalian ? $permohonan->pengembalian->format('Y-m-d') : '') }}" />
                                    @error('pengembalian')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-dpmptsp-only">
                                    <label for="keterangan_pengembalian" class="block font-medium text-sm text-gray-700">Keterangan Pengembalian</label>
                                    <textarea id="keterangan_pengembalian" name="keterangan_pengembalian"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('keterangan_pengembalian', $permohonan->keterangan_pengembalian) }}</textarea>
                                    @error('keterangan_pengembalian')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                                
                                <div class="field-dpmptsp-only">
                                    <label for="menghubungi" class="block font-medium text-sm text-gray-700">Tanggal Menghubungi</label>
                                    <input id="menghubungi" name="menghubungi" type="date"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('menghubungi', $permohonan->menghubungi ? $permohonan->menghubungi->format('Y-m-d') : '') }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }} />
                                    @error('menghubungi')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-dpmptsp-only">
                                    <label for="keterangan_menghubungi" class="block font-medium text-sm text-gray-700">Keterangan Menghubungi</label>
                                    <textarea id="keterangan_menghubungi" name="keterangan_menghubungi"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }}>{{ old('keterangan_menghubungi', $permohonan->keterangan_menghubungi) }}</textarea>
                                    @error('keterangan_menghubungi')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-dpmptsp-only">
                                    <label for="status_menghubungi" class="block font-medium text-sm text-gray-700">Status Menghubungi</label>
                                    <input id="status_menghubungi" name="status_menghubungi" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('status_menghubungi', $permohonan->status_menghubungi) }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }} />
                                    @error('status_menghubungi')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-dpmptsp-only">
                                    <label for="perbaikan" class="block font-medium text-sm text-gray-700">Tanggal Perbaikan</label>
                                    <input id="perbaikan" name="perbaikan" type="date"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('perbaikan', $permohonan->perbaikan ? $permohonan->perbaikan->format('Y-m-d') : '') }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }} />
                                    @error('perbaikan')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-dpmptsp-only">
                                    <label for="keterangan_perbaikan" class="block font-medium text-sm text-gray-700">Keterangan Perbaikan</label>
                                    <textarea id="keterangan_perbaikan" name="keterangan_perbaikan"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }}>{{ old('keterangan_perbaikan', $permohonan->keterangan_perbaikan) }}</textarea>
                                    @error('keterangan_perbaikan')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-dpmptsp-only">
                                    <label for="verifikasi_dpmptsp" class="block font-medium text-sm text-gray-700">Verifikasi Analisa</label>
                                    <select name="verifikasi_dpmptsp" id="verifikasi_dpmptsp"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isDisabled(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}"
                                        {{ $isDisabled(['admin','dpmptsp']) ? 'disabled' : '' }}>
                                        <option value="">-- Pilih Status --</option>
                                        @foreach($verificationStatusOptions as $opt)
                                            <option value="{{ $opt }}" @selected(old('verifikasi_dpmptsp', $permohonan->verifikasi_dpmptsp) == $opt)>
                                                {{ $opt }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('verifikasi_dpmptsp')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-dpmptsp-only">
                                    <label for="terbit" class="block font-medium text-sm text-gray-700">Tanggal Terbit</label>
                                    <input id="terbit" name="terbit" type="date"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('terbit', $permohonan->terbit ? $permohonan->terbit->format('Y-m-d') : '') }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }} />
                                    @error('terbit')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-dpmptsp-only">
                                    <label for="keterangan_terbit" class="block font-medium text-sm text-gray-700">Keterangan Terbit</label>
                                    <textarea id="keterangan_terbit" name="keterangan_terbit"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }}>{{ old('keterangan_terbit', $permohonan->keterangan_terbit) }}</textarea>
                                    @error('keterangan_terbit')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="pemroses_dan_tgl_surat" class="block font-medium text-sm text-gray-700">Pemroses & Tgl Surat</label>
                                    <input id="pemroses_dan_tgl_surat" name="pemroses_dan_tgl_surat" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}"
                                        value="{{ old('pemroses_dan_tgl_surat', $permohonan->pemroses_dan_tgl_surat) }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }} />
                                    @error('pemroses_dan_tgl_surat')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>

                                <div class="field-dpmptsp-only">
                                    <label for="keterangan" class="block font-medium text-sm text-gray-700">Keterangan</label>
                                    <textarea id="keterangan" name="keterangan"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm {{ $isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : '' }}" {{ $isReadOnly(['admin','dpmptsp']) ? 'readonly' : '' }}>{{ old('keterangan', $permohonan->keterangan) }}</textarea>
                                    @error('keterangan')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
                                </div>
                            </div> {{-- END: KOLOM KANAN --}}
                        </div> {{-- END: grid grid-cols-1 md:grid-cols-2 --}}

                        {{-- Tombol Aksi --}}
                        <div class="flex items-center justify-end mt-8 pt-6 border-t">
                            <a href="{{ route('permohonan.show', $permohonan) }}"
                                class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md mr-2 hover:bg-gray-300">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                {{ __('Update Data') }}
                            </button>
                        </div>
                    </form>
                    {{-- END: Form --}}
                </div> {{-- END: p-6 md:p-8 text-gray-900 --}}
            </div> {{-- END: bg-white overflow-hidden shadow-sm sm:rounded-lg --}}
        </div> {{-- END: max-w-6xl mx-auto sm:px-6 lg:px-8 --}}
    </div> {{-- END: py-12 --}}
</x-app-layout>