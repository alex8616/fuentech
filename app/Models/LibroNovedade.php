<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LibroNovedade extends Model
{
    use HasFactory;
    protected $fillable = ['caja_id',
                           'user_id',
                           'controles',
                           'llaves',
                           'datadisplay',
                           'tanque_1',
                           'tanque_2',
                           'tanque_3',
                           'detalle',
                           'Fecha_registro'];

    //Relacion de uno a muchos inversa
    public function user(){
        return $this->belongsTo(User::class);
    }

    //Relacion de uno a muchos inversa
    public function caja(){
        return $this->belongsTo(Caja::class);
    }
}
