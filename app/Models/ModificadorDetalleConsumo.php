<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModificadorDetalleConsumo extends Model
{
    use HasFactory;
    protected $fillable = [
        'fecha_venta',
        'comentario',
        'cantidad',
        'precio',
        'total',
        'detalle_modificadore_id',
        'detalle_consumo_id',
        'eliminado',
        'comentarioeliminado'
    ];

    public function detalleconsumo(){
        return $this->belongsTo(DetalleConsumo::class);
    }

    public function detallemodificador(){
        return $this->belongsTo(DetalleModificadore::class,'detalle_modificadore_id');
    }
}
