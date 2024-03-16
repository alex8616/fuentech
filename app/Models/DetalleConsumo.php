<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleConsumo extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha_venta',
        'comentario',
        'cantidad',
        'precio',
        'total',
        'consumo_id',
        'producto_id',
        'eliminado',
        'comentarioeliminado'
    ];

    public function consumo(){
        return $this->belongsTo(Consumo::class);
    }

    public function producto(){
        return $this->belongsTo(Producto::class);
    }
}
