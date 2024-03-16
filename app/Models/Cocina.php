<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cocina extends Model
{
    use HasFactory;
    protected $fillable = [
        'Nombre_Cocina',
        'empresa_id',
    ];

    public function categorias(){
        return $this->hasMany(Categoria::class);
    }
    public function aubcategorias(){
        return $this->hasMany(SubCategoria::class);
    }
}
