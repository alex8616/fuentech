<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticuloCaja extends Model
{
    use HasFactory;
    protected $fillable = ['Nombre_Articulo','Codigo_caja'];

    //Relacion de uno a muchos
    public function detallecajas(){
        return $this->hasMany(DetalleCaja::class);
    }
}
