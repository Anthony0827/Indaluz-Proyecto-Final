<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use App\Models\Verificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\VerifyEmail;

class RegisterController extends Controller
{
    /**
     * Show the role choice page.
     */
    public function choice()
    {
        return view('auth.register-choice');
    }

    /**
     * Show the registration form for the given role.
     *
     * @param  string  $rol  'cliente' or 'agricultor'
     */
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

    /**
     * Handle a registration request for the given role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $rol
     */
    public function register(Request $request, string $rol)
    {
        // Validation rules
        $rules = [
            'nombre'    => ['required', 'string', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'apellido'  => ['required', 'string', 'max:50', 'regex:/^[\pL\s]+$/u'],
            'correo'    => ['required', 'email', 'unique:usuarios,correo'],
            'password'  => ['required', 'string', 'min:8', 'confirmed'],
            'direccion' => ['nullable', 'string', 'max:255'],
            'telefono'  => ['nullable', 'regex:/^[0-9]+$/', 'max:20'],
        ];

        // Custom error messages (Spanish)
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

        // Perform validation
        $data = $request->validate($rules, $messages);

        // Create the user (without logging in)
        $user = Usuario::create([
            'nombre'     => $data['nombre'],
            'apellido'   => $data['apellido'],
            'correo'     => $data['correo'],
            'contraseña' => Hash::make($data['password']),
            'rol'        => $rol,
            'direccion'  => $data['direccion'] ?? null,
            'telefono'   => $data['telefono']  ?? null,
        ]);

        // Create a verification token
        $token = Str::random(64);
        Verificacion::create([
            'id_usuario' => $user->id_usuario,
            'token'      => $token,
        ]);

        // Send verification email
        Mail::to($user->correo)->send(new VerifyEmail($user, $token));

        // Redirect to login with success message
        return redirect()
            ->route('login')
            ->with('success', '¡Registrado con éxito! Revisa tu correo y verifica tu cuenta.');
    }
}
