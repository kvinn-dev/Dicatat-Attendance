@extends('layouts.app')

@section('content')
<div class="mb-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-3">
        <a href="{{ route('settings.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Pengaturan</a>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-900 dark:text-gray-100 font-medium">Sistem</span>
    </div>
    
    <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Pengaturan Sistem</h2>
</div>

<div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-xl p-6 max-w-2xl">
    
    <!-- Alert Success -->
    @if(session('success'))
    <div class="mb-6 rounded-lg bg-green-50 dark:bg-green-900/30 p-4 text-sm text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800 flex items-center">
        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('settings.system_setting.update') }}" method="POST" class="space-y-6">
        @csrf
        
        <!-- Pilihan Bahasa -->
        <div>
            <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bahasa (Language)</label>
            <select id="language" name="language" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2.5 transition-colors">
                <option value="id">Bahasa Indonesia</option>
                <option value="en">English</option>
            </select>
        </div>

        <!-- Pilihan Tema -->
        <div>
            <label for="theme" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tema Tampilan (Theme)</label>
            <select id="theme" name="theme" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2.5 transition-colors">
                <option value="light">Mode Terang (Light)</option>
                <option value="dark">Mode Gelap (Dark)</option>
                <option value="system">Ikuti Sistem (System Default)</option>
            </select>
            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">Pilih tema antarmuka aplikasi. Jika memilih "Ikuti Sistem", tampilan akan menyesuaikan pengaturan perangkat Anda.</p>
        </div>

        <div class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-end">
            <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-indigo-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
@endsection
