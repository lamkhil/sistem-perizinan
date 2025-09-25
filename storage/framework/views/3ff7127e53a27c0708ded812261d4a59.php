<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Buat Permohonan Baru
        </h2>
     <?php $__env->endSlot(); ?>


    <div class="py-12 <?php echo e($cssClasses); ?>">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 md:p-8 text-gray-900">
                    <?php if($errors->any()): ?>
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <p class="font-bold">Oops! Ada beberapa hal yang perlu diperbaiki:</p>
                            <ul class="list-disc list-inside mt-2">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('permohonan.store')); ?>"
                          x-data="{ jenisPelakuUsaha: '<?php echo e(old('jenis_pelaku_usaha', 'Badan Usaha')); ?>' }">
                        <?php echo csrf_field(); ?>

                        <?php
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
                        ?>

                        <?php
                            $cssClasses = ($user && $user->role) ? 'role-' . $user->role : '';
                        ?>

                        <!-- Role-based CSS -->
                        <link rel="stylesheet" href="<?php echo e(asset('css/role-based.css')); ?>">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                            
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Data Pemohon</h3>

                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="no_permohonan" class="block font-medium text-sm text-gray-700">No. Permohonan</label>
                                    <input id="no_permohonan" name="no_permohonan" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['pd_teknis']) ? 'bg-gray-100' : ''); ?>"
                                        value="<?php echo e(old('no_permohonan')); ?>" <?php echo e($isReadOnly(['pd_teknis']) ? 'readonly' : ''); ?> required />
                                    <?php $__errorArgs = ['no_permohonan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Pindah No. Proyek ke Data Pemohon untuk Admin & PD Teknis -->
                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="no_proyek" class="block font-medium text-sm text-gray-700">No. Proyek</label>
                                    <input id="no_proyek" name="no_proyek" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['pd_teknis','admin']) ? 'bg-gray-100' : ''); ?>"
                                        value="<?php echo e(old('no_proyek')); ?>" <?php echo e($isReadOnly(['pd_teknis','admin']) ? 'readonly' : ''); ?> />
                                    <?php $__errorArgs = ['no_proyek'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="tanggal_permohonan" class="block font-medium text-sm text-gray-700">Tanggal Permohonan</label>
                                    <input id="tanggal_permohonan" name="tanggal_permohonan" type="date"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['pd_teknis']) ? 'bg-gray-100' : ''); ?>"
                                        value="<?php echo e(old('tanggal_permohonan')); ?>" <?php echo e($isReadOnly(['pd_teknis']) ? 'readonly' : ''); ?> required />
                                    <?php $__errorArgs = ['tanggal_permohonan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="jenis_pelaku_usaha" class="block font-medium text-sm text-gray-700">Jenis Perusahaan</label>
                                    <select name="jenis_pelaku_usaha" id="jenis_pelaku_usaha"
                                        x-model="jenisPelakuUsaha"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isDisabled(['pd_teknis']) ? 'bg-gray-100' : ''); ?>" <?php echo e($isDisabled(['pd_teknis']) ? 'disabled' : ''); ?> required>
                                        <option value="">Pilih Jenis Perusahaan</option>
                                        <?php $__currentLoopData = $jenisPelakuUsahas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jenis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($jenis); ?>" <?php if(old('jenis_pelaku_usaha') == $jenis): echo 'selected'; endif; ?>>
                                                <?php echo e($jenis); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['jenis_pelaku_usaha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp hide-for-pd-teknis" x-show="jenisPelakuUsaha === 'Orang Perseorangan'">
                                    <label for="nik" class="block font-medium text-sm text-gray-700">Nomor Induk Kependudukan (NIK)</label>
                                    <input id="nik" name="nik" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['pd_teknis']) ? 'bg-gray-100' : ''); ?>"
                                        value="<?php echo e(old('nik')); ?>" placeholder="Masukkan 16 digit NIK" maxlength="16" <?php echo e($isReadOnly(['pd_teknis']) ? 'readonly' : ''); ?> />
                                    <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp hide-for-pd-teknis" x-show="jenisPelakuUsaha === 'Badan Usaha'">
                                    <label for="jenis_badan_usaha" class="block font-medium text-sm text-gray-700">Jenis Badan Usaha</label>
                                    <select name="jenis_badan_usaha" id="jenis_badan_usaha"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['pd_teknis']) ? 'bg-gray-100' : ''); ?>"
                                        <?php echo e($isReadOnly(['pd_teknis']) ? 'disabled' : ''); ?>>
                                        <option value="">Pilih Jenis Badan Usaha</option>
                                        <option value="Perseroan Terbatas (PT)" <?php if(old('jenis_badan_usaha') == 'Perseroan Terbatas (PT)'): echo 'selected'; endif; ?>>
                                            Perseroan Terbatas (PT)
                                        </option>
                                        <option value="Perseroan Terbatas (PT) Perorangan" <?php if(old('jenis_badan_usaha') == 'Perseroan Terbatas (PT) Perorangan'): echo 'selected'; endif; ?>>
                                            Perseroan Terbatas (PT) Perorangan
                                        </option>
                                        <option value="Persekutuan Komanditer (CV/Commanditaire Vennootschap)" <?php if(old('jenis_badan_usaha') == 'Persekutuan Komanditer (CV/Commanditaire Vennootschap)'): echo 'selected'; endif; ?>>
                                            Persekutuan Komanditer (CV/Commanditaire Vennootschap)
                                        </option>
                                        <option value="Persekutuan Firma (FA / Venootschap Onder Firma)" <?php if(old('jenis_badan_usaha') == 'Persekutuan Firma (FA / Venootschap Onder Firma)'): echo 'selected'; endif; ?>>
                                            Persekutuan Firma (FA / Venootschap Onder Firma)
                                        </option>
                                        <option value="Persekutuan Perdata" <?php if(old('jenis_badan_usaha') == 'Persekutuan Perdata'): echo 'selected'; endif; ?>>
                                            Persekutuan Perdata
                                        </option>
                                        <option value="Perusahaan Umum (Perum)" <?php if(old('jenis_badan_usaha') == 'Perusahaan Umum (Perum)'): echo 'selected'; endif; ?>>
                                            Perusahaan Umum (Perum)
                                        </option>
                                        <option value="Perusahaan Umum Daerah (Perumda)" <?php if(old('jenis_badan_usaha') == 'Perusahaan Umum Daerah (Perumda)'): echo 'selected'; endif; ?>>
                                            Perusahaan Umum Daerah (Perumda)
                                        </option>
                                        <option value="Badan Hukum Lainnya" <?php if(old('jenis_badan_usaha') == 'Badan Hukum Lainnya'): echo 'selected'; endif; ?>>
                                            Badan Hukum Lainnya
                                        </option>
                                        <option value="Koperasi" <?php if(old('jenis_badan_usaha') == 'Koperasi'): echo 'selected'; endif; ?>>
                                            Koperasi
                                        </option>
                                        <option value="Persekutuan dan Perkumpulan" <?php if(old('jenis_badan_usaha') == 'Persekutuan dan Perkumpulan'): echo 'selected'; endif; ?>>
                                            Persekutuan dan Perkumpulan
                                        </option>
                                        <option value="Yayasan" <?php if(old('jenis_badan_usaha') == 'Yayasan'): echo 'selected'; endif; ?>>
                                            Yayasan
                                        </option>
                                        <option value="Badan Layanan Umum" <?php if(old('jenis_badan_usaha') == 'Badan Layanan Umum'): echo 'selected'; endif; ?>>
                                            Badan Layanan Umum
                                        </option>
                                        <option value="BUM Desa" <?php if(old('jenis_badan_usaha') == 'BUM Desa'): echo 'selected'; endif; ?>>
                                            BUM Desa
                                        </option>
                                        <option value="BUM Desa Bersama" <?php if(old('jenis_badan_usaha') == 'BUM Desa Bersama'): echo 'selected'; endif; ?>>
                                            BUM Desa Bersama
                                        </option>
                                    </select>
                                    <?php $__errorArgs = ['jenis_badan_usaha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div class="field-data-pemohon hide-for-pd-teknis">
                                    <label for="nama_usaha" class="block font-medium text-sm text-gray-700">Nama Usaha</label>
                                    <input id="nama_usaha" name="nama_usaha" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['dpmptsp']) ? 'bg-gray-100' : ''); ?>"
                                        value="<?php echo e(old('nama_usaha')); ?>" <?php echo e($isReadOnly(['dpmptsp']) ? 'readonly' : ''); ?> required />
                                    <?php $__errorArgs = ['nama_usaha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Nama Perusahaan (kolom milik PD Teknis) -->
                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="nama_perusahaan" class="block font-medium text-sm text-gray-700">Nama Perusahaan</label>
                                    <input id="nama_perusahaan" name="nama_perusahaan" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['pd_teknis']) ? 'bg-gray-100' : ''); ?>"
                                        value="<?php echo e(old('nama_perusahaan')); ?>" <?php echo e($isReadOnly(['pd_teknis']) ? 'readonly' : ''); ?> />
                                    <?php $__errorArgs = ['nama_perusahaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="field-data-pemohon hide-for-dpmptsp">
                                    <label for="nib" class="block font-medium text-sm text-gray-700">NIB</label>
                                    <input id="nib" name="nib" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['pd_teknis']) ? 'bg-gray-100' : ''); ?>"
                                        value="<?php echo e(old('nib')); ?>" placeholder="Masukkan 20 digit NIB" maxlength="20" <?php echo e($isReadOnly(['pd_teknis']) ? 'readonly' : ''); ?> required />
                                    <?php $__errorArgs = ['nib'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                
                                <div class="field-data-pemohon hide-for-pd-teknis">
                                    <label for="alamat_perusahaan" class="block font-medium text-sm text-gray-700">Alamat Perusahaan</label>
                                    <textarea id="alamat_perusahaan" name="alamat_perusahaan"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['dpmptsp']) ? 'bg-gray-100' : ''); ?>" <?php echo e($isReadOnly(['dpmptsp']) ? 'readonly' : ''); ?> required><?php echo e(old('alamat_perusahaan')); ?></textarea>
                                    <?php $__errorArgs = ['alamat_perusahaan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="field-data-pemohon hide-for-pd-teknis">
                                    <label for="sektor" class="block font-medium text-sm text-gray-700">Sektor</label>
                                    <select name="sektor" id="sektor"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isDisabled(['dpmptsp','admin']) ? 'bg-gray-100' : ''); ?>" <?php echo e($isDisabled(['dpmptsp','admin']) ? 'disabled' : ''); ?>>
                                        <option value="">Pilih Sektor</option>
                                        <?php $__currentLoopData = $sektors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sektor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($sektor); ?>" <?php if(old('sektor') == $sektor): echo 'selected'; endif; ?>>
                                                <?php echo e($sektor); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['sektor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <?php if(in_array($user->role, ['admin', 'pd_teknis'])): ?>
                                <div>
                                    <label for="kbli" class="block font-medium text-sm text-gray-700">KBLI</label>
                                    <input id="kbli" name="kbli" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        value="<?php echo e(old('kbli')); ?>" placeholder="Masukkan nomor KBLI" />
                                    <?php $__errorArgs = ['kbli'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label for="inputan_teks" class="block font-medium text-sm text-gray-700">Kegiatan</label>
                                    <input id="inputan_teks" name="inputan_teks" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        value="<?php echo e(old('inputan_teks')); ?>" placeholder="Masukkan kegiatan" />
                                    <?php $__errorArgs = ['inputan_teks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <?php endif; ?>

                                <div class="field-data-pemohon hide-for-pd-teknis">
                                    <label for="modal_usaha" class="block font-medium text-sm text-gray-700">Modal Usaha</label>
                                    <input id="modal_usaha" name="modal_usaha" type="number"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['dpmptsp']) ? 'bg-gray-100' : ''); ?>"
                                        value="<?php echo e(old('modal_usaha')); ?>" <?php echo e($isReadOnly(['dpmptsp']) ? 'readonly' : ''); ?> required />
                                    <?php $__errorArgs = ['modal_usaha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="field-data-pemohon hide-for-pd-teknis">
                                    <label for="jenis_proyek" class="block font-medium text-sm text-gray-700">Jenis Proyek</label>
                                    <select name="jenis_proyek" id="jenis_proyek"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isDisabled(['dpmptsp']) ? 'bg-gray-100' : ''); ?>" <?php echo e($isDisabled(['dpmptsp']) ? 'disabled' : ''); ?> required>
                                        <option value="">Pilih Jenis Proyek</option>
                                        <?php $__currentLoopData = $jenisProyeks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proyek): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($proyek); ?>" <?php if(old('jenis_proyek') == $proyek): echo 'selected'; endif; ?>>
                                                <?php echo e($proyek); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['jenis_proyek'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <?php if(in_array($user->role, ['admin', 'dpmptsp'])): ?>
                                <div>
                                    <label for="nama_perizinan" class="block font-medium text-sm text-gray-700">Nama Perizinan</label>
                                    <input id="nama_perizinan" name="nama_perizinan" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        value="<?php echo e(old('nama_perizinan')); ?>" placeholder="Masukkan nama perizinan" />
                                    <?php $__errorArgs = ['nama_perizinan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label for="skala_usaha" class="block font-medium text-sm text-gray-700">Skala Usaha</label>
                                    <select name="skala_usaha" id="skala_usaha"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Pilih Skala Usaha</option>
                                        <option value="Mikro" <?php if(old('skala_usaha') == 'Mikro'): echo 'selected'; endif; ?>>Mikro</option>
                                        <option value="Kecil" <?php if(old('skala_usaha') == 'Kecil'): echo 'selected'; endif; ?>>Kecil</option>
                                        <option value="Menengah" <?php if(old('skala_usaha') == 'Menengah'): echo 'selected'; endif; ?>>Menengah</option>
                                        <option value="Besar" <?php if(old('skala_usaha') == 'Besar'): echo 'selected'; endif; ?>>Besar</option>
                                    </select>
                                    <?php $__errorArgs = ['skala_usaha'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label for="risiko" class="block font-medium text-sm text-gray-700">Risiko</label>
                                    <select name="risiko" id="risiko"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                        <option value="">Pilih Risiko</option>
                                        <option value="Rendah" <?php if(old('risiko') == 'Rendah'): echo 'selected'; endif; ?>>Rendah</option>
                                        <option value="Sedang" <?php if(old('risiko') == 'Sedang'): echo 'selected'; endif; ?>>Sedang</option>
                                        <option value="Tinggi" <?php if(old('risiko') == 'Tinggi'): echo 'selected'; endif; ?>>Tinggi</option>
                                    </select>
                                    <?php $__errorArgs = ['risiko'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label for="jangka_waktu" class="block font-medium text-sm text-gray-700">Jangka Waktu (Hari Kerja)</label>
                                    <input id="jangka_waktu" name="jangka_waktu" type="number"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        value="<?php echo e(old('jangka_waktu')); ?>" placeholder="Masukkan jangka waktu dalam hari kerja" />
                                    <?php $__errorArgs = ['jangka_waktu'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label for="no_telephone" class="block font-medium text-sm text-gray-700">No. Telephone</label>
                                    <input id="no_telephone" name="no_telephone" type="text"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                        value="<?php echo e(old('no_telephone')); ?>" placeholder="Masukkan nomor telephone" />
                                    <?php $__errorArgs = ['no_telephone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <?php endif; ?>
                            </div> 

                            
                            <div class="space-y-6">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2">Verifikasi & Tracking</h3>

                                
                                
                                <div class="hide-for-pd-teknis">
                                    <label for="verifikator" class="block font-medium text-sm text-gray-700">Verifikator</label>
                                    <select name="verifikator" id="verifikator"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isDisabled(['admin','dpmptsp']) ? 'bg-gray-100' : ''); ?>" <?php echo e($isDisabled(['admin','dpmptsp']) ? 'disabled' : ''); ?> required>
                                        <option value="">Pilih Verifikator</option>
                                        <?php $__currentLoopData = $verifikators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $verifikator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($verifikator); ?>" <?php if(old('verifikator') == $verifikator): echo 'selected'; endif; ?>><?php echo e($verifikator); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['verifikator'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label for="status" class="block font-medium text-sm text-gray-700">Status Permohonan</label>
                                    <select name="status" id="status" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isDisabled(['admin','dpmptsp','pd_teknis']) ? 'bg-gray-100' : ''); ?>" <?php echo e($isDisabled(['admin','dpmptsp','pd_teknis']) ? 'disabled' : ''); ?> required>
                                        <option value="Diterima" <?php if(old('status') == 'Diterima'): echo 'selected'; endif; ?>>Diterima</option>
                                        <option value="Dikembalikan" <?php if(old('status') == 'Dikembalikan'): echo 'selected'; endif; ?>>Dikembalikan</option>
                                        <option value="Ditolak" <?php if(old('status') == 'Ditolak'): echo 'selected'; endif; ?>>Ditolak</option>
                                        <option value="Menunggu" <?php if(old('status', 'Menunggu') == 'Menunggu'): echo 'selected'; endif; ?>>Menunggu</option>
                                    </select>
                                    <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="field-pd-teknis-only">
                                    <label for="verifikasi_pd_teknis" class="block font-medium text-sm text-gray-700">Verifikasi PD Teknis</label>
                                    <select name="verifikasi_pd_teknis" id="verifikasi_pd_teknis"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isDisabled(['admin','dpmptsp']) ? 'bg-gray-100' : ''); ?>" <?php echo e($isDisabled(['admin','dpmptsp']) ? 'disabled' : ''); ?>>
                                        <option value="">-- Pilih Status --</option>
                                        <?php $__currentLoopData = $verificationStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($opt); ?>" <?php if(old('verifikasi_pd_teknis') == $opt): echo 'selected'; endif; ?>>
                                                <?php echo e($opt); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['verifikasi_pd_teknis'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                
                                <div>
                                    <label for="pengembalian" class="block font-medium text-sm text-gray-700">Tanggal Pengembalian</label>
                                    <input id="pengembalian" name="pengembalian" type="date"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['pd_teknis','dpmptsp','admin']) ? 'bg-gray-100' : ''); ?>"
                                        value="<?php echo e(old('pengembalian')); ?>" <?php echo e($isReadOnly(['pd_teknis','dpmptsp','admin']) ? 'readonly' : ''); ?> />
                                    <?php $__errorArgs = ['pengembalian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div>
                                    <label for="keterangan_pengembalian" class="block font-medium text-sm text-gray-700">Keterangan Pengembalian</label>
                                    <textarea id="keterangan_pengembalian" name="keterangan_pengembalian"
                                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"><?php echo e(old('keterangan_pengembalian')); ?></textarea>
                                    <?php $__errorArgs = ['keterangan_pengembalian'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : ''); ?>"
                                            value="<?php echo e(old('menghubungi')); ?>" <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'readonly' : ''); ?> />
                                        <?php $__errorArgs = ['menghubungi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div>
                                        <label for="keterangan_menghubungi" class="block font-medium text-sm text-gray-700">Keterangan Menghubungi</label>
                                        <textarea id="keterangan_menghubungi" name="keterangan_menghubungi"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : ''); ?>" <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'readonly' : ''); ?>><?php echo e(old('keterangan_menghubungi')); ?></textarea>
                                        <?php $__errorArgs = ['keterangan_menghubungi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div>
                                        <label for="status_menghubungi" class="block font-medium text-sm text-gray-700">Status Menghubungi</label>
                                        <input id="status_menghubungi" name="status_menghubungi" type="text"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : ''); ?>"
                                            value="<?php echo e(old('status_menghubungi')); ?>" <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'readonly' : ''); ?> />
                                        <?php $__errorArgs = ['status_menghubungi'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div>
                                        <label for="perbaikan" class="block font-medium text-sm text-gray-700">Tanggal Perbaikan</label>
                                        <input id="perbaikan" name="perbaikan" type="date"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : ''); ?>"
                                            value="<?php echo e(old('perbaikan')); ?>" <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'readonly' : ''); ?> />
                                        <?php $__errorArgs = ['perbaikan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div>
                                        <label for="keterangan_perbaikan" class="block font-medium text-sm text-gray-700">Keterangan Perbaikan</label>
                                        <textarea id="keterangan_perbaikan" name="keterangan_perbaikan"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : ''); ?>" <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'readonly' : ''); ?>><?php echo e(old('keterangan_perbaikan')); ?></textarea>
                                        <?php $__errorArgs = ['keterangan_perbaikan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="field-dpmptsp-only">
                                    <label for="verifikasi_dpmptsp" class="block font-medium text-sm text-gray-700">Verifikasi Analisa</label>
                                    <select name="verifikasi_dpmptsp" id="verifikasi_dpmptsp"
                                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isDisabled(['admin','dpmptsp']) ? 'bg-gray-100' : ''); ?>" <?php echo e($isDisabled(['admin','dpmptsp']) ? 'disabled' : ''); ?>>
                                        <option value="">-- Pilih Status --</option>
                                        <?php $__currentLoopData = $verificationStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($opt); ?>" <?php if(old('verifikasi_dpmptsp') == $opt): echo 'selected'; endif; ?>>
                                                <?php echo e($opt); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['verifikasi_dpmptsp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                    <div>
                                        <label for="terbit" class="block font-medium text-sm text-gray-700">Tanggal Terbit</label>
                                        <input id="terbit" name="terbit" type="date"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : ''); ?>"
                                            value="<?php echo e(old('terbit')); ?>" <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'readonly' : ''); ?> />
                                        <?php $__errorArgs = ['terbit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div>
                                        <label for="keterangan_terbit" class="block font-medium text-sm text-gray-700">Keterangan Terbit</label>
                                        <textarea id="keterangan_terbit" name="keterangan_terbit"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : ''); ?>" <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'readonly' : ''); ?>><?php echo e(old('keterangan_terbit')); ?></textarea>
                                        <?php $__errorArgs = ['keterangan_terbit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <div>
                                        <label for="keterangan" class="block font-medium text-sm text-gray-700">Keterangan</label>
                                        <textarea id="keterangan" name="keterangan"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'bg-gray-100' : ''); ?>" <?php echo e($isReadOnly(['admin','dpmptsp']) ? 'readonly' : ''); ?>><?php echo e(old('keterangan')); ?></textarea>
                                        <?php $__errorArgs = ['keterangan'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div> 
                        </div> 

                        
                        <div class="flex items-center justify-end mt-8 pt-6 border-t">
                            <a href="<?php echo e(route('dashboard')); ?>"
                                class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md mr-2 hover:bg-gray-300">Batal</a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <?php echo e(__('Simpan')); ?>

                            </button>
                        </div>
                    </form>
                    
                </div> 
            </div> 
        </div> 
    </div> 
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>

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


<?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/permohonan/create.blade.php ENDPATH**/ ?>