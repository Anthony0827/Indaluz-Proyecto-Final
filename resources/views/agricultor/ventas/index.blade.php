{{-- resources/views/agricultor/ventas/index.blade.php --}}
@extends('layouts.agricultor')

@section('title', 'Mis Ventas')
@section('header', 'Análisis de Ventas')

@section('content')
<div class="space-y-6">
    {{-- Selector de período --}}
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('agricultor.ventas.index') }}" class="flex flex-wrap items-end gap-4">
            <div class="flex-1 min-w-[200px]">
                <label for="periodo" class="block text-sm font-medium text-gray-700 mb-1">Período</label>
                <select name="periodo" id="periodo" onchange="toggleCustomDates(this.value)"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                    <option value="hoy" {{ $periodo == 'hoy' ? 'selected' : '' }}>Hoy</option>
                    <option value="semana" {{ $periodo == 'semana' ? 'selected' : '' }}>Esta semana</option>
                    <option value="mes" {{ $periodo == 'mes' ? 'selected' : '' }}>Este mes</option>
                    <option value="trimestre" {{ $periodo == 'trimestre' ? 'selected' : '' }}>Este trimestre</option>
                    <option value="anio" {{ $periodo == 'anio' ? 'selected' : '' }}>Este año</option>
                    <option value="personalizado" {{ $periodo == 'personalizado' ? 'selected' : '' }}>Personalizado</option>
                </select>
            </div>

            <div id="fechas-personalizadas" class="flex gap-4 {{ $periodo != 'personalizado' ? 'hidden' : '' }}">
                <div>
                    <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" 
                           value="{{ $periodo == 'personalizado' ? $fechaInicio->format('Y-m-d') : '' }}"
                           class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                </div>
                <div>
                    <label for="fecha_fin" class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" 
                           value="{{ $periodo == 'personalizado' ? $fechaFin->format('Y-m-d') : '' }}"
                           class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                </div>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                <i data-lucide="filter" class="w-4 h-4 inline mr-1"></i>
                Aplicar
            </button>

            <button type="button" onclick="window.location.href='{{ route('agricultor.ventas.exportar') }}'" 
                    class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                <i data-lucide="download" class="w-4 h-4 inline mr-1"></i>
                Exportar
            </button>
        </form>
    </div>

    {{-- Tarjetas de estadísticas principales --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        {{-- Total de ventas --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Ventas totales</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($estadisticas['total_ventas'], 2) }}€</p>
                    @if(isset($comparacion['ventas']))
                        <p class="text-xs mt-2 flex items-center {{ $comparacion['ventas'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <i data-lucide="{{ $comparacion['ventas'] >= 0 ? 'trending-up' : 'trending-down' }}" class="w-3 h-3 mr-1"></i>
                            {{ abs($comparacion['ventas']) }}% vs período anterior
                        </p>
                    @endif
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i data-lucide="euro" class="w-6 h-6 text-green-600"></i>
                </div>
            </div>
        </div>

        {{-- Número de pedidos --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Pedidos</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $estadisticas['numero_pedidos'] }}</p>
                    @if(isset($comparacion['pedidos']))
                        <p class="text-xs mt-2 flex items-center {{ $comparacion['pedidos'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <i data-lucide="{{ $comparacion['pedidos'] >= 0 ? 'trending-up' : 'trending-down' }}" class="w-3 h-3 mr-1"></i>
                            {{ abs($comparacion['pedidos']) }}%
                        </p>
                    @endif
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i data-lucide="shopping-cart" class="w-6 h-6 text-blue-600"></i>
                </div>
            </div>
        </div>

        {{-- Productos vendidos --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Productos vendidos</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $estadisticas['productos_vendidos'] }}</p>
                    @if(isset($comparacion['productos']))
                        <p class="text-xs mt-2 flex items-center {{ $comparacion['productos'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <i data-lucide="{{ $comparacion['productos'] >= 0 ? 'trending-up' : 'trending-down' }}" class="w-3 h-3 mr-1"></i>
                            {{ abs($comparacion['productos']) }}%
                        </p>
                    @endif
                </div>
                <div class="bg-yellow-100 rounded-full p-3">
                    <i data-lucide="package" class="w-6 h-6 text-yellow-600"></i>
                </div>
            </div>
        </div>

        {{-- Ticket medio --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Ticket medio</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ number_format($estadisticas['ticket_medio'], 2) }}€</p>
                    @if(isset($comparacion['ticket_medio']))
                        <p class="text-xs mt-2 flex items-center {{ $comparacion['ticket_medio'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <i data-lucide="{{ $comparacion['ticket_medio'] >= 0 ? 'trending-up' : 'trending-down' }}" class="w-3 h-3 mr-1"></i>
                            {{ abs($comparacion['ticket_medio']) }}%
                        </p>
                    @endif
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <i data-lucide="receipt" class="w-6 h-6 text-purple-600"></i>
                </div>
            </div>
        </div>

        {{-- Clientes únicos --}}
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Clientes</p>
                    <p class="text-2xl font-bold text-gray-900 mt-2">{{ $estadisticas['clientes_unicos'] }}</p>
                    @if(isset($comparacion['clientes']))
                        <p class="text-xs mt-2 flex items-center {{ $comparacion['clientes'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            <i data-lucide="{{ $comparacion['clientes'] >= 0 ? 'trending-up' : 'trending-down' }}" class="w-3 h-3 mr-1"></i>
                            {{ abs($comparacion['clientes']) }}%
                        </p>
                    @endif
                </div>
                <div class="bg-indigo-100 rounded-full p-3">
                    <i data-lucide="users" class="w-6 h-6 text-indigo-600"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficos --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Gráfico de ventas por período --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Evolución de ventas</h3>
            <canvas id="ventasPorPeriodoChart" height="300"></canvas>
        </div>

        {{-- Distribución por categoría --}}
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Ventas por categoría</h3>
            <canvas id="ventasPorCategoriaChart" height="300"></canvas>
        </div>
    </div>

    {{-- Tablas de información detallada --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Productos más vendidos --}}
        <div class="bg-white rounded-lg shadow">
            <div class="p-6 border-b">
                <h3 class="text-lg font-semibold text-gray-800">Productos más vendidos</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Producto
                            </th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Cantidad
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ingresos
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($productosMasVendidos as $producto)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $producto->nombre }}</div>
                                        <div class="text-xs text-gray-500">{{ ucfirst($producto->categoria) }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="text-sm text-gray-900">{{ $producto->cantidad_vendida }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <span class="text-sm font-medium text-gray-900">{{ number_format($cliente->total_comprado, 2) }}€</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                    No hay clientes en este período
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Producto estrella --}}
    @if($estadisticas['producto_estrella'])
        <div class="bg-green-50 border border-green-200 rounded-lg p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i data-lucide="star" class="w-8 h-8 text-green-600"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-green-800">Producto estrella del período</h3>
                    <p class="text-green-700 mt-1">
                        <span class="font-semibold">{{ $estadisticas['producto_estrella']->nombre }}</span> 
                        con {{ $estadisticas['producto_estrella']->total_vendido }} unidades vendidas
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Toggle fechas personalizadas
    window.toggleCustomDates = function(value) {
        const fechasDiv = document.getElementById('fechas-personalizadas');
        if (value === 'personalizado') {
            fechasDiv.classList.remove('hidden');
        } else {
            fechasDiv.classList.add('hidden');
        }
    };

    // Datos para gráficos
    const ventasPorPeriodo = @json($ventasPorPeriodo);
    const ventasPorCategoria = @json($ventasPorCategoria);

    // Gráfico de evolución de ventas
    if (ventasPorPeriodo.length > 0) {
        const ctx1 = document.getElementById('ventasPorPeriodoChart').getContext('2d');
        new Chart(ctx1, {
            type: 'line',
            data: {
                labels: ventasPorPeriodo.map(item => {
                    const fecha = new Date(item.fecha);
                    return fecha.toLocaleDateString('es-ES', { day: '2-digit', month: 'short' });
                }),
                datasets: [{
                    label: 'Ventas (€)',
                    data: ventasPorPeriodo.map(item => item.total),
                    borderColor: 'rgb(34, 197, 94)',
                    backgroundColor: 'rgba(34, 197, 94, 0.1)',
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Ventas: ' + context.parsed.y.toFixed(2) + '€';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return value + '€';
                            }
                        }
                    }
                }
            }
        });
    }

    // Gráfico de ventas por categoría
    if (ventasPorCategoria.length > 0) {
        const ctx2 = document.getElementById('ventasPorCategoriaChart').getContext('2d');
        new Chart(ctx2, {
            type: 'doughnut',
            data: {
                labels: ventasPorCategoria.map(item => ucfirst(item.categoria)),
                datasets: [{
                    data: ventasPorCategoria.map(item => item.total),
                    backgroundColor: [
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(251, 146, 60, 0.8)',
                        'rgba(147, 51, 234, 0.8)'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((value / total) * 100).toFixed(1);
                                return label + ': ' + value.toFixed(2) + '€ (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });
    }

    // Función para capitalizar primera letra
    function ucfirst(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
});
</script>
@endpush


@endsection

                                    