{{-- resources/views/agricultor/productos/edit.blade.php --}}
@extends('layouts.agricultor')

@section('title', 'Editar Producto')
@section('header', 'Editar Producto')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-md p-6">
        {{-- Encabezado --}}
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Editar: {{ $producto->nombre }}</h2>
            <p class="text-gray-600 mt-1">Actualiza la información de tu producto</p>
        </div>

        <form method="POST" 
              action="{{ route('agricultor.productos.update', $producto->id_producto) }}" 
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Columna izquierda --}}
                <div class="space-y-6">
                    {{-- Nombre del producto --}}
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre del producto <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre"
                               value="{{ old('nombre', $producto->nombre) }}"
                               required
                               placeholder="Ej: Tomates pera"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('nombre') border-red-500 @enderror">
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Categoría --}}
                    <div>
                        <label for="categoria" class="block text-sm font-medium text-gray-700 mb-2">
                            Categoría <span class="text-red-500">*</span>
                        </label>
                        <select name="categoria" 
                                id="categoria"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('categoria') border-red-500 @enderror">
                            <option value="">Selecciona una categoría</option>
                            <option value="fruta" {{ old('categoria', $producto->categoria) == 'fruta' ? 'selected' : '' }}>Fruta</option>
                            <option value="verdura" {{ old('categoria', $producto->categoria) == 'verdura' ? 'selected' : '' }}>Verdura</option>
                        </select>
                        @error('categoria')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Precio --}}
                    <div>
                        <label for="precio" class="block text-sm font-medium text-gray-700 mb-2">
                            Precio por unidad/kg (€) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="number" 
                                   name="precio" 
                                   id="precio"
                                   value="{{ old('precio', $producto->precio) }}"
                                   step="0.01"
                                   min="0.01"
                                   max="9999.99"
                                   required
                                   placeholder="0.00"
                                   class="w-full px-3 py-2 pr-8 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('precio') border-red-500 @enderror">
                            <span class="absolute right-3 top-2 text-gray-500">€</span>
                        </div>
                        @error('precio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Cantidad en inventario --}}
                    <div>
                        <label for="cantidad_inventario" class="block text-sm font-medium text-gray-700 mb-2">
                            Cantidad disponible <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               name="cantidad_inventario" 
                               id="cantidad_inventario"
                               value="{{ old('cantidad_inventario', $producto->cantidad_inventario) }}"
                               min="0"
                               max="99999"
                               required
                               placeholder="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('cantidad_inventario') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Número de unidades o kilos disponibles</p>
                        @error('cantidad_inventario')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
                            Estado del producto <span class="text-red-500">*</span>
                        </label>
                        <select name="estado" 
                                id="estado"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('estado') border-red-500 @enderror">
                            <option value="activo" {{ old('estado', $producto->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado', $producto->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Columna derecha --}}
                <div class="space-y-6">
                    {{-- Tiempo de cosecha --}}
                    <div>
                        <label for="tiempo_de_cosecha" class="block text-sm font-medium text-gray-700 mb-2">
                            Tiempo desde la cosecha <span class="text-red-500">*</span>
                        </label>
                        <select name="tiempo_de_cosecha" 
                                id="tiempo_de_cosecha"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('tiempo_de_cosecha') border-red-500 @enderror">
                            <option value="">Selecciona una opción</option>
                            <option value="Recién cosechado" {{ old('tiempo_de_cosecha', $producto->tiempo_de_cosecha) == 'Recién cosechado' ? 'selected' : '' }}>Recién cosechado (hoy)</option>
                            <option value="1 día" {{ old('tiempo_de_cosecha', $producto->tiempo_de_cosecha) == '1 día' ? 'selected' : '' }}>1 día</option>
                            <option value="2-3 días" {{ old('tiempo_de_cosecha', $producto->tiempo_de_cosecha) == '2-3 días' ? 'selected' : '' }}>2-3 días</option>
                            <option value="4-7 días" {{ old('tiempo_de_cosecha', $producto->tiempo_de_cosecha) == '4-7 días' ? 'selected' : '' }}>4-7 días</option>
                            <option value="Más de 1 semana" {{ old('tiempo_de_cosecha', $producto->tiempo_de_cosecha) == 'Más de 1 semana' ? 'selected' : '' }}>Más de 1 semana</option>
                        </select>
                        @error('tiempo_de_cosecha')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Imagen actual --}}
                    @if($producto->imagen)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Imagen actual
                            </label>
                            <div class="border rounded-lg p-4 bg-gray-50">
                                <img src="{{ asset('storage/' . $producto->imagen) }}" 
                                     alt="{{ $producto->nombre }}"
                                     class="mx-auto h-32 w-32 object-cover rounded-lg">
                            </div>
                        </div>
                    @endif

                    {{-- Nueva imagen --}}
                    <div>
                        <label for="imagen" class="block text-sm font-medium text-gray-700 mb-2">
                            {{ $producto->imagen ? 'Cambiar imagen' : 'Imagen del producto' }}
                        </label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-green-500 transition-colors">
                            <div class="space-y-1 text-center">
                                <div id="preview-container" class="mb-4 hidden">
                                    <img id="preview-image" class="mx-auto h-32 w-32 object-cover rounded-lg" alt="Vista previa">
                                </div>
                                <i data-lucide="upload-cloud" class="mx-auto h-12 w-12 text-gray-400"></i>
                                <div class="flex text-sm text-gray-600">
                                    <label for="imagen" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none">
                                        <span>Sube una nueva imagen</span>
                                        <input id="imagen" 
                                               name="imagen" 
                                               type="file" 
                                               accept="image/jpeg,image/png,image/jpg,image/webp"
                                               class="sr-only">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, WEBP hasta 2MB</p>
                            </div>
                        </div>
                        @error('imagen')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción del producto
                        </label>
                        <textarea name="descripcion" 
                                  id="descripcion"
                                  rows="4"
                                  placeholder="Describe tu producto: calidad, características especiales, beneficios..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Máximo 500 caracteres</p>
                        @error('descripcion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Botones de acción --}}
            <div class="flex justify-end gap-4 pt-6 border-t">
                <a href="{{ route('agricultor.productos.index') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Preview de nueva imagen
    const imageInput = document.getElementById('imagen');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    });

    // Contador de caracteres para descripción
    const descripcion = document.getElementById('descripcion');
    const maxLength = 500;
    
    descripcion.addEventListener('input', function() {
        if (this.value.length > maxLength) {
            this.value = this.value.substring(0, maxLength);
        }
    });
});
</script>
@endpush
@endsection