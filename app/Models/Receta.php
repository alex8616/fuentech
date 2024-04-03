<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;
    protected $fillable = [
        'NombreReceta',
        'producto_id'
    ];

    public function detallerecetas(){
        return $this->hasMany(DetalleReceta::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
