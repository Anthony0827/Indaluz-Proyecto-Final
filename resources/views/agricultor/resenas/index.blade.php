{{-- resources/views/agricultor/resenas/index.blade.php --}}
@extends('layouts.agricultor')

@section('header', 'Reseñas de Clientes')

@section('content')
<div class="container mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Reseñas</h2>
    </div>

    @if($resenas->count())
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr class="bg-green-100">
                        <th class="px-5 py-3 text-left text-xs font-semibold text-green-800 uppercase">ID</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-green-800 uppercase">Pedido</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-green-800 uppercase">Cliente</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-green-800 uppercase">Fecha</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-green-800 uppercase">Puntuación</th>
                        <th class="px-5 py-3 text-left text-xs font-semibold text-green-800 uppercase">Comentario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resenas as $resena)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-5 py-4 text-sm text-gray-700">{{ $resena->id_reseña }}</td>
                            <td class="px-5 py-4 text-sm text-gray-700">
                                <a href="{{ route('agricultor.pedidos.index') }}#pedido-{{ $resena->id_pedido }}"
                                   class="text-green-600 hover:underline">
                                    #{{ $resena->id_pedido }}
                                </a>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-700">{{ $resena->cliente->nombre }}</td>
                            <td class="px-5 py-4 text-sm text-gray-700">
                                {{ $resena->fecha_reseña->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-5 py-4 text-sm">
                                <div class="flex space-x-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i data-lucide="star"
                                           class="w-5 h-5 {{ $i <= $resena->rating ? 'text-yellow-500' : 'text-gray-300' }}">
                                        </i>
                                    @endfor
                                </div>
                            </td>
                            <td class="px-5 py-4 text-sm text-gray-700">{{ $resena->comentario }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $resenas->links() }}
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-600">No hay reseñas aún.</p>
        </div>
    @endif
</div>
@endsection
