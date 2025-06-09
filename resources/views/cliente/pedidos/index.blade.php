{{-- resources/views/cliente/pedidos/index.blade.php --}}
@extends('layouts.cliente')

@section('title', 'Mis pedidos')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Mis pedidos</h2>

    @if($pedidos->count())
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-700 uppercase">ID Pedido</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Fecha</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Total</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Estado</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Acciones</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-gray-700 uppercase">Reseña</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pedidos as $pedido)
                        @php
                            $resena = \App\Models\Reseña::where('id_pedido', $pedido->id_pedido)
                                        ->where('id_cliente', auth()->id())
                                        ->first();
                        @endphp
                        <tr class="border-b">
                            <td class="px-5 py-4 text-sm">{{ $pedido->id_pedido }}</td>
                            <td class="px-5 py-4 text-sm">{{ $pedido->fecha_pedido->format('d/m/Y H:i') }}</td>
                            <td class="px-5 py-4 text-sm font-semibold">{{ number_format($pedido->total,2) }} €</td>
                            <td class="px-5 py-4 text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $pedido->estado == 'entregado'
                                        ? 'bg-green-100 text-green-800'
                                        : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($pedido->estado) }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm">
                                <a href="{{ route('cliente.pedidos.show', $pedido->id_pedido) }}"
                                   class="text-green-600 hover:underline">Ver detalle</a>
                            </td>
                            <td class="px-5 py-4 text-sm">
                                <div x-data="{ modalOpen: false, rating: {{ $resena->rating ?? 0 }}, hoverRating: 0 }">
                                    <button @click="modalOpen = true"
                                            class="font-medium hover:underline {{ $resena ? 'text-yellow-600' : 'text-green-600' }}">
                                        {{ $resena ? 'Editar' : 'Escribir' }} reseña
                                    </button>

                                    {{-- Modal reseña --}}
                                    <div
                                        x-show="modalOpen"
                                        x-cloak
                                        @click.away="modalOpen = false"
                                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50"
                                    >
                                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                                            <h3 class="text-lg font-semibold mb-4">
                                                {{ $resena ? 'Editar reseña' : 'Escribir reseña' }}
                                            </h3>
                                            <form action="{{ $resena
                                                              ? route('cliente.pedidos.reseña.update', $pedido->id_pedido)
                                                              : route('cliente.pedidos.reseña.store',  $pedido->id_pedido) }}"
                                                  method="POST">
                                                @csrf
                                                @if($resena) @method('PUT') @endif

                                                {{-- Puntuación --}}
                                                <div class="mb-4">
                                                    <label class="block text-sm mb-1">Puntuación</label>
                                                    <div class="flex space-x-1" @mouseleave="hoverRating = 0">
                                                        <template x-for="i in 5" :key="i">
                                                            <button type="button"
                                                                    class="focus:outline-none transform transition hover:scale-110 active:scale-125"
                                                                    @mouseover="hoverRating = i"
                                                                    @click="rating = i"
                                                            >
                                                                <i data-lucide="star"
                                                                   class="w-6 h-6 transition-colors duration-150"
                                                                   :class="{
                                                                     'text-yellow-500': i <= (hoverRating || rating),
                                                                     'text-gray-300': i > (hoverRating || rating)
                                                                   }"></i>
                                                            </button>
                                                        </template>
                                                        <input type="hidden" name="rating" x-model="rating">
                                                    </div>
                                                </div>

                                                {{-- Comentario --}}
                                                <div class="mb-4">
                                                    <label class="block text-sm mb-1">Comentario</label>
                                                    <textarea name="comentario"
                                                              rows="3"
                                                              class="w-full border border-gray-300 rounded-lg px-3 py-2">{{ $resena->comentario ?? '' }}</textarea>
                                                </div>

                                                {{-- Botones --}}
                                                <div class="flex justify-end space-x-2">
                                                    <button type="button"
                                                            @click="modalOpen = false"
                                                            class="px-4 py-2 border rounded">
                                                        Cancelar
                                                    </button>
                                                    <button type="submit"
                                                            class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                                        {{ $resena ? 'Actualizar' : 'Enviar' }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-6">
            {{ $pedidos->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-600">Aún no has realizado ningún pedido.</p>
            <a href="{{ route('cliente.home') }}"
               class="mt-4 inline-block text-green-600 hover:underline">
                Volver a la tienda
            </a>
        </div>
    @endif
</div>
@endsection
