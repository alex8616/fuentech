<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaCorrienteProveedor extends Model
{
    use HasFactory;
    protected $fillable = [
        'Tipo',
        'Monto',
        'MedioDePago',
        'Comentario',
        'Eliminado',
        'Arqueo',
        'proveedor_id'
    ];

    public function proveedor(){
        return $this->belongsTo(Proveedore::class, 'proveedor_id');
    }
}
