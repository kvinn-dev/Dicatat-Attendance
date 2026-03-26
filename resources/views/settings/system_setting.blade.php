@extends('layouts.app')

@section('content')
<div class="mb-6">
    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 mb-3">
        <a href="{{ route('settings.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">{{ __('settings/system-setting.breadcrumb-before') }}</a>
        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
        </svg>
        <span class="text-gray-900 dark:text-gray-100 font-medium">{{ __('settings/system-setting.breadcrumb-now') }}</span>
    </div>

    <h2 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ __('settings/system-setting.title') }}</h2>
</div>

<div class="bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 rounded-xl p-6 md:p-8 max-w-4xl">

    <!-- Alert Success -->
    @if(session('success'))
    <div class="mb-6 rounded-lg bg-green-50 dark:bg-green-900/30 p-4 text-sm text-green-800 dark:text-green-200 border border-green-200 dark:border-green-800 flex items-center">
        <svg class="mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('settings.system_setting.update') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pilihan Bahasa -->
            <div>
                <label for="language" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('settings/system-setting.general.language.label') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129" />
                        </svg>
                    </div>
                    <select id="language" name="language" class="block w-full pl-10 appearance-none rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2.5 transition-colors">
                        <option value="id" {{ ($settings['language'] ?? 'id') == 'id' ? 'selected' : '' }}>Bahasa Indonesia</option>
                        <option value="en" {{ ($settings['language'] ?? 'id') == 'en' ? 'selected' : '' }}>English</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pilihan Tema -->
            <div>
                <label for="theme" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('settings/system-setting.general.theme.label') }}</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </div>
                    <select id="theme" name="theme" class="block w-full pl-10 appearance-none rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2.5 transition-colors">
                        <option value="light">{{ __('settings/system-setting.general.theme.options.light') }}</option>
                        <option value="dark">{{ __('settings/system-setting.general.theme.options.dark') }}</option>
                        <option value="system">{{ __('settings/system-setting.general.theme.options.system') }}</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->role === 'admin')
        <div class="pt-6 mt-6 border-t border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">{{ __('settings/system-setting.work_schedule.title') }}</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('settings/system-setting.work_schedule.start_time') }}</label>
                    <input type="time" name="work_start_time" value="{{ $settings['work_start_time'] ?? '09:00' }}" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2.5 transition-colors">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('settings/system-setting.work_schedule.end_time') }}</label>
                    <input type="time" name="work_end_time" value="{{ $settings['work_end_time'] ?? '17:00' }}" class="block w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2.5 transition-colors">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">{{ __('settings/system-setting.work_schedule.work_days.label') }}</label>

                @php
                $dayMap = [
                'monday' => 1,
                'tuesday' => 2,
                'wednesday' => 3,
                'thursday' => 4,
                'friday' => 5,
                'saturday' => 6,
                'sunday' => 0,
                ];
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach(['monday','tuesday','wednesday','thursday','friday','saturday','sunday'] as $day)
                    @php $value = $dayMap[$day]; @endphp

                    <label class="relative flex items-center p-3 rounded-xl border border-gray-200 dark:border-gray-700 hover:bg-indigo-50 dark:hover:bg-gray-700/80 cursor-pointer transition-all duration-200 group">

                        <input type="checkbox"
                            name="work_days[]"
                            value="{{ $value }}"
                            {{ in_array($value, $settings['work_days'] ?? []) ? 'checked' : '' }}
                            class="w-4 h-4 text-indigo-600 bg-gray-100 border-gray-300 rounded focus:ring-indigo-500 dark:focus:ring-indigo-600 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 transition">

                        <span class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-indigo-700 dark:group-hover:text-indigo-400 transition-colors">
                            {{ __("settings/system-setting.work_schedule.work_days.options.$day") }}
                        </span>

                    </label>
                    @endforeach
                </div>
                <p class="mt-3 text-xs text-gray-500 dark:text-gray-400">{{ __('settings/system-setting.work_schedule.work_days.description') }}</p>
            </div>
        </div>
        @endif

        <div class="pt-6 mt-2 border-t border-gray-100 dark:border-gray-700 flex justify-end">
            <button type="submit" class="inline-flex items-center justify-center px-5 py-2.5 bg-indigo-600 border border-transparent rounded-lg font-medium text-sm text-white hover:bg-indigo-700 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                {{ __('settings/system-setting.actions.save') }}
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeSelect = document.getElementById('theme');

        // 1. Inisialisasi dropdown dari localStorage saat halaman dimuat
        const currentTheme = localStorage.getItem('theme') || 'system';
        if (themeSelect) {
            themeSelect.value = currentTheme;
        }

        // 2. Tangani perubahan saat user memilih tema dari dropdown
        if (themeSelect) {
            themeSelect.addEventListener('change', function(e) {
                const selectedTheme = e.target.value;
                localStorage.setItem('theme', selectedTheme); // Simpan ke browser

                // Trigger event global agar Alpine.js memperbarui tampilan
                window.dispatchEvent(new CustomEvent('theme-changed', {
                    detail: selectedTheme
                }));
            });
        }
    });
</script>
@endsection