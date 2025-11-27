{{-- Sidebar Layout --}}
<style>
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(-20px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }
</style>
<div class="flex h-screen bg-gray-100 overflow-hidden">
    <!-- Sidebar -->
    <div class="bg-gradient-sidebar shadow-lg w-64 flex-shrink-0 relative z-sidebar overflow-visible gpu-accelerated" x-data="{ sidebarOpen: true }">
        <!-- Logo Section -->
        <div class="flex items-center justify-center h-16 px-4 border-b border-white/20">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="w-8 h-8 rounded-full" loading="lazy" decoding="async">
                <span class="text-lg font-bold text-white">Dashboard Analisa</span>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-6 px-4 optimize-rendering">
            <div class="space-y-2">
                <!-- Dashboard -->
                @if(auth()->user() && auth()->user()->role !== 'penerbitan_berkas')
                <a href="{{ route('dashboard') }}" 
                   rel="prefetch"
                   onmouseenter="this.rel='prefetch'; if (!this.dataset.prefetched) { const link = document.createElement('link'); link.rel='prefetch'; link.href=this.href; link.as='document'; document.head.appendChild(link); this.dataset.prefetched='true'; }"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white border-r-2 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-colors duration-150">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                @endif

                <!-- Manajemen Staff -->
                @can('admin')
                <a href="{{ route('users.index') }}" 
                   rel="prefetch"
                   onmouseenter="this.rel='prefetch'; if (!this.dataset.prefetched) { const link = document.createElement('link'); link.rel='prefetch'; link.href=this.href; link.as='document'; document.head.appendChild(link); this.dataset.prefetched='true'; }"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('users.*') ? 'bg-white/20 text-white border-r-2 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-colors duration-150">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Manajemen Staff
                </a>
                @endcan

                <!-- Permohonan -->
                @if(auth()->user() && auth()->user()->role !== 'penerbitan_berkas')
                <a href="{{ route('permohonan.index') }}" 
                   rel="prefetch"
                   onmouseenter="this.rel='prefetch'; if (!this.dataset.prefetched) { const link = document.createElement('link'); link.rel='prefetch'; link.href=this.href; link.as='document'; document.head.appendChild(link); this.dataset.prefetched='true'; }"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('permohonan.*') ? 'bg-white/20 text-white border-r-2 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-colors duration-150">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Permohonan
                </a>
                @endif

                <!-- Statistik -->
                @if(auth()->user() && auth()->user()->role !== 'penerbitan_berkas')
                <a href="{{ route('statistik') }}" 
                   rel="prefetch"
                   onmouseenter="this.rel='prefetch'; if (!this.dataset.prefetched) { const link = document.createElement('link'); link.rel='prefetch'; link.href=this.href; link.as='document'; document.head.appendChild(link); this.dataset.prefetched='true'; }"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('statistik') ? 'bg-white/20 text-white border-r-2 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-colors duration-150">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Statistik
                </a>
                @endif

                <!-- Penerbitan Berkas -->
                @if(auth()->user() && in_array(auth()->user()->role, ['admin', 'penerbitan_berkas']))
                <a href="{{ route('penerbitan-berkas') }}" 
                   rel="prefetch"
                   onmouseenter="this.rel='prefetch'; if (!this.dataset.prefetched) { const link = document.createElement('link'); link.rel='prefetch'; link.href=this.href; link.as='document'; document.head.appendChild(link); this.dataset.prefetched='true'; }"
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('penerbitan-berkas') ? 'bg-white/20 text-white border-r-2 border-white' : 'text-white/80 hover:bg-white/10 hover:text-white' }} transition-colors duration-150">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Penerbitan Berkas
                </a>
                @endif

            </div>
        </nav>

        <!-- Notifications Section (for dpmptsp and admin user) -->
        @if(auth()->user() && in_array(auth()->user()->role, ['dpmptsp', 'admin']))
        <div class="px-4 mt-4" 
             x-data="{
                notifications: [],
                count: 0,
                showDropdown: false,
                loading: false,
                refreshInterval: null,
                isFetching: false,
                lastFetchTime: 0,
                countCache: null,
                countCacheTime: 0,
                CACHE_DURATION: 30000, // 30 detik cache untuk count
                async fetchCountOnly() {
                    const now = Date.now();
                    if (this.countCache !== null && (now - this.countCacheTime) < this.CACHE_DURATION) {
                        this.count = this.countCache;
                        return;
                    }
                    
                    if (this.isFetching) {
                        return;
                    }
                    this.isFetching = true;
                    try {
                        const response = await fetch('{{ route('api.notifications') }}', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            cache: 'default'
                        });
                        if (response.ok) {
                            const data = await response.json();
                            this.count = data.count || 0;
                            this.countCache = this.count;
                            this.countCacheTime = Date.now();
                        }
                    } catch (error) {
                        this.count = 0;
                    } finally {
                        this.isFetching = false;
                    }
                },
                async fetchNotifications(showLoading = false) {
                    if (this.isFetching) {
                        return;
                    }
                    
                    const now = Date.now();
                    if (!showLoading && (now - this.lastFetchTime) < 2000) {
                        return;
                    }
                    
                    this.isFetching = true;
                    this.lastFetchTime = now;
                    
                    if (showLoading) {
                        this.loading = true;
                    }
                    try {
                        const response = await fetch('{{ route('api.notifications') }}', {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'Cache-Control': 'no-cache'
                            },
                            cache: 'no-store'
                        });
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        const data = await response.json();
                        this.notifications = data.notifications || [];
                        this.count = data.count || 0;
                    } catch (error) {
                        console.error('Error fetching notifications:', error);
                        this.notifications = [];
                        this.count = 0;
                    } finally {
                        this.isFetching = false;
                        if (showLoading) {
                            this.loading = false;
                        }
                    }
                },
                handleNotificationClick(url) {
                    if (!url) {
                        console.error('URL notifikasi tidak valid:', url);
                        return;
                    }
                    this.showDropdown = false;
                    setTimeout(() => {
                        window.location.href = url;
                    }, 150);
                },
                init() {
                    this.showDropdown = false;
                    this.notifications = [];
                    this.loading = false;
                    
                    if ('requestIdleCallback' in window) {
                        requestIdleCallback(() => {
                            this.fetchCountOnly();
                        }, { timeout: 2000 });
                    } else {
                        setTimeout(() => {
                            this.fetchCountOnly();
                        }, 2000);
                    }
                },
                destroy() {
                    if (this.refreshInterval) {
                        clearInterval(this.refreshInterval);
                    }
                }
             }"
             @click.away="showDropdown = false">
            <div class="relative">
                <button @click="showDropdown = !showDropdown; if (showDropdown) { $nextTick(() => { fetchNotifications(true); }); }" 
                        class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium rounded-lg text-white/80 hover:bg-white/10 hover:text-white transition-colors duration-150 gpu-accelerated">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span>Notifikasi</span>
                    </div>
                    <span x-show="count > 0" 
                          x-text="count" 
                          class="ml-2 px-2.5 py-1 text-xs font-bold text-white bg-orange-500 rounded-full shadow-md"></span>
                </button>

                <!-- Modal Notifications (Muncul di Tengah) -->
                <template x-if="showDropdown">
                    <div x-show="showDropdown"
                         x-cloak
                         x-init="$watch('showDropdown', value => { if (value) { document.body.style.overflow = 'hidden'; } else { document.body.style.overflow = ''; } })"
                         class="notification-modal overflow-y-auto"
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition ease-in duration-200"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         @click.self="showDropdown = false">
                    <!-- Overlay -->
                    <div class="notification-modal bg-black bg-opacity-50 transition-opacity" style="z-index: 99998 !important;"></div>
                    
                    <!-- Modal Content -->
                    <div class="notification-modal pointer-events-none" style="z-index: 99999 !important; display: flex !important; align-items: center !important; justify-content: center !important; padding: 1rem !important;">
                        <div class="relative bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-[80vh] flex flex-col pointer-events-auto"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                            <!-- Header -->
                            <div class="flex items-center justify-between p-4 border-b-2 border-orange-300 bg-gradient-to-r from-orange-50 to-amber-50 rounded-t-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-semibold text-orange-800">Berkas Dikembalikan</h3>
                                        <p class="text-sm text-orange-600 mt-0.5">Silakan periksa dan tindak lanjuti</p>
                                    </div>
                                </div>
                                <button @click="showDropdown = false" 
                                        class="text-orange-400 hover:text-orange-600 transition-colors p-1 hover:bg-orange-100 rounded-full">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Body -->
                            <div class="flex-1 overflow-y-auto p-4">
                                <div x-show="loading" class="text-center py-8 text-gray-500">
                                    <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500"></div>
                                    <p class="mt-2 text-sm">Memuat notifikasi...</p>
                                </div>
                                
                                <div x-show="!loading && notifications.length === 0" class="text-center py-8 text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="mt-2 text-sm">Tidak ada notifikasi</p>
                                </div>
                                
                                <div x-show="!loading && notifications.length > 0" class="space-y-3">
                                    <template x-for="(notification, index) in notifications" :key="index">
                                        <div class="relative border-l-4 border-orange-400 bg-gradient-to-r from-orange-50/50 to-white rounded-lg hover:shadow-md transition-all duration-200"
                                             :style="`animation: slideIn 0.3s ease-out; animation-delay: ${index * 0.1}s;`"
                                             x-data="{ 
                                                expanded: false, 
                                                saving: false,
                                                status: notification.status || 'Dikembalikan',
                                                menghubungi: notification.menghubungi || '',
                                                keterangan_menghubungi: notification.keterangan_menghubungi || '',
                                                async saveChanges() {
                                                    this.saving = true;
                                                    try {
                                                        const response = await fetch(`{{ url('/api/notifications') }}/${notification.id}/update`, {
                                                            method: 'POST',
                                                            headers: {
                                                                'Content-Type': 'application/json',
                                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                                'X-Requested-With': 'XMLHttpRequest',
                                                                'Accept': 'application/json'
                                                            },
                                                            body: JSON.stringify({
                                                                status: this.status,
                                                                menghubungi: this.menghubungi || null,
                                                                keterangan_menghubungi: this.keterangan_menghubungi || null
                                                            })
                                                        });
                                                        const data = await response.json();
                                                        if (data.success) {
                                                            Swal.fire({
                                                                icon: 'success',
                                                                title: 'Berhasil!',
                                                                text: data.message,
                                                                timer: 2000,
                                                                showConfirmButton: false
                                                            });
                                                            this.expanded = false;
                                                            // Refresh notifications - dispatch event
                                                            window.dispatchEvent(new CustomEvent('refresh-notifications'));
                                                        } else {
                                                            throw new Error(data.message || 'Terjadi kesalahan');
                                                        }
                                                    } catch (error) {
                                                        Swal.fire({
                                                            icon: 'error',
                                                            title: 'Gagal!',
                                                            text: error.message || 'Terjadi kesalahan saat menyimpan'
                                                        });
                                                    } finally {
                                                        this.saving = false;
                                                    }
                                                }
                                             }">
                                            <!-- Header - Clickable untuk expand/collapse -->
                                            <div @click.stop="expanded = !expanded" 
                                                 class="group p-4 cursor-pointer hover:from-orange-100 hover:to-orange-50/50 hover:border-orange-500">
                                                <div class="flex items-start">
                                                    <div class="flex-shrink-0">
                                                        <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                                                            <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="ml-4 flex-1 min-w-0">
                                                        <div class="flex items-center space-x-2">
                                                            <p class="text-sm font-semibold text-orange-800" x-text="notification.no_permohonan"></p>
                                                            <span class="px-2 py-0.5 text-xs font-medium text-orange-700 bg-orange-100 rounded-full">Perlu Tindakan</span>
                                                        </div>
                                                        <p class="text-sm text-gray-700 mt-1 font-medium" x-text="notification.nama_usaha"></p>
                                                        <p class="text-sm text-gray-600 mt-2" x-text="notification.keterangan"></p>
                                                        <div class="flex items-center mt-3 space-x-4">
                                                            <p class="text-xs text-orange-600 font-medium bg-orange-50 px-2 py-1 rounded" x-show="notification.tanggal_pengembalian" x-text="'Dikembalikan: ' + notification.tanggal_pengembalian"></p>
                                                            <p class="text-xs text-gray-400" x-text="notification.created_at"></p>
                                                        </div>
                                                    </div>
                                                    <div class="flex-shrink-0 ml-2 flex items-center space-x-2">
                                                        <button @click.stop="expanded = !expanded" 
                                                                class="text-orange-400 hover:text-orange-600 transition-colors p-1">
                                                            <svg class="w-5 h-5 transition-transform" :class="{'rotate-180': expanded}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                            </svg>
                                                        </button>
                                                        <a @click.stop :href="notification.url" 
                                                           class="text-orange-400 hover:text-orange-600 transition-transform hover:translate-x-1">
                                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Form Section - Expandable -->
                                            <div x-show="expanded" 
                                                 x-transition:enter="transition ease-out duration-200"
                                                 x-transition:enter-start="opacity-0 max-h-0"
                                                 x-transition:enter-end="opacity-100 max-h-96"
                                                 x-transition:leave="transition ease-in duration-150"
                                                 x-transition:leave-start="opacity-100 max-h-96"
                                                 x-transition:leave-end="opacity-0 max-h-0"
                                                 @click.stop
                                                 class="px-4 pb-4 border-t border-orange-200 bg-orange-50/30 overflow-hidden">
                                                <div class="pt-4 space-y-3">
                                                    <!-- Status Dropdown -->
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                                                        <select x-model="status" 
                                                                class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500">
                                                            <option value="Dikembalikan">Dikembalikan</option>
                                                            <option value="Menunggu">Menunggu</option>
                                                            <option value="Diterima">Diterima</option>
                                                            <option value="Ditolak">Ditolak</option>
                                                        </select>
                                                    </div>
                                                    
                                                    <!-- Menghubungi Date -->
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal Menghubungi</label>
                                                        <input type="date" 
                                                               x-model="menghubungi"
                                                               class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500" />
                                                    </div>
                                                    
                                                    <!-- Keterangan Menghubungi -->
                                                    <div>
                                                        <label class="block text-xs font-medium text-gray-700 mb-1">Keterangan Menghubungi</label>
                                                        <!-- Template Buttons -->
                                                        <div class="flex flex-wrap gap-2 mb-2">
                                                            <button type="button" 
                                                                    @click="if (!keterangan_menghubungi || !keterangan_menghubungi.startsWith('Belum dihubungi')) { keterangan_menghubungi = 'Belum dihubungi\n\n' + (keterangan_menghubungi || ''); }"
                                                                    class="px-3 py-1.5 text-xs font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-md hover:bg-gray-200 transition-colors">
                                                                Belum dihubungi
                                                            </button>
                                                            <button type="button" 
                                                                    @click="if (!keterangan_menghubungi || !keterangan_menghubungi.startsWith('Telah dihubungi')) { keterangan_menghubungi = 'Telah dihubungi\n\n' + (keterangan_menghubungi || ''); }"
                                                                    class="px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-100 border border-blue-300 rounded-md hover:bg-blue-200 transition-colors">
                                                                Telah dihubungi
                                                            </button>
                                                            <button type="button" 
                                                                    @click="if (!keterangan_menghubungi || !keterangan_menghubungi.startsWith('Tidak bisa dihubungi')) { keterangan_menghubungi = 'Tidak bisa dihubungi\n\n' + (keterangan_menghubungi || ''); }"
                                                                    class="px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 border border-red-300 rounded-md hover:bg-red-200 transition-colors">
                                                                Tidak bisa dihubungi
                                                            </button>
                                                        </div>
                                                        <textarea x-model="keterangan_menghubungi"
                                                                  rows="3"
                                                                  placeholder="Masukkan keterangan menghubungi atau gunakan template di atas..."
                                                                  class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-orange-500 focus:ring-orange-500"></textarea>
                                                    </div>
                                                    
                                                    <!-- Action Buttons -->
                                                    <div class="flex items-center space-x-2 pt-2">
                                                        <button @click="saveChanges()" 
                                                                :disabled="saving"
                                                                class="flex-1 px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-md hover:bg-orange-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                                            <span x-show="!saving">Simpan</span>
                                                            <span x-show="saving" class="flex items-center justify-center">
                                                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                                                </svg>
                                                                Menyimpan...
                                                            </span>
                                                        </button>
                                                        <button @click="expanded = false" 
                                                                class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-300 transition-colors">
                                                            Batal
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                            
                            <!-- Footer -->
                            <div x-show="!loading && notifications.length > 0" 
                                 class="p-4 border-t border-orange-200 bg-orange-50/50 rounded-b-lg">
                                <p class="text-sm text-center text-orange-700">
                                    Total <span x-text="count" class="font-semibold"></span> berkas dikembalikan yang perlu ditindak lanjuti
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                </template>
            </div>
        </div>
        @endif

        <!-- User Profile Section - Compact -->
        <div class="absolute bottom-0 left-0 w-64 p-2 bg-gradient-sidebar" 
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
                            form.action = '{{ route('logout') }}';
                            
                            const csrfToken = document.createElement('input');
                            csrfToken.type = 'hidden';
                            csrfToken.name = '_token';
                            csrfToken.value = '{{ csrf_token() }}';
                            
                            form.appendChild(csrfToken);
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                }
             }"
             class="z-profile-dropdown">
            <div class="relative">
                <!-- Profile Button - Compact -->
                <button @click="profileOpen = !profileOpen" class="flex items-center space-x-2 w-full p-1 rounded">
                    <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center">
                        <span class="text-white text-xs font-bold">{{ Auth::user() ? substr(Auth::user()->name, 0, 2) : 'U' }}</span>
                    </div>
                    <div class="flex-1 min-w-0 text-left">
                        <p class="text-xs font-medium text-white truncate">{{ Auth::user() ? Auth::user()->name : 'User' }}</p>
                        <p class="text-xs text-white/70 truncate capitalize">{{ Auth::user() ? Auth::user()->role : 'guest' }}</p>
                    </div>
                    <svg class="w-3 h-3 text-white/60" :class="{ 'rotate-180': profileOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                     class="absolute bottom-full left-0 right-0 mb-1 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-10 w-48 pointer-events-auto"
                     @click.away="profileOpen = false">
                    
                    <!-- Profile Info -->
                    <div class="px-3 py-2 border-b border-gray-100">
                        <p class="text-xs font-medium text-gray-900 truncate">{{ Auth::user() ? Auth::user()->name : 'User' }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ Auth::user() ? Auth::user()->email : 'user@example.com' }}</p>
                        <p class="text-xs text-primary-500 capitalize">{{ Auth::user() ? Auth::user()->role : 'guest' }}</p>
                    </div>

                    <!-- Profile Link -->
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-1.5 text-xs text-gray-700">
                        <svg class="w-3 h-3 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Profile
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
    <div class="flex-1 flex flex-col overflow-hidden min-h-0">
        <!-- Header -->
        <header class="bg-white shadow-sm border-b border-gray-200 flex-shrink-0">
            <div class="px-6 py-4">
                <h1 class="text-2xl font-bold text-gray-900">{{ $header ?? 'Dashboard' }}</h1>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 z-content min-h-0 max-h-full">
            <div class="p-6 pb-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>

<script>
function handleLogout(event) {
    event.preventDefault();
    
    try {
        const form = event.target.closest('form');
        if (form) {
            form.submit();
        } else {
            window.location.href = '{{ route("logout.get") }}';
        }
    } catch (error) {
        console.error('Logout error:', error);
        window.location.href = '{{ route("logout.get") }}';
    }
}

window.emergencyLogout = function() {
    window.location.href = '{{ route("logout.get") }}';
};
</script>
