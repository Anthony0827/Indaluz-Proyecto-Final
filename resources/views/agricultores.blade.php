@extends('layouts.app')

@section('title', 'Para Agricultores - Indaluz')

@section('content')

<!-- HERO AGRICULTORES -->
<section class="relative w-full h-80 bg-cover bg-center rounded-xl overflow-hidden mb-12" style="background-image: url('/images/agricultor-campo.jpg')">
    <div class="absolute inset-0 bg-green-900 bg-opacity-60 flex items-center justify-center text-center text-white px-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Vende Directamente</h1>
            <p class="text-lg max-w-3xl">Conecta con miles de consumidores y obtén mejores precios por tus productos</p>
        </div>
    </div>
</section>

<!-- BENEFICIOS PARA AGRICULTORES -->
<section class="mb-16">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">¿Por qué elegir Indaluz?</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Beneficio 1 -->
            <div class="text-center bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="trending-up" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Mejores Precios</h3>
                <p class="text-gray-600">
                    Elimina intermediarios y obtén hasta un 40% más de beneficios vendiendo directamente al consumidor.
                </p>
            </div>

            <!-- Beneficio 2 -->
            <div class="text-center bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="users" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Alcance Amplio</h3>
                <p class="text-gray-600">
                    Accede a una base de más de 800 clientes activos en toda la provincia de Almería.
                </p>
            </div>

            <!-- Beneficio 3 -->
            <div class="text-center bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="smartphone" class="w-8 h-8 text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Gestión Fácil</h3>
                <p class="text-gray-600">
                    Administra tu inventario, precios y pedidos desde una plataforma intuitiva y fácil de usar.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CÓMO FUNCIONA -->
<section class="bg-green-50 py-12 rounded-xl mb-16">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Cómo Empezar en 3 Pasos</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Paso 1 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">1</span>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Regístrate</h3>
                <p class="text-gray-700">
                    Crea tu perfil de agricultor con información básica sobre tu explotación y productos principales.
                </p>
            </div>

            <!-- Paso 2 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">2</span>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Sube Productos</h3>
                <p class="text-gray-700">
                    Añade tus productos con fotos, descripciones, precios y disponibilidad. ¡Es muy sencillo!
                </p>
            </div>

            <!-- Paso 3 -->
            <div class="text-center">
                <div class="w-20 h-20 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">3</span>
                </div>
                <h3 class="text-xl font-semibold text-green-700 mb-3">Vende</h3>
                <p class="text-gray-700">
                    Recibe pedidos, gestiona las entregas y cobra directamente. ¡Así de simple!
                </p>
            </div>
        </div>
    </div>
</section>

<!-- HERRAMIENTAS DISPONIBLES -->
<section class="mb-16">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Herramientas para tu Negocio</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Panel de Control -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i data-lucide="bar-chart-3" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-green-700 mb-2">Panel de Control</h3>
                        <p class="text-gray-600 mb-3">
                            Visualiza tus ventas, productos más populares y estadísticas de rendimiento en tiempo real.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Estadísticas de ventas detalladas</li>
                            <li>• Análisis de productos más vendidos</li>
                            <li>• Tendencias de demanda por temporada</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Gestión de Inventario -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i data-lucide="package" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-green-700 mb-2">Gestión de Inventario</h3>
                        <p class="text-gray-600 mb-3">
                            Mantén actualizado tu stock y recibe alertas automáticas cuando se agoten los productos.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Actualización automática de stock</li>
                            <li>• Alertas de productos agotados</li>
                            <li>• Programación de cosechas futuras</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Comunicación con Clientes -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i data-lucide="message-circle" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-green-700 mb-2">Comunicación Directa</h3>
                        <p class="text-gray-600 mb-3">
                            Interactúa directamente con tus clientes, resuelve dudas y construye relaciones duraderas.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Chat integrado con compradores</li>
                            <li>• Sistema de valoraciones</li>
                            <li>• Notificaciones de pedidos</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Promociones y Ofertas -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-start space-x-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <i data-lucide="tag" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold text-green-700 mb-2">Promociones Inteligentes</h3>
                        <p class="text-gray-600 mb-3">
                            Crea ofertas especiales y promociona productos próximos a vencerse para evitar desperdicios.
                        </p>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Descuentos por volumen</li>
                            <li>• Ofertas flash temporales</li>
                            <li>• Promociones anti-desperdicio</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIOS -->
<section class="mb-16">
    <div class="max-w-6xl mx-auto">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Lo que Dicen Nuestros Agricultores</h2>
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Testimonio 1 -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center mr-3">
                        <i data-lucide="user" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">José Martinez</h4>
                        <p class="text-sm text-gray-600">Huerta El Olivar</p>
                    </div>
                </div>
                <p class="text-gray-700 text-sm italic">
                    "Desde que uso Indaluz, mis ingresos han aumentado un 35%. La plataforma es muy fácil de usar y los clientes valoran mucho la frescura de mis productos."
                </p>
                <div class="flex text-yellow-400 mt-3">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                </div>
            </div>

            <!-- Testimonio 2 -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center mr-3">
                        <i data-lucide="user" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Carmen López</h4>
                        <p class="text-sm text-gray-600">Finca Los Naranjos</p>
                    </div>
                </div>
                <p class="text-gray-700 text-sm italic">
                    "Lo mejor es que puedo vender directamente sin intermediarios. Los pagos son puntuales y el soporte técnico siempre está disponible cuando lo necesito."
                </p>
                <div class="flex text-yellow-400 mt-3">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                </div>
            </div>

            <!-- Testimonio 3 -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-200 rounded-full flex items-center justify-center mr-3">
                        <i data-lucide="user" class="w-6 h-6 text-green-600"></i>
                    </div>
                    <div>
                        <h4 class="font-semibold text-gray-800">Miguel Ruiz</h4>
                        <p class="text-sm text-gray-600">Cooperativa Verde</p>
                    </div>
                </div>
                <p class="text-gray-700 text-sm italic">
                    "La función de ofertas especiales me ha ayudado a reducir el desperdicio casi por completo. Ahora todo lo que produzco se vende, y eso es fantástico."
                </p>
                <div class="flex text-yellow-400 mt-3">
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRECIOS Y COMISIONES -->
<section class="bg-gradient-to-r from-green-600 to-green-700 text-white py-12 rounded-xl mb-16">
    <div class="max-w-4xl mx-auto text-center px-6">
        <h2 class="text-3xl font-bold mb-6">Tarifas Transparentes</h2>
        <p class="text-lg mb-8">
            Sin costes ocultos ni suscripciones mensuales. Solo pagas una pequeña comisión por venta realizada.
        </p>
        <div class="grid md:grid-cols-2 gap-8 mb-8">
            <div class="bg-white bg-opacity-20 p-6 rounded-xl">
                <h3 class="text-2xl font-bold mb-2">5%</h3>
                <p class="text-lg font-semibold mb-2">Comisión por Venta</p>
                <p class="text-sm">
                    Solo pagas cuando vendes. Sin cuotas mensuales ni costes de mantenimiento.
                </p>
            </div>
            <div class="bg-white bg-opacity-20 p-6 rounded-xl">
                <h3 class="text-2xl font-bold mb-2">0€</h3>
                <p class="text-lg font-semibold mb-2">Registro y Alta</p>
                <p class="text-sm">
                    Completamente gratuito darte de alta y empezar a usar todas nuestras herramientas.
                </p>
            </div>
        </div>
        <div class="bg-white bg-opacity-10 p-4 rounded-lg mb-6">
            <p class="text-sm">
                <strong>Ejemplo:</strong> Si vendes productos por valor de 100€, pagas solo 5€ de comisión. El 95% restante es para ti.
            </p>
        </div>
    </div>
</section>

<!-- REQUISITOS -->
<section class="mb-16">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Requisitos para Unirte</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-semibold text-green-700 mb-4">Documentación Necesaria</h3>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-2"></i>
                        DNI o NIE del titular
                    </li>
                    <li class="flex items-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-2"></i>
                        Certificado de explotación agraria
                    </li>
                    <li class="flex items-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-2"></i>
                        Seguro de responsabilidad civil (opcional)
                    </li>
                    <li class="flex items-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-green-600 mr-2"></i>
                        Cuenta bancaria para recibir pagos
                    </li>
                </ul>
            </div>
            <div class="bg-green-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold text-green-700 mb-4">Condiciones Básicas</h3>
                <ul class="space-y-2 text-gray-700">
                    <li class="flex items-center">
                        <i data-lucide="map-pin" class="w-5 h-5 text-green-600 mr-2"></i>
                        Explotación ubicada en Almería
                    </li>
                    <li class="flex items-center">
                        <i data-lucide="leaf" class="w-5 h-5 text-green-600 mr-2"></i>
                        Productos frescos y de calidad
                    </li>
                    <li class="flex items-center">
                        <i data-lucide="shield-check" class="w-5 h-5 text-green-600 mr-2"></i>
                        Cumplimiento normativas sanitarias
                    </li>
                    <li class="flex items-center">
                        <i data-lucide="clock" class="w-5 h-5 text-green-600 mr-2"></i>
                        Disponibilidad para gestionar pedidos
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- CTA REGISTRO -->
<section class="text-center bg-green-50 py-12 rounded-xl">
    <h3 class="text-3xl font-bold text-green-700 mb-4">¿Listo para Empezar?</h3>
    <p class="text-gray-700 mb-8 max-w-2xl mx-auto">
        Únete a los más de 150 agricultores que ya están vendiendo a través de Indaluz. El registro es gratuito y puedes empezar a vender en menos de 24 horas.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="#" class="bg-green-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
            Registrarse como Agricultor
        </a>
        <a href="#" class="bg-white text-green-700 px-8 py-3 rounded-lg font-semibold border-2 border-green-600 hover:bg-green-50 transition">
            Solicitar Demostración
        </a>
    </div>
    <p class="text-sm text-gray-600 mt-4">
        ¿Tienes dudas? <a href="#" class="text-green-600 underline">Contáctanos</a> y te ayudamos sin compromiso.
    </p>
</section>

@endsection