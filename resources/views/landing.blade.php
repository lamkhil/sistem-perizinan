<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Analisa & Tracking Perizinan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            overflow: hidden; /* Mencegah scrolling */
        }
        
        .gradient-bg {
            background-image: linear-gradient(to right, #0E2A66, #153476, #283593);
            position: relative;
        }

        .gradient-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4' viewBox='0 0 4 4'%3E%3Cpath fill='%239C92AC' fill-opacity='0.64' d='M1 3h1v1H1V3zm2-2h1v1H3V1z'%3E%3C/path%3E%3C/svg%3E");
            opacity: 0.9;
            z-index: 0;
            pointer-events: none;
            background-blend-mode: overlay;
        }
        
        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0); }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        .illustration-on-welcome {
            width: 100%; 
            max-width: 400px; /* Nilai diperkecil lagi */
            height: auto; 
            margin: auto;
            align-self: center; 
            z-index: 1; 
        }

        @media (max-width: 767px) { 
            .illustration-on-welcome {
                max-width: 250px; 
            }
        }

        @media (min-width: 768px) and (max-width: 1023px) { 
            .illustration-on-welcome {
                max-width: 350px; 
            }
        }

        @media (min-width: 1024px) { 
            .illustration-on-welcome {
                max-width: 450px; 
            }
        }

        @media (min-width: 1280px) { 
            .illustration-on-welcome {
                max-width: 500px; 
            }
        }

    </style>
</head>
<body class="antialiased" data-has-register-errors="{{ $errors->has('name') || $errors->has('role') ? 'true' : 'false' }}">
    <div class="min-h-screen grid lg:grid-cols-2">
        <!-- Bagian Kiri - Branding -->
        <div class="relative flex flex-col justify-between p-8 lg:p-16 gradient-bg text-white overflow-hidden">
            <div class="w-full z-10 space-y-4 md:space-y-6">
                <p class="text-xl md:text-2xl font-light">Selamat Datang,</p>
                <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                    Sistem Analisa & Tracking Perizinan
                </h1>
                <p class="mt-4 text-base md:text-lg leading-relaxed opacity-90">
                    Lacak dan kelola setiap tahap permohonan izin dengan mudah, cepat, dan transparan.
                </p>
            </div>
            
            <div class="mt-auto flex justify-center items-end h-full w-full">
                <img src="{{ asset('images/welcome-illustration.png') }}" alt="Ilustrasi Selamat Datang" class="illustration-on-welcome float-animation">
            </div>
        </div>

        <!-- Bagian Kanan - Form -->
        <div class="flex flex-col justify-center items-center p-8 lg:p-16 bg-white/70 backdrop-blur-md rounded-l-3xl shadow-lg">
            <div class="w-full max-w-sm">

                <!-- Login Form -->
                <div id="loginForm">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2 text-center lg:text-left">
                        Sign In
                    </h2>
                    <p class="text-gray-500 text-center lg:text-left mb-6">
                        Halo! Masukkan Detail Pribadimu.
                    </p>

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf
                        <div>
                            <input
                                id="email"
                                class="w-full px-5 py-3 bg-white border-2 border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                                type="email"
                                name="email"
                                placeholder="Email"
                                value="{{ old('email') }}"
                                required
                            />
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <input
                                id="password"
                                class="w-full px-5 py-3 bg-white border-2 border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                                type="password"
                                name="password"
                                placeholder="Password"
                                required
                            />
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <label for="remember_me" class="flex items-center text-gray-600 hover:text-gray-800 transition-colors cursor-pointer">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    class="rounded-md text-primary-600 focus:ring-primary-600 border-gray-300"
                                    name="remember"
                                />
                                <span class="ml-2 font-medium">Remember me</span>
                            </label>

                            <a href="{{ route('password.request') }}" class="text-primary-600 hover:text-primary-700 font-medium transition-colors">
                                Lupa password?
                            </a>
                        </div>

                        <div>
                            <button type="submit" class="w-full py-3 px-6 bg-gradient-primary text-white font-bold rounded-xl shadow-lg hover:opacity-95 transition-all duration-300 transform hover:scale-105">
                                MASUK
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Register Form -->
                <div id="registerForm" class="hidden">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-2 text-center lg:text-left">
                        Sign Up
                    </h2>
                    <p class="text-gray-500 text-center lg:text-left mb-6">
                        Buat akun baru untuk memulai.
                    </p>

                    <form method="POST" action="{{ route('landing.register') }}" class="space-y-4">
                        @csrf
                        <div>
                            <input
                                id="reg_name"
                                class="w-full px-5 py-3 bg-white border-2 border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                                type="text"
                                name="name"
                                placeholder="Nama Lengkap"
                                value="{{ old('name') }}"
                                required
                            />
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <input
                                id="reg_email"
                                class="w-full px-5 py-3 bg-white border-2 border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                                type="email"
                                name="email"
                                placeholder="Email"
                                value="{{ old('email') }}"
                                required
                            />
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <input
                                id="reg_password"
                                class="w-full px-5 py-3 bg-white border-2 border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                                type="password"
                                name="password"
                                placeholder="Password"
                                required
                            />
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <input
                                id="reg_password_confirmation"
                                class="w-full px-5 py-3 bg-white border-2 border-gray-200 rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-300"
                                type="password"
                                name="password_confirmation"
                                placeholder="Konfirmasi Password"
                                required
                            />
                        </div>

                        <div>
                            <select
                                id="reg_role"
                                class="w-full px-5 py-3 bg-white border-2 border-gray-200 rounded-xl text-gray-700 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-purple-600 transition-all duration-300"
                                name="role"
                                required
                            >
                                <option value="">Pilih Role</option>
                                <option value="dpmptsp" @selected(old('role') == 'dpmptsp')>DPMPTSP</option>
                                <option value="pd_teknis" @selected(old('role') == 'pd_teknis')>PD Teknis</option>
                                <option value="penerbitan_berkas" @selected(old('role') == 'penerbitan_berkas')>Penerbitan Berkas</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <button type="submit" class="w-full py-3 px-6 bg-gradient-primary text-white font-bold rounded-xl shadow-lg hover:opacity-95 transition-all duration-300 transform hover:scale-105">
                                DAFTAR
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="text-center mt-4">
                    <p class="text-gray-600 text-sm">
                        <span id="loginFooter">Belum punya akun? </span>
                        <span id="registerFooter" class="hidden">Sudah punya akun? </span>
                        <button id="switchToRegister" class="text-primary-600 hover:text-primary-700 font-bold">Daftar sekarang</button>
                        <button id="switchToLogin" class="text-primary-600 hover:text-primary-700 font-bold hidden">Masuk sekarang</button>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Form switching functionality
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const switchToRegister = document.getElementById('switchToRegister');
        const switchToLogin = document.getElementById('switchToLogin');
        const loginFooter = document.getElementById('loginFooter');
        const registerFooter = document.getElementById('registerFooter');

        function showLogin() {
            // Show/hide forms
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            
            // Update footer
            switchToRegister.classList.remove('hidden');
            switchToLogin.classList.add('hidden');
            loginFooter.classList.remove('hidden');
            registerFooter.classList.add('hidden');
        }

        function showRegister() {
            // Show/hide forms
            registerForm.classList.remove('hidden');
            loginForm.classList.add('hidden');
            
            // Update footer
            switchToLogin.classList.remove('hidden');
            switchToRegister.classList.add('hidden');
            loginFooter.classList.add('hidden');
            registerFooter.classList.remove('hidden');
        }

        // Event listeners
        switchToRegister.addEventListener('click', showRegister);
        switchToLogin.addEventListener('click', showLogin);

        // Initialize form based on errors
        const hasRegisterErrors = document.body.getAttribute('data-has-register-errors') === 'true';
        if (hasRegisterErrors) {
            showRegister();
        }
    </script>
</body>
</html>