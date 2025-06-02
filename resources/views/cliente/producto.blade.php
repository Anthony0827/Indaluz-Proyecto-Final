{{-- resources/views/cliente/producto.blade.php --}}
@extends('layouts.cliente')

@section('title', $producto->nombre)

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Breadcrumbs --}}
    <nav class="text-sm mb-6">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('cliente.home') }}" class="text-gray-500 hover:text-gray-700">Inicio</a>
                <i data-lucide="chevron-right" class="w-4 h-4 mx-2 text-gray-400"></i>
            </li>
            <li class="flex items-center">
                <a href="{{ route('cliente.home', ['categoria' => $producto->categoria]) }}" class="text-gray-500 hover:text-gray-700">
                    {{ ucfirst($producto->categoria) }}s
                </a>
                <i data-lucide="chevron-right" class="w-4 h-4 mx-2 text-gray-400"></i>
            </li>
            <li class="text-gray-700">{{ $producto->nombre }}</li>
        </ol>
    </nav>

    {{-- Producto principal --}}
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <div class="grid md:grid-cols-2 gap-8">
            {{-- Imagen del producto --}}
            <div>
                <div class="relative rounded-lg overflow-hidden bg-gray-100">
                    @if($producto->imagen)
                        <img src="{{ asset('storage/' . $producto->imagen) }}" 
                             alt="{{ $producto->nombre }}"
                             class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 flex items-center justify-center text-gray-400">
                            <i data-lucide="image-off" class="w-24 h-24"></i>
                        </div>
                    @endif
                    
                    {{-- Badges --}}
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        <span class="bg-green-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            {{ $producto->tiempo_de_cosecha }}
                        </span>
                        <span class="bg-gray-800 text-white px-3 py-1 rounded-full text-sm font-semibold">
                            {{ ucfirst($producto->categoria) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Información del producto --}}
            <div>
                <h1 class="text-3xl font-bold text-gray-800 mb-4">{{ $producto->nombre }}</h1>
                
                {{-- Agricultor --}}
                <div class="flex items-center mb-4">
                    <p class="text-gray-600">
                        Vendido por: 
                        <a href="{{ route('cliente.agricultor', $producto->agricultor->id_usuario) }}" 
                           class="text-green-600 hover:text-green-700 font-semibold">
                            {{ $producto->agricultor->nombre_empresa ?? $producto->agricultor->nombre . ' ' . $producto->agricultor->apellido }}
                        </a>
                    </p>
                    @if($producto->agricultor->verificado)
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 ml-2" title="Agricultor verificado"></i>
                    @endif
                </div>

                {{-- Precio --}}
                <div class="mb-6">
                    <div class="flex items-baseline gap-2">
                        <span class="text-4xl font-bold text-green-600">{{ number_format($producto->precio, 2) }}€</span>
                        <span class="text-lg text-gray-600">/ {{ $producto->unidad_medida_texto }}</span>
                    </div>
                </div>

                {{-- Descripción --}}
                @if($producto->descripcion)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold mb-2">Descripción</h3>
                        <p class="text-gray-700 leading-relaxed">{{ $producto->descripcion }}</p>
                    </div>
                @endif

                {{-- Disponibilidad --}}
                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-gray-600">Disponibilidad:</span>
                        @if($producto->cantidad_inventario > 0)
                            <span class="text-green-600 font-semibold">En stock ({{ $producto->cantidad_inventario }} {{ $producto->unidad_medida_texto }})</span>
                        @else
                            <span class="text-red-600 font-semibold">Sin stock</span>
                        @endif
                    </div>
                    @if($producto->agricultor->municipio)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Ubicación:</span>
                            <span class="text-gray-700">{{ $producto->agricultor->municipio }}, {{ $producto->agricultor->provincia ?? 'Almería' }}</span>
                        </div>
                    @endif
                </div>

                {{-- Selector de cantidad y botón de compra --}}
                @if($producto->cantidad_inventario > 0)
                    <div class="flex items-center gap-4 mb-6">
                        <div class="flex items-center border border-gray-300 rounded-lg">
                            <button type="button" 
                                    class="px-4 py-2 text-gray-600 hover:text-gray-800 decrease-qty"
                                    data-max="{{ $producto->cantidad_inventario }}">
                                <i data-lucide="minus" class="w-4 h-4"></i>
                            </button>
                            <input type="number" 
                                   id="cantidad" 
                                   value="1" 
                                   min="1" 
                                   max="{{ $producto->cantidad_inventario }}"
                                   class="w-16 text-center border-0 focus:outline-none"
                                   readonly>
                            <button type="button" 
                                    class="px-4 py-2 text-gray-600 hover:text-gray-800 increase-qty"
                                    data-max="{{ $producto->cantidad_inventario }}">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                            </button>
                        </div>
                        <button class="flex-1 bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition font-semibold add-to-cart-detail"
                                data-id="{{ $producto->id_producto }}"
                                data-nombre="{{ $producto->nombre }}"
                                data-precio="{{ $producto->precio }}"
                                data-unidad="{{ $producto->unidad_medida_texto }}"
                                data-max="{{ $producto->cantidad_inventario }}">
                            <i data-lucide="shopping-cart" class="w-5 h-5 inline mr-2"></i>
                            Añadir al carrito
                        </button>
                    </div>
                @else
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                        <p class="text-red-600 font-semibold">Producto no disponible</p>
                        <p class="text-red-500 text-sm">Este producto está temporalmente sin stock</p>
                    </div>
                @endif

                {{-- Información adicional --}}
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold mb-3">Información adicional</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600">Categoría:</span>
                            <span class="text-gray-800 font-medium ml-2">{{ ucfirst($producto->categoria) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Tiempo de cosecha:</span>
                            <span class="text-gray-800 font-medium ml-2">{{ $producto->tiempo_de_cosecha }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Unidad de venta:</span>
                            <span class="text-gray-800 font-medium ml-2">{{ $producto->unidad_medida_texto }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600">Precio por unidad:</span>
                            <span class="text-gray-800 font-medium ml-2">{{ number_format($producto->precio, 2) }}€</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Información del agricultor --}}
    <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
        <h2 class="text-2xl font-bold mb-4">Sobre el agricultor</h2>
        <div class="flex items-start gap-6">
            <div class="flex-shrink-0">
                @if($producto->agricultor->foto_perfil)
                    <img src="{{ $producto->agricultor->foto_perfil_url }}" 
                         alt="{{ $producto->agricultor->nombre }}"
                         class="w-24 h-24 rounded-full object-cover">
                @else
                    <div class="w-24 h-24 rounded-full bg-green-600 flex items-center justify-center text-white text-2xl font-bold">
                        {{ substr($producto->agricultor->nombre, 0, 1) }}
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <h3 class="text-xl font-semibold mb-2">
                    {{ $producto->agricultor->nombre_empresa ?? $producto->agricultor->nombre . ' ' . $producto->agricultor->apellido }}
                </h3>
                @if($producto->agricultor->descripcion_publica)
                    <p class="text-gray-700 mb-3">{{ Str::limit($producto->agricultor->descripcion_publica, 200) }}</p>
                @endif
                <div class="flex items-center gap-6 text-sm text-gray-600">
                    @if($producto->agricultor->anos_experiencia)
                        <div class="flex items-center gap-1">
                            <i data-lucide="award" class="w-4 h-4"></i>
                            <span>{{ $producto->agricultor->anos_experiencia }} años de experiencia</span>
                        </div>
                    @endif
                    <div class="flex items-center gap-1">
                        <i data-lucide="package" class="w-4 h-4"></i>
                        <span>{{ $producto->agricultor->productos_count ?? 0 }} productos</span>
                    </div>
                </div>
                <a href="{{ route('cliente.agricultor', $producto->agricultor->id_usuario) }}" 
                   class="inline-flex items-center mt-3 text-green-600 hover:text-green-700 font-medium">
                    Ver perfil completo
                    <i data-lucide="arrow-right" class="w-4 h-4 ml-1"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Productos relacionados --}}
    @if($similares->count() > 0 || $producto->agricultor->productos->count() > 0)
        <div class="mb-8">
            <h2 class="text-2xl font-bold mb-6">También te puede interesar</h2>
            
            {{-- Tabs --}}
            <div class="border-b border-gray-200 mb-6">
                <nav class="-mb-px flex space-x-8">
                    <button type="button" 
                            onclick="showRelatedTab('similares')"
                            id="tab-similares"
                            class="related-tab border-b-2 border-green-500 py-2 px-1 text-sm font-medium text-green-600">
                        Productos similares
                    </button>
                    <button type="button"
                            onclick="showRelatedTab('agricultor')"
                            id="tab-agricultor"
                            class="related-tab border-b-2 border-transparent py-2 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                        Más de este agricultor
                    </button>
                </nav>
            </div>

            {{-- Productos similares --}}
            <div id="content-similares" class="related-content">
                @if($similares->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($similares as $similar)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                                <a href="{{ route('cliente.producto', $similar->id_producto) }}">
                                    <div class="relative h-48 bg-gray-200">
                                        @if($similar->imagen)
                                            <img src="{{ asset('storage/' . $similar->imagen) }}" 
                                                 alt="{{ $similar->nombre }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <i data-lucide="image-off" class="w-12 h-12"></i>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-800 mb-1">
                                        <a href="{{ route('cliente.producto', $similar->id_producto) }}" class="hover:text-green-600">
                                            {{ $similar->nombre }}
                                        </a>
                                    </h3>
                                    <p class="text-lg font-bold text-green-600">
                                        {{ number_format($similar->precio, 2) }}€
                                        <span class="text-sm text-gray-500 font-normal">/{{ $similar->unidad_medida_texto }}</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No hay productos similares disponibles</p>
                @endif
            </div>

            {{-- Más del agricultor --}}
            <div id="content-agricultor" class="related-content hidden">
                @if($producto->agricultor->productos->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        @foreach($producto->agricultor->productos as $otroProducto)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                                <a href="{{ route('cliente.producto', $otroProducto->id_producto) }}">
                                    <div class="relative h-48 bg-gray-200">
                                        @if($otroProducto->imagen)
                                            <img src="{{ asset('storage/' . $otroProducto->imagen) }}" 
                                                 alt="{{ $otroProducto->nombre }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <i data-lucide="image-off" class="w-12 h-12"></i>
                                            </div>
                                        @endif
                                    </div>
                                </a>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-800 mb-1">
                                        <a href="{{ route('cliente.producto', $otroProducto->id_producto) }}" class="hover:text-green-600">
                                            {{ $otroProducto->nombre }}
                                        </a>
                                    </h3>
                                    <p class="text-lg font-bold text-green-600">
                                        {{ number_format($otroProducto->precio, 2) }}€
                                        <span class="text-sm text-gray-500 font-normal">/{{ $otroProducto->unidad_medida_texto }}</span>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">Este agricultor no tiene más productos disponibles</p>
                @endif
            </div>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Control de cantidad
    const cantidadInput = document.getElementById('cantidad');
    const decreaseBtn = document.querySelector('.decrease-qty');
    const increaseBtn = document.querySelector('.increase-qty');

    if (decreaseBtn && increaseBtn) {
        decreaseBtn.addEventListener('click', function() {
            let cantidad = parseInt(cantidadInput.value);
            if (cantidad > 1) {
                cantidadInput.value = cantidad - 1;
            }
        });

        increaseBtn.addEventListener('click', function() {
            let cantidad = parseInt(cantidadInput.value);
            let max = parseInt(this.dataset.max);
            if (cantidad < max) {
                cantidadInput.value = cantidad + 1;
            }
        });
    }

    // Añadir al carrito con cantidad específica
    const addToCartBtn = document.querySelector('.add-to-cart-detail');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const cantidad = parseInt(cantidadInput.value);
            const producto = {
                id: this.dataset.id,
                nombre: this.dataset.nombre,
                precio: this.dataset.precio,
                unidad: this.dataset.unidad,
                max: parseInt(this.dataset.max),
                cantidad: cantidad
            };

            // Usar el mismo sistema de carrito que en la página principal
            const carrito = {
                items: JSON.parse(localStorage.getItem('carrito') || '[]'),
                
                add(producto) {
                    const existe = this.items.find(item => item.id === producto.id);
                    if (existe) {
                        if (existe.cantidad + producto.cantidad <= producto.max) {
                            existe.cantidad += producto.cantidad;
                        } else {
                            alert(`Solo puedes añadir ${producto.max - existe.cantidad} más de este producto`);
                            return false;
                        }
                    } else {
                        this.items.push({
                            id: producto.id,
                            nombre: producto.nombre,
                            precio: parseFloat(producto.precio),
                            unidad: producto.unidad,
                            cantidad: producto.cantidad,
                            max: producto.max
                        });
                    }
                    this.save();
                    this.updateUI();
                    return true;
                },
                
                save() {
                    localStorage.setItem('carrito', JSON.stringify(this.items));
                },
                
                updateUI() {
                    const total = this.items.reduce((sum, item) => sum + item.cantidad, 0);
                    document.querySelectorAll('.cart-count').forEach(el => {
                        el.textContent = total;
                    });
                }
            };

            if (carrito.add(producto)) {
                // Animación de confirmación
                const originalText = this.innerHTML;
                this.innerHTML = '<i data-lucide="check" class="w-5 h-5 inline mr-2"></i>Añadido al carrito';
                this.classList.add('bg-green-700');
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.remove('bg-green-700');
                    lucide.createIcons();
                }, 2000);
            }
        });
    }
});

// Función para cambiar tabs de productos relacionados
function showRelatedTab(tabName) {
    // Ocultar todos los contenidos
    document.querySelectorAll('.related-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Resetear estilos de todos los tabs
    document.querySelectorAll('.related-tab').forEach(tab => {
        tab.classList.remove('border-green-500', 'text-green-600');
        tab.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Mostrar el contenido seleccionado
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Activar el tab seleccionado
    const activeTab = document.getElementById('tab-' + tabName);
    activeTab.classList.remove('border-transparent', 'text-gray-500');
    activeTab.classList.add('border-green-500', 'text-green-600');
}
</script>
@endpush
@endsection