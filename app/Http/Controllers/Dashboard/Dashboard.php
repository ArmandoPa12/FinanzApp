<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Transaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function dashboard(Request $request)
    {
        $usuario = Auth::user();
        $query = Transaccion::with(['categoria', 'persona']);
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('fecha', [$request->from, $request->to]);
        } elseif ($request->filled('days')) {
            $query->where('fecha', '>=', now()->subDays($request->days));
        }


        if ($request->filled('categoria_id') && $request->categoria_id != 0) {
            $query->where('categoria_id', $request->categoria_id);
        }

        if ($request->filled('tipo') && $request->tipo != 0) {
            $query->where('tipo', $request->tipo);
        }
        
        if ($request->filled('tipo_pago') && $request->tipo_pago != 0 ) {
            $query->where('tipo_pago', $request->tipo_pago);
        }   

        if ($request->filled('sort') && in_array($request->sort, ['asc', 'desc'])) {
            $query->orderBy('monto', $request->sort);
        } else {
            $query->orderBy('fecha', 'desc');
        }

        return inertia('Dashboard/Dashboar', [
            'usuario' => [
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'username' => $usuario->username,
            ],
            'transacciones' => $query->get(),
            'categorias' => Categoria::all(),
            'filters' => $request->only(['from', 'to', 'days', 'categoria_id', 'tipo', 'tipo_pago', 'sort']),
        ]);
    }
}
