{{-- resources/views/cliente/perfil/index.blade.php --}}
@extends('layouts.cliente')

@section('title', 'Mi Perfil')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="max-w-4xl mx-auto">
        {{-- Encabezado --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Mi Perfil</h1>
            <p class="text-gray-600 mt-1">Administra tu información personal</p>
        </div>

        {{-- Foto de perfil --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Foto de perfil</h2>
            
            <div class="flex items-center space-x-6">
                {{-- Avatar actual --}}
                <div class="flex-shrink-0">
                    @if($cliente->foto_perfil)
                        <img src="{{ $cliente->foto_perfil_url }}" 
                             alt="Foto de perfil"
                             class="w-24 h-24 rounded-full object-cover border-4 border-green-200">
                    @else
                        <div class="w-24 h-24 rounded-full bg-green-600 flex items-center justify-center text-white text-3xl font-bold border-4 border-green-200">
                            {{ substr($cliente->nombre, 0, 1) }}
                        </div>
                    @endif
                </div>

                {{-- Formulario para cambiar foto --}}
                <div class="flex-1">
                    <form method="POST" 
                          action="{{ route('cliente.perfil.updateAvatar') }}" 
                          enctype="multipart/form-data"
                          class="flex items-center space-x-4">
                        @csrf
                        @method('PATCH')
                        
                        <div class="flex-1">
                            <input type="file" 
                                   name="foto_perfil" 
                                   id="foto_perfil"
                                   accept="image/*"
                                   class="block w-full text-sm text-gray-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-green-50 file:text-green-700
                                          hover:file:bg-green-100
                                          cursor-pointer"
                                   required>
                            <p class="text-xs text-gray-500 mt-1">JPG, PNG, WEBP. Máximo 2MB</p>
                            @error('foto_perfil')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" 
                                class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            Cambiar foto
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Información personal --}}
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Información personal</h2>
            
            <form method="POST" action="{{ route('cliente.perfil.update') }}">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Nombre --}}
                    <div>
                        <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                            Nombre <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="nombre" 
                               id="nombre"
                               value="{{ old('nombre', $cliente->nombre) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('nombre') border-red-500 @enderror">
                        @error('nombre')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Apellidos --}}
                    <div>
                        <label for="apellido" class="block text-sm font-medium text-gray-700 mb-2">
                            Apellidos <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="apellido" 
                               id="apellido"
                               value="{{ old('apellido', $cliente->apellido) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('apellido') border-red-500 @enderror">
                        @error('apellido')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="correo" class="block text-sm font-medium text-gray-700 mb-2">
                            Correo electrónico <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               name="correo" 
                               id="correo"
                               value="{{ old('correo', $cliente->correo) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('correo') border-red-500 @enderror">
                        @error('correo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Teléfono --}}
                    <div>
                        <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                            Teléfono
                        </label>
                        <input type="tel" 
                               name="telefono" 
                               id="telefono"
                               value="{{ old('telefono', $cliente->telefono) }}"
                               placeholder="600123456"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('telefono') border-red-500 @enderror">
                        @error('telefono')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Dirección completa --}}
                <div class="mt-6">
                    <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                        Dirección
                    </label>
                    <input type="text" 
                           name="direccion" 
                           id="direccion"
                           value="{{ old('direccion', $cliente->direccion) }}"
                           placeholder="Calle, número, piso..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('direccion') border-red-500 @enderror">
                    @error('direccion')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Código postal, municipio y provincia --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <div>
                        <label for="codigo_postal" class="block text-sm font-medium text-gray-700 mb-2">
                            Código Postal
                        </label>
                        <input type="text" 
                               name="codigo_postal" 
                               id="codigo_postal"
                               value="{{ old('codigo_postal', $cliente->codigo_postal) }}"
                               maxlength="5"
                               placeholder="04000"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('codigo_postal') border-red-500 @enderror">
                        @error('codigo_postal')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="municipio" class="block text-sm font-medium text-gray-700 mb-2">
                            Municipio
                        </label>
                        <input type="text" 
                               name="municipio" 
                               id="municipio"
                               value="{{ old('municipio', $cliente->municipio) }}"
                               placeholder="Almería"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('municipio') border-red-500 @enderror">
                        @error('municipio')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="provincia" class="block text-sm font-medium text-gray-700 mb-2">
                            Provincia
                        </label>
                        <input type="text" 
                               name="provincia" 
                               id="provincia"
                               value="{{ old('provincia', $cliente->provincia ?? 'Almería') }}"
                               placeholder="Almería"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('provincia') border-red-500 @enderror">
                        @error('provincia')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Botón guardar --}}
                <div class="mt-6 flex justify-end">
                    <button type="submit" 
                            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>

        {{-- Cambiar contraseña --}}
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Cambiar contraseña</h2>
            
            <form method="POST" action="{{ route('cliente.perfil.updatePassword') }}">
                @csrf
                @method('PATCH')
                
                <div class="space-y-4">
                    {{-- Contraseña actual --}}
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña actual <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               name="current_password" 
                               id="current_password"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nueva contraseña --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Nueva contraseña <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               name="password" 
                               id="password"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('password') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Mínimo 8 caracteres</p>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Confirmar contraseña --}}
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmar nueva contraseña <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                    </div>
                </div>

                {{-- Botón cambiar --}}
                <div class="mt-6 flex justify-end">
                    <button type="submit" 
                            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                        Cambiar contraseña
                    </button>
                </div>
            </form>
        </div>

        {{-- Información adicional --}}
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <i data-lucide="info" class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0"></i>
                <div class="text-sm">
                    <p class="text-blue-800 font-medium">Sobre tu información</p>
                    <p class="text-blue-600 mt-1">
                        Tu información personal es privada y segura. Solo la usamos para procesar tus pedidos y mejorar tu experiencia en Indaluz.
                    </p>
                </div>
            </div>
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

    // Preview de la imagen antes de subirla
    const inputFoto = document.getElementById('foto_perfil');
    if (inputFoto) {
        inputFoto.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                // Aquí podrías añadir un preview de la imagen si lo deseas
                console.log('Imagen seleccionada:', file.name);
            }
        });
    }
});
</script>
@endpush
@endsection