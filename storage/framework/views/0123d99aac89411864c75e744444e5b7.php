<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f0f4f8;
        }
    </style>
</head>
<body class="antialiased flex items-center justify-center min-h-screen p-4 lg:p-12">
    <div class="flex flex-col lg:flex-row w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden">
        <!-- Left Panel (Greeting) -->
        <div class="hidden lg:flex lg:w-1/2 p-8 lg:p-12 items-center justify-center text-center bg-gradient-to-br from-purple-700 to-indigo-800 rounded-l-3xl relative">
            <div class="z-10 text-white">
                <h2 class="text-4xl lg:text-5xl font-extrabold mb-4">Welcome Back!</h2>
                <p class="text-lg mb-8 opacity-90">
                    To keep connected with us, please sign in with your personal details.
                </p>
                
                <!-- Sign In Button -->
                <a href="<?php echo e(route('login')); ?>" class="inline-block px-12 py-3 border-2 border-white rounded-full font-bold text-white hover:bg-white hover:text-purple-700 transition-all duration-300 transform hover:scale-105 shadow-md">
                    SIGN IN
                </a>
            </div>
        </div>

        <!-- Right Panel (Registration Form) -->
        <div class="w-full lg:w-1/2 p-8 lg:p-10 flex items-center justify-center">
            <div class="w-full max-w-sm">
                <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 mb-2 text-center lg:text-left">
                    Create Account
                </h2>
                <p class="text-gray-500 text-center lg:text-left text-xs md:text-sm mb-4">
                    Enter your personal details to start your journey with us.
                </p>

                <!-- Registration Form -->
                <form action="#" method="POST" class="space-y-3">
                    <!-- Name -->
                    <div>
                        <input 
                            id="name" 
                            class="w-full px-4 py-2 bg-gray-100 border-2 border-transparent rounded-lg text-gray-700 placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-purple-600 transition-all duration-300" 
                            type="text" 
                            name="name" 
                            placeholder="Name"
                            required 
                        />
                    </div>
                    
                    <!-- Email Address -->
                    <div>
                        <input 
                            id="email" 
                            class="w-full px-4 py-2 bg-gray-100 border-2 border-transparent rounded-lg text-gray-700 placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-purple-600 transition-all duration-300" 
                            type="email" 
                            name="email" 
                            placeholder="Email"
                            required 
                        />
                    </div>

                    <!-- Password -->
                    <div>
                        <input 
                            id="password" 
                            class="w-full px-4 py-2 bg-gray-100 border-2 border-transparent rounded-lg text-gray-700 placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-purple-600 transition-all duration-300"
                            type="password"
                            name="password"
                            placeholder="Password"
                            required 
                        />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <input 
                            id="password_confirmation" 
                            class="w-full px-4 py-2 bg-gray-100 border-2 border-transparent rounded-lg text-gray-700 placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-purple-600 transition-all duration-300"
                            type="password"
                            name="password_confirmation" 
                            placeholder="Confirm Password"
                            required 
                        />
                    </div>

                    <!-- Role -->
                    <div>
                        <select name="role" id="role" class="w-full px-4 py-2 bg-gray-100 border-2 border-transparent rounded-lg text-gray-700 text-sm focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-purple-600 transition-all duration-300">
                            <option value="" disabled selected class="text-gray-400">Select Role</option>
                            <option value="pd_teknis">Staff PD Teknis</option>
                            <option value="dpmtsp">Staff DPMTSP</option>
                            <option value="penerbitan_berkas">Staff Penerbitan Berkas</option>
                        </select>
                    </div>

                    <!-- Sign Up Button -->
                    <div>
                        <button type="submit" class="w-full py-2.5 px-6 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-lg shadow-md hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105">
                            SIGN UP
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/auth/register.blade.php ENDPATH**/ ?>