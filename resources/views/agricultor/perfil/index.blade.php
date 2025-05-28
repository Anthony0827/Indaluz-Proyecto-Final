{{-- resources/views/agricultor/perfil/index.blade.php --}}
@extends('layouts.agricultor')

@section('title', 'Mi Perfil')
@section('header', 'Gestión de Perfil')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    {{-- Tabs de navegación --}}
    <div class="bg-white rounded-lg shadow">
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8 px-6" aria-label="Tabs">
                <button type="button" 
                        onclick="showTab('public')"
                        id="tab-public"
                        class="tab-button border-b-2 border-green-500 py-4 px-1 text-sm font-medium text-green-600">
                    Perfil Público
                </button>
                <button type="button"
                        onclick="showTab('private')"
                        id="tab-private" 
                        class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Datos Personales
                </button>
                <button type="button"
                        onclick="showTab('security')"
                        id="tab-security"
                        class="tab-button border-b-2 border-transparent py-4 px-1 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300">
                    Seguridad
                </button>
            </nav>
        </div>
    </div>

    {{-- Tab: Perfil Público --}}
    <div id="content-public" class="tab-content">
        <form method="POST" action="{{ route('agricultor.perfil.updatePublic') }}" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Información Pública</h3>
                    <p class="mt-1 text-sm text-gray-600">Esta información será visible para los clientes</p>
                </div>
                
                <div class="p-6 space-y-6">
                    {{-- Foto de portada --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Foto de portada
                        </label>
                        <div class="relative">
                            <div class="h-48 bg-gray-200 rounded-lg overflow-hidden">
                                @if($agricultor->foto_portada)
                                    <img src="{{ $agricultor->foto_portada_url }}" 
                                         alt="Portada"
                                         class="w-full h-full object-cover"
                                         id="portada-preview">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400" id="portada-placeholder">
                                        <i data-lucide="image" class="w-12 h-12"></i>
                                    </div>
                                    <img src="" alt="Portada" class="w-full h-full object-cover hidden" id="portada-preview">
                                @endif
                            </div>
                            <label for="foto_portada" class="absolute bottom-4 right-4 bg-white rounded-lg px-4 py-2 shadow cursor-pointer hover:bg-gray-50">
                                <i data-lucide="camera" class="w-4 h-4 inline mr-2"></i>
                                Cambiar portada
                                <input type="file" 
                                       name="foto_portada" 
                                       id="foto_portada"
                                       accept="image/*"
                                       class="hidden">
                            </label>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Recomendado: 1200x400px, máximo 4MB</p>
                        @error('foto_portada')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Foto de perfil y nombre de empresa --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Foto de perfil
                            </label>
                            <div class="flex flex-col items-center">
                                <div class="relative">
                                    @if($agricultor->foto_perfil)
                                        <img src="{{ $agricultor->foto_perfil_url }}" 
                                             alt="Perfil"
                                             class="w-32 h-32 rounded-full object-cover"
                                             id="perfil-preview">
                                    @else
                                        <div class="w-32 h-32 rounded-full bg-green-600 flex items-center justify-center text-white text-3xl font-bold" id="perfil-placeholder">
                                            {{ substr($agricultor->nombre, 0, 1) }}
                                        </div>
                                        <img src="" alt="Perfil" class="w-32 h-32 rounded-full object-cover hidden" id="perfil-preview">
                                    @endif
                                    <label for="foto_perfil" class="absolute bottom-0 right-0 bg-white rounded-full p-2 shadow cursor-pointer hover:bg-gray-50">
                                        <i data-lucide="camera" class="w-4 h-4"></i>
                                        <input type="file" 
                                               name="foto_perfil" 
                                               id="foto_perfil"
                                               accept="image/*"
                                               class="hidden">
                                    </label>
                                </div>
                                <p class="mt-2 text-xs text-gray-500">Máximo 2MB</p>
                            </div>
                            @error('foto_perfil')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="nombre_empresa" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre de tu empresa/marca (opcional)
                            </label>
                            <input type="text" 
                                   name="nombre_empresa" 
                                   id="nombre_empresa"
                                   value="{{ old('nombre_empresa', $agricultor->nombre_empresa) }}"
                                   placeholder="Ej: Huerta Los Naranjos"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                            <p class="mt-1 text-xs text-gray-500">Si no tienes empresa, se mostrará tu nombre personal</p>
                            @error('nombre_empresa')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Descripción pública --}}
                    <div>
                        <label for="descripcion_publica" class="block text-sm font-medium text-gray-700 mb-2">
                            Descripción de tu negocio
                        </label>
                        <textarea name="descripcion_publica" 
                                  id="descripcion_publica"
                                  rows="4"
                                  placeholder="Cuenta a tus clientes sobre tu historia, valores, qué te hace especial..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">{{ old('descripcion_publica', $agricultor->descripcion_publica) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Máximo 1000 caracteres</p>
                        @error('descripcion_publica')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Información adicional --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="anos_experiencia" class="block text-sm font-medium text-gray-700 mb-2">
                                Años de experiencia
                            </label>
                            <input type="number" 
                                   name="anos_experiencia" 
                                   id="anos_experiencia"
                                   value="{{ old('anos_experiencia', $agricultor->anos_experiencia) }}"
                                   min="0"
                                   max="100"
                                   placeholder="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                            @error('anos_experiencia')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="horario_atencion" class="block text-sm font-medium text-gray-700 mb-2">
                                Horario de atención
                            </label>
                            <input type="text" 
                                   name="horario_atencion" 
                                   id="horario_atencion"
                                   value="{{ old('horario_atencion', $agricultor->horario_atencion) }}"
                                   placeholder="Ej: Lunes a Viernes 8:00-14:00"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                            @error('horario_atencion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Certificaciones --}}
                    <div>
                        <label for="certificaciones" class="block text-sm font-medium text-gray-700 mb-2">
                            Certificaciones
                        </label>
                        <textarea name="certificaciones" 
                                  id="certificaciones"
                                  rows="3"
                                  placeholder="Ej: Agricultura ecológica, Denominación de origen, ISO 9001..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">{{ old('certificaciones', $agricultor->certificaciones) }}</textarea>
                        @error('certificaciones')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Métodos de cultivo --}}
                    <div>
                        <label for="metodos_cultivo" class="block text-sm font-medium text-gray-700 mb-2">
                            Métodos de cultivo
                        </label>
                        <textarea name="metodos_cultivo" 
                                  id="metodos_cultivo"
                                  rows="3"
                                  placeholder="Describe tus técnicas de cultivo: orgánico, hidropónico, tradicional..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">{{ old('metodos_cultivo', $agricultor->metodos_cultivo) }}</textarea>
                        @error('metodos_cultivo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t flex justify-between">
                    <a href="{{ route('agricultor.perfil.preview') }}" 
                       target="_blank"
                       class="text-green-600 hover:text-green-700 font-medium">
                        <i data-lucide="eye" class="w-4 h-4 inline mr-1"></i>
                        Ver vista previa
                    </a>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        Guardar cambios
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Tab: Datos Personales --}}
    <div id="content-private" class="tab-content hidden">
        <form method="POST" action="{{ route('agricultor.perfil.updatePrivate') }}">
            @csrf
            @method('PATCH')
            
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Datos Personales</h3>
                    <p class="mt-1 text-sm text-gray-600">Esta información es privada y no será visible para los clientes</p>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-2">
                                Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="nombre" 
                                   id="nombre"
                                   value="{{ old('nombre', $agricultor->nombre) }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('nombre') border-red-500 @enderror">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="apellido" class="block text-sm font-medium text-gray-700 mb-2">
                                Apellidos <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="apellido" 
                                   id="apellido"
                                   value="{{ old('apellido', $agricultor->apellido) }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('apellido') border-red-500 @enderror">
                            @error('apellido')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="correo" class="block text-sm font-medium text-gray-700 mb-2">
                                Correo electrónico <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="correo" 
                                   id="correo"
                                   value="{{ old('correo', $agricultor->correo) }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('correo') border-red-500 @enderror">
                            @error('correo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-2">
                                Teléfono <span class="text-red-500">*</span>
                            </label>
                            <input type="tel" 
                                   name="telefono" 
                                   id="telefono"
                                   value="{{ old('telefono', $agricultor->telefono) }}"
                                   required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('telefono') border-red-500 @enderror">
                            @error('telefono')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">
                            Dirección completa <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="direccion" 
                               id="direccion"
                               value="{{ old('direccion', $agricultor->direccion) }}"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('direccion') border-red-500 @enderror">
                        @error('direccion')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="codigo_postal" class="block text-sm font-medium text-gray-700 mb-2">
                                Código Postal
                            </label>
                            <input type="text" 
                                   name="codigo_postal" 
                                   id="codigo_postal"
                                   value="{{ old('codigo_postal', $agricultor->codigo_postal) }}"
                                   maxlength="5"
                                   placeholder="04000"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('codigo_postal') border-red-500 @enderror">
                            @error('codigo_postal')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="municipio" class="block text-sm font-medium text-gray-700 mb-2">
                                Municipio
                            </label>
                            <input type="text" 
                                   name="municipio" 
                                   id="municipio"
                                   value="{{ old('municipio', $agricultor->municipio) }}"
                                   placeholder="Almería"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('municipio') border-red-500 @enderror">
                            @error('municipio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="provincia" class="block text-sm font-medium text-gray-700 mb-2">
                                Provincia
                            </label>
                            <input type="text" 
                                   name="provincia" 
                                   id="provincia"
                                   value="{{ old('provincia', $agricultor->provincia ?? 'Almería') }}"
                                   placeholder="Almería"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('provincia') border-red-500 @enderror">
                            @error('provincia')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t flex justify-end">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        Guardar cambios
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Tab: Seguridad --}}
    <div id="content-security" class="tab-content hidden">
        <form method="POST" action="{{ route('agricultor.perfil.updatePassword') }}">
            @csrf
            @method('PATCH')
            
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Cambiar Contraseña</h3>
                    <p class="mt-1 text-sm text-gray-600">Mantén tu cuenta segura actualizando tu contraseña regularmente</p>
                </div>
                
                <div class="p-6 space-y-6">
                    <div>
                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                            Contraseña actual <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               name="current_password" 
                               id="current_password"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('current_password') border-red-500 @enderror">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Nueva contraseña <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               name="password" 
                               id="password"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500 @error('password') border-red-500 @enderror">
                        <p class="mt-1 text-xs text-gray-500">Mínimo 8 caracteres</p>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                            Confirmar nueva contraseña <span class="text-red-500">*</span>
                        </label>
                        <input type="password" 
                               name="password_confirmation" 
                               id="password_confirmation"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-green-500">
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 border-t flex justify-end">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                        Cambiar contraseña
                    </button>
                </div>
            </div>
        </form>

        {{-- Información adicional de seguridad --}}
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex">
                <i data-lucide="shield" class="w-5 h-5 text-yellow-600 mr-3 flex-shrink-0"></i>
                <div>
                    <h4 class="text-sm font-medium text-yellow-800">Consejos de seguridad</h4>
                    <ul class="mt-2 text-sm text-yellow-700 list-disc list-inside space-y-1">
                        <li>Usa una contraseña única que no uses en otros sitios</li>
                        <li>Combina letras mayúsculas, minúsculas, números y símbolos</li>
                        <li>Cambia tu contraseña regularmente</li>
                        <li>No compartas tu contraseña con nadie</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Función para cambiar entre tabs
function showTab(tabName) {
    // Ocultar todos los contenidos
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    // Resetear estilos de todos los tabs
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('border-green-500', 'text-green-600');
        button.classList.add('border-transparent', 'text-gray-500');
    });
    
    // Mostrar el contenido seleccionado
    document.getElementById('content-' + tabName).classList.remove('hidden');
    
    // Activar el tab seleccionado
    const activeTab = document.getElementById('tab-' + tabName);
    activeTab.classList.remove('border-transparent', 'text-gray-500');
    activeTab.classList.add('border-green-500', 'text-green-600');
}

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar iconos
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // Preview de imagen de perfil
    const inputPerfil = document.getElementById('foto_perfil');
    const previewPerfil = document.getElementById('perfil-preview');
    const placeholderPerfil = document.getElementById('perfil-placeholder');

    if (inputPerfil) {
        inputPerfil.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewPerfil.src = e.target.result;
                    previewPerfil.classList.remove('hidden');
                    if (placeholderPerfil) {
                        placeholderPerfil.classList.add('hidden');
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Preview de imagen de portada
    const inputPortada = document.getElementById('foto_portada');
    const previewPortada = document.getElementById('portada-preview');
    const placeholderPortada = document.getElementById('portada-placeholder');

    if (inputPortada) {
        inputPortada.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewPortada.src = e.target.result;
                    previewPortada.classList.remove('hidden');
                    if (placeholderPortada) {
                        placeholderPortada.classList.add('hidden');
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Contador de caracteres para descripción
    const descripcion = document.getElementById('descripcion_publica');
    if (descripcion) {
        descripcion.addEventListener('input', function() {
            if (this.value.length > 1000) {
                this.value = this.value.substring(0, 1000);
            }
        });
    }

    // Mostrar el tab correcto si hay errores
    @if($errors->has('current_password') || $errors->has('password'))
        showTab('security');
    @elseif($errors->has('nombre') || $errors->has('apellido') || $errors->has('correo') || $errors->has('telefono') || $errors->has('direccion'))
        showTab('private');
    @endif
});
</script>
@endpush
@endsection