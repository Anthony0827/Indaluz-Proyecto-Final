{{-- resources/views/agricultor/pedidos/index.blade.php --}}
@extends('layouts.agricultor')

@section('title', 'Mis Pedidos')
@section('header', 'Gestión de Pedidos')

@section('content')
<div class="space-y-6">
    {{-- Estadísticas rápidas --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pendientes</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $estadisticas['pendientes'] }}</p>
                </div>
                <div class="bg-yellow-100 rounded-full p-2">
                    <i data-lucide="clock" class="w-5 h-5 text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Confirmados</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $estadisticas['confirmados'] }}</p>
                </div>
                <div class="bg-blue-100 rounded-full p-2">
                    <i data-lucide="check-circle" class="w-5 h-5 text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Entregados</p>
                    <p class="text-2xl font-bold text-green-600">{{ $estadisticas['entregados'] }}</p>
                </div>
                <div class="bg-green-100 rounded-full p-2">
                    <i data-lucide="package-check" class="w-5 h-5 text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Cancelados</p>
                    <p class="text-2xl font-bold text-red-600">{{ $estadisticas['cancelados'] }}</p>
                </div>
                <div class="bg-red-100 rounded-full p-2">
                    <i data-lucide="x-circle" class="w-5 h-5 text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('agricultor.pedidos.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" 
                       name="buscar" 
                       value="{{ request('buscar') }}"
                       placeholder="Buscar por cliente o número de pedido..." 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
            </div>
            
            <select name="estado" 
                    class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                <option value="">Todos los estados</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="confirmado" {{ request('estado') == 'confirmado' ? 'selected' : '' }}>Confirmado</option>
                <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>

            <input type="date" 
                   name="fecha_desde" 
                   value="{{ request('fecha_desde') }}"
                   placeholder="Desde"
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">

            <input type="date" 
                   name="fecha_hasta" 
                   value="{{ request('fecha_hasta') }}"
                   placeholder="Hasta"
                   class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">

            <button type="submit" 
                    class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                <i data-lucide="filter" class="w-4 h-4 inline mr-1"></i>
                Filtrar
            </button>

            @if(request()->hasAny(['buscar', 'estado', 'fecha_desde', 'fecha_hasta']))
                <a href="{{ route('agricultor.pedidos.index') }}" 
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    {{-- Lista de pedidos --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pedido
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Cliente
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Fecha
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Productos
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Entrega
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pedidos as $pedido)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    #{{ str_pad($pedido->id_pedido, 6, '0', STR_PAD_LEFT) }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $pedido->metodo_pago == 'tarjeta' ? 'Pagado' : 'Pago en efectivo' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $pedido->cliente_nombre }} {{ $pedido->cliente_apellido }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    <a href="tel:{{ $pedido->cliente_telefono }}" class="hover:text-green-600">
                                        <i data-lucide="phone" class="w-3 h-3 inline"></i>
                                        {{ $pedido->cliente_telefono }}
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('H:i') }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">
                                    {{ $pedido->productos_agricultor }} productos
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ number_format($pedido->total_agricultor, 2) }}€
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 text-xs rounded-full font-medium
                                    {{ $pedido->estado == 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $pedido->estado == 'confirmado' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $pedido->estado == 'entregado' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $pedido->estado == 'cancelado' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($pedido->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($pedido->fecha_entrega)->format('d/m/Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ $pedido->hora_entrega }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <a href="{{ route('agricultor.pedidos.show', $pedido->id_pedido) }}" 
                                   class="text-green-600 hover:text-green-900 font-medium">
                                    Ver detalle
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                                <i data-lucide="package-x" class="w-12 h-12 text-gray-400 mx-auto mb-3"></i>
                                <p>No se encontraron pedidos</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pedidos->hasPages())
            <div class="px-6 py-4 border-t">
                {{ $pedidos->appends(request()->all())->links() }}
            </div>
        @endif
    </div>

    {{-- Información adicional --}}
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex">
            <i data-lucide="info" class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0"></i>
            <div class="text-sm">
                <p class="text-blue-800 font-medium">Gestión de pedidos</p>
                <ul class="text-blue-600 mt-1 list-disc list-inside">
                    <li>Solo se muestran pedidos que contienen tus productos</li>
                    <li>El total mostrado corresponde únicamente a tus productos</li>
                    <li>Mantén actualizados los estados para una mejor experiencia del cliente</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endpush
@endsection