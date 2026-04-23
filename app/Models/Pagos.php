<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    use HasFactory;
    protected $fillable = [
        'TipoPago',
        'FechaDePago',
        'TotalPago',
        'TipoMoneda',
        'consumo_id',
        'hospedaje_habitacion_id',
        'grupo_id',
        'reserva_salones_id'
    ];

    public function consumo(){
        return $this->belongsTo(Consumo::class);
    }

    public function hospedaje(){
        return $this->belongsTo(HospedajeHabitacion::class);
    }
    public function reservasalon(){
        return $this->belongsTo(ReservaSalones::class);
    }
}