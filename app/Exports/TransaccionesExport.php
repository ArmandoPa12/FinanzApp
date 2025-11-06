<?php

namespace App\Exports;

use App\Models\Transaccion;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaccionesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Transaccion::with(['categoria','usuario'])->orderBy('fecha','asc')->get();
    }

    public function headings():array{
        return [
            'tipo',
            'monto',
            'tipo_pago',
            'descripción',
            'categoria_id',
            'usuario_id',
            'fecha',
        ];
    }
     public function map($tran): array
    {
        $tipo = $tran->tipo ? 'Salida' : 'Entrada';
        $tipoPago = $tran->tipo_pago ? 'Transferencia' : 'Efectivo';
        return [
            $tipo,
            number_format($tran->monto, 2, '.', ''),
            $tipoPago,
            $tran->descripcion ?? '',
            $tran->categoria->nombre ?? '',
            $tran->usuario->username ?? '',
            $tran->fecha,
        ];
    }

}
