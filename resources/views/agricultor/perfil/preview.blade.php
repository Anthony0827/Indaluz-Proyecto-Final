{{-- resources/views/agricultor/perfil/preview.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $agricultor->nombre_empresa ?? $agricultor->nombre . ' ' . $agricultor->apellido }} - Indaluz</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>
<body class="bg-gray-50">
    {{-- Banner de preview --}}
    <div class="bg-yellow-500 text-center py-2 px-4">
        <p class="text-sm font-medium">
            Vista previa del perfil público - 
            <a href="{{ route('agricultor.perfil.index') }}" class="underline">Volver a editar</a>
        </p>
    </div>

    {{-- Header --}}
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo-indaluz.png') }}" alt="Indaluz" class="h-10 mr-3">
                    <span class="text-xl font-bold text-green-700">Indaluz</span>
                </div>
                <nav class="flex items-center space-x-4">
                    <a href="#" class="text-gray-700 hover:text-green-600">Inicio</a>
                    <a href="#" class="text-gray-700 hover:text-green-600">Productos</a>
                    <a href="#" class="text-gray-700 hover:text-green-600">Agricultores</a>
                </nav>
            </div>
        </div>
    </header>

    {{-- Contenido del perfil --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {{-- Portada y foto de perfil --}}
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            {{-- Imagen de portada --}}
            <div class="h-64 bg-gray-200 relative">
                @if($agricultor->foto_portada)
                    <img src="{{ $agricultor->foto_portada_url }}" 
                         alt="Portada"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-r from-green-400 to-green-600"></div>
                @endif
            </div>

            {{-- Información principal --}}
            <div class="relative px-6 pb-6">
                <div class="flex flex-col sm:flex-row sm:items-end sm:space-x-5">
                    {{-- Foto de perfil --}}
                    <div class="-mt-12 sm:-mt-16">
                        @if($agricultor->foto_perfil)
                            <img src="{{ $agricultor->foto_perfil_url }}" 
                                 alt="{{ $agricultor->nombre }}"
                                 class="w-24 h-24 sm:w-32 sm:h-32 rounded-full border-4 border-white bg-white">
                        @else
                            <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full border-4 border-white bg-green-600 flex items-center justify-center text-white text-3xl font-bold">
                                {{ substr($agricultor->nombre, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    {{-- Nombre y estadísticas --}}
                    <div class="mt-6 sm:flex-1 sm:min-w-0 sm:flex sm:items-center sm:justify-between sm:space-x-6 sm:pb-1">
                        <div class="flex-1 min-w-0">
                            <h1 class="text-2xl font-bold text-gray-900 truncate">
                                {{ $agricultor->nombre_empresa ?? $agricultor->nombre . ' ' . $agricultor->apellido }}
                            </h1>
                            <div class="mt-2 flex flex-col sm:flex-row sm:flex-wrap sm:mt-0 sm:space-x-6">
                                <div class="mt-2 flex items-center text-sm text-gray-500">
                                    <i data-lucide="map-pin" class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400"></i>
                                    {{ $agricultor->municipio ?? 'Almería' }}, {{ $agricultor->provincia ?? 'Almería' }}
                                </div>
                                @if($agricultor->anos_experiencia)
                                    <div class="mt-2 flex items-center text-sm text-gray-500">
                                        <i data-lucide="award" class="flex-shrink-0 mr-1.5 h-4 w-4 text-gray-400"></i>
                                        {{ $agricultor->anos_experiencia }} años de experiencia
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Botón de contacto --}}
                        <div class="mt-6 flex flex-col justify-stretch space-y-3 sm:flex-row sm:space-y-0 sm:space-x-4">
                            <button type="button" class="inline-flex justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <i data-lucide="message-circle" class="mr-2 h-4 w-4"></i>
                                Contactar
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Estadísticas --}}
                <div class="mt-6 grid grid-cols-3 gap-4">
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ $totalProductos }}</p>
                        <p class="text-sm text-gray-500">Productos</p>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($calificacionPromedio, 1) }}</p>
                        <div class="flex justify-center items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <i data-lucide="star" class="h-4 w-4 {{ $i <= $calificacionPromedio ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"></i>
                            @endfor
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="text-2xl font-bold text-gray-900">{{ $totalReseñas }}</p>
                        <p class="text-sm text-gray-500">Reseñas</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabs de información --}}
        <div class="mt-8 bg-white rounded-lg shadow">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                    <button class="border-b-2 border-green-500 py-4 px-1 text-sm font-medium text-green-600">
                        Acerca de
                    </button>
                    <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Productos ({{ $totalProductos }})
                    </button>
                    <button class="border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Reseñas ({{ $totalReseñas }})
                    </button>
                </nav>
            </div>

            <div class="p-6 space-y-6">
                {{-- Descripción --}}
                @if($agricultor->descripcion_publica)
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Sobre nosotros</h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $agricultor->descripcion_publica }}</p>
                    </div>
                @endif

                {{-- Información en columnas --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Métodos de cultivo --}}
                    @if($agricultor->metodos_cultivo)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">
                                <i data-lucide="leaf" class="inline h-5 w-5 text-green-600 mr-2"></i>
                                Métodos de cultivo
                            </h3>
                            <p class="text-gray-700">{{ $agricultor->metodos_cultivo }}</p>
                        </div>
                    @endif

                    {{-- Certificaciones --}}
                    @if($agricultor->certificaciones)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">
                                <i data-lucide="award" class="inline h-5 w-5 text-green-600 mr-2"></i>
                                Certificaciones
                            </h3>
                            <p class="text-gray-700">{{ $agricultor->certificaciones }}</p>
                        </div>
                    @endif
                </div>

                {{-- Horario de atención --}}
                @if($agricultor->horario_atencion)
                    <div class="bg-green-50 rounded-lg p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">
                            <i data-lucide="clock" class="inline h-5 w-5 text-green-600 mr-2"></i>
                            Horario de atención
                        </h3>
                        <p class="text-gray-700">{{ $agricultor->horario_atencion }}</p>
                    </div>
                @endif

                {{-- Mensaje si no hay información --}}
                @if(!$agricultor->descripcion_publica && !$agricultor->metodos_cultivo && !$agricultor->certificaciones && !$agricultor->horario_atencion)
                    <div class="text-center py-12">
                        <i data-lucide="info" class="mx-auto h-12 w-12 text-gray-400"></i>
                        <p class="mt-2 text-gray-500">Este agricultor aún no ha completado su perfil público.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    </script>
</body>
</html>