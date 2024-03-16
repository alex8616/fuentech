<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Camarero extends Model
{
    use HasFactory;
    protected $fillable = [
        'NombreCamarero',
    ];

    //Relacion de uno a muchos inversa
    public function consumos(){
        return $this->belongsTo(Consumo::class, 'empresa_id');
    }
}
