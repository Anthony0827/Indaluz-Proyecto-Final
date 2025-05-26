{{-- resources/views/agricultor/dashboard.blade.php --}}
@extends('layouts.agricultor')

@section('title', 'Panel de Agricultor')

@section('content')
<div class="space-y-6">
    {{-- Encabezado de bienvenida --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold text-gray-800">
            ¡Bienvenido, {{ Auth::user()->nombre }}!
        </h1>
        <p class="text-gray-600 mt-2">
            Aquí puedes gestionar tus productos, pedidos y ver el rendimiento de tu negocio.
        </p>
    </div>

    {{-- Estadísticas principales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Productos activos --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Productos Activos</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['productos_activos'] }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i data-lucide="package" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-4">Total de productos en venta</p>
        </div>

        {{-- Pedidos del mes --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pedidos este mes</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pedidos_mes'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i data-lucide="shopping-cart" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-4">{{ date('F Y') }}</p>
        </div>

        {{-- Ingresos del mes --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Ingresos del mes</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($stats['ingresos_mes'], 2) }}€</p>
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <i data-lucide="euro" class="w-6 h-6 text-yellow-600"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-4">Pedidos entregados</p>
        </div>

        {{-- Calificación promedio --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Calificación</p>
                    <div class="flex items-center mt-2">
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['calificacion_promedio'] }}</p>
                        <i data-lucide="star" class="w-6 h-6 text-yellow-500 ml-2 fill-current"></i>
                    </div>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <i data-lucide="award" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
            <p class="text-xs text-gray-500 mt-4">Valoración promedio</p>
        </div>
    </div>

    {{-- Acciones rápidas --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Acciones rápidas</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('agricultor.productos.create') }}" 
               class="flex items-center justify-center gap-3 bg-green-600 text-white px-4 py-3 rounded-lg hover:bg-green-700 transition">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                <span>Añadir Producto</span>
            </a>
            <a href="{{ route('agricultor.pedidos.index') }}" 
               class="flex items-center justify-center gap-3 bg-blue-600 text-white px-4 py-3 rounded-lg hover:bg-blue-700 transition">
                <i data-lucide="package-2" class="w-5 h-5"></i>
                <span>Ver Pedidos</span>
            </a>
            <a href="{{ route('agricultor.productos.index') }}" 
               class="flex items-center justify-center gap-3 bg-gray-600 text-white px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i data-lucide="settings" class="w-5 h-5"></i>
                <span>Gestionar Productos</span>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Productos más vendidos --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Productos más vendidos</h2>
            @if($topProductos->count() > 0)
                <div class="space-y-3">
                    @foreach($topProductos as $producto)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                @if($producto->imagen)
                                    <img src="{{ asset('storage/'.$producto->imagen) }}" alt="{{ $producto->nombre }}" 
                                         class="w-12 h-12 rounded object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                        <i data-lucide="image-off" class="w-6 h-6 text-gray-400"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-gray-800">{{ $producto->nombre }}</p>
                                    <p class="text-sm text-gray-500">{{ $producto->categoria }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-800">{{ $producto->total_vendido }} uds</p>
                                <p class="text-sm text-green-600">{{ number_format($producto->precio, 2) }}€</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">
                    Aún no hay ventas registradas. ¡Empieza añadiendo productos!
                </p>
            @endif
        </div>

        {{-- Pedidos recientes --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Pedidos recientes</h2>
            @if($pedidosRecientes->count() > 0)
                <div class="space-y-3">
                    @foreach($pedidosRecientes as $pedido)
                        <div class="border-l-4 border-{{ $pedido->estado == 'entregado' ? 'green' : ($pedido->estado == 'pendiente' ? 'yellow' : 'gray') }}-500 bg-gray-50 p-3 rounded-r-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-800">
                                        {{ $pedido->nombre }} {{ $pedido->apellido }}
                                    </p>
                                    <p class="text-sm text-gray-600">
                                        Pedido #{{ $pedido->id_pedido }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-gray-800">{{ number_format($pedido->total, 2) }}€</p>
                                    <span class="inline-flex px-2 py-1 text-xs rounded-full mt-1
                                        {{ $pedido->estado == 'entregado' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $pedido->estado == 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                        {{ $pedido->estado == 'confirmado' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $pedido->estado == 'cancelado' ? 'bg-red-100 text-red-800' : '' }}">
                                        {{ ucfirst($pedido->estado) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <a href="{{ route('agricultor.pedidos.index') }}" 
                   class="block text-center text-green-600 hover:text-green-700 mt-4 font-medium">
                    Ver todos los pedidos →
                </a>
            @else
                <p class="text-gray-500 text-center py-8">
                    No hay pedidos recientes
                </p>
            @endif
        </div>
    </div>

    {{-- Avisos importantes --}}
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
        <div class="flex items-start gap-3">
            <i data-lucide="info" class="w-5 h-5 text-yellow-600 mt-0.5"></i>
            <div>
                <h3 class="font-semibold text-yellow-800 mb-2">Consejos para aumentar tus ventas</h3>
                <ul class="list-disc list-inside text-sm text-yellow-700 space-y-1">
                    <li>Mantén tus productos actualizados con fotos de calidad</li>
                    <li>Responde rápidamente a los pedidos de tus clientes</li>
                    <li>Ofrece productos de temporada para mejores precios</li>
                    <li>Cuida la calidad y frescura de tus productos</li>
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Script para inicializar iconos --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endsection