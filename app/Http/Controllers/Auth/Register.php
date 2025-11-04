<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class Register extends Controller
{
    public function index()
    {
        return inertia('Auth/Register');
    }

    public function store(AuthRequest $request)
    {
        // $request->validate([
            // 'nombre' => 'required|string|max:100',
            // 'username' => 'required|string|max:50|unique:personas,username',
            // 'password' => 'required|string|min:3',
        // ]);

        $usuario = Persona::create([
            'nombre' => $request->nombre,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($usuario, true);
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }
}
