<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;

class Persona extends Model
{
    use Notifiable;

    protected $table = 'personas';
    protected $fillable = [
        'nombre',
        'apellido',
        'carnet',
    ];
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];
    public function telefonos()
    {
        return $this->hasMany(Telefono::class);
    }
}   
