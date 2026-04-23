<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;
    protected $fillable = [
        'empresa_id',
        'user_id',
        'monto',
        'tipo',
        'mediopago',
        'Comentario',
        'fecharegistro',
        'FechaCierre',
        'eliminado'
    ];

    public function empresa(){
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}
