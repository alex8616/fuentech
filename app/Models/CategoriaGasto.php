<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaGasto extends Model
{
    use HasFactory;
    protected $fillable = [
        'Nombre_categoria',
        'Estado'
    ];

    //Relacion de uno a muchos
    public function gastos(){
        return $this->hasMany(Gasto::class);
    }

}
