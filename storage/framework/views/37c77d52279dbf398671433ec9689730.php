<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
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
<body class="antialiased">
    <div class="min-h-screen flex items-center justify-center p-4 lg:p-12">
        <div class="flex flex-col lg:flex-row w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden">
            <!-- Left Panel (Login Form) -->
            <div class="w-full lg:w-1/2 p-8 lg:p-16 flex items-center justify-center">
                <div class="w-full max-w-sm">
                    <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-4 text-center lg:text-left">
                        Sign In
                    </h2>
                    <p class="text-gray-500 text-center lg:text-left mb-8">
                        Welcome back! Please enter your details.
                    </p>

                    <!-- Login Form -->
                    <form action="<?php echo e(route('login')); ?>" method="POST" class="space-y-6">
                        <?php echo csrf_field(); ?>
                        <!-- Email Address -->
                        <div>
                            <input 
                                id="email" 
                                class="w-full px-5 py-3 bg-gray-100 border-2 border-transparent rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-purple-600 transition-all duration-300" 
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
                                class="w-full px-5 py-3 bg-gray-100 border-2 border-transparent rounded-xl text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-600 focus:border-purple-600 transition-all duration-300"
                                type="password"
                                name="password"
                                placeholder="Password"
                                required 
                            />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between text-sm">
                            <label for="remember_me" class="flex items-center text-gray-600 hover:text-gray-800 transition-colors cursor-pointer">
                                <input 
                                    id="remember_me" 
                                    type="checkbox" 
                                    class="rounded-md text-purple-600 focus:ring-purple-600 border-gray-300" 
                                    name="remember"
                                >
                                <span class="ml-2 font-medium">Remember me</span>
                            </label>

                            <a href="#" class="text-purple-600 hover:text-purple-800 font-medium transition-colors">
                                Forgot password?
                            </a>
                        </div>

                        <!-- Sign In Button -->
                        <div>
                            <button type="submit" class="w-full py-3 px-6 bg-gradient-to-r from-purple-600 to-indigo-600 text-white font-bold rounded-xl shadow-lg hover:from-purple-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105">
                                SIGN IN
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Panel (Greeting) -->
            <div class="hidden lg:flex lg:w-1/2 p-8 lg:p-16 items-center justify-center text-center bg-gradient-to-br from-purple-700 to-indigo-800 rounded-r-3xl relative">
                <div class="z-10 text-white">
                    <h2 class="text-4xl lg:text-5xl font-extrabold mb-4">Hello, Friend!</h2>
                    <p class="text-lg mb-8 opacity-90">
                        Enter your personal details to start your journey with us.
                    </p>
                    
                    <!-- Sign Up Button -->
                    <a href="<?php echo e(route('register')); ?>" class="inline-block px-12 py-3 border-2 border-white rounded-full font-bold text-white hover:bg-white hover:text-purple-700 transition-all duration-300 transform hover:scale-105 shadow-md">
                        SIGN UP
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\sistem-perizinan\resources\views/auth/login.blade.php ENDPATH**/ ?>