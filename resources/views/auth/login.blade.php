<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Dicatat</title>
    <link rel="icon" type="image/svg" href="{{ asset('favicon.svg') }}">
    <!-- Menggunakan Tailwind CSS via CDN -->
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
    <!-- Font Inter untuk tampilan yang lebih modern -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 transition-colors duration-300">
    <div class="flex min-h-screen flex-col lg:flex-row">

        <!-- Kiri: Ilustrasi -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-white dark:bg-gray-800 items-center justify-center overflow-hidden">

            <!-- Background Soft Shape -->
            <div class="absolute w-[500px] h-[500px] bg-blue-100 dark:bg-blue-900/20 rounded-full blur-3xl opacity-50"></div>

            <!-- Ilustrasi -->
            <img src="{{ asset('images/ill_loginregis.svg') }}"
                alt="Ilustrasi"
                class="relative z-10 w-[70%] h-auto">
        </div>

        <!-- Kanan: Form -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-10 bg-white dark:bg-gray-800 transition-colors duration-300">

            <div class="w-full max-w-md space-y-6">

                <!-- Header -->
                <div class="text-center">
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                        Selamat Datang Kembali
                    </h1>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Silakan masuk ke akun Anda untuk melanjutkan
                    </p>
                </div>

                <!-- Alert -->
                @if (session('status'))
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-600 dark:text-green-400 px-4 py-3 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
                @endif

                <!-- Form -->
                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                        <input type="email" name="email"
                            class="mt-1 w-full px-4 py-3 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-50 placeholder-gray-400 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Masukkan Email">
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="text-sm font-medium text-gray-700 dark:text-gray-300">Kata Sandi</label>
                        <input type="password" name="password"
                            class="mt-1 w-full px-4 py-3 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-50 placeholder-gray-400 border border-gray-300 dark:border-gray-600 focus:ring-2 focus:ring-blue-500 focus:outline-none"
                            placeholder="Masukkan Kata Sandi">
                    </div>

                    <!-- Remember -->
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" class="rounded border-gray-300 text-blue-600">
                            <span class="text-gray-600 dark:text-gray-400">Ingat saya</span>
                        </label>

                        <a href="/forgot-password" class="text-blue-600 hover:underline dark:text-blue-400">
                            Lupa password?
                        </a>
                    </div>

                    <!-- Button -->
                    <button type="submit"
                        class="w-full py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                        Masuk
                    </button>

                    <!-- Register -->
                    <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                        Belum punya akun?
                        <a href="/register" class="text-blue-600 hover:underline dark:text-blue-400">
                            Daftar
                        </a>
                    </p>

                </form>
            </div>
        </div>
    </div>
</body>

</html>