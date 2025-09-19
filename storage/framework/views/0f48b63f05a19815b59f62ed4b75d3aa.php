
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="bg-white shadow-lg w-64 flex-shrink-0" x-data="{ sidebarOpen: true }">
        <!-- Logo Section -->
        <div class="flex items-center justify-center h-16 px-4 border-b border-gray-200">
            <div class="flex items-center space-x-3">
                <img src="<?php echo e(asset('images/logo.jpg')); ?>" alt="Logo" class="w-8 h-8 rounded-full">
                <span class="text-lg font-bold text-gray-800">Dashboard Analisa</span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-6 px-4">
            <div class="space-y-2">
                <!-- Dashboard -->
                <a href="<?php echo e(route('dashboard')); ?>" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg <?php echo e(request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>

                <!-- Manajemen Staff -->
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin')): ?>
                <a href="<?php echo e(route('users.index')); ?>" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg <?php echo e(request()->routeIs('users.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Manajemen Staff
                </a>
                <?php endif; ?>

                <!-- Permohonan -->
                <a href="<?php echo e(route('permohonan.index')); ?>" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg <?php echo e(request()->routeIs('permohonan.*') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Permohonan
                </a>

                <!-- Statistik -->
                <a href="<?php echo e(route('statistik')); ?>" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg <?php echo e(request()->routeIs('statistik') ? 'bg-blue-50 text-blue-700 border-r-2 border-blue-700' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900'); ?>">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Statistik
                </a>
            </div>
        </nav>

        <!-- User Profile Section - Compact -->
        <div class="absolute bottom-0 left-0 w-64 p-2 bg-white" 
             x-data="{ 
                profileOpen: false,
                confirmLogout() {
                    Swal.fire({
                        title: 'Konfirmasi Logout',
                        text: 'Apakah Anda yakin ingin keluar dari sistem?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Ya, Logout',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = '<?php echo e(route('logout')); ?>';
                            
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '<?php echo e(csrf_token()); ?>';
                            
                            form.appendChild(csrfToken);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }
             }"
             style="z-index: 1;">
            <div class="relative">
                <!-- Profile Button - Compact -->
                <button @click="profileOpen = !profileOpen" class="flex items-center space-x-2 w-full p-1 rounded">
                    <div class="w-6 h-6 bg-purple-500 rounded-full flex items-center justify-center">
                        <span class="text-white text-xs font-bold"><?php echo e(substr(Auth::user()->name, 0, 2)); ?></span>
                    </div>
                    <div class="flex-1 min-w-0 text-left">
                        <p class="text-xs font-medium text-gray-900 truncate"><?php echo e(Auth::user()->name); ?></p>
                        <p class="text-xs text-gray-500 truncate capitalize"><?php echo e(Auth::user()->role); ?></p>
                    </div>
                    <svg class="w-3 h-3 text-gray-400" :class="{ 'rotate-180': profileOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="profileOpen" 
                     x-transition:enter="transition ease-out duration-75"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-50"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute bottom-full left-0 right-0 mb-1 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10 w-48"
                     @click.away="profileOpen = false"
                     style="pointer-events: auto;">
                    
                    <!-- Profile Info -->
                    <div class="px-3 py-2 border-b border-gray-100">
                        <p class="text-xs font-medium text-gray-900 truncate"><?php echo e(Auth::user()->name); ?></p>
                        <p class="text-xs text-gray-500 truncate"><?php echo e(Auth::user()->email); ?></p>
                        <p class="text-xs text-blue-600 capitalize"><?php echo e(Auth::user()->role); ?></p>
                    </div>

                    <!-- Profile Link -->
                    <a href="<?php echo e(route('profile.edit')); ?>" class="flex items-center px-3 py-1.5 text-xs text-gray-700">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
                    </a>

                    <!-- Settings Link -->
                    <a href="#" class="flex items-center px-3 py-1.5 text-xs text-gray-700">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Settings
                    </a>

                    <!-- Logout Button -->
                    <button @click="confirmLogout()" class="flex items-center w-full px-3 py-1.5 text-xs text-red-600">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200">
            <div class="px-6 py-4">
                <h1 class="text-2xl font-bold text-gray-900"><?php echo e($header ?? 'Dashboard'); ?></h1>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50" style="z-index: 0;">
            <div class="p-6">
                <?php echo e($slot); ?>

            </div>
        </main>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/components/sidebar.blade.php ENDPATH**/ ?>