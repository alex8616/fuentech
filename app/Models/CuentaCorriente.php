<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaCorriente extends Model
{
    use HasFactory;
    protected $fillable = [
        'Tipo',
        'Monto',
        'MedioDePago',
        'Comentario',
        'Eliminado',
        'cliente_id'
    ];

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
}
