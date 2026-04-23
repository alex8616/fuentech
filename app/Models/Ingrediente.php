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
        'CantidadStock',
        'ComentarioStock',
        'MinimoStock',
        'proveedor_id',
        'categoria_ingrediente_id',
    ];

    //Relacion de uno a muchos inversa
    public function categoriaingrediente(){
        return $this->belongsTo(CategoriaIngrediente::class, 'categoria_ingrediente_id');
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }

    public function proveedor(){
        return $this->belongsTo(Proveedore::class, 'proveedor_id');
    }

    public function detallereceta(){
        return $this->hasMany(DetalleReceta::class);
    }

    public function stockdate(){
        return $this->belongsTo(StockDate::class);
    }
}
