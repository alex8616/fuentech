<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auto extends Model
{
    use HasFactory;
    protected $fillable = [
        'color',
        'placa',
        'marca',
        'comentario',
        'hospedaje_habitacion_id',
    ];

    public function hospedaje(){
        return $this->belongsTo(HospedajeHabitacion::class, 'hospedaje_habitacion_id');
    }
}