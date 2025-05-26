@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
{{-- Mensajes de sesión --}}
@if(session('success'))
    <div class="max-w-md mx-auto mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="max-w-md mx-auto mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
        {{ session('error') }}
    </div>
@endif

@if(session('info'))
    <div class="max-w-md mx-auto mb-4 p-4 bg-blue-100 border border-blue-400 text-blue-700 rounded">
        {{ session('info') }}
    </div>
@endif

<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-center mb-6 text-green-700">Iniciar Sesión</h2>

    <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Correo Electrónico</label>
            <input
                type="email"
                name="correo"
                value="{{ old('correo') }}"
                class="w-full border border-gray-300 p-2 rounded focus:border-green-500 focus:outline-none @error('correo') border-red-500 @enderror"
                required
                autofocus
                placeholder="ejemplo@correo.com"
            >
            @error('correo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Contraseña</label>
            <input
                type="password"
                name="password"
                class="w-full border border-gray-300 p-2 rounded focus:border-green-500 focus:outline-none @error('password') border-red-500 @enderror"
                required
                placeholder="Tu contraseña"
            >
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember" class="form-checkbox text-green-600 rounded">
                <span class="ml-2 text-sm text-gray-700">Recuérdame</span>
            </label>
            <a href="#" class="text-sm text-green-600 hover:underline">¿Olvidaste tu contraseña?</a>
        </div>

        <button
            type="submit"
            class="w-full bg-green-600 text-white py-3 rounded hover:bg-green-700 transition font-semibold"
        >
            Iniciar Sesión
        </button>

        <div class="text-center text-sm text-gray-600 mt-6 pt-6 border-t">
            <p class="mb-2">¿No tienes cuenta?</p>
            <a href="{{ route('register') }}" class="text-green-600 hover:underline font-medium">
                Regístrate aquí
            </a>
        </div>
    </form>
</div>
@endsection