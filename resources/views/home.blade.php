@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <section class="text-center">
        <h2 class="text-4xl font-bold mb-4 text-green-700">Bienvenido a Indaluz</h2>
        <p class="text-lg text-gray-700 mb-6 max-w-2xl mx-auto">
            Compra frutas, verduras y hortalizas frescas directamente desde los agricultores de Almería.
            Apoya el comercio local y accede a productos de calidad sin intermediarios.
        </p>

        <div class="flex justify-center gap-4">
            <a href="#" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
                Ver Productos
            </a>
            <a href="#" class="bg-white text-green-600 border border-green-600 px-6 py-2 rounded-lg hover:bg-green-100 transition">
                Conoce Más
            </a>
        </div>
    </section>
@endsection
