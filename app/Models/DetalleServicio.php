<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleServicio extends Model
{
    use HasFactory;
    protected $fillable = [
        'servicio_id',
        'TipoServicio',
        'fecha_venta',
        'comentario',
        'eliminado',
        'comentarioeliminado',
        'cantidad',
        'precio',
        'total',
        'lavado',
        'fecha_cierre',
        'pagado',
        'tipopago'
    ];

    //Relacion de uno a muchos inversa
    public function servicio(){
        return $this->belongsTo(Servicio::class);
    }
}
