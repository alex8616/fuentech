<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
    use HasFactory;
    protected $fillable = [
        'TipoPago',
        'FechaDePago',
        'TotalPago',
        'consumo_id',
    ];

    public function consumo(){
        return $this->belongsTo(Consumo::class);
    }    
}