<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* CSS Tambahan untuk Pola SVG */
        .gradient-with-pattern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: transparent;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='4' height='4' viewBox='0 0 4 4'%3E%3Cpath fill='%239C92AC' fill-opacity='0.64' d='M1 3h1v1H1V3zm2-2h1v1H3V1z'%3E%3C/path%3E%3C/svg%3E");
            opacity: 0.9;
            z-index: 0;
            pointer-events: none;
            background-blend-mode: overlay;
        }

        /* Perbaikan warna teks agar lebih kontras */
        .main-title, .greeting {
            color: #FFFFFF;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
        }
        .description {
            color: #D1D5DB;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.2);
        }

        /* Styling untuk gambar PNG */
        .illustration-image {
            display: none; /* Sembunyikan secara default untuk mobile */
        }

        @media (min-width: 1024px) { /* Tampilkan di layar besar (lg dan lebih besar) */
            .illustration-image {
                display: block;
                position: absolute;
                /* Perubahan: Mengatur posisi agar sedikit ke atas */
                bottom: 25%; /* Sesuaikan nilai ini untuk menaikkan/menurunkan gambar */
                right: 3rem; /* Sesuaikan jarak dari kanan */
                width: 45%; /* Atur lebar gambar */
                max-width: 500px; /* Batasi lebar maksimum */
                z-index: 10;
                animation: float 6s ease-in-out infinite;
            }
        }

        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
            100% { transform: translateY(0); }
        }

        /* Penyesuaian z-index untuk login/register agar di atas ilustrasi */
        .z-20 {
            z-index: 20;
        }
    </style>
</head>
<body class="antialiased">
    <div class="relative min-h-screen bg-gradient-sidebar selection:bg-primary-500 selection:text-white gradient-with-pattern">
        @if (Route::has('login'))
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-end z-20">
                @auth
                    <a href="{{ url('/dashboard') }}" class="font-semibold text-white hover:text-gray-300 focus:outline focus:outline-2 focus:rounded-sm focus:outline-white">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="font-semibold text-white hover:text-gray-300 focus:outline focus:outline-2 focus:rounded-sm focus:outline-white">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ms-4 font-semibold text-white hover:text-gray-300 focus:outline focus:outline-2 focus:rounded-sm focus:outline-white">Register</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="max-w-7xl mx-auto p-6 lg:p-8 flex items-center min-h-screen relative z-10">
            <div class="text-left w-full max-w-2xl lg:max-w-4xl">
                <p class="text-3xl md:text-4xl font-light mb-2 greeting">Selamat Datang,</p>
                <h1 class="text-5xl md:text-6xl font-bold leading-tight main-title">
                    Sistem Analisa & Tracking Perizinan
                </h1>
                <p class="mt-4 text-xl leading-relaxed description">
                    Lacak dan kelola setiap tahap permohonan izin dengan mudah, cepat, dan transparan.
                </p>
                <div class="mt-10">
                    <a href="{{ route('login') }}" class="inline-flex items-center px-10 py-4 bg-white text-primary-600 font-bold uppercase tracking-wider rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 transition ease-in-out duration-150 transform hover:scale-105">
                        Get Started
                    </a>
                </div>
            </div>
        </div>

        <div class="illustration-image">
            <img src="{{ asset('images/welcome-illustration.png') }}" alt="Ilustrasi Selamat Datang">
        </div>
    </div>
</body>
</html>