<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DPMPTSP</title>
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
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .checkbox {
            margin-right: 0.5rem;
            accent-color: #fbbf24;
        }
        .forgot-link {
            color: white;
            text-decoration: none;
            font-size: 0.9rem;
        }
        .forgot-link:hover {
            color: #fbbf24;
        }
        .login-btn {
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
        .login-btn:hover {
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

            <!-- Login Form -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-white mb-2">Login</h1>
                <p class="text-white text-lg">Masukkan Detail Pribadimu!</p>
            </div>

            <form action="{{ route('login') }}" method="POST">
                @csrf
                
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

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-6">
                    <label class="checkbox-container text-white">
                        <input type="checkbox" name="remember" class="checkbox">
                        <span>Ingat Saya</span>
                    </label>
                    <a href="#" class="forgot-link">Lupa Password?</a>
                </div>

                <!-- Login Button -->
                <button type="submit" class="login-btn">
                    Masuk
                </button>
            </form>

            <!-- Links -->
            <div class="text-center mt-6">
                <p class="text-white text-sm">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-yellow-300 hover:text-yellow-200 underline">
                        Daftar sekarang
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