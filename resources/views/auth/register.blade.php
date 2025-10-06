<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - DPMPTSP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0E2A66 0%, #092767 71%, #283593 100%);
            min-height: 100vh;
        }
        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 2rem;
        }
        .logo {
            width: 300px;
            height: 300px;
            border-radius: 50%;
            margin-bottom: 2rem;
        }
        .input-container {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            width: 20px;
            height: 20px;
        }
        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            color: white;
            font-size: 1rem;
        }
        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .form-input:focus {
            outline: none;
            border-color: #fbbf24;
            background: rgba(255, 255, 255, 0.15);
        }
        .form-select {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            color: white;
            font-size: 1rem;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 1rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
        }
        .form-select:focus {
            outline: none;
            border-color: #fbbf24;
            background-color: rgba(255, 255, 255, 0.15);
        }
        .form-select option {
            background: #0E2A66;
            color: white;
        }
        .register-btn {
            width: 100%;
            padding: 1rem;
            background: #283593;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .register-btn:hover {
            background: #092767;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo -->
            <div class="logo-container">
                <img src="{{ asset('images/dpmptsp-removebg.png') }}" alt="DPMPTSP Logo" class="logo">
            </div>

            <!-- Sign Up Form -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Sign Up</h1>
                <p class="text-white text-lg">Daftarkan Detail Pribadimu!</p>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <!-- Username Field -->
                <div class="input-container">
                    <svg class="input-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-input" 
                        placeholder="Username"
                        required
                    >
                </div>

                <!-- Email Field -->
                <div class="input-container">
                    <svg class="input-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                    </svg>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="Email"
                        required
                    >
                </div>

                <!-- Password Field -->
                <div class="input-container">
                    <svg class="input-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                    <input 
                        type="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Password"
                        required
                    >
                </div>

                <!-- Confirm Password Field -->
                <div class="input-container">
                    <svg class="input-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                    </svg>
                    <input 
                        type="password" 
                        name="password_confirmation" 
                        class="form-input" 
                        placeholder="Confirm Password"
                        required
                    >
                </div>

                <!-- Role Field -->
                <div class="input-container">
                    <svg class="input-icon" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                    </svg>
                    <select name="role" class="form-select" required>
                        <option value="" disabled selected>Role</option>
                        <option value="pd_teknis">Staff PD Teknis</option>
                        <option value="dpmptsp">Staff DPMPTSP</option>
                        <option value="penerbitan_berkas">Staff Penerbitan Berkas</option>
                    </select>
                </div>

                <!-- Register Button -->
                <button type="submit" class="register-btn">
                    Daftar
                </button>
            </form>

            <!-- Links -->
            <div class="text-center mt-6">
                <p class="text-white text-sm">
                    Sudah punya akun? 
                    <a href="{{ route('login') }}" class="text-yellow-300 hover:text-yellow-200 underline">
                        Masuk sekarang
                    </a>
                </p>
                <p class="text-white text-sm mt-2">
                    <a href="{{ route('landing') }}" class="text-yellow-300 hover:text-yellow-200 underline">
                        Kembali ke halaman utama
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>