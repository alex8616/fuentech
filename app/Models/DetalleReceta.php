<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleReceta extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha_registro',
        'cantidadneta',
        'cantidadbruta',
        'unidad',
        'costo',
        'receta_id',
        'ingrediente_id',
    ];

    public function receta(){
        return $this->belongsTo(Receta::class);
    }

    public function ingrediente(){
        return $this->belongsTo(Ingrediente::class);
    }
}
