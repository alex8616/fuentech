<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockDate extends Model
{
    use HasFactory;
    protected $fillable = [
        'Cantidad',
        'StockMinimo',
        'NombreProducto',
        'producto_id',
        'ingrediente_id',
        'consumo_id'
    ];

    //Relacion de uno a muchos inversa
    public function consumos(){
        return $this->belongsTo(Consumo::class, 'consumo_id');
    }
    
    //Relacion de uno a muchos inversa
    public function productos(){
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    
    //Relacion de uno a muchos inversa
    public function ingredientes(){
        return $this->belongsTo(Ingrediente::class, 'ingrediente_id');
    }

    // Relación de uno a muchos
    public function detalleStockDates(){
        return $this->hasMany(DetalleStockDate::class, 'stock_dates_id');
    }
}
