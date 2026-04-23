<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salones extends Model
{
    use HasFactory;
    protected $fillable = ['Nombre_salon',
        'Detalle_salon',
        'Precio_salon',
        'imagen',
        'Estado_salon',
        'Reserva_salon',
    ];

    //Relacion de uno a muchos
    public function reservasalon(){
        return $this->hasMany(ReservaSalones::class);
    } 

}
