<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleGasto extends Model
{
    use HasFactory;
    protected $fillable = [
        'cantidad',
        'precio',
        'total',
        'stock',
        'eliminado',
        'gasto_id',
        'producto_id',
    ];

    public function gastos(){
        return $this->belongsTo(Gasto::class);
    }

    public function productos(){
        return $this->belongsTo(Producto::class,'producto_id');
    }

}
