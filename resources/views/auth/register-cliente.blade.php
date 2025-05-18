@extends('layouts.app')

@section('title', 'Registro Cliente')

@section('content')
<div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold text-center mb-6 text-green-700">
        Registro como Cliente
    </h2>

    <form method="POST" action="{{ route('register.submit') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="rol" value="cliente">

        <div>
            <label class="block mb-1">Nombre</label>
            <input name="nombre" value="{{ old('nombre') }}"
                   class="w-full border p-2 rounded @error('nombre') border-red-500 @enderror">
            @error('nombre') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1">Apellido</label>
            <input name="apellido" value="{{ old('apellido') }}"
                   class="w-full border p-2 rounded @error('apellido') border-red-500 @enderror">
            @error('apellido') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1">Correo</label>
            <input type="email" name="correo" value="{{ old('correo') }}"
                   class="w-full border p-2 rounded @error('correo') border-red-500 @enderror">
            @error('correo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1">Contraseña</label>
            <input type="password" name="password"
                   class="w-full border p-2 rounded @error('password') border-red-500 @enderror">
            @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block mb-1">Confirmar Contraseña</label>
            <input type="password" name="password_confirmation"
                   class="w-full border p-2 rounded">
        </div>

        <button type="submit"
                class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
            Registrarme
        </button>
    </form>
</div>
@endsection
