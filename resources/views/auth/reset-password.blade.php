<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('auth/reset-password.title') }}</title>
    <link rel="icon" type="image/svg" href="{{ asset('favicon.svg') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    <script>
        const savedTheme = localStorage.getItem('theme') || 'system';
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (savedTheme === 'dark' || (savedTheme === 'system' && systemPrefersDark)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <!-- Language Switcher -->
    <div class="absolute top-4 right-4 z-50 flex items-center bg-white dark:bg-gray-800 rounded-full shadow-sm px-3 py-1.5 border border-gray-200 dark:border-gray-700">
        <a href="{{ route('switch-language', 'id') }}" class="text-xs font-semibold tracking-wide transition-colors duration-200 {{ app()->getLocale() == 'id' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">ID</a>
        <span class="text-gray-300 dark:text-gray-600 mx-2">|</span>
        <a href="{{ route('switch-language', 'en') }}" class="text-xs font-semibold tracking-wide transition-colors duration-200 {{ app()->getLocale() == 'en' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300' }}">EN</a>
    </div>

    <div class="flex min-h-screen flex-col lg:flex-row">

        <!-- Kiri: Ilustrasi -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-white dark:bg-gray-800 items-center justify-center overflow-hidden">
            <div class="absolute w-[500px] h-[500px] bg-blue-100 dark:bg-blue-900/20 rounded-full blur-3xl opacity-50"></div>
            <img src="{{ asset('images/ill_loginregis.svg') }}" alt="Ilustrasi" class="relative z-10 w-[70%] h-auto">
        </div>

        <!-- Kanan: Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-10 bg-white dark:bg-gray-800 transition-colors duration-300">
            <div class="w-full max-w-md space-y-6">

                <!-- Header -->
                <div class="text-center">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                        {{ __('auth/reset-password.label') }}
                    </h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        {{ __('auth/reset-password.description') }}
                    </p>
                </div>

                <!-- Alert Error -->
                @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 px-4 py-3 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Form -->
                <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                    @csrf
                    
                    <!-- Token Reset Password -->
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email -->
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('auth/reset-password.email_label') }}</label>
                        <input type="email" name="email" value="{{ $request->email ?? old('email') }}" required readonly
                            class="mt-1 w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-400 border border-gray-300 dark:border-gray-600 focus:outline-none cursor-not-allowed">
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('auth/reset-password.password_label') }}</label>
                        <input type="password" name="password" required
                            class="mt-1 w-full px-4 py-3 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>
                    
                    <!-- Konfirmasi Password -->
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('auth/reset-password.password_confirmation_label') }}</label>
                        <input type="password" name="password_confirmation" required
                            class="mt-1 w-full px-4 py-3 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none">
                    </div>

                    <!-- Button -->
                    <button type="submit" class="w-full py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition shadow-sm">
                        {{ __('auth/reset-password.submit_button') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>