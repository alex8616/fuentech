<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adelanto extends Model
{
    use HasFactory;
    protected $fillable = [
        'TipoAdelanto',
        'TipoMoneda',
        'MontoDolar',
        'FechaDeAdelanto',
        'TotalAdelanto',
        'hospedaje_habitacion_id',
        'grupo_hospedajes_id',
        'reserva_salones_id'
    ];

    public function hospedaje(){
        return $this->belongsTo(HospedajeHabitacion::class, 'hospedaje_habitacion_id');
    }

    public function grupohospedaje(){
        return $this->belongsTo(GrupoHospedaje::class, 'grupo_hospedajes_id');
    }

    public function reservasalon(){
        return $this->belongsTo(ReservaSalones::class, 'reserva_salones_id');
    }
}
