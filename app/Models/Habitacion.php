<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habitacion extends Model
{
    use HasFactory;
    protected $fillable = ['Nombre_habitacion',
                            'Detalle_habitacion',
                            'Precio_habitacion',
                            'imagen',
                            'color_habitacion',
                            'Estado_habitacion',
                            'Reserva_habitacion',
                            'Grupo_habitacion'
                        ];
    
    //Relacion de uno a muchos
    public function hospedajehabitacion(){
        return $this->hasMany(HospedajeHabitacion::class);
    } 
    
    public function mantenimiento(){
        return $this->hasMany(Mantenimiento::class);
    } 
}
