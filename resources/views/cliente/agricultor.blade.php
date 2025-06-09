{{-- resources/views/cliente/agricultor.blade.php --}}
@extends('layouts.cliente')

@section('title', $agricultor->nombre_empresa ?? $agricultor->nombre . ' ' . $agricultor->apellido)

@section('content')
<div class="container mx-auto px-4 py-6 space-y-12">

    {{-- Cabecera: portada + avatar --}}
    <div class="relative bg-white shadow rounded-lg overflow-hidden">
        {{-- Portada --}}
        @if($agricultor->foto_portada)
            <img src="{{ asset('storage/' . $agricultor->foto_portada) }}"
                 alt="Portada {{ $agricultor->nombre }}"
                 class="w-full h-64 object-cover">
        @else
            <div class="w-full h-64 bg-green-100"></div>
        @endif

        {{-- Avatar --}}
        <div class="absolute -bottom-16 left-8">
            @if($agricultor->foto_perfil)
                <img src="{{ asset('storage/' . $agricultor->foto_perfil) }}"
                     alt="Avatar {{ $agricultor->nombre }}"
                     class="w-32 h-32 rounded-full border-4 border-white object-cover">
            @else
                <div class="w-32 h-32 rounded-full bg-green-600 border-4 border-white
                            text-white flex items-center justify-center text-4xl font-bold">
                    {{ substr($agricultor->nombre, 0, 1) }}
                </div>
            @endif
        </div>
    </div>

    {{-- Datos del agricultor --}}
    <div class="mt-20 bg-white shadow rounded-lg p-6 space-y-4">
        {{-- Nombre / Empresa --}}
        <h1 class="text-3xl font-bold text-gray-800">
            {{ $agricultor->nombre_empresa ?? $agricultor->nombre . ' ' . $agricultor->apellido }}
        </h1>

        {{-- Descripción pública --}}
        @if($agricultor->descripcion_publica)
            <p class="text-gray-600">{{ $agricultor->descripcion_publica }}</p>
        @endif

        {{-- Puntuación media --}}
        <div class="flex items-center space-x-2">
            <div class="flex">
                @for($i = 1; $i <= 5; $i++)
                    <i data-lucide="star"
                       class="w-6 h-6 {{ $i <= floor($calificacionPromedio) ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                @endfor
            </div>
            <span class="text-gray-700">
                {{ number_format($calificacionPromedio, 1) }} / 5 ({{ $totalReseñas }} reseñas)
            </span>
        </div>

        {{-- Datos adicionales (experiencia, horario, etc.) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($agricultor->anos_experiencia)
                <div>
                    <h3 class="font-semibold text-lg text-gray-800">Años de experiencia</h3>
                    <p class="text-gray-600">{{ $agricultor->anos_experiencia }} años</p>
                </div>
            @endif
            @if($agricultor->horario_atencion)
                <div>
                    <h3 class="font-semibold text-lg text-gray-800">Horario de atención</h3>
                    <p class="text-gray-600">{{ $agricultor->horario_atencion }}</p>
                </div>
            @endif
            @if($agricultor->certificaciones)
                <div>
                    <h3 class="font-semibold text-lg text-gray-800">Certificaciones</h3>
                    <p class="text-gray-600">{{ $agricultor->certificaciones }}</p>
                </div>
            @endif
            @if($agricultor->metodos_cultivo)
                <div>
                    <h3 class="font-semibold text-lg text-gray-800">Métodos de cultivo</h3>
                    <p class="text-gray-600">{{ $agricultor->metodos_cultivo }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Productos del agricultor --}}
    <section>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            Productos de {{ $agricultor->nombre_empresa ?? $agricultor->nombre }}
        </h2>

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
                                    {{ number_format($producto->precio, 2) }}€ /
                                    {{ ucfirst($producto->unidad_medida) }}
                                </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $productos->links() }}
            </div>
        @else
            <p class="text-gray-600">Este agricultor no tiene productos activos en este momento.</p>
        @endif
    </section>

    {{-- Reseñas recientes (opcional) --}}
    @if(isset($reseñasRecientes) && $reseñasRecientes->count())
        <section class="space-y-4">
            <h2 class="text-2xl font-bold text-gray-800">Reseñas recientes</h2>
            @foreach($reseñasRecientes as $res)
                <div class="bg-white shadow rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-semibold">{{ $res->cliente->nombre }}</span>
                        <span class="text-sm text-gray-500">{{ $res->fecha_reseña->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex items-center mb-2 space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                            <i data-lucide="star"
                               class="w-5 h-5 {{ $i <= $res->rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                        @endfor
                    </div>
                    @if($res->comentario)
                        <p class="text-gray-700">{{ $res->comentario }}</p>
                    @endif
                </div>
            @endforeach
        </section>
    @endif

</div>
@endsection
