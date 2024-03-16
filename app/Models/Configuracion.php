<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;
    protected $fillable = [
        'NombreImpresora',
        'empresa_id'
    ];

    public function empresas(){
        return $this->hasMany(Empresa::class, 'empresa_id');
    }
    
}
