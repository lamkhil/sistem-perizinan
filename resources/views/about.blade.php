<x-sidebar-layout>
    <x-slot name="header">Tentang Kami</x-slot>

    <div class="space-y-6">
        <!-- Container Utama - Deskripsi Sistem & Pengembang -->
        <div class="bg-gradient-to-br from-primary-500 via-primary-600 to-primary-700 rounded-2xl shadow-xl overflow-hidden">
            <div class="p-8 md:p-12 text-white">
                <!-- Icon Header -->
                <div class="flex items-center justify-center w-20 h-20 bg-white/20 rounded-2xl mb-6 mx-auto">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>

                <!-- Judul -->
                <h1 class="text-3xl md:text-4xl font-bold text-center mb-8">Sistem Analisa dan Tracking Perizinan</h1>

                <!-- Deskripsi Sistem -->
                <div class="mb-8 space-y-4 text-white/95 leading-relaxed">
                    <p class="text-lg text-center max-w-4xl mx-auto">
                        Sistem Perizinan adalah aplikasi web yang dirancang untuk mengoptimalkan proses pengurusan perizinan usaha. 
                        Sistem ini mendukung workflow multi-level dengan kontrol akses berdasarkan peran pengguna, memungkinkan 
                        pengelolaan yang efisien dari tahap pengajuan hingga persetujuan dan penerbitan dokumen resmi.
                    </p>
                    <p class="text-lg text-center max-w-4xl mx-auto">
                        Sistem ini menyediakan platform terintegrasi bagi berbagai pemangku kepentingan dalam proses perizinan, 
                        mulai dari pengajuan hingga penerbitan dokumen resmi dengan tingkat efisiensi, transparansi, dan akuntabilitas yang tinggi.
                    </p>
                </div>

                <!-- Divider -->
                <div class="border-t border-white/30 my-8"></div>

                <!-- Tentang Pengembang -->
                <div class="text-center">
                    <p class="text-lg text-white/95 leading-relaxed">
                        Website ini dikembangkan sebagai solusi untuk mengotomatisasi proses perizinan yang sebelumnya masih dilakukan secara manual. 
                        Sistem dilengkapi dengan fitur analisa data perizinan yang membantu perusahaan dalam mengevaluasi waktu proses, jumlah permohonan, 
                        dan tingkat penyelesaian perizinan. Selain itu, sistem ini memudahkan pelacakan status permohonan secara real-time untuk meningkatkan 
                        efisiensi, transparansi, dan ketepatan pengambilan keputusan.
                    </p>
                </div>
            </div>
        </div>

        <!-- Card Khusus Tim Pengembang -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            <div class="bg-gradient-sidebar p-6">
                <h2 class="text-2xl font-bold text-white text-center flex items-center justify-center">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    Tim Pengembang
                </h2>
            </div>
            
            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Developer 1 -->
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-6 border-2 border-primary-200 hover:border-primary-400 transition-all duration-300 hover:shadow-lg">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-20 h-20 bg-primary-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4 shadow-md">
                                MU
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Muhammad Ulil Amri</h3>
                            <p class="text-sm text-gray-600 mb-3">NIM: 23091397091</p>
                            <div class="w-16 h-0.5 bg-primary-300 my-2"></div>
                            <p class="text-sm text-gray-700 font-medium">
                                Program Studi Manajemen Informatika<br>
                                Universitas Negeri Surabaya
                            </p>
                        </div>
                    </div>

                    <!-- Developer 2 -->
                    <div class="bg-gradient-to-br from-primary-50 to-primary-100 rounded-xl p-6 border-2 border-primary-200 hover:border-primary-400 transition-all duration-300 hover:shadow-lg">
                        <div class="flex flex-col items-center text-center">
                            <div class="w-20 h-20 bg-primary-600 rounded-full flex items-center justify-center text-white text-2xl font-bold mb-4 shadow-md">
                                NA
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Nesyari Az-Zahra</h3>
                            <p class="text-sm text-gray-600 mb-3">NIM: 23091397104</p>
                            <div class="w-16 h-0.5 bg-primary-300 my-2"></div>
                            <p class="text-sm text-gray-700 font-medium">
                                Program Studi Manajemen Informatika<br>
                                Universitas Negeri Surabaya
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="mt-8 pt-6 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600">
                        <span class="font-semibold">Dikembangkan menggunakan</span> Laravel Framework
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-sidebar-layout>
