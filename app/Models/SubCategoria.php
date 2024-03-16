<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model
{
    use HasFactory;
    protected $fillable = [
        'Nombre_subcategoria',
        'Estado',
        'AppComensal',
        'MenuOnline',
        'CartaQR',
        'cocina_id',
        'categoria_id'
    ];

    //Relacion de uno a muchos inversa
    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function cocina(){
        return $this->belongsTo(Cocina::class);
    }
}

