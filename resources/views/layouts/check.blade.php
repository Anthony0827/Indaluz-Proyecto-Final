{{-- resources/views/layouts/check.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Título de la página dinámico según la sección --}}
    <title>Indaluz - @yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Carga de estilos y scripts con Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- Icono de la pestaña del navegador --}}
    <link rel="icon" href="{{ asset('images/logo-indaluz.png') }}" type="image/png" sizes="64x64">

    {{-- Lucide Icons para iconografía --}}
    <script src="https://unpkg.com/lucide@latest" defer></script>
    @stack('styles')
</head>
<body class="bg-gray-50">
    {{-- Cabecera simplificada para el proceso de checkout --}}
    <header class="bg-white shadow-sm">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            {{-- Logo y nombre de la tienda con enlace a inicio --}}
            <a href="{{ route('cliente.home') }}" class="flex items-center">
                <img src="{{ asset('images/logo-indaluz.png') }}" alt="Indaluz" class="h-8 w-auto">
                <span class="ml-2 text-lg font-bold text-green-700">Indaluz</span>
            </a>
            {{-- Indicador de pasos del checkout (Envío, Pago, Confirmación) --}}
            
        </div>
    </header>
    {{-- Pie de página simplificado --}}
    <footer class="bg-white border-t py-4 mt-8">
        <div class="container mx-auto px-4 text-center text-sm text-gray-500">
            © {{ date('Y') }} Indaluz. Todos los derechos reservados.
        </div>
    </footer>

    {{-- Zona principal donde se inserta el contenido de la vista --}}
    <main class="min-h-screen container mx-auto px-4 py-8">
        @yield('content')
    </main>

    

    {{-- Inicialización de iconos de Lucide tras carga del DOM --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') lucide.createIcons();
        });
    </script>

    @stack('scripts')
</body>
</html>
