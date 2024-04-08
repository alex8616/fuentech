<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modificadore extends Model
{
    use HasFactory;
    protected $fillable = [
        'NombreModificador',
        'NombrePublicoModificador',
        'LogicaPrecioModificador',
        'CantidadMinimaModificador',
        'CantidadMaximaModificador',
    ];

    public function detallemodificador(){
        return $this->hasMany(DetalleModificadore::class);
    }
    
    public function producto(){
        return $this->hasMany(producto::class);
    }
}