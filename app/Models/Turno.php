<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turno extends Model
{
    use HasFactory;
    protected $fillable = [
        'Nombre',
        'Inicio',
        'Fin',
        'Fecha',
        'Estado'
    ];

    public function comsumos(){
        return $this->hasMany(Consumo::class);
    }

}
