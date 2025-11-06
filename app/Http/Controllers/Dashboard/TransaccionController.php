<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Transaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaccionController extends Controller
{
    public function index()
    {
        return inertia('Dashboard/Transaccion/Transacciones', [
            'categorias' => Categoria::all(),
            'mode' => 'create',
            'transaccion' => null,
        ]);
    }

    public function store(Request $request)
    {
        $message = [
            'tipo.required' => 'El tipo es obligatorio.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser un número.',
            'tipo_pago.required' => 'El tipo de pago es obligatorio.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no es válida.',
        ];

        $validated = $request->validate([
            'tipo' => 'required',
            'monto' => 'required|numeric',
            'tipo_pago' => 'required',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'exists:categorias,id',
            'persona_id' => 'nullable|exists:personas,id',
            'fecha' => 'required|date',
        ], $message);

        $validated['usuario_id'] = Auth::id();

        Transaccion::create($validated);
        return redirect()->back()->with('success', 'Transacción creada correctamente');


    }

    public function edit(Transaccion $transaccion)
    {
        
        return inertia('Dashboard/Transaccion/Transacciones', [
            'categorias' => Categoria::all(),
            'mode' => 'edit',
            'transaccion' => $transaccion,
        ]);
    }
    public function update(Request $request, Transaccion $transaccion)
    {
        $message = [
            'tipo.required' => 'El tipo es obligatorio.',
            'monto.required' => 'El monto es obligatorio.',
            'monto.numeric' => 'El monto debe ser un número.',
            'tipo_pago.required' => 'El tipo de pago es obligatorio.',
            'descripcion.string' => 'La descripción debe ser una cadena de texto.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha no es válida.',
        ];

        $validated = $request->validate([
            'tipo' => 'required',
            'monto' => 'required|numeric',
            'tipo_pago' => 'required',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'exists:categorias,id',
            'usuario_id' => 'nullable|exists:usuario,id',
            'fecha' => 'required|date',
        ], $message);

        $validated['usuario_id'] = Auth::id();

        $transaccion->update($validated);
        return redirect()->route('transaccion')->with('success', 'Transacción actualizada correctamente');
    }

    public function delete(Transaccion $transaccion)
    {
        $transaccion->delete();
        return back();
        // return redirect()->back()->with('success', 'Transacción eliminada correctamente');
    }
}
