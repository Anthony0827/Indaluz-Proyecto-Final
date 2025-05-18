@extends('layouts.app')

@section('title', 'Iniciar Sesión')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-center mb-6 text-green-700">Iniciar Sesión</h2>

    <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1">Correo</label>
            <input
                type="email"
                name="correo"
                value="{{ old('correo') }}"
                class="w-full border p-2 rounded @error('correo') border-red-500 @enderror"
                required
                autofocus
            >
            @error('correo')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1">Contraseña</label>
            <input
                type="password"
                name="password"
                class="w-full border p-2 rounded @error('password') border-red-500 @enderror"
                required
            >
            @error('password')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember" class="form-checkbox text-green-600">
                <span class="ml-2 text-sm text-gray-700">Recuérdame</span>
            </label>
            <a href="#" class="text-sm text-green-600 hover:underline">¿Olvidaste tu contraseña?</a>
        </div>

        <button
            type="submit"
            class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition"
        >
            Entrar
        </button>

        <p class="text-center text-sm text-gray-600 mt-4">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="text-green-600 hover:underline">Regístrate</a>
        </p>
    </form>
</div>
@endsection
