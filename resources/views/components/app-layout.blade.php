<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Attendance System' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <header class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-xl font-bold">Attendance System</h1>
            <nav>
                <a href="{{ url('/') }}" class="mr-4 hover:underline">Home</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="hover:underline text-white">Logout</button>
                </form>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto p-6">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-gray-200 text-gray-600 p-4 mt-10 text-center">
        &copy; {{ date('Y') }} Attendance System
    </footer>

</body>

</html>