<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('auth/register.title') }}</title>
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

    <div class="flex min-h-screen">

        <!-- Kiri: Ilustrasi -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-white dark:bg-gray-800 items-center justify-center overflow-hidden">

            <!-- Background Soft Shape -->
            <div class="absolute w-[500px] h-[500px] bg-blue-100 dark:bg-blue-900/20 rounded-full blur-3xl opacity-50"></div>

            <!-- Ilustrasi -->
            <img src="{{ asset('images/ill_loginregis.svg') }}"
                alt="Ilustrasi"
                class="relative z-10 w-[70%] h-auto">
        </div>
        
        <!-- Kanan: Form Register -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white dark:bg-gray-800 transition-colors duration-300">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight">{{ __('auth/register.label') }}</h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">{{ __('auth/register.sub-label') }}</p>
                </div>

                <!-- Global Alert -->
                @if (session('status'))
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-600 dark:text-green-400 px-4 py-3 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
                @endif
                @if (session('error'))
                <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 px-4 py-3 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="mt-8 space-y-6">
                    @csrf

                    <!-- Nama -->
                    <div class="space-y-1">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('auth/register.name') }}</label>
                        <input type="text" name="name" id="name"
                            class="block w-full px-4 py-3 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('name') border-red-500 ring-red-200 dark:ring-red-900 @enderror"
                            placeholder="{{ __('auth/register.name_placeholder') }}" required>
                        @error('name')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('auth/register.email') }}</label>
                        <input type="email" name="email" id="email"
                            class="block w-full px-4 py-3 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('email') border-red-500 ring-red-200 dark:ring-red-900 @enderror"
                            placeholder="{{ __('auth/register.email_placeholder') }}" required>
                        @error('email')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-1">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('auth/register.password') }}</label>
                        <input type="password" name="password" id="password"
                            class="block w-full px-4 py-3 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('password') border-red-500 ring-red-200 dark:ring-red-900 @enderror"
                            placeholder="{{ __('auth/register.password_placeholder') }}" required>
                        @error('password')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="space-y-1">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('auth/register.password_confirmation') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="block w-full px-4 py-3 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            placeholder="{{ __('auth/register.password_confirmation_placeholder') }}" required>
                    </div>

                    <!-- Role -->
                    <div class="space-y-1">
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('auth/register.role') }}</label>
                        <select name="role" id="role"
                            class="block w-full px-4 py-3 rounded-lg bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('role') border-red-500 ring-red-200 dark:ring-red-900 @enderror"
                            required>
                            <option value="">{{ __('auth/register.role_placeholder') }}</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>{{ __('auth/register.admin') }}</option>
                            <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>{{ __('auth/register.employee') }}</option>
                        </select>
                        @error('role')
                        <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Daftar -->
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:focus:ring-offset-gray-800 transition duration-200 transform hover:-translate-y-0.5">
                        {{ __('auth/register.button') }}
                    </button>

                    <!-- Link Login -->
                    <p class="text-center text-sm text-gray-600 dark:text-gray-400 mt-4">
                        {{ __('auth/register.have_account') }}
                        <a href="{{ Route::has('login') ? route('login') : '#' }}" class="font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300 transition">{{ __('auth/register.login') }}</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>

</html>