<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authtenticable;

class Usuario extends Authtenticable
{
    protected $table = 'usuarios';

    protected $fillable = ['username', 'password','persona_id'];
    public function transacciones()
    {
        return $this->hasMany(Transaccion::class);
    }
    public function personas()
    {
        return $this->hasMany(Persona::class);
    }

}
