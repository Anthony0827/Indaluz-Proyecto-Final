{{-- resources/views/auth/register-agricultor.blade.php --}}
@extends('layouts.app')

@section('title', 'Registro Agricultor')

@section('content')
{{-- Mostrar mensajes de sesión --}}
@if(session('success'))
    <div class="max-w-md mx-auto mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="max-w-md mx-auto mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        {{ session('error') }}
    </div>
@endif

<div class="max-w-md mx-auto my-12 bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-center mb-6 text-green-700">
        Registro como Agricultor
    </h2>

    {{-- Información adicional para agricultores --}}
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
        <h3 class="font-semibold text-green-800 mb-2 flex items-center">
            <i data-lucide="info" class="w-5 h-5 mr-2"></i>
            Únete a nuestra comunidad
        </h3>
        <p class="text-sm text-green-700">
            Como agricultor en Indaluz, podrás vender directamente tus productos frescos a clientes locales, 
            establecer precios justos y construir relaciones duraderas con tu comunidad.
        </p>
    </div>

    <form method="POST" action="{{ route('register.submit', 'agricultor') }}" class="space-y-4">
        @csrf

        {{-- Datos personales --}}
        <div class="space-y-4">
            <h4 class="font-semibold text-gray-700 border-b pb-2">Datos Personales</h4>
            
            <div>
                <label for="nombre" class="block mb-1 font-medium">
                    Nombre <span class="text-red-500">*</span>
                </label>
                <input
                    id="nombre"
                    name="nombre"
                    type="text"
                    value="{{ old('nombre') }}"
                    required
                    autofocus
                    placeholder="Ej: Juan"
                    class="w-full border border-gray-300 p-2 rounded focus:border-green-500 focus:outline-none @error('nombre') border-red-500 @enderror"
                >
                @error('nombre')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="apellido" class="block mb-1 font-medium">
                    Apellidos <span class="text-red-500">*</span>
                </label>
                <input
                    id="apellido"
                    name="apellido"
                    type="text"
                    value="{{ old('apellido') }}"
                    required
                    placeholder="Ej: García López"
                    class="w-full border border-gray-300 p-2 rounded focus:border-green-500 focus:outline-none @error('apellido') border-red-500 @enderror"
                >
                @error('apellido')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Datos de contacto --}}
        <div class="space-y-4">
            <h4 class="font-semibold text-gray-700 border-b pb-2 mt-6">Datos de Contacto</h4>
            
            <div>
                <label for="correo" class="block mb-1 font-medium">
                    Correo Electrónico <span class="text-red-500">*</span>
                </label>
                <input
                    id="correo"
                    name="correo"
                    type="email"
                    value="{{ old('correo') }}"
                    required
                    placeholder="ejemplo@correo.com"
                    class="w-full border border-gray-300 p-2 rounded focus:border-green-500 focus:outline-none @error('correo') border-red-500 @enderror"
                >
                @error('correo')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="telefono" class="block mb-1 font-medium">
                    Teléfono <span class="text-red-500">*</span>
                    <span class="text-gray-500 text-sm">(importante para coordinar entregas)</span>
                </label>
                <input
                    id="telefono"
                    name="telefono"
                    type="tel"
                    value="{{ old('telefono') }}"
                    required
                    placeholder="Ej: 600123456"
                    class="w-full border border-gray-300 p-2 rounded focus:border-green-500 focus:outline-none @error('telefono') border-red-500 @enderror"
                >
                @error('telefono')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Ubicación --}}
        <div class="space-y-4">
            <h4 class="font-semibold text-gray-700 border-b pb-2 mt-6">Ubicación de la Explotación</h4>
            
            <div>
                <label for="direccion" class="block mb-1 font-medium">
                    Dirección <span class="text-red-500">*</span>
                    <span class="text-gray-500 text-sm">(zona/municipio de tu explotación)</span>
                </label>
                <input
                    id="direccion"
                    name="direccion"
                    type="text"
                    value="{{ old('direccion') }}"
                    required
                    placeholder="Ej: Camino Rural s/n, El Ejido, Almería"
                    class="w-full border border-gray-300 p-2 rounded focus:border-green-500 focus:outline-none @error('direccion') border-red-500 @enderror"
                >
                @error('direccion')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Contraseña --}}
        <div class="space-y-4">
            <h4 class="font-semibold text-gray-700 border-b pb-2 mt-6">Seguridad</h4>
            
            <div>
                <label for="password" class="block mb-1 font-medium">
                    Contraseña <span class="text-red-500">*</span>
                </label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    placeholder="Mínimo 8 caracteres"
                    class="w-full border border-gray-300 p-2 rounded focus:border-green-500 focus:outline-none @error('password') border-red-500 @enderror"
                >
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block mb-1 font-medium">
                    Confirmar Contraseña <span class="text-red-500">*</span>
                </label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    placeholder="Repite la contraseña"
                    class="w-full border border-gray-300 p-2 rounded focus:border-green-500 focus:outline-none"
                >
            </div>
        </div>

        {{-- Términos y condiciones --}}
        <div class="mt-6">
            <label class="flex items-start">
                <input 
                    type="checkbox" 
                    name="terms" 
                    required 
                    class="mt-1 mr-2 text-green-600 focus:ring-green-500"
                >
                <span class="text-sm text-gray-600">
                    Acepto los <a href="#" class="text-green-600 hover:underline">términos y condiciones</a> 
                    y la <a href="#" class="text-green-600 hover:underline">política de privacidad</a> de Indaluz.
                    Entiendo que mis datos serán utilizados para gestionar mi cuenta de vendedor.
                </span>
            </label>
        </div>

        {{-- Botón de envío --}}
        <button
            type="submit"
            class="w-full bg-green-600 text-white py-3 rounded-lg hover:bg-green-700 transition font-semibold mt-6"
        >
            Crear cuenta de Agricultor
        </button>

        {{-- Enlaces adicionales --}}
        <div class="text-center text-sm text-gray-600 mt-6 space-y-2">
            <p>
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-green-600 hover:underline font-medium">Inicia Sesión</a>
            </p>
            <p>
                ¿Eres un cliente?
                <a href="{{ route('register.role', 'cliente') }}" class="text-green-600 hover:underline">Regístrate como cliente</a>
            </p>
        </div>
    </form>
</div>

{{-- Inicializar iconos Lucide --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    });
</script>
@endsection