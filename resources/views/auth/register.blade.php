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
            width: 120px;
            height: 120px;
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
            font-size: 1.2rem;
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
                    <span class="input-icon">👤</span>
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
                    <span class="input-icon">✉</span>
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
                    <span class="input-icon">🔒</span>
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
                    <span class="input-icon">🔒</span>
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
                    <span class="input-icon">👥</span>
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