<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleInventario extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'descripcion',
        'cantidad',
        'fecha',
        'tipo',
        'estado',
        'inventarios_id',
    ];

    // Relación inversa con Inventario
    public function inventario(){
        return $this->belongsTo(Inventario::class, 'inventarios_id');
    }
}
