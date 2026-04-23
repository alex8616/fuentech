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

    public function comsumos(){
        return $this->hasMany(Consumo::class);
    }

    public function movimientos(){
        return $this->hasMany(Movimiento::class);
    }

    public function cajas(){
        return $this->hasMany(Caja::class);
    }
}
