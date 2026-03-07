<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-background text-foreground">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 border-r bg-card hidden md:block">
            <div class="p-6">
                <h1 class="text-2xl font-bold tracking-tight">WorkForce</h1>
            </div>
            <nav class="space-y-1 px-4">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('dashboard') ? 'bg-accent' : '' }}">
                    Dashboard
                </a>
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('employees.index') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('employees.*') ? 'bg-accent' : '' }}">
                        Employees
                    </a>
                    <a href="{{ route('attendance.report') }}" class="flex items-center px-4 py-2 text-sm font-medium rounded-md hover:bg-accent hover:text-accent-foreground {{ request()->routeIs('attendance.report') ? 'bg-accent' : '' }}">
                        Attendance Report
                    </a>
                @endif
            </nav>
            <div class="absolute bottom-0 w-64 p-4 border-t">
                <div class="flex items-center gap-2 mb-4">
                    <div class="h-8 w-8 rounded-full bg-primary text-primary-foreground flex items-center justify-center">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-muted-foreground capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-ui.button variant="outline" class="w-full">Logout</x-ui.button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>
    </div>
</body>
</html>