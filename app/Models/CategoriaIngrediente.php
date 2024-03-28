<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaIngrediente extends Model
{
    use HasFactory;
    protected $fillable = [
        'NombreCategoria',
    ];

    //Relacion de uno a muchos
    public function productoingredientes(){
        return $this->hasMany(Ingrediente::class);
    }
}
