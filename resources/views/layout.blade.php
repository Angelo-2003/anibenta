<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AniBenta Marketplace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navigation Bar -->
    <nav class="bg-green-600 p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-white font-bold text-2xl tracking-tight">
                AniBenta <span class="text-green-200 text-sm">Wholesale</span>
            </a>
            <a href="{{ route('dashboard.index') }}" class="text-white font-semibold hover:text-green-200 bg-green-700 px-4 py-2 rounded">
                Proxy Dashboard
            </a>
        </div>
    </nav>

    <!-- Main Content Area -->
    <main class="container mx-auto p-4 mt-6">
        @yield('content')
    </main>
</body>
</html>