<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Attendance System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50">
    <div class="flex min-h-screen">

        <!-- Kiri: Branding -->
        <div class="hidden lg:flex lg:w-1/2 relative bg-blue-900 items-center justify-center overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-blue-900 opacity-90 z-10"></div>
            <img src="https://images.unsplash.com/photo-1497215728101-856f4ea42174?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80" alt="Office" class="absolute inset-0 w-full h-full object-cover">
            <div class="relative z-20 text-white p-12 text-center">
                <h2 class="text-4xl font-bold mb-4 tracking-tight">WorkForce System</h2>
                <p class="text-blue-100 text-lg max-w-md mx-auto">
                    Kelola kehadiran karyawan, pantau produktivitas, dan akses laporan secara real-time dalam satu platform terintegrasi.
                </p>
            </div>
        </div>

        <!-- Kanan: Form Register -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Daftar Akun</h1>
                    <p class="mt-2 text-sm text-gray-600">Buat akun baru untuk mengakses sistem</p>
                </div>

                <!-- Global Alert -->
                @if (session('status'))
                    <div class="bg-green-50 border border-green-200 text-green-600 px-4 py-3 rounded-lg text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <form action="{{ route('register') }}" method="POST" class="mt-8 space-y-6">
                    @csrf

                    <!-- Nama -->
                    <div class="space-y-1">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" id="name"
                            class="block w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('name') border-red-500 ring-red-200 @enderror"
                            placeholder="Nama lengkap Anda" value="{{ old('name') }}" required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-1">
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                            class="block w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('email') border-red-500 ring-red-200 @enderror"
                            placeholder="nama@perusahaan.com" value="{{ old('email') }}" required>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="space-y-1">
                        <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" id="password"
                            class="block w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('password') border-red-500 ring-red-200 @enderror"
                            placeholder="••••••••" required>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="space-y-1">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="block w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                            placeholder="••••••••" required>
                    </div>

                    <!-- Role -->
                    <div class="space-y-1">
                        <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" id="role"
                            class="block w-full px-4 py-3 rounded-lg border border-gray-300 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200 @error('role') border-red-500 ring-red-200 @enderror"
                            required>
                            <option value="">-- Pilih Role --</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Karyawan</option>
                        </select>
                        @error('role')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tombol Daftar -->
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 transform hover:-translate-y-0.5">
                        Daftar Akun
                    </button>

                    <!-- Link Login -->
                    <p class="text-center text-sm text-gray-600 mt-4">
                        Sudah punya akun? 
                        <a href="{{ Route::has('login') ? route('login') : '#' }}" class="font-medium text-blue-600 hover:text-blue-500 transition">Masuk</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>