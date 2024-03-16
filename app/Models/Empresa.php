<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $fillable = [
        'NombreEmpresa',
        'LogoEmpresa',
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

    public function proveedores(){
        return $this->belongsTo(Proveedore::class);
    }

    public function categorias(){
        return $this->belongsTo(Categoria::class);
    }

    public function ambientemesas(){
        return $this->hasMany(AmbienteMesa::class);
    }

    public function configuracions(){
        return $this->hasMany(Configuracion::class);
    }

    public function comsumos(){
        return $this->hasMany(Consumo::class);
    }
}
