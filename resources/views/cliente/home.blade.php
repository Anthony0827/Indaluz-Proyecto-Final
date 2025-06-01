{{-- resources/views/cliente/home.blade.php --}}
@extends('layouts.cliente')

@section('title', 'Tienda')

@section('content')
<div class="container mx-auto px-4 py-6">
    {{-- Filtros --}}
    <div class="mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <form method="GET" action="{{ route('cliente.home') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- Categoría --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                        <select name="categoria"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                            <option value="">Todas las categorías</option>
                            <option value="fruta" {{ request('categoria') == 'fruta' ? 'selected' : '' }}>Frutas</option>
                            <option value="verdura" {{ request('categoria') == 'verdura' ? 'selected' : '' }}>Verduras</option>
                        </select>
                    </div>

                    {{-- Rango de precio --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Precio máximo</label>
                        <input type="number"
                               name="precio_max"
                               value="{{ request('precio_max') }}"
                               step="0.01"
                               placeholder="Ej: 10.00"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                    </div>

                    {{-- Frescura --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Frescura</label>
                        <select name="frescura"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                            <option value="">Cualquier tiempo</option>
                            <option value="hoy" {{ request('frescura') == 'hoy' ? 'selected' : '' }}>Recién cosechado</option>
                            <option value="semana" {{ request('frescura') == 'semana' ? 'selected' : '' }}>Esta semana</option>
                        </select>
                    </div>

                    {{-- Ordenar por --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ordenar por</label>
                        <select name="orden"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                            <option value="recientes" {{ request('orden') == 'recientes' ? 'selected' : '' }}>Más recientes</option>
                            <option value="precio_asc" {{ request('orden') == 'precio_asc' ? 'selected' : '' }}>Precio: menor a mayor</option>
                            <option value="precio_desc" {{ request('orden') == 'precio_desc' ? 'selected' : '' }}>Precio: mayor a menor</option>
                            <option value="nombre" {{ request('orden') == 'nombre' ? 'selected' : '' }}>Nombre</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        <i data-lucide="filter" class="w-4 h-4 inline mr-2"></i>
                        Aplicar Filtros
                    </button>
                    @if(request()->hasAny(['buscar', 'categoria', 'precio_max', 'frescura', 'orden']))
                        <a href="{{ route('cliente.home') }}"
                           class="text-gray-600 hover:text-gray-800">
                            <i data-lucide="x" class="w-4 h-4 inline mr-1"></i>
                            Limpiar filtros
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- Resultados de búsqueda --}}
    @if(request('buscar'))
        <div class="mb-4">
            <p class="text-gray-600">
                Resultados para: <span class="font-semibold">{{ request('buscar') }}</span>
                <span class="text-sm">({{ $productos->total() }} productos encontrados)</span>
            </p>
        </div>
    @endif

    {{-- Grid de productos --}}
    @if($productos->count() > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($productos as $producto)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                    <a href="{{ route('cliente.producto', $producto->id_producto) }}">
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

                            {{-- Badge de frescura --}}
                            <div class="absolute top-2 left-2">
                                <span class="bg-green-600 text-white px-2 py-1 rounded text-xs font-semibold">
                                    {{ $producto->tiempo_de_cosecha }}
                                </span>
                            </div>

                            {{-- Badge de categoría --}}
                            <div class="absolute top-2 right-2">
                                <span class="bg-gray-800 text-white px-2 py-1 rounded text-xs font-semibold">
                                    {{ ucfirst($producto->categoria) }}
                                </span>
                            </div>
                        </div>
                    </a>

                    <div class="p-4">
                        <h3 class="font-semibold text-lg text-gray-800 mb-1">
                            <a href="{{ route('cliente.producto', $producto->id_producto) }}"
                               class="hover:text-green-600 transition">
                                {{ $producto->nombre }}
                            </a>
                        </h3>

                        <p class="text-sm text-gray-600 mb-2">
                            Por <a href="{{ route('cliente.agricultor', $producto->agricultor->id_usuario) }}"
                                   class="text-green-600 hover:underline">
                                {{ $producto->agricultor->nombre_empresa ?? $producto->agricultor->nombre }}
                            </a>
                        </p>

                        <div class="flex justify-between items-center mb-3">
                            <div>
                                <span class="text-2xl font-bold text-green-600">
                                    {{ number_format($producto->precio, 2) }}€
                                </span>
                                <span class="text-sm text-gray-500">
                                    /{{ $producto->unidad_medida_texto }}
                                </span>
                            </div>
                            <div class="text-sm text-gray-600">
                                Stock: {{ $producto->cantidad_inventario }}
                            </div>
                        </div>

                        <button class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition add-to-cart"
                                data-id="{{ $producto->id_producto }}"
                                data-nombre="{{ $producto->nombre }}"
                                data-precio="{{ $producto->precio }}"
                                data-unidad="{{ $producto->unidad_medida_texto }}"
                                data-max="{{ $producto->cantidad_inventario }}">
                            <i data-lucide="shopping-cart" class="w-4 h-4 inline mr-2"></i>
                            Añadir al carrito
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="mt-8">
            {{ $productos->links() }}
        </div>
    @else
        {{-- Sin productos --}}
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <i data-lucide="package-x" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">No se encontraron productos</h3>
            <p class="text-gray-600 mb-4">
                @if(request()->hasAny(['buscar', 'categoria', 'precio_max', 'frescura']))
                    Intenta ajustar tus filtros de búsqueda
                @else
                    No hay productos disponibles en este momento
                @endif
            </p>
            @if(request()->hasAny(['buscar', 'categoria', 'precio_max', 'frescura']))
                <a href="{{ route('cliente.home') }}"
                   class="inline-flex items-center text-green-600 hover:text-green-700">
                    <i data-lucide="arrow-left" class="w-4 h-4 mr-2"></i>
                    Ver todos los productos
                </a>
            @endif
        </div>
    @endif
</div>

{{-- Sección de categorías destacadas --}}
<section class="py-12">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-gray-800 mb-8">Categorías</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <a href="{{ route('cliente.catalogo', ['categoria' => 'fruta']) }}"
               class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition group">
                <div class="w-20 h-20 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center group-hover:bg-red-200 transition">
                    <i data-lucide="apple" class="w-10 h-10 text-red-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Frutas</h3>
                <p class="text-sm text-gray-600 mt-1">Del huerto a tu mesa</p>
            </a>
            <a href="{{ route('cliente.catalogo', ['categoria' => 'verdura']) }}"
               class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition group">
                <div class="w-20 h-20 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition">
                    <i data-lucide="salad" class="w-10 h-10 text-green-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Verduras</h3>
                <p class="text-sm text-gray-600 mt-1">Frescas del campo</p>
            </a>
            <a href="{{ route('cliente.catalogo', ['frescura' => 'hoy']) }}"
               class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition group">
                <div class="w-20 h-20 mx-auto mb-4 bg-yellow-100 rounded-full flex items-center justify-center group-hover:bg-yellow-200 transition">
                    <i data-lucide="sun" class="w-10 h-10 text-yellow-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Recién Cosechado</h3>
                <p class="text-sm text-gray-600 mt-1">Del día</p>
            </a>
            <a href="{{ route('cliente.catalogo', ['orden' => 'precio_asc']) }}"
               class="bg-white rounded-lg shadow-md p-6 text-center hover:shadow-lg transition group">
                <div class="w-20 h-20 mx-auto mb-4 bg-purple-100 rounded-full flex items-center justify-center group-hover:bg-purple-200 transition">
                    <i data-lucide="tag" class="w-10 h-10 text-purple-600"></i>
                </div>
                <h3 class="font-semibold text-gray-800">Ofertas</h3>
                <p class="text-sm text-gray-600 mt-1">Mejores precios</p>
            </a>
        </div>
    </div>
</section>

{{-- Productos Recientes --}}
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Productos Recientes</h2>
            <a href="{{ route('cliente.catalogo') }}" class="text-green-600 hover:text-green-700 font-medium">
                Ver todos <i data-lucide="arrow-right" class="w-4 h-4 inline"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($productosRecientes as $producto)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition">
                    <a href="{{ route('cliente.producto', $producto->id_producto) }}">
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
                            <div class="absolute top-2 left-2">
                                <span class="bg-green-600 text-white px-2 py-1 rounded text-xs font-semibold">
                                    {{ $producto->tiempo_de_cosecha }}
                                </span>
                            </div>
                        </div>
                    </a>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-1">
                            <a href="{{ route('cliente.producto', $producto->id_producto) }}" class="hover:text-green-600">
                                {{ $producto->nombre }}
                            </a>
                        </h3>
                        <p class="text-sm text-gray-600 mb-2">
                            Por <a href="{{ route('cliente.agricultor', $producto->agricultor->id_usuario) }}"
                                   class="text-green-600 hover:underline">
                                {{ $producto->agricultor->nombre }}
                            </a>
                        </p>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-green-600">
                                {{ number_format($producto->precio, 2) }}€
                            </span>
                            <span class="text-sm text-gray-500">
                                /{{ $producto->unidad_medida_texto }}
                            </span>
                        </div>
                        <button class="w-full mt-3 bg-green-600 text-white py-2 rounded hover:bg-green-700 transition add-to-cart"
                                data-id="{{ $producto->id_producto }}"
                                data-nombre="{{ $producto->nombre }}"
                                data-precio="{{ $producto->precio }}">
                            <i data-lucide="shopping-cart" class="w-4 h-4 inline mr-1"></i>
                            Añadir
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Cómo Funciona --}}
<section id="como-funciona" class="py-16 bg-green-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">¿Cómo Funciona?</h2>
        <div class="grid md:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-green-600 rounded-full flex items-center justify-center text-white">
                    <i data-lucide="search" class="w-10 h-10"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">1. Busca</h3>
                <p class="text-gray-600">Explora productos frescos de agricultores locales</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-green-600 rounded-full flex items-center justify-center text-white">
                    <i data-lucide="shopping-cart" class="w-10 h-10"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">2. Compra</h3>
                <p class="text-gray-600">Añade productos a tu carrito y realiza el pedido</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-green-600 rounded-full flex items-center justify-center text-white">
                    <i data-lucide="credit-card" class="w-10 h-10"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">3. Paga</h3>
                <p class="text-gray-600">Paga con tarjeta o en efectivo al recoger</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 mx-auto mb-4 bg-green-600 rounded-full flex items-center justify-center text-white">
                    <i data-lucide="package" class="w-10 h-10"></i>
                </div>
                <h3 class="font-semibold text-lg mb-2">4. Recoge</h3>
                <p class="text-gray-600">Recoge tu pedido o recíbelo en casa</p>
            </div>
        </div>
    </div>
</section>

{{-- Agricultores Destacados --}}
<section class="py-12">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold text-gray-800">Agricultores Destacados</h2>
            <a href="{{ route('cliente.catalogo') }}" class="text-green-600 hover:text-green-700 font-medium">
                Ver todos <i data-lucide="arrow-right" class="w-4 h-4 inline"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($agricultoresDestacados as $agricultor)
                <a href="{{ route('cliente.agricultor', $agricultor->id_usuario) }}"
                   class="text-center group">
                    <div class="relative">
                        @if($agricultor->foto_perfil)
                            <img src="{{ $agricultor->foto_perfil_url }}"
                                 alt="{{ $agricultor->nombre }}"
                                 class="w-24 h-24 rounded-full mx-auto object-cover group-hover:ring-4 group-hover:ring-green-400 transition">
                        @else
                            <div class="w-24 h-24 rounded-full mx-auto bg-green-600 flex items-center justify-center text-white text-2xl font-bold group-hover:ring-4 group-hover:ring-green-400 transition">
                                {{ substr($agricultor->nombre, 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <h3 class="mt-3 font-semibold text-gray-800 group-hover:text-green-600 transition">
                        {{ $agricultor->nombre }}
                    </h3>
                    <p class="text-sm text-gray-600">
                        {{ $agricultor->productos_count }} productos
                    </p>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- Beneficios --}}
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">¿Por qué elegir Indaluz?</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <i data-lucide="leaf" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Productos Frescos</h3>
                <p class="text-gray-600">Directamente del campo a tu mesa, sin intermediarios</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <i data-lucide="users" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Apoyo Local</h3>
                <p class="text-gray-600">Ayudas a los agricultores locales y a la economía de Almería</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                    <i data-lucide="shield-check" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold mb-2">Garantía de Calidad</h3>
                <p class="text-gray-600">Productos seleccionados y agricultores verificados</p>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Gestión del carrito (localStorage)
    const carrito = {
        items: JSON.parse(localStorage.getItem('carrito') || '[]'),

        add(producto) {
            const existe = this.items.find(item => item.id === producto.id);
            if (existe) {
                if (existe.cantidad < producto.max) {
                    existe.cantidad++;
                } else {
                    alert('No hay más stock disponible');
                    return false;
                }
            } else {
                this.items.push({
                    id: producto.id,
                    nombre: producto.nombre,
                    precio: parseFloat(producto.precio),
                    unidad: producto.unidad,
                    cantidad: 1,
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
            // Actualizar contador
            const total = this.items.reduce((sum, item) => sum + item.cantidad, 0);
            document.querySelectorAll('.cart-count').forEach(el => {
                el.textContent = total;
            });

            // Actualizar dropdown del carrito
            const cartItems = document.getElementById('cart-items');
            if (cartItems) {
                if (this.items.length === 0) {
                    cartItems.innerHTML = '<p class="px-4 py-8 text-center text-gray-500">Tu carrito está vacío</p>';
                } else {
                    let html = '<div class="max-h-96 overflow-y-auto">';
                    this.items.forEach(item => {
                        html += `
                            <div class="px-4 py-3 border-b hover:bg-gray-50">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-sm">${item.nombre}</h4>
                                        <p class="text-xs text-gray-600">${item.cantidad} x ${item.precio.toFixed(2)}€/${item.unidad}</p>
                                    </div>
                                    <span class="font-semibold text-sm">${(item.cantidad * item.precio).toFixed(2)}€</span>
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    cartItems.innerHTML = html;
                }
            }
        }
    };

    // Inicializar UI del carrito
    carrito.updateUI();

    // Añadir al carrito
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const added = carrito.add({
                id: this.dataset.id,
                nombre: this.dataset.nombre,
                precio: this.dataset.precio,
                unidad: this.dataset.unidad,
                max: parseInt(this.dataset.max)
            });

            if (added) {
                // Animación de confirmación
                const originalText = this.innerHTML;
                this.innerHTML = '<i data-lucide="check" class="w-4 h-4 inline mr-2"></i>Añadido';
                this.classList.add('bg-green-700');

                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.remove('bg-green-700');
                    lucide.createIcons();
                }, 1500);
            }
        });
    });
});
</script>
@endpush
