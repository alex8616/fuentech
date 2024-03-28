<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockDate extends Model
{
    use HasFactory;
    protected $fillable = [
        'Cantidad',
        'StockAnterior',
        'StockActual',
        'Diferencia',
        'TipoStock',
        'DetalleStock',
        'NombreProducto',
        'FechaStock',
        'producto_id'
    ];

    //Relacion de uno a muchos inversa
    public function productos(){
        return $this->belongsTo(Producto::class);
    }
}
