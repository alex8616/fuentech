<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;    

    protected $fillable = [
        'NombreProducto',
        'PrecioProducto',
        'CostoProducto',
        'CodigoProducto',
        'EstadoProducto',
        'DescripcionProducto',
        'ControlStock',
        'FavoritoProducto',
        'MenuOnlineProducto',
        'ImagenProducto',
        'CantidadStock',
        'ComentarioStock',
        'MinimoStock',
        'proveedor_id',
        'categoria_id',
        'sub_categoria_id',
        'empresa_id',
    ];

    //Relacion de uno a muchos inversa
    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    public function proveedor(){
        return $this->belongsTo(Proveedore::class, 'proveedor_id');
    }

    public function detalleconsumo(){
        return $this->hasMany(DetalleConsumo::class);
    }

    public function stockdate(){
        return $this->belongsTo(StockDate::class);
    }
    
    public function ingredientes(){
        return $this->hasMany(Ingrediente::class);
    }
    
    public function receta(){
        return $this->hasMany(Receta::class);
    }
}
