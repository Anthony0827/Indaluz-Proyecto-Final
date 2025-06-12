{{-- resources/views/cliente/agricultor.blade.php --}}
@extends('layouts.cliente')

@section('title', $agricultor->nombre_empresa ?? $agricultor->nombre . ' ' . $agricultor->apellido)

@section('content')
<main class="bg-gray-50">

    {{-- Cabecera perfil --}}
    <div class="bg-white shadow-sm">
        {{-- Portada --}}
        <div class="h-64 bg-gray-200 relative overflow-hidden">
            @if($agricultor->foto_portada)
                <img src="{{ asset('storage/' . $agricultor->foto_portada) }}"
                     alt="Portada {{ $agricultor->nombre }}"
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-r from-green-400 to-green-600"></div>
            @endif
        </div> <br> <br> <br>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 pb-6 flex items-end">
            {{-- Avatar --}}
            <div class="flex-shrink-0">
                @if($agricultor->foto_perfil)
                    <img src="{{ asset('storage/' . $agricultor->foto_perfil) }}"
                         alt="{{ $agricultor->nombre }}"
                         class="w-32 h-32 sm:w-40 sm:h-40 rounded-full border-4 border-white object-cover">
                @else
                    <div class="w-32 h-32 sm:w-40 sm:h-40 rounded-full border-4 border-white bg-green-600
                                flex items-center justify-center text-white text-4xl font-bold">
                        {{ substr($agricultor->nombre,0,1) }}
                    </div>
                @endif
            </div>
            {{-- Nombre y datos --}}
            <div class="ml-6">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 truncate">
                    {{ $agricultor->nombre_empresa ?? $agricultor->nombre . ' ' . $agricultor->apellido }}
                </h1>
                <div class="mt-2 flex flex-wrap text-sm text-gray-500 space-x-4">
                    @if($agricultor->municipio || $agricultor->provincia)
                        <div class="flex items-center">
                            <i data-lucide="map-pin" class="w-4 h-4 mr-1 text-gray-400"></i>
                            {{ $agricultor->municipio ?? 'Almería' }}, {{ $agricultor->provincia ?? 'Almería' }}
                        </div>
                    @endif
                    @if($agricultor->anos_experiencia)
                        <div class="flex items-center">
                            <i data-lucide="award" class="w-4 h-4 mr-1 text-gray-400"></i>
                            {{ $agricultor->anos_experiencia }} años de experiencia
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Estadísticas --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-white rounded-lg shadow p-6 grid grid-cols-3 divide-x divide-gray-200 text-center">
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $totalProductos }}</p>
                <p class="text-sm text-gray-500">Productos</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($calificacionPromedio,1) }}</p>
                <div class="flex justify-center items-center space-x-1">
                    @for($i=1;$i<=5;$i++)
                        <i data-lucide="star"
                           class="w-5 h-5 {{ $i <= $calificacionPromedio ? 'text-yellow-400 fill-current' : 'text-gray-300' }}">
                        </i>
                    @endfor
                </div>
                <p class="text-sm text-gray-500">{{ $totalReseñas }} reseñas</p>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $totalReseñas }}</p>
                <p class="text-sm text-gray-500">Reseñas</p>
            </div>
        </div>
    </div>

    {{-- Sobre nosotros --}}
    @if($agricultor->descripcion_publica)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">Sobre nosotros</h2>
            <p class="text-gray-700 whitespace-pre-line">{{ $agricultor->descripcion_publica }}</p>
        </div>
    </div>
    @endif

    {{-- Métodos de cultivo y Certificaciones --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        @if($agricultor->metodos_cultivo)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2 flex items-center">
                <i data-lucide="leaf" class="w-5 h-5 text-green-600 mr-2"></i>
                Métodos de cultivo
            </h3>
            <p class="text-gray-700">{{ $agricultor->metodos_cultivo }}</p>
        </div>
        @endif
        @if($agricultor->certificaciones)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2 flex items-center">
                <i data-lucide="award" class="w-5 h-5 text-green-600 mr-2"></i>
                Certificaciones
            </h3>
            <p class="text-gray-700">{{ $agricultor->certificaciones }}</p>
        </div>
        @endif
    </div>

    {{-- Horario de atención --}}
    @if($agricultor->horario_atencion)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="bg-green-50 rounded-lg p-6 flex items-start space-x-3">
            <i data-lucide="clock" class="w-6 h-6 text-green-600 mt-1"></i>
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Horario de atención</h3>
                <p class="text-gray-700">{{ $agricultor->horario_atencion }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- Productos --}}
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Productos</h2>
        @if($productos->count())
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($productos as $producto)
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                        <a href="{{ route('cliente.producto', $producto->id_producto) }}">
                            <div class="h-40 bg-gray-200">
                                @if($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}"
                                         alt="{{ $producto->nombre }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400">
                                        <i data-lucide="image-off" class="w-12 h-12"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-semibold text-lg text-gray-800">{{ $producto->nombre }}</h3>
                                <p class="text-green-600 font-bold mt-2">
                                    {{ number_format($producto->precio,2) }}€ /
                                    {{ ucfirst($producto->unidad_medida) }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">{{ $productos->links() }}</div>
        @else
            <p class="text-gray-600">No hay productos disponibles.</p>
        @endif
    </section>

    {{-- Reseñas recientes --}}
    @if(isset($reseñasRecientes) && $reseñasRecientes->count())
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Reseñas recientes</h2>
        <div class="space-y-6">
            @foreach($reseñasRecientes as $res)
                <div class="bg-white rounded-lg shadow p-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="font-semibold text-gray-800">{{ $res->cliente->nombre }}</span>
                        <span class="text-sm text-gray-500">{{ $res->fecha_reseña->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex items-center mb-2 space-x-1">
                        @for($i=1;$i<=5;$i++)
                            <i data-lucide="star"
                               class="w-5 h-5 {{ $i <= $res->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                    @if($res->comentario)
                        <p class="text-gray-700">{{ $res->comentario }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </section>
    @endif

</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') lucide.createIcons();
    });
</script>
@endpush
