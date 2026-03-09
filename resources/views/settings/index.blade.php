@extends('layouts.app')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Pengaturan</h2>
</div>

<div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
    <!-- Profile Settings -->
    <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="p-3 bg-indigo-50 dark:bg-indigo-900/50 rounded-lg text-indigo-600 dark:text-indigo-400">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pengaturan Profil</h3>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Perbarui informasi pribadi dan kata sandi Anda.</p>
        <a href="{{ route('profile.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">Kelola Profil &rarr;</a>
    </div>

    <!-- System Settings -->
    <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="p-3 bg-blue-50 dark:bg-blue-900/50 rounded-lg text-blue-600 dark:text-blue-400">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Pengaturan Sistem</h3>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Konfigurasikan preferensi dan pengaturan default aplikasi.</p>
        <button class="text-sm font-medium text-gray-400 cursor-not-allowed">Coming Soon</button>
    </div>

    <!-- Notification Settings -->
    <div class="rounded-xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 p-6">
        <div class="flex items-center gap-4 mb-4">
            <div class="p-3 bg-yellow-50 dark:bg-yellow-900/50 rounded-lg text-yellow-600 dark:text-yellow-400">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Notifikasi</h3>
        </div>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Kelola peringatan email dan notifikasi push.</p>
        <button class="text-sm font-medium text-gray-400 cursor-not-allowed">Coming Soon</button>
    </div>
</div>
@endsection
