<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteReserva extends Model
{
    use HasFactory;
    protected $fillable = [
        'NombreCliente',
        'CelularCliente'
    ];


    //Relacion de uno a muchos
    public function reservasalon(){
        return $this->hasMany(ReservaSalones::class);
    } 
}
