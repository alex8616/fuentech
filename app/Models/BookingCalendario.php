<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingCalendario extends Model
{

    protected $table = 'booking_calendario';

    protected $fillable = [
        'tipo_habitacion_id',
        'fecha',
        'total',
        'reservadas',
        'bloqueadas',
        'precio',
        'cerrado',
        'min_noches'
    ];

}