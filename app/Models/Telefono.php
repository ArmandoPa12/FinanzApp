<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Telefono extends Model
{
    protected $table = 'telefonos';

    protected $fillable = ['numero'];

    public function persona()
    {
        return $this->belongsTo(Persona::class);
    }
}
