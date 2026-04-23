<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'totalnuevo',
        'totaldaniado',
        'totaldesechado',
        'totalperdido',
        'totalgeneral',
        'totalingreso',
        'totalsalida',
        'recursos_id',
    ];

    // Relación de uno a muchos
    public function recursos(){
        return $this->hasMany(Recurso::class, 'recursos_id');
    }

    // Relación con DetalleInventario
    public function detalleinventarios(){
        return $this->hasMany(DetalleInventario::class, 'inventarios_id');
    }
}

