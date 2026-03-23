<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{
          sidebarOpen: false,
          theme: localStorage.getItem('theme') || 'system',
          initTheme() {
              const isSystemDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
              if (this.theme === 'dark' || (this.theme === 'system' && isSystemDark)) {
                  document.documentElement.classList.add('dark');
              } else {
                  document.documentElement.classList.remove('dark');
              }
          }
      }"
    x-init="initTheme(); window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => { if (theme === 'system') initTheme(); });"
    @theme-changed.window="theme = $event.detail; initTheme()">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dicatat | Pemantau Presensimu</title>
    <link rel="icon" type="image/svg" href="{{ asset('favicon.svg') }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <script>
        // Mencegah FOUC (layar berkedip) saat memuat tema gelap
        const savedTheme = localStorage.getItem('theme') || 'system';
        const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        if (savedTheme === 'dark' || (savedTheme === 'system' && systemPrefersDark)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-900 dark:bg-gray-900 dark:text-gray-100 transition-colors duration-300">
    <div class="flex h-screen overflow-hidden">

        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 z-40 bg-gray-900/80 backdrop-blur-sm lg:hidden" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 shadow-lg lg:shadow-none">
            <!-- Logo -->
            <div class="flex items-center px-6 h-16 border-b border-gray-200 dark:border-gray-700">
                <img src="{{ asset('images/logo_dicatat.svg') }}" alt="Dicatat Logo" class="ml-5 h-7 w-auto">
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-1 overflow-y-auto h-[calc(100vh-4rem)]">
                @php
                $user = auth()->user();
                $navSections = [];

                // Icons
                $iconDashboard = '
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />';
                $iconAttendance = '
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />';
                $iconEmployee = '
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />';
                $iconLeave = '
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />';
                $iconReport = '
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />';
                $iconSettings = '
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';

                if ($user->role === 'admin') {
                $navSections['Main Menu'] = [
                ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => $iconDashboard],
                ['name' => 'Laporan Absensi', 'route' => 'attendances.index', 'icon' => $iconAttendance],
                ['name' => 'Data Karyawan', 'route' => 'employees.index', 'icon' => $iconEmployee],
                ['name' => 'Pengajuan Cuti', 'route' => 'leave.index', 'icon' => $iconLeave],
                ];
                } else {
                // Employee
                $navSections['Main Menu'] = [
                ['name' => 'Dashboard', 'route' => 'dashboard', 'icon' => $iconDashboard],
                ['name' => 'Pengajuan Cuti', 'route' => 'leave.index', 'icon' => $iconLeave],
                ['name' => 'Laporan Analisis', 'route' => 'reports.index', 'icon' => $iconReport],
                ];
                }

                $navSections['System'] = [
                ['name' => 'Pengaturan', 'route' => 'settings.index', 'icon' => $iconSettings],
                ];
                @endphp

                @foreach($navSections as $section => $items)
                @if($section === 'System')
                <div class="my-3 mx-4 border-t border-gray-200 dark:border-gray-700"></div>
                @endif

                @foreach($items as $item)
                @if(Route::has($item['route']))
                <a href="{{ route($item['route']) }}"
                    class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors duration-150 group
                            {{ request()->routeIs($item['route'].'*') 
                                ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-900/50 dark:text-indigo-400' 
                                : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700/50 dark:hover:text-gray-100' 
                            }}">
                    <svg class="w-5 h-5 mr-3 {{ request()->routeIs($item['route'].'*') ? 'text-indigo-600 dark:text-indigo-400' : 'text-gray-400 group-hover:text-gray-500 dark:text-gray-500 dark:group-hover:text-gray-300' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        {!! $item['icon'] !!}
                    </svg>
                    {{ $item['name'] }}
                </a>
                @endif
                @endforeach
                @endforeach
            </nav>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col overflow-hidden">

            <!-- Top Navbar -->
            <header class="flex items-center justify-between h-16 px-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Right Side Actions -->
                <div class="flex items-center ml-auto mr-6 gap-4">
                    <!-- Notifications Dropdown -->
                    @php
                    $userNotifications = \App\Models\Notification::where(function($query) {
                    $query->where('user_id', auth()->id())
                    ->orWhereNull('user_id');
                    })
                    ->orderBy('created_at', 'desc')
                    ->take(5)
                    ->get()
                    ->map(function($notif) {
                    return [
                    'id' => $notif->id,
                    'title' => $notif->title,
                    'description' => $notif->content,
                    'time' => $notif->created_at->diffForHumans(),
                    'read' => !is_null($notif->read_at)
                    ];
                    });
                    @endphp
                    <div x-data="{
                        open: false,
                        notifications: {{ Js::from($userNotifications) }},
                        get unreadCount() {
                            return this.notifications.filter(n => !n.read).length;
                        }
                    }" @click.away="open = false" class="relative">
                        <button @click="open = !open" class="relative p-2 rounded-full text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 focus:outline-none transition-colors">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <!-- Badge -->
                            <span x-show="unreadCount > 0" x-text="unreadCount" x-cloak class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-[10px] font-bold text-white bg-red-500 border-2 border-white rounded-full dark:border-gray-800"></span>
                        </button>

                        <!-- Dropdown Panel -->
                        <div x-show="open" x-cloak
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="transform opacity-0 scale-95"
                            x-transition:enter-end="transform opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="transform opacity-100 scale-100"
                            x-transition:leave-end="transform opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-72 sm:w-80 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50">

                            <div class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200 border-b border-gray-100 dark:border-gray-700">
                                Notifikasi
                            </div>

                            <div class="max-h-60 overflow-y-auto">
                                <template x-for="notification in notifications" :key="notification.id">
                                    <a href="#" class="block px-4 py-3 border-b border-gray-50 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors" :class="{ 'bg-indigo-50/50 dark:bg-indigo-900/20': !notification.read }">
                                        <div class="flex justify-between items-start mb-1">
                                            <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="notification.title"></p>
                                            <span class="text-[10px] text-gray-500 dark:text-gray-400 whitespace-nowrap ml-2" x-text="notification.time"></span>
                                        </div>
                                        <p class="text-xs text-gray-600 dark:text-gray-400 line-clamp-2" x-text="notification.description"></p>
                                    </a>
                                </template>

                                <div x-show="notifications.length === 0" class="px-4 py-4 text-sm text-center text-gray-500 dark:text-gray-400">
                                    Tidak ada notifikasi baru
                                </div>
                            </div>

                            <div class="border-t border-gray-100 dark:border-gray-700 flex divide-x divide-gray-100 dark:divide-gray-700">
                                <form action="{{ route('settings.notification.read_all') }}" method="POST" class="w-1/2">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full h-full block px-4 py-2 text-xs text-center text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200 font-medium transition-colors rounded-bl-md">
                                        Tandai Semua Dibaca
                                    </button>
                                </form>
                                <a href="{{ auth()->user()->role === 'admin' ? route('settings.notification.admin') : route('settings.notification') }}"
                                    class="w-1/2 flex items-center justify-center px-4 py-2 text-xs text-center text-indigo-600 dark:text-indigo-400 hover:bg-gray-50 dark:hover:bg-gray-700/50 hover:text-indigo-800 dark:hover:text-indigo-300 font-medium transition-colors rounded-br-md">
                                    Lihat Semua
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User Dropdown -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                            <div class="h-8 w-8 rounded-full bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-300 flex items-center justify-center font-semibold text-sm">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">{{ auth()->user()->role }}</p>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu -->
                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 z-50" style="display: none;">
                            <a href="{{ route('profile.index') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">Profil Anda</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-gray-100 dark:hover:bg-gray-700">Keluar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900 p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>