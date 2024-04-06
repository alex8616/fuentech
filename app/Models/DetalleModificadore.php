<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleModificadore extends Model
{
    use HasFactory;
    protected $fillable = [
        'CostoDetalleModificador',
        'MaximoDetalleModificador',
        'modificadore_id',
        'producto_id',
    ];

    public function modificadore(){
        return $this->belongsTo(Modificadore::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
