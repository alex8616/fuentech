<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mantenimiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'Problema',
        'Solucion',
        'InicioProblema',
        'FinalProblema',
        'TiempoSolucion',
        'EstadoSolucion',
        'user_id',
        'habitacion_id'
    ];
        
    //Relacion de uno a muchos inversa
    public function user(){
    return $this->belongsTo(User::class);
    }

    //Relacion de uno a muchos inversa
    public function habitacion(){
    return $this->belongsTo(Habitacion::class);
    }
}
