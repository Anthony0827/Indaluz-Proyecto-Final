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
<header x-data="{ open: false, userMenu: false }" class="relative z-50 bg-green-600 text-white shadow">
    <div class="container mx-auto flex items-center justify-between py-4 px-6">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            <img src="{{ asset('images/logo-indaluz.png') }}" alt="Indaluz" class="h-14 w-auto">
            <span class="hidden sm:inline text-2xl font-bold">Indaluz</span>
        </a>

        <!-- Navegación escritorio -->
        <nav class="hidden md:flex items-center space-x-6">
            <a href="{{ route('home') }}" class="hover:text-green-200 {{ request()->routeIs('home') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Inicio</a>
            <a href="{{ route('nosotros') }}" class="hover:text-green-200 {{ request()->routeIs('nosotros') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Nosotros</a>
            <a href="{{ route('sostenibilidad') }}" class="hover:text-green-200 {{ request()->routeIs('sostenibilidad') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Sostenibilidad</a>
            <a href="{{ route('agricultores') }}" class="hover:text-green-200 {{ request()->routeIs('agricultores') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Agricultores</a>
            <a href="{{ route('contacto') }}" class="hover:text-green-200 {{ request()->routeIs('contacto') ? 'text-green-200 border-b-2 border-green-200' : '' }}">Contacto</a>

            

            <!-- Usuario con dropdown -->
            <div class="relative" @click.away="userMenu = false">
                <button @click="userMenu = !userMenu" class="p-2 hover:text-green-200">
                    <i data-lucide="user"></i>
                </button>
                <div x-show="userMenu" x-cloak
                     class="absolute right-0 mt-2 w-40 bg-white text-gray-800 rounded shadow-lg py-2 z-50">
                    <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-green-50">Login</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 hover:bg-green-50">Register</a>
                </div>
            </div>
        </nav>

        <!-- Iconos + hamburguesa móvil -->
        <div class="flex md:hidden items-center space-x-4">
            <button class="p-2 hover:text-green-200">
                <i data-lucide="search"></i>
            </button>
            <button class="p-2 hover:text-green-200">
                <i data-lucide="shopping-cart"></i>
            </button>

            <!-- Usuario móvil -->
            <div class="relative" @click.away="userMenu = false">
                <button @click="userMenu = !userMenu" class="p-2 hover:text-green-200">
                    <i data-lucide="user"></i>
                </button>
                <div x-show="userMenu" x-cloak
                     class="absolute top-full right-0 mt-2 w-40 bg-white text-gray-800 rounded shadow-lg py-2 z-50">
                    <a href="{{ route('login') }}" class="block px-4 py-2 hover:bg-green-50">Login</a>
                    <a href="{{ route('register') }}" class="block px-4 py-2 hover:bg-green-50">Register</a>
                </div>
            </div>

            <!-- Botón hamburguesa -->
            <button @click="open = !open" class="p-2 hover:text-green-200">
                <i data-lucide="menu"></i>
            </button>
        </div>
    </div>

    <!-- Menú móvil desplegable -->
    <div x-show="open" x-cloak @click.away="open = false"
         class="md:hidden bg-green-600 text-white z-40">
        <nav class="flex flex-col space-y-2 p-4">
            <a href="{{ route('home') }}" class="hover:text-green-200 {{ request()->routeIs('home') ? 'text-green-200 font-semibold' : '' }}">Inicio</a>
            <a href="#" class="hover:text-green-200">Tienda</a>
            <a href="{{ route('nosotros') }}" class="hover:text-green-200 {{ request()->routeIs('nosotros') ? 'text-green-200 font-semibold' : '' }}">Nosotros</a>
            <a href="{{ route('sostenibilidad') }}" class="hover:text-green-200 {{ request()->routeIs('sostenibilidad') ? 'text-green-200 font-semibold' : '' }}">Sostenibilidad</a>
            <a href="{{ route('agricultores') }}" class="hover:text-green-200 {{ request()->routeIs('agricultores') ? 'text-green-200 font-semibold' : '' }}">Agricultores</a>
            <a href="{{ route('contacto') }}" class="hover:text-green-200 {{ request()->routeIs('contacto') ? 'text-green-200 font-semibold' : '' }}">Contacto</a>
        </nav>
    </div>

    <!-- Inicia los iconos de Lucide -->
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