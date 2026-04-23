<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
    protected $fillable = ['hospedaje_habitacion_id',
                            'user_id',
                            'ingreso_reserva',
                            'salida_reserva',
                            'EstadoReserva',
                            'ComentarioReserva',
                            'CategoriaHabitacion',
                            'CantidadPersonas',
                            'CodigoReserva',
                            
                            'CanalReserva',
                            'ComisionReserva',
                            'LlegadoReserva',
                            'PrecioDolar',
                            'PrecioBolivianos',
                            'ReservaCancelado',
                            'ComentarioCancelado'
                        ];
    
    public function hospedajehabitacion(){
        return $this->belongsTo(HospedajeHabitacion::class, 'hospedaje_habitacion_id');
    }
}
