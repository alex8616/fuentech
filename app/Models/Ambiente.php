<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    use HasFactory;
    protected $fillable = [
        'NombreAmbiente',
        'DescripcionAmbiente',
        'empresa_id'
    ];

    public function empresas(){
        return $this->hasMany(Empresa::class, 'empresa_id');
    }

    public function ambientemesas(){
        return $this->hasMany(AmbienteMesa::class);
    }
}
