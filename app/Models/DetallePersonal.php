<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetallePersonal extends Model
{
    use HasFactory;
    protected $fillable = [
                            'estado',
                            'HoraExtra',
                            'fecha_ingreso',
                            'hora_ingreso',
                            'fecha_salida',
                            'hora_salida',
                            'RazonHoraExtra',
                            'persona_id'
                        ];

    //Relacion de uno a muchos inversa
    public function personal(){
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }
}
