<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleCaja extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'caja_id',
        'codigo_caja_id',
        'articulo_caja_id',
        'Articulo_description',
        'Ingreso',
        'Egreso',
        'Fecha_registro',
        'Factura',
        'NFactura',
        'Deuda',
        'Sumatoria',
        'ServicioPrestado',
        'Eliminado',
        'ComentarioEliminado',
        'TipoServicioPrestado'
    ];

    //Relacion de uno a muchos inversa
    public function user(){
        return $this->belongsTo(User::class);
    }

    //Relacion de uno a muchos inversa
    public function caja(){
        return $this->belongsTo(Caja::class);
    }

    //Relacion de uno a muchos inversa
    public function codigocaja(){
        return $this->belongsTo(CodigoCaja::class, "codigo_caja_id");
    }

    //Relacion de uno a muchos inversa
    public function articulocaja(){
        return $this->belongsTo(ArticuloCaja::class, "articulo_caja_id");
    }
}
