<?php

namespace App\Http\Controllers\Agricultor;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    /**
     * Muestra el perfil del agricultor
     */
    public function index()
    {
        $agricultor = Auth::user();
        return view('agricultor.perfil.index', compact('agricultor'));
    }

    /**
     * Actualiza el perfil público del agricultor
     */
    public function updatePublic(Request $request)
    {
        $agricultor = Auth::user();

        $validated = $request->validate([
            'nombre_empresa' => 'nullable|string|max:100',
            'descripcion_publica' => 'nullable|string|max:1000',
            'anos_experiencia' => 'nullable|integer|min:0|max:100',
            'certificaciones' => 'nullable|string|max:500',
            'metodos_cultivo' => 'nullable|string|max:500',
            'horario_atencion' => 'nullable|string|max:200',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'foto_portada' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096', // 4MB para portada
        ], [
            'nombre_empresa.max' => 'El nombre de la empresa no puede tener más de 100 caracteres.',
            'descripcion_publica.max' => 'La descripción no puede tener más de 1000 caracteres.',
            'anos_experiencia.integer' => 'Los años de experiencia deben ser un número.',
            'anos_experiencia.min' => 'Los años de experiencia no pueden ser negativos.',
            'certificaciones.max' => 'Las certificaciones no pueden tener más de 500 caracteres.',
            'metodos_cultivo.max' => 'Los métodos de cultivo no pueden tener más de 500 caracteres.',
            'foto_perfil.image' => 'El archivo debe ser una imagen.',
            'foto_perfil.max' => 'La foto de perfil no puede pesar más de 2MB.',
            'foto_portada.max' => 'La foto de portada no puede pesar más de 4MB.',
        ]);

        // Procesar foto de perfil
        if ($request->hasFile('foto_perfil')) {
            // Eliminar foto anterior si existe
            if ($agricultor->foto_perfil) {
                Storage::disk('public')->delete($agricultor->foto_perfil);
            }

            $foto = $request->file('foto_perfil');
            $nombreFoto = 'perfil-' . $agricultor->id_usuario . '-' . time() . '.' . $foto->getClientOriginalExtension();
            $validated['foto_perfil'] = $foto->storeAs('perfiles', $nombreFoto, 'public');
        }

        // Procesar foto de portada
        if ($request->hasFile('foto_portada')) {
            // Eliminar portada anterior si existe
            if ($agricultor->foto_portada) {
                Storage::disk('public')->delete($agricultor->foto_portada);
            }

            $portada = $request->file('foto_portada');
            $nombrePortada = 'portada-' . $agricultor->id_usuario . '-' . time() . '.' . $portada->getClientOriginalExtension();
            $validated['foto_portada'] = $portada->storeAs('perfiles', $nombrePortada, 'public');
        }

        // Actualizar datos
        $agricultor->update($validated);

        return redirect()
            ->route('agricultor.perfil.index')
            ->with('success', 'Perfil público actualizado correctamente.');
    }

    /**
     * Actualiza los datos privados del agricultor
     */
    public function updatePrivate(Request $request)
    {
        $agricultor = Auth::user();

        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'apellido' => ['required', 'string', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'correo' => ['required', 'email', Rule::unique('usuarios')->ignore($agricultor->id_usuario, 'id_usuario')],
            'telefono' => ['required', 'regex:/^[0-9]+$/', 'min:9', 'max:20'],
            'direccion' => ['required', 'string', 'max:255'],
            'codigo_postal' => ['nullable', 'regex:/^[0-9]{5}$/'],
            'municipio' => ['nullable', 'string', 'max:100'],
            'provincia' => ['nullable', 'string', 'max:100'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',
            'correo.required' => 'El correo es obligatorio.',
            'correo.email' => 'El correo debe ser válido.',
            'correo.unique' => 'Este correo ya está en uso.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.regex' => 'El teléfono solo puede contener números.',
            'direccion.required' => 'La dirección es obligatoria.',
            'codigo_postal.regex' => 'El código postal debe tener 5 dígitos.',
        ]);

        // Actualizar datos
        $agricultor->update($validated);

        return redirect()
            ->route('agricultor.perfil.index')
            ->with('success', 'Datos personales actualizados correctamente.');
    }

    /**
     * Actualiza la contraseña
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'La contraseña actual es obligatoria.',
            'password.required' => 'La nueva contraseña es obligatoria.',
            'password.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',
        ]);

        $agricultor = Auth::user();

        // Verificar contraseña actual
        if (!Hash::check($validated['current_password'], $agricultor->contraseña)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        // Actualizar contraseña
        $agricultor->update([
            'contraseña' => Hash::make($validated['password'])
        ]);

        return redirect()
            ->route('agricultor.perfil.index')
            ->with('success', 'Contraseña actualizada correctamente.');
    }

    /**
     * Vista previa del perfil público (como lo ven los clientes)
     */
    public function preview()
    {
        $agricultor = Auth::user();
        
        // Obtener estadísticas para mostrar en el perfil público
        $totalProductos = $agricultor->productos()->activos()->count();
        $calificacionPromedio = $agricultor->reseñasRecibidas()->avg('rating') ?? 0;
        $totalReseñas = $agricultor->reseñasRecibidas()->count();
        
        return view('agricultor.perfil.preview', compact('agricultor', 'totalProductos', 'calificacionPromedio', 'totalReseñas'));
    }
}