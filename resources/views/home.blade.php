@extends('layouts.app')

@section('title', 'Inicio')

@section('content')

<!-- HERO -->
<section class="relative w-full h-96 bg-cover bg-center rounded-xl overflow-hidden mb-12" style="background-image: url('/images/frutas-header.jpg')">
    <div class="absolute inset-0 bg-green-900 bg-opacity-50 flex items-center justify-center text-center text-white px-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Frescura directa desde el campo</h1>
            <p class="mb-6 text-lg">Conecta con agricultores locales y disfruta productos frescos, sostenibles y saludables.</p>
            <a href="#" class="bg-white text-green-700 px-6 py-2 rounded font-semibold hover:bg-green-100 transition">Empieza ahora</a>
        </div>
    </div>
</section>

<!-- ICONOS DE BENEFICIOS -->
<section class="grid grid-cols-2 md:grid-cols-5 text-center gap-6 mb-12">
    <div>
        <i data-lucide="truck" class="mx-auto w-8 h-8 text-green-600 mb-2"></i>
        <p class="font-semibold text-sm">Envíos</p>
    </div>
    <div>
        <i data-lucide="rotate-ccw" class="mx-auto w-8 h-8 text-green-600 mb-2"></i>
        <p class="font-semibold text-sm">Devoluciones</p>
    </div>
    <div>
        <i data-lucide="lock" class="mx-auto w-8 h-8 text-green-600 mb-2"></i>
        <p class="font-semibold text-sm">Pagos seguros</p>
    </div>
    <div>
        <i data-lucide="badge-dollar-sign" class="mx-auto w-8 h-8 text-green-600 mb-2"></i>
        <p class="font-semibold text-sm">Precios justos</p>
    </div>
    <div>
        <i data-lucide="check-circle" class="mx-auto w-8 h-8 text-green-600 mb-2"></i>
        <p class="font-semibold text-sm">Máxima calidad</p>
    </div>
</section>

<!-- ¿POR QUÉ ELEGIRNOS? -->
<section class="text-center mb-16">
    <h2 class="text-3xl font-bold text-green-700 mb-6">¿Por qué elegirnos?</h2>
    <div class="grid md:grid-cols-2 gap-6 max-w-5xl mx-auto">
        <div class="bg-green-100 p-6 rounded-xl shadow-sm">
            <p class="text-gray-800 font-medium">Ofrecemos productos frescos y de calidad directamente del agricultor a su mesa.</p>
        </div>
        <div class="bg-green-100 p-6 rounded-xl shadow-sm">
            <p class="text-gray-800 font-medium">Comprometidos con prácticas sostenibles para cuidar el medio ambiente.</p>
        </div>
        <div class="bg-green-100 p-6 rounded-xl shadow-sm">
            <p class="text-gray-800 font-medium">Pagos seguros y políticas de devolución flexibles.</p>
        </div>
        <div class="bg-green-100 p-6 rounded-xl shadow-sm">
            <p class="text-gray-800 font-medium">Precios justos que benefician tanto al consumidor como al agricultor.</p>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="text-center bg-green-700 text-white py-12 rounded-xl mb-16">
    <h3 class="text-2xl font-semibold mb-4">¡Únete a la revolución verde!</h3>
    <p class="mb-6">Crea tu cuenta y empieza a apoyar el comercio local hoy mismo.</p>
    <a href="#" class="bg-white text-green-700 px-6 py-2 rounded hover:bg-green-100 transition">Registrarse</a>
</section>

<!-- CONTACTO + REDES -->
<section class="grid md:grid-cols-2 gap-8 mb-16">
    <div>
        <h4 class="text-xl font-bold mb-4">Síguenos en redes</h4>
        <div class="flex gap-4 mb-4 text-green-600">
            <i data-lucide="facebook" class="w-6 h-6"></i>
            <i data-lucide="instagram" class="w-6 h-6"></i>
            <i data-lucide="twitter" class="w-6 h-6"></i>
        </div>
        <p class="text-sm">Email: <a href="mailto:contacto@indaluz.com" class="text-green-700 font-medium">contacto@indaluz.com</a></p>
        <p class="text-sm">Tel: +34 123 456 789</p>
    </div>

    <div>
        <h4 class="text-xl font-bold mb-4">Contáctanos</h4>
        <form class="space-y-4">
            <input type="text" placeholder="Nombre" class="w-full border border-gray-300 p-2 rounded">
            <input type="email" placeholder="Correo" class="w-full border border-gray-300 p-2 rounded">
            <textarea placeholder="Mensaje" class="w-full border border-gray-300 p-2 rounded h-28"></textarea>
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Enviar</button>
        </form>
    </div>
</section>

@endsection
