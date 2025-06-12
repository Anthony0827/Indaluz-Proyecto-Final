@extends('layouts.app')

@section('title', 'Contacto - Indaluz')

@section('content')

<!-- HERO CONTACTO -->
<section class="relative w-full h-64 bg-cover bg-center rounded-xl overflow-hidden mb-12" style="background-image: url('/images/almeria-paisaje.jpg')">
    <div class="absolute inset-0 bg-green-900 bg-opacity-60 flex items-center justify-center text-center text-white px-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Contacta con Nosotros</h1>
            <p class="text-lg">Estamos aquí para ayudarte con cualquier consulta</p>
        </div>
    </div>
</section>

<!-- INFORMACIÓN DE CONTACTO -->
<section class="mb-16">
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-3 gap-8 mb-12">
            <!-- Teléfono -->
            <div class="text-center bg-white p-6 rounded-xl shadow-md">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="phone" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-2">Teléfono</h3>
                <p class="text-gray-600 mb-2">Llámanos de lunes a viernes</p>
                <p class="font-semibold text-green-700">+34 950 123 456</p>
                <p class="text-sm text-gray-500 mt-1">9:00 - 18:00 h</p>
            </div>

            <!-- Email -->
            <div class="text-center bg-white p-6 rounded-xl shadow-md">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="mail" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-2">Email</h3>
                <p class="text-gray-600 mb-2">Escríbenos cuando quieras</p>
                <p class="font-semibold text-green-700">contacto@indaluz.com</p>
                <p class="text-sm text-gray-500 mt-1">Respuesta en 24h</p>
            </div>

            <!-- Ubicación -->
            <div class="text-center bg-white p-6 rounded-xl shadow-md">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="map-pin" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-2">Ubicación</h3>
                <p class="text-gray-600 mb-2">Oficinas centrales</p>
                <p class="font-semibold text-green-700">Almería, Andalucía</p>
                <p class="text-sm text-gray-500 mt-1">España</p>
            </div>
        </div>
    </div>
</section>

<!-- FORMULARIO DE CONTACTO Y MAPA -->
<section class="mb-16">
    <div class="max-w-6xl mx-auto">
        <div class="grid md:grid-cols-2 gap-12">
            <!-- Formulario -->
            <div>
                <h2 class="text-3xl font-bold text-green-700 mb-6">Envíanos un Mensaje</h2>
                <form class="space-y-6" action="#" method="POST">
                    @csrf
                    
                    <!-- Nombre y Email -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre completo *
                            </label>
                            <input 
                                type="text" 
                                id="nombre" 
                                name="nombre" 
                                required
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                placeholder="Tu nombre completo"
                            >
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Correo electrónico *
                            </label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                placeholder="tu@email.com"
                            >
                        </div>
                    </div>

                    <!-- Teléfono y Tipo de Usuario -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                                Teléfono
                            </label>
                            <input 
                                type="tel" 
                                id="telefono" 
                                name="telefono"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                                placeholder="+34 600 000 000"
                            >
                        </div>
                        <div>
                            <label for="tipo_usuario" class="block text-sm font-medium text-gray-700 mb-2">
                                Tipo de usuario *
                            </label>
                            <select 
                                id="tipo_usuario" 
                                name="tipo_usuario" 
                                required
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                            >
                                <option value="">Seleccionar...</option>
                                <option value="consumidor">Consumidor</option>
                                <option value="agricultor">Agricultor</option>
                                <option value="empresa">Empresa/Restaurante</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                    </div>

                    <!-- Asunto -->
                    <div>
                        <label for="asunto" class="block text-sm font-medium text-gray-700 mb-2">
                            Asunto *
                        </label>
                        <select 
                            id="asunto" 
                            name="asunto" 
                            required
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                        >
                            <option value="">Selecciona un tema...</option>
                            <option value="soporte_tecnico">Soporte técnico</option>
                            <option value="info_productos">Información sobre productos</option>
                            <option value="registro_agricultor">Registro como agricultor</option>
                            <option value="problemas_pedido">Problemas con pedido</option>
                            <option value="sugerencias">Sugerencias y mejoras</option>
                            <option value="colaboraciones">Colaboraciones empresariales</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>

                    <!-- Mensaje -->
                    <div>
                        <label for="mensaje" class="block text-sm font-medium text-gray-700 mb-2">
                            Mensaje *
                        </label>
                        <textarea 
                            id="mensaje" 
                            name="mensaje" 
                            rows="6" 
                            required
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500 transition resize-none"
                            placeholder="Describe tu consulta o mensaje con el mayor detalle posible..."
                        ></textarea>
                    </div>

                    <!-- Consentimiento RGPD -->
                    <div class="flex items-start space-x-3">
                        <input 
                            type="checkbox" 
                            id="rgpd" 
                            name="rgpd" 
                            required
                            class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500"
                        >
                        <label for="rgpd" class="text-sm text-gray-600">
                            Acepto que Indaluz trate mis datos personales para responder a mi consulta según la 
                            <a href="#" class="text-green-600 underline">Política de Privacidad</a> *
                        </label>
                    </div>

                    <!-- Newsletter -->
                    <div class="flex items-start space-x-3">
                        <input 
                            type="checkbox" 
                            id="newsletter" 
                            name="newsletter"
                            class="mt-1 rounded border-gray-300 text-green-600 focus:ring-green-500"
                        >
                        <label for="newsletter" class="text-sm text-gray-600">
                            Quiero recibir novedades y ofertas especiales de Indaluz por email
                        </label>
                    </div>

                    <!-- Botón Enviar -->
                    <div>
                        <button 
                            type="submit" 
                            class="w-full bg-green-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition"
                        >
                            Enviar Mensaje
                        </button>
                    </div>
                </form>
            </div>

            <!-- Mapa e Información Adicional -->
            <div>
                <h2 class="text-3xl font-bold text-green-700 mb-6">Nuestra Ubicación</h2>
                
                <!-- Mapa Placeholder -->
                <div class="bg-green-100 h-64 rounded-xl mb-6 flex items-center justify-center">
                    <div class="text-center text-green-600">
                        <i data-lucide="map" class="w-16 h-16 mx-auto mb-2"></i>
                        <p class="font-medium">Mapa de Almería</p>
                        <p class="text-sm">Oficinas centrales de Indaluz</p>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div class="space-y-6">
                    <div class="bg-green-50 p-6 rounded-xl">
                        <h3 class="text-xl font-semibold text-green-700 mb-3">Horarios de Atención</h3>
                        <div class="space-y-2 text-gray-700">
                            <div class="flex justify-between">
                                <span>Lunes - Viernes:</span>
                                <span class="font-medium">9:00 - 18:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Sábados:</span>
                                <span class="font-medium">10:00 - 14:00</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Domingos:</span>
                                <span class="font-medium">Cerrado</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <h3 class="text-xl font-semibold text-green-700 mb-3">Soporte Urgente</h3>
                        <p class="text-gray-600 mb-3">
                            Para problemas urgentes con pedidos o entregas, contacta directamente:
                        </p>
                        <div class="space-y-2">
                            <p class="flex items-center text-green-700">
                                <i data-lucide="phone" class="w-4 h-4 mr-2"></i>
                                <span class="font-semibold">+34 950 999 888</span>
                            </p>
                            <p class="flex items-center text-green-700">
                                <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                                <span class="font-semibold">urgente@indaluz.com</span>
                            </p>
                        </div>
                        <p class="text-sm text-gray-500 mt-2">
                            Disponible 24/7 para emergencias
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ RÁPIDAS -->
<section class="bg-green-50 py-12 rounded-xl mb-16">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Preguntas Frecuentes</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <!-- FAQ 1 -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-green-700 mb-2">¿Cómo puedo registrarme como agricultor?</h3>
                <p class="text-gray-600 text-sm">
                    Es muy sencillo. Solo necesitas tu DNI, certificado de explotación agraria y una cuenta bancaria. 
                    El proceso de registro toma menos de 10 minutos.
                </p>
            </div>

            <!-- FAQ 2 -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-green-700 mb-2">¿Cuánto tarda en llegar mi pedido?</h3>
                <p class="text-gray-600 text-sm">
                    Los pedidos se entregan entre 24-48 horas desde la confirmación. Los productos más frescos 
                    pueden estar disponibles para recogida el mismo día.
                </p>
            </div>

            <!-- FAQ 3 -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-green-700 mb-2">¿Qué comisión cobráis a los agricultores?</h3>
                <p class="text-gray-600 text-sm">
                    Solo cobramos un 5% de comisión por venta realizada. Sin cuotas mensuales ni costes ocultos. 
                    Si no vendes, no pagas nada.
                </p>
            </div>

            <!-- FAQ 4 -->
            <div class="bg-white p-6 rounded-xl shadow-sm">
                <h3 class="text-lg font-semibold text-green-700 mb-2">¿Ofrecéis garantía de calidad?</h3>
                <p class="text-gray-600 text-sm">
                    Sí, todos nuestros productos están garantizados. Si no estás satisfecho, te devolvemos el dinero 
                    o reemplazamos el producto sin preguntas.
                </p>
            </div>
        </div>
        
        <div class="text-center mt-8">
            <p class="text-gray-600 mb-4">¿No encuentras la respuesta que buscas?</p>
            <a href="#" class="text-green-600 font-semibold hover:text-green-700 underline">
                Ver todas las preguntas frecuentes
            </a>
        </div>
    </div>
</section>

<!-- REDES SOCIALES -->
<section class="mb-16">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-green-700 mb-6">Síguenos en Redes Sociales</h2>
        <p class="text-gray-600 mb-8">
            Mantente al día con las últimas novedades, productos de temporada y consejos de nuestros agricultores.
        </p>
        
        <div class="flex justify-center space-x-6 mb-8">
            <!-- Facebook -->
            <a href="#" class="bg-green-600 text-white p-4 rounded-full hover:bg-green-700 transition">
                <i data-lucide="facebook" class="w-6 h-6"></i>
            </a>
            
            <!-- Instagram -->
            <a href="#" class="bg-green-600 text-white p-4 rounded-full hover:bg-green-700 transition">
                <i data-lucide="instagram" class="w-6 h-6"></i>
            </a>
            
            <!-- Twitter -->
            <a href="#" class="bg-green-600 text-white p-4 rounded-full hover:bg-green-700 transition">
                <i data-lucide="twitter" class="w-6 h-6"></i>
            </a>
            
            <!-- LinkedIn -->
            <a href="#" class="bg-green-600 text-white p-4 rounded-full hover:bg-green-700 transition">
                <i data-lucide="linkedin" class="w-6 h-6"></i>
            </a>
            
            <!-- YouTube -->
            <a href="#" class="bg-green-600 text-white p-4 rounded-full hover:bg-green-700 transition">
                <i data-lucide="youtube" class="w-6 h-6"></i>
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-6 text-sm">
            <div class="bg-white p-4 rounded-xl shadow-sm">
                <i data-lucide="facebook" class="w-8 h-8 text-green-600 mx-auto mb-2"></i>
                <p class="font-medium text-gray-800">@IndaluzAlmeria</p>
                <p class="text-gray-600">Noticias y actualizaciones diarias</p>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-sm">
                <i data-lucide="instagram" class="w-8 h-8 text-green-600 mx-auto mb-2"></i>
                <p class="font-medium text-gray-800">@indaluz_oficial</p>
                <p class="text-gray-600">Fotos de productos y recetas</p>
            </div>
            
            <div class="bg-white p-4 rounded-xl shadow-sm">
                <i data-lucide="youtube" class="w-8 h-8 text-green-600 mx-auto mb-2"></i>
                <p class="font-medium text-gray-800">Indaluz TV</p>
                <p class="text-gray-600">Tutoriales y documentales</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA FINAL -->
<section class="text-center bg-gradient-to-r from-green-600 to-green-700 text-white py-12 rounded-xl">
    <h3 class="text-2xl font-semibold mb-4">¿Tienes alguna Duda?</h3>
    <p class="mb-6 max-w-2xl mx-auto">
        Nuestro equipo está aquí para ayudarte. No dudes en contactarnos por cualquier medio, 
        estaremos encantados de resolver todas tus consultas.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="tel:+34950123456" class="bg-white text-green-700 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition">
            Llamar Ahora
        </a>
        <a href="mailto:contacto@indaluz.com" class="bg-green-800 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-900 transition border border-green-400">
            Enviar Email
        </a>
    </div>
</section>

@endsection