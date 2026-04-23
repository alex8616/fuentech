<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingReservaDetalle extends Model
{
    protected $table = 'booking_reserva_detalles';

    protected $fillable = [
        'booking_reserva_id',
        'tipo_habitacion_id',
        'cantidad',
        'precio'
    ];

    public function reserva()
    {
        return $this->belongsTo(BookingReserva::class,'booking_reserva_id');
    }
}