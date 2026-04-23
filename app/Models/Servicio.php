<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;
    protected $fillable = [
        'hospedaje_habitacion_id',
        'user_id',
        'FechaRegistro_servicio',
        'FechaCierre',
        'ServicioComentario',
        'subTotalDesayuno',
        'totalpagadoDesayuno',
        'totalDesayuno',
        'subTotalLavado',
        'totalpagadoLavado',
        'totalLavado',
        'subTotalData',
        'totalpagadoData',
        'totalData',
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
        return $this->belongsTo(ReservaSalones::class);
    }

    //Relacion de uno a muchos
    public function detalleservicio(){
        return $this->hasMany(DetalleServicio::class);
    }
}
