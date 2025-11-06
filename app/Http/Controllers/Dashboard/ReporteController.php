<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Transaccion;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
    {
        return inertia('Dashboard/Reporte/Index',[
            'transacciones' => Transaccion::all(),
            'categorias' => Categoria::all(),  
        ]);
    }
}
