<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioConsumo extends Model
{
    use HasFactory;
    protected $fillable = [
        'hospedaje_habitacion_id',
        'user_id',
        'FechaRegistro_servicio',
        'FechaCierre',
        'ServicioComentario',
        'subTotal',
        'totalpagado',
        'total',
        'totalgeneral',
        'reserva_salones_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function hospedajehabitacion(){
        return $this->belongsTo(HospedajeHabitacion::class);
    }

    public function reservasalon(){
        return $this->belongsTo(ReservaSalones::class, 'reserva_salones_id');
    }

    public function consumo(){
        return $this->hasMany(Consumo::class);
    }
}
