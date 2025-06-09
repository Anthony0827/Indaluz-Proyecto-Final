{{-- resources/views/cliente/pedido-confirmacion.blade.php --}}
@extends('layouts.cliente')

@section('title', 'Pedido Confirmado')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-3xl mx-auto">
        {{-- Mensaje de éxito --}}
        <div class="bg-green-50 border border-green-200 rounded-lg p-8 text-center mb-8">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="check-circle" class="w-10 h-10 text-green-600"></i>
            </div>
            <h1 class="text-3xl font-bold text-green-800 mb-2">¡Pedido Confirmado!</h1>
            <p class="text-green-700 text-lg">
                Tu pedido ha sido procesado exitosamente
            </p>
            <p class="text-green-600 mt-2">
                Número de pedido: <span class="font-semibold">#{{ str_pad($pedido->id_pedido, 6, '0', STR_PAD_LEFT) }}</span>
            </p>
            @if($pedido->numero_transaccion)
                <p class="text-sm text-green-600 mt-1">
                    Transacción: {{ $pedido->numero_transaccion }}
                </p>
            @endif
        </div>

        {{-- Detalles del pedido --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Detalles del pedido</h2>
            
            <div class="space-y-4">
                @foreach($pedido->detalles as $detalle)
                    <div class="flex justify-between items-start pb-4 border-b last:border-0">
                        <div class="flex-1">
                            <h3 class="font-medium text-gray-800">{{ $detalle->producto->nombre }}</h3>
                            <p class="text-sm text-gray-600">
                                {{ $detalle->cantidad }} {{ $detalle->producto->unidad_medida_texto }} × 
                                {{ number_format($detalle->precio_unitario, 2) }}€
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                Vendido por: {{ $detalle->producto->agricultor->nombre_empresa ?? $detalle->producto->agricultor->nombre }}
                            </p>
                        </div>
                        <p class="font-semibold text-gray-800 ml-4">
                            {{ number_format($detalle->subtotal, 2) }}€
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="border-t pt-4 mt-4">
                <div class="flex justify-between text-lg font-semibold">
                    <span>Total pagado</span>
                    <span class="text-green-600">{{ number_format($pedido->total, 2) }}€</span>
                </div>
            </div>
        </div>

        {{-- Información de entrega --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-semibold mb-4">Información de entrega</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Método de entrega</p>
                    <p class="font-medium">
                        {{ $pedido->metodo_entrega == 'domicilio' ? 'Entrega a domicilio' : 'Recogida en punto de venta' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Fecha de entrega</p>
                    <p class="font-medium">
                        {{ \Carbon\Carbon::parse($pedido->fecha_entrega)->format('d/m/Y') }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Horario</p>
                    <p class="font-medium">{{ $pedido->hora_entrega }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Método de pago</p>
                    <p class="font-medium">
                        {{ $pedido->metodo_pago == 'tarjeta' ? 'Tarjeta de crédito/débito' : 'Efectivo' }}
                    </p>
                </div>
            </div>

            @if($pedido->metodo_entrega == 'domicilio')
                <div class="mt-4 pt-4 border-t">
                    <p class="text-sm text-gray-600">Dirección de entrega</p>
                    <p class="font-medium">{{ $pedido->direccion_envio }}</p>
                </div>
            @endif

            @if($pedido->notas_cliente)
                <div class="mt-4 pt-4 border-t">
                    <p class="text-sm text-gray-600">Notas del pedido</p>
                    <p class="text-gray-800">{{ $pedido->notas_cliente }}</p>
                </div>
            @endif
        </div>

        {{-- Próximos pasos --}}
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <h3 class="font-semibold text-blue-800 mb-3 flex items-center">
                <i data-lucide="info" class="w-5 h-5 mr-2"></i>
                ¿Qué sigue ahora?
            </h3>
            <ul class="space-y-2 text-blue-700">
                <li class="flex items-start">
                    <i data-lucide="check" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                    <span>Recibirás un email de confirmación con los detalles de tu pedido</span>
                </li>
                <li class="flex items-start">
                    <i data-lucide="check" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                    <span>El agricultor preparará tu pedido con productos frescos</span>
                </li>
                <li class="flex items-start">
                    <i data-lucide="check" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                    <span>
                        @if($pedido->metodo_entrega == 'domicilio')
                            Te entregaremos el pedido en la fecha y horario seleccionados
                        @else
                            Podrás recoger tu pedido en el punto de venta acordado
                        @endif
                    </span>
                </li>
                @if($pedido->metodo_pago == 'efectivo')
                    <li class="flex items-start">
                        <i data-lucide="check" class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0"></i>
                        <span>Prepara el importe exacto en efectivo: {{ number_format($pedido->total, 2) }}€</span>
                    </li>
                @endif
            </ul>
        </div>

        {{-- Botones de acción --}}
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('cliente.pedidos') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                <i data-lucide="package" class="w-5 h-5 mr-2"></i>
                Ver mis pedidos
            </a>
            <a href="{{ route('cliente.home') }}" 
               class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                <i data-lucide="shopping-bag" class="w-5 h-5 mr-2"></i>
                Seguir comprando
            </a>
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

    // Limpiar el carrito del localStorage
    localStorage.removeItem('carrito');
    
    // Actualizar contador del carrito en el header
    document.querySelectorAll('.cart-count').forEach(el => {
        el.textContent = '0';
    });
});
</script>
@endpush
@endsection