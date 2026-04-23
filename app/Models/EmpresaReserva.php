<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpresaReserva extends Model
{
    use HasFactory;
    protected $fillable = [
        'NombreEmpresa'
    ];

    //Relacion de uno a muchos
    public function reservasalon(){
        return $this->hasMany(ReservaSalones::class);
    } 
}
