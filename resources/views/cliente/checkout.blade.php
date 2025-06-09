{{-- resources/views/cliente/checkout.blade.php --}}
@extends('layouts.check')

@section('title', 'Finalizar Compra')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Finalizar Compra</h1>

    <form method="POST" action="{{ route('cliente.checkout.procesar') }}" id="checkout-form">
        @csrf
        
        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Columna principal - Formulario --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Datos de envío --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4 flex items-center">
                        <i data-lucide="map-pin" class="w-5 h-5 mr-2 text-green-600"></i>
                        Datos de Envío
                    </h2>

                    <div class="space-y-4">
                        {{-- Dirección --}}
                        <div>
                            <label for="direccion_envio" class="block text-sm font-medium text-gray-700 mb-2">
                                Dirección completa <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="direccion_envio" 
                                   id="direccion_envio"
                                   value="{{ old('direccion_envio', $cliente->direccion) }}"
                                   placeholder="Calle, número, piso..."
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('direccion_envio') border-red-500 @enderror">
                            @error('direccion_envio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            {{-- Código Postal --}}
                            <div>
                                <label for="codigo_postal" class="block text-sm font-medium text-gray-700 mb-2">
                                    Código Postal <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="codigo_postal" 
                                       id="codigo_postal"
                                       value="{{ old('codigo_postal', $cliente->codigo_postal) }}"
                                       maxlength="5"
                                       placeholder="04000"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('codigo_postal') border-red-500 @enderror">
                                @error('codigo_postal')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Municipio --}}
                            <div>
                                <label for="municipio" class="block text-sm font-medium text-gray-700 mb-2">
                                    Municipio <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="municipio" 
                                       id="municipio"
                                       value="{{ old('municipio', $cliente->municipio) }}"
                                       placeholder="Almería"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('municipio') border-red-500 @enderror">
                                @error('municipio')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Provincia --}}
                            <div>
                                <label for="provincia" class="block text-sm font-medium text-gray-700 mb-2">
                                    Provincia <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="provincia" 
                                       id="provincia"
                                       value="{{ old('provincia', $cliente->provincia ?? 'Almería') }}"
                                       placeholder="Almería"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('provincia') border-red-500 @enderror">
                                @error('provincia')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Teléfono de contacto --}}
                        <div>
                            <label for="telefono_contacto" class="block text-sm font-medium text-gray-700 mb-2">
                                Teléfono de contacto <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   name="telefono_contacto" 
                                   id="telefono_contacto"
                                   value="{{ old('telefono_contacto', $cliente->telefono) }}"
                                   placeholder="600123456"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('telefono_contacto') border-red-500 @enderror">
                            @error('telefono_contacto')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Método de entrega --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4 flex items-center">
                        <i data-lucide="truck" class="w-5 h-5 mr-2 text-green-600"></i>
                        Método de Entrega
                    </h2>

                    <div class="space-y-4">
                        {{-- Tipo de entrega --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                ¿Cómo prefieres recibir tu pedido? <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" 
                                           name="metodo_entrega" 
                                           value="domicilio"
                                           {{ old('metodo_entrega', 'domicilio') == 'domicilio' ? 'checked' : '' }}
                                           required
                                           class="mr-3 text-green-600 focus:ring-green-500">
                                    <div>
                                        <p class="font-medium">Entrega a domicilio</p>
                                        <p class="text-sm text-gray-600">Recibe tu pedido en la dirección indicada</p>
                                    </div>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" 
                                           name="metodo_entrega" 
                                           value="recogida"
                                           {{ old('metodo_entrega') == 'recogida' ? 'checked' : '' }}
                                           required
                                           class="mr-3 text-green-600 focus:ring-green-500">
                                    <div>
                                        <p class="font-medium">Recoger en el punto de venta</p>
                                        <p class="text-sm text-gray-600">Recoge tu pedido directamente del agricultor</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Fecha y hora de entrega --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="fecha_entrega" class="block text-sm font-medium text-gray-700 mb-2">
                                    Fecha de entrega <span class="text-red-500">*</span>
                                </label>
                                <input type="date" 
                                       name="fecha_entrega" 
                                       id="fecha_entrega"
                                       value="{{ old('fecha_entrega', date('Y-m-d', strtotime('+1 day'))) }}"
                                       min="{{ date('Y-m-d') }}"
                                       required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('fecha_entrega') border-red-500 @enderror">
                                @error('fecha_entrega')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="hora_entrega" class="block text-sm font-medium text-gray-700 mb-2">
                                    Horario preferido <span class="text-red-500">*</span>
                                </label>
                                <select name="hora_entrega" 
                                        id="hora_entrega"
                                        required
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('hora_entrega') border-red-500 @enderror">
                                    <option value="">Selecciona un horario</option>
                                    <option value="09:00-11:00" {{ old('hora_entrega') == '09:00-11:00' ? 'selected' : '' }}>09:00 - 11:00</option>
                                    <option value="11:00-13:00" {{ old('hora_entrega') == '11:00-13:00' ? 'selected' : '' }}>11:00 - 13:00</option>
                                    <option value="13:00-15:00" {{ old('hora_entrega') == '13:00-15:00' ? 'selected' : '' }}>13:00 - 15:00</option>
                                    <option value="15:00-17:00" {{ old('hora_entrega') == '15:00-17:00' ? 'selected' : '' }}>15:00 - 17:00</option>
                                    <option value="17:00-19:00" {{ old('hora_entrega') == '17:00-19:00' ? 'selected' : '' }}>17:00 - 19:00</option>
                                    <option value="19:00-21:00" {{ old('hora_entrega') == '19:00-21:00' ? 'selected' : '' }}>19:00 - 21:00</option>
                                </select>
                                @error('hora_entrega')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Notas para el vendedor --}}
                        <div>
                            <label for="notas_cliente" class="block text-sm font-medium text-gray-700 mb-2">
                                Notas para el vendedor (opcional)
                            </label>
                            <textarea name="notas_cliente" 
                                      id="notas_cliente"
                                      rows="3"
                                      placeholder="Instrucciones especiales, preferencias de entrega, etc."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('notas_cliente') border-red-500 @enderror">{{ old('notas_cliente') }}</textarea>
                            @error('notas_cliente')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Método de pago --}}
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-semibold mb-4 flex items-center">
                        <i data-lucide="credit-card" class="w-5 h-5 mr-2 text-green-600"></i>
                        Método de Pago
                    </h2>

                    <div class="space-y-4">
                        {{-- Tipo de pago --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                ¿Cómo prefieres pagar? <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-2">
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" 
                                           name="metodo_pago" 
                                           value="tarjeta"
                                           {{ old('metodo_pago', 'tarjeta') == 'tarjeta' ? 'checked' : '' }}
                                           required
                                           class="mr-3 text-green-600 focus:ring-green-500"
                                           onchange="togglePaymentMethod()">
                                    <div>
                                        <p class="font-medium">Tarjeta de crédito/débito</p>
                                        <p class="text-sm text-gray-600">Pago seguro con tarjeta</p>
                                    </div>
                                </label>
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" 
                                           name="metodo_pago" 
                                           value="efectivo"
                                           {{ old('metodo_pago') == 'efectivo' ? 'checked' : '' }}
                                           required
                                           class="mr-3 text-green-600 focus:ring-green-500"
                                           onchange="togglePaymentMethod()">
                                    <div>
                                        <p class="font-medium">Efectivo</p>
                                        <p class="text-sm text-gray-600">Paga al recibir tu pedido</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Datos de tarjeta --}}
                        <div id="datos-tarjeta" class="space-y-4 {{ old('metodo_pago', 'tarjeta') != 'tarjeta' ? 'hidden' : '' }}">
                            {{-- Número de tarjeta --}}
                            <div>
                                <label for="numero_tarjeta" class="block text-sm font-medium text-gray-700 mb-2">
                                    Número de tarjeta <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="numero_tarjeta" 
                                       id="numero_tarjeta"
                                       placeholder="1234 5678 9012 3456"
                                       maxlength="16"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('numero_tarjeta') border-red-500 @enderror">
                                @error('numero_tarjeta')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Nombre del titular --}}
                            <div>
                                <label for="nombre_titular" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre del titular <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       name="nombre_titular" 
                                       id="nombre_titular"
                                       placeholder="Como aparece en la tarjeta"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('nombre_titular') border-red-500 @enderror">
                                @error('nombre_titular')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Fecha de expiración y CVV --}}
<div class="grid grid-cols-3 gap-4">
    {{-- Mes --}}
    <div>
        <label for="mes_expiracion" class="block text-sm font-medium text-gray-700 mb-2">
            Mes <span class="text-red-500">*</span>
        </label>
        <select name="mes_expiracion" 
                id="mes_expiracion"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('mes_expiracion') border-red-500 @enderror">
            <option value="">Mes</option>
            @for($m = 1; $m <= 12; $m++)
                @php $mm = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                <option value="{{ $mm }}" {{ old('mes_expiracion') == $mm ? 'selected' : '' }}>
                    {{ $mm }}
                </option>
            @endfor
        </select>
        @error('mes_expiracion')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- Año --}}
    <div>
        <label for="anio_expiracion" class="block text-sm font-medium text-gray-700 mb-2">
            Año <span class="text-red-500">*</span>
        </label>
        <select name="anio_expiracion" 
                id="anio_expiracion"
                required
                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('anio_expiracion') border-red-500 @enderror">
            <option value="">Año</option>
            @php
                $currentYear = date('Y');
            @endphp
            @for($y = 0; $y < 10; $y++)
                @php $year = $currentYear + $y; @endphp
                <option value="{{ $year }}" {{ old('anio_expiracion') == $year ? 'selected' : '' }}>
                    {{ $year }}
                </option>
            @endfor
        </select>
        @error('anio_expiracion')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    {{-- CVV --}}
    <div>
        <label for="cvv" class="block text-sm font-medium text-gray-700 mb-2">
            CVV <span class="text-red-500">*</span>
        </label>
        <input type="text" 
               name="cvv" 
               id="cvv"
               maxlength="3"
               placeholder="123"
               required
               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('cvv') border-red-500 @enderror">
        @error('cvv')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>


                        {{-- Mensaje de seguridad --}}
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex">
                                <i data-lucide="shield-check" class="w-5 h-5 text-green-600 mr-3 flex-shrink-0"></i>
                                <div class="text-sm">
                                    <p class="text-green-800 font-medium">Pago 100% seguro</p>
                                    <p class="text-green-600 mt-1">
                                        Tus datos están protegidos con encriptación SSL. No almacenamos información de tarjetas.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Columna lateral - Resumen del pedido --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6 sticky top-24">
                    <h2 class="text-xl font-semibold mb-4">Resumen del pedido</h2>
                    
                    <div class="space-y-4 mb-6">
                        @foreach($items as $item)
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800">{{ $item['producto']->nombre }}</p>
                                    <p class="text-sm text-gray-600">
                                        {{ $item['cantidad'] }} {{ $item['producto']->unidad_medida_texto }} × 
                                        {{ number_format($item['producto']->precio, 2) }}€
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        Vendido por: {{ $item['producto']->agricultor->nombre_empresa ?? $item['producto']->agricultor->nombre }}
                                    </p>
                                </div>
                                <p class="font-semibold text-gray-800 ml-4">
                                    {{ number_format($item['subtotal'], 2) }}€
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t pt-4 space-y-2">
                        <div class="flex justify-between text-sm">
                            <span>Subtotal</span>
                            <span>{{ number_format($subtotal, 2) }}€</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span>Gastos de envío</span>
                            <span class="text-green-600">Gratis</span>
                        </div>
                        <div class="border-t pt-2 mt-2">
                            <div class="flex justify-between text-lg font-semibold">
                                <span>Total</span>
                                <span class="text-green-600">{{ number_format($subtotal, 2) }}€</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" 
                            id="btn-procesar-pago"
                            class="w-full mt-6 bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-semibold disabled:bg-gray-400 disabled:cursor-not-allowed">
                        <span class="flex items-center justify-center">
                            <i data-lucide="lock" class="w-5 h-5 mr-2"></i>
                            Confirmar y pagar
                        </span>
                    </button>

                    <p class="text-xs text-gray-500 text-center mt-4">
                        Al realizar el pedido aceptas nuestros términos y condiciones
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos Lucide
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Toggle método de pago
    window.togglePaymentMethod = function() {
        const metodoPago = document.querySelector('input[name="metodo_pago"]:checked').value;
        const datosTarjeta = document.getElementById('datos-tarjeta');
        const camposTarjeta = datosTarjeta.querySelectorAll('input, select');
        
        if (metodoPago === 'tarjeta') {
            datosTarjeta.classList.remove('hidden');
            // Hacer campos requeridos
            camposTarjeta.forEach(campo => {
                if (campo.name !== 'notas_cliente') {
                    campo.required = true;
                }
            });
        } else {
            datosTarjeta.classList.add('hidden');
            // Quitar requerido
            camposTarjeta.forEach(campo => {
                campo.required = false;
            });
        }
    };

    // Formatear número de tarjeta
    const numeroTarjeta = document.getElementById('numero_tarjeta');
    if (numeroTarjeta) {
        numeroTarjeta.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s/g, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });
    }

    // Validar solo números en campos numéricos
    const camposNumericos = ['numero_tarjeta', 'cvv', 'telefono_contacto', 'codigo_postal'];
    camposNumericos.forEach(campo => {
        const elemento = document.getElementById(campo);
        if (elemento) {
            elemento.addEventListener('input', function(e) {
                e.target.value = e.target.value.replace(/[^0-9]/g, '');
            });
        }
    });

    // Prevenir envío múltiple del formulario
    const form = document.getElementById('checkout-form');
    const btnProcesar = document.getElementById('btn-procesar-pago');
    
    form.addEventListener('submit', function(e) {
        // Deshabilitar botón
        btnProcesar.disabled = true;
        btnProcesar.innerHTML = `
            <span class="flex items-center justify-center">
                <svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Procesando pago...
            </span>
        `;
    });

    // Establecer fecha mínima de entrega
    const fechaEntrega = document.getElementById('fecha_entrega');
    if (fechaEntrega) {
        const hoy = new Date();
        const yyyy = hoy.getFullYear();
        const mm = String(hoy.getMonth() + 1).padStart(2, '0');
        const dd = String(hoy.getDate()).padStart(2, '0');
        fechaEntrega.min = `${yyyy}-${mm}-${dd}`;
    }
});
</script>
@endpush