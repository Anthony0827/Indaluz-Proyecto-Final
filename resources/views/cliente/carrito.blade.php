{{-- resources/views/cliente/carrito.blade.php --}}
@extends('layouts.cliente')

@section('title', 'Mi Carrito')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Mi Carrito de Compras</h1>

    {{-- Contenedor del carrito --}}
    <div id="carrito-container" class="grid lg:grid-cols-3 gap-8">
        {{-- Lista de productos --}}
        <div class="lg:col-span-2">
            <div id="productos-carrito" class="bg-white rounded-lg shadow">
                {{-- Se llenará dinámicamente con JavaScript --}}
                <div class="p-8 text-center text-gray-500">
                    <div class="animate-pulse">
                        <div class="h-4 bg-gray-200 rounded w-1/2 mx-auto mb-4"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/3 mx-auto"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Resumen del pedido --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                <h2 class="text-xl font-semibold mb-4">Resumen del pedido</h2>
                
                <div id="resumen-carrito" class="space-y-3">
                    {{-- Se llenará dinámicamente con JavaScript --}}
                </div>

                <div class="border-t mt-4 pt-4">
                    <div class="flex justify-between text-lg font-semibold">
                        <span>Total</span>
                        <span id="total-carrito">0.00€</span>
                    </div>
                </div>

                <button id="proceder-pago" 
                        class="w-full mt-6 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-semibold disabled:bg-gray-400 disabled:cursor-not-allowed"
                        disabled>
                    Proceder al pago
                </button>

                <a href="{{ route('cliente.home') }}" 
                   class="block text-center mt-4 text-green-600 hover:text-green-700">
                    Continuar comprando
                </a>
            </div>
        </div>
    </div>

    {{-- Productos recomendados --}}
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">También te puede interesar</h2>
        <div id="productos-recomendados" class="grid grid-cols-2 md:grid-cols-4 gap-6">
            {{-- Se puede llenar con productos aleatorios --}}
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestión del carrito
    const carritoManager = {
        items: [],
        
        init() {
            this.loadFromStorage();
            this.render();
            this.validarCarrito();
        },
        
        loadFromStorage() {
            try {
                const stored = localStorage.getItem('carrito');
                this.items = stored ? JSON.parse(stored) : [];
                // Asegurar que items sea siempre un array
                if (!Array.isArray(this.items)) {
                    this.items = [];
                }
            } catch (e) {
                console.error('Error loading cart:', e);
                this.items = [];
            }
        },
        
        saveToStorage() {
            try {
                localStorage.setItem('carrito', JSON.stringify(this.items));
                this.updateCartCount();
                // Actualizar también el dropdown del header si existe
                this.updateHeaderCart();
            } catch (e) {
                console.error('Error saving cart:', e);
            }
        },
        
        updateCartCount() {
            const total = this.items.reduce((sum, item) => sum + (item.cantidad || 0), 0);
            document.querySelectorAll('.cart-count').forEach(el => {
                el.textContent = total;
            });
        },
        
        updateHeaderCart() {
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
                                        <p class="text-xs text-gray-600">${item.cantidad} x ${parseFloat(item.precio).toFixed(2)}€/${item.unidad || 'unidad'}</p>
                                    </div>
                                    <span class="font-semibold text-sm">${(item.cantidad * parseFloat(item.precio)).toFixed(2)}€</span>
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    cartItems.innerHTML = html;
                }
            }
        },
        
        async validarCarrito() {
            if (this.items.length === 0) return;
            
            try {
                const response = await fetch('{{ route("cliente.carrito.validar") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ items: this.items })
                });
                
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                
                const data = await response.json();
                
                if (data.productos) {
                    // Actualizar items con información validada
                    this.items = data.productos;
                    this.saveToStorage();
                    this.render();
                }
                
                if (data.errores && data.errores.length > 0) {
                    // Mostrar errores
                    data.errores.forEach(error => {
                        this.showNotification(error, 'error');
                    });
                }
            } catch (error) {
                console.error('Error validando carrito:', error);
            }
        },
        
        updateQuantity(id, cantidad) {
            const itemIndex = this.items.findIndex(i => i.id == id);
            if (itemIndex !== -1) {
                const item = this.items[itemIndex];
                const newQuantity = Math.max(1, Math.min(cantidad, item.max || 99));
                this.items[itemIndex].cantidad = newQuantity;
                this.saveToStorage();
                this.render();
            }
        },
        
        removeItem(id) {
            // Filtrar el item que queremos eliminar
            const originalLength = this.items.length;
            this.items = this.items.filter(item => item.id != id);
            
            // Verificar que realmente se eliminó
            if (this.items.length < originalLength) {
                this.saveToStorage();
                this.render();
                this.showNotification('Producto eliminado del carrito', 'success');
            } else {
                console.error('No se pudo eliminar el producto con id:', id);
            }
        },
        
        clearCart() {
            if (confirm('¿Estás seguro de vaciar el carrito?')) {
                this.items = [];
                this.saveToStorage();
                this.render();
                this.showNotification('Carrito vaciado', 'success');
            }
        },
        
        calculateTotal() {
            return this.items.reduce((sum, item) => {
                const precio = parseFloat(item.precio) || 0;
                const cantidad = parseInt(item.cantidad) || 0;
                return sum + (precio * cantidad);
            }, 0);
        },
        
        render() {
            const container = document.getElementById('productos-carrito');
            const resumen = document.getElementById('resumen-carrito');
            const total = document.getElementById('total-carrito');
            const btnPago = document.getElementById('proceder-pago');
            
            if (!container || !resumen || !total || !btnPago) {
                console.error('Elementos del carrito no encontrados');
                return;
            }
            
            if (this.items.length === 0) {
                container.innerHTML = `
                    <div class="p-12 text-center">
                        <i data-lucide="shopping-cart" class="w-16 h-16 text-gray-400 mx-auto mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Tu carrito está vacío</h3>
                        <p class="text-gray-600 mb-6">Agrega algunos productos frescos para empezar</p>
                        <a href="{{ route('cliente.home') }}" 
                           class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                            <i data-lucide="arrow-left" class="w-5 h-5"></i>
                            Ir a comprar
                        </a>
                    </div>
                `;
                resumen.innerHTML = '<p class="text-gray-500 text-center">No hay productos</p>';
                total.textContent = '0.00€';
                btnPago.disabled = true;
            } else {
                // Renderizar productos
                let htmlProductos = `
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h2 class="text-lg font-semibold">Productos (${this.items.length})</h2>
                            <button onclick="window.carritoManager.clearCart()" 
                                    class="text-red-600 hover:text-red-700 text-sm">
                                Vaciar carrito
                            </button>
                        </div>
                        <div class="space-y-4">
                `;
                
                this.items.forEach(item => {
                    const precio = parseFloat(item.precio) || 0;
                    const cantidad = parseInt(item.cantidad) || 1;
                    const max = parseInt(item.max) || 99;
                    
                    htmlProductos += `
                        <div class="flex gap-4 p-4 border rounded-lg ${item.precio_cambio ? 'border-yellow-400 bg-yellow-50' : ''}">
                            <div class="w-24 h-24 bg-gray-200 rounded-lg overflow-hidden flex-shrink-0">
                                ${item.imagen 
                                    ? `<img src="${item.imagen}" alt="${item.nombre}" class="w-full h-full object-cover">`
                                    : '<div class="w-full h-full flex items-center justify-center text-gray-400"><i data-lucide="image-off" class="w-8 h-8"></i></div>'
                                }
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800">${item.nombre}</h3>
                                <p class="text-sm text-gray-600">Vendido por: ${item.agricultor || 'Agricultor'}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="text-green-600 font-semibold">
                                        ${precio.toFixed(2)}€/${item.unidad || 'unidad'}
                                    </span>
                                    ${item.precio_cambio ? `
                                        <span class="text-sm text-yellow-600">
                                            (Precio actualizado)
                                        </span>
                                    ` : ''}
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="flex items-center border rounded-lg">
                                    <button onclick="window.carritoManager.updateQuantity('${item.id}', ${cantidad - 1})"
                                            class="px-3 py-1 hover:bg-gray-100 ${cantidad <= 1 ? 'opacity-50 cursor-not-allowed' : ''}"
                                            ${cantidad <= 1 ? 'disabled' : ''}>
                                        <i data-lucide="minus" class="w-4 h-4"></i>
                                    </button>
                                    <input type="number" 
                                           value="${cantidad}" 
                                           min="1" 
                                           max="${max}"
                                           onchange="window.carritoManager.updateQuantity('${item.id}', parseInt(this.value))"
                                           class="w-16 text-center border-0 focus:outline-none">
                                    <button onclick="window.carritoManager.updateQuantity('${item.id}', ${cantidad + 1})"
                                            class="px-3 py-1 hover:bg-gray-100 ${cantidad >= max ? 'opacity-50 cursor-not-allowed' : ''}"
                                            ${cantidad >= max ? 'disabled' : ''}>
                                        <i data-lucide="plus" class="w-4 h-4"></i>
                                    </button>
                                </div>
                                <button onclick="window.carritoManager.removeItem('${item.id}')"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded">
                                    <i data-lucide="trash-2" class="w-5 h-5"></i>
                                </button>
                            </div>
                        </div>
                    `;
                });
                
                htmlProductos += `
                        </div>
                    </div>
                `;
                
                container.innerHTML = htmlProductos;
                
                // Renderizar resumen
                let htmlResumen = '';
                this.items.forEach(item => {
                    const precio = parseFloat(item.precio) || 0;
                    const cantidad = parseInt(item.cantidad) || 1;
                    const subtotal = precio * cantidad;
                    
                    htmlResumen += `
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">${item.nombre} x${cantidad}</span>
                            <span class="font-medium">${subtotal.toFixed(2)}€</span>
                        </div>
                    `;
                });
                resumen.innerHTML = htmlResumen;
                
                // Actualizar total
                const totalAmount = this.calculateTotal();
                total.textContent = totalAmount.toFixed(2) + '€';
                btnPago.disabled = false;
            }
            
            // Reinicializar iconos de Lucide
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        },
        
        showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                type === 'error' ? 'bg-red-100 text-red-800' : 
                type === 'success' ? 'bg-green-100 text-green-800' : 
                'bg-blue-100 text-blue-800'
            }`;
            notification.innerHTML = `
                <div class="flex items-center gap-2">
                    <i data-lucide="${type === 'error' ? 'alert-circle' : type === 'success' ? 'check-circle' : 'info'}" class="w-5 h-5"></i>
                    <span>${message}</span>
                </div>
            `;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
            
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
    };
    
    // Hacer carritoManager global para poder acceder desde los onclick
    window.carritoManager = carritoManager;
    
    // Inicializar carrito
    carritoManager.init();
    
    // Botón proceder al pago
        const btnProcederPago = document.getElementById('proceder-pago');

    if (btnProcederPago) {
        btnProcederPago.addEventListener('click', function () {
            if (carritoManager.items.length > 0) {
                // Validar carrito primero
                fetch('{{ route("cliente.carrito.validar") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ items: carritoManager.items })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '{{ route("cliente.checkout") }}';
                    } else {
                        alert('Algunos productos no están disponibles. Por favor revisa tu carrito.');
                    }
                })
                .catch(error => {
                    console.error('Error en la validación del carrito:', error);
                    alert('Ha ocurrido un error al validar el carrito.');
                });
            }
        });
    }
});
</script>
@endpush
@endsection
