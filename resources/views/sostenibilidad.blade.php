@extends('layouts.app')

@section('title', 'Sostenibilidad - Indaluz')

@section('content')

<!-- HERO SOSTENIBILIDAD -->
<section class="relative w-full h-80 bg-cover bg-center rounded-xl overflow-hidden mb-12" style="background-image: url('/images/agricultura-sostenible.jpg')">
    <div class="absolute inset-0 bg-green-900/60 flex items-center justify-center text-center text-white px-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Compromiso Verde</h1>
            <p class="text-lg max-w-3xl">Cultivando el futuro de manera responsable y sostenible</p>
        </div>
    </div>
</section>

<!-- INTRODUCCIÓN -->
<section class="mb-16">
    <div class="max-w-4xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-green-700 mb-6">Agricultura Sostenible para un Futuro Mejor</h2>
        <p class="text-lg text-gray-700 leading-relaxed">
            En Indaluz creemos que la sostenibilidad no es solo una opción, sino una responsabilidad. Trabajamos junto a nuestros agricultores para promover prácticas que cuiden tanto de la tierra como de las personas que la habitan.
        </p>
    </div>
</section>

<!-- NUESTROS PILARES SOSTENIBLES -->
<section class="mb-16">
    <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Nuestros Pilares Sostenibles</h2>
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Pilar 1: Agricultura Ecológica -->
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="sprout" class="w-8 h-8 text-green-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-green-700 mb-3 text-center">Agricultura Ecológica</h3>
            <p class="text-gray-600 text-sm text-center">
                Promovemos el uso de técnicas agrícolas que respetan los ciclos naturales y evitan químicos nocivos.
            </p>
        </div>

        <!-- Pilar 2: Reducción de Residuos -->
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="recycle" class="w-8 h-8 text-green-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-green-700 mb-3 text-center">Reducción de Residuos</h3>
            <p class="text-gray-600 text-sm text-center">
                Implementamos estrategias para minimizar el desperdicio alimentario y promover el aprovechamiento total.
            </p>
        </div>

        <!-- Pilar 3: Energía Renovable -->
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="sun" class="w-8 h-8 text-green-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-green-700 mb-3 text-center">Energía Renovable</h3>
            <p class="text-gray-600 text-sm text-center">
                Apostamos por fuentes de energía limpia en nuestras operaciones y las de nuestros colaboradores.
            </p>
        </div>

        <!-- Pilar 4: Comercio Justo -->
        <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-lg transition-shadow">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="handshake" class="w-8 h-8 text-green-600"></i>
            </div>
            <h3 class="text-xl font-semibold text-green-700 mb-3 text-center">Comercio Justo</h3>
            <p class="text-gray-600 text-sm text-center">
                Garantizamos precios justos que permiten a los agricultores obtener beneficios dignos por su trabajo.
            </p>
        </div>
    </div>
</section>

<!-- PRÁCTICAS SOSTENIBLES -->
<section class="bg-green-50 py-12 rounded-xl mb-16">
    <div class="max-w-6xl mx-auto px-6">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Prácticas que Implementamos</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Práctica 1 -->
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                    <i data-lucide="droplets" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-green-700 mb-2">Gestión Eficiente del Agua</h3>
                    <p class="text-gray-700">
                        Implementamos sistemas de riego por goteo y tecnologías de monitoreo que reducen el consumo de agua hasta un 40% comparado con métodos tradicionales.
                    </p>
                </div>
            </div>

            <!-- Práctica 2 -->
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                    <i data-lucide="shield-check" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-green-700 mb-2">Control Biológico de Plagas</h3>
                    <p class="text-gray-700">
                        Fomentamos el uso de enemigos naturales de las plagas y métodos preventivos que reducen la necesidad de pesticidas químicos.
                    </p>
                </div>
            </div>

            <!-- Práctica 3 -->
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                    <i data-lucide="leaf" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-green-700 mb-2">Fertilización Orgánica</h3>
                    <p class="text-gray-700">
                        Promovemos el uso de compost y fertilizantes orgánicos que mejoran la estructura del suelo y mantienen su biodiversidad.
                    </p>
                </div>
            </div>

            <!-- Práctica 4 -->
            <div class="flex items-start space-x-4">
                <div class="w-12 h-12 bg-green-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                    <i data-lucide="truck" class="w-6 h-6 text-white"></i>
                </div>
                <div>
                    <h3 class="text-xl font-semibold text-green-700 mb-2">Logística Verde</h3>
                    <p class="text-gray-700">
                        Optimizamos las rutas de entrega y utilizamos embalajes biodegradables para reducir la huella de carbono del transporte.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- IMPACTO AMBIENTAL -->
<section class="mb-16">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Nuestro Impacto Ambiental</h2>
        <div class="grid md:grid-cols-2 gap-8">
            <!-- Estadísticas Positivas -->
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-xl font-semibold text-green-700 mb-6">Logros Ambientales</h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Reducción de pesticidas:</span>
                        <span class="text-2xl font-bold text-green-600">60%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Ahorro de agua:</span>
                        <span class="text-2xl font-bold text-green-600">40%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Reducción de CO2:</span>
                        <span class="text-2xl font-bold text-green-600">35%</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Desperdicio evitado:</span>
                        <span class="text-2xl font-bold text-green-600">25%</span>
                    </div>
                </div>
            </div>

            <!-- Certificaciones -->
            <div class="bg-green-50 p-6 rounded-xl">
                <h3 class="text-xl font-semibold text-green-700 mb-6">Certificaciones y Reconocimientos</h3>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <i data-lucide="award" class="w-6 h-6 text-green-600"></i>
                        <span class="text-gray-700">Certificación Agricultura Ecológica</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i data-lucide="award" class="w-6 h-6 text-green-600"></i>
                        <span class="text-gray-700">Sello Comercio Justo</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i data-lucide="award" class="w-6 h-6 text-green-600"></i>
                        <span class="text-gray-700">Certificación Huella de Carbono</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i data-lucide="award" class="w-6 h-6 text-green-600"></i>
                        <span class="text-gray-700">Premio Innovación Sostenible 2024</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PROGRAMA ANTI-DESPERDICIO -->
<section class="bg-gradient-to-r from-green-600 to-green-700 text-white py-12 rounded-xl mb-16">
    <div class="max-w-4xl mx-auto text-center px-6">
        <h2 class="text-3xl font-bold mb-6">Programa Anti-Desperdicio</h2>
        <p class="text-lg mb-8">
            Productos próximos a su fecha de vencimiento a precios reducidos. ¡Únete a la lucha contra el desperdicio alimentario!
        </p>
        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/20 p-4 rounded-lg">
                <div class="text-3xl font-bold mb-2">2.5 Ton</div>
                <div class="text-sm">Alimentos salvados</div>
            </div>
            <div class="bg-white/20 p-4 rounded-lg">
                <div class="text-3xl font-bold mb-2">1,200</div>
                <div class="text-sm">Familias beneficiadas</div>
            </div>
            <div class="bg-white/20 p-4 rounded-lg">
                <div class="text-3xl font-bold mb-2">80%</div>
                <div class="text-sm">Descuento promedio</div>
            </div>
        </div>
        <a href="#" class="bg-white text-green-700 px-6 py-3 rounded-lg font-semibold hover:bg-green-50 transition">
            Ver Ofertas Anti-Desperdicio
        </a>
    </div>
</section>

<!-- CONSEJOS SOSTENIBLES -->
<section class="mb-16">
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center">Consejos para un Consumo Sostenible</h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-semibold text-green-700 mb-3">🌱 Compra Local y de Temporada</h3>
                <p class="text-gray-700 text-sm">
                    Los productos de temporada son más nutritivos, sabrosos y tienen menor impacto ambiental. Además, apoyas la economía local.
                </p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-semibold text-green-700 mb-3">♻️ Planifica tus Compras</h3>
                <p class="text-gray-700 text-sm">
                    Hacer una lista de compras te ayuda a evitar el desperdicio alimentario y a comprar solo lo que realmente necesitas.
                </p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-semibold text-green-700 mb-3">🥕 Aprovecha todo el Producto</h3>
                <p class="text-gray-700 text-sm">
                    Las hojas de remolacha, los tallos de brócoli y las cáscaras de muchas frutas son comestibles y nutritivas.
                </p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md">
                <h3 class="text-lg font-semibold text-green-700 mb-3">🌿 Compostaje en Casa</h3>
                <p class="text-gray-700 text-sm">
                    Convierte tus restos orgánicos en abono natural para tus plantas. Es fácil y reduce significativamente tus residuos.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA COMPROMISO -->
<section class="text-center bg-green-50 py-12 rounded-xl">
    <h3 class="text-2xl font-semibold text-green-700 mb-4">Únete a Nuestro Compromiso Verde</h3>
    <p class="text-gray-700 mb-6 max-w-2xl mx-auto">
        Cada compra que realizas en Indaluz es un voto por un futuro más sostenible. Juntos podemos hacer la diferencia.
    </p>
    <a href="#" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition">
        Empieza tu Compra Sostenible
    </a>
</section>

@endsection