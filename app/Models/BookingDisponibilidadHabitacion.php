<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingDisponibilidadHabitacion extends Model
{
    protected $table = 'booking_disponibilidad_habitaciones';

    protected $fillable = [
        'tipo_habitacion_id',
        'fecha',
        'total',
        'reservadas',
        'bloqueadas'
    ];
}