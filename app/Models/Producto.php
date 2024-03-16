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
}
