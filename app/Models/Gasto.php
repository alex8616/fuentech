<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;
    protected $fillable = [
        'FechaRegistro',
        'Importe',
        'MedioDePago',
        'TipoConprobante',
        'NumeroComprobante',
        'UsarArqueo',
        'Comentario',
        'proveedor_id',
        'categoria_gasto_id',
        'user_id',
    ];

    public function categoriagasto(){
        return $this->belongsTo(CategoriaGasto::class, 'categoria_gasto_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function proveedor(){
        return $this->belongsTo(Proveedore::class, 'proveedor_id');
    }

    public function detallegasto(){
        return $this->hasMany(DetalleGasto::class);
    }
}
