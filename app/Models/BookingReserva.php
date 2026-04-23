<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingReserva extends Model
{
    protected $table = 'booking_reservas';

    protected $fillable = [
        'codigo_reserva',
        'nombre',
        'telefono',
        'email',
        'fecha_ingreso',
        'fecha_salida',
        'adultos',
        'ninos',
        'estado'
    ];

    public function detalles()
    {
        return $this->hasMany(BookingReservaDetalle::class,'booking_reserva_id');
    }
}