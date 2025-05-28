{{-- resources/views/agricultor/productos/index.blade.php --}}
@extends('layouts.agricultor')

@section('title', 'Mis Productos')
@section('header', 'Gestión de Productos')

@section('content')
<div class="space-y-6">
    {{-- Encabezado con botón de añadir --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Mis Productos</h2>
            <p class="text-gray-600 mt-1">Gestiona tu catálogo de productos</p>
        </div>
        <a href="{{ route('agricultor.productos.create') }}" 
           class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition flex items-center gap-2">
            <i data-lucide="plus-circle" class="w-5 h-5"></i>
            <span>Añadir Producto</span>
        </a>
    </div>

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow p-4">
        <form method="GET" action="{{ route('agricultor.productos.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" 
                       name="buscar" 
                       value="{{ request('buscar') }}"
                       placeholder="Buscar productos..." 
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
            </div>
            <select name="categoria" 
                    class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                <option value="">Todas las categorías</option>
                <option value="fruta" {{ request('categoria') == 'fruta' ? 'selected' : '' }}>Frutas</option>
                <option value="verdura" {{ request('categoria') == 'verdura' ? 'selected' : '' }}>Verduras</option>
            </select>
            <select name="estado" 
                    class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                <option value="">Todos los estados</option>
                <option value="activo" {{ request('estado') == 'activo' ? 'selected' : '' }}>Activos</option>
                <option value="inactivo" {{ request('estado') == 'inactivo' ? 'selected' : '' }}>Inactivos</option>
            </select>
            <button type="submit" 
                    class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition">
                Filtrar
            </button>
            @if(request()->hasAny(['buscar', 'categoria', 'estado']))
                <a href="{{ route('agricultor.productos.index') }}" 
                   class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    Limpiar
                </a>
            @endif
        </form>
    </div>

    {{-- Grid de productos --}}
    @if($productos->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($productos as $producto)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    {{-- Imagen del producto --}}
                    <div class="relative h-48 bg-gray-200">
                        @if($producto->imagen)
                            <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                 alt="{{ $producto->nombre }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i data-lucide="image-off" class="w-12 h-12"></i>
                            </div>
                        @endif
                        
                        {{-- Badge de estado --}}
                        <div class="absolute top-2 right-2">
                            @if($producto->estado == 'activo')
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">
                                    Activo
                                </span>
                            @else
                                <span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-semibold">
                                    Inactivo
                                </span>
                            @endif
                        </div>

                        {{-- Badge de categoría --}}
                        <div class="absolute top-2 left-2">
                            <span class="bg-gray-800 text-white px-2 py-1 rounded-full text-xs font-semibold">
                                {{ ucfirst($producto->categoria) }}
                            </span>
                        </div>
                    </div>

                    {{-- Información del producto --}}
                    <div class="p-4">
                        <h3 class="font-semibold text-lg text-gray-800 mb-2">{{ $producto->nombre }}</h3>
                        
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>Precio:</span>
                                <span class="font-semibold text-green-600">{{ number_format($producto->precio, 2) }}€</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Stock:</span>
                                <span class="font-semibold {{ $producto->cantidad_inventario > 10 ? 'text-green-600' : 'text-orange-600' }}">
                                    {{ $producto->cantidad_inventario }} unidades
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span>Cosecha:</span>
                                <span class="text-gray-700">{{ $producto->tiempo_de_cosecha }}</span>
                            </div>
                        </div>

                        {{-- Actualización rápida de stock --}}
                        <div class="mt-4 border-t pt-4">
                            <form class="stock-update-form flex gap-2" data-id="{{ $producto->id_producto }}">
                                @csrf
                                <input type="number" 
                                       name="cantidad" 
                                       value="{{ $producto->cantidad_inventario }}"
                                       min="0" 
                                       max="99999"
                                       class="flex-1 px-2 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:border-green-500">
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700 transition">
                                    <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                                </button>
                            </form>
                        </div>

                        {{-- Acciones --}}
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('agricultor.productos.edit', $producto->id_producto) }}" 
                               class="flex-1 bg-gray-600 text-white text-center py-2 rounded text-sm hover:bg-gray-700 transition">
                                Editar
                            </a>
                            @if($producto->estado == 'activo')
                                <form method="POST" 
                                      action="{{ route('agricultor.productos.destroy', $producto->id_producto) }}"
                                      onsubmit="return confirm('¿Estás seguro de desactivar este producto?')"
                                      class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full bg-red-600 text-white py-2 rounded text-sm hover:bg-red-700 transition">
                                        Desactivar
                                    </button>
                                </form>
                            @else
                                <form method="POST" 
                                      action="{{ route('agricultor.productos.reactivate', $producto->id_producto) }}"
                                      class="flex-1">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full bg-green-600 text-white py-2 rounded text-sm hover:bg-green-700 transition">
                                        Reactivar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="mt-8">
            {{ $productos->links() }}
        </div>
    @else
        {{-- Mensaje cuando no hay productos --}}
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i data-lucide="package-x" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">No tienes productos</h3>
            <p class="text-gray-600 mb-6">Empieza añadiendo tu primer producto para comenzar a vender</p>
            <a href="{{ route('agricultor.productos.create') }}" 
               class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                <i data-lucide="plus-circle" class="w-5 h-5"></i>
                <span>Añadir mi primer producto</span>
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Reinicializar iconos
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Actualización rápida de stock
    document.querySelectorAll('.stock-update-form').forEach(form => {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const productId = this.dataset.id;
            const cantidad = this.querySelector('input[name="cantidad"]').value;
            const button = this.querySelector('button[type="submit"]');
            const originalContent = button.innerHTML;
            
            // Mostrar loading
            button.innerHTML = '<i data-lucide="loader" class="w-4 h-4 animate-spin"></i>';
            button.disabled = true;
            
            try {
                const response = await fetch(`/agricultor/productos/${productId}/stock`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ cantidad })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    // Mostrar éxito temporalmente
                    button.innerHTML = '<i data-lucide="check" class="w-4 h-4"></i>';
                    button.classList.remove('bg-blue-600', 'hover:bg-blue-700');
                    button.classList.add('bg-green-600');
                    
                    setTimeout(() => {
                        button.innerHTML = originalContent;
                        button.classList.remove('bg-green-600');
                        button.classList.add('bg-blue-600', 'hover:bg-blue-700');
                        button.disabled = false;
                        lucide.createIcons();
                    }, 2000);
                }
            } catch (error) {
                console.error('Error:', error);
                button.innerHTML = originalContent;
                button.disabled = false;
                lucide.createIcons();
                alert('Error al actualizar el stock');
            }
        });
    });
});
</script>
@endpush
@endsection