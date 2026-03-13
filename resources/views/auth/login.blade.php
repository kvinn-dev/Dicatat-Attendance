<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Dicatat</title>
    <!-- Menggunakan Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Inter untuk tampilan yang lebih modern -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">
        
        <!-- Bagian Kiri: Ilustrasi / Branding (Hanya tampil di Desktop) -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-blue-900 items-center justify-center overflow-hidden">
            <!-- Background Gradient & Pattern -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-900 opacity-90 z-10"></div>
            <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Office" class="absolute inset-0 w-full h-full object-cover">
            
            <!-- Content Branding -->
            <div class="relative z-20 text-white p-12 text-center">
                <h2 class="text-4xl font-bold mb-4 tracking-tight">WorkForce System</h2>
                <p class="text-blue-100 text-lg max-w-md mx-auto">
                    Kelola kehadiran karyawan, pantau produktivitas, dan akses laporan secara real-time dalam satu platform terintegrasi.
                </p>
            </div>
        </div>

        <!-- Bagian Kanan: Form Login -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md space-y-8">
                
                <!-- Header Form -->
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Selamat Datang Kembali</h1>
                    <p class="mt-2 text-sm text-gray-600">Silakan masuk ke akun Anda untuk melanjutkan</p>
                </div>

                <!-- Alert Error Global (Jika ada error yang tidak terikat field) -->
                @if (session('status'))
                    <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="mt-8 space-y-6">
                    @csrf
                    
                    <!-- Input Email -->
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="relative">
                            <input type="email" name="email" id="email" 
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('email') border-red-500 ring-red-200 @enderror"
                                placeholder="Masukkan Email" 
                                value="{{ old('email') }}" 
                                required autofocus>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Input Password -->
                    <div class="space-y-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" 
                                class="block w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('password') border-red-500 ring-red-200 @enderror"
                                placeholder="Masukkan Kata Sandi" 
                                required>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded cursor-pointer">
                            <label for="remember_me" class="ml-2 block text-sm text-gray-600 cursor-pointer">Ingat saya</label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500 transition">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Tombol Login -->
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 transform hover:-translate-y-0.5">
                        Masuk
                    </button>

                    <!-- Link Register -->
                    <p class="text-center text-sm text-gray-600 mt-4">
                        Belum punya akun? 
                        <a href="{{ Route::has('register') ? route('register') : '#' }}" class="font-medium text-blue-600 hover:text-blue-500 transition">Daftar Akun</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>