<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;
    protected $fillable = ['Nombre_Completo',
                            'Dni',
                            'Cargo',
                            'Pin',
                            'imagen',
                            'descriptores',
                            'estado',
                            'Tiempo',
                        ];

    //Relacion de uno a muchos
    public function detallepersonals(){
        return $this->hasMany(DetallePersonal::class);
    }
}
