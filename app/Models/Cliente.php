<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;
    protected $fillable = [
        'NombreCliente',
        'EmailCliente',
        'TelefonoCliente',
        'CalleCliente',
        'NumeroCliente',
        'PisoCliente',
        'BarrioCliente',
        'Comentario',
        'MedioDePagoGasto',
        'Descuento',
        'NitDni',
        'EstadoCliente',
        'CuentaCorrienteCliente',
        'Total'
    ];

    //Relacion de uno a muchos inversa
    public function consumos(){
        return $this->belongsTo(Consumo::class, 'empresa_id');
    }

    public function cuentacorrientes(){
        return $this->hasMany(CuentaCorriente::class);
    }
}