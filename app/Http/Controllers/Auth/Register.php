<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\Persona;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Register extends Controller
{
    public function index()
    {
        return inertia('Auth/Register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:usuarios,username',
            'password' => 'required|string|min:3',
            'apellido' => 'nullable|string|max:100',
            'carnet' => 'nullable|string|max:20|unique:personas,carnet',

        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser un texto válido.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',

            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.string' => 'El nombre de usuario debe ser un texto válido.',
            'username.max' => 'El nombre de usuario no puede tener más de 50 caracteres.',
            'username.unique' => 'El nombre de usuario ya está en uso. Elige otro.',

            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser una cadena de texto.',
            'password.min' => 'La contraseña debe tener al menos 3 caracteres.',

            'apellido.string' => 'El apellido debe ser texto válido.',
            'apellido.max' => 'El apellido no puede tener más de 100 caracteres.',
            'carnet.unique' => 'El número de carnet ya está registrado.',

        ]);


        $persona = Persona::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'carnet' => $request->carnet,
        ]);

        $usuario = Usuario::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'persona_id' => $persona->id
        ]);

        
        Auth::login($usuario, true);
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }
}
