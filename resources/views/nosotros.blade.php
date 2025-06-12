@extends('layouts.app')

@section('title', 'Nosotros - Indaluz')

@section('content')

<!-- HERO NOSOTROS -->
<section class="relative w-full h-80 bg-cover bg-center rounded-xl overflow-hidden mb-12" style="background-image: url('/images/equipo-indaluz.jpg')">
    <div class="absolute inset-0 bg-green-800 bg-opacity-60 flex items-center justify-center text-center text-white px-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Conoce Indaluz</h1>
            <p class="text-lg max-w-2xl">Nuestra historia, valores y compromiso con la agricultura andaluza</p>
        </div>
    </div>
</section>

<!-- NUESTRA HISTORIA -->
<section class="mb-16">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Nuestra Historia</h2>
        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div>
                <p class="text-gray-700 mb-4">
                    Indaluz nació en el corazón de Almería con una misión clara: conectar directamente a los agricultores locales con consumidores que valoran la calidad, frescura y sostenibilidad de los productos andaluces.
                </p>
                <p class="text-gray-700 mb-4">
                    Fundada por un grupo de jóvenes emprendedores comprometidos con el desarrollo rural, nuestra plataforma surge como respuesta a la necesidad de modernizar la comercialización agrícola tradicional.
                </p>
                <p class="text-gray-700">
                    Desde nuestros inicios, hemos trabajado incansablemente para crear un ecosistema digital que beneficie tanto a productores como a consumidores, eliminando intermediarios innecesarios y garantizando precios justos.
                </p>
            </div>
            <div class="bg-green-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold text-green-700 mb-4">Cifras que nos avalan</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Agricultores registrados:</span>
                        <span class="font-semibold text-green-700">150+</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Productos disponibles:</span>
                        <span class="font-semibold text-green-700">500+</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Pedidos completados:</span>
                        <span class="font-semibold text-green-700">2,500+</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Clientes satisfechos:</span>
                        <span class="font-semibold text-green-700">800+</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- NUESTROS VALORES -->
<section class="bg-green-50 py-12 rounded-xl mb-16">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Nuestros Valores</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Transparencia -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="eye" class="w-8 h-8 text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Transparencia</h3>
                <p class="text-gray-700">
                    Creemos en la transparencia total: origen de los productos, métodos de cultivo y precios justos para todos.
                </p>
            </div>
            
            <!-- Sostenibilidad -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="leaf" class="w-8 h-8 text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Sostenibilidad</h3>
                <p class="text-gray-700">
                    Promovemos prácticas agrícolas sostenibles que respeten el medio ambiente y las generaciones futuras.
                </p>
            </div>
            
            <!-- Comunidad -->
            <div class="text-center">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="users" class="w-8 h-8 text-white"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Comunidad</h3>
                <p class="text-gray-700">
                    Fortalecemos la comunidad agrícola local, creando vínculos duraderos entre productores y consumidores.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- NUESTRO EQUIPO -->
<section class="mb-16">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Nuestro Equipo</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Miembro 1 -->
            <div class="text-center">
                <div class="w-32 h-32 bg-green-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i data-lucide="user" class="w-16 h-16 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Anthony Ramos</h3>
                <p class="text-green-600 font-medium mb-2">Fundador y CEO</p>
                <p class="text-gray-600 text-sm">
                    Ingeniero agrónomo con más de 5 años de experiencia en desarrollo rural y tecnología aplicada al sector agrícola.
                </p>
            </div>
            
            <!-- Miembro 2 -->
            <div class="text-center">
                <div class="w-32 h-32 bg-green-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i data-lucide="user" class="w-16 h-16 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">María González</h3>
                <p class="text-green-600 font-medium mb-2">Directora de Operaciones</p>
                <p class="text-gray-600 text-sm">
                    Especialista en logística y cadena de suministro, garantiza la calidad y frescura de todos nuestros productos.
                </p>
            </div>
            
            <!-- Miembro 3 -->
            <div class="text-center">
                <div class="w-32 h-32 bg-green-200 rounded-full mx-auto mb-4 flex items-center justify-center">
                    <i data-lucide="user" class="w-16 h-16 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Carlos Martín</h3>
                <p class="text-green-600 font-medium mb-2">Responsable Técnico</p>
                <p class="text-gray-600 text-sm">
                    Desarrollador full-stack encargado de mantener y mejorar continuamente nuestra plataforma tecnológica.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- MISIÓN Y VISIÓN -->
<section class="grid md:grid-cols-2 gap-8 mb-16">
    <!-- Misión -->
    <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-green-500">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                <i data-lucide="target" class="w-6 h-6 text-green-600"></i>
            </div>
            <h3 class="text-2xl font-bold text-green-700">Nuestra Misión</h3>
        </div>
        <p class="text-gray-700 leading-relaxed">
            Facilitar el acceso a productos agrícolas frescos, locales y de calidad, conectando directamente a agricultores y consumidores a través de una plataforma digital innovadora que promueva el comercio justo y sostenible en Andalucía.
        </p>
    </div>
    
    <!-- Visión -->
    <div class="bg-white p-8 rounded-xl shadow-md border-l-4 border-green-500">
        <div class="flex items-center mb-6">
            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4">
                <i data-lucide="eye" class="w-6 h-6 text-green-600"></i>
            </div>
            <h3 class="text-2xl font-bold text-green-700">Nuestra Visión</h3>
        </div>
        <p class="text-gray-700 leading-relaxed">
            Ser la plataforma líder en la comercialización de productos agrícolas locales en Andalucía, transformando la manera en que se conectan productores y consumidores, y contribuyendo al desarrollo sostenible del sector agrícola regional.
        </p>
    </div>
</section>

<!-- CTA ÚNETE -->
<section class="text-center bg-gradient-to-r from-green-600 to-green-700 text-white py-12 rounded-xl">
    <h3 class="text-2xl font-semibold mb-4">¿Quieres formar parte de Indaluz?</h3>
    <p class="mb-6 max-w-2xl mx-auto">
        Ya seas agricultor buscando nuevos canales de venta o consumidor interesado en productos frescos y locales, te invitamos a unirte a nuestra comunidad.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="#" class="bg-white text-green-700 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition">
            Soy Agricultor
        </a>
        <a href="#" class="bg-green-800 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-900 transition border border-green-400">
            Soy Consumidor
        </a>
    </div>
</section>

@endsection