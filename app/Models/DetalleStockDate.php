<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleStockDate extends Model
{
    use HasFactory;
    protected $fillable = [
        'TipoStock',
        'StockAnterior',
        'StockActual',
        'Diferencia',
        'DetalleStock',
        'FechaStock',
        'CantidadFaltante',
        'FechaInicioSolucion',
        'FechaFinSolucion',
        'EstadoStock',
        'SolucionStock',
        'stock_dates_id',
        'TipoServicio',
        'IdTipoServicio',
        'proveedor_id',
        'user_id'
    ];

    //Relacion de uno a muchos inversa
    public function stockdates(){
        return $this->belongsTo(StockDate::class, 'stock_dates_id');
    }

    public function proveedores(){
        return $this->belongsTo(Proveedore::class, 'proveedor_id');
    }

    public function users(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
