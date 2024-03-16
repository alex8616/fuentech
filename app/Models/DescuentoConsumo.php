<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescuentoConsumo extends Model
{
    use HasFactory;
    protected $fillable = [
        'TipoDescuento',
        'FechaDescuento',
        'MontoDescuento',
        'TotalDescuento',
        'consumo_id',
    ];

    public function consumo(){
        return $this->belongsTo(Consumo::class);
    }    
}
