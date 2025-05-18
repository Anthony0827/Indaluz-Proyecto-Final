<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indaluz - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Iconos Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-gray-50 text-gray-900">

    <!-- Header -->
    <header class="bg-green-600 text-white shadow">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo-indaluz.png') }}" alt="Logo Indaluz" class="h-14 w-auto">
            <span class="text-2xl font-bold">Indaluz</span>
        </a>
            <nav class="flex gap-4">
                <a href="#" class="hover:text-green-200 flex items-center gap-1"><i data-lucide="home"></i>Inicio</a>
                <a href="#" class="hover:text-green-200 flex items-center gap-1"><i data-lucide="leaf"></i>Productos</a>
                <a href="#" class="hover:text-green-200 flex items-center gap-1"><i data-lucide="shopping-cart"></i>Carrito</a>
                <a href="#" class="hover:text-green-200 flex items-center gap-1"><i data-lucide="user"></i>Login</a>
            </nav>
        </div>
    </header>

    <!-- Contenido -->
    <main class="container mx-auto py-8 px-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-green-700 text-white text-center py-4 mt-10">
        © {{ date('Y') }} Indaluz. Plataforma local de productos frescos de Almería.
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
