<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Login - DPMPTSP</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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
            background: radial-gradient(circle at center, rgba(255, 255, 255, 0.03) 0%, transparent 60%);
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
        .toggle-visibility {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6b7280;
            background: transparent;
            border: none;
            cursor: pointer;
            width: 24px;
            height: 24px;
            padding: 0;
            z-index: 1;
        }
        .toggle-visibility:hover {
            color: #0E2A66;
        }
        .captcha-container {
            margin-bottom: 1rem;
        }
        .captcha-container img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            border: 1px solid #dfe7f4;
            cursor: pointer;
            background: #f8fafc;
            padding: 4px;
        }
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .checkbox-container {
            display: flex;
            align-items: center;
        }
        .checkbox-container input[type="checkbox"] {
            margin-right: 0.5rem;
            accent-color: #0E2A66;
        }
        .checkbox-container label {
            color: #4b5563;
            font-size: 0.9rem;
            cursor: pointer;
        }
        .forgot-link {
            color: #0E2A66;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .forgot-link:hover {
            text-decoration: underline;
        }
        .login-btn {
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
        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            border-radius: 8px 8px 0 0;
        }
        .login-btn:hover {
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
            <img src="<?php echo e(asset('images/dpmptsp-removebg.png')); ?>" alt="DPMPTSP Logo" class="logo">
        </div>
        <div class="branding">
            <h2>Selamat Datang,</h2>
            <h1>MASPATI</h1>
            <p>Monitoring Analisa Sistem Perizinan Terintegrasi</p>
        </div>
    </div>

    <!-- Right Section - Login Form -->
    <div class="right-section">
        <div class="form-card">
            <div class="form-header">
                <h1>Login</h1>
                <p>Masukkan Detail Pribadimu!</p>
            </div>

            <form action="<?php echo e(route('login')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                
                <!-- Email Field -->
                <?php if($errors->has('email')): ?>
                    <div class="error-message"><?php echo e($errors->first('email')); ?></div>
                <?php endif; ?>
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
                        value="<?php echo e(old('email')); ?>"
                    >
                </div>

                <!-- Password Field -->
                <?php if($errors->has('password')): ?>
                    <div class="error-message"><?php echo e($errors->first('password')); ?></div>
                <?php endif; ?>
                <div class="input-container">
                    <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <input 
                        id="password-input"
                        type="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Password"
                        required
                    >
                    <button type="button" class="toggle-visibility" aria-label="Tampilkan password" onclick="(function(btn){var i=document.getElementById('password-input');if(i.type==='password'){i.type='text';btn.setAttribute('aria-label','Sembunyikan password');}else{i.type='password';btn.setAttribute('aria-label','Tampilkan password');}})(this)">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    </button>
                </div>

                <!-- CAPTCHA Field -->
                <div class="input-container">
                    <div class="captcha-container">
                        <img id="captcha-image" src="<?php echo e(captcha_src('flat')); ?>" alt="Captcha" style="cursor: pointer;" data-captcha-url="<?php echo e(captcha_src('flat')); ?>">
                    </div>
                    <input 
                        type="text" 
                        name="captcha" 
                        class="form-input" 
                        placeholder="Masukkan Captcha"
                        required
                    >
                    <?php if($errors->has('captcha')): ?>
                        <div class="error-message"><?php echo e($errors->first('captcha')); ?></div>
                    <?php endif; ?>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="form-options">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember">
                        <span>Ingat Saya</span>
                    </label>
                    <a href="#" class="forgot-link">Lupa Password?</a>
                </div>

                <!-- Login Button -->
                <button type="submit" class="login-btn">
                    Masuk
                </button>
            </form>

            <!-- Footer Links -->
            <div class="form-footer">
                <p>
                    Belum punya akun? 
                    <a href="<?php echo e(route('register')); ?>">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </div>

    <script>
        // Setup CSRF token for AJAX requests
        window.Laravel = {
            csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
        };
        
        // Update CSRF token in all forms when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (csrfToken) {
                const csrfInputs = document.querySelectorAll('input[name="_token"]');
                csrfInputs.forEach(input => {
                    input.value = csrfToken;
                });
            }
            
            // Ensure form has valid CSRF token before submit
            const loginForm = document.querySelector('form[action*="login"]');
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    const formToken = this.querySelector('input[name="_token"]');
                    const metaToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    
                    if (formToken && metaToken && formToken.value !== metaToken) {
                        formToken.value = metaToken;
                    }
                });
            }
        });

        // CAPTCHA refresh handler
        (function() {
            var captchaImage = document.getElementById('captcha-image');
            if (captchaImage) {
                var captchaBaseUrl = captchaImage.getAttribute('data-captcha-url');
                captchaImage.addEventListener('click', function() {
                    this.src = captchaBaseUrl + '?' + Math.random();
                });
                captchaImage.addEventListener('error', function() {
                    this.onerror = null;
                    this.src = captchaBaseUrl + '?' + Math.random();
                });
            }
        })();
    </script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/auth/login.blade.php ENDPATH**/ ?>