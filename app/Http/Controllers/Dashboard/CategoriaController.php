<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {

        return inertia('Dashboard/Categoria/Categorias', [
            'categorias' => Categoria::all()
        ]);
    }

    public function create()
    {
        return inertia('Dashboard/Categoria/Create');
    }

    public function store(Request $request)
    {
        $message = [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser una cadena de texto.',
            'nombre.max' => 'El nombre no debe exceder los 100 caracteres.',
            'nombre.unique' => 'El nombre ya existe. Por favor, elige otro nombre.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'descripcion.max' => 'La descripción no debe exceder los 500 caracteres.',
        ];

        $request->validate([
            'nombre' => 'required|string|max:100|unique:categorias,nombre',
            'descripcion' => 'nullable|string|max:500',
        ], $message);

        Categoria::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return back();
        // return redirect()->route('categoria');
    }
    public function update(Categoria $categoria)
    {
        $categoria->update(
            request()->validate([
                'nombre' => 'required|string|max:100|unique:categorias,nombre,' . $categoria->id,
                'descripcion' => 'string|max:500',
            ])
        );
        return back();
    }

    public function delete(Categoria $categoria)
    {
        if ($categoria->id <= 5) {
            return back()->withErrors(['categoria' => 'No se puede eliminar esta categoría predeterminada.']);
        }
        $categoria->delete();
        return back();
    }
}
