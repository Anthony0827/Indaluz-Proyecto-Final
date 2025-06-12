{{-- resources/views/agricultor/pedidos/show.blade.php --}}
@extends('layouts.agricultor')

@section('title', 'Detalle del Pedido')
@section('header', 'Detalle del Pedido #' . str_pad($pedido->id_pedido, 6, '0', STR_PAD_LEFT))

@section('content')
<div class="space-y-6">
    {{-- Información general del pedido --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- Estado y acciones --}}
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Estado del pedido</h3>
                <div class="flex items-center gap-3 mb-4">
                    <span class="inline-flex px-3 py-1 text-sm rounded-full font-medium
                        {{ $pedido->estado == 'pendiente' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $pedido->estado == 'confirmado' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $pedido->estado == 'entregado' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $pedido->estado == 'cancelado' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($pedido->estado) }}
                    </span>
                </div>

                @if($pedido->estado !== 'cancelado' && $pedido->estado !== 'entregado')
                    <form method="POST" action="{{ route('agricultor.pedidos.updateEstado', $pedido->id_pedido) }}" class="flex gap-2">
                        @csrf
                        @method('PATCH')
                        <select name="estado" class="flex-1 px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:border-green-500">
                            <option value="">Cambiar estado</option>
                            @if($pedido->estado == 'pendiente')
                                <option value="confirmado">Confirmar</option>
                            @endif
                            @if($pedido->estado == 'confirmado')
                                <option value="entregado">Marcar como entregado</option>
                            @endif
                            <option value="cancelado">Cancelar</option>
                        </select>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition text-sm">
                            Actualizar
                        </button>
                    </form>
                @endif
            </div>

            {{-- Información del cliente --}}
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Cliente</h3>
                <p class="font-medium text-gray-900">{{ $pedido->cliente->nombre }} {{ $pedido->cliente->apellido }}</p>
                <p class="text-sm text-gray-600">
                    <i data-lucide="phone" class="w-4 h-4 inline mr-1"></i>
                    <a href="tel:{{ $pedido->cliente->telefono }}" class="hover:text-green-600">
                        {{ $pedido->cliente->telefono }}
                    </a>
                </p>
                <p class="text-sm text-gray-600">
                    <i data-lucide="mail" class="w-4 h-4 inline mr-1"></i>
                    <a href="mailto:{{ $pedido->cliente->correo }}" class="hover:text-green-600">
                        {{ $pedido->cliente->correo }}
                    </a>
                </p>
            </div>

            {{-- Información de entrega --}}
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Entrega</h3>
                <p class="font-medium text-gray-900">
                    {{ $pedido->metodo_entrega == 'domicilio' ? 'Entrega a domicilio' : 'Recogida en punto de venta' }}
                </p>
                <p class="text-sm text-gray-600">
                    <i data-lucide="calendar" class="w-4 h-4 inline mr-1"></i>
                    {{ \Carbon\Carbon::parse($pedido->fecha_entrega)->format('d/m/Y') }}
                </p>
                <p class="text-sm text-gray-600">
                    <i data-lucide="clock" class="w-4 h-4 inline mr-1"></i>
                    {{ $pedido->hora_entrega }}
                </p>
            </div>
        </div>

        @if($pedido->metodo_entrega == 'domicilio')
            <div class="mt-6 pt-6 border-t">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Dirección de entrega</h3>
                <p class="text-gray-900">{{ $pedido->direccion_envio }}</p>
            </div>
        @endif

        @if($pedido->notas_cliente)
            <div class="mt-6 pt-6 border-t">
                <h3 class="text-sm font-medium text-gray-500 mb-2">Notas del cliente</h3>
                <p class="text-gray-900 bg-gray-50 rounded p-3">{{ $pedido->notas_cliente }}</p>
            </div>
        @endif
    </div>

    {{-- Productos del pedido (solo los del agricultor) --}}
    <div class="bg-white rounded-lg shadow">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-800">Tus productos en este pedido</h2>
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
                            Precio unitario
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Subtotal
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($productosDelAgricultor as $detalle)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($detalle->producto->imagen)
                                        <img src="{{ asset('storage/' . $detalle->producto->imagen) }}" 
                                             alt="{{ $detalle->producto->nombre }}"
                                             class="w-10 h-10 rounded-lg object-cover mr-3">
                                    @else
                                        <div class="w-10 h-10 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                                            <i data-lucide="image-off" class="w-5 h-5 text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $detalle->producto->nombre }}</div>
                                        <div class="text-xs text-gray-500">{{ ucfirst($detalle->producto->categoria) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="text-sm text-gray-900">
                                    {{ $detalle->cantidad }} {{ $detalle->producto->unidad_medida_texto }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="text-sm text-gray-900">{{ number_format($detalle->precio_unitario, 2) }}€</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="text-sm font-medium text-gray-900">
                                    {{ number_format($detalle->cantidad * $detalle->precio_unitario, 2) }}€
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-medium text-gray-900">
                            Total de tus productos:
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-lg font-bold text-green-600">{{ number_format($totalAgricultor, 2) }}€</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- Información de pago --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Información de pago</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-600">Método de pago</p>
                <p class="font-medium text-gray-900">
                    {{ $pedido->metodo_pago == 'tarjeta' ? 'Tarjeta de crédito/débito' : 'Efectivo' }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-600">Estado del pago</p>
                <p class="font-medium {{ $pedido->estado_pago == 'pagado' ? 'text-green-600' : 'text-yellow-600' }}">
                    {{ ucfirst($pedido->estado_pago) }}
                    @if($pedido->metodo_pago == 'efectivo' && $pedido->estado_pago == 'pendiente')
                        <span class="text-sm text-gray-500">(Se pagará al entregar)</span>
                    @endif
                </p>
            </div>
            @if($pedido->numero_transaccion)
                <div>
                    <p class="text-sm text-gray-600">Número de transacción</p>
                    <p class="font-mono text-sm text-gray-900">{{ $pedido->numero_transaccion }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Línea de tiempo del pedido --}}
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-800 mb-4">Historial del pedido</h2>
        <div class="space-y-4">
            {{-- Pedido creado --}}
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                        <i data-lucide="check" class="w-4 h-4 text-green-600"></i>
                    </div>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Pedido realizado</p>
                    <p class="text-sm text-gray-500">
                        {{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>

            {{-- Estados intermedios --}}
            @if(in_array($pedido->estado, ['confirmado', 'entregado']))
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i data-lucide="package-2" class="w-4 h-4 text-blue-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Pedido confirmado</p>
                        <p class="text-sm text-gray-500">Preparando productos</p>
                    </div>
                </div>
            @endif

            @if($pedido->estado == 'entregado')
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i data-lucide="package-check" class="w-4 h-4 text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Pedido entregado</p>
                        <p class="text-sm text-gray-500">Entrega completada exitosamente</p>
                    </div>
                </div>
            @endif

            @if($pedido->estado == 'cancelado')
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <i data-lucide="x" class="w-4 h-4 text-red-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Pedido cancelado</p>
                        <p class="text-sm text-gray-500">El pedido ha sido cancelado</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Botones de acción --}}
    <div class="flex justify-between items-center">
        <a href="{{ route('agricultor.pedidos.index') }}" 
           class="text-gray-600 hover:text-gray-800 font-medium">
            <i data-lucide="arrow-left" class="w-4 h-4 inline mr-1"></i>
            Volver a pedidos
        </a>

        <div class="flex gap-3">
            @if($pedido->estado == 'confirmado')
                <form method="POST" action="{{ route('agricultor.pedidos.marcarPreparado', $pedido->id_pedido) }}">
                    @csrf
                    <button type="submit" 
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                        <i data-lucide="check-square" class="w-4 h-4 inline mr-1"></i>
                        Marcar como preparado
                    </button>
                </form>
            @endif

            <button onclick="window.print()" 
                    class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                <i data-lucide="printer" class="w-4 h-4 inline mr-1"></i>
                Imprimir
            </button>
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

    // Auto-submit del formulario de cambio de estado
    const selectEstado = document.querySelector('select[name="estado"]');
    if (selectEstado) {
        selectEstado.addEventListener('change', function() {
            if (this.value && confirm('¿Estás seguro de cambiar el estado del pedido?')) {
                this.form.submit();
            }
        });
    }
});
</script>
@endpush

{{-- Estilos para impresión --}}
@push('styles')
<style>
@media print {
    .no-print { display: none !important; }
    body { font-size: 12pt; }
    .shadow { box-shadow: none !important; }
}
</style>
@endpush
@endsection