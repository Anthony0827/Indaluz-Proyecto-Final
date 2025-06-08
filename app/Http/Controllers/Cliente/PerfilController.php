<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PerfilController extends Controller
{
    /**
     * Muestra el perfil del cliente
     */
    public function index()
    {
        $cliente = Auth::user();
        return view('cliente.perfil.index', compact('cliente'));
    }

    /**
     * Actualiza los datos personales del cliente
     */
    public function update(Request $request)
    {
        $cliente = Auth::user();

        // Validación de datos
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'apellido' => ['required', 'string', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'correo' => ['required', 'email', Rule::unique('usuarios')->ignore($cliente->id_usuario, 'id_usuario')],
            'telefono' => ['nullable', 'regex:/^[0-9]+$/', 'max:20'],
            'direccion' => ['nullable', 'string', 'max:255'],
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
            'telefono.regex' => 'El teléfono solo puede contener números.',
            'codigo_postal.regex' => 'El código postal debe tener 5 dígitos.',
        ]);

        // Actualizar datos
        $cliente->update($validated);

        return redirect()
            ->route('cliente.perfil')
            ->with('success', 'Datos actualizados correctamente.');
    }

    /**
     * Actualiza la foto de perfil
     */
    public function updateAvatar(Request $request)
    {
        $validated = $request->validate([
            'foto_perfil' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'foto_perfil.required' => 'Debes seleccionar una imagen.',
            'foto_perfil.image' => 'El archivo debe ser una imagen.',
            'foto_perfil.mimes' => 'La imagen debe ser JPEG, PNG, JPG o WEBP.',
            'foto_perfil.max' => 'La imagen no puede pesar más de 2MB.',
        ]);

        $cliente = Auth::user();

        try {
            // Eliminar foto anterior si existe
            if ($cliente->foto_perfil && Storage::disk('public')->exists($cliente->foto_perfil)) {
                Storage::disk('public')->delete($cliente->foto_perfil);
            }

            // Subir nueva foto
            $foto = $request->file('foto_perfil');
            $nombreFoto = 'cliente-' . $cliente->id_usuario . '-' . time() . '.' . $foto->getClientOriginalExtension();
            $rutaFoto = $foto->storeAs('avatares', $nombreFoto, 'public');

            // Actualizar en base de datos
            $cliente->update(['foto_perfil' => $rutaFoto]);

            return redirect()
                ->route('cliente.perfil')
                ->with('success', 'Foto de perfil actualizada correctamente.');

        } catch (\Exception $e) {
            return redirect()
                ->route('cliente.perfil')
                ->withErrors(['foto_perfil' => 'Error al subir la imagen: ' . $e->getMessage()]);
        }
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

        $cliente = Auth::user();

        // Verificar contraseña actual
        if (!Hash::check($validated['current_password'], $cliente->contraseña)) {
            return back()->withErrors(['current_password' => 'La contraseña actual es incorrecta.']);
        }

        // Actualizar contraseña
        $cliente->update([
            'contraseña' => Hash::make($validated['password'])
        ]);

        return redirect()
            ->route('cliente.perfil')
            ->with('success', 'Contraseña actualizada correctamente.');
    }
}