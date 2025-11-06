<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaccion extends Model
{
    protected $table = 'transacciones';

    protected $fillable = [
        'tipo', 'monto', 'tipo_pago', 'descripcion',
        'categoria_id', 'fecha', 'usuario_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
}
