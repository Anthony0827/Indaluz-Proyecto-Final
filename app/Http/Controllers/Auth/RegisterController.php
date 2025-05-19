<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function choice()
    {
        return view('auth.register-choice');
    }

    public function showForm(string $rol)
    {
        if ($rol === 'cliente') {
            return view('auth.register-cliente');
        }
        if ($rol === 'agricultor') {
            return view('auth.register-agricultor');
        }
        abort(404);
    }

    public function register(Request $request, string $rol)
    {
        $rules = [
            'nombre'    => ['required','string','max:50','regex:/^[\pL\s]+$/u'],
            'apellido'  => ['required','string','max:50','regex:/^[\pL\s]+$/u'],
            'correo'    => ['required','email','unique:usuarios,correo'],
            'password'  => ['required','string','min:8','confirmed'],
            'direccion' => ['nullable','string','max:255'],
            'telefono'  => ['nullable','regex:/^[0-9]+$/','max:20'],
        ];

        $messages = [
            'nombre.required'    => 'El nombre es obligatorio.',
            'nombre.regex'       => 'El nombre solo puede contener letras y espacios.',
            'nombre.max'         => 'El nombre no puede tener más de 50 caracteres.',

            'apellido.required'  => 'El apellido es obligatorio.',
            'apellido.regex'     => 'El apellido solo puede contener letras y espacios.',
            'apellido.max'       => 'El apellido no puede tener más de 50 caracteres.',

            'correo.required'    => 'El correo es obligatorio.',
            'correo.email'       => 'El correo debe ser una dirección de email válida.',
            'correo.unique'      => 'Este correo ya está registrado.',

            'password.required'  => 'La contraseña es obligatoria.',
            'password.min'       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'La confirmación de la contraseña no coincide.',

            'direccion.max'      => 'La dirección no puede tener más de 255 caracteres.',

            'telefono.regex'     => 'El teléfono solo puede contener números.',
            'telefono.max'       => 'El teléfono no puede tener más de 20 dígitos.',
        ];

        // Validamos
        $data = $request->validate($rules, $messages);

        // Creamos usuario
        Usuario::create([
            'nombre'     => $data['nombre'],
            'apellido'   => $data['apellido'],
            'correo'     => $data['correo'],
            'contraseña' => Hash::make($data['password']),
            'rol'        => $rol,
            'direccion'  => $data['direccion'] ?? null,
            'telefono'   => $data['telefono']  ?? null,
        ]);

        return redirect()
            ->route('login')
            ->with('success', '¡Registro completado! Ahora puedes iniciar sesión.');
    }
}
