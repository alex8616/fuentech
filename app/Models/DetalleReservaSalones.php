<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleReservaSalones extends Model
{
    use HasFactory;
    protected $fillable = ['reserva_salones_id',
                           'cliente_id'];
     
    //Relacion de uno a muchos inversa
    public function reservasalon(){
        return $this->belongsTo(ReservaSalones::class);
    }

    //Relacion de uno a muchos inversa
    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
