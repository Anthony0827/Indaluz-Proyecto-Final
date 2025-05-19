{{-- resources/views/auth/register-cliente.blade.php --}}
@extends('layouts.app')

@section('title', 'Registro Cliente')

@section('content')
<div class="max-w-md mx-auto my-12 bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-center mb-6 text-green-700">
        Registro como Cliente
    </h2>

    <form method="POST" action="{{ route('register.submit', 'cliente') }}" class="space-y-4">
        @csrf

        <div>
            <label for="nombre" class="block mb-1 font-medium">Nombre</label>
            <input
                id="nombre"
                name="nombre"
                type="text"
                value="{{ old('nombre') }}"
                required
                autofocus
                class="w-full border border-gray-300 p-2 rounded @error('nombre') border-red-500 @enderror"
            >
            @error('nombre')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="apellido" class="block mb-1 font-medium">Apellido</label>
            <input
                id="apellido"
                name="apellido"
                type="text"
                value="{{ old('apellido') }}"
                required
                class="w-full border border-gray-300 p-2 rounded @error('apellido') border-red-500 @enderror"
            >
            @error('apellido')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="correo" class="block mb-1 font-medium">Correo Electrónico</label>
            <input
                id="correo"
                name="correo"
                type="email"
                value="{{ old('correo') }}"
                required
                class="w-full border border-gray-300 p-2 rounded @error('correo') border-red-500 @enderror"
            >
            @error('correo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block mb-1 font-medium">Contraseña</label>
            <input
                id="password"
                name="password"
                type="password"
                required
                class="w-full border border-gray-300 p-2 rounded @error('password') border-red-500 @enderror"
            >
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block mb-1 font-medium">Confirmar Contraseña</label>
            <input
                id="password_confirmation"
                name="password_confirmation"
                type="password"
                required
                class="w-full border border-gray-300 p-2 rounded"
            >
        </div>

        <div>
            <label for="direccion" class="block mb-1 font-medium">Dirección (opcional)</label>
            <input
                id="direccion"
                name="direccion"
                type="text"
                value="{{ old('direccion') }}"
                class="w-full border border-gray-300 p-2 rounded @error('direccion') border-red-500 @enderror"
            >
            @error('direccion')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="telefono" class="block mb-1 font-medium">Teléfono (opcional)</label>
            <input
                id="telefono"
                name="telefono"
                type="text"
                value="{{ old('telefono') }}"
                class="w-full border border-gray-300 p-2 rounded @error('telefono') border-red-500 @enderror"
            >
            @error('telefono')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button
            type="submit"
            class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition"
        >
            Registrarme
        </button>

        <p class="text-center text-sm text-gray-600 mt-4">
            ¿Ya tienes cuenta?
            <a href="{{ route('login') }}" class="text-green-600 hover:underline">Inicia Sesión</a>
        </p>
    </form>
</div>
@endsection
