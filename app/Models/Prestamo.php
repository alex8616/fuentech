<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prestamo extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre_objeto',
        'TipoServicio',
        'fecha_venta',
        'fecha_cierre',
        'comentario',
        'Devuelto',
        'hospedaje_habitacion_id',
    ];

    public function hospedaje(){
        return $this->belongsTo(HospedajeHabitacion::class, 'hospedaje_habitacion_id');
    }
}
