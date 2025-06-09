{{-- resources/views/layouts/agricultor.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Indaluz Agricultor - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Estilos -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" href="{{ asset('images/logo-indaluz.png') }}" type="image/png" sizes="64x64">

    <!-- Alpine.js para interactividad -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest" defer></script>

    @stack('styles')
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div x-data="{ open: false }" class="flex">
            <!-- Sidebar para escritorio -->
            <div class="hidden lg:flex lg:flex-shrink-0">
                <div class="flex flex-col w-64 bg-green-800">
                    <!-- Logo -->
                    <div class="flex items-center justify-center h-16 bg-green-900">
                        <a href="{{ route('agricultor.dashboard') }}" class="flex items-center gap-2">
                            <img src="{{ asset('images/logo-indaluz.png') }}" alt="Indaluz" class="h-10 w-auto">
                            <span class="text-white font-bold text-xl">Indaluz</span>
                        </a>
                    </div>

                    <!-- Navegación -->
                    <nav class="flex-1 px-2 py-4 bg-green-800 space-y-1">
                        <a href="{{ route('agricultor.dashboard') }}" 
                           class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-md text-white hover:bg-green-700 transition
                           {{ request()->routeIs('agricultor.dashboard') ? 'bg-green-700' : '' }}">
                            <i data-lucide="home" class="w-5 h-5"></i>
                            <span>Dashboard</span>
                        </a>

                        <a href="{{ route('agricultor.productos.index') }}" 
                           class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-md text-white hover:bg-green-700 transition
                           {{ request()->routeIs('agricultor.productos.*') ? 'bg-green-700' : '' }}">
                            <i data-lucide="package" class="w-5 h-5"></i>
                            <span>Mis Productos</span>
                        </a>

                        <a href="{{ route('agricultor.pedidos.index') }}" 
                           class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-md text-white hover:bg-green-700 transition
                           {{ request()->routeIs('agricultor.pedidos.*') ? 'bg-green-700' : '' }}">
                            <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                            <span>Pedidos</span>
                        </a>

                        <a href="{{ route('agricultor.ventas.index') }}" 
                           class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-md text-white hover:bg-green-700 transition
                           {{ request()->routeIs('agricultor.ventas.*') ? 'bg-green-700' : '' }}">
                            <i data-lucide="trending-up" class="w-5 h-5"></i>
                            <span>Ventas</span>
                        </a>

                        <a href="{{ route('agricultor.resenas.index') }}"
                            class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-md text-white hover:bg-green-700 transition {{ request()->routeIs('agricultor.resenas.*') ? 'bg-green-700' : '' }}">
                                <i data-lucide="star" class="w-5 h-5"></i>
                                <span>Reseñas</span>
                            </a>


                        <a href="{{ route('agricultor.perfil.index') }}" 
                           class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-md text-white hover:bg-green-700 transition
                           {{ request()->routeIs('agricultor.perfil.*') ? 'bg-green-700' : '' }}">
                            <i data-lucide="user" class="w-5 h-5"></i>
                            <span>Mi Perfil</span>
                        </a>
                    </nav>

                    <!-- Cerrar sesión -->
                    <div class="flex-shrink-0 flex bg-green-900 p-4">
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-md text-white hover:bg-green-800 transition w-full">
                                <i data-lucide="log-out" class="w-5 h-5"></i>
                                <span>Cerrar Sesión</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar móvil -->
            <div x-show="open" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="-translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-300"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="-translate-x-full"
                 class="lg:hidden fixed inset-0 z-40 flex">
                <div class="relative flex-1 flex flex-col max-w-xs w-full bg-green-800">
                    <!-- Logo móvil -->
                    <div class="flex items-center justify-between h-16 bg-green-900 px-4">
                        <a href="{{ route('agricultor.dashboard') }}" class="flex items-center gap-2">
                            <img src="{{ asset('images/logo-indaluz.png') }}" alt="Indaluz" class="h-10 w-auto">
                            <span class="text-white font-bold text-xl">Indaluz</span>
                        </a>
                        <button @click="open = false" class="text-white">
                            <i data-lucide="x" class="w-6 h-6"></i>
                        </button>
                    </div>

                    <!-- Navegación móvil (mismo contenido que escritorio) -->
                    <nav class="flex-1 px-2 py-4 bg-green-800 space-y-1">
                        <!-- Copiar los mismos enlaces de navegación aquí -->
                        <a href="{{ route('agricultor.dashboard') }}" 
                           class="flex items-center gap-3 px-4 py-2 text-sm font-medium rounded-md text-white hover:bg-green-700 transition">
                            <i data-lucide="home" class="w-5 h-5"></i>
                            <span>Dashboard</span>
                        </a>
                        <!-- ... resto de enlaces ... -->
                    </nav>
                </div>

                <!-- Overlay -->
                <div @click="open = false" class="flex-shrink-0 w-14 bg-black bg-opacity-50"></div>
            </div>
        </div>

        <!-- Contenido principal -->
        <div class="flex-1 flex flex-col">
            <!-- Header superior -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-4 py-3">
                    <!-- Botón menú móvil -->
                    <button @click="open = true" class="lg:hidden text-gray-500 hover:text-gray-700">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>

                    <!-- Título de la página -->
                    <h1 class="text-xl font-semibold text-gray-800">
                        @yield('header', 'Panel de Agricultor')
                    </h1>

                    <!-- Info del usuario -->
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-600">
                            {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
                        </span>
                        <div class="h-8 w-8 rounded-full bg-green-600 flex items-center justify-center text-white font-semibold">
                            {{ substr(Auth::user()->nombre, 0, 1) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Contenido de la página -->
            <main class="flex-1 p-6">
                {{-- Mensajes de éxito/error --}}
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 px-6 py-4">
                <p class="text-sm text-gray-600 text-center">
                    © {{ date('Y') }} Indaluz - Panel de Agricultor
                </p>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Inicializar iconos Lucide
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });

        // Re-inicializar iconos después de cambios en el DOM
        document.addEventListener('alpine:init', () => {
            Alpine.data('reinitIcons', () => ({
                init() {
                    this.$nextTick(() => {
                        if (typeof lucide !== 'undefined') {
                            lucide.createIcons();
                        }
                    });
                }
            }));
        });
    </script>

    @stack('scripts')
</body>
</html>