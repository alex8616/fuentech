<?php

// app/Models/Envio.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    protected $fillable = ['estado', 'chofer', 'donde', 'fecha_envio'];

    public function items()
    {
        return $this->hasMany(ItemEnvio::class);
    }
}
