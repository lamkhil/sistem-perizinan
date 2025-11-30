<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign Up - DPMPTSP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700;800&family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap');
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Montserrat', 'Poppins', 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
        }
        .left-section {
            width: 50%;
            background: linear-gradient(135deg, #0A1A3A 0%, #071024 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }
        .left-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at center, rgba(255, 255, 255, 0.03) 0%, transparent 70%);
            pointer-events: none;
        }
        .left-section::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(ellipse at center, transparent 0%, rgba(0, 0, 0, 0.4) 100%);
            pointer-events: none;
        }
        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 3rem;
            position: relative;
            z-index: 1;
        }
        .logo {
            width: 300px;
            height: 300px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fbbf24;
            background: white;
            padding: 15px;
            box-shadow: 0 0 30px rgba(212, 176, 101, 0.25), 0 0 60px rgba(212, 176, 101, 0.15), 0 5px 15px rgba(0, 0, 0, 0.3), inset 0 -2px 10px rgba(251, 191, 36, 0.15);
            filter: drop-shadow(0 0 20px rgba(212, 176, 101, 0.2));
            position: relative;
        }
        .logo::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            width: 60%;
            height: 30%;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.3) 0%, transparent 100%);
            border-radius: 50% 50% 0 0;
            pointer-events: none;
        }
        .branding {
            text-align: center;
            color: white;
            margin-top: 2rem;
            position: relative;
            z-index: 1;
        }
        .branding h2 {
            font-size: 1.5rem;
            font-weight: 300;
            margin-bottom: 2rem;
            font-family: 'Cormorant Garamond', 'Cinzel', serif;
            color: rgba(255, 255, 255, 0.95);
            letter-spacing: 2px;
        }
        .branding h1 {
            font-size: 5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            letter-spacing: 3px;
            font-family: 'Cinzel', 'Cormorant Garamond', serif;
            background: linear-gradient(135deg, #FDE07D 0%, #F5C241 50%, #E6B12A 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 30px rgba(245, 194, 65, 0.25), 0 0 60px rgba(230, 177, 42, 0.2);
            position: relative;
            display: inline-block;
            filter: drop-shadow(0 0 15px rgba(245, 194, 65, 0.3));
        }
        .branding .divider {
            width: 60px;
            height: 1px;
            background: rgba(255, 255, 255, 0.2);
            margin: 1.5rem auto;
        }
        .branding .tagline {
            font-size: 0.8125rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.8);
            font-family: 'Montserrat', sans-serif;
            letter-spacing: 0.5px;
            margin-top: 0.5rem;
            text-transform: uppercase;
        }
        .branding p {
            font-size: 0.875rem;
            font-weight: 400;
            color: rgba(255, 255, 255, 0.88);
            font-family: 'Montserrat', sans-serif;
            letter-spacing: 0.3px;
            margin-top: 1rem;
            line-height: 1.6;
        }
        .right-section {
            width: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .form-card {
            background: rgba(255, 255, 255, 0.75);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            border-radius: 16px;
            padding: 3rem;
            padding-top: 3.5rem;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }
        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .form-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #0E2A66;
            margin-bottom: 0.5rem;
        }
        .form-header p {
            color: #6b7280;
            font-size: 0.95rem;
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
            color: #6b7280;
            width: 20px;
            height: 20px;
            z-index: 1;
        }
        .form-input {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #1f2937;
            background: white;
            transition: all 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: #0E2A66;
            box-shadow: 0 0 0 3px rgba(14, 42, 102, 0.1);
        }
        .form-input::placeholder {
            color: #9ca3af;
        }
        .form-select {
            width: 100%;
            padding: 0.875rem 1rem 0.875rem 3rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.95rem;
            color: #1f2937;
            background: white;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 1rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            cursor: pointer;
            transition: all 0.2s;
        }
        .form-select:focus {
            outline: none;
            border-color: #0E2A66;
            box-shadow: 0 0 0 3px rgba(14, 42, 102, 0.1);
        }
        .form-select option {
            background: white;
            color: #1f2937;
        }
        .register-btn {
            width: 100%;
            padding: 0.875rem;
            background: linear-gradient(135deg, #0F2547 0%, #163A6F 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12), inset 0 1px 0 rgba(255, 255, 255, 0.1), inset 0 -1px 0 rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .register-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            border-radius: 8px 8px 0 0;
        }
        .register-btn:hover {
            background: linear-gradient(135deg, #163A6F 0%, #1B4A8F 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(14, 42, 102, 0.25), inset 0 1px 0 rgba(255, 255, 255, 0.15), inset 0 -1px 0 rgba(0, 0, 0, 0.15);
        }
        .form-footer {
            text-align: center;
            margin-top: 1.5rem;
            color: #6b7280;
            font-size: 0.9rem;
        }
        .form-footer a {
            color: #0E2A66;
            text-decoration: none;
            font-weight: 500;
        }
        .form-footer a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: #ef4444;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }
        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }
            .left-section {
                width: 100%;
                min-height: 40vh;
            }
            .right-section {
                width: 100%;
            }
            .logo {
                width: 150px;
                height: 150px;
            }
            .branding h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Left Section - Branding -->
    <div class="left-section">
        <div class="logo-container">
            <img src="{{ asset('images/dpmptsp-removebg.png') }}" alt="DPMPTSP Logo" class="logo">
        </div>
        <div class="branding">
            <h2>Selamat Datang,</h2>
            <h1>MASPATI</h1>
            <div class="divider"></div>
            <p class="tagline">Platform Resmi Pemerintah Kota Surabaya</p>
            <p>Monitoring Analisa Sistem Perizinan Terintegrasi</p>
        </div>
    </div>

    <!-- Right Section - Register Form -->
    <div class="right-section">
        <div class="form-card">
            <div class="form-header">
                <h1>Sign Up</h1>
                <p>Daftarkan Detail Pribadimu!</p>
            </div>

            <form action="{{ route('register') }}" method="POST">
                @csrf
                
                <!-- Username Field -->
                @if($errors->has('name'))
                    <div class="error-message">{{ $errors->first('name') }}</div>
                @endif
                <div class="input-container">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <input 
                        type="text" 
                        name="name" 
                        class="form-input" 
                        placeholder="Username"
                        required
                        value="{{ old('name') }}"
                    >
                </div>

                <!-- Email Field -->
                @if($errors->has('email'))
                    <div class="error-message">{{ $errors->first('email') }}</div>
                @endif
                <div class="input-container">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-input" 
                        placeholder="Email"
                        required
                        value="{{ old('email') }}"
                    >
                </div>

                <!-- Password Field -->
                @if($errors->has('password'))
                    <div class="error-message">{{ $errors->first('password') }}</div>
                @endif
                <div class="input-container">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
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
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
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
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                    <select name="role" id="role" class="form-select" required onchange="toggleSektorField()">
                        <option value="" disabled selected>Role</option>
                        <option value="pd_teknis" {{ old('role') == 'pd_teknis' ? 'selected' : '' }}>Staff PD Teknis</option>
                        <option value="dpmptsp" {{ old('role') == 'dpmptsp' ? 'selected' : '' }}>Staff DPMPTSP</option>
                        <option value="penerbitan_berkas" {{ old('role') == 'penerbitan_berkas' ? 'selected' : '' }}>Staff Penerbitan Berkas</option>
                    </select>
                </div>

                <!-- Sektor Field (Hidden by default) -->
                <div class="input-container" id="sektor-container" style="display: none;">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <select name="sektor" id="sektor" class="form-select">
                        <option value="" disabled selected>Sektor</option>
                        <option value="Dinkopdag" {{ old('sektor') == 'Dinkopdag' ? 'selected' : '' }}>Dinkopdag</option>
                        <option value="Disbudpar" {{ old('sektor') == 'Disbudpar' ? 'selected' : '' }}>Disbudpar</option>
                        <option value="Dinkes" {{ old('sektor') == 'Dinkes' ? 'selected' : '' }}>Dinkes</option>
                        <option value="Dishub" {{ old('sektor') == 'Dishub' ? 'selected' : '' }}>Dishub</option>
                        <option value="Dprkpp" {{ old('sektor') == 'Dprkpp' ? 'selected' : '' }}>Dprkpp</option>
                        <option value="Dkpp" {{ old('sektor') == 'Dkpp' ? 'selected' : '' }}>Dkpp</option>
                        <option value="Dlh" {{ old('sektor') == 'Dlh' ? 'selected' : '' }}>Dlh</option>
                        <option value="Disperinaker" {{ old('sektor') == 'Disperinaker' ? 'selected' : '' }}>Disperinaker</option>
                    </select>
                </div>

                <!-- Register Button -->
                <button type="submit" class="register-btn">
                    Daftar
                </button>
            </form>

            <!-- Footer Links -->
            <div class="form-footer">
                <p>
                    Sudah punya akun? 
                    <a href="{{ route('login') }}">Masuk sekarang</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        function toggleSektorField() {
            const roleSelect = document.getElementById('role');
            const sektorContainer = document.getElementById('sektor-container');
            const sektorSelect = document.getElementById('sektor');
            
            if (roleSelect.value === 'pd_teknis') {
                sektorContainer.style.display = 'block';
                sektorSelect.required = true;
            } else {
                sektorContainer.style.display = 'none';
                sektorSelect.required = false;
                sektorSelect.value = '';
            }
        }

        // Check if role was previously selected (for old() values)
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            if (roleSelect.value === 'pd_teknis') {
                toggleSektorField();
            }
            
            // Setup CSRF token for AJAX requests
            window.Laravel = {
                csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            };
            
            // Update CSRF token in all forms when page loads
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (csrfToken) {
                const csrfInputs = document.querySelectorAll('input[name="_token"]');
                csrfInputs.forEach(input => {
                    input.value = csrfToken;
                });
            }
        });
    </script>
</body>
</html>
