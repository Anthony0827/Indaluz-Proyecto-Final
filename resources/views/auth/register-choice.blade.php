@extends('layouts.app')

@section('title', 'Registro')

@section('content')
<div class="max-w-lg mx-auto text-center py-12">
    <h2 class="text-3xl font-bold text-green-700 mb-6">¿Cómo deseas registrarte?</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <a href="{{ route('register.role', 'cliente') }}"
           class="bg-white border-2 border-green-600 rounded-lg shadow p-6 hover:bg-green-50 transition">
            <i data-lucide="user" class="w-12 h-12 text-green-600 mx-auto mb-4"></i>
            <h3 class="font-semibold">Como Cliente</h3>
        </a>
        <a href="{{ route('register.role', 'agricultor') }}"
           class="bg-white border-2 border-green-600 rounded-lg shadow p-6 hover:bg-green-50 transition">
            <i data-lucide="leaf" class="w-12 h-12 text-green-600 mx-auto mb-4"></i>
            <h3 class="font-semibold">Como Agricultor</h3>
        </a>
    </div>
</div>
<script>lucide.createIcons()</script>
@endsection
