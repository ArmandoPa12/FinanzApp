<?php

namespace App\Imports;

use App\Models\Categoria;
use App\Models\Transaccion;
use DateTime;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransaccionesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $tipoTexto = strtolower(trim($row['tipo'] ?? ''));
        $tipoPagoTexto = strtolower(trim($row['tipo_pago'] ?? ''));
        $tipo = $tipoTexto === 'entrada'? false : true;
        $tipoPago = $tipoPagoTexto === 'transferencia' ? true : false;
        $categoria = Categoria::where('nombre', $row['categoria_id'] ?? '')->first();
        return new Transaccion([
            'tipo' => $tipo,
            'monto' => $row['monto'] ?? 0,
            'tipo_pago' => $tipoPago,
            'descripcion' => $row['descripcion'] ?? null,
            'categoria_id' => $categoria?->id, // null-safe
            'usuario_id' => Auth::id(),
            'fecha' => $row['fecha'] ?? now()->toDateString(),  
        ]);
    }
}
