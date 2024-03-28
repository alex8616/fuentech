<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;
    protected $fillable = [
        'NombreIngrediente',
        'UnidadIngrediente',
        'CostoIngrediente',
        'CantidadIngrediente',
        'ControlStock',
        'proveedor_id',
        'categoria_id',
        'producto_id'
    ];

    //Relacion de uno a muchos inversa
    public function categoriaingrediente(){
        return $this->belongsTo(CategoriaIngrediente::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
