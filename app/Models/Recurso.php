<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recurso extends Model
{
    use HasFactory;
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'estado',
        'clasificacion',
        'marca',
        'observaciones',
        'color',
        'imagen',
        'categori_recursos_id',
    ];

    //Relacion de uno a muchos inversa
    public function categoriarecurso(){
        return $this->belongsTo(CategoriRecurso::class, 'categori_recursos_id');
    }

    // En Recurso.php
    public function inventario(){
        return $this->hasMany(Inventario::class, 'recursos_id');
    }

}
