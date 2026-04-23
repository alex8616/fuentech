<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;
    protected $fillable = [
        'NombreImpresora',
        'user_id',
        'DireccionIpLocal',
        'Activo'
    ];

    public function users(){
        return $this->hasMany(User::class, 'user_id');
    }
    
}
