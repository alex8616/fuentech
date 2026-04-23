<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleHospedajeHabitacion extends Model
{
    use HasFactory;
    protected $fillable = ['hospedaje_habitacion_id',
                           'cliente_id'];
     
    //Relacion de uno a muchos inversa
    public function hospedajehabitacion(){
        return $this->belongsTo(HospedajeHabitacion::class, 'hospedaje_habitacion_id');
    }

    //Relacion de uno a muchos inversa
    public function cliente(){
        return $this->belongsTo(ClienteHostal::class);
    }
}
