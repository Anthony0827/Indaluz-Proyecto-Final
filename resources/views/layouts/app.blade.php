<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indaluz - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/logo-indaluz.png') }}" type="image/png" sizes="64x64">

    <!-- Iconos Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
        <!-- Alpine.js (para el menú móvil) -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest" defer></script>

</head>
<body class="bg-gray-50 text-gray-900">

    <!-- Header -->
<header x-data="{ open: false }" class="bg-green-600 text-white shadow">
    <div class="container mx-auto flex items-center justify-between py-4 px-6">
        <!-- Logo + Nombre -->
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo-indaluz.png') }}" alt="Indaluz" class="h-14 w-auto">
            <span class="hidden sm:inline text-2xl font-bold">Indaluz</span>
        </a>

        <!-- NAV Escritorio -->
        <nav class="hidden md:flex items-center space-x-6">
            <a href="#" class="hover:text-green-200">Inicio</a>
            <a href="#" class="hover:text-green-200">Tienda</a>
            <a href="#" class="hover:text-green-200">Nosotros</a>
            <a href="#" class="hover:text-green-200">Sostenibilidad</a>
            <a href="#" class="hover:text-green-200">Agricultores</a>
            <a href="#" class="hover:text-green-200">Contacto</a>
            <!-- Iconos en escritorio -->
            <button class="p-2 hover:text-green-200"><i data-lucide="search"></i></button>
            <button class="p-2 hover:text-green-200"><i data-lucide="shopping-cart"></i></button>
        </nav>

        <!-- Iconos + Hamburguesa Móvil -->
        <div class="flex md:hidden items-center space-x-4">
            <button class="p-2 hover:text-green-200"><i data-lucide="search"></i></button>
            <button class="p-2 hover:text-green-200"><i data-lucide="shopping-cart"></i></button>
            <button @click="open = !open" class="p-2 hover:text-green-200">
                <i data-lucide="menu"></i>
            </button>
        </div>
    </div>

    <!-- Menú Móvil -->
    <div x-show="open"
         x-cloak
         @click.away="open = false"
         class="md:hidden bg-green-600 text-white">
        <nav class="flex flex-col space-y-2 p-4">
            <a href="#" class="hover:text-green-200">Inicio</a>
            <a href="#" class="hover:text-green-200">Tienda</a>
            <a href="#" class="hover:text-green-200">Nosotros</a>
            <a href="#" class="hover:text-green-200">Sostenibilidad</a>
            <a href="#" class="hover:text-green-200">Agricultores</a>
            <a href="#" class="hover:text-green-200">Contacto</a>
        </nav>
    </div>

    <!-- Renderiza los iconos Lucide -->
    <script>lucide.createIcons()</script>
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
