<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriRecurso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'pertenece',
    ];

    //Relacion de uno a muchos
    public function recursos(){
        return $this->hasMany(Recurso::class);
    }
}
