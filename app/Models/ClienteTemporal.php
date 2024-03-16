<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteTemporal extends Model
{
    use HasFactory;
    protected $fillable = [
        'NombreCliente',
        'TelefonoCliente',
        'CalleCliente',
        'NumeroCliente',
        'PisoCliente',
        'BarrioCliente',
        'Comentario',
    ];

    //Relacion de uno a muchos inversa
    public function consumos(){
        return $this->belongsTo(Consumo::class);
    }
}
