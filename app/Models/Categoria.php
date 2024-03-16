<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = [
        'Nombre_categoria',
        'Estado',
        'AppComensal',
        'MenuOnline',
        'CartaQR',
        'cocina_id',
        'empresa_id',
    ];

    //Relacion de uno a muchos
    public function productos(){
        return $this->hasMany(Producto::class);
    }

    //Relacion de uno a muchos
    public function subcategorias(){
        return $this->hasMany(SubCategoria::class);
    }

    public function empresas(){
        return $this->hasMany(Empresa::class, 'empresa_id');
    }

    public function cocina(){
        return $this->belongsTo(Cocina::class);
    }
}
