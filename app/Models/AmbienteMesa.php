<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbienteMesa extends Model
{
    use HasFactory;
    protected $fillable = [
        'NombreMesas',
        'PosisionX',
        'PosisionY',
        'ambiente_id',
        'estado'
    ];

    public function registrarMesa(){
        return $this->belongsTo(Ambiente::class);
    }

    //Relacion de uno a muchos inversa
    public function consumos(){
        return $this->belongsTo(Consumo::class, 'empresa_id');
    }
}
