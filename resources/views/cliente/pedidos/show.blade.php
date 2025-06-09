@extends('layouts.cliente')

@section('title', 'Pedido #' . $pedido->id_pedido)

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Pedido #{{ $pedido->id_pedido }}</h2>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <p><strong>Fecha:</strong> {{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($pedido->estado) }}</p>
        <p><strong>Total:</strong> {{ number_format($pedido->total,2) }} €</p>
    </div>

    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full leading-normal">
            <thead>
                <tr class="bg-gray-100">
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Producto</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Cantidad</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Precio unitario</th>
                    <th class="px-5 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pedido->detalles as $detalle)
                    <tr class="border-b">
                        <td class="px-5 py-4 text-sm">{{ $detalle->producto->nombre }}</td>
                        <td class="px-5 py-4 text-sm">{{ $detalle->cantidad }}</td>
                        <td class="px-5 py-4 text-sm">{{ number_format($detalle->precio_unitario,2) }} €</td>
                        <td class="px-5 py-4 text-sm">{{ number_format($detalle->subtotal,2) }} €</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <a href="{{ route('cliente.pedidos') }}"
       class="mt-6 inline-block text-green-600 hover:underline">
        ← Volver a Mis pedidos
    </a>
</div>
@endsection
