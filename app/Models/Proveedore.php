<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedore extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'documento',
        'empresa_id'
    ];

    //Relacion de uno a muchos
    public function empresas(){
        return $this->hasMany(Empresa::class);
    }

    //Relacion de uno a muchos
    public function productos(){
        return $this->hasMany(Producto::class);
    }
}
